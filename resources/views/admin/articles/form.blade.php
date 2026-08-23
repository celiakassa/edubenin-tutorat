@extends('layouts.dashboard')

@section('title', ($article->exists ? 'Modifier' : 'Nouvel').' article - Administration')
@section('page-title', $article->exists ? 'Modifier l\'article' : 'Nouvel article')

@push('styles')
    <style>
        .af-layout { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
        @media (max-width: 900px) { .af-layout { grid-template-columns: 1fr; } }

        .af-card {
            background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: var(--kp-radius);
            box-shadow: var(--kp-shadow-sm); padding: 24px; margin-bottom: 24px;
        }
        .af-card-title { font-family: var(--kp-font-title); font-size: var(--kp-fs-lg, 1.1rem); font-weight: 700; color: var(--kp-ink); margin: 0 0 18px; }

        .af-group { margin-bottom: 20px; }
        .af-group:last-child { margin-bottom: 0; }
        .af-group label { display: block; font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-base); margin-bottom: 8px; }
        .af-group input[type="text"],
        .af-group textarea {
            width: 100%; padding: 12px 14px; border: 1.5px solid var(--kp-border); border-radius: 12px;
            font-size: var(--kp-fs-base); background: #fff; font-family: var(--kp-font-body);
        }
        .af-group input[type="text"]:focus,
        .af-group textarea:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        .af-group textarea { min-height: 320px; resize: vertical; }
        .af-err { color: #e02c18; font-size: var(--kp-fs-2xs); font-weight: 600; margin-top: 6px; display: block; }
        .af-hint { display: block; color: var(--kp-muted); font-size: var(--kp-fs-2xs); margin-top: 6px; }
        .af-counter { display: flex; justify-content: flex-end; color: var(--kp-muted); font-size: var(--kp-fs-2xs); margin-top: 6px; }
        .af-counter.af-counter--over { color: #e02c18; font-weight: 700; }

        .af-visually-hidden { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); border: 0; }

        .af-dropzone { position: relative; border: 2px dashed var(--kp-border); border-radius: 12px; background: var(--kp-surface); overflow: hidden; }
        .af-dropzone__prompt {
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
            min-height: 140px; padding: 20px; text-align: center; color: var(--kp-muted); cursor: pointer; margin: 0;
        }
        .af-dropzone__prompt:hover { color: var(--kp-blue); }
        .af-dropzone__prompt i { font-size: 1.8rem; color: var(--kp-blue); }
        .af-dropzone__prompt p { margin: 0; font-size: var(--kp-fs-sm, .85rem); font-weight: 500; }
        .af-dropzone__preview-wrap { padding: 12px; text-align: center; }
        .af-dropzone__preview-wrap img,
        .af-dropzone__preview-wrap video { width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px; display: block; }
        .af-change-link {
            display: inline-block; margin-top: 10px; color: var(--kp-blue); font-size: var(--kp-fs-2xs);
            font-weight: 700; cursor: pointer; text-decoration: underline;
        }

        .af-check { display: flex; align-items: center; gap: 10px; }

        .af-actions { display: flex; align-items: center; gap: 12px; margin-top: 8px; flex-wrap: wrap; }
        .af-btn {
            display: inline-flex; align-items: center; gap: 8px; height: 46px; padding: 0 24px;
            border-radius: var(--kp-radius-pill); font-weight: 700; font-size: var(--kp-fs-base);
            text-decoration: none; border: none; cursor: pointer;
        }
        .af-btn--publish { background: var(--kp-blue); color: #fff; }
        .af-btn--publish:hover { background: var(--kp-blue-darker); color: #fff; }
        .af-btn--draft { background: var(--kp-surface); color: var(--kp-ink); border: 1.5px solid var(--kp-border); }
        .af-btn--draft:hover { background: var(--kp-border); }
        .af-btn--cancel { background: none; color: var(--kp-muted); padding: 0 8px; height: auto; text-decoration: underline; }
        .af-btn--cancel:hover { color: var(--kp-ink); }
    </style>
@endpush

@section('content')
    <form id="articleForm" method="POST"
          action="{{ $article->exists ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if ($article->exists)
            @method('PUT')
        @endif
        <input type="hidden" name="publish_action" id="publishAction" value="draft">

        <div class="af-layout">
            <div class="af-col-main">
                <div class="af-card">
                    <h2 class="af-card-title">Contenu principal</h2>

                    <div class="af-group">
                        <label for="title">Titre</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required>
                        @error('title')<span class="af-err">{{ $message }}</span>@enderror
                    </div>

                    <div class="af-group">
                        <label for="excerpt">Résumé</label>
                        <input type="text" id="excerpt" name="excerpt" maxlength="255" value="{{ old('excerpt', $article->excerpt) }}">
                        <div class="af-counter" id="excerptCounter">0 / 155 caractères recommandés (SEO)</div>
                        <span class="af-hint">Affiché dans la liste du blog et utilisé comme meta description.</span>
                        @error('excerpt')<span class="af-err">{{ $message }}</span>@enderror
                    </div>

                    <div class="af-group">
                        <label for="content">Contenu</label>
                        <textarea id="content" name="content" required>{{ old('content', $article->content) }}</textarea>
                        @error('content')<span class="af-err">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="af-col-side">
                <div class="af-card">
                    <h2 class="af-card-title">Média</h2>

                    <div class="af-group">
                        <label>Image de couverture</label>
                        <div class="af-dropzone" id="coverDropzone">
                            <label for="cover" class="af-dropzone__prompt" id="coverPrompt" style="{{ $article->cover_path ? 'display:none;' : '' }}">
                                <i class="fas fa-image"></i>
                                <p>Cliquez pour choisir une image</p>
                            </label>
                            <div class="af-dropzone__preview-wrap" id="coverPreviewWrap" style="{{ $article->cover_path ? '' : 'display:none;' }}">
                                <img id="coverPreview" src="{{ $article->cover_path ? asset('storage/'.$article->cover_path) : '' }}" alt="">
                                <label for="cover" class="af-change-link">Changer l'image</label>
                            </div>
                        </div>
                        <input type="file" id="cover" name="cover" accept="image/jpeg,image/png,image/webp" class="af-visually-hidden">
                        <span class="af-hint">Formats acceptés : JPG, PNG — 5 Mo max</span>
                        @error('cover')<span class="af-err">{{ $message }}</span>@enderror
                    </div>

                    <div class="af-group">
                        <label>Vidéo <span style="font-weight:400;color:var(--kp-muted);">(optionnel)</span></label>
                        <div class="af-dropzone" id="videoDropzone">
                            <label for="video" class="af-dropzone__prompt" id="videoPrompt" style="{{ $article->video_path ? 'display:none;' : '' }}">
                                <i class="fas fa-video"></i>
                                <p>Cliquez pour choisir une vidéo</p>
                            </label>
                            <div class="af-dropzone__preview-wrap" id="videoPreviewWrap" style="{{ $article->video_path ? '' : 'display:none;' }}">
                                <video id="videoPreview" src="{{ $article->video_path ? asset('storage/'.$article->video_path) : '' }}" controls></video>
                                <label for="video" class="af-change-link">Changer la vidéo</label>
                            </div>
                        </div>
                        <input type="file" id="video" name="video" accept="video/mp4,video/webm,video/quicktime" class="af-visually-hidden">
                        <span class="af-hint">Formats acceptés : MP4, WEBM, MOV — 5 Mo max</span>
                        @error('video')<span class="af-err">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="af-card">
                    <h2 class="af-card-title">Publication</h2>
                    <div class="af-actions">
                        <button type="submit" class="af-btn af-btn--publish" onclick="document.getElementById('publishAction').value='publish';">
                            <i class="fas fa-paper-plane"></i> Publier
                        </button>
                        <button type="submit" class="af-btn af-btn--draft" onclick="document.getElementById('publishAction').value='draft';">
                            Enregistrer (brouillon)
                        </button>
                        <a href="{{ route('admin.articles') }}" class="af-btn af-btn--cancel">Annuler</a>
                    </div>
                    @if ($article->exists)
                        <span class="af-hint" style="margin-top:14px;">
                            Statut actuel : {{ $article->is_published ? 'publié' : 'brouillon' }}.
                            "Enregistrer (brouillon)" repasse l'article en brouillon.
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function afPreviewFile(inputId, promptId, wrapId, previewId) {
            const input = document.getElementById(inputId);
            const prompt = document.getElementById(promptId);
            const wrap = document.getElementById(wrapId);
            const preview = document.getElementById(previewId);
            if (!input) return;
            input.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                preview.src = URL.createObjectURL(file);
                prompt.style.display = 'none';
                wrap.style.display = 'block';
            });
        }
        afPreviewFile('cover', 'coverPrompt', 'coverPreviewWrap', 'coverPreview');
        afPreviewFile('video', 'videoPrompt', 'videoPreviewWrap', 'videoPreview');

        (function () {
            const excerpt = document.getElementById('excerpt');
            const counter = document.getElementById('excerptCounter');
            if (!excerpt || !counter) return;
            const recommended = 155;
            function update() {
                const len = excerpt.value.length;
                counter.textContent = len + ' / ' + recommended + ' caractères recommandés (SEO)';
                counter.classList.toggle('af-counter--over', len > recommended);
            }
            excerpt.addEventListener('input', update);
            update();
        })();
    </script>
@endpush
