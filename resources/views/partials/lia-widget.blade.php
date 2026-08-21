<style>
    .lia-bubble {
        position: fixed; bottom: 24px; right: 24px; z-index: 4000;
        width: 58px; height: 58px; border-radius: 50%; border: none;
        background: var(--kp-blue, #0B69F1); color: #fff; font-size: 1.5rem;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(11, 105, 241, .35); cursor: pointer;
        transition: transform .2s ease;
    }
    .lia-bubble:hover { transform: scale(1.06); }

    .lia-panel {
        position: fixed; bottom: 96px; right: 24px; z-index: 4000;
        width: 340px; max-width: calc(100vw - 32px); height: 460px; max-height: calc(100vh - 140px);
        background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(16, 24, 40, .22);
        display: none; flex-direction: column; overflow: hidden;
    }
    .lia-panel.active { display: flex; }

    .lia-panel__header {
        background: var(--kp-blue, #0B69F1); color: #fff; padding: 14px 16px;
        display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;
    }
    .lia-panel__header h3 { font-size: .98rem; font-weight: 700; margin: 0; color: #fff; }
    .lia-panel__header p { font-size: .74rem; opacity: .85; margin: 2px 0 0; }
    .lia-panel__close { background: none; border: none; color: #fff; font-size: 1.2rem; cursor: pointer; line-height: 1; }

    .lia-panel__messages { flex: 1; overflow-y: auto; padding: 14px; display: flex; flex-direction: column; gap: 10px; background: #f7f8fa; }
    .lia-msg { max-width: 82%; padding: 9px 13px; border-radius: 14px; font-size: .87rem; line-height: 1.5; white-space: pre-line; }
    .lia-msg--bot { align-self: flex-start; background: #fff; color: #1b1535; border: 1px solid #e5e7eb; border-bottom-left-radius: 4px; }
    .lia-msg--user { align-self: flex-end; background: var(--kp-blue, #0B69F1); color: #fff; border-bottom-right-radius: 4px; }
    .lia-msg--typing { align-self: flex-start; color: #6b7280; font-style: italic; }

    .lia-panel__form { display: flex; gap: 8px; padding: 12px; border-top: 1px solid #e5e7eb; flex-shrink: 0; }
    .lia-panel__form input {
        flex: 1; border: 1.5px solid #e5e7eb; border-radius: 20px; padding: 9px 14px; font-size: .87rem;
    }
    .lia-panel__form input:focus { outline: none; border-color: var(--kp-blue, #0B69F1); }
    .lia-panel__form button {
        width: 38px; height: 38px; border-radius: 50%; border: none; background: var(--kp-blue, #0B69F1);
        color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0;
    }
    .lia-panel__form button:disabled { opacity: .6; cursor: default; }

    @media (max-width: 480px) {
        .lia-panel { right: 16px; bottom: 88px; }
        .lia-bubble { right: 16px; bottom: 16px; }
    }
</style>

<button type="button" class="lia-bubble" id="liaToggle" aria-label="Ouvrir l'assistant Lia">
    <i class="bi bi-chat-dots-fill"></i>
</button>

<div class="lia-panel" id="liaPanel">
    <div class="lia-panel__header">
        <div>
            <h3>Lia</h3>
            <p>Assistante virtuelle Kopiao</p>
        </div>
        <button type="button" class="lia-panel__close" id="liaClose" aria-label="Fermer">&times;</button>
    </div>
    <div class="lia-panel__messages" id="liaMessages"></div>
    <form class="lia-panel__form" id="liaForm" autocomplete="off">
        <input type="text" id="liaInput" placeholder="Posez votre question…" maxlength="500" required>
        <button type="submit" id="liaSend" aria-label="Envoyer">
            <i class="bi bi-send-fill"></i>
        </button>
    </form>
</div>

<script src="{{ asset('js/lia-widget.js') }}"></script>
