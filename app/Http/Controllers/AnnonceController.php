<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use FedaPay\Customer;
use Exception;

class AnnonceController extends Controller
{
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
            'budget' => 'required|numeric|min:1000',
            'disponibilite' => 'required|date|after:now',
            'format' => 'required|in:presentiel,en_ligne,hybrid'
        ]);

        $annonce = new Annonce();
        $annonce->student_id = Auth::id();
        $annonce->domaine = $request->domaine;
        $annonce->description = $request->description;
        $annonce->budget = $request->budget;
        $annonce->disponibilite = $request->disponibilite;
        $annonce->format = $request->format;
        
        // Calculer l'acompte (20-30%)
        $percentage = rand(20, 30) / 100;
        $annonce->acompte = $request->budget * $percentage;
        
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

        // Vérifier si un paiement est déjà en cours
        $pendingPayment = Payment::where('annonce_id', $annonce->id)
            ->where('status', 'pending')
            ->first();

        return view('annonces.payment', compact('annonce', 'user', 'pendingPayment'));
    }

    // Initialiser le paiement avec FedaPay
    public function initPayment(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();
        
        if ($annonce->student_id != Auth::id()) {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        // Vérifier si l'annonce est déjà payée
        if ($annonce->is_paid) {
            return response()->json(['error' => 'Cette annonce est déjà payée'], 400);
        }

        try {
            // Configuration FedaPay
            FedaPay::setApiKey(config('services.fedapay.secret_key'));
            FedaPay::setEnvironment(config('services.fedapay.mode', 'live'));
            
            // IMPORTANT: Pour le développement local, FedaPay LIVE ne peut pas accéder à localhost
            // Solution 1: Utiliser une URL de test en ligne
            // Solution 2: Utiliser ngrok pour exposer votre localhost
            
            // URL de callback (CRITIQUE)
            $callbackUrl = route('annonces.payment.callback', $annonce->id);
            
            // Si vous êtes en local, VOUS DEVEZ utiliser ngrok ou un service similaire
            if (app()->environment('local')) {
                // TÉLÉCHARGEZ NGROK: https://ngrok.com/
                // Lancez: ngrok http 8000
                // Utilisez l'URL HTTPS fournie par ngrok
                // Exemple: $callbackUrl = "https://abcd-123-456-789.ngrok-free.app/annonces/{$annonce->id}/payment/callback";
                
                // Pour tester sans ngrok, utilisez une URL de test en ligne:
                $callbackUrl = "https://webhook.site/your-unique-url"; // Créez un webhook sur webhook.site
                
                Log::warning('MODE LOCAL: Pensez à configurer ngrok pour recevoir les callbacks réels');
            }
            
            Log::info('Création transaction FedaPay', [
                'annonce_id' => $annonce->id,
                'amount' => $annonce->acompte,
                'callback_url' => $callbackUrl,
                'mode' => 'live'
            ]);
            
            // Créer le client dans FedaPay
            $customer = Customer::create([
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'phone_number' => [
                    'number' => $user->telephone ? preg_replace('/[^0-9]/', '', $user->telephone) : '22900000000',
                    'country' => 'bj'
                ]
            ]);
            
            // Créer la transaction FedaPay
            $transaction = Transaction::create([
                'description' => 'Acompte pour annonce: ' . $annonce->domaine,
                'amount' => $annonce->acompte,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => $callbackUrl,
                'customer' => $customer,
                'mode' => $request->input('payment_method', 'mtn'), // mtn, moov, card
                'metadata' => [
                    'annonce_id' => $annonce->id,
                    'user_id' => $user->id,
                    'type' => 'acompte_annonce'
                ]
            ]);
            
            // Générer le token de paiement
            $token = $transaction->generateToken();
            
            // Créer l'enregistrement de paiement dans notre base
            $payment = Payment::create([
                'annonce_id' => $annonce->id,
                'user_id' => $user->id,
                'fedapay_transaction_id' => $transaction->id,
                'amount' => $annonce->acompte,
                'currency' => 'XOF',
                'status' => 'pending',
                'payment_method' => $request->input('payment_method', 'mobile_money'),
                'payment_details' => [
                    'reference' => $transaction->reference,
                    'payment_url' => $token->url,
                    'customer_id' => $customer->id,
                    'callback_url' => $callbackUrl
                ]
            ]);
            
            // Mettre à jour l'annonce
            $annonce->update([
                'status' => 'en_paiement',
                'payment_reference' => $transaction->reference
            ]);
            
            Log::info('Transaction FedaPay créée avec succès', [
                'transaction_id' => $transaction->id,
                'reference' => $transaction->reference,
                'payment_url' => $token->url
            ]);
            
            return response()->json([
                'success' => true,
                'payment_url' => $token->url,
                'payment_id' => $payment->id,
                'transaction_id' => $transaction->id,
                'transaction_reference' => $transaction->reference
            ]);

        } catch (Exception $e) {
            Log::error('Erreur FedaPay: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'annonce_id' => $annonce->id,
                'user_id' => $user->id
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de l\'initialisation du paiement. Veuillez réessayer.',
                'debug' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Callback de FedaPay
    public function paymentCallback(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        
        Log::info('Callback FedaPay reçu', [
            'annonce_id' => $id,
            'query_params' => $request->query(),
            'post_data' => $request->post()
        ]);
        
        // Récupérer le paiement en attente
        $payment = Payment::where('annonce_id', $annonce->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$payment) {
            Log::warning('Aucun paiement en attente pour annonce', ['annonce_id' => $id]);
            return redirect()->route('annonces.payment', $annonce->id)
                ->with('error', 'Aucun paiement en attente trouvé.');
        }

        try {
            // Configuration FedaPay pour vérifier
            FedaPay::setApiKey(config('services.fedapay.secret_key'));
            FedaPay::setEnvironment(config('services.fedapay.mode', 'live'));
            
            // Récupérer la transaction FedaPay
            $transaction = Transaction::retrieve($payment->fedapay_transaction_id);
            
            Log::info('Vérification transaction FedaPay', [
                'transaction_id' => $transaction->id,
                'status' => $transaction->status,
                'reference' => $transaction->reference,
                'approved_at' => $transaction->approved_at
            ]);
            
            if ($transaction->status === 'approved') {
                // Paiement réussi
                $payment->update([
                    'status' => 'completed',
                    'payment_method' => $transaction->mode ?? 'mobile_money',
                    'paid_at' => $transaction->approved_at ?? now(),
                    'payment_details' => array_merge(
                        $payment->payment_details ?? [],
                        [
                            'callback_data' => $request->all(),
                            'transaction_status' => $transaction->status,
                            'approved_at' => $transaction->approved_at,
                            'mode' => $transaction->mode
                        ]
                    )
                ]);

                // Mettre à jour l'annonce
                $annonce->markAsPublished();
                
                Log::info('Paiement réussi', [
                    'annonce_id' => $annonce->id,
                    'payment_id' => $payment->id,
                    'transaction_id' => $transaction->id
                ]);

                return redirect()->route('annonces.show', $annonce->id)
                    ->with('success', 'Paiement effectué avec succès ! Votre annonce est maintenant publiée.');

            } else {
                // Paiement échoué ou annulé
                $statusMessage = match($transaction->status) {
                    'canceled' => 'Le paiement a été annulé.',
                    'declined' => 'Le paiement a été refusé.',
                    default => 'Le paiement a échoué.'
                };
                
                $payment->update([
                    'status' => 'failed',
                    'payment_details' => array_merge(
                        $payment->payment_details ?? [],
                        [
                            'callback_data' => $request->all(),
                            'transaction_status' => $transaction->status,
                            'failed_at' => now()
                        ]
                    )
                ]);

                $annonce->update(['status' => 'en_attente']);
                
                Log::warning('Paiement échoué', [
                    'annonce_id' => $annonce->id,
                    'transaction_status' => $transaction->status,
                    'payment_id' => $payment->id
                ]);

                return redirect()->route('annonces.payment', $annonce->id)
                    ->with('error', $statusMessage . ' Veuillez réessayer.');
            }

        } catch (Exception $e) {
            Log::error('Erreur vérification transaction FedaPay: ' . $e->getMessage(), [
                'annonce_id' => $annonce->id,
                'payment_id' => $payment->id ?? 'N/A',
                'error' => $e->getMessage()
            ]);

            return redirect()->route('annonces.payment', $annonce->id)
                ->with('error', 'Erreur lors de la vérification du paiement. Veuillez contacter le support.');
        }
    }

    // Vérifier manuellement le statut du paiement
    public function checkPaymentStatus($id)
    {
        $annonce = Annonce::findOrFail($id);
        
        if ($annonce->student_id != Auth::id()) {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        $payment = Payment::where('annonce_id', $annonce->id)
            ->latest()
            ->first();

        if (!$payment) {
            return response()->json(['status' => 'no_payment'], 404);
        }

        if ($payment->status === 'completed') {
            return response()->json([
                'status' => 'completed',
                'annonce' => $annonce
            ]);
        }

        // Vérifier avec FedaPay si le paiement est en attente
        if ($payment->status === 'pending') {
            try {
                FedaPay::setApiKey(config('services.fedapay.secret_key'));
                FedaPay::setEnvironment(config('services.fedapay.mode', 'live'));
                
                $transaction = Transaction::retrieve($payment->fedapay_transaction_id);
                
                if ($transaction->status === 'approved') {
                    // Mettre à jour le paiement
                    $payment->update([
                        'status' => 'completed',
                        'payment_method' => $transaction->mode ?? 'mobile_money',
                        'paid_at' => $transaction->approved_at ?? now()
                    ]);

                    // Mettre à jour l'annonce
                    $annonce->markAsPublished();

                    return response()->json([
                        'status' => 'completed',
                        'annonce' => $annonce
                    ]);
                } elseif (in_array($transaction->status, ['canceled', 'declined'])) {
                    $payment->update(['status' => 'failed']);
                    $annonce->update(['status' => 'en_attente']);
                    
                    return response()->json([
                        'status' => 'failed',
                        'transaction_status' => $transaction->status
                    ]);
                }
            } catch (Exception $e) {
                Log::error('Erreur vérification statut: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status' => $payment->status,
            'payment' => $payment
        ]);
    }

    // Afficher les annonces de l'étudiant
    public function index()
    {
        if (Auth::user()->role_id != 2) {
            abort(403, 'Accès réservé aux étudiants');
        }

        $user = Auth::user();
        $annonces = Annonce::where('student_id', Auth::id())
            ->with('latestPayment')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('annonces.index', compact('annonces', 'user'));
    }

    // Afficher une annonce spécifique
    public function show($id)
    {
        $annonce = Annonce::with(['student', 'payments'])->findOrFail($id);
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a le droit de voir l'annonce
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
        
        // Vérifier que l'utilisateur a le droit de modifier l'annonce
        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier que l'annonce peut être modifiée
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
        
        // Vérifier que l'utilisateur a le droit de modifier l'annonce
        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier que l'annonce peut être modifiée
        if ($annonce->status != 'en_attente') {
            return redirect()->route('annonces.show', $annonce->id)
                ->with('error', 'Cette annonce ne peut plus être modifiée.');
        }

        $request->validate([
            'domaine' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'budget' => 'required|numeric|min:1000',
            'disponibilite' => 'required|date|after:now',
            'format' => 'required|in:presentiel,en_ligne,hybrid'
        ]);

        // Sauvegarder les anciennes valeurs pour le log
        $oldBudget = $annonce->budget;
        $oldDeposit = $annonce->acompte;

        // Mettre à jour l'annonce
        $annonce->domaine = $request->domaine;
        $annonce->description = $request->description;
        $annonce->budget = $request->budget;
        $annonce->disponibilite = $request->disponibilite;
        $annonce->format = $request->format;
        
        // Recalculer l'acompte si le budget a changé
        if ($oldBudget != $request->budget) {
            $percentage = rand(20, 30) / 100;
            $annonce->acompte = $request->budget * $percentage;
            
            Log::info('Budget modifié - recalcul acompte', [
                'annonce_id' => $annonce->id,
                'old_budget' => $oldBudget,
                'new_budget' => $request->budget,
                'old_deposit' => $oldDeposit,
                'new_deposit' => $annonce->acompte
            ]);
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

        // Vérifier si l'annonce n'a pas encore été attribuée
        if ($annonce->status === 'attribuee') {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer une annonce déjà attribuée.');
        }

        $annonce->delete();

        return redirect()->route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }

    // Webhook FedaPay (pour les notifications serveur à serveur)
    public function webhook(Request $request)
    {
        $payload = $request->all();
        
        Log::info('Webhook FedaPay reçu:', $payload);

        // Vérifier la signature du webhook (important pour la sécurité)
        // $signature = $request->header('X-FEDAPAY-SIGNATURE');
        // $endpointSecret = 'votre_secret_webhook'; // À définir dans votre dashboard FedaPay
        
        // if (!$this->verifyWebhookSignature($payload, $signature, $endpointSecret)) {
        //     Log::warning('Signature webhook invalide');
        //     return response()->json(['error' => 'Signature invalide'], 400);
        // }

        // Traiter l'événement
        if (isset($payload['event']) && $payload['event'] === 'transaction.approved') {
            $transactionId = $payload['data']['id'] ?? null;
            
            if ($transactionId) {
                // Trouver le paiement correspondant
                $payment = Payment::where('fedapay_transaction_id', $transactionId)->first();
                
                if ($payment && $payment->status === 'pending') {
                    // Mettre à jour le paiement
                    $payment->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                        'payment_details' => array_merge(
                            $payment->payment_details ?? [],
                            ['webhook_data' => $payload]
                        )
                    ]);

                    // Mettre à jour l'annonce
                    $annonce = $payment->annonce;
                    $annonce->markAsPublished();

                    Log::info('Paiement mis à jour via webhook:', ['payment_id' => $payment->id]);
                }
            }
        }

        return response()->json(['success' => true]);
    }

    // Méthode pour vérifier la signature du webhook (optionnel mais recommandé)
    private function verifyWebhookSignature($payload, $signature, $secret)
    {
        // Implémentez la vérification de signature selon la documentation FedaPay
        // https://docs.fedapay.com/webhooks#verifying-signatures
        return true; // À implémenter pour la production
    }
}