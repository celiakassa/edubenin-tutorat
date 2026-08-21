@extends('layouts.dashboard')

@section('title', 'Blog - Administration')
@section('page-title', 'Blog')

@push('styles')
    <style>
        .am-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 18px; flex-wrap: wrap; }
        .am-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .am-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }
        .am-add { display: inline-flex; align-items: center; gap: 8px; height: 46px; padding: 0 22px; border-radius: var(--kp-radius-pill); background: var(--kp-blue); color: #fff; font-weight: 700; font-size: var(--kp-fs-base); text-decoration: none; }
        .am-add:hover { background: var(--kp-blue-darker); color: #fff; }

        .am-list { display: flex; flex-direction: column; gap: 8px; }
        .am-item { display: flex; align-items: center; gap: 14px; background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 12px 16px; }
        .am-item__cover { width: 56px; height: 56px; border-radius: 10px; background: var(--kp-blue-soft) center/cover no-repeat; flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: var(--kp-blue); }
        .am-item__main { flex: 1; min-width: 0; }
        .am-item__title { font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-base); }
        .am-item__meta { color: var(--kp-muted); font-size: var(--kp-fs-2xs); display: flex; gap: 10px; margin-top: 2px; flex-wrap: wrap; align-items: center; }
        .am-badge { display: inline-block; padding: 2px 10px; border-radius: var(--kp-radius-pill); font-size: var(--kp-fs-2xs); font-weight: 700; }
        .am-badge--published { background: #dcfce7; color: #15803d; }
        .am-badge--draft { background: var(--kp-surface); color: var(--kp-muted); }
        .am-item__actions { display: flex; gap: 8px; flex-shrink: 0; }
        .am-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; height: 36px; padding: 0 14px; border-radius: 9px; font-size: var(--kp-fs-2xs); font-weight: 700; cursor: pointer; border: none; text-decoration: none; }
        .am-btn--view { background: var(--kp-surface); color: var(--kp-ink); }
        .am-btn--view:hover { background: var(--kp-blue-soft); color: var(--kp-blue-dark); }
        .am-btn--edit { background: var(--kp-surface); color: var(--kp-ink); }
        .am-btn--edit:hover { background: var(--kp-blue); color: #fff; }
        .am-btn--del { background: #fee2e2; color: #e02c18; }
        .am-btn--del:hover { background: #e02c18; color: #fff; }
        .am-empty { text-align: center; padding: 50px 20px; color: var(--kp-muted); }
        @media (max-width: 560px) {
            .am-item { flex-wrap: wrap; }
            .am-item__actions { width: 100%; }
            .am-item__actions .am-btn, .am-item__actions form { flex: 1; }
            .am-item__actions form .am-btn { width: 100%; }
        }
    </style>
@endpush

@section('content')
    <div class="am-head">
        <div>
            <h2>Gestion du blog</h2>
            <p>{{ count($articles) }} article(s) au total.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="am-add"><i class="fas fa-plus"></i> Nouvel article</a>
    </div>

    @if (count($articles) > 0)
        <div class="am-list">
            @foreach ($articles as $article)
                <div class="am-item">
                    <div class="am-item__cover">
                        @if ($article->cover_path)
                            <img src="{{ asset('storage/' . $article->cover_path) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                        @else
                            <i class="fas fa-image"></i>
                        @endif
                    </div>
                    <div class="am-item__main">
                        <div class="am-item__title">{{ $article->title }}</div>
                        <div class="am-item__meta">
                            <span class="am-badge {{ $article->is_published ? 'am-badge--published' : 'am-badge--draft' }}">
                                {{ $article->is_published ? 'Publié' : 'Brouillon' }}
                            </span>
                            <span>{{ $article->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="am-item__actions">
                        @if ($article->is_published)
                            <a href="{{ route('blog.show', $article) }}" target="_blank" class="am-btn am-btn--view"><i class="fas fa-eye"></i></a>
                        @endif
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="am-btn am-btn--edit"><i class="fas fa-edit"></i> Modifier</a>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                              onsubmit="return kpConfirmDelete(event, this, {title: 'Supprimer cet article ?', text: 'Cette action est irréversible.', confirmText: 'Oui, supprimer'});">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="am-btn am-btn--del"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="am-empty"><i class="fas fa-newspaper" style="font-size: 50px; color: var(--kp-border); display: block; margin-bottom: 12px;"></i>Aucun article. Créez-en un via le bouton ci-dessus.</div>
    @endif
@endsection
