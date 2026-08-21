@extends('layouts.welcomeLayout')

@section('title', 'Blog Kopiao — Conseils et actualités')
@section('meta_description', 'Conseils pour trouver le bon tuteur, réussir ses cours particuliers et actualités de la plateforme Kopiao.')

@section('content')
<style>
    .blog-page { background: var(--kp-surface); padding: 40px 0 70px; }
    .blog-hero { text-align: center; max-width: 680px; margin: 0 auto 40px; padding: 0 16px; }
    .blog-eyebrow {
        display: inline-block; font-size: .74rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
        color: var(--kp-blue); background: var(--kp-blue-soft); padding: 5px 14px; border-radius: var(--kp-radius-pill); margin-bottom: 16px;
    }
    .blog-title { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.9rem, 1.3rem + 2.6vw, 2.7rem); color: var(--kp-ink); margin: 0 0 12px; }
    .blog-sub { color: var(--kp-muted); font-size: 1.02rem; margin: 0; }

    /* Mise en page magazine */
    .blog-magazine { display: grid; grid-template-columns: 1.6fr 1fr; gap: 28px; max-width: 1140px; margin: 0 auto; padding: 0 16px; align-items: stretch; }
    @media (max-width: 900px) { .blog-magazine { grid-template-columns: 1fr; } }

    /* Article à la une */
    .blog-featured {
        position: relative; display: flex; align-items: flex-end; min-height: 460px;
        border-radius: var(--kp-radius); overflow: hidden; text-decoration: none; color: #fff;
        background: var(--kp-blue-soft) center/cover no-repeat; box-shadow: var(--kp-shadow-sm);
        transition: box-shadow .3s ease;
    }
    .blog-featured:hover { box-shadow: var(--kp-shadow-lg); }
    .blog-featured::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(15, 17, 22, 0) 30%, rgba(15, 17, 22, .88) 100%);
    }
    .blog-featured__badge {
        position: absolute; top: 18px; left: 18px; z-index: 1;
        background: var(--kp-blue); color: #fff; font-size: .72rem; font-weight: 700; letter-spacing: .4px;
        text-transform: uppercase; padding: 5px 12px; border-radius: var(--kp-radius-pill);
    }
    .blog-featured__body { position: relative; z-index: 1; padding: 32px; }
    .blog-featured__meta { font-size: .82rem; opacity: .88; margin: 0 0 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
    .blog-featured__title { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.35rem, 1rem + 1.8vw, 1.9rem); line-height: 1.28; margin: 0 0 10px; color: #fff; }
    .blog-featured__excerpt { font-size: .95rem; opacity: .92; margin: 0; max-width: 540px; line-height: 1.6; }

    /* Colonne "Articles récents" */
    .blog-recent__title { font-family: var(--kp-font-title); font-weight: 700; font-size: 1.05rem; color: var(--kp-ink); margin: 0 0 16px; }
    .blog-recent__viewport { position: relative; overflow: hidden; max-height: 460px; }
    .blog-recent__viewport::after {
        content: ''; position: absolute; left: 0; right: 0; bottom: 0; height: 40px; pointer-events: none;
        background: linear-gradient(180deg, rgba(247, 248, 250, 0), var(--kp-surface));
    }
    .blog-recent__track { display: flex; flex-direction: column; gap: 12px; will-change: transform; }
    .blog-mini-card {
        display: flex; gap: 14px; align-items: center; text-decoration: none; color: inherit;
        background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: 12px; padding: 10px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }
    .blog-mini-card:hover { border-color: color-mix(in srgb, var(--kp-blue), transparent 65%); box-shadow: var(--kp-shadow-sm); }
    .blog-mini-card__thumb { width: 72px; height: 72px; border-radius: 10px; object-fit: cover; flex-shrink: 0; background: var(--kp-blue-soft); }
    .blog-mini-card__thumb-placeholder {
        width: 72px; height: 72px; border-radius: 10px; flex-shrink: 0; background: var(--kp-blue-soft); color: var(--kp-blue);
        display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
    }
    .blog-mini-card__title { font-weight: 700; font-size: .88rem; color: var(--kp-ink); margin: 0 0 4px; line-height: 1.35; }
    .blog-mini-card__date { font-size: .76rem; color: var(--kp-muted); margin: 0; }

    @media (max-width: 900px) {
        .blog-recent__viewport { max-height: none; overflow: visible; }
        .blog-recent__viewport::after { display: none; }
        .blog-recent__track { transform: none !important; }
    }

    .blog-empty {
        text-align: center; color: var(--kp-muted); max-width: 480px; margin: 0 auto; padding: 60px 32px;
        background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: var(--kp-radius); box-shadow: var(--kp-shadow-sm);
    }
    .blog-empty i { font-size: 2.4rem; color: var(--kp-blue-soft); display: block; margin-bottom: 14px; }
    .blog-empty p { font-size: 1rem; margin: 0; }
</style>

<div class="blog-page">
    <div class="container">
        <div class="blog-hero" data-aos="fade-up">
            <span class="blog-eyebrow">Blog Kopiao</span>
            <h1 class="blog-title">Conseils et actualités</h1>
            <p class="blog-sub">Nos astuces pour bien choisir un tuteur, réussir ses cours particuliers et suivre les nouveautés de la plateforme.</p>
        </div>

        @if (! $featured)
            <div class="blog-empty" data-aos="fade-up">
                <i class="bi bi-journal-text"></i>
                <p>Aucun article publié pour le moment. Revenez bientôt !</p>
            </div>
        @else
            <div class="blog-magazine">
                <a href="{{ route('blog.show', $featured) }}" class="blog-featured"
                   @if ($featured->cover_path) style="background-image: url('{{ asset('storage/'.$featured->cover_path) }}');" @endif
                   data-aos="fade-right">
                    <span class="blog-featured__badge">À la une</span>
                    <div class="blog-featured__body">
                        <p class="blog-featured__meta">
                            <span>{{ $featured->published_at?->translatedFormat('d M Y') }}</span>
                            @if ($featured->author)
                                <span>&middot; Par {{ $featured->author->firstname }} {{ $featured->author->lastname }}</span>
                            @endif
                        </p>
                        <h2 class="blog-featured__title">{{ $featured->title }}</h2>
                        @if ($featured->excerpt)
                            <p class="blog-featured__excerpt">{{ \Illuminate\Support\Str::limit($featured->excerpt, 160) }}</p>
                        @endif
                    </div>
                </a>

                <div class="blog-recent" data-aos="fade-left">
                    <h3 class="blog-recent__title">Articles récents</h3>

                    @if ($recentArticles->isEmpty())
                        <p class="text-muted small">D'autres articles arrivent bientôt.</p>
                    @else
                        <div class="blog-recent__viewport" id="blogRecentViewport">
                            <div class="blog-recent__track" id="blogRecentTrack">
                                @foreach ($recentArticles as $article)
                                    <a href="{{ route('blog.show', $article) }}" class="blog-mini-card">
                                        @if ($article->cover_path)
                                            <img src="{{ asset('storage/'.$article->cover_path) }}" alt="{{ $article->title }}" class="blog-mini-card__thumb">
                                        @else
                                            <div class="blog-mini-card__thumb-placeholder"><i class="bi bi-journal-text"></i></div>
                                        @endif
                                        <div>
                                            <p class="blog-mini-card__title">{{ $article->title }}</p>
                                            <p class="blog-mini-card__date">{{ $article->published_at?->translatedFormat('d M Y') }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    (function () {
        const viewport = document.getElementById('blogRecentViewport');
        const track = document.getElementById('blogRecentTrack');
        if (!viewport || !track) return;
        if (!window.matchMedia('(min-width: 901px)').matches) return;
        if (track.scrollHeight <= viewport.clientHeight) return;

        // Boucle sans fin : le contenu est duplique une fois, puis on translate
        // en continu jusqu'a la moitie (identique au depart) avant de revenir a 0.
        track.innerHTML += track.innerHTML;

        let position = 0;
        let paused = false;
        const speed = 0.35; // pixels par frame (~21px/s a 60fps)

        viewport.addEventListener('mouseenter', () => { paused = true; });
        viewport.addEventListener('mouseleave', () => { paused = false; });

        function loop() {
            if (!paused) {
                position += speed;
                const halfHeight = track.scrollHeight / 2;
                if (position >= halfHeight) {
                    position -= halfHeight;
                }
                track.style.transform = 'translateY(-' + position + 'px)';
            }
            requestAnimationFrame(loop);
        }

        requestAnimationFrame(loop);
    })();
</script>
@endsection
