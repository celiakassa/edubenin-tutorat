@extends('layouts.welcomeLayout')

@section('content')
<style>
    .dt-page { background: var(--kp-surface); padding: 40px 0 70px; }

    /* Hero */
    .dt-hero { text-align: center; max-width: 720px; margin: 0 auto 56px; padding: 0 16px; }
    .dt-eyebrow {
        display: inline-block; font-size: .74rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
        color: var(--kp-blue); background: var(--kp-blue-soft); padding: 5px 14px; border-radius: var(--kp-radius-pill); margin-bottom: 16px;
    }
    .dt-title { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.9rem, 1.3rem + 2.6vw, 2.7rem); color: var(--kp-ink); margin: 0 0 14px; }
    .dt-sub { color: var(--kp-muted); font-size: 1.05rem; margin: 0 0 28px; }
    .dt-cta-group { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    /* Sections communes */
    .dt-section { max-width: 1100px; margin: 0 auto 64px; padding: 0 16px; }
    .dt-section-title { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.4rem, 1.1rem + 1.2vw, 1.9rem); color: var(--kp-ink); text-align: center; margin: 0 0 10px; }
    .dt-section-sub { color: var(--kp-muted); text-align: center; max-width: 560px; margin: 0 auto 36px; }

    /* Chiffres clés */
    .dt-stats { max-width: 940px; margin: 0 auto 56px; padding: 0 16px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; justify-items: center; }
    @media (max-width: 640px) { .dt-stats { grid-template-columns: 1fr; } }
    .dt-stat {
        width: 100%; background: linear-gradient(160deg, var(--kp-blue-soft), var(--kp-white) 65%);
        border: 1px solid var(--kp-border); border-radius: var(--kp-radius);
        box-shadow: var(--kp-shadow-sm); padding: 28px 20px; text-align: center;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .dt-stat:hover { transform: translateY(-4px); box-shadow: var(--kp-shadow-lg); }
    .dt-stat-icon {
        width: 48px; height: 48px; border-radius: 50%; margin: 0 auto 14px; background: var(--kp-white); color: var(--kp-blue);
        display: flex; align-items: center; justify-content: center; font-size: 1.3rem; box-shadow: var(--kp-shadow-sm);
    }
    .dt-stat-number { font-family: var(--kp-font-title); font-weight: 800; font-size: 2.3rem; color: var(--kp-blue); line-height: 1; margin: 0 0 8px; }
    .dt-stat-label { color: var(--kp-muted); font-size: .86rem; letter-spacing: .3px; margin: 0; }

    /* Étapes */
    .dt-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    @media (max-width: 900px) { .dt-steps { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .dt-steps { grid-template-columns: 1fr; } }
    .dt-step {
        background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: var(--kp-radius);
        box-shadow: var(--kp-shadow-sm); padding: 26px 20px; text-align: center; position: relative;
    }
    .dt-step-num {
        width: 40px; height: 40px; border-radius: 50%; background: var(--kp-blue); color: #fff;
        display: flex; align-items: center; justify-content: center; font-weight: 700; margin: 0 auto 16px;
    }
    .dt-step h3 { font-family: var(--kp-font-title); font-size: 1.05rem; font-weight: 700; color: var(--kp-ink); margin: 0 0 8px; }
    .dt-step p { color: var(--kp-muted); font-size: .92rem; margin: 0; line-height: 1.6; }

    /* Avantages */
    .dt-benefits { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    @media (max-width: 900px) { .dt-benefits { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .dt-benefits { grid-template-columns: 1fr; } }
    .dt-benefit {
        background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: var(--kp-radius);
        box-shadow: var(--kp-shadow-sm); padding: 24px 22px; display: flex; gap: 16px; align-items: flex-start;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .dt-benefit:hover { transform: translateY(-6px); box-shadow: var(--kp-shadow-lg); }
    .dt-benefit i {
        flex-shrink: 0; width: 44px; height: 44px; border-radius: 12px; background: var(--kp-blue-soft); color: var(--kp-blue);
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }
    .dt-benefit h3 { font-family: var(--kp-font-title); font-size: 1rem; font-weight: 700; color: var(--kp-ink); margin: 0 0 6px; }
    .dt-benefit p { color: var(--kp-muted); font-size: .9rem; margin: 0; line-height: 1.6; }

    /* Tuteurs récents */
    .dt-tutors { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    @media (max-width: 900px) { .dt-tutors { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .dt-tutors { grid-template-columns: 1fr; } }
    .dt-tutor-card {
        background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: var(--kp-radius);
        box-shadow: var(--kp-shadow-sm); padding: 24px 18px; text-align: center; transition: var(--kp-transition);
    }
    .dt-tutor-card:hover { box-shadow: var(--kp-shadow); transform: translateY(-3px); }
    .dt-tutor-avatar {
        width: 72px; height: 72px; border-radius: 50%; margin: 0 auto 14px; overflow: hidden;
        background: var(--kp-blue-soft); color: var(--kp-blue); display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1.3rem;
    }
    .dt-tutor-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .dt-tutor-card h3 { font-family: var(--kp-font-title); font-size: .98rem; font-weight: 700; color: var(--kp-ink); margin: 0 0 8px; }
    .dt-tutor-subjects { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; }
    .dt-tutor-subjects span {
        background: var(--kp-surface); border: 1px solid var(--kp-border); color: var(--kp-text);
        font-size: .74rem; font-weight: 600; padding: 3px 10px; border-radius: var(--kp-radius-pill);
    }
    .dt-tutors-empty { text-align: center; color: var(--kp-muted); padding: 30px 0; }

    /* CTA finale */
    .dt-final-cta {
        max-width: 900px; margin: 0 auto; padding: 44px 32px; text-align: center; border-radius: var(--kp-radius);
        background: linear-gradient(135deg, var(--kp-blue), var(--kp-blue-dark)); color: #fff;
    }
    .dt-final-cta h2 { font-family: var(--kp-font-title); font-weight: 800; font-size: 1.6rem; margin: 0 0 10px; }
    .dt-final-cta p { opacity: .92; margin: 0 0 22px; }
    .dt-final-cta .kp-btn--on-blue { animation: dt-pulse 2.6s ease-in-out infinite; }
    @keyframes dt-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, .45); }
        50% { box-shadow: 0 0 0 12px rgba(255, 255, 255, 0); }
    }
</style>

<div class="dt-page">
    <div class="container">

        <!-- Hero -->
        <div class="dt-hero" data-aos="fade-up">
            <span class="dt-eyebrow">Rejoignez la communauté Kopiao</span>
            <h1 class="dt-title">Devenez tuteur et partagez votre savoir</h1>
            <p class="dt-sub">Vous maîtrisez une matière et aimez transmettre ? Aidez des élèves et étudiants à
                progresser, tout en étant rémunéré selon vos disponibilités.</p>
            <div class="dt-cta-group">
                <a href="{{ route('register.tuteur') }}" class="kp-btn kp-btn--accent">
                    <i class="bi bi-mortarboard me-2"></i>Je deviens tuteur
                </a>
                <a href="{{ route('faq') }}" class="kp-btn kp-btn--secondary">
                    Comment ça marche ?
                </a>
            </div>
        </div>

        <!-- Chiffres clés -->
        <div class="dt-stats" id="dtStats" data-aos="fade-up">
            <div class="dt-stat">
                <div class="dt-stat-icon"><i class="bi bi-mortarboard"></i></div>
                <p class="dt-stat-number" data-count="{{ $stats['tutorsCount'] }}">0</p>
                <p class="dt-stat-label">Tuteurs actifs</p>
            </div>
            <div class="dt-stat">
                <div class="dt-stat-icon"><i class="bi bi-journal-bookmark"></i></div>
                <p class="dt-stat-number" data-count="{{ $stats['subjectsCount'] }}">0</p>
                <p class="dt-stat-label">Matières disponibles</p>
            </div>
            <div class="dt-stat">
                <div class="dt-stat-icon"><i class="bi bi-award"></i></div>
                <p class="dt-stat-number" data-count="{{ $stats['missionsCount'] }}">0</p>
                <p class="dt-stat-label">Missions honorées</p>
            </div>
        </div>

        <!-- Étapes -->
        <div class="dt-section">
            <h2 class="dt-section-title" data-aos="fade-up">Le parcours pour devenir tuteur</h2>
            <p class="dt-section-sub" data-aos="fade-up">Quatre étapes simples entre votre inscription et vos premiers cours.</p>
            <div class="dt-steps">
                <div class="dt-step" data-aos="fade-up" data-aos-delay="0">
                    <div class="dt-step-num">1</div>
                    <h3>Inscription</h3>
                    <p>Créez votre compte tuteur en quelques secondes avec vos coordonnées.</p>
                </div>
                <div class="dt-step" data-aos="fade-up" data-aos-delay="100">
                    <div class="dt-step-num">2</div>
                    <h3>Profil</h3>
                    <p>Complétez votre profil : matières enseignées, qualifications, tarif, disponibilités.</p>
                </div>
                <div class="dt-step" data-aos="fade-up" data-aos-delay="200">
                    <div class="dt-step-num">3</div>
                    <h3>Validation</h3>
                    <p>Notre équipe vérifie votre profil pour garantir la confiance des apprenants.</p>
                </div>
                <div class="dt-step" data-aos="fade-up" data-aos-delay="300">
                    <div class="dt-step-num">4</div>
                    <h3>Premiers cours</h3>
                    <p>Postulez aux annonces qui correspondent à vos matières et démarrez vos cours.</p>
                </div>
            </div>
        </div>

        <!-- Avantages -->
        <div class="dt-section">
            <h2 class="dt-section-title" data-aos="fade-up">Pourquoi devenir tuteur sur Kopiao ?</h2>
            <p class="dt-section-sub" data-aos="fade-up">Des avantages concrets pensés pour les tuteurs.</p>
            <div class="dt-benefits">
                <div class="dt-benefit" data-aos="fade-up" data-aos-delay="0">
                    <i class="bi bi-cash-coin"></i>
                    <div>
                        <h3>Un revenu complémentaire</h3>
                        <p>Fixez votre propre tarif horaire et soyez payé pour chaque mission acceptée.</p>
                    </div>
                </div>
                <div class="dt-benefit" data-aos="fade-up" data-aos-delay="100">
                    <i class="bi bi-calendar2-check"></i>
                    <div>
                        <h3>Des horaires flexibles</h3>
                        <p>Choisissez vos disponibilités et le nombre d'élèves que vous souhaitez accompagner.</p>
                    </div>
                </div>
                <div class="dt-benefit" data-aos="fade-up" data-aos-delay="200">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <h3>Un acompte garanti</h3>
                        <p>Chaque annonce est déjà partiellement payée par l'élève avant même votre première séance.</p>
                    </div>
                </div>
                <div class="dt-benefit" data-aos="fade-up" data-aos-delay="300">
                    <i class="bi bi-people"></i>
                    <div>
                        <h3>Des demandes ciblées</h3>
                        <p>Vous ne voyez que les annonces correspondant à vos matières et domaines d'expertise.</p>
                    </div>
                </div>
                <div class="dt-benefit" data-aos="fade-up" data-aos-delay="400">
                    <i class="bi bi-graph-up-arrow"></i>
                    <div>
                        <h3>Une visibilité croissante</h3>
                        <p>Les avis des élèves et votre historique de cours renforcent votre profil au fil du temps.</p>
                    </div>
                </div>
                <div class="dt-benefit" data-aos="fade-up" data-aos-delay="500">
                    <i class="bi bi-headset"></i>
                    <div>
                        <h3>Un accompagnement dédié</h3>
                        <p>Notre équipe support reste disponible pour vous aider à chaque étape.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tuteurs récemment inscrits -->
        <div class="dt-section">
            <h2 class="dt-section-title" data-aos="fade-up">Ils viennent de nous rejoindre</h2>
            <p class="dt-section-sub" data-aos="fade-up">Découvrez les derniers tuteurs inscrits sur la plateforme.</p>

            @if ($recentTutors->isEmpty())
                <div class="dt-tutors-empty">
                    <i class="bi bi-people" style="font-size: 2rem; opacity: .4;"></i>
                    <p class="mt-2 mb-0">Soyez parmi les premiers tuteurs à rejoindre Kopiao !</p>
                </div>
            @else
                <div class="dt-tutors">
                    @foreach ($recentTutors as $tutor)
                        <div class="dt-tutor-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                            <div class="dt-tutor-avatar">
                                @if ($tutor->photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($tutor->photo_path))
                                    <img src="{{ asset('storage/' . $tutor->photo_path) }}" alt="{{ $tutor->firstname }} {{ $tutor->lastname }}">
                                @else
                                    {{ strtoupper(substr($tutor->firstname, 0, 1) . substr($tutor->lastname, 0, 1)) }}
                                @endif
                            </div>
                            <h3>{{ $tutor->firstname }} {{ $tutor->lastname }}</h3>
                            @if ($tutor->subjects->isNotEmpty())
                                <div class="dt-tutor-subjects">
                                    @foreach ($tutor->subjects->take(3) as $subject)
                                        <span>{{ $subject->nom }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- CTA finale -->
        <div class="dt-final-cta" data-aos="fade-up">
            <h2>Prêt à partager votre savoir ?</h2>
            <p>Rejoignez les tuteurs de Kopiao et commencez à accompagner des apprenants dès aujourd'hui.</p>
            <a href="{{ route('register.tuteur') }}" class="kp-btn kp-btn--on-blue">
                <i class="bi bi-mortarboard me-2"></i>Je m'inscris comme tuteur
            </a>
        </div>

    </div>
</div>

<script>
    (function () {
        const statsSection = document.getElementById('dtStats');
        if (!statsSection) return;

        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-count'), 10) || 0;
            const duration = 1200;
            const start = performance.now();

            function step(now) {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target).toLocaleString('fr-FR');
                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    el.textContent = target.toLocaleString('fr-FR');
                }
            }

            requestAnimationFrame(step);
        }

        const observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                statsSection.querySelectorAll('.dt-stat-number').forEach(animateCounter);
                obs.disconnect();
            });
        }, { threshold: 0.4 });

        observer.observe(statsSection);
    })();
</script>
@endsection
