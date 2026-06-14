    <style>
        /* ===================================================================
           NAVBAR KOPIAO — minimaliste, fond bleu plein, responsive.
           Toutes les couleurs viennent des variables du design system
           (kopiao-ui.css). Aucune valeur hex en dur ici.
           =================================================================== */

        /* Bandeau bleu plein, hauteur stable, sans barre grise interne */
        .header {
            background-color: var(--kp-blue);
            padding: 0;
            z-index: 997;
            box-shadow: var(--kp-shadow-sm);
            transition: none;
        }
        .header .header-container {
            background: transparent;
            border-radius: 0;
            padding-top: 0;
            padding-bottom: 0;
            margin-bottom: 0;
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        /* Logo « Kopiao » en blanc, sans pastille */
        .header .logo,
        .logo {
            background: transparent !important;
            padding: 0;
            border-radius: 0;
            display: inline-flex;
            align-items: center;
            order: 0 !important;            /* neutralise l'inversion de welcome.css */
        }
        .header .logo:hover,
        .logo:hover {
            background: transparent !important;
            transform: none;
        }
        .header .logo h1,
        .logo h1 {
            color: var(--kp-white);
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: .3px;
        }

        /* Liens de navigation (desktop) */
        .desktop-menu {
            display: flex;
            align-items: center;
            gap: .35rem;
            order: 1 !important;
        }
        .nav-link-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            color: rgba(255, 255, 255, .9);
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            border-radius: var(--kp-radius-pill);
            transition: var(--kp-transition);
        }
        .nav-link-item { position: relative; }
        .nav-link-item:hover { color: var(--kp-white); }
        .nav-link-item.is-active { color: var(--kp-white); }
        /* Trait jaune qui se remplit (largeur 0 → pleine) au survol et sur la page active */
        .nav-link-item::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 4px;
            width: 0;
            height: 3px;
            background: var(--kp-yellow);
            border-radius: 3px;
            transform: translateX(-50%);
            transition: width .28s ease;
        }
        .nav-link-item:hover::after,
        .nav-link-item.is-active::after { width: 20px; }

        /* Bouton « Se connecter » : blanc sur bleu */
        .nav-login-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            margin-left: .35rem;
            background: var(--kp-yellow);
            color: #1a1a1a;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border-radius: var(--kp-radius-pill);
            transition: var(--kp-transition);
        }
        .nav-login-btn:hover {
            background: var(--kp-white);
            color: var(--kp-blue);
        }

        /* Menu profil (utilisateur connecté) */
        .nav-profile { position: relative; margin-left: .35rem; }
        .nav-profile__btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            background: none;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--kp-transition);
        }
        .nav-profile__avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--kp-white);
            color: var(--kp-blue);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, .55);
            transition: var(--kp-transition);
        }
        .nav-profile__avatar img { width: 100%; height: 100%; object-fit: cover; }
        .nav-profile__btn:hover .nav-profile__avatar { border-color: var(--kp-white); transform: translateY(-1px); }
        .nav-profile__btn .bi-chevron-down { font-size: 12px; transition: var(--kp-transition); }
        .nav-profile.open .nav-profile__btn .bi-chevron-down { transform: rotate(180deg); }
        .nav-profile__menu {
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            min-width: 220px;
            background: var(--kp-white);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius-sm);
            box-shadow: var(--kp-shadow-lg);
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: var(--kp-transition);
            z-index: 1000;
        }
        .nav-profile.open .nav-profile__menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .nav-profile__item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--kp-text);
            background: none;
            border: none;
            font-size: 14px;
            font-weight: 500;
            text-align: left;
            text-decoration: none;
            cursor: pointer;
            transition: var(--kp-transition);
        }
        .nav-profile__item i { font-size: 1rem; width: 18px; color: var(--kp-muted); }
        .nav-profile__item:hover { background: var(--kp-blue-soft); color: var(--kp-blue-dark); }
        .nav-profile__item:hover i { color: var(--kp-blue); }
        .nav-profile__sep { margin: 6px 4px; border: 0; border-top: 1px solid var(--kp-border); }
        .nav-profile__item--danger { color: #dc3545; }
        .nav-profile__item--danger i { color: #dc3545; }
        .nav-profile__item--danger:hover { background: #fdecec; color: #b02a37; }
        .nav-profile__item--danger:hover i { color: #b02a37; }

        /* ===== Burger (mobile / tablette) — blanc sur bleu, soigné ===== */
        .burger-menu {
            display: none;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            padding: 0;
            background: none;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            z-index: 1001;
            order: 1 !important;
            transition: var(--kp-transition);
        }
        .burger-menu:hover { background: rgba(255, 255, 255, .14); }
        .burger-icon,
        .burger-icon::before,
        .burger-icon::after {
            width: 24px;
            height: 2.5px;
            background-color: var(--kp-white);
            border-radius: 2px;
            transition: all .3s ease;
        }
        .burger-icon { position: relative; display: block; }
        .burger-icon::before,
        .burger-icon::after { content: ''; position: absolute; left: 0; }
        .burger-icon::before { top: -7px; }
        .burger-icon::after { top: 7px; }
        .burger-menu.active .burger-icon { background-color: transparent; }
        .burger-menu.active .burger-icon::before { transform: rotate(45deg); top: 0; }
        .burger-menu.active .burger-icon::after { transform: rotate(-45deg); top: 0; }

        /* ===== Drawer mobile : glisse depuis la DROITE, sous la navbar ===== */
        .sidebar-menu {
            position: fixed;
            top: 64px;
            right: -340px;
            width: 300px;
            max-width: 86vw;
            height: calc(100% - 64px);
            background: var(--kp-blue);
            z-index: 1002;
            transition: right .32s ease;
            box-shadow: -8px 0 28px rgba(0, 0, 0, .18);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .sidebar-menu.active { right: 0; }
        .sidebar-header { display: none; }   /* le drawer démarre déjà sous la navbar */
        .sidebar-links { padding: 14px; display: flex; flex-direction: column; gap: 4px; }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            color: var(--kp-white);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            border-left: none;
            transition: var(--kp-transition);
        }
        .sidebar-link i { font-size: 1.15rem; width: 22px; text-align: center; }
        .sidebar-link span { font-size: 1rem; font-weight: 500; }
        .sidebar-link:hover,
        .sidebar-link:focus,
        .sidebar-link.is-active { background: rgba(255, 255, 255, .14); color: var(--kp-white); }
        .sidebar-link:hover i, .sidebar-link:hover span { color: var(--kp-white); }
        /* CTA « Devenir tuteur » : accent jaune */
        .sidebar-link--cta { background: var(--kp-yellow); color: var(--kp-blue-dark); font-weight: 700; margin-top: 8px; }
        .sidebar-link--cta i, .sidebar-link--cta span { color: var(--kp-blue-dark); font-weight: 700; }
        .sidebar-link--cta:hover,
        .sidebar-link--cta:focus { background: var(--kp-yellow); color: var(--kp-blue-dark); filter: brightness(.95); }
        .sidebar-link--cta:hover i, .sidebar-link--cta:hover span { color: var(--kp-blue-dark); }
        .logout-btn {
            background: none;
            width: 100%;
            text-align: left;
            border: none;
            cursor: pointer;
        }

        /* Overlay : démarre aussi sous la navbar */
        .menu-overlay {
            position: fixed;
            top: 64px;
            left: 0;
            width: 100%;
            height: calc(100% - 64px);
            background: rgba(0, 0, 0, .45);
            z-index: 1001;
            display: none;
        }
        .menu-overlay.active { display: block; }
        body.menu-open { overflow: hidden; }

        /* ===== Breakpoints ===== */
        @media (max-width: 991px) {
            .header .header-container { min-height: 58px; }
            .sidebar-menu { top: 58px; height: calc(100% - 58px); }
            .menu-overlay { top: 58px; height: calc(100% - 58px); }
            .burger-menu { display: inline-flex; }
            .desktop-menu { display: none !important; }
        }
        @media (min-width: 992px) {
            .burger-menu { display: none !important; }
            .desktop-menu { display: flex; }
        }

        /* Animation des liens footer */
        .footer-links ul li a {
            transition: all 0.3s ease;
            display: inline-block;
        }
        .footer-links ul li a:hover {
            color: var(--kp-yellow) !important;
            transform: translateX(5px);
        }

        /* Animation réseaux sociaux */
        .footer .social-links a {
            width: auto;
            height: auto;
            border: none;
            border-radius: 0;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .footer .social-links a:hover {
            transform: translateY(-3px);
            color: var(--kp-yellow) !important;
            border-color: transparent;
        }
    </style>
