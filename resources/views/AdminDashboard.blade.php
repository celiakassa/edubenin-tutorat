@extends('layouts.dashboard')

@section('title', 'Kopiao - Administration')
@section('page-title', 'Tableau de bord')

@push('styles')
    <style>
        .adm-greet { margin-bottom: 22px; }
        .adm-greet h1 { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .adm-greet p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .adm-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 26px; }
        .adm-stat { background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; transition: border-color .2s, transform .2s; }
        .adm-stat:hover { border-color: var(--kp-blue); transform: translateY(-1px); }
        .adm-stat__icon { width: 44px; height: 44px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-md); flex-shrink: 0; background: rgba(26, 26, 26, .06); color: #1a1a1a; }
        .adm-stat__info { display: flex; align-items: baseline; gap: 7px; min-width: 0; flex-wrap: wrap; }
        .adm-stat__val { font-size: var(--kp-fs-xl); font-weight: 700; color: #1a1a1a; margin: 0; }
        .adm-stat__lbl { font-size: var(--kp-fs-xs); color: var(--kp-muted); margin: 0; }
        .adm-group { margin-bottom: 22px; }
        .adm-group__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-md); font-weight: 700; color: var(--kp-ink); margin: 0 0 12px; display: flex; align-items: center; gap: 9px; }
        .adm-group__title i { color: var(--kp-blue); }
        .adm-stat__icon--ok { background: #d1fae5; color: #065f46; }
        .adm-stat__icon--wait { background: #fef3c7; color: #92400e; }
        .adm-stat__icon--danger { background: #fee2e2; color: #991b1b; }
        .adm-stat__icon--info { background: var(--kp-blue-soft); color: var(--kp-blue); }

        .adm-section { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; overflow: hidden; margin-bottom: 18px; }
        .adm-section__head { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 15px 18px; border-bottom: 1px solid var(--kp-border); }
        .adm-section__head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-md); font-weight: 700; color: var(--kp-ink); margin: 0; display: flex; align-items: center; gap: 9px; }
        .adm-section__head h2 i { color: var(--kp-blue); }
        .adm-count { font-size: var(--kp-fs-2xs); font-weight: 700; padding: 4px 12px; border-radius: 20px; white-space: nowrap; }
        .adm-count--warning { background: #fef3c7; color: #92400e; }
        .adm-count--success { background: #d1fae5; color: #065f46; }
        .adm-count--muted { background: var(--kp-surface); color: var(--kp-muted); }
        .adm-count--danger { background: #fee2e2; color: #991b1b; }

        .adm-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .adm-table thead th { text-align: left; padding: 11px 18px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: var(--kp-surface); white-space: nowrap; }
        .adm-table tbody td { padding: 12px 18px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; }
        .adm-table tbody tr:last-child td { border-bottom: none; }
        .adm-teacher { display: flex; align-items: center; gap: 11px; }
        .adm-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-2xs); flex-shrink: 0; overflow: hidden; }
        .adm-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .adm-teacher__name { font-weight: 700; color: var(--kp-ink); }
        .adm-teacher__mail { color: var(--kp-muted); font-size: var(--kp-fs-xs); }
        .adm-comp { display: flex; align-items: center; gap: 8px; min-width: 120px; }
        .adm-comp__bar { flex: 1; height: 6px; background: var(--kp-border); border-radius: 6px; overflow: hidden; }
        .adm-comp__bar span { display: block; height: 100%; background: var(--kp-blue); border-radius: 6px; }
        .adm-comp__pct { font-size: var(--kp-fs-2xs); font-weight: 700; color: var(--kp-muted); white-space: nowrap; }
        .adm-actions { display: flex; gap: 7px; justify-content: flex-end; flex-wrap: wrap; }
        .adm-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 13px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; text-decoration: none; cursor: pointer; border: none; white-space: nowrap; transition: all .2s; }
        .adm-btn--primary { background: var(--kp-blue); color: #fff; }
        .adm-btn--primary:hover { background: var(--kp-blue-darker); color: #fff; }
        .adm-btn--ghost { background: #fff; color: var(--kp-ink); border: 1.5px solid var(--kp-border); }
        .adm-btn--ghost:hover { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }

        .adm-empty { padding: 28px 18px; text-align: center; color: var(--kp-muted); font-size: var(--kp-fs-sm); }

        @media (max-width: 640px) {
            .adm-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .adm-table thead { display: none; }
            .adm-table, .adm-table tbody, .adm-table tr, .adm-table td { display: block; }
            .adm-table tbody tr { position: relative; padding: 14px; border-bottom: 1px solid var(--kp-border); }
            .adm-table tbody td { border: none !important; padding: 4px 0; }
            .adm-teacher { margin-bottom: 8px; }
            .adm-comp { min-width: 0; max-width: 220px; }
            .adm-actions { justify-content: flex-start; margin-top: 8px; }
        }
        @media (max-width: 380px) { .adm-stats { grid-template-columns: 1fr; } }

    </style>
@endpush

@section('content')
    <div class="adm-greet">
        <h1>Bonjour, {{ auth()->user()->firstname }} 👋</h1>
        <p>Vue d'ensemble de la plateforme et gestion des tuteurs.</p>
    </div>

    {{-- Groupe : Vue d'ensemble --}}
    <div class="adm-group">
        <h2 class="adm-group__title"><i class="fas fa-layer-group"></i> Vue d'ensemble</h2>
        <div class="adm-stats">
            <div class="adm-stat"><div class="adm-stat__icon"><i class="fas fa-users"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $totalUsers }}</h3><p class="adm-stat__lbl">Utilisateurs</p></div></div>
            <div class="adm-stat"><div class="adm-stat__icon"><i class="fas fa-user-graduate"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $totalStudents }}</h3><p class="adm-stat__lbl">Apprenants</p></div></div>
            <div class="adm-stat"><div class="adm-stat__icon"><i class="fas fa-chalkboard-teacher"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $totalTeachers }}</h3><p class="adm-stat__lbl">Tuteurs</p></div></div>
            <div class="adm-stat"><div class="adm-stat__icon adm-stat__icon--ok"><i class="fas fa-user-check"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $activeAccounts }}</h3><p class="adm-stat__lbl">Comptes actifs</p></div></div>
            <div class="adm-stat"><div class="adm-stat__icon adm-stat__icon--danger"><i class="fas fa-user-slash"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $inactiveAccounts }}</h3><p class="adm-stat__lbl">Désactivés</p></div></div>
        </div>
    </div>

    {{-- Groupe : Statut des tuteurs --}}
    <div class="adm-group">
        <h2 class="adm-group__title"><i class="fas fa-user-shield"></i> Statut des tuteurs</h2>
        <div class="adm-stats">
            <div class="adm-stat"><div class="adm-stat__icon adm-stat__icon--ok"><i class="fas fa-check-circle"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $verifiedTeachersCount }}</h3><p class="adm-stat__lbl">Vérifiés</p></div></div>
            <div class="adm-stat"><div class="adm-stat__icon adm-stat__icon--wait"><i class="fas fa-clock"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $pendingTeachersCount }}</h3><p class="adm-stat__lbl">En attente</p></div></div>
            <div class="adm-stat"><div class="adm-stat__icon adm-stat__icon--danger"><i class="fas fa-times-circle"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $rejectedTeachersCount }}</h3><p class="adm-stat__lbl">Rejetés</p></div></div>
            <div class="adm-stat"><div class="adm-stat__icon"><i class="fas fa-user-slash"></i></div><div class="adm-stat__info"><h3 class="adm-stat__val">{{ $inactiveTeachersCount }}</h3><p class="adm-stat__lbl">Désactivés</p></div></div>
        </div>
    </div>

    @php
        $groups = [
            ['title' => 'Tuteurs en attente de validation', 'icon' => 'fa-clock', 'color' => 'warning', 'list' => $pendingTeachers, 'badge' => $pendingTeachersCount, 'doc' => true],
        ];
    @endphp

    @foreach ($groups as $g)
        <div class="adm-section">
            <div class="adm-section__head">
                <h2><i class="fas {{ $g['icon'] }}"></i> {{ $g['title'] }}</h2>
                <span class="adm-count adm-count--{{ $g['color'] }}">{{ $g['badge'] }}</span>
            </div>
            @if (count($g['list']) > 0)
                <div style="overflow-x: auto;">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Tuteur</th>
                                <th>Complétion</th>
                                <th>Inscrit le</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($g['list'] as $teacher)
                                @php $comp = $teacher->profile_completion ?? null; @endphp
                                <tr>
                                    <td>
                                        <div class="adm-teacher">
                                            <div class="adm-avatar">
                                                @if ($teacher->photo_path && Storage::disk('public')->exists($teacher->photo_path))
                                                    <img src="{{ asset('storage/' . $teacher->photo_path) }}" alt="Profil">
                                                @else
                                                    {{ strtoupper(substr($teacher->firstname, 0, 1) . substr($teacher->lastname, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="adm-teacher__name">{{ $teacher->firstname }} {{ $teacher->lastname }}</div>
                                                <div class="adm-teacher__mail">{{ $teacher->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if (! is_null($comp))
                                            <div class="adm-comp">
                                                <div class="adm-comp__bar"><span style="width: {{ $comp }}%;"></span></div>
                                                <span class="adm-comp__pct">{{ $comp }}%</span>
                                            </div>
                                        @else
                                            <span style="color: var(--kp-muted);">—</span>
                                        @endif
                                    </td>
                                    <td class="adm-teacher__mail">{{ $teacher->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="adm-actions">
                                            @if ($g['doc'] && $teacher->identity_document_path)
                                                <a href="{{ route('admin.viewIdentityDocument', $teacher->id) }}" target="_blank" class="adm-btn adm-btn--ghost"><i class="fas fa-file-alt"></i> Document</a>
                                            @endif
                                            <a href="{{ route('admin.teacher.details', $teacher->id) }}" class="adm-btn adm-btn--primary"><i class="fas fa-eye"></i> Détails</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="adm-empty">Aucun tuteur en attente de validation. 🎉</div>
            @endif
        </div>
    @endforeach

    <div style="text-align: center; margin-top: 6px;">
        <a href="{{ route('admin.teachers') }}" class="adm-btn adm-btn--primary" style="padding: 10px 22px;"><i class="fas fa-users"></i> Voir tous les tuteurs</a>
    </div>
@endsection

