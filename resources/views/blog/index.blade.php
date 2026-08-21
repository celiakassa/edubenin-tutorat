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

    .blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; max-width: 1100px; margin: 0 auto; padding: 0 16px; }
    @media (max-width: 900px) { .blog-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .blog-grid { grid-template-columns: 1fr; } }

    .blog-card {
        background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: var(--kp-radius);
        box-shadow: var(--kp-shadow-sm); overflow: hidden; transition: var(--kp-transition); display: flex; flex-direction: column;
    }
    .blog-card:hover { box-shadow: var(--kp-shadow); transform: translateY(-3px); }
    .blog-card__cover { height: 170px; background: var(--kp-blue-soft) center/cover no-repeat; }
    .blog-card__body { padding: 20px; display: flex; flex-direction: column; flex: 1; }
    .blog-card__date { color: var(--kp-muted); font-size: .78rem; margin: 0 0 8px; }
    .blog-card__title { font-family: var(--kp-font-title); font-weight: 700; font-size: 1.08rem; color: var(--kp-ink); margin: 0 0 10px; }
    .blog-card__excerpt { color: var(--kp-text); font-size: .92rem; line-height: 1.6; margin: 0 0 16px; flex: 1; }
    .blog-card__anchor { display: flex; width: 100%; color: inherit; text-decoration: none; }
    .blog-card__anchor .blog-card { width: 100%; }
    .blog-card__link { color: var(--kp-blue); font-weight: 600; font-size: .9rem; text-decoration: none; }
    .blog-card__anchor:hover .blog-card__link { text-decoration: underline; }

    .blog-empty { text-align: center; color: var(--kp-muted); padding: 60px 16px; max-width: 1100px; margin: 0 auto; }
</style>

<div class="blog-page">
    <div class="container">
        <div class="blog-hero" data-aos="fade-up">
            <span class="blog-eyebrow">Blog Kopiao</span>
            <h1 class="blog-title">Conseils et actualités</h1>
            <p class="blog-sub">Nos astuces pour bien choisir un tuteur, réussir ses cours particuliers et suivre les nouveautés de la plateforme.</p>
        </div>

        @if ($articles->isEmpty())
            <div class="blog-empty">
                <i class="bi bi-journal-text" style="font-size: 2rem; opacity: .4;"></i>
                <p class="mt-2 mb-0">Aucun article publié pour le moment. Revenez bientôt !</p>
            </div>
        @else
            <div class="blog-grid" data-aos="fade-up">
                @foreach ($articles as $article)
                    <a href="{{ route('blog.show', $article) }}" class="blog-card__anchor">
                        <div class="blog-card">
                            <div class="blog-card__cover" @if ($article->cover_path) style="background-image: url('{{ asset('storage/' . $article->cover_path) }}');" @endif></div>
                            <div class="blog-card__body">
                                <p class="blog-card__date">{{ $article->published_at?->translatedFormat('d M Y') }}</p>
                                <h2 class="blog-card__title">{{ $article->title }}</h2>
                                @if ($article->excerpt)
                                    <p class="blog-card__excerpt">{{ $article->excerpt }}</p>
                                @endif
                                <span class="blog-card__link">Lire l'article <i class="bi bi-arrow-right"></i></span>
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
