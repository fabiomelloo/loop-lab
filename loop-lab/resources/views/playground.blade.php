@extends('layouts.playground')
@section('title', 'Laboratório de estudo PHP')

@section('content')
@php($firstStudy = $studies[0] ?? ['id' => 'livre', 'title' => 'Código livre', 'concept' => 'PHP', 'goal' => 'Escreva e execute um pequeno código.', 'tip' => 'Comece com echo.', 'code' => "<?php\n\necho 'Olá, PHP!';"])
<section class="lab-intro">
    <div>
        <span class="eyebrow">Laboratório sem pressão</span>
        <h1>Aprenda PHP testando ideias</h1>
        <p>Escolha um assunto, altere o exemplo e execute. O resultado aparece sem recarregar a página e seu rascunho fica salvo neste navegador.</p>
    </div>
    <div class="study-flow" aria-label="Fluxo de estudo">
        <span>1. Leia</span><span>2. Altere</span><span>3. Execute</span><span>4. Explique</span>
    </div>
</section>

<section class="study-progress" aria-label="Progresso no laboratório">
    <div class="progress-row"><span>Exemplos praticados</span><strong data-study-count>0 de {{ count($studies) }}</strong></div>
    <div class="progress-track" aria-hidden="true"><span data-study-progress></span></div>
</section>

<div class="lab-grid">
    <aside class="study-list" aria-label="Assuntos para praticar">
        @foreach($studies as $study)
            <button class="study-button {{ $loop->first ? 'active' : '' }}" type="button" data-study-id="{{ $study['id'] }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                <strong>{{ $study['title'] }}</strong><small>{{ $study['concept'] }}</small>
            </button>
        @endforeach
    </aside>

    <section class="workspace" aria-label="Editor de prática">
        <div class="brief">
            <div><span class="eyebrow">Prática atual</span><h2 data-study-title>{{ $firstStudy['title'] }}</h2><p data-study-goal>{{ $firstStudy['goal'] }}</p><p class="tip"><strong>Dica:</strong> <span data-study-tip>{{ $firstStudy['tip'] }}</span></p></div>
            <span class="concept" data-study-concept>{{ $firstStudy['concept'] }}</span>
        </div>

        <form method="POST" action="{{ route('playground.run', absolute: false) }}" data-playground-form>
            @csrf
            <div class="editor-panel">
                <div class="editor-bar"><span>estudo.php</span><span>Tab indenta · Ctrl + Enter executa</span></div>
                <label class="sr-only" for="playground-code">Código PHP</label>
                <textarea class="editor" id="playground-code" name="code" spellcheck="false" maxlength="10000">{{ $firstStudy['code'] }}</textarea>
                <div class="editor-actions">
                    <span class="editor-help" data-save-status>Rascunho salvo automaticamente</span>
                    <div class="button-group">
                        <button class="btn btn-secondary" type="button" data-reset-code>Restaurar exemplo</button>
                        <button class="btn btn-primary" type="submit" data-run-code>Executar código</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="result" id="exercise-result" aria-live="polite" aria-busy="false"><p class="result-empty">A saída do seu código aparecerá aqui.</p></div>
        <p class="status-line" data-lab-status role="status"></p>
    </section>
</div>
@endsection

@push('scripts')
<script>
(() => {
    const studies = @json($studies);
    const byId = new Map(studies.map(study => [study.id, study]));
    const editor = document.querySelector('#playground-code');
    const form = document.querySelector('[data-playground-form]');
    const result = document.querySelector('#exercise-result');
    const status = document.querySelector('[data-lab-status]');
    const runButton = document.querySelector('[data-run-code]');
    let activeId = studies[0]?.id || 'livre';
    let saveTimer;

    const draftKey = id => `loop-lab:playground:draft:${id}`;
    const completedKey = 'loop-lab:playground:completed';
    let storedCompleted = [];
    try { storedCompleted = JSON.parse(localStorage.getItem(completedKey) || '[]'); } catch (error) { localStorage.removeItem(completedKey); }
    const completed = new Set(Array.isArray(storedCompleted) ? storedCompleted : []);

    function updateProgress() {
        const total = studies.length || 1;
        document.querySelector('[data-study-count]').textContent = `${completed.size} de ${studies.length}`;
        document.querySelector('[data-study-progress]').style.width = `${Math.round((completed.size / total) * 100)}%`;
        document.querySelectorAll('[data-study-id]').forEach(button => button.classList.toggle('done', completed.has(button.dataset.studyId)));
    }

    function chooseStudy(id) {
        const study = byId.get(id);
        if (!study) return;
        activeId = id;
        document.querySelectorAll('[data-study-id]').forEach(button => {
            const active = button.dataset.studyId === id;
            button.classList.toggle('active', active);
            button.setAttribute('aria-pressed', String(active));
        });
        document.querySelector('[data-study-title]').textContent = study.title;
        document.querySelector('[data-study-goal]').textContent = study.goal;
        document.querySelector('[data-study-tip]').textContent = study.tip;
        document.querySelector('[data-study-concept]').textContent = study.concept;
        editor.value = localStorage.getItem(draftKey(id)) ?? study.code;
        result.innerHTML = '<p class="result-empty">A saída do seu código aparecerá aqui.</p>';
        status.textContent = '';
        editor.focus();
    }

    document.querySelectorAll('[data-study-id]').forEach(button => button.addEventListener('click', () => chooseStudy(button.dataset.studyId)));

    document.querySelector('[data-reset-code]').addEventListener('click', () => {
        const study = byId.get(activeId);
        if (!study) return;
        editor.value = study.code;
        localStorage.removeItem(draftKey(activeId));
        result.innerHTML = '<p class="result-empty">Exemplo restaurado. Altere algo e execute novamente.</p>';
        status.textContent = '';
        editor.focus();
    });

    editor.addEventListener('input', () => {
        clearTimeout(saveTimer);
        document.querySelector('[data-save-status]').textContent = 'Salvando rascunho...';
        saveTimer = setTimeout(() => {
            localStorage.setItem(draftKey(activeId), editor.value);
            document.querySelector('[data-save-status]').textContent = 'Rascunho salvo automaticamente';
        }, 250);
    });

    editor.addEventListener('keydown', event => {
        if (event.key === 'Tab') {
            event.preventDefault();
            editor.setRangeText('    ', editor.selectionStart, editor.selectionEnd, 'end');
            editor.dispatchEvent(new Event('input'));
        }
        if (event.key === 'Enter' && (event.ctrlKey || event.metaKey)) {
            event.preventDefault();
            form.requestSubmit(runButton);
        }
    });

    form.addEventListener('submit', async event => {
        event.preventDefault();
        runButton.disabled = true;
        runButton.textContent = 'Executando...';
        result.setAttribute('aria-busy', 'true');
        status.className = 'status-line';
        status.textContent = 'Enviando o código com segurança...';

        try {
            const response = await fetch(form.action, {method: 'POST', body: new FormData(form), headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}});
            const contentType = response.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) throw new Error(`O servidor devolveu uma resposta inválida (${response.status}).`);
            const data = await response.json();
            if (!response.ok) throw new Error(Object.values(data.errors || {}).flat()[0] || data.message || 'Não foi possível executar.');
            result.innerHTML = data.html;
            status.classList.add(data.successful ? 'ok' : 'bad');
            status.textContent = data.successful ? `Executado em ${data.milliseconds} ms. Agora tente explicar por que essa saída apareceu.` : 'Leia o erro, corrija somente uma parte e execute outra vez.';
            if (data.successful) {
                completed.add(activeId);
                localStorage.setItem(completedKey, JSON.stringify([...completed]));
                updateProgress();
            }
        } catch (error) {
            result.innerHTML = '<div class="feedback bad" role="alert"></div>';
            result.querySelector('.feedback').textContent = `${error.message} Seu código continua salvo; tente novamente em instantes.`;
            status.classList.add('bad');
            status.textContent = 'O laboratório não perdeu seu rascunho.';
        } finally {
            result.setAttribute('aria-busy', 'false');
            runButton.disabled = false;
            runButton.textContent = 'Executar código';
        }
    });

    const savedDraft = localStorage.getItem(draftKey(activeId));
    if (savedDraft) editor.value = savedDraft;
    updateProgress();
})();
</script>
@endpush
