<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Carbon\Carbon;

class AnnonceController extends Controller
{
    public function __construct()
    {
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment', 'sandbox'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        if (Auth::user()->role_id != 2) {
            abort(403, 'Accès réservé aux étudiants');
        }

        $user = Auth::user();
        return view('annonces.create', compact('user'));
    }

    // Enregistrer l'annonce
    public function store(Request $request)
    {
        if (Auth::user()->role_id != 2) {
            abort(403, 'Accès réservé aux étudiants');
        }

        $request->validate([
            'domaine' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'budget' => 'required|numeric|min:1000|max:1000000000',
            'disponibilite' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (empty(trim($value))) {
                        $fail('Veuillez ajouter au moins un créneau de disponibilité.');
                        return;
                    }

                    $lines = explode("\n", trim($value));
                    $validFormat = true;
                    $errors = [];

                    foreach ($lines as $index => $line) {
                        $line = trim($line);
                        if (!empty($line)) {
                            // Vérifier le format: jour HH:MM - HH:MM
                            if (!preg_match('/^([a-zA-Zéèêëàâäîïôöùûüç\s]+) (\d{2}:\d{2}) - (\d{2}:\d{2})$/', $line, $matches)) {
                                $validFormat = false;
                                $errors[] = "Ligne " . ($index + 1) . ": Format incorrect. Utilisez: 'jour HH:MM - HH:MM'";
                                continue;
                            }

                            $jour = trim($matches[1]);
                            $startTime = $matches[2];
                            $endTime = $matches[3];

                            // Vérifier les heures
                            if (!preg_match('/^(\d{2}):(\d{2})$/', $startTime, $timeStart) ||
                                !preg_match('/^(\d{2}):(\d{2})$/', $endTime, $timeEnd)) {
                                $validFormat = false;
                                $errors[] = "Ligne " . ($index + 1) . ": Format d'heure incorrect";
                                continue;
                            }

                            $startHour = (int)$timeStart[1];
                            $startMinute = (int)$timeStart[2];
                            $endHour = (int)$timeEnd[1];
                            $endMinute = (int)$timeEnd[2];

                            if ($startHour < 0 || $startHour > 23 || $endHour < 0 || $endHour > 23 ||
                                $startMinute < 0 || $startMinute > 59 || $endMinute < 0 || $endMinute > 59) {
                                $validFormat = false;
                                $errors[] = "Ligne " . ($index + 1) . ": Heures invalides";
                                continue;
                            }

                            // Vérifier que l'heure de fin est après l'heure de début
                            $startTotal = $startHour * 60 + $startMinute;
                            $endTotal = $endHour * 60 + $endMinute;

                            if ($endTotal <= $startTotal) {
                                $validFormat = false;
                                $errors[] = "Ligne " . ($index + 1) . ": L'heure de fin doit être après l'heure de début";
                            }
                        }
                    }

                    if (!$validFormat) {
                        $fail('Erreurs dans les disponibilités: ' . implode(', ', $errors));
                    }
                }
            ],
            'format' => 'required|in:presentiel,en_ligne,hybrid'
        ]);

        $annonce = new Annonce();
        $annonce->student_id = Auth::id();
        $annonce->domaine = $request->domaine;
        $annonce->description = $request->description;
        $annonce->budget = (float) $request->budget;
        $annonce->disponibilite = trim($request->disponibilite);
        $annonce->format = $request->format;

        // Calcul acompte
        $percentage = rand(20, 30) / 100;
        $annonce->acompte = round($annonce->budget * $percentage, 2);

        // Statut initial
        $annonce->status = 'en_attente';
        $annonce->is_paid = false;

        $annonce->save();

        return redirect()->route('annonces.payment', $annonce->id)
            ->with('success', 'Annonce créée. Veuillez payer l\'acompte pour la publier.');
    }

    // Afficher la page de paiement
    public function payment($id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();

        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        if ($annonce->is_paid) {
            return redirect()->route('annonces.show', $annonce->id)
                ->with('info', 'Cette annonce est déjà payée.');
        }

        return view('annonces.payment', compact('annonce', 'user'));
    }

    // Callback de paiement - CORRIGÉ
    public function handlePayment(Request $request)
    {
        $user = Auth::user();
        $transactionId = $request->input('id');
        $annonceId = $request->input('annonce_id');

        if (!$transactionId || !$annonceId) {
            return redirect()->back()->with('error', 'Transaction invalide.');
        }

        try {
            // Récupérer la transaction FedaPay
            $transaction = Transaction::retrieve($transactionId);

            // Vérifier le statut
            if ($transaction->status !== 'approved') {
                return redirect()->route('annonces.payment', $annonceId)
                    ->with('error', 'Le paiement n\'est pas encore confirmé.');
            }

            // Éviter les doublons
            $existingPayment = Payment::where('fedapay_transaction_id', $transaction->id)->first();
            if ($existingPayment) {
                return redirect()->route('annonces.show', $annonceId)
                    ->with('info', 'Ce paiement a déjà été traité.');
            }

            // Récupérer l'annonce
            $annonce = Annonce::findOrFail($annonceId);

            // Vérifier que l'utilisateur est propriétaire de l'annonce
            if ($annonce->student_id != $user->id) {
                abort(403, 'Accès non autorisé');
            }

            // IMPORTANT: FedaPay retourne le montant en FCFA (entier)
            $amountPaid = (float) $transaction->amount; // Conversion en float pour notre DB

            // Créer le paiement
            Payment::create([
                'annonce_id' => $annonce->id,
                'user_id' => $user->id,
                'fedapay_transaction_id' => $transaction->id,
                'amount' => $amountPaid,
                'currency' => 'XOF',
                'status' => $transaction->status,
                'payment_method' => $transaction->mode ?? 'mobile_money',
                'payment_details' => json_encode($transaction->toArray()),
                'paid_at' => Carbon::now(),
            ]);

            // Mettre à jour l'annonce
            $annonce->update([
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => Carbon::now()
            ]);

            return redirect()->route('annonces.show', $annonce->id)
                ->with('success', 'Paiement effectué avec succès ! Votre annonce est maintenant publiée.');

        } catch (\FedaPay\Error\ApiConnection $e) {
            Log::error('Erreur connexion FedaPay: ' . $e->getMessage());
            return redirect()->route('annonces.payment', $annonceId)
                ->with('error', 'Impossible de vérifier le paiement.');
        } catch (\FedaPay\Error\InvalidRequest $e) {
            Log::error('Erreur requête FedaPay: ' . $e->getMessage());
            return redirect()->route('annonces.payment', $annonceId)
                ->with('error', 'Erreur lors de la vérification du paiement.');
        } catch (\Exception $e) {
            Log::error('Erreur paiement annonce: ' . $e->getMessage());
            return redirect()->route('annonces.payment', $annonceId)
                ->with('error', 'Une erreur est survenue lors du traitement du paiement.');
        }
    }

    // Afficher les annonces de l'étudiant
    public function index()
    {
        if (Auth::user()->role_id != 2) {
            abort(403, 'Accès réservé aux étudiants');
        }

        $user = Auth::user();
        $annonces = Annonce::where('student_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('annonces.index', compact('annonces', 'user'));
    }

    // Afficher une annonce spécifique
    public function show($id)
    {
        $annonce = Annonce::with(['student', 'payments'])->findOrFail($id);
        $user = Auth::user();

        if ($annonce->student_id != Auth::id() && Auth::user()->role_id != 1) {
            abort(403, 'Accès non autorisé');
        }

        return view('annonces.show', compact('annonce', 'user'));
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();

        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        if ($annonce->status != 'en_attente') {
            return redirect()->route('annonces.show', $annonce->id)
                ->with('error', 'Cette annonce ne peut plus être modifiée.');
        }

        return view('annonces.edit', compact('annonce', 'user'));
    }

    // Mettre à jour l'annonce
    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);

        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        if ($annonce->status != 'en_attente') {
            return redirect()->route('annonces.show', $annonce->id)
                ->with('error', 'Cette annonce ne peut plus être modifiée.');
        }

        $request->validate([
            'domaine' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'budget' => 'required|numeric|min:1000',
            'disponibilite' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (empty(trim($value))) {
                        $fail('Veuillez ajouter au moins un créneau de disponibilité.');
                        return;
                    }

                    $lines = explode("\n", trim($value));
                    $validFormat = true;
                    $errors = [];

                    foreach ($lines as $index => $line) {
                        $line = trim($line);
                        if (!empty($line)) {
                            if (!preg_match('/^([a-zA-Zéèêëàâäîïôöùûüç\s]+) (\d{2}:\d{2}) - (\d{2}:\d{2})$/', $line, $matches)) {
                                $validFormat = false;
                                $errors[] = "Ligne " . ($index + 1) . ": Format incorrect";
                                continue;
                            }

                            $startTime = $matches[2];
                            $endTime = $matches[3];

                            if (preg_match('/^(\d{2}):(\d{2})$/', $startTime, $timeStart) &&
                                preg_match('/^(\d{2}):(\d{2})$/', $endTime, $timeEnd)) {
                                $startHour = (int)$timeStart[1];
                                $startMinute = (int)$timeStart[2];
                                $endHour = (int)$timeEnd[1];
                                $endMinute = (int)$timeEnd[2];

                                if ($startHour < 0 || $startHour > 23 || $endHour < 0 || $endHour > 23 ||
                                    $startMinute < 0 || $startMinute > 59 || $endMinute < 0 || $endMinute > 59) {
                                    $validFormat = false;
                                    $errors[] = "Ligne " . ($index + 1) . ": Heures invalides";
                                    continue;
                                }

                                $startTotal = $startHour * 60 + $startMinute;
                                $endTotal = $endHour * 60 + $endMinute;

                                if ($endTotal <= $startTotal) {
                                    $validFormat = false;
                                    $errors[] = "Ligne " . ($index + 1) . ": L'heure de fin doit être après l'heure de début";
                                }
                            }
                        }
                    }

                    if (!$validFormat) {
                        $fail('Erreurs dans les disponibilités: ' . implode(', ', $errors));
                    }
                }
            ],
            'format' => 'required|in:presentiel,en_ligne,hybrid'
        ]);

        $annonce->domaine = $request->domaine;
        $annonce->description = $request->description;
        $annonce->budget = $request->budget;
        $annonce->disponibilite = trim($request->disponibilite);
        $annonce->format = $request->format;

        // Recalculer l'acompte si le budget a changé
        if ($annonce->isDirty('budget')) {
            $percentage = rand(20, 30) / 100;
            $annonce->acompte = $request->budget * $percentage;
        }

        $annonce->save();

        return redirect()->route('annonces.show', $annonce->id)
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    // Supprimer une annonce
    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);

        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        if ($annonce->status === 'attribuee') {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer une annonce déjà attribuée.');
        }

        $annonce->delete();

        return redirect()->route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}
