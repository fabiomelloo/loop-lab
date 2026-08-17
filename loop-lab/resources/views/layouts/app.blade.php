<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'PHP na Prática')</title>
    <style>
        :root{--navy:#08162e;--navy2:#102445;--blue:#2563eb;--blue2:#1d4ed8;--cyan:#22d3ee;--orange:#f97316;--bg:#f4f7fb;--surface:#fff;--text:#172033;--muted:#526078;--line:#dbe3ef;--ok:#047857;--bad:#b42318}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--text);font:16px/1.6 Inter,Arial,sans-serif}button,input,textarea{font:inherit}a{color:inherit;text-decoration:none}.shell{display:grid;grid-template-columns:278px 1fr;min-height:100vh}.sidebar{background:var(--navy);color:#e7eefc;padding:24px 18px;position:sticky;top:0;height:100vh;overflow:auto}.brand{font-size:22px;font-weight:800;margin:0 8px 26px}.brand span{color:var(--cyan)}.progress{background:var(--navy2);padding:16px;border-radius:14px;margin-bottom:24px}.progress-row{display:flex;justify-content:space-between;font-size:14px}.bar{height:8px;background:#293c5c;border-radius:99px;overflow:hidden;margin-top:9px}.bar>span{display:block;height:100%;background:linear-gradient(90deg,var(--cyan),#60a5fa);border-radius:99px}.module{margin:18px 8px 7px;color:#91a4c3;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.08em}.nav-link{display:block;padding:10px 12px;border-radius:10px;color:#d5e0f2}.nav-link:hover,.nav-link.active{background:var(--navy2);color:#fff}.nav-link.completed{color:#91a4c3;opacity:.6;text-decoration:line-through}.nav-link.locked{opacity:.55}.content{min-width:0}.topbar{height:72px;padding:0 36px;display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,.9);border-bottom:1px solid var(--line);position:sticky;top:0;z-index:10;backdrop-filter:blur(12px)}.topbar strong{color:var(--blue)}.mobile-title{display:none}.page{width:min(1120px,calc(100% - 48px));margin:0 auto;padding:36px 0 64px}.eyebrow{color:var(--blue);font-weight:800;text-transform:uppercase;font-size:13px;letter-spacing:.08em}h1{font-size:clamp(32px,5vw,48px);line-height:1.12;margin:8px 0 12px}h2{font-size:24px;line-height:1.25;margin:0 0 14px}h3{margin:0 0 10px}.lead{font-size:18px;color:var(--muted);max-width:760px}.card{background:var(--surface);border:1px solid var(--line);border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(20,38,70,.06)}.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.stats{margin:28px 0}.stat strong{display:block;font-size:30px}.stat span{color:var(--muted)}.btn{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:10px 18px;border:1px solid transparent;border-radius:10px;font-weight:800;cursor:pointer;transition:.2s}.btn-primary{background:var(--blue);color:#fff}.btn-primary:hover{background:var(--blue2)}.btn-secondary{background:#fff;border-color:var(--line);color:var(--text)}.btn-secondary:hover{border-color:var(--blue);color:var(--blue)}.btn-warn{background:#fff7ed;border-color:#fed7aa;color:#9a3412}.hero-actions,.actions{display:flex;gap:10px;flex-wrap:wrap}.course-card{margin-top:24px;display:flex;align-items:center;justify-content:space-between;gap:24px}.course-card p{color:var(--muted)}.badge{display:inline-block;padding:4px 10px;border-radius:999px;background:#dbeafe;color:#1e40af;font-size:13px;font-weight:800}.stack{display:grid;gap:20px}.code{background:#0b1220;color:#dbeafe;border-radius:12px;padding:18px;overflow:auto;font:14px/1.7 Consolas,monospace;white-space:pre}.line-list{padding-left:22px}.line-list li{margin:8px 0}.warning{padding:14px 16px;border-left:4px solid var(--orange);background:#fff7ed;border-radius:8px}.editor{width:100%;min-height:390px;padding:22px;border:0;background:#0b1220;color:#dbeafe;font:15px/1.65 Consolas,monospace;resize:vertical;tab-size:4}.editor:focus{outline:3px solid #93c5fd;outline-offset:-3px}.output{min-height:90px;background:#07101f;color:#dbeafe;padding:16px;border-radius:10px;white-space:pre-wrap;font:14px/1.6 Consolas,monospace}.feedback{padding:20px;border-radius:12px}.feedback h2{margin-bottom:6px}.feedback.ok{background:#ecfdf3;color:#065f46;border:1px solid #a7f3d0}.feedback.bad{background:#fff1f0;color:#912018;border:1px solid #fecaca}.compare{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin:14px 0}.compare pre{white-space:pre-wrap;background:#fff;padding:12px;border-radius:8px;color:var(--text);overflow:auto}.hints details,.solution{border-top:1px solid var(--line);padding:14px 0}.hints summary,.solution summary{cursor:pointer;font-weight:800}.step{display:grid;grid-template-columns:72px 1fr;gap:12px;padding:12px 0;border-top:1px solid var(--line)}.step strong{color:var(--blue)}.security-note{font-size:14px;color:var(--muted)}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
        .ajax-loader{position:fixed;z-index:100;top:0;left:0;width:100%;height:3px;background:var(--blue);transform:scaleX(0);transform-origin:left;opacity:0;transition:transform .25s,opacity .2s}.ajax-loader.loading{transform:scaleX(.75);opacity:1}.page-jump{display:flex;gap:8px;margin:26px 0 42px;padding:6px;background:#e8eef8;border-radius:12px;width:max-content}.page-jump a{padding:8px 16px;border-radius:8px;font-weight:800}.page-jump a:hover{background:#fff;color:var(--blue)}.lesson-section{scroll-margin-top:94px}.section-heading{display:flex;align-items:center;gap:16px;margin-bottom:20px}.section-heading h2,.section-heading p{margin:0}.section-number{display:grid;place-items:center;width:48px;height:48px;border-radius:14px;background:var(--blue);color:#fff;font-size:22px;font-weight:900}.learning-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px}.learning-intro{box-shadow:none}.learning-code .card{min-width:0}.lesson-detail{margin-top:14px;padding:0}.lesson-detail>summary{padding:20px 24px;font-size:17px;font-weight:800;cursor:pointer;list-style-position:inside}.lesson-detail[open]{padding:0 24px 24px}.lesson-detail[open]>summary{margin:0 -24px 18px;border-bottom:1px solid var(--line)}.practice-section{margin-top:64px;padding-top:36px;border-top:1px solid var(--line)}
        .exercise-list{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:20px}.exercise-item{display:flex;align-items:center;gap:12px;min-height:72px;padding:12px;border:1px solid var(--line);border-radius:12px;background:#fff}.exercise-item:hover{border-color:#93c5fd}.exercise-item.active{border:2px solid var(--blue);background:#eff6ff}.exercise-item small{display:block;color:var(--muted)}.exercise-status{display:grid;place-items:center;flex:0 0 34px;height:34px;border-radius:10px;background:#e8eef8;color:var(--blue);font-weight:900}.exercise-item.active .exercise-status{background:var(--blue);color:#fff}.exercise-workspace{display:grid;grid-template-columns:minmax(280px,.72fr) minmax(0,1.28fr);border:1px solid var(--line);border-radius:18px;background:#fff;overflow:hidden;box-shadow:0 16px 40px rgba(20,38,70,.09)}.exercise-brief{padding:28px;background:#fbfcfe;border-right:1px solid var(--line)}.exercise-kicker{display:flex;justify-content:space-between;align-items:center;color:var(--muted);font-size:14px;font-weight:800}.exercise-brief h2{font-size:28px;margin-top:20px}.task-box{padding:18px;border-radius:12px;background:#eff6ff;border-left:4px solid var(--blue)}.task-box p{margin:5px 0 0;font-size:17px}.task-label{color:var(--blue2);font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.08em}.rules-box{margin-top:22px}.rules-box ul{padding-left:20px}.workflow-tip{margin-top:24px;padding-top:18px;border-top:1px solid var(--line);color:var(--muted);font-size:14px}.editor-card{min-width:0;background:#0b1220}.editor-heading{height:50px;display:flex;align-items:center;gap:18px;padding:0 18px;color:#a8b4c8;background:#111c30;border-bottom:1px solid #25334a;font:13px Consolas,monospace}.editor-dot{display:inline-block;width:10px;height:10px;margin-right:6px;border-radius:50%;background:#475569}.editor-help{margin:0;padding:9px 18px;color:#91a4bd;background:#111c30;font-size:13px}.editor-actions{display:flex;justify-content:space-between;gap:12px;padding:16px;background:#fff;border-top:1px solid var(--line)}.actions-secondary{display:flex;gap:8px}.btn-quiet{color:var(--muted);background:transparent}.btn-quiet:hover{background:#f1f5f9}.result-card,.help-card{margin-top:20px;padding:24px;border:1px solid var(--line);border-radius:16px;background:#fff}.result-heading{display:flex;gap:14px;align-items:center;margin-bottom:16px}.result-heading h2{margin:0}.result-icon{display:grid;place-items:center;width:44px;height:44px;border-radius:12px;background:#0b1220;color:var(--cyan);font:800 16px Consolas,monospace}.next-step{margin-top:18px;padding:18px;border:1px solid #bfdbfe;border-radius:12px;background:#fff}.next-step h3,.next-step p{margin:4px 0 12px}.help-card{display:grid;grid-template-columns:280px 1fr;gap:28px}.help-card h2{margin-bottom:4px}.help-card p{color:var(--muted)}.profile-form{display:flex;gap:10px;align-items:end}.profile-form label{display:block;font-weight:800}.profile-form input{min-height:46px;padding:9px 12px;border:1px solid var(--line);border-radius:10px}.ranking-table{width:100%;border-collapse:collapse}.ranking-table th,.ranking-table td{padding:15px 12px;border-bottom:1px solid var(--line);text-align:left}.ranking-table th{color:var(--muted);font-size:13px;text-transform:uppercase}.ranking-table tr.current{background:#eff6ff}.rank-position{font-weight:900;color:var(--blue)}.rank-name{font-weight:800}.rank-you{margin-left:7px;padding:2px 7px;border-radius:99px;background:#dbeafe;color:#1e40af;font-size:11px}.empty-ranking{text-align:center;padding:42px;color:var(--muted)}
        .mascot-toast{--mascot-accent:#2563eb;position:fixed;right:24px;bottom:24px;z-index:1000;display:grid;grid-template-columns:138px minmax(210px,300px);align-items:center;gap:6px;width:min(470px,calc(100vw - 32px));padding:16px 18px 16px 8px;border:2px solid color-mix(in srgb,var(--mascot-accent) 32%,white);border-radius:28px;background:rgba(255,255,255,.96);box-shadow:0 24px 70px rgba(8,22,46,.24),inset 0 -4px 0 rgba(15,23,42,.06);backdrop-filter:blur(12px);transform:translateY(28px) scale(.94);opacity:0;visibility:hidden;pointer-events:none}.mascot-toast.visible{animation:mascot-enter .38s cubic-bezier(.2,.9,.25,1.2) forwards;visibility:visible;pointer-events:auto}.mascot-toast.leaving{animation:mascot-exit .2s ease-in forwards}.mascot-toast.error{--mascot-accent:#dc2626}.mascot-toast.success{--mascot-accent:#2563eb}.mascot-image{display:block;width:138px;height:138px;object-fit:contain;filter:drop-shadow(0 10px 12px rgba(15,23,42,.2));transform-origin:bottom center}.mascot-toast.visible .mascot-image{animation:mascot-react .55s .12s cubic-bezier(.2,.8,.2,1) both}.mascot-copy{min-width:0;padding-right:10px}.mascot-label{display:block;margin-bottom:3px;color:var(--mascot-accent);font-size:12px;font-weight:900;letter-spacing:.1em;text-transform:uppercase}.mascot-title{margin:0 0 4px;font-size:22px;line-height:1.15}.mascot-message{margin:0;color:var(--muted);font-size:15px;line-height:1.45}.mascot-controls{position:absolute;top:10px;right:10px;display:flex;gap:4px}.mascot-icon-btn{display:grid;place-items:center;width:44px;height:44px;padding:0;border:0;border-radius:50%;background:transparent;color:#475569;cursor:pointer}.mascot-icon-btn:hover{background:#eef2f7;color:var(--text)}.mascot-icon-btn:focus-visible{outline:3px solid #93c5fd;outline-offset:1px}.mascot-icon-btn svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}@keyframes mascot-enter{to{opacity:1;transform:translateY(0) scale(1)}}@keyframes mascot-exit{to{opacity:0;transform:translateY(16px) scale(.97)}}@keyframes mascot-react{0%{transform:scale(.82) rotate(-4deg)}55%{transform:scale(1.08) rotate(3deg)}100%{transform:scale(1) rotate(0)}}
        @media(max-width:900px){.shell{grid-template-columns:1fr}.sidebar{position:static;height:auto}.sidebar nav{display:none}.topbar{padding:0 20px}.mobile-title{display:block}.page{width:min(100% - 28px,720px)}.grid,.learning-grid,.exercise-workspace,.help-card{grid-template-columns:1fr}.exercise-list{grid-template-columns:1fr}.exercise-brief{border-right:0;border-bottom:1px solid var(--line)}.course-card{align-items:flex-start;flex-direction:column}}@media(max-width:560px){.page-jump{width:100%}.page-jump a{flex:1;text-align:center}.editor-actions{align-items:stretch;flex-direction:column-reverse}.actions-secondary{display:grid;grid-template-columns:1fr 1fr}.editor-actions>.btn{width:100%}.compare{grid-template-columns:1fr}.editor{min-height:320px}.section-heading{align-items:flex-start}.mascot-toast{right:16px;bottom:16px;grid-template-columns:104px 1fr;padding:12px 12px 12px 4px;border-radius:22px}.mascot-image{width:104px;height:116px}.mascot-title{font-size:18px}.mascot-message{font-size:14px}.mascot-controls{top:4px;right:4px}.mascot-copy{padding:34px 4px 0 0}}@media(prefers-reduced-motion:reduce){*{scroll-behavior:auto!important;transition:none!important}.mascot-toast.visible,.mascot-toast.leaving,.mascot-toast.visible .mascot-image{animation:none!important}.mascot-toast.visible{opacity:1;transform:none}.mascot-toast.leaving{opacity:0}}
    </style>
</head>
<body><div class="ajax-loader" aria-hidden="true"></div><div class="shell">
    <aside class="sidebar"><div class="brand"><span>&lt;?php</span> na Prática</div>
        <div class="progress"><div class="progress-row"><span>Seu progresso</span><strong data-progress-percent>{{ $stats['percent'] }}%</strong></div><div class="bar"><span data-progress-bar style="width:{{ $stats['percent'] }}%"></span></div><small data-progress-count>{{ $stats['completed'] }} de {{ $stats['total'] }} exercícios</small></div>
        <nav aria-label="Módulos do curso"><a class="nav-link" href="{{ route('dashboard') }}">Visão geral</a>
            @foreach($modules as $module)<div class="module">{{ str_pad($module->position,2,'0',STR_PAD_LEFT) }} {{ $module->title }}</div>
                @foreach($module->lessons as $item)<a class="nav-link {{ request()->route('lesson')?->is($item) ? 'active' : '' }} {{ in_array($item->id, $completedLessonIds ?? []) ? 'completed' : '' }}" href="{{ route('lessons.show',$item) }}">{{ $item->title }}{{ in_array($item->id, $completedLessonIds ?? []) ? ' ✓' : '' }}</a>@endforeach
            @endforeach
            <div class="module">Seu aprendizado</div><a class="nav-link {{ request()->routeIs('review') ? 'active' : '' }}" href="{{ route('review') }}">Revisar erros</a>
            <div class="module">Comunidade</div><a class="nav-link {{ request()->routeIs('ranking') ? 'active' : '' }}" href="{{ route('ranking') }}">Ranking</a>
            <div class="module">Laboratório</div><a class="nav-link" href="{{ route('playground') }}">PHP Playground</a>
        </nav>
    </aside>
    <div class="content"><header class="topbar"><span class="mobile-title">PHP na Prática</span><span>Aprenda escrevendo código</span><div class="hero-actions"><strong data-xp>{{ $stats['xp'] }} XP</strong>@auth<form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-quiet" type="submit">Sair</button></form>@else<a href="{{ route('login') }}">Entrar</a>@endauth</div></header><main class="page">@yield('content')</main></div>
</div>
<aside class="mascot-toast" data-mascot-toast aria-live="polite" aria-atomic="true" aria-hidden="true">
    <img class="mascot-image" data-mascot-image src="/images/mascots/encouragement.webp" width="138" height="138" alt="">
    <div class="mascot-copy"><span class="mascot-label" data-mascot-label></span><h2 class="mascot-title" data-mascot-title></h2><p class="mascot-message" data-mascot-message></p></div>
    <div class="mascot-controls">
        <button class="mascot-icon-btn" type="button" data-mascot-sound aria-label="Silenciar sons" aria-pressed="false" title="Silenciar sons"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M11 5 6 9H3v6h3l5 4z"/><path data-sound-wave d="M15.5 8.5a5 5 0 0 1 0 7M18 6a8.5 8.5 0 0 1 0 12"/></svg></button>
        <button class="mascot-icon-btn" type="button" data-mascot-close aria-label="Fechar mensagem"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg></button>
    </div>
</aside>
<script>
(() => {
    const loader = () => document.querySelector('.ajax-loader');
    const setLoading = (active) => loader()?.classList.toggle('loading', active);
    const mascotToast = document.querySelector('[data-mascot-toast]');
    let mascotTimer;
    let audioContext;
    const mascotMessages = {
        error: [
            {image: 'try-again.webp', title: 'Quase lá!', message: 'Leia o diagnóstico, ajuste uma parte e tente de novo.'},
            {image: 'encouragement.webp', title: 'Errar faz parte!', message: 'Seu código está mais perto da resposta do que antes.'},
        ],
        success: [
            {image: 'success.webp', title: 'Mandou muito bem!', message: 'Exercício concluído e XP conquistado.'},
            {image: 'celebration.webp', title: 'Código aprovado!', message: 'Você venceu este desafio. Bora para o próximo?'},
        ],
    };

    function soundsMuted() {
        return localStorage.getItem('php-pratica:sounds-muted') === '1';
    }

    function updateSoundButton() {
        const muted = soundsMuted();
        const button = mascotToast.querySelector('[data-mascot-sound]');
        button.setAttribute('aria-pressed', String(muted));
        button.setAttribute('aria-label', muted ? 'Ativar sons' : 'Silenciar sons');
        button.title = muted ? 'Ativar sons' : 'Silenciar sons';
        mascotToast.querySelector('[data-sound-wave]').style.display = muted ? 'none' : '';
    }

    function playMascotSound(type) {
        if (soundsMuted()) return;
        try {
            audioContext ??= new (window.AudioContext || window.webkitAudioContext)();
            const now = audioContext.currentTime;
            const notes = type === 'success' ? [523.25, 659.25, 783.99] : [293.66, 246.94];
            notes.forEach((frequency, index) => {
                const oscillator = audioContext.createOscillator();
                const gain = audioContext.createGain();
                oscillator.type = type === 'success' ? 'sine' : 'triangle';
                oscillator.frequency.value = frequency;
                gain.gain.setValueAtTime(0.0001, now + index * .1);
                gain.gain.exponentialRampToValueAtTime(.08, now + index * .1 + .015);
                gain.gain.exponentialRampToValueAtTime(.0001, now + index * .1 + .18);
                oscillator.connect(gain).connect(audioContext.destination);
                oscillator.start(now + index * .1);
                oscillator.stop(now + index * .1 + .2);
            });
        } catch (error) {
            localStorage.setItem('php-pratica:sounds-muted', '1');
            updateSoundButton();
        }
    }

    function hideMascot() {
        clearTimeout(mascotTimer);
        if (!mascotToast.classList.contains('visible')) return;
        mascotToast.classList.add('leaving');
        setTimeout(() => {
            mascotToast.classList.remove('visible', 'leaving', 'error', 'success');
            mascotToast.setAttribute('aria-hidden', 'true');
        }, matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 210);
    }

    function showMascot(type) {
        const options = mascotMessages[type] || mascotMessages.error;
        const content = options[Math.floor(Math.random() * options.length)];
        clearTimeout(mascotTimer);
        mascotToast.classList.remove('visible', 'leaving', 'error', 'success');
        mascotToast.querySelector('[data-mascot-image]').src = `/images/mascots/${content.image}`;
        mascotToast.querySelector('[data-mascot-label]').textContent = type === 'success' ? 'Desafio concluído' : 'Nova tentativa';
        mascotToast.querySelector('[data-mascot-title]').textContent = content.title;
        mascotToast.querySelector('[data-mascot-message]').textContent = content.message;
        mascotToast.classList.add(type);
        mascotToast.setAttribute('aria-hidden', 'false');
        requestAnimationFrame(() => mascotToast.classList.add('visible'));
        playMascotSound(type);
        mascotTimer = setTimeout(hideMascot, type === 'success' ? 5200 : 4600);
    }

    updateSoundButton();

    async function navigate(url, push = true) {
        setLoading(true);
        try {
            const response = await fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}});
            if (!response.ok) throw new Error('Não foi possível abrir esta página.');
            const html = await response.text();
            const page = new DOMParser().parseFromString(html, 'text/html');
            document.querySelector('.shell').replaceWith(page.querySelector('.shell'));
            document.title = page.title;
            if (push) history.pushState({}, '', url);
            const hash = new URL(url, location.href).hash;
            if (hash) document.querySelector(hash)?.scrollIntoView({behavior: 'smooth'});
            else scrollTo({top: 0, behavior: 'smooth'});
        } catch (error) {
            location.href = url;
        } finally {
            setLoading(false);
        }
    }

    document.addEventListener('click', (event) => {
        if (event.target.closest('[data-mascot-close]')) {
            hideMascot();
            return;
        }
        if (event.target.closest('[data-mascot-sound]')) {
            localStorage.setItem('php-pratica:sounds-muted', soundsMuted() ? '0' : '1');
            updateSoundButton();
            if (!soundsMuted()) playMascotSound('success');
            return;
        }
        const reset = event.target.closest('[data-reset-editor]');
        if (reset) {
            event.preventDefault();
            const form = reset.closest('form');
            const bytes = Uint8Array.from(atob(form.dataset.starterCode), character => character.charCodeAt(0));
            const editor = form.querySelector('[name="code"]');
            editor.value = new TextDecoder().decode(bytes);
            localStorage.removeItem(editorStorageKey(editor));
            document.querySelector('#exercise-result').innerHTML = '';
            return;
        }

        const link = event.target.closest('a[href]');
        if (!link || event.defaultPrevented || event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || link.target || link.hasAttribute('download')) return;
        const url = new URL(link.href, location.href);
        if (url.origin !== location.origin) return;
        if (url.pathname === location.pathname && url.search === location.search) return;
        event.preventDefault();
        navigate(url.href);
    });

    document.addEventListener('submit', async (event) => {
        const profileForm = event.target.closest('[data-profile-form]');
        if (profileForm) {
            event.preventDefault();
            const button = event.submitter;
            const oldText = button.textContent;
            button.disabled = true; button.textContent = 'Salvando...'; setLoading(true);
            try {
                const response = await fetch(profileForm.action, {method: 'POST', body: new FormData(profileForm), headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}});
                const data = await response.json();
                const feedback = document.querySelector('#profile-feedback');
                if (!response.ok) {
                    feedback.innerHTML = '<p class="feedback bad" role="alert"></p>';
                    feedback.querySelector('p').textContent = Object.values(data.errors || {}).flat()[0] || data.message;
                    return;
                }
                feedback.innerHTML = '<p class="feedback ok">Nome atualizado com sucesso.</p>';
                document.querySelectorAll('.ranking-table tr.current .rank-name').forEach(cell => {
                    cell.childNodes[0].textContent = data.displayName;
                });
            } catch (error) {
                document.querySelector('#profile-feedback').innerHTML = '<p class="feedback bad">Falha de conexão. Tente novamente.</p>';
            } finally {
                button.disabled = false; button.textContent = oldText; setLoading(false);
            }
            return;
        }

        const form = event.target.closest('[data-async-form]');
        if (!form) return;
        event.preventDefault();
        const button = event.submitter;
        const action = button?.formAction || form.action;
        const oldText = button?.textContent;
        if (button) { button.disabled = true; button.textContent = 'Aguarde...'; }
        setLoading(true);

        try {
            const response = await fetch(action, {
                method: 'POST', body: new FormData(form),
                headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
            });
            const data = await response.json();
            if (!response.ok) {
                const message = Object.values(data.errors || {}).flat()[0] || data.message || 'Não foi possível concluir a ação.';
                document.querySelector('#exercise-result').innerHTML = `<section class="result-card"><div class="feedback bad" role="alert"></div></section>`;
                document.querySelector('#exercise-result .feedback').textContent = message;
                return;
            }
            document.querySelector('#exercise-result').innerHTML = data.html;
            if (data.gamification?.type) showMascot(data.gamification.type);
            document.querySelector('#exercise-result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
            if (data.stats) {
                document.querySelector('[data-progress-percent]').textContent = `${data.stats.percent}%`;
                document.querySelector('[data-progress-bar]').style.width = `${data.stats.percent}%`;
                document.querySelector('[data-progress-count]').textContent = `${data.stats.completed} de ${data.stats.total} exercícios`;
                document.querySelector('[data-xp]').textContent = `${data.stats.xp} XP`;
                const status = document.querySelector(`[data-exercise-id="${data.exerciseId}"] .exercise-status`);
                if (status && data.html.includes('Resposta correta!')) status.textContent = '✓';
            }
        } catch (error) {
            document.querySelector('#exercise-result').innerHTML = '<section class="result-card"><div class="feedback bad" role="alert">Falha de conexão. Tente novamente.</div></section>';
        } finally {
            if (button) { button.disabled = false; button.textContent = oldText; }
            setLoading(false);
        }
    });

    addEventListener('popstate', () => navigate(location.href, false));

    function editorStorageKey(editor) {
        return `php-pratica:${location.pathname}:${editor.name}`;
    }

    function restoreEditors() {
        document.querySelectorAll('textarea.editor').forEach(editor => {
            const saved = localStorage.getItem(editorStorageKey(editor));
            if (saved && !editor.dataset.restored) editor.value = saved;
            editor.dataset.restored = '1';
        });
    }

    document.addEventListener('input', event => {
        if (event.target.matches('textarea.editor')) localStorage.setItem(editorStorageKey(event.target), event.target.value);
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && mascotToast.classList.contains('visible')) {
            hideMascot();
            return;
        }
        const editor = event.target.closest('textarea.editor');
        if (!editor) return;

        if (event.key === 'Tab') {
            event.preventDefault();
            const start = editor.selectionStart;
            const end = editor.selectionEnd;
            if (event.shiftKey) {
                const lineStart = editor.value.lastIndexOf('\n', start - 1) + 1;
                const removable = editor.value.slice(lineStart, lineStart + 4).match(/^ {1,4}|^\t/)?.[0] || '';
                if (removable) editor.setRangeText('', lineStart, lineStart + removable.length, 'preserve');
            } else if (start !== end && editor.value.slice(start, end).includes('\n')) {
                const lineStart = editor.value.lastIndexOf('\n', start - 1) + 1;
                const selected = editor.value.slice(lineStart, end).replace(/^/gm, '    ');
                editor.setRangeText(selected, lineStart, end, 'select');
            } else {
                editor.setRangeText('    ', start, end, 'end');
            }
            editor.dispatchEvent(new Event('input', {bubbles: true}));
        }

        if (event.key === 'Enter') {
            const before = editor.value.slice(0, editor.selectionStart);
            const currentLine = before.split('\n').pop();
            const indent = currentLine.match(/^\s*/)?.[0] || '';
            const extra = currentLine.trimEnd().endsWith('{') ? '    ' : '';
            if (indent || extra) {
                event.preventDefault();
                editor.setRangeText(`\n${indent}${extra}`, editor.selectionStart, editor.selectionEnd, 'end');
                editor.dispatchEvent(new Event('input', {bubbles: true}));
            }
        }
    });

    restoreEditors();
    new MutationObserver(restoreEditors).observe(document.querySelector('.content'), {childList:true, subtree:true});
})();
</script>
</body></html>
