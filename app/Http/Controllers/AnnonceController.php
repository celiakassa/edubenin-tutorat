<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Payment;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Moneroo\Laravel\Payment as MonerooPayment;

class AnnonceController extends Controller
{
    public function __construct()
    {
        // FedaPay configuration
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment', 'sandbox'));
    }

    // Méthode pour récupérer les matières
    private function getSubjects()
    {
        return Subject::where('is_active', true)
            ->orderBy('nom')
            ->get();
    }

    // Afficher le formulaire de création
    public function create()
    {
        abort_if(Auth::user()->role_id != 2, 403, 'Accès réservé aux étudiants');

        $user = Auth::user();
        $subjects = $this->getSubjects();

        return view('annonces.create', [
            'user' => $user,
            'subjects' => $subjects
        ]);
    }

    // Enregistrer l'annonce
    public function store(Request $request)
    {
        abort_if(Auth::user()->role_id != 2, 403, 'Accès réservé aux étudiants');

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
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
                            if (!preg_match('/^([a-zA-Zéèêëàâäîïôöùûüç\s]+) (\d{2}:\d{2}) - (\d{2}:\d{2})$/', $line, $matches)) {
                                $validFormat = false;
                                $errors[] = "Ligne " . ($index + 1) . ": Format incorrect. Utilisez: 'jour HH:MM - HH:MM'";
                                continue;
                            }

                            $jour = trim($matches[1]);
                            $startTime = $matches[2];
                            $endTime = $matches[3];

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
        $annonce->subject_id = $request->subject_id;
        $annonce->description = $request->description;
        $annonce->budget = (float) $request->budget;
        $annonce->disponibilite = $request->disponibilite;
        $annonce->format = $request->format;

        // Calcul acompte FIXE à 30%
        $annonce->acompte = round($annonce->budget * 0.3, 2);

        // Statut initial
        $annonce->status = 'en_attente';
        $annonce->is_paid = false;

        $annonce->save();

        return to_route('annonces.payment', $annonce->id)
            ->with('success', 'Annonce créée. Veuillez payer l\'acompte pour la publier.');
    }

    // Afficher la page de paiement
    public function payment($id)
    {
        $annonce = Annonce::with('subject')->findOrFail($id);
        $user = Auth::user();

        abort_if($annonce->student_id != Auth::id(), 403, 'Accès non autorisé');

        if ($annonce->is_paid) {
            return to_route('annonces.show', $annonce->id)
                ->with('info', 'Cette annonce est déjà payée.');
        }

        return view('annonces.payment', ['annonce' => $annonce, 'user' => $user]);
    }

    // ==================== MÉTHODES FEDAPAY ====================

    // Initialiser le paiement FedaPay
    public function initPayment(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();

        if ($annonce->student_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Accès non autorisé'], 403);
        }

        if ($annonce->is_paid) {
            return response()->json(['success' => false, 'message' => 'Cette annonce est déjà payée'], 400);
        }

        try {
            // Créer la transaction FedaPay
            $transaction = Transaction::create([
                'description' => 'Acompte pour annonce: ' . ($annonce->subject->nom ?? 'Formation'),
                'amount' => (int) $annonce->acompte,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('annonces.payment.callback'),
                'customer' => [
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'phone_number' => [
                        'number' => $user->telephone ?? '00000000',
                        'country' => 'bj'
                    ]
                ]
            ]);

            // Générer le token de paiement
            $token = $transaction->generateToken();

            Log::info('Paiement FedaPay initialisé', [
                'transaction_id' => $transaction->id,
                'token' => $token->token,
                'annonce_id' => $annonce->id,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'token' => $token->token,
                'transaction_id' => $transaction->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur init paiement FedaPay: ' . $e->getMessage(), [
                'annonce_id' => $annonce->id,
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Callback de paiement FedaPay
    public function handlePayment(Request $request)
    {
        $user = Auth::user();
        $transactionId = $request->input('id');
        $annonceId = $request->input('annonce_id');

        Log::info('Callback FedaPay reçu', [
            'transaction_id' => $transactionId,
            'annonce_id' => $annonceId,
            'user_id' => $user->id ?? null
        ]);

        if (!$transactionId || !$annonceId) {
            return back()->with('error', 'Transaction invalide.');
        }

        try {
            // Récupérer la transaction FedaPay
            $transaction = Transaction::retrieve($transactionId);

            // Vérifier le statut
            if ($transaction->status !== 'approved') {
                return to_route('annonces.payment', $annonceId)
                    ->with('error', 'Le paiement n\'est pas encore confirmé.');
            }

            // Éviter les doublons
            $existingPayment = Payment::where('fedapay_transaction_id', $transaction->id)->first();
            if ($existingPayment) {
                return to_route('annonces.show', $annonceId)
                    ->with('info', 'Ce paiement a déjà été traité.');
            }

            // Récupérer l'annonce
            $annonce = Annonce::findOrFail($annonceId);

            // Vérifier que l'utilisateur est propriétaire de l'annonce
            abort_if($annonce->student_id != $user->id, 403, 'Accès non autorisé');

            DB::beginTransaction();

            // Créer le paiement
            Payment::create([
                'annonce_id' => $annonce->id,
                'user_id' => $user->id,
                'fedapay_transaction_id' => $transaction->id,
                'amount' => (float) $transaction->amount,
                'currency' => 'XOF',
                'status' => $transaction->status,
                'payment_method' => $transaction->mode ?? 'mobile_money',
                'payment_details' => json_encode($transaction->toArray()),
                'paid_at' => \Illuminate\Support\Facades\Date::now(),
            ]);

            // Mettre à jour l'annonce
            $annonce->update([
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => \Illuminate\Support\Facades\Date::now()
            ]);

            DB::commit();

            return redirect()->route('annonces.show', $annonce->id)
                ->with('success', 'Paiement effectué avec succès ! Votre annonce est maintenant publiée.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur paiement FedaPay: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'annonce_id' => $annonceId,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('annonces.payment', $annonceId)
                ->with('error', 'Une erreur est survenue lors du traitement du paiement.');
        }
    }

    // Webhook FedaPay
    public function webhook(Request $request)
    {
        Log::info('Webhook FedaPay reçu', $request->all());

        try {
            $payload = $request->all();
            $transactionId = $payload['data']['id'] ?? null;
            $status = $payload['data']['status'] ?? null;

            if (!$transactionId || $status !== 'approved') {
                return response()->json(['status' => 'ignored']);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Erreur webhook FedaPay: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    // ==================== MÉTHODES MONEROO ====================

    // Initialiser le paiement Moneroo
    public function initPaymentMoneroo(Request $request, $id)
    {
        Log::info('Moneroo config check', [
            'secret_key_from_env' => env('MONEROO_SECRET_KEY'),
            'secret_key_from_config' => config('services.moneroo.secret_key'),
            'config_array' => config('services.moneroo'),
        ]);

        if (!config('services.moneroo.secret_key')) {
            throw new \Exception('Config Moneroo: ' . json_encode(config('services.moneroo')));
        }

        $annonce = Annonce::with('subject')->findOrFail($id);
        $user = Auth::user();

        if ($annonce->student_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Accès non autorisé'], 403);
        }

        if ($annonce->is_paid) {
            return response()->json(['success' => false, 'message' => 'Cette annonce est déjà payée'], 400);
        }

        try {
            if (!config('services.moneroo.secret_key')) {
                throw new \Exception('La clé secrète Moneroo n\'est pas configurée');
            }

            $paymentData = [
                'amount' => (int) $annonce->acompte,
                'currency' => 'XOF',
                'description' => 'Acompte pour annonce: ' . ($annonce->subject->nom ?? 'Formation'),
                'return_url' => route('annonces.payment.callback.moneroo'),
                'customer' => [
                    'email' => $user->email,
                    'first_name' => $user->firstname,
                    'last_name' => $user->lastname,
                    'phone' => $user->telephone ?? '',
                ],
                'metadata' => [
                    'annonce_id' => (string) $annonce->id,
                    'user_id' => (string) $user->id,
                    'payment_type' => 'annonce_acompte',
                ],
            ];

            $monerooPayment = new MonerooPayment();
            $payment = $monerooPayment->init($paymentData);

            Log::info('Paiement Moneroo initialisé', [
                'transaction_id' => $payment->id,
                'annonce_id' => $annonce->id,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'checkout_url' => $payment->checkout_url,
                'transaction_id' => $payment->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur init paiement Moneroo: ' . $e->getMessage(), [
                'annonce_id' => $annonce->id,
                'user_id' => $user->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Callback de paiement Moneroo
    public function handlePaymentMoneroo(Request $request)
    {
        $user = Auth::user();
        $transactionId = $request->query('paymentId');

        Log::info('Payment success callback Moneroo', [
            'transaction_id' => $transactionId,
            'all_params' => $request->all()
        ]);

        if (!$transactionId) {
            return redirect()->route('annonces.index')
                ->with('error', 'Transaction invalide.');
        }

        try {
            $monerooPayment = new MonerooPayment();

            Log::info('Attempting to get payment details', ['transaction_id' => $transactionId]);

            $payment = $monerooPayment->get($transactionId);

            Log::info('Payment retrieved successfully', [
                'transaction_id' => $transactionId,
                'status' => $payment->status ?? 'N/A',
            ]);

            if (isset($payment->is_processed) && $payment->is_processed === true) {
                Log::info('Payment already processed by Moneroo');

                $existingPayment = Payment::where('moneroo_payment_id', $transactionId)->first();
                if ($existingPayment && $existingPayment->annonce_id) {
                    return redirect()->route('annonces.show', $existingPayment->annonce_id)
                        ->with('info', 'Ce paiement a déjà été traité.');
                }

                return redirect()->route('annonces.index')
                    ->with('info', 'Ce paiement a déjà été traité.');
            }

            $status = $payment->status ?? 'unknown';

            if (strtolower($status) === 'success') {
                Log::info('Starting annonce payment processing');

                $paymentData = json_decode(json_encode($payment), true);
                $annonceId = $paymentData['metadata']['annonce_id'] ?? null;

                if (!$annonceId) {
                    throw new \Exception('Annonce ID non trouvé dans les métadonnées');
                }

                $this->processAnnoncePaymentMoneroo($payment, $transactionId, $annonceId);

                try {
                    $monerooPayment->markAsProcessed($transactionId);
                    Log::info('Payment marked as processed');
                } catch (\Exception $e) {
                    Log::warning('Could not mark as processed: ' . $e->getMessage());
                }

                return redirect()->route('annonces.show', $annonceId)
                    ->with('success', 'Paiement effectué avec succès ! Votre annonce est maintenant publiée.');
            } else {
                Log::warning('Payment not successful', ['status' => $status]);

                return redirect()->route('annonces.payment', $annonceId ?? '')
                    ->with('error', 'Le paiement n\'a pas été validé. Statut: ' . $status);
            }

        } catch (\Exception $e) {
            Log::error('Erreur verification paiement', [
                'transaction_id' => $transactionId,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
            ]);

            return redirect()->route('annonces.index')
                ->with('error', 'Erreur lors de la vérification du paiement.');
        }
    }

    // Traiter le paiement Moneroo
    private function processAnnoncePaymentMoneroo($payment, $transactionId, $annonceId)
    {
        try {
            Log::info('Processing annonce payment started', [
                'transaction_id' => $transactionId,
                'annonce_id' => $annonceId
            ]);

            $existingPayment = Payment::where('moneroo_payment_id', $transactionId)->first();

            if ($existingPayment) {
                Log::info('Payment already processed in database');
                return;
            }

            $paymentData = json_decode(json_encode($payment), true);

            if (!is_array($paymentData)) {
                throw new \Exception('Impossible de convertir les données de paiement');
            }

            DB::beginTransaction();

            $annonce = Annonce::findOrFail($annonceId);

            $userId = null;
            if (isset($paymentData['metadata']) && is_array($paymentData['metadata'])) {
                $userId = $paymentData['metadata']['user_id'] ?? null;
            }

            if (!$userId) {
                throw new \Exception('User ID manquant dans les metadata');
            }

            if ($annonce->student_id != $userId) {
                throw new \Exception('L\'utilisateur n\'est pas propriétaire de l\'annonce');
            }

            $amount = (float) ($paymentData['amount'] ?? $annonce->acompte);

            $currency = 'XOF';
            if (isset($paymentData['currency']) && is_array($paymentData['currency'])) {
                $currency = $paymentData['currency']['code'] ?? 'XOF';
            }

            $methodCode = 'moneroo';
            $methodName = 'Moneroo';

            if (isset($paymentData['capture']) && is_array($paymentData['capture'])) {
                if (isset($paymentData['capture']['method']) && is_array($paymentData['capture']['method'])) {
                    $methodCode = $paymentData['capture']['method']['short_code'] ?? 'moneroo';
                    $methodName = $paymentData['capture']['method']['name'] ?? 'Moneroo';
                }
            }

            Log::info('Payment details extracted', [
                'amount' => $amount,
                'currency' => $currency,
                'method_code' => $methodCode,
            ]);

            $paymentDetailsArray = [
                'id' => $paymentData['id'] ?? $transactionId,
                'status' => $paymentData['status'] ?? 'success',
                'amount' => $amount,
                'currency_code' => $currency,
                'currency_full' => $paymentData['currency'] ?? null,
                'amount_formatted' => $paymentData['amount_formatted'] ?? null,
                'description' => $paymentData['description'] ?? null,
                'method' => [
                    'code' => $methodCode,
                    'name' => $methodName,
                ],
                'customer' => $paymentData['customer'] ?? null,
                'capture' => $paymentData['capture'] ?? null,
                'metadata' => $paymentData['metadata'] ?? null,
                'initiated_at' => $paymentData['initiated_at'] ?? null,
            ];

            $paidAt = isset($paymentData['initiated_at'])
                ? Carbon::parse($paymentData['initiated_at'])
                : now();

            Log::info('Creating payment record for annonce');

            $paymentRecord = Payment::create([
                'moneroo_payment_id' => $transactionId,
                'annonce_id' => $annonce->id,
                'user_id' => $userId,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'completed',
                'payment_method' => $methodCode,
                'payment_details' => json_encode($paymentDetailsArray),
                'paid_at' => $paidAt,
            ]);

            $annonce->update([
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => Carbon::now()
            ]);

            Log::info('Annonce payment record created successfully', [
                'payment_id' => $paymentRecord->id,
                'annonce_id' => $annonce->id,
            ]);

            DB::commit();

            Log::info('Annonce payment processed successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error in processAnnoncePaymentMoneroo', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            throw $e;
        }
    }

    // Webhook Moneroo
    public function webhookMoneroo(Request $request)
    {
        Log::info('Webhook Moneroo reçu', $request->all());

        try {
            $payload = $request->all();

            $transactionId = $payload['data']['id'] ?? null;
            $status = $payload['data']['status'] ?? null;
            $metadata = $payload['data']['metadata'] ?? [];

            if (!$transactionId || $status !== 'success') {
                return response()->json(['status' => 'ignored']);
            }

            $annonceId = $metadata['annonce_id'] ?? null;

            if (!$annonceId) {
                Log::warning('Annonce ID non trouvé dans metadata');
                return response()->json(['status' => 'ignored']);
            }

            $existingPayment = Payment::where('moneroo_payment_id', $transactionId)->first();

            if ($existingPayment) {
                return response()->json(['status' => 'already_processed']);
            }

            $payment = (object) $payload['data'];

            $this->processAnnoncePaymentMoneroo($payment, $transactionId, $annonceId);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Erreur webhook Moneroo', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // Vérifier le statut du paiement
    public function checkPaymentStatus(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);

        return response()->json([
            'is_paid' => $annonce->is_paid,
            'status' => $annonce->status,
        ]);
    }

    // Afficher les annonces de l'étudiant
    public function index()
    {
        abort_if(Auth::user()->role_id != 2, 403, 'Accès réservé aux étudiants');

        $user = Auth::user();
        $annonces = Annonce::with('subject')
            ->where('student_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('annonces.index', ['annonces' => $annonces, 'user' => $user]);
    }

    // Afficher une annonce spécifique
    public function show($id)
    {
        $annonce = Annonce::with(['student', 'subject', 'payments'])->findOrFail($id);
        $user = Auth::user();

        abort_if($annonce->student_id != Auth::id() && Auth::user()->role_id != 1, 403, 'Accès non autorisé');

        return view('annonces.show', ['annonce' => $annonce, 'user' => $user]);
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $annonce = Annonce::with('subject')->findOrFail($id);
        $user = Auth::user();

        abort_if($annonce->student_id != Auth::id(), 403, 'Accès non autorisé');

        if ($annonce->status != 'en_attente') {
            return to_route('annonces.show', $annonce->id)
                ->with('error', 'Cette annonce ne peut plus être modifiée.');
        }

        $subjects = $this->getSubjects();

        return view('annonces.edit', [
            'annonce' => $annonce,
            'user' => $user,
            'subjects' => $subjects
        ]);
    }

    // Mettre à jour l'annonce
    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);

        abort_if($annonce->student_id != Auth::id(), 403, 'Accès non autorisé');

        if ($annonce->status != 'en_attente') {
            return to_route('annonces.show', $annonce->id)
                ->with('error', 'Cette annonce ne peut plus être modifiée.');
        }

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
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
                            if (!preg_match('/^([a-zA-Zéèêëàâäîïôöùûüç\s]+) (\d{2}:\d{2}) - (\d{2}:\d{2})$/', $line, $matches)) {
                                $validFormat = false;
                                $errors[] = "Ligne " . ($index + 1) . ": Format incorrect. Utilisez: 'jour HH:MM - HH:MM'";
                                continue;
                            }

                            $jour = trim($matches[1]);
                            $startTime = $matches[2];
                            $endTime = $matches[3];

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

        $annonce->subject_id = $request->subject_id;
        $annonce->description = $request->description;
        $annonce->budget = $request->budget;
        $annonce->disponibilite = $request->disponibilite;
        $annonce->format = $request->format;

        // Recalculer l'acompte si le budget a changé (toujours 30%)
        if ($annonce->isDirty('budget')) {
            $annonce->acompte = $request->budget * 0.3;
        }

        $annonce->save();

        return to_route('annonces.show', $annonce->id)
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    // Supprimer une annonce
    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);

        abort_if($annonce->student_id != Auth::id(), 403, 'Accès non autorisé');

        if ($annonce->status === 'attribuee') {
            return back()
                ->with('error', 'Impossible de supprimer une annonce déjà attribuée.');
        }

        $annonce->delete();

        return to_route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}
