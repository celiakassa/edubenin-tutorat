<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kopiao - Dashboard')</title>
    <link href="{{ asset('favicon.svg') }}" rel="icon" type="image/svg+xml">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Rubik:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="{{ asset('css/kopiao-ui.css') }}" rel="stylesheet">

    @include('layouts.partials.styles')

    <style>
        /* ===== Coquille Dashboard Kopiao — moderne & minimaliste ===== */
        body { margin: 0; background: var(--kp-surface); font-family: var(--kp-font-body); }
        .dash { display: flex; min-height: 100vh; }

        /* Sidebar — dégradé bleu */
        .dash-sidebar {
            width: 232px; flex-shrink: 0;
            background: linear-gradient(160deg, var(--kp-blue) 0%, var(--kp-blue-darker) 100%);
            color: #fff; display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0; z-index: 1040;
            transition: transform .3s ease;
        }
        .dash-sidebar__brand { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 20px 16px 14px; }
        .dash-sidebar__name { font-family: var(--kp-font-title); font-weight: 700; font-size: var(--kp-fs-xl); color: #fff; letter-spacing: .3px; text-decoration: none; transition: opacity .2s; }
        .dash-sidebar__name:hover { color: #fff; opacity: .8; }
        .dash-sidebar__toggle {
            background: none; border: none; color: rgba(255,255,255,.7); cursor: pointer; flex-shrink: 0;
            width: 30px; height: 30px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center; font-size: var(--kp-fs-lg); transition: all .2s;
        }
        .dash-sidebar__toggle:hover { background: rgba(255,255,255,.12); color: #fff; }
        .dash-sidebar__toggle i { transition: transform .2s; }
        .dash-nav { flex: 1; padding: 8px 10px; overflow-y: auto; }
        /* Chaque lien : icône dans une pastille arrondie */
        .dash-nav__cta {
            display: flex; align-items: center; gap: 11px;
            margin-bottom: 6px; padding: 7px 9px; color: #fff;
            border-radius: 12px; font-weight: 600; font-size: var(--kp-fs-base); text-decoration: none; transition: var(--kp-transition);
        }
        .dash-nav__cta i { width: 30px; height: 30px; border-radius: 9px; display: inline-flex; align-items: center; justify-content: center; font-size: var(--kp-fs-lg); background: var(--kp-yellow); color: #1a1a1a; flex-shrink: 0; transition: all .2s; }
        .dash-nav__cta:hover { background: rgba(255,255,255,.1); }
        .dash-nav__item {
            display: flex; align-items: center; gap: 11px; padding: 7px 9px; margin-bottom: 3px;
            border-radius: 12px; color: rgba(255,255,255,.85);
            text-decoration: none; font-weight: 500; font-size: var(--kp-fs-base); cursor: pointer; transition: var(--kp-transition);
        }
        .dash-nav__item i { width: 30px; height: 30px; border-radius: 9px; display: inline-flex; align-items: center; justify-content: center; font-size: var(--kp-fs-lg); background: rgba(255,255,255,.12); color: rgba(255,255,255,.9); flex-shrink: 0; transition: all .2s; }
        .dash-nav__item:hover { background: rgba(255,255,255,.08); color: #fff; }
        .dash-nav__item:hover i { background: rgba(255,255,255,.22); color: #fff; }
        /* Page active = pilule claire + icône en pastille blanche (icône bleue) */
        .dash-nav__item.active { background: rgba(255,255,255,.16); color: #fff; font-weight: 700; }
        .dash-nav__item.active i { background: #fff; color: var(--kp-blue); }
        .dash-sidebar__foot { padding: 12px; }
        .dash-logout {
            display: flex; align-items: center; gap: 11px; width: 100%; padding: 9px 11px;
            border-radius: 12px; background: #e02c18; color: #fff;
            border: none; font-weight: 600; font-size: var(--kp-fs-base); cursor: pointer; transition: var(--kp-transition);
        }
        .dash-logout i { width: 28px; height: 28px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: var(--kp-fs-lg); background: rgba(255, 255, 255, .18); color: #fff; flex-shrink: 0; }
        .dash-logout:hover { background: #c62411; color: #fff; }

        /* Zone principale */
        .dash-main { flex: 1; margin-left: 232px; min-width: 0; display: flex; flex-direction: column; padding-top: 67px; }
        .dash-header {
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
            background: var(--kp-surface);
            padding: 13px 40px; height: 67px;
            position: fixed; top: 0; left: 232px; right: 0; z-index: 1020;
            border-bottom: 1px solid var(--kp-border);
        }
        .dash-header__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-lg); font-weight: 700; color: var(--kp-ink); margin: 0; }
        .dash-burger { display: none; background: none; border: none; font-size: var(--kp-fs-2xl); color: var(--kp-ink); cursor: pointer; padding: 0; }
        .dash-user { display: flex; align-items: center; gap: 9px; position: relative; cursor: pointer; }
        .dash-user__avatar { width: 40px; height: 40px; border-radius: 50%; background: #1a1a1a; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-base); overflow: hidden; flex-shrink: 0; }
        .dash-user__avatar img { width: 100%; height: 100%; object-fit: cover; }
        .dash-user__menu { position: absolute; right: 0; top: calc(100% + 12px); min-width: 244px; background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: 14px; box-shadow: var(--kp-shadow-lg); padding: 12px; display: none; z-index: 1030; }
        /* Pont transparent pour ne pas perdre le survol entre l'avatar et la carte */
        .dash-user__menu.open { display: block; }
        /* Carte profil (non cliquable) */
        .dash-user__card { display: flex; align-items: center; gap: 12px; padding: 4px 6px 14px; border-bottom: 1px solid var(--kp-border); margin-bottom: 12px; }
        .dash-user__card-avatar { width: 46px; height: 46px; border-radius: 50%; background: #1a1a1a; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-md); overflow: hidden; flex-shrink: 0; }
        .dash-user__card-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .dash-user__card-info { min-width: 0; }
        .dash-user__card-name { display: block; font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-md); line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dash-user__card-email { display: block; color: var(--kp-muted); font-size: var(--kp-fs-xs); margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dash-user__logout { display: flex; align-items: center; justify-content: center; gap: 9px; width: 100%; padding: 10px 12px; border: none; border-radius: 10px; background: #e02c18; color: #fff; font-weight: 600; font-size: var(--kp-fs-base); cursor: pointer; transition: background .2s; }
        .dash-user__logout i { font-size: var(--kp-fs-lg); }
        .dash-user__logout:hover { background: #c62411; color: #fff; }
        .dash-content { flex: 1; padding: 28px 40px; }
        /* Largeur uniforme du contenu sur toutes les pages du dashboard */
        .dash-content__inner { max-width: 900px; margin: 0 auto; }

        /* Bouton repli (desktop) */
        .dash-collapse { display: inline-flex; background: none; border: none; font-size: var(--kp-fs-2xl); color: var(--kp-ink); cursor: pointer; padding: 0; }
        @media (min-width: 992px) {
            .dash.is-collapsed .dash-sidebar { width: 74px; }
            .dash.is-collapsed .dash-main { margin-left: 74px; }
            .dash.is-collapsed .dash-header { left: 74px; }
            .dash.is-collapsed .dash-nav__item span,
            .dash.is-collapsed .dash-nav__cta span,
            .dash.is-collapsed .dash-logout span { display: none; }
            .dash.is-collapsed .dash-nav__item,
            .dash.is-collapsed .dash-nav__cta,
            .dash.is-collapsed .dash-logout { justify-content: center; padding-left: 0; padding-right: 0; }
            .dash.is-collapsed .dash-sidebar__brand { justify-content: center; padding: 22px 0 14px; position: relative; }
            .dash.is-collapsed .dash-sidebar__toggle { display: none; }
            .dash.is-collapsed .dash-sidebar__toggle i { transform: rotate(180deg); }
            /* Logo replié = « K » cliquable (lien vers l'accueil) */
            .dash.is-collapsed .dash-sidebar__name { font-size: 0; }
            .dash.is-collapsed .dash-sidebar__name::after { content: 'K'; font-family: var(--kp-font-title); font-weight: 700; font-size: var(--kp-fs-xl); color: #fff; }
            /* Logo replié au survol : on cache le « K » et on affiche le toggle pour déplier */
            .dash.is-collapsed .dash-sidebar__brand:hover .dash-sidebar__name { display: none; }
            .dash.is-collapsed .dash-sidebar__brand:hover .dash-sidebar__toggle { display: inline-flex; }
        }

        .dash-backdrop { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, .45); z-index: 1035; }

        /* « Publier / Modifier une annonce » : panneau qui glisse depuis la droite */
        .kp-cmodal { display: none; position: fixed; inset: 0; z-index: 3000; }
        .kp-cmodal.open { display: block; }
        .kp-cmodal__overlay { position: fixed; inset: 0; background: rgba(11, 18, 32, .5); opacity: 0; transition: opacity .25s; }
        .kp-cmodal.open .kp-cmodal__overlay { opacity: 1; }
        .kp-cmodal__dialog { position: absolute; top: 0; right: 0; bottom: 0; width: 580px; max-width: 95vw; background: #fff; box-shadow: -14px 0 50px rgba(0, 0, 0, .22); transform: translateX(100%); transition: transform .3s ease; overflow-y: auto; }
        .kp-cmodal.open .kp-cmodal__dialog { transform: translateX(0); }
        .kp-cmodal__close { position: fixed; top: 14px; right: 16px; width: 36px; height: 36px; border-radius: 50%; border: none; background: #f1f3f7; color: #1a1a1a; cursor: pointer; z-index: 5; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-base); transition: all .2s; }
        .kp-cmodal__close:hover { background: var(--kp-blue); color: #fff; }
        /* Mobile : « Nouvelle annonce » monte du bas (bottom sheet) */
        @media (max-width: 575px) {
            .kp-cmodal__dialog {
                top: auto; left: 0; right: 0; bottom: 0;
                width: 100%; max-width: 100%; max-height: 92vh;
                border-radius: 20px 20px 0 0; transform: translateY(100%);
                box-shadow: 0 -14px 40px rgba(0, 0, 0, .25);
            }
            .kp-cmodal.open .kp-cmodal__dialog { transform: translateY(0); }
            .kp-cmodal__dialog::before { content: ''; position: absolute; top: 10px; left: 50%; transform: translateX(-50%); width: 42px; height: 4px; border-radius: 4px; background: #d5dae2; z-index: 6; }
            .kp-cmodal__close { position: absolute; top: 14px; right: 14px; }
        }

        /* « Paiement de l'acompte » : panneau qui glisse depuis la droite */
        .kp-pmodal { display: none; position: fixed; inset: 0; z-index: 3000; }
        .kp-pmodal.open { display: block; }
        .kp-pmodal__overlay { position: fixed; inset: 0; background: rgba(11, 18, 32, .5); opacity: 0; transition: opacity .25s; }
        .kp-pmodal.open .kp-pmodal__overlay { opacity: 1; }
        .kp-pmodal__dialog { position: absolute; top: 0; right: 0; bottom: 0; width: 480px; max-width: 95vw; background: #fff; box-shadow: -14px 0 50px rgba(0, 0, 0, .22); transform: translateX(100%); transition: transform .3s ease; overflow-y: auto; }
        .kp-pmodal.open .kp-pmodal__dialog { transform: translateX(0); }
        .kpp-wrap { padding: 26px 26px 32px; }
        .kpp-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); color: var(--kp-ink); margin: 0 0 4px; display: flex; align-items: center; gap: 9px; }
        .kpp-head h2 i { color: var(--kp-blue); }
        .kpp-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0 0 20px; }
        .kpp-summary { border: 1px solid var(--kp-border); border-radius: 14px; padding: 16px 18px; margin-bottom: 16px; }
        .kpp-summary h3 { font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); margin: 0 0 10px; font-weight: 700; }
        .kpp-row { display: flex; justify-content: space-between; gap: 16px; padding: 8px 0; font-size: var(--kp-fs-base); }
        .kpp-row + .kpp-row { border-top: 1px dashed var(--kp-border); }
        .kpp-row > span:first-child { color: var(--kp-muted); flex-shrink: 0; }
        .kpp-row > span:last-child { color: var(--kp-ink); font-weight: 600; text-align: right; white-space: pre-line; }
        .kpp-amount { background: var(--kp-yellow); border-radius: 14px; padding: 18px; text-align: center; margin-bottom: 16px; }
        .kpp-amount .lbl { font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: #1a1a1a; font-weight: 700; }
        .kpp-amount .val { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 800; color: #1a1a1a; margin: 4px 0 2px; }
        .kpp-amount .note { font-size: var(--kp-fs-xs); color: rgba(26, 26, 26, .65); }
        .kpp-instructions { list-style: none; background: var(--kp-blue-soft); border-radius: 12px; padding: 13px 16px; font-size: var(--kp-fs-xs); color: var(--kp-text); margin: 0 0 18px; }
        .kpp-instructions li { position: relative; padding-left: 20px; margin-bottom: 5px; }
        .kpp-instructions li:last-child { margin-bottom: 0; }
        .kpp-instructions li::before { content: '\f00c'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; left: 0; top: 1px; color: var(--kp-blue); font-size: var(--kp-fs-2xs); }
        .kpp-pay { width: 100%; border: none; border-radius: 30px; background: var(--kp-blue); color: #fff; padding: 14px; font-weight: 700; font-size: var(--kp-fs-md); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 9px; transition: background .2s; }
        .kpp-pay:hover { background: var(--kp-blue-darker); }
        .kpp-pay:disabled { opacity: .7; cursor: default; }
        .kpp-secure { text-align: center; font-size: var(--kp-fs-xs); color: var(--kp-muted); margin-top: 12px; }
        .kpp-spin { width: 15px; height: 15px; border: 2px solid rgba(255, 255, 255, .4); border-top-color: #fff; border-radius: 50%; display: inline-block; animation: kppspin .7s linear infinite; }
        @keyframes kppspin { to { transform: rotate(360deg); } }

        /* ===== Notifications toast (succès / erreur) — animées ===== */
        .kp-toast-wrap { position: fixed; top: 18px; right: 18px; z-index: 4000; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
        .kp-toast { position: relative; overflow: hidden; display: flex; align-items: center; gap: 12px; min-width: 290px; max-width: 390px; padding: 14px 16px; border-radius: 12px; color: #fff; font-size: var(--kp-fs-base); font-weight: 600; box-shadow: 0 12px 32px rgba(0, 0, 0, .20); pointer-events: auto; transform: translateX(120%); opacity: 0; transition: transform .45s cubic-bezier(.22, 1, .36, 1), opacity .35s; }
        .kp-toast.show { transform: translateX(0); opacity: 1; }
        .kp-toast.hide { transform: translateX(120%); opacity: 0; }
        .kp-toast--success { background: #16a34a; }   /* vrai vert */
        .kp-toast--error { background: #dc2626; }      /* vrai rouge */
        .kp-toast__icon { width: 30px; height: 30px; border-radius: 50%; background: rgba(255, 255, 255, .22); display: inline-flex; align-items: center; justify-content: center; font-size: var(--kp-fs-lg); flex-shrink: 0; }
        .kp-toast__msg { flex: 1; line-height: 1.35; }
        .kp-toast__close { background: none; border: none; color: rgba(255, 255, 255, .85); cursor: pointer; font-size: var(--kp-fs-lg); padding: 0; flex-shrink: 0; line-height: 1; }
        .kp-toast__close:hover { color: #fff; }
        .kp-toast__bar { position: absolute; left: 0; bottom: 0; height: 3px; background: rgba(255, 255, 255, .55); animation: kptoastbar linear forwards; }
        @keyframes kptoastbar { from { width: 100%; } to { width: 0; } }
        @media (max-width: 575px) { .kp-toast-wrap { left: 14px; right: 14px; top: 14px; } .kp-toast { min-width: 0; max-width: none; } }

        /* ===== Modal de confirmation global (style unique, réf. = modal candidat) ===== */
        .kpc-overlay { display: none; position: fixed; inset: 0; background: rgba(11, 18, 32, .5); z-index: 3600; align-items: center; justify-content: center; padding: 20px; }
        .kpc-overlay.active { display: flex; }
        .kpc-container { background: #fff; border-radius: 18px; padding: 28px; max-width: 420px; width: 100%; text-align: center; position: relative; box-shadow: 0 24px 60px rgba(0, 0, 0, .25); }
        .kpc-close { position: absolute; top: 12px; right: 16px; background: none; border: none; font-size: var(--kp-fs-2xl); color: var(--kp-muted); cursor: pointer; line-height: 1; }
        .kpc-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-2xl); margin: 0 auto 16px; }
        .kpc-icon.danger { background: #fee2e2; color: #e02c18; }
        .kpc-icon.success { background: #d1fae5; color: #10b981; }
        .kpc-icon.warning { background: #fff3cd; color: #b8860b; }
        .kpc-title { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 10px; }
        .kpc-message { color: var(--kp-text); font-size: var(--kp-fs-base); line-height: 1.55; margin: 0 0 22px; }
        .kpc-buttons { display: flex; gap: 10px; }
        .kpc-btn { flex: 1; padding: 11px; border-radius: 10px; font-weight: 600; font-size: var(--kp-fs-base); cursor: pointer; border: none; }
        .kpc-btn.cancel { background: var(--kp-surface); color: var(--kp-ink); }
        .kpc-btn.confirm { background: #e02c18; color: #fff; }

        @media (max-width: 991px) {
            .dash-sidebar { transform: translateX(-100%); box-shadow: var(--kp-shadow-lg); }
            .dash-sidebar.open { transform: translateX(0); }
            .dash-main { margin-left: 0; }
            .dash-burger { display: inline-flex; }
            .dash-collapse, .dash-sidebar__toggle { display: none; }
            .dash-backdrop.show { display: block; }
            .dash-content { padding: 20px 16px; }
            .dash-header { left: 0; padding: 12px 18px; }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="dash">
        @include('layouts.partials.sidebar')

        <div class="dash-main">
            @include('layouts.partials.header')

            <main class="dash-content">
                <div class="dash-content__inner">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <div class="dash-backdrop" id="dashBackdrop"></div>

    {{-- Modal de confirmation global (suppression, etc.) — style unique --}}
    <div class="kpc-overlay" id="kpConfirmModal">
        <div class="kpc-container">
            <button type="button" class="kpc-close" onclick="kpConfirmClose()" aria-label="Fermer">&times;</button>
            <div class="kpc-icon danger" id="kpcIcon"><i class="fas fa-trash-alt"></i></div>
            <h2 class="kpc-title" id="kpcTitle">Confirmation</h2>
            <p class="kpc-message" id="kpcMessage"></p>
            <div class="kpc-buttons">
                <button type="button" class="kpc-btn cancel" onclick="kpConfirmClose()">Annuler</button>
                <button type="button" class="kpc-btn confirm" id="kpcConfirmBtn">Confirmer</button>
            </div>
        </div>
    </div>

    @auth
        @if (auth()->user()->isEtudiant())
            <div class="kp-cmodal" id="createAnnonceModal">
                <div class="kp-cmodal__overlay" onclick="closeCreateAnnonceModal()"></div>
                <div class="kp-cmodal__dialog">
                    <button type="button" class="kp-cmodal__close" onclick="closeCreateAnnonceModal()" aria-label="Fermer"><i class="bi bi-x-lg"></i></button>
                    @php $subjects = \App\Models\Subject::orderBy('nom')->get(); @endphp
                    @include('annonces.partials.create-form')

                    {{-- Overrides : modal plus moderne, soft, minimaliste --}}
                    <style>
                        #createAnnonceModal .create-annonce-container { background: #fff; border: none; border-radius: 0; box-shadow: none; max-width: 100%; min-height: 100%; backdrop-filter: none; }
                        #createAnnonceModal .annonce-header { background: #fff; color: var(--kp-ink); padding: 22px 24px 4px; }
                        #createAnnonceModal .annonce-header::before { display: none; }
                        #createAnnonceModal .annonce-header h1 { font-size: var(--kp-fs-xl); color: var(--kp-ink); gap: 9px; }
                        #createAnnonceModal .annonce-header h1 i { color: var(--kp-blue); }
                        #createAnnonceModal .annonce-header p { font-size: var(--kp-fs-sm); color: var(--kp-muted); }
                        #createAnnonceModal .info-banner { margin: 14px 24px 0; padding: 11px 14px; border-radius: 12px; font-size: var(--kp-fs-xs); }
                        #createAnnonceModal .annonce-form { padding: 16px 24px 24px; }
                        #createAnnonceModal .form-section { padding: 16px; border-radius: 14px; margin-bottom: 14px; box-shadow: none; border: 1px solid var(--kp-border); }
                        #createAnnonceModal .form-section:hover { box-shadow: none; }
                        #createAnnonceModal .form-section h2 { font-size: var(--kp-fs-md); margin-bottom: 14px; }
                        #createAnnonceModal .form-group { margin-bottom: 14px; }
                        #createAnnonceModal .form-group label { font-size: var(--kp-fs-sm); margin-bottom: 6px; }
                        #createAnnonceModal .form-group input,
                        #createAnnonceModal .form-group select,
                        #createAnnonceModal .form-group textarea,
                        #createAnnonceModal .custom-select-search { padding: 10px 13px; font-size: var(--kp-fs-base); border-radius: 10px; border-width: 1px; }
                        #createAnnonceModal .form-group textarea { min-height: 78px; }
                        #createAnnonceModal .radio-label { padding: 12px 8px; border-radius: 10px; border-width: 1px; }
                        #createAnnonceModal .radio-icon { font-size: var(--kp-fs-lg); margin-bottom: 6px; }
                        #createAnnonceModal .radio-text { font-size: var(--kp-fs-xs); }
                        #createAnnonceModal .budget-preview { padding: 16px; border-radius: 14px; }
                        #createAnnonceModal .add-disponibilite-btn { padding: 9px 16px; font-size: var(--kp-fs-sm); border-radius: 9px; }
                        #createAnnonceModal .form-actions { gap: 12px; margin-top: 20px; padding-top: 18px; }
                        #createAnnonceModal .btn-submit,
                        #createAnnonceModal .btn-cancel { padding: 11px 22px; font-size: var(--kp-fs-base); border-radius: 30px; }
                    </style>
                </div>
            </div>

            {{-- Paiement de l'acompte : panneau latéral droit --}}
            <div class="kp-pmodal" id="paymentDrawer">
                <div class="kp-pmodal__overlay" onclick="closePaymentDrawer()"></div>
                <div class="kp-pmodal__dialog">
                    <button type="button" class="kp-cmodal__close" onclick="closePaymentDrawer()" aria-label="Fermer"><i class="bi bi-x-lg"></i></button>
                    <div class="kpp-wrap">
                        <div class="kpp-head">
                            <h2><i class="fas fa-credit-card"></i> Paiement de l'acompte</h2>
                            <p>Finalisez votre annonce en réglant l'acompte.</p>
                        </div>
                        <div class="kpp-summary">
                            <h3>Résumé de l'annonce</h3>
                            <div class="kpp-row"><span>Matière</span><span id="pd-matiere">—</span></div>
                            <div class="kpp-row"><span>Format</span><span id="pd-format">—</span></div>
                            <div class="kpp-row"><span>Disponibilités</span><span id="pd-dispo">—</span></div>
                            <div class="kpp-row"><span>Budget total</span><span id="pd-budget">—</span></div>
                        </div>
                        <div class="kpp-amount">
                            <div class="lbl">Acompte à régler</div>
                            <div class="val" id="pd-acompte">—</div>
                            <div class="note" id="pd-note"></div>
                        </div>
                        <ul class="kpp-instructions">
                            <li>L'acompte sera déduit du montant total à payer au tuteur.</li>
                            <li>Votre annonce sera visible par les tuteurs après paiement.</li>
                        </ul>
                        <button type="button" class="kpp-pay" id="pd-pay"><i class="fas fa-lock"></i> <span>Payer maintenant</span></button>
                        <div class="kpp-secure"><i class="fas fa-shield-alt"></i> Paiement 100% sécurisé via Moneroo</div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('layouts.partials.scripts')

    <script>
        (function () {
            const sidebar = document.getElementById('dashSidebar');
            const burger = document.getElementById('dashBurger');
            const backdrop = document.getElementById('dashBackdrop');
            function closeSidebar() { sidebar && sidebar.classList.remove('open'); backdrop && backdrop.classList.remove('show'); }
            if (burger) burger.addEventListener('click', () => { sidebar.classList.toggle('open'); backdrop.classList.toggle('show'); });
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            // Repli / dépli de la sidebar (desktop) + mémorisation
            const dash = document.querySelector('.dash');
            const collapseBtn = document.getElementById('dashCollapse');
            if (dash && collapseBtn) {
                if (localStorage.getItem('dashCollapsed') === '1') dash.classList.add('is-collapsed');
                collapseBtn.addEventListener('click', () => {
                    dash.classList.toggle('is-collapsed');
                    localStorage.setItem('dashCollapsed', dash.classList.contains('is-collapsed') ? '1' : '0');
                });
            }

            // Modal « Publier une annonce »
            window.openCreateAnnonceModal = function () {
                const m = document.getElementById('createAnnonceModal');
                if (m) {
                    document.documentElement.style.overflow = 'hidden';
                    document.body.style.overflow = 'hidden';
                    m.classList.add('open');
                    const dlg = m.querySelector('.kp-cmodal__dialog');
                    if (dlg) dlg.scrollTop = 0;
                }
            };
            window.closeCreateAnnonceModal = function () {
                const m = document.getElementById('createAnnonceModal');
                if (m) {
                    m.classList.remove('open');
                    document.documentElement.style.overflow = '';
                    document.body.style.overflow = '';
                }
            };
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { window.closeCreateAnnonceModal(); if (window.closePaymentDrawer) window.closePaymentDrawer(); if (window.kpConfirmClose) window.kpConfirmClose(); } });

            // Drawer « Paiement de l'acompte »
            let pdAnnonceId = null;
            window.openPaymentDrawer = function (data) {
                const drawer = document.getElementById('paymentDrawer');
                if (!drawer) return;
                pdAnnonceId = data.annonceId;
                const fmt = data.format === 'presentiel' ? 'Présentiel'
                    : (data.format === 'en_ligne' ? 'En ligne'
                    : (data.format === 'hybride' ? 'Hybride' : (data.format || '—')));
                document.getElementById('pd-matiere').textContent = data.matiere || '—';
                document.getElementById('pd-format').textContent = fmt;
                document.getElementById('pd-dispo').textContent = data.disponibilite || '—';
                document.getElementById('pd-budget').textContent = data.budget || '—';
                document.getElementById('pd-acompte').textContent = data.acompte || '—';
                document.getElementById('pd-note').textContent = data.note || '';
                const btn = document.getElementById('pd-pay');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock"></i> <span>Payer ' + (data.acompte || 'maintenant') + '</span>';
                document.documentElement.style.overflow = 'hidden';
                document.body.style.overflow = 'hidden';
                drawer.classList.add('open');
                const dlg = drawer.querySelector('.kp-pmodal__dialog');
                if (dlg) dlg.scrollTop = 0;
            };
            window.closePaymentDrawer = function () {
                const drawer = document.getElementById('paymentDrawer');
                if (!drawer) return;
                drawer.classList.remove('open');
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
            };
            const pdPay = document.getElementById('pd-pay');
            if (pdPay) {
                pdPay.addEventListener('click', async function () {
                    if (!pdAnnonceId) return;
                    const original = pdPay.innerHTML;
                    pdPay.disabled = true;
                    pdPay.innerHTML = '<span class="kpp-spin"></span> Initialisation...';
                    try {
                        const res = await fetch('/annonces/' + pdAnnonceId + '/init-payment-moneroo', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();
                        if (data.success && data.checkout_url) {
                            window.location.href = data.checkout_url;
                        } else {
                            window.kpToast('error', data.message || 'Impossible d\'initialiser le paiement');
                            pdPay.disabled = false;
                            pdPay.innerHTML = original;
                        }
                    } catch (e) {
                        console.error('Erreur:', e);
                        window.kpToast('error', 'Une erreur est survenue lors de l\'initialisation du paiement');
                        pdPay.disabled = false;
                        pdPay.innerHTML = original;
                    }
                });
            }

            // Notification toast animée (succès vert / erreur rouge)
            window.kpToast = function (type, message, opts) {
                opts = opts || {};
                let wrap = document.getElementById('kpToastWrap');
                if (!wrap) {
                    wrap = document.createElement('div');
                    wrap.id = 'kpToastWrap';
                    wrap.className = 'kp-toast-wrap';
                    document.body.appendChild(wrap);
                }
                const isError = type === 'error';
                const duration = opts.duration || 4500;
                const toast = document.createElement('div');
                toast.className = 'kp-toast kp-toast--' + (isError ? 'error' : 'success');
                toast.innerHTML =
                    '<span class="kp-toast__icon"><i class="fas ' + (isError ? 'fa-circle-xmark' : 'fa-circle-check') + '"></i></span>' +
                    '<span class="kp-toast__msg"></span>' +
                    '<button type="button" class="kp-toast__close" aria-label="Fermer"><i class="fas fa-xmark"></i></button>' +
                    '<span class="kp-toast__bar" style="animation-duration:' + duration + 'ms"></span>';
                toast.querySelector('.kp-toast__msg').textContent = message;
                wrap.appendChild(toast);
                requestAnimationFrame(function () { toast.classList.add('show'); });
                let timer = setTimeout(remove, duration);
                function remove() {
                    clearTimeout(timer);
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    setTimeout(function () { toast.remove(); }, 450);
                }
                toast.querySelector('.kp-toast__close').addEventListener('click', remove);
            };

            // Confirmation stylisée (modal unique, même style que accepter/refuser candidat)
            window.kpConfirmClose = function () {
                const m = document.getElementById('kpConfirmModal');
                if (m) m.classList.remove('active');
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
            };
            window.kpConfirmDelete = function (e, form, opts) {
                if (e) e.preventDefault();
                opts = opts || {};
                const m = document.getElementById('kpConfirmModal');
                if (!m) { form.submit(); return false; }
                const icon = document.getElementById('kpcIcon');
                icon.className = 'kpc-icon ' + (opts.icon || 'danger');
                icon.innerHTML = '<i class="fas ' + (opts.iconClass || 'fa-trash-alt') + '"></i>';
                document.getElementById('kpcTitle').textContent = opts.title || 'Confirmer la suppression';
                document.getElementById('kpcMessage').textContent = opts.text || 'Cette action est irréversible.';
                const btn = document.getElementById('kpcConfirmBtn');
                btn.textContent = opts.confirmText || 'Oui, supprimer';
                btn.style.background = opts.confirmColor || '';
                btn.onclick = function () { window.kpConfirmClose(); form.submit(); };
                document.documentElement.style.overflow = 'hidden';
                document.body.style.overflow = 'hidden';
                m.classList.add('active');
                return false;
            };
            (function () {
                const m = document.getElementById('kpConfirmModal');
                if (m) m.addEventListener('click', function (e) { if (e.target === m) window.kpConfirmClose(); });
            })();

            const user = document.getElementById('dashUser');
            const userMenu = document.getElementById('dashUserMenu');
            if (user && userMenu) {
                user.addEventListener('click', (e) => { e.stopPropagation(); userMenu.classList.toggle('open'); });
                document.addEventListener('click', () => userMenu.classList.remove('open'));
            }
        })();
    </script>

    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if (session('success'))
                    window.kpToast('success', @json(session('success')));
                @elseif (session('error'))
                    window.kpToast('error', @json(session('error')));
                @endif
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>
