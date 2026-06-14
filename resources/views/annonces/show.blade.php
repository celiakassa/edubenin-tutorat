@extends('layouts.dashboard')

@section('title', "Détails de l'annonce - Kopiao")
@section('page-title', "Détail de l'annonce")

@push('styles')
    <style>
        .ad-page { max-width: 900px; margin: 0 auto; }

        .ad-back { display: inline-flex; align-items: center; gap: 8px; color: var(--kp-muted); text-decoration: none; font-weight: 600; font-size: var(--kp-fs-base); margin-bottom: 18px; transition: color .2s; }
        .ad-back:hover { color: var(--kp-blue); }

        .ad-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 6px; }
        .ad-head__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 9px; display: flex; align-items: center; gap: 11px; }
        .ad-head__title i { color: var(--kp-blue); }
        .ad-meta { display: flex; gap: 18px; color: var(--kp-muted); font-size: var(--kp-fs-sm); flex-wrap: wrap; }
        .ad-meta i { margin-right: 5px; color: var(--kp-blue); }

        .ad-status { padding: 6px 16px; border-radius: 20px; font-size: var(--kp-fs-xs); font-weight: 600; white-space: nowrap; flex-shrink: 0; }
        .status-en_attente { background: #fef3c7; color: #92400e; }
        .status-en_paiement { background: #dbeafe; color: #1e40af; }
        .status-publiee { background: #d1fae5; color: #065f46; }
        .status-attribuee { background: #ede9fe; color: #5b21b6; }
        .status-refusee { background: #fee2e2; color: #991b1b; }

        .ad-alert { padding: 12px 16px; border-radius: 11px; margin: 16px 0; font-weight: 500; font-size: var(--kp-fs-base); display: flex; align-items: center; gap: 9px; }
        .ad-alert.ok { background: #e7f6ee; color: #1d7a48; }
        .ad-alert.err { background: #fee2e2; color: #991b1b; }

        .ad-grid { display: grid; grid-template-columns: 1fr 330px; gap: 20px; align-items: start; margin-top: 22px; }
        @media (max-width: 820px) { .ad-grid { grid-template-columns: 1fr; } }
        @media (max-width: 575px) {
            .ad-head__title { font-size: var(--kp-fs-xl); }
            .ad-meta { gap: 8px 16px; }
            .ad-card { padding: 16px; }
            .ad-grid { gap: 16px; margin-top: 18px; }
            /* Actions : boutons empilés pleine largeur */
            .ad-actions { flex-direction: column; align-items: stretch; }
            .ad-actions > .kp-btn, .ad-actions > form { width: 100%; }
            .ad-actions .kp-btn { width: 100%; justify-content: center; }
        }

        .ad-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; padding: 20px 22px; box-shadow: var(--kp-shadow); margin-bottom: 18px; }
        .ad-card__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-lg); font-weight: 700; color: var(--kp-ink); margin: 0 0 15px; display: flex; align-items: center; gap: 9px; }
        .ad-card__title i { color: var(--kp-blue); }
        .ad-desc { color: var(--kp-text); font-size: var(--kp-fs-md); line-height: 1.65; margin: 0; }

        .ad-dispo { display: flex; flex-direction: column; gap: 8px; }
        .ad-dispo__item { display: flex; justify-content: space-between; align-items: center; padding: 9px 13px; background: var(--kp-surface); border-radius: 10px; font-size: var(--kp-fs-base); }
        .ad-dispo__day { font-weight: 600; color: var(--kp-ink); }
        .ad-dispo__time { color: var(--kp-muted); }
        .ad-empty { color: var(--kp-muted); font-style: italic; font-size: var(--kp-fs-base); }

        /* Finances */
        .ad-budget { background: var(--kp-yellow); border-radius: 13px; padding: 15px 18px; margin-bottom: 14px; }
        .ad-budget__lbl { font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: #1a1a1a; }
        .ad-budget__amt { font-size: var(--kp-fs-2xl); font-weight: 800; color: #1a1a1a; margin-top: 2px; }
        .ad-fin__row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--kp-border); font-size: var(--kp-fs-base); }
        .ad-fin__row:last-of-type { border-bottom: none; }
        .ad-fin__lbl { color: var(--kp-muted); }
        .ad-fin__lbl small { display: block; font-size: var(--kp-fs-2xs); color: var(--kp-blue); }
        .ad-fin__val { font-weight: 700; color: var(--kp-ink); text-align: right; }
        .ad-paystatus { margin-top: 12px; width: 100%; display: inline-flex; justify-content: center; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 11px; font-size: var(--kp-fs-sm); font-weight: 600; }
        .ad-paystatus.paid { background: #e7f6ee; color: #1d7a48; }
        .ad-paystatus.pending { background: #fff3cd; color: #856404; }

        /* Étudiant */
        .ad-student { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .ad-student__avatar { width: 48px; height: 48px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; }
        .ad-student__name { font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-md); }
        .ad-student__since { color: var(--kp-muted); font-size: var(--kp-fs-xs); }
        .ad-student__detail { display: flex; align-items: center; gap: 9px; color: var(--kp-text); font-size: var(--kp-fs-base); padding: 6px 0; border-top: 1px solid var(--kp-surface); }
        .ad-student__detail i { color: var(--kp-muted); width: 16px; text-align: center; }

        /* Timeline */
        .ad-timeline { position: relative; padding-left: 22px; }
        .ad-timeline::before { content: ''; position: absolute; left: 5px; top: 4px; bottom: 4px; width: 2px; background: var(--kp-border); }
        .ad-tl { position: relative; padding-bottom: 16px; }
        .ad-tl:last-child { padding-bottom: 0; }
        .ad-tl::before { content: ''; position: absolute; left: -22px; top: 3px; width: 12px; height: 12px; border-radius: 50%; background: var(--kp-blue); border: 2px solid #fff; box-shadow: 0 0 0 1px var(--kp-border); }
        .ad-tl__date { font-size: var(--kp-fs-2xs); color: var(--kp-muted); }
        .ad-tl__title { font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-base); margin: 1px 0; }
        .ad-tl__desc { font-size: var(--kp-fs-sm); color: var(--kp-muted); }

        /* Actions */
        .ad-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 4px; }
        .ad-btn-danger { background: #e02c18; color: #fff; }
        .ad-btn-danger:hover { background: #c62411; color: #fff; }
        .ad-badge { background: rgba(255,255,255,.25); padding: 1px 8px; border-radius: 20px; font-size: var(--kp-fs-2xs); margin-left: 4px; }
    </style>
@endpush

@section('content')
    <div class="ad-page">
        <a href="{{ route('annonces.index') }}" class="ad-back"><i class="fas fa-arrow-left"></i> Retour aux annonces</a>

        <div class="ad-head">
            <div>
                <h1 class="ad-head__title"><i class="fas fa-book"></i> {{ $annonce->subject->nom ?? 'Matière non spécifiée' }}</h1>
                <div class="ad-meta">
                    <span><i class="fas fa-calendar-alt"></i> Créée le {{ $annonce->created_at->format('d/m/Y') }}</span>
                    @if ($annonce->status == 'publiée' && $annonce->published_at)
                        <span><i class="fas fa-eye"></i> Publiée le {{ $annonce->published_at->format('d/m/Y') }}</span>
                    @endif
                </div>
            </div>
            <span class="ad-status status-{{ str_replace('é', 'e', $annonce->status) }}">{{ $annonce->status }}</span>
        </div>


        <div class="ad-grid">
            {{-- Colonne principale --}}
            <div>
                <div class="ad-card">
                    <h3 class="ad-card__title"><i class="fas fa-align-left"></i> Description</h3>
                    <p class="ad-desc">{{ $annonce->description }}</p>
                </div>

                <div class="ad-card">
                    <h3 class="ad-card__title"><i class="fas fa-calendar-check"></i> Disponibilités</h3>
                    <div class="ad-dispo">
                        @if ($annonce->disponibilite)
                            @foreach (explode("\n", trim($annonce->disponibilite)) as $line)
                                @if (trim($line))
                                    @php
                                        $parts = explode(' ', trim($line));
                                        $jour = count($parts) >= 3 ? ucfirst($parts[0]) : '';
                                        $heures = count($parts) >= 3 ? $parts[1] . ' ' . $parts[2] . ' ' . ($parts[3] ?? '') : trim($line);
                                    @endphp
                                    <div class="ad-dispo__item">
                                        <span class="ad-dispo__day">{{ $jour ?: 'Créneau' }}</span>
                                        <span class="ad-dispo__time">{{ $heures }}</span>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p class="ad-empty">Aucune disponibilité spécifiée.</p>
                        @endif
                    </div>
                </div>

                <div class="ad-card">
                    <h3 class="ad-card__title"><i class="fas fa-history"></i> Historique</h3>
                    <div class="ad-timeline">
                        <div class="ad-tl">
                            <div class="ad-tl__date">{{ $annonce->created_at->format('d/m/Y H:i') }}</div>
                            <div class="ad-tl__title">Annonce créée</div>
                            <div class="ad-tl__desc">L'annonce a été créée par l'étudiant.</div>
                        </div>
                        @if ($annonce->status == 'en_paiement')
                            <div class="ad-tl">
                                <div class="ad-tl__date">En attente</div>
                                <div class="ad-tl__title">Paiement en cours</div>
                                <div class="ad-tl__desc">En attente de paiement de l'acompte.</div>
                            </div>
                        @endif
                        @if ($annonce->published_at)
                            <div class="ad-tl">
                                <div class="ad-tl__date">{{ $annonce->published_at->format('d/m/Y H:i') }}</div>
                                <div class="ad-tl__title">Annonce publiée</div>
                                <div class="ad-tl__desc">Visible par les tuteurs.</div>
                            </div>
                        @endif
                        @if ($annonce->payments()->where('status', 'completed')->exists())
                            @foreach ($annonce->payments()->where('status', 'completed')->get() as $payment)
                                <div class="ad-tl">
                                    <div class="ad-tl__date">{{ $payment->paid_at->format('d/m/Y H:i') }}</div>
                                    <div class="ad-tl__title">Paiement effectué</div>
                                    <div class="ad-tl__desc">Acompte de {{ number_format($payment->amount, 0, ',', ' ') }} FCFA payé.</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- Colonne latérale --}}
            <div>
                <div class="ad-card">
                    <h3 class="ad-card__title"><i class="fas fa-money-bill-wave"></i> Finances</h3>
                    <div class="ad-budget">
                        <div class="ad-budget__lbl">Budget total</div>
                        <div class="ad-budget__amt">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div class="ad-fin__row">
                        <span class="ad-fin__lbl">Acompte <small>{{ $annonce->budget ? round(($annonce->acompte / $annonce->budget) * 100) : 0 }}% du budget</small></span>
                        <span class="ad-fin__val">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="ad-fin__row">
                        <span class="ad-fin__lbl">Solde restant</span>
                        <span class="ad-fin__val">{{ number_format($annonce->budget - $annonce->acompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <span class="ad-paystatus {{ $annonce->is_paid ? 'paid' : 'pending' }}">
                        <i class="fas fa-{{ $annonce->is_paid ? 'check-circle' : 'clock' }}"></i>
                        {{ $annonce->is_paid ? 'Acompte payé' : 'Acompte en attente' }}
                    </span>
                </div>

                <div class="ad-card">
                    <h3 class="ad-card__title"><i class="fas fa-user-graduate"></i> Étudiant</h3>
                    <div class="ad-student">
                        <div class="ad-student__avatar">{{ strtoupper(substr($annonce->student->firstname, 0, 1) . substr($annonce->student->lastname, 0, 1)) }}</div>
                        <div>
                            <div class="ad-student__name">{{ $annonce->student->firstname }} {{ $annonce->student->lastname }}</div>
                            <div class="ad-student__since">Inscrit depuis {{ $annonce->student->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="ad-student__detail"><i class="fas fa-envelope"></i> {{ $annonce->student->email }}</div>
                    @if ($annonce->student->telephone)
                        <div class="ad-student__detail"><i class="fas fa-phone"></i> {{ $annonce->student->telephone }}</div>
                    @endif
                    @if ($annonce->student->city)
                        <div class="ad-student__detail"><i class="fas fa-map-marker-alt"></i> {{ $annonce->student->city }}</div>
                    @endif
                    @if ($annonce->student->learning_preference)
                        <div class="ad-student__detail">
                            <i class="fas fa-graduation-cap"></i>
                            @if ($annonce->student->learning_preference == 'online') Cours en ligne
                            @elseif ($annonce->student->learning_preference == 'in_person') Cours présentiel
                            @else Mode hybride @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="ad-actions">
            @if (!$annonce->is_paid && $annonce->status == 'en_attente' && Auth::user()->id == $annonce->student_id)
                <button type="button" class="kp-btn kp-btn--primary" onclick="payThisAnnonce()"><i class="fas fa-credit-card"></i> Payer l'acompte</button>
            @endif
            @if (($annonce->status == 'publiée' || $annonce->status == 'attribuee') && Auth::user()->id == $annonce->student_id)
                <a href="{{ route('annonces.candidatures.index', $annonce->id) }}" class="kp-btn kp-btn--secondary">
                    <i class="fas fa-users"></i> Voir les candidatures
                    @if ($annonce->candidatures()->count() > 0)<span class="ad-badge">{{ $annonce->candidatures()->count() }}</span>@endif
                </a>
            @endif
            @if (Auth::user()->id == $annonce->student_id && $annonce->status == 'en_attente')
                <button type="button" class="kp-btn kp-btn--secondary" onclick="editThisAnnonce()"><i class="fas fa-edit"></i> Modifier</button>
            @endif
            @if (Auth::user()->id == $annonce->student_id && $annonce->status != 'attribuee')
                <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST" onsubmit="return kpConfirmDelete(event, this, {text: 'Cette annonce sera définitivement supprimée.'});">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="kp-btn ad-btn-danger"><i class="fas fa-trash"></i> Supprimer</button>
                </form>
            @endif
            @if (Auth::user()->role_id == 1)
                <a href="{{ route('admin.dashboard') }}" class="kp-btn kp-btn--secondary"><i class="fas fa-cog"></i> Administration</a>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function editThisAnnonce() {
            if (window.kpAnnonceFormToEdit && window.openCreateAnnonceModal) {
                window.kpAnnonceFormToEdit({
                    action: @json(route('annonces.update', $annonce->id)),
                    subjectId: @json($annonce->subject_id),
                    subjectNom: @json($annonce->subject->nom ?? ''),
                    description: @json($annonce->description),
                    format: @json($annonce->format),
                    disponibilite: @json($annonce->disponibilite),
                    budget: @json($annonce->budget)
                });
                window.openCreateAnnonceModal();
            } else {
                window.location = @json(route('annonces.edit', $annonce->id));
            }
        }

        @php
            $payMatiere = $annonce->subject->nom ?? 'Matière non spécifiée';
            $payBudget = number_format($annonce->budget, 0, ',', ' ') . ' FCFA';
            $payAcompte = number_format($annonce->acompte, 0, ',', ' ') . ' FCFA';
            $payNote = $annonce->budget ? round(($annonce->acompte / $annonce->budget) * 100) . '% du budget total' : '';
        @endphp
        function payThisAnnonce() {
            if (window.openPaymentDrawer) {
                window.openPaymentDrawer({
                    annonceId: @json($annonce->id),
                    matiere: @json($payMatiere),
                    format: @json($annonce->format),
                    disponibilite: @json($annonce->disponibilite),
                    budget: @json($payBudget),
                    acompte: @json($payAcompte),
                    note: @json($payNote)
                });
            } else {
                window.location = @json(route('annonces.show', $annonce->id));
            }
        }
    </script>
@endpush
