@extends('layouts.welcomeLayout')

@section('title', 'Blog Kopiao — Conseils et actualités')
@section('meta_description', 'Conseils pour trouver le bon tuteur, réussir ses cours particuliers et actualités de la plateforme Kopiao.')

@section('content')
<style>
    .blog-page { background: var(--kp-surface); padding: 40px 0 70px; }
    .blog-hero { text-align: center; max-width: 680px; margin: 0 auto 48px; padding: 0 16px; }
    .blog-eyebrow {
        display: inline-block; font-size: .74rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
        color: var(--kp-blue); background: var(--kp-blue-soft); padding: 5px 14px; border-radius: var(--kp-radius-pill); margin-bottom: 16px;
    }
    .blog-title { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.9rem, 1.3rem + 2.6vw, 2.7rem); color: var(--kp-ink); margin: 0 0 12px; }
    .blog-sub { color: var(--kp-muted); font-size: 1.02rem; margin: 0; }

    .blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; max-width: 1140px; margin: 0 auto; padding: 0 16px; }
    @media (max-width: 992px) { .blog-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 620px) { .blog-grid { grid-template-columns: 1fr; } }

    .blog-card {
        background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: var(--kp-radius);
        box-shadow: var(--kp-shadow-sm); overflow: hidden; display: flex; flex-direction: column; height: 100%;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .blog-card:hover { box-shadow: var(--kp-shadow-lg); transform: translateY(-4px); }

    .blog-card__cover { position: relative; aspect-ratio: 16 / 9; background: var(--kp-blue-soft); overflow: hidden; }
    .blog-card__cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .blog-card__cover-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--kp-blue); font-size: 2rem; }
    .blog-card__date {
        position: absolute; top: 12px; left: 12px; background: rgba(255, 255, 255, .95); color: var(--kp-ink);
        font-size: .72rem; font-weight: 700; padding: 5px 11px; border-radius: var(--kp-radius-pill); box-shadow: var(--kp-shadow-sm);
    }

    .blog-card__body { padding: 20px; display: flex; flex-direction: column; flex: 1; }
    .blog-card__title { font-family: var(--kp-font-title); font-weight: 700; font-size: 1.1rem; color: var(--kp-ink); margin: 0 0 10px; line-height: 1.35; }
    .blog-card__excerpt { color: var(--kp-text); font-size: .92rem; line-height: 1.6; margin: 0 0 18px; flex: 1; }
    .blog-card__cta {
        display: inline-flex; align-items: center; gap: 6px; align-self: flex-start;
        color: var(--kp-blue); font-weight: 700; font-size: .86rem; text-decoration: none;
        border: 1.5px solid var(--kp-blue-soft); padding: 7px 16px; border-radius: var(--kp-radius-pill);
        transition: var(--kp-transition);
    }
    .blog-card:hover .blog-card__cta { background: var(--kp-blue); border-color: var(--kp-blue); color: #fff; }

    .blog-card__anchor { color: inherit; text-decoration: none; display: block; height: 100%; }

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

        @if ($articles->isEmpty())
            <div class="blog-empty" data-aos="fade-up">
                <i class="bi bi-journal-text"></i>
                <p>Aucun article publié pour le moment. Revenez bientôt !</p>
            </div>
        @else
            <div class="blog-grid">
                @foreach ($articles as $article)
                    <a href="{{ route('blog.show', $article) }}" class="blog-card__anchor"
                       data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                        <div class="blog-card">
                            <div class="blog-card__cover">
                                @if ($article->cover_path)
                                    <img src="{{ asset('storage/' . $article->cover_path) }}" alt="{{ $article->title }}">
                                @else
                                    <div class="blog-card__cover-placeholder"><i class="bi bi-journal-text"></i></div>
                                @endif
                                <span class="blog-card__date">{{ $article->published_at?->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="blog-card__body">
                                <h2 class="blog-card__title">{{ $article->title }}</h2>
                                @if ($article->excerpt)
                                    <p class="blog-card__excerpt">{{ \Illuminate\Support\Str::limit($article->excerpt, 120) }}</p>
                                @endif
                                <span class="blog-card__cta">Lire l'article <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
