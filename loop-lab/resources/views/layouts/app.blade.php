<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Loop Lab')</title>
    <style>
        :root{--navy:#08162e;--navy2:#102445;--blue:#2563eb;--blue2:#1d4ed8;--cyan:#22d3ee;--orange:#f97316;--bg:#f4f7fb;--surface:#fff;--text:#172033;--muted:#526078;--line:#dbe3ef;--ok:#047857;--bad:#b42318}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--text);font:16px/1.6 Inter,Arial,sans-serif}button,input,textarea{font:inherit}a{color:inherit;text-decoration:none}.shell{display:grid;grid-template-columns:278px 1fr;min-height:100vh}.sidebar{background:linear-gradient(180deg,#071225 0%,#08162e 100%);color:#e7eefc;padding:22px 16px;position:sticky;top:0;height:100vh;overflow:auto;border-right:1px solid rgba(255,255,255,.06)}.brand{display:flex;align-items:center;gap:10px;font-size:20px;font-weight:800;margin:0 4px 18px}.brand span{color:var(--cyan)}.sidebar-card{background:rgba(16,36,69,.92);padding:16px;border:1px solid rgba(255,255,255,.06);border-radius:16px;box-shadow:inset 0 1px 0 rgba(255,255,255,.05);margin-bottom:18px}.sidebar-card p{margin:4px 0 0;color:#b9c7dc;font-size:13px;line-height:1.45}.progress{margin-bottom:0}.progress-row{display:flex;align-items:baseline;justify-content:space-between;gap:12px;font-size:14px}.progress-row strong{font-size:16px}.bar{height:8px;background:#243752;border-radius:99px;overflow:hidden;margin-top:10px}.bar>span{display:block;height:100%;background:linear-gradient(90deg,var(--cyan),#60a5fa);border-radius:99px}.sidebar-section{margin-top:20px}.sidebar-heading{margin:0 4px 10px;color:#91a4c3;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.1em}.sidebar-note{margin:0 4px 14px;color:#b9c7dc;font-size:13px;line-height:1.45}.module-group{margin-bottom:10px;border:1px solid transparent;border-radius:16px;overflow:hidden;background:rgba(255,255,255,.02)}.module-group[open]{background:rgba(255,255,255,.03);border-color:rgba(255,255,255,.06)}.module-summary{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 12px 12px 14px;cursor:pointer;list-style:none;user-select:none}.module-summary::-webkit-details-marker{display:none}.module-summary strong{display:block;font-size:14px;line-height:1.25}.module-summary small{display:block;color:#91a4c3;font-size:12px;font-weight:700;margin-top:2px}.module-badge{display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:30px;padding:0 9px;border-radius:999px;background:rgba(255,255,255,.08);color:#d5e0f2;font-size:12px;font-weight:800}.module-group[open] .module-badge{background:rgba(34,211,238,.16);color:#dffcff}.module-lessons{display:grid;gap:6px;padding:0 10px 12px}.nav-link{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px 12px;border-radius:12px;color:#d5e0f2;background:rgba(255,255,255,.02)}.nav-link:hover,.nav-link.active{background:var(--navy2);color:#fff}.nav-link.completed{color:#a9b9d0;opacity:.82}.nav-link.completed .nav-status{background:rgba(148,163,184,.15);color:#cbd5e1}.nav-link.locked{opacity:.55}.nav-status{display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:24px;padding:0 8px;border-radius:999px;background:rgba(37,99,235,.14);color:#bfdbfe;font-size:11px;font-weight:900;flex-shrink:0}.nav-link.active .nav-status{background:#fff;color:var(--blue)}.nav-link.completed .nav-status{background:rgba(34,197,94,.14);color:#d1fae5}.content{min-width:0}.topbar{height:72px;padding:0 36px;display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,.9);border-bottom:1px solid var(--line);position:sticky;top:0;z-index:10;backdrop-filter:blur(12px)}.topbar strong{color:var(--blue)}.mobile-title{display:none}.page{width:min(1120px,calc(100% - 48px));margin:0 auto;padding:36px 0 64px}.eyebrow{color:var(--blue);font-weight:800;text-transform:uppercase;font-size:13px;letter-spacing:.08em}h1{font-size:clamp(32px,5vw,48px);line-height:1.12;margin:8px 0 12px}h2{font-size:24px;line-height:1.25;margin:0 0 14px}h3{margin:0 0 10px}.lead{font-size:18px;color:var(--muted);max-width:760px}.card{background:var(--surface);border:1px solid var(--line);border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(20,38,70,.06)}.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.stats{margin:28px 0}.stat strong{display:block;font-size:30px}.stat span{color:var(--muted)}.btn{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:10px 18px;border:1px solid transparent;border-radius:10px;font-weight:800;cursor:pointer;transition:.2s}.btn-primary{background:var(--blue);color:#fff}.btn-primary:hover{background:var(--blue2)}.btn-secondary{background:#fff;border-color:var(--line);color:var(--text)}.btn-secondary:hover{border-color:var(--blue);color:var(--blue)}.btn-warn{background:#fff7ed;border-color:#fed7aa;color:#9a3412}.hero-actions,.actions{display:flex;gap:10px;flex-wrap:wrap}.course-card{margin-top:24px;display:flex;align-items:center;justify-content:space-between;gap:24px}.course-card p{color:var(--muted)}.badge{display:inline-block;padding:4px 10px;border-radius:999px;background:#dbeafe;color:#1e40af;font-size:13px;font-weight:800}.stack{display:grid;gap:20px}.code{background:#0b1220;color:#dbeafe;border-radius:12px;padding:18px;overflow:auto;font:14px/1.7 Consolas,monospace;white-space:pre}.line-list{padding-left:22px}.line-list li{margin:8px 0}.warning{padding:14px 16px;border-left:4px solid var(--orange);background:#fff7ed;border-radius:8px}.editor{width:100%;min-height:390px;padding:22px;border:0;background:#0b1220;color:#dbeafe;font:15px/1.65 Consolas,monospace;resize:vertical;tab-size:4}.editor:focus{outline:3px solid #93c5fd;outline-offset:-3px}.output{min-height:90px;background:#07101f;color:#dbeafe;padding:16px;border-radius:10px;white-space:pre-wrap;font:14px/1.6 Consolas,monospace}.feedback{padding:20px;border-radius:12px}.feedback h2{margin-bottom:6px}.feedback.ok{background:#ecfdf3;color:#065f46;border:1px solid #a7f3d0}.feedback.bad{background:#fff1f0;color:#912018;border:1px solid #fecaca}.compare{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin:14px 0}.compare pre{white-space:pre-wrap;background:#fff;padding:12px;border-radius:8px;color:var(--text);overflow:auto}.hints details,.solution{border-top:1px solid var(--line);padding:14px 0}.hints summary,.solution summary{cursor:pointer;font-weight:800}.step{display:grid;grid-template-columns:72px 1fr;gap:12px;padding:12px 0;border-top:1px solid var(--line)}.step strong{color:var(--blue)}.security-note{font-size:14px;color:var(--muted)}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
        .ajax-loader{position:fixed;z-index:100;top:0;left:0;width:100%;height:3px;background:var(--blue);transform:scaleX(0);transform-origin:left;opacity:0;transition:transform .25s,opacity .2s}.ajax-loader.loading{transform:scaleX(.75);opacity:1}.page-jump{display:flex;gap:8px;margin:26px 0 42px;padding:6px;background:#e8eef8;border-radius:12px;width:max-content}.page-jump a{padding:8px 16px;border-radius:8px;font-weight:800}.page-jump a:hover{background:#fff;color:var(--blue)}.lesson-section{scroll-margin-top:94px}.section-heading{display:flex;align-items:center;gap:16px;margin-bottom:20px}.section-heading h2,.section-heading p{margin:0}.section-number{display:grid;place-items:center;width:48px;height:48px;border-radius:14px;background:var(--blue);color:#fff;font-size:22px;font-weight:900}.learning-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px}.learning-intro{box-shadow:none}.learning-code .card{min-width:0}.lesson-detail{margin-top:14px;padding:0}.lesson-detail>summary{padding:20px 24px;font-size:17px;font-weight:800;cursor:pointer;list-style-position:inside}.lesson-detail[open]{padding:0 24px 24px}.lesson-detail[open]>summary{margin:0 -24px 18px;border-bottom:1px solid var(--line)}.practice-section{margin-top:64px;padding-top:36px;border-top:1px solid var(--line)}
        .exercise-list{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:20px}.exercise-item{display:flex;align-items:center;gap:12px;min-height:72px;padding:12px;border:1px solid var(--line);border-radius:12px;background:#fff}.exercise-item:hover{border-color:#93c5fd}.exercise-item.active{border:2px solid var(--blue);background:#eff6ff}.exercise-item small{display:block;color:var(--muted)}.exercise-status{display:grid;place-items:center;flex:0 0 34px;height:34px;border-radius:10px;background:#e8eef8;color:var(--blue);font-weight:900}.exercise-item.active .exercise-status{background:var(--blue);color:#fff}.exercise-workspace{display:grid;grid-template-columns:minmax(280px,.72fr) minmax(0,1.28fr);border:1px solid var(--line);border-radius:18px;background:#fff;overflow:hidden;box-shadow:0 16px 40px rgba(20,38,70,.09)}.exercise-brief{padding:28px;background:#fbfcfe;border-right:1px solid var(--line)}.exercise-kicker{display:flex;justify-content:space-between;align-items:center;color:var(--muted);font-size:14px;font-weight:800}.exercise-brief h2{font-size:28px;margin-top:20px}.task-box{padding:18px;border-radius:12px;background:#eff6ff;border-left:4px solid var(--blue)}.task-box p{margin:5px 0 0;font-size:17px}.task-label{color:var(--blue2);font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.08em}.rules-box{margin-top:22px}.rules-box ul{padding-left:20px}.workflow-tip{margin-top:24px;padding-top:18px;border-top:1px solid var(--line);color:var(--muted);font-size:14px}.editor-card{min-width:0;background:#0b1220}.editor-heading{height:50px;display:flex;align-items:center;gap:18px;padding:0 18px;color:#a8b4c8;background:#111c30;border-bottom:1px solid #25334a;font:13px Consolas,monospace}.editor-dot{display:inline-block;width:10px;height:10px;margin-right:6px;border-radius:50%;background:#475569}.editor-help{margin:0;padding:9px 18px;color:#91a4bd;background:#111c30;font-size:13px}.editor-actions{display:flex;justify-content:space-between;gap:12px;padding:16px;background:#fff;border-top:1px solid var(--line)}.actions-secondary{display:flex;gap:8px}.btn-quiet{color:var(--muted);background:transparent}.btn-quiet:hover{background:#f1f5f9}.result-card,.help-card{margin-top:20px;padding:24px;border:1px solid var(--line);border-radius:16px;background:#fff}.result-heading{display:flex;gap:14px;align-items:center;margin-bottom:16px}.result-heading h2{margin:0}.result-icon{display:grid;place-items:center;width:44px;height:44px;border-radius:12px;background:#0b1220;color:var(--cyan);font:800 16px Consolas,monospace}.next-step{margin-top:18px;padding:18px;border:1px solid #bfdbfe;border-radius:12px;background:#fff}.next-step h3,.next-step p{margin:4px 0 12px}.help-card{display:grid;grid-template-columns:280px 1fr;gap:28px}.help-card h2{margin-bottom:4px}.help-card p{color:var(--muted)}.profile-form{display:flex;gap:10px;align-items:end}.profile-form label{display:block;font-weight:800}.profile-form input{min-height:46px;padding:9px 12px;border:1px solid var(--line);border-radius:10px}.ranking-table{width:100%;border-collapse:collapse}.ranking-table th,.ranking-table td{padding:15px 12px;border-bottom:1px solid var(--line);text-align:left}.ranking-table th{color:var(--muted);font-size:13px;text-transform:uppercase}.ranking-table tr.current{background:#eff6ff}.rank-position{font-weight:900;color:var(--blue)}.rank-name{font-weight:800}.rank-you{margin-left:7px;padding:2px 7px;border-radius:99px;background:#dbeafe;color:#1e40af;font-size:11px}.empty-ranking{text-align:center;padding:42px;color:var(--muted)}
        .mascot-toast{--mascot-accent:#2563eb;position:fixed;right:24px;bottom:24px;z-index:1000;display:grid;grid-template-columns:138px minmax(210px,300px);align-items:center;gap:6px;width:min(470px,calc(100vw - 32px));padding:16px 18px 16px 8px;border:2px solid color-mix(in srgb,var(--mascot-accent) 32%,white);border-radius:28px;background:rgba(255,255,255,.96);box-shadow:0 24px 70px rgba(8,22,46,.24),inset 0 -4px 0 rgba(15,23,42,.06);backdrop-filter:blur(12px);transform:translateY(28px) scale(.94);opacity:0;visibility:hidden;pointer-events:none}.mascot-toast.visible{animation:mascot-enter .38s cubic-bezier(.2,.9,.25,1.2) forwards;visibility:visible;pointer-events:auto}.mascot-toast.leaving{animation:mascot-exit .2s ease-in forwards}.mascot-toast.error{--mascot-accent:#dc2626}.mascot-toast.success{--mascot-accent:#2563eb}.mascot-image{display:block;width:138px;height:138px;object-fit:contain;filter:drop-shadow(0 10px 12px rgba(15,23,42,.2));transform-origin:bottom center}.mascot-toast.visible .mascot-image{animation:mascot-react .55s .12s cubic-bezier(.2,.8,.2,1) both}.mascot-copy{min-width:0;padding-right:10px}.mascot-label{display:block;margin-bottom:3px;color:var(--mascot-accent);font-size:12px;font-weight:900;letter-spacing:.1em;text-transform:uppercase}.mascot-title{margin:0 0 4px;font-size:22px;line-height:1.15}.mascot-message{margin:0;color:var(--muted);font-size:15px;line-height:1.45}.mascot-controls{position:absolute;top:10px;right:10px;display:flex;gap:4px}.mascot-icon-btn{display:grid;place-items:center;width:44px;height:44px;padding:0;border:0;border-radius:50%;background:transparent;color:#475569;cursor:pointer}.mascot-icon-btn:hover{background:#eef2f7;color:var(--text)}.mascot-icon-btn:focus-visible{outline:3px solid #93c5fd;outline-offset:1px}.mascot-icon-btn svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}@keyframes mascot-enter{to{opacity:1;transform:translateY(0) scale(1)}}@keyframes mascot-exit{to{opacity:0;transform:translateY(16px) scale(.97)}}@keyframes mascot-react{0%{transform:scale(.82) rotate(-4deg)}55%{transform:scale(1.08) rotate(3deg)}100%{transform:scale(1) rotate(0)}}
        @media(max-width:900px){.shell{grid-template-columns:1fr}.sidebar{position:static;height:auto;border-right:0;border-bottom:1px solid rgba(255,255,255,.06)}.topbar{padding:0 20px}.mobile-title{display:block}.page{width:min(100% - 28px,720px)}.grid,.learning-grid,.exercise-workspace,.help-card{grid-template-columns:1fr}.exercise-list{grid-template-columns:1fr}.exercise-brief{border-right:0;border-bottom:1px solid var(--line)}.course-card{align-items:flex-start;flex-direction:column}}@media(max-width:560px){.page-jump{width:100%}.page-jump a{flex:1;text-align:center}.editor-actions{align-items:stretch;flex-direction:column-reverse}.actions-secondary{display:grid;grid-template-columns:1fr 1fr}.editor-actions>.btn{width:100%}.compare{grid-template-columns:1fr}.editor{min-height:320px}.section-heading{align-items:flex-start}.mascot-toast{right:16px;bottom:16px;grid-template-columns:104px 1fr;padding:12px 12px 12px 4px;border-radius:22px}.mascot-image{width:104px;height:116px}.mascot-title{font-size:18px}.mascot-message{font-size:14px}.mascot-controls{top:4px;right:4px}.mascot-copy{padding:34px 4px 0 0}}@media(prefers-reduced-motion:reduce){*{scroll-behavior:auto!important;transition:none!important}.mascot-toast.visible,.mascot-toast.leaving,.mascot-toast.visible .mascot-image{animation:none!important}.mascot-toast.visible{opacity:1;transform:none}.mascot-toast.leaving{opacity:0}}
    </style>
    <style>
        .reward-hero{display:grid;grid-template-columns:minmax(0,1fr) 300px;gap:24px;align-items:stretch;margin-bottom:24px}.reward-balance{display:flex;flex-direction:column;justify-content:center;padding:24px;border-radius:24px;background:linear-gradient(145deg,#1d4ed8,#2563eb 55%,#4f46e5);color:#fff;box-shadow:0 18px 40px rgba(37,99,235,.24)}.reward-balance span{font-weight:800}.reward-balance strong{font-size:38px;line-height:1.15;margin:6px 0}.reward-balance small{color:#dbeafe}.reward-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin:20px 0 42px}.reward-stat{padding:20px;border:1px solid var(--line);border-radius:18px;background:#fff;box-shadow:0 8px 24px rgba(20,38,70,.05)}.reward-stat span,.reward-stat small{display:block;color:var(--muted)}.reward-stat strong{display:block;font-size:30px;margin:3px 0}.reward-section-heading{display:flex;align-items:end;justify-content:space-between;gap:24px;margin-bottom:20px}.reward-section-heading h2{margin-bottom:0}.reward-section-heading p{max-width:440px;margin:0;color:var(--muted)}.reward-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}.reward-card{--reward-accent:#2563eb;display:flex;flex-direction:column;gap:16px;min-width:0;padding:22px;border:1px solid var(--line);border-top:4px solid var(--reward-accent);border-radius:20px;background:#fff;box-shadow:0 12px 30px rgba(20,38,70,.07);transition:transform .2s ease,box-shadow .2s ease}.reward-card:hover{transform:translateY(-3px);box-shadow:0 18px 38px rgba(20,38,70,.12)}.reward-card.redeemed{background:#f8fafc;border-color:#cbd5e1}.reward-blue{--reward-accent:#2563eb}.reward-cyan{--reward-accent:#0891b2}.reward-orange{--reward-accent:#ea580c}.reward-pink{--reward-accent:#db2777}.reward-violet{--reward-accent:#7c3aed}.reward-gold{--reward-accent:#ca8a04}.reward-icon{display:grid;place-items:center;width:52px;height:52px;border-radius:16px;background:color-mix(in srgb,var(--reward-accent) 12%,white);color:var(--reward-accent)}.reward-icon svg{width:27px;height:27px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linejoin:round}.reward-card-copy{flex:1}.reward-category{color:var(--reward-accent);font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.08em}.reward-card h3{font-size:20px;line-height:1.25;margin:4px 0 8px}.reward-card p{margin:0;color:var(--muted)}.reward-cost-row{display:flex;align-items:center;justify-content:space-between;gap:12px}.reward-cost-row strong{font-size:19px}.reward-cost-row span{color:var(--muted);font-size:12px;font-weight:800;text-align:right}.reward-progress{height:8px;border-radius:99px;background:#e5eaf2;overflow:hidden}.reward-progress span{display:block;height:100%;border-radius:inherit;background:var(--reward-accent)}.reward-button{width:100%}.reward-button:disabled{cursor:not-allowed;opacity:.6}.reward-history{margin-top:46px;padding:24px;border:1px solid var(--line);border-radius:20px;background:#fff}.reward-history-list{display:grid;gap:10px}.reward-history-list article{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:14px 0;border-top:1px solid var(--line)}.reward-history-list article div span{display:block;color:var(--muted);font-size:13px}.reward-history-list code{padding:6px 10px;border-radius:8px;background:#eef2ff;color:#3730a3;font-weight:900}.reward-toast{margin:0 0 20px}.reward-toast strong{display:block;font-size:18px}@media(max-width:980px){.reward-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:720px){.reward-hero{grid-template-columns:1fr}.reward-stats,.reward-grid{grid-template-columns:1fr}.reward-section-heading{align-items:flex-start;flex-direction:column}.reward-history-list article{align-items:flex-start;flex-direction:column}}@media(prefers-reduced-motion:reduce){.reward-card{transition:none}.reward-card:hover{transform:none}}
    </style>
    <style>
        :root{--navy:#111827;--navy2:#1f2937;--blue:#4f46e5;--blue2:#4338ca;--cyan:#34d399;--green:#22c55e;--gold:#d99a1b;--bg:#f6f7fb;--surface:#fff;--text:#172033;--muted:#667085;--line:#e5e7eb}
        body{background:var(--bg);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}.shell{grid-template-columns:264px minmax(0,1fr)}
        .sidebar{display:flex;flex-direction:column;padding:24px 14px 16px;background:linear-gradient(180deg,#111827,#0f172a);overflow-x:hidden}.brand{margin:0 8px 26px;gap:12px;color:#fff}.brand-mark{display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:linear-gradient(145deg,#6366f1,#4f46e5);box-shadow:0 8px 18px rgba(79,70,229,.32);font:900 21px/1 ui-monospace,monospace}.brand-copy{display:grid;font-size:17px;line-height:1.1}.brand-copy small{margin-top:3px;color:#94a3b8;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
        .primary-nav{display:grid;gap:4px}.primary-link{display:flex;align-items:center;gap:12px;min-height:46px;padding:10px 12px;border-radius:12px;color:#cbd5e1;font-size:14px;font-weight:750;transition:background .2s,color .2s,transform .2s}.primary-link svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}.primary-link:hover{background:rgba(255,255,255,.07);color:#fff;transform:translateX(2px)}.primary-link.active{background:#4f46e5;color:#fff;box-shadow:0 8px 20px rgba(79,70,229,.24)}.primary-link.active-secondary{color:#fff;background:rgba(79,70,229,.15)}.primary-link.ranking-link svg,.primary-link.reward-link svg{color:#fbbf24}.primary-link.ranking-link.active,.primary-link.reward-link.active{background:#3a2d14;color:#fde68a;box-shadow:none}
        .course-tree{margin-top:24px;padding-top:20px;border-top:1px solid rgba(255,255,255,.08)}.sidebar-heading{margin:0 12px 10px;color:#64748b}.module-group{margin-bottom:3px;background:transparent;border-radius:12px}.module-group[open]{background:rgba(255,255,255,.035);border-color:transparent}.module-summary{padding:10px 12px;color:#cbd5e1}.module-summary strong{font-size:13px}.module-summary small{font-size:11px;color:#64748b}.module-chevron{color:#64748b;font-size:18px;transition:transform .2s}.module-group[open] .module-chevron{transform:rotate(180deg)}.module-lessons{padding:0 8px 9px 18px}.nav-link{min-height:38px;padding:8px 9px;border-radius:9px;background:transparent;color:#94a3b8;font-size:12px}.nav-link:hover,.nav-link.active{background:rgba(79,70,229,.18);color:#fff}.nav-status{min-width:22px;height:22px;padding:0 6px;background:rgba(255,255,255,.06);color:#94a3b8;font-size:10px}.nav-link.active .nav-status{background:#4f46e5;color:#fff}
        .sidebar-profile{display:grid;grid-template-columns:38px 1fr auto;align-items:center;gap:10px;margin-top:auto;padding:14px 8px 2px;border-top:1px solid rgba(255,255,255,.08)}.profile-avatar{display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#334155;color:#fff;font-weight:900}.profile-copy{display:grid;min-width:0;line-height:1.2}.profile-copy strong{overflow:hidden;color:#f8fafc;font-size:13px;text-overflow:ellipsis;white-space:nowrap}.profile-copy small{margin-top:4px;color:#64748b;font-size:10px}.profile-level{padding:4px 6px;border-radius:7px;background:rgba(34,197,94,.12);color:#86efac;font-size:9px;font-weight:900}
        .topbar{height:68px;padding:0 32px;background:rgba(255,255,255,.92)}.topbar-context{color:#667085;font-size:14px;font-weight:700}.topbar-actions{display:flex;align-items:center;gap:12px}.topbar-actions form{display:flex}.topbar-xp{display:flex;align-items:center;gap:7px;padding:7px 11px;border-radius:10px;background:#ecfdf3;color:#15803d;font-size:13px;font-weight:900}.topbar-xp svg{width:17px;height:17px;fill:#22c55e;stroke:#15803d;stroke-width:1}.topbar-login{font-size:14px;font-weight:800;color:var(--blue)}.page{width:min(1180px,calc(100% - 56px));padding:38px 0 70px}h1{letter-spacing:-.035em}.btn:focus-visible,a:focus-visible,summary:focus-visible{outline:3px solid #a5b4fc;outline-offset:2px}
        .dashboard-heading{display:flex;align-items:flex-start;justify-content:space-between;gap:24px;margin-bottom:26px}.dashboard-heading h1{font-size:clamp(32px,4vw,44px);margin:5px 0}.dashboard-heading .lead{margin:0;font-size:16px}.streak-pill{display:flex;align-items:center;gap:9px;padding:10px 14px;border:1px solid #fed7aa;border-radius:12px;background:#fff7ed;color:#9a3412;font-size:13px;font-weight:700}.streak-pill svg{width:22px;height:22px;fill:#f97316;stroke:#c2410c;stroke-width:1}.streak-pill strong{font-size:16px}
        .dashboard-grid{display:grid;grid-template-columns:minmax(0,1.75fr) minmax(250px,.65fr);gap:20px}.mission-hero{position:relative;display:grid;grid-template-columns:minmax(0,1fr) 190px;min-height:330px;overflow:hidden;border-radius:24px;background:linear-gradient(135deg,#4338ca 0%,#4f46e5 58%,#6366f1 100%);color:#fff;box-shadow:0 18px 40px rgba(79,70,229,.2)}.mission-copy{position:relative;z-index:2;padding:30px}.mission-label{display:inline-flex;padding:5px 10px;border:1px solid rgba(255,255,255,.2);border-radius:999px;background:rgba(255,255,255,.12);font-size:11px;font-weight:900;letter-spacing:.08em;text-transform:uppercase}.mission-path{margin:18px 0 3px!important;color:#c7d2fe!important;font-size:12px;font-weight:800}.mission-copy h2{max-width:520px;margin:0 0 8px;font-size:29px}.mission-copy>p{max-width:580px;margin:0 0 20px;color:#e0e7ff}.mission-progress-row{display:flex;justify-content:space-between;max-width:500px;color:#e0e7ff;font-size:12px;font-weight:800}.dashboard-progress{max-width:500px;height:8px;margin:7px 0 22px;overflow:hidden;border-radius:99px;background:rgba(15,23,42,.28)}.dashboard-progress span{display:block;height:100%;border-radius:inherit;background:#34d399;box-shadow:0 0 15px rgba(52,211,153,.55)}.mission-button{gap:8px;min-height:43px;background:#fff;color:#3730a3}.mission-button:hover{background:#eef2ff;transform:translateY(-1px)}.mission-button svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2}.mission-art{position:relative;display:grid;place-items:center}.mission-art>span{position:relative;z-index:2;display:grid;place-items:center;width:116px;height:116px;border:1px solid rgba(255,255,255,.26);border-radius:32px;background:rgba(255,255,255,.14);box-shadow:inset 0 1px 0 rgba(255,255,255,.3),0 20px 40px rgba(30,27,75,.25);transform:rotate(-7deg);font:900 24px/1 ui-monospace,monospace}.mission-orbit{position:absolute;border:1px solid rgba(255,255,255,.13);border-radius:50%}.orbit-one{width:210px;height:210px}.orbit-two{width:280px;height:280px}
        .level-card{display:flex;flex-direction:column;align-items:center;padding:24px;border:1px solid var(--line);border-radius:24px;background:#fff;box-shadow:0 12px 32px rgba(15,23,42,.06)}.level-card-top{display:flex;align-self:stretch;justify-content:space-between;color:var(--muted);font-size:12px;font-weight:800}.level-card-top strong{color:var(--blue)}.level-ring{display:grid;place-items:center;width:154px;height:154px;margin:23px 0 17px;border-radius:50%;background:conic-gradient(#22c55e var(--level-progress),#e9eef5 0);box-shadow:inset 0 0 0 1px rgba(15,23,42,.03)}.level-ring:before{content:"";grid-area:1/1;width:126px;height:126px;border-radius:50%;background:#fff}.level-ring div{z-index:1;grid-area:1/1;display:grid;text-align:center}.level-ring strong{font-size:28px;line-height:1.1}.level-ring span{color:var(--muted);font-size:11px;font-weight:700}.level-card p{margin:0 0 14px;color:var(--muted);font-size:12px;text-align:center}.level-card a{margin-top:auto;color:var(--blue);font-size:13px;font-weight:900}
        .dashboard-section{margin-top:36px}.dashboard-section-heading,.panel-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin-bottom:15px}.dashboard-section-heading h2,.panel-heading h2{margin:3px 0 0}.section-counter{padding:6px 10px;border-radius:9px;background:#eef2ff;color:#4338ca;font-size:11px;font-weight:900}.daily-missions{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}.daily-mission{display:grid;grid-template-columns:44px minmax(0,1fr) auto;align-items:center;gap:12px;padding:16px;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 7px 20px rgba(15,23,42,.035);transition:transform .2s,border-color .2s,box-shadow .2s}.daily-mission:hover{border-color:#c7d2fe;box-shadow:0 12px 25px rgba(15,23,42,.08);transform:translateY(-2px)}.mission-icon{display:grid;place-items:center;width:44px;height:44px;border-radius:13px}.mission-icon svg,.journey-icon svg{width:23px;height:23px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}.mission-icon-green{background:#ecfdf3;color:#16a34a}.mission-icon-blue{background:#eef2ff;color:#4f46e5}.mission-icon-amber{background:#fff7ed;color:#ea580c}.daily-copy{display:grid;min-width:0;line-height:1.3}.daily-copy strong{font-size:13px}.daily-copy small{overflow:hidden;margin-top:4px;color:var(--muted);font-size:11px;text-overflow:ellipsis;white-space:nowrap}.xp-chip{padding:4px 7px;border-radius:8px;background:#ecfdf3;color:#15803d;font-size:10px;font-weight:900}.mission-fraction{color:var(--blue);font-size:12px;font-weight:900}
        .dashboard-lower-grid{display:grid;grid-template-columns:1.15fr .85fr;gap:20px;margin-top:36px}.dashboard-panel{padding:23px;border:1px solid var(--line);border-radius:20px;background:#fff;box-shadow:0 10px 28px rgba(15,23,42,.05)}.panel-heading a,.journey-link{color:var(--blue);font-size:12px;font-weight:900}.eyebrow-gold{color:#b7791f}.podium-list{display:grid;gap:8px}.podium-entry{display:grid;grid-template-columns:26px 38px 1fr auto;align-items:center;gap:10px;padding:10px;border-radius:12px}.podium-entry.current{background:#eef2ff}.podium-position{color:#b7791f;font-size:15px;font-weight:900;text-align:center}.podium-entry:first-child .podium-position{color:#d99a1b}.podium-avatar{display:grid;place-items:center;width:36px;height:36px;border-radius:11px;background:#f1f5f9;color:#475569;font-size:13px;font-weight:900}.podium-name{display:grid;line-height:1.25}.podium-name strong{font-size:13px}.podium-name small{color:var(--muted);font-size:10px}.podium-xp{color:#475569;font-size:12px}.your-position{margin:13px 0 0;padding-top:13px;border-top:1px solid var(--line);color:var(--muted);font-size:12px}.your-position strong{color:#b7791f}.empty-dashboard{color:var(--muted);font-size:13px}.journey-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:8px 0 20px}.journey-stats>div{display:grid;justify-items:center;padding:14px 6px;border-radius:14px;background:#f8fafc;text-align:center}.journey-icon{display:grid;place-items:center;width:36px;height:36px;margin-bottom:7px;border-radius:11px;background:#eef2ff;color:#4f46e5}.journey-stats strong{font-size:20px}.journey-stats small{color:var(--muted);font-size:9px;line-height:1.3}.journey-link{display:flex;justify-content:space-between;padding-top:14px;border-top:1px solid var(--line)}
        .topbar-xp.xp-pop{animation:xp-pop .55s ease}@keyframes xp-pop{50%{transform:scale(1.14);background:#dcfce7;box-shadow:0 0 0 8px rgba(34,197,94,.1)}}
        @media(max-width:1050px){.dashboard-grid{grid-template-columns:1fr}.level-card{display:grid;grid-template-columns:auto 150px 1fr auto;gap:18px;align-items:center}.level-card-top{display:grid}.level-ring{width:110px;height:110px;margin:0}.level-ring:before{width:90px;height:90px}.level-ring strong{font-size:22px}.daily-missions{grid-template-columns:1fr}.dashboard-lower-grid{grid-template-columns:1fr}}
        @media(max-width:900px){.shell{grid-template-columns:1fr}.sidebar{position:static;display:block;height:auto;padding:12px 14px}.brand{margin:0 4px 12px}.brand-mark{width:34px;height:34px}.primary-nav{display:flex;gap:6px;overflow-x:auto;padding-bottom:3px;scrollbar-width:none}.primary-link{flex:0 0 auto;min-height:40px;padding:8px 11px}.primary-link:hover{transform:none}.course-tree,.sidebar-profile{display:none}.topbar{top:0}.topbar-context{display:none}.mobile-title{display:block;font-weight:900}.page{width:min(100% - 28px,760px)}}
        @media(max-width:620px){.topbar{height:60px;padding:0 14px}.topbar-xp{padding:6px 8px}.dashboard-heading{display:grid}.streak-pill{width:max-content}.mission-hero{grid-template-columns:1fr;min-height:0}.mission-copy{padding:24px}.mission-art{display:none}.level-card{display:flex}.level-card-top{display:flex}.level-ring{width:132px;height:132px;margin:13px 0}.level-ring:before{width:108px;height:108px}.dashboard-section-heading{align-items:flex-start}.daily-mission{grid-template-columns:40px minmax(0,1fr) auto;padding:13px}.mission-icon{width:40px;height:40px}.dashboard-panel{padding:18px}.journey-stats{grid-template-columns:1fr}.journey-stats>div{grid-template-columns:36px auto 1fr;align-items:center;justify-items:start;gap:10px;text-align:left}.journey-icon{margin:0}.podium-entry{grid-template-columns:20px 34px 1fr auto;padding:8px 3px}.topbar-actions .btn{padding:7px;min-height:38px}}
        @media(prefers-reduced-motion:reduce){.primary-link,.daily-mission,.topbar-xp{transition:none!important;animation:none!important}.primary-link:hover,.daily-mission:hover{transform:none}}
    </style>
    <style>
        /* Identidade visual compartilhada por todas as áreas de estudo */
        body{background-color:#f5f6fb;background-image:radial-gradient(circle at 78% 4%,rgba(99,102,241,.09),transparent 28rem),radial-gradient(circle at 35% 95%,rgba(34,197,94,.06),transparent 24rem)}
        .brand{gap:11px}.brand-emblem{display:grid;place-items:center;width:42px;height:42px;flex:0 0 42px;border:1px solid rgba(255,255,255,.18);border-radius:14px;background:linear-gradient(145deg,#6366f1,#4338ca);box-shadow:0 9px 20px rgba(79,70,229,.38),inset 0 1px 0 rgba(255,255,255,.25)}.brand-emblem svg{width:32px;height:32px;fill:none;stroke:#fff;stroke-width:2.4;stroke-linecap:round;stroke-linejoin:round}.brand-wordmark{display:grid;line-height:1}.brand-wordmark>span{font-size:20px;letter-spacing:-.04em}.brand-wordmark strong{color:#fff}.brand-wordmark b{margin-left:3px;color:#86efac}.brand-wordmark small{margin-top:6px;color:#8291aa;font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
        .page>h1,.page>.dashboard-heading h1,.reward-hero h1{color:#111827}.page>h1{font-size:clamp(34px,4vw,46px);margin-top:6px}.lead{color:#667085;line-height:1.65}.eyebrow{display:inline-flex;align-items:center;gap:7px;color:#4f46e5;font-size:11px;font-weight:900;letter-spacing:.12em}.eyebrow:before{content:"";width:7px;height:7px;border-radius:3px;background:#22c55e;box-shadow:0 0 0 4px rgba(34,197,94,.1)}.eyebrow-gold:before{background:#d99a1b;box-shadow:0 0 0 4px rgba(217,154,27,.12)}
        .card,.result-card,.help-card,.reward-stat,.reward-history,.dashboard-panel{border-color:#e3e6ef;border-radius:20px;box-shadow:0 12px 32px rgba(30,41,59,.055),inset 0 1px 0 #fff}.card{padding:26px}.card h2,.card h3,.result-card h2,.help-card h2{color:#172033}.card p,.help-card p{color:#667085}
        .btn{min-height:46px;border-radius:12px;transition:background .2s,border-color .2s,color .2s,box-shadow .2s,transform .2s}.btn:active{transform:translateY(1px)}.btn-primary{border-color:#16a34a;background:#22c55e;color:#052e16;box-shadow:0 4px 0 #15803d,0 9px 18px rgba(34,197,94,.17)}.btn-primary:hover{border-color:#15803d;background:#4ade80;color:#052e16;box-shadow:0 3px 0 #15803d,0 12px 22px rgba(34,197,94,.22);transform:translateY(-1px)}.btn-secondary{border-color:#d9deea;background:#fff;color:#344054;box-shadow:0 2px 0 #e5e7eb}.btn-secondary:hover{border-color:#a5b4fc;background:#f5f3ff;color:#4338ca}.btn-quiet:hover{background:#eef2ff;color:#4338ca}.badge{border:1px solid #c7d2fe;background:#eef2ff;color:#4338ca}
        .page-jump{gap:4px;padding:5px;border:1px solid #e0e4ed;border-radius:14px;background:#fff;box-shadow:0 7px 20px rgba(30,41,59,.04)}.page-jump a{min-height:42px;padding:8px 17px;color:#667085}.page-jump a:hover{background:#eef2ff;color:#4338ca}.section-heading{margin-top:4px}.section-number{border:1px solid #c7d2fe;background:#eef2ff;color:#4338ca;box-shadow:none}.learning-intro{position:relative;overflow:hidden}.learning-intro:before{content:"";position:absolute;inset:0 auto 0 0;width:4px;background:#6366f1}.learning-code .card{background:#111827;border-color:#263244;color:#e5e7eb}.learning-code .card h3{color:#f8fafc}.code{border:1px solid #263244;border-radius:14px;background:#0b1120;color:#d1fae5;box-shadow:inset 0 1px 12px rgba(0,0,0,.18)}.lesson-detail{border-color:#e3e6ef}.lesson-detail>summary{color:#344054}.lesson-detail>summary:hover{color:#4f46e5}.lesson-detail[open]{border-color:#c7d2fe}.step strong{color:#4f46e5}.warning{border:1px solid #fed7aa;border-left:4px solid #f97316;background:#fff7ed;color:#7c2d12}
        .practice-section{border-top:0}.practice-section:before{content:"";display:block;width:100%;height:1px;margin-bottom:36px;background:linear-gradient(90deg,transparent,#d8deea 18%,#d8deea 82%,transparent)}.exercise-list{gap:12px}.exercise-item{border-color:#e1e5ed;border-radius:14px;box-shadow:0 6px 16px rgba(30,41,59,.035);transition:border-color .2s,background .2s,box-shadow .2s,transform .2s}.exercise-item:hover{border-color:#a5b4fc;box-shadow:0 10px 22px rgba(79,70,229,.09);transform:translateY(-1px)}.exercise-item.active{border:2px solid #6366f1;background:#f3f1ff;box-shadow:0 8px 22px rgba(79,70,229,.1)}.exercise-status{background:#eef2ff;color:#4f46e5}.exercise-item.active .exercise-status{background:#4f46e5;color:#fff}.exercise-workspace{border-color:#dce1eb;border-radius:22px;box-shadow:0 22px 55px rgba(30,41,59,.1)}.exercise-brief{background:linear-gradient(160deg,#fff,#f8fafc);border-color:#e3e6ef}.task-box{border:1px solid #c7d2fe;border-left:4px solid #6366f1;border-radius:14px;background:#f3f1ff}.task-label{color:#4338ca}.editor-card,.editor{background:#0b1120}.editor-heading,.editor-help{background:#111827;border-color:#263244}.editor-heading strong{color:#c7d2fe}.editor-dot:nth-child(1){background:#fb7185}.editor-dot:nth-child(2){background:#fbbf24}.editor-dot:nth-child(3){background:#4ade80}.editor-actions{background:#f8fafc}.result-icon{border:1px solid #334155;border-radius:14px;background:#111827;color:#86efac}.feedback{border-radius:14px}.feedback.ok{border-color:#86efac;background:#ecfdf3}.feedback.bad{border-color:#fca5a5;background:#fff1f2}.next-step{border-color:#c7d2fe;background:#f5f3ff}.help-card{background:linear-gradient(135deg,#fff,#fafaff)}
        .profile-form input{border-color:#d4d9e4;border-radius:12px;background:#f8fafc;color:#172033}.profile-form input:focus{outline:3px solid #c7d2fe;border-color:#6366f1;background:#fff}.ranking-table th{height:52px;background:#f8fafc;color:#667085;letter-spacing:.07em}.ranking-table td{border-color:#e8ebf1}.ranking-table tbody tr{transition:background .18s}.ranking-table tbody tr:hover{background:#fafaff}.ranking-table tr.current{background:#eef2ff}.rank-position{color:#b7791f}.rank-you{background:#ede9fe;color:#5b21b6}.stats .stat{position:relative;overflow:hidden}.stats .stat:after{content:"";position:absolute;right:-18px;bottom:-28px;width:80px;height:80px;border-radius:50%;background:rgba(99,102,241,.06)}.stats .stat strong{color:#312e81;font-variant-numeric:tabular-nums}
        .reward-balance{border:1px solid rgba(255,255,255,.18);background:linear-gradient(145deg,#312e81,#4f46e5 65%,#6366f1);box-shadow:0 18px 40px rgba(79,70,229,.22)}.reward-card{--reward-accent:#d99a1b!important;border-color:#e3e6ef;border-top:1px solid #e3e6ef;box-shadow:0 12px 32px rgba(30,41,59,.055)}.reward-card:hover{border-color:#e8c66c;box-shadow:0 18px 38px rgba(146,104,18,.1)}.reward-icon{border:1px solid #f4dfa3;background:#fffbeb;color:#b7791f}.reward-category{color:#9a6b13}.reward-progress{background:#edf0f5}.reward-progress span{background:linear-gradient(90deg,#d99a1b,#fbbf24)}.reward-history code{background:#fffbeb;color:#926812}
        .stack>.course-card{border-left:4px solid #6366f1}.stack>.course-card:hover{border-color:#6366f1;box-shadow:0 16px 38px rgba(79,70,229,.09)}.empty-ranking{background:linear-gradient(135deg,#fff,#fafaff)}
        @media(max-width:900px){.brand-emblem{width:38px;height:38px;flex-basis:38px}.brand-wordmark small{display:none}.page{padding-top:30px}.page>h1{font-size:34px}}
        @media(max-width:560px){.card{padding:20px}.page-jump a{padding:8px 10px}.profile-form{align-items:stretch;flex-direction:column}.profile-form>div,.profile-form input{width:100%}.ranking-table{min-width:650px}.ranking-shell{overflow-x:auto!important}.reward-card:hover,.exercise-item:hover{transform:none}}
        @media(prefers-reduced-motion:reduce){.btn,.exercise-item,.ranking-table tbody tr{transition:none}.btn:hover,.exercise-item:hover{transform:none}}
    </style>
    <style>
        .glossary-help{display:flex;align-items:center;gap:9px;width:max-content;max-width:100%;margin:18px 0 0;padding:9px 13px;border:1px solid #c7d2fe;border-radius:12px;background:#f5f3ff;color:#514b70;font-size:13px;font-weight:700}.glossary-term{display:inline;border-bottom:2px dotted #818cf8;color:inherit;font-weight:650;cursor:help;text-decoration:none;outline:0;transition:color .18s,background .18s,border-color .18s}.glossary-term:hover,.glossary-term:focus-visible,.glossary-term.active{border-color:#4f46e5;border-radius:4px;background:#eef2ff;color:#3730a3}.code .glossary-term,.editor-card .glossary-term{border-color:#6ee7b7;color:inherit}.code .glossary-term:hover,.code .glossary-term:focus-visible,.code .glossary-term.active{background:#183044;color:#a7f3d0}.glossary-tooltip{position:fixed;z-index:1100;width:min(340px,calc(100vw - 24px));padding:16px;border:1px solid #c7d2fe;border-radius:16px;background:#fff;color:#172033;box-shadow:0 20px 55px rgba(15,23,42,.24),inset 0 1px 0 #fff;opacity:0;transform:translateY(5px) scale(.98);pointer-events:none;transition:opacity .16s ease,transform .16s ease}.glossary-tooltip:after{content:"";position:absolute;left:50%;width:12px;height:12px;border-right:1px solid #c7d2fe;border-bottom:1px solid #c7d2fe;background:#fff;transform:translateX(-50%) rotate(45deg)}.glossary-tooltip[data-placement="top"]:after{bottom:-7px}.glossary-tooltip[data-placement="bottom"]:after{top:-7px;transform:translateX(-50%) rotate(225deg)}.glossary-tooltip.visible{opacity:1;transform:translateY(0) scale(1)}.glossary-tooltip[hidden]{display:none}.glossary-tooltip-label{display:flex;align-items:center;gap:8px;margin-bottom:6px;color:#4338ca;font-size:14px;font-weight:900}.glossary-tooltip-label:before{content:"?";display:grid;place-items:center;width:22px;height:22px;border-radius:8px;background:#eef2ff;color:#4f46e5;font-size:12px}.glossary-tooltip-definition{margin:0;color:#475467;font-size:13px;line-height:1.5}.glossary-tooltip-example{display:block;margin-top:10px;padding:8px 10px;border:1px solid #263244;border-radius:9px;background:#111827;color:#a7f3d0;font:12px/1.45 Consolas,ui-monospace,monospace;white-space:pre-wrap;overflow-wrap:anywhere}@media(max-width:560px){.glossary-help{width:100%;align-items:flex-start}.glossary-term{padding:2px 0}.glossary-tooltip{padding:14px}}@media(prefers-reduced-motion:reduce){.glossary-term,.glossary-tooltip{transition:none}}
    </style>
</head>
<body><div class="ajax-loader" aria-hidden="true"></div><div class="shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}" aria-label="Loop Lab — início"><x-brand-logo /></a>
        <nav class="primary-nav" aria-label="Navegação principal">
            <a class="primary-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11 12 3l9 8v10h-6v-6H9v6H3V11Z"/></svg><span>Início</span></a>
            @php($firstLesson = $modules->first()?->lessons->first())
            @if($firstLesson)<a class="primary-link {{ request()->routeIs('lessons.*') ? 'active' : '' }}" href="{{ route('lessons.show', $firstLesson) }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v17H6.5A2.5 2.5 0 0 0 4 22V5.5ZM20 5.5A2.5 2.5 0 0 0 17.5 3H13v17h4.5A2.5 2.5 0 0 1 20 22V5.5Z"/></svg><span>Curso</span></a>@endif
            <a class="primary-link" href="{{ $firstLesson ? route('lessons.show', $firstLesson).'#praticar' : route('dashboard') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.5 4.5 19.5 9M4 20l4.5-1 11-11a2.1 2.1 0 0 0-3-3l-11 11L4 20ZM13 6l5 5"/></svg><span>Desafios</span></a>
            <a class="primary-link {{ request()->routeIs('review') ? 'active' : '' }}" href="{{ route('review') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8M3 3v5h5"/><path d="m9 12 2 2 4-5"/></svg><span>Revisar</span></a>
            <a class="primary-link ranking-link {{ request()->routeIs('ranking') ? 'active' : '' }}" href="{{ route('ranking') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 21h8M12 17v4M7 4h10v4a5 5 0 0 1-10 0V4Z"/><path d="M7 6H4v2a4 4 0 0 0 4 4M17 6h3v2a4 4 0 0 1-4 4"/></svg><span>Ranking</span></a>
            <a class="primary-link reward-link {{ request()->routeIs('rewards.*') ? 'active' : '' }}" href="{{ route('rewards.index') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9h16v12H4V9ZM3 5h18v4H3V5ZM12 5v16M7.5 5C5 5 5 2 7.2 2 9.5 2 12 5 12 5M16.5 5C19 5 19 2 16.8 2 14.5 2 12 5 12 5"/></svg><span>Recompensas</span></a>
        </nav>
        <section class="course-tree">
            <p class="sidebar-heading">Trilha do curso</p>
            @foreach($modules as $module)
                <details class="module-group" @if((request()->route('lesson') && request()->route('lesson')->module_id === $module->id)) open @endif>
                    <summary class="module-summary"><div><strong>{{ str_pad($module->position,2,'0',STR_PAD_LEFT) }}. {{ $module->title }}</strong><small>{{ $module->lessons->count() }} aulas</small></div><span class="module-chevron">⌄</span></summary>
                    <div class="module-lessons">
                        @foreach($module->lessons as $item)
                            @php($locked = $item->prerequisite_lesson_id && ! in_array($item->prerequisite_lesson_id, $completedLessonIds ?? []))
                            <a class="nav-link {{ request()->route('lesson')?->is($item) ? 'active' : '' }} {{ in_array($item->id, $completedLessonIds ?? []) ? 'completed' : '' }} {{ $locked ? 'locked' : '' }}" @if(request()->route('lesson')?->is($item)) aria-current="page" @endif href="{{ route('lessons.show',$item) }}"><span>{{ $item->title }}</span><span class="nav-status">{{ in_array($item->id, $completedLessonIds ?? []) ? '✓' : str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span></a>
                        @endforeach
                    </div>
                </details>
            @endforeach
        </section>
        <div class="sidebar-profile"><span class="profile-avatar">{{ mb_strtoupper(mb_substr($learner->display_name ?? auth()->user()?->name ?? 'E', 0, 1)) }}</span><span class="profile-copy"><strong>{{ $learner->display_name ?? auth()->user()?->name ?? 'Estudante PHP' }}</strong><small>{{ $stats['xp'] }} XP conquistados</small></span><span class="profile-level">LVL {{ intdiv((int) $stats['xp'], 500) + 1 }}</span></div>
    </aside>
    <div class="content"><header class="topbar"><span class="mobile-title">Loop Lab</span><span class="topbar-context">Sua jornada em PHP</span><div class="topbar-actions"><span class="topbar-xp" data-xp><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m13 2-8 12h7l-1 8 8-12h-7l1-8Z"/></svg><span data-xp-value>{{ $stats['xp'] }} XP</span></span>@auth<form method="POST" action="{{ route('logout', absolute: false) }}">@csrf<button class="btn btn-quiet" type="submit">Sair</button></form>@else<a class="topbar-login" href="{{ route('login') }}">Entrar</a>@endauth</div></header><main class="page">@yield('content')</main></div>
</div>
<aside class="mascot-toast" data-mascot-toast aria-live="polite" aria-atomic="true" aria-hidden="true">
    <img class="mascot-image" data-mascot-image src="/images/mascots/encouragement.webp" width="138" height="138" alt="">
    <div class="mascot-copy"><span class="mascot-label" data-mascot-label></span><h2 class="mascot-title" data-mascot-title></h2><p class="mascot-message" data-mascot-message></p></div>
    <div class="mascot-controls">
        <button class="mascot-icon-btn" type="button" data-mascot-sound aria-label="Silenciar sons" aria-pressed="false" title="Silenciar sons"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M11 5 6 9H3v6h3l5 4z"/><path data-sound-wave d="M15.5 8.5a5 5 0 0 1 0 7M18 6a8.5 8.5 0 0 1 0 12"/></svg></button>
        <button class="mascot-icon-btn" type="button" data-mascot-close aria-label="Fechar mensagem"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg></button>
    </div>
</aside>
<aside class="glossary-tooltip" id="glossary-tooltip" role="tooltip" aria-live="polite" hidden>
    <strong class="glossary-tooltip-label" data-glossary-label></strong>
    <p class="glossary-tooltip-definition" data-glossary-definition></p>
    <code class="glossary-tooltip-example" data-glossary-example></code>
</aside>
<script>
(() => {
    const loader = () => document.querySelector('.ajax-loader');
    const setLoading = (active) => loader()?.classList.toggle('loading', active);
    const mascotToast = document.querySelector('[data-mascot-toast]');
    let mascotTimer;
    let audioContext;
    let activeGlossaryTerm;
    let glossaryHideTimer;
    const glossaryTooltip = document.querySelector('#glossary-tooltip');
    const glossaryTerms = @json(config('learning_glossary.terms'));
    const glossaryProcessedNodes = new WeakSet();
    const glossaryEntries = Object.entries(glossaryTerms).sort((a, b) => b[0].length - a[0].length);
    const glossaryByLabel = new Map(glossaryEntries.map(([label, details]) => [label.toLocaleLowerCase('pt-BR'), {label, ...details}]));
    const glossaryExpression = new RegExp([
        '\\$[A-Za-z_][A-Za-z0-9_]*',
        ...glossaryEntries.map(([label]) => label.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')),
    ].join('|'), 'giu');
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
        const button = mascotToast?.querySelector('[data-mascot-sound]');
        if (button) {
            button.setAttribute('aria-pressed', String(muted));
            button.setAttribute('aria-label', muted ? 'Ativar sons' : 'Silenciar sons');
            button.title = muted ? 'Ativar sons' : 'Silenciar sons';
        }
        const soundWave = mascotToast?.querySelector('[data-sound-wave]');
        if (soundWave) soundWave.style.display = muted ? 'none' : '';
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
        if (!mascotToast || !mascotToast.classList.contains('visible')) return;
        mascotToast.classList.add('leaving');
        setTimeout(() => {
            if (mascotToast) {
                mascotToast.classList.remove('visible', 'leaving', 'error', 'success');
                mascotToast.setAttribute('aria-hidden', 'true');
            }
        }, matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 210);
    }

    function showMascot(type) {
        if (!mascotToast) return;
        const options = mascotMessages[type] || mascotMessages.error;
        const content = options[Math.floor(Math.random() * options.length)];
        clearTimeout(mascotTimer);
        mascotToast.classList.remove('visible', 'leaving', 'error', 'success');
        const img = mascotToast.querySelector('[data-mascot-image]');
        if (img) img.src = `/images/mascots/${content.image}`;
        const label = mascotToast.querySelector('[data-mascot-label]');
        if (label) label.textContent = type === 'success' ? 'Desafio concluído' : 'Nova tentativa';
        const title = mascotToast.querySelector('[data-mascot-title]');
        if (title) title.textContent = content.title;
        const message = mascotToast.querySelector('[data-mascot-message]');
        if (message) message.textContent = content.message;
        mascotToast.classList.add(type);
        mascotToast.setAttribute('aria-hidden', 'false');
        requestAnimationFrame(() => mascotToast?.classList.add('visible'));
        playMascotSound(type);
        mascotTimer = setTimeout(hideMascot, type === 'success' ? 5200 : 4600);
    }

    function isGlossaryWordCharacter(character) {
        return Boolean(character && /[\p{L}\p{N}_]/u.test(character));
    }

    function enhanceGlossary() {
        const page = document.querySelector('.page');
        if (! page) return;

        const walker = document.createTreeWalker(page, NodeFilter.SHOW_TEXT, {
            acceptNode(node) {
                if (! node.data.trim() || glossaryProcessedNodes.has(node)) return NodeFilter.FILTER_REJECT;
                if (node.parentElement?.closest('textarea,input,button,a,script,style,svg,.glossary-term,[data-no-glossary]')) return NodeFilter.FILTER_REJECT;

                return NodeFilter.FILTER_ACCEPT;
            },
        });
        const nodes = [];
        while (walker.nextNode()) nodes.push(walker.currentNode);

        nodes.forEach(node => {
            glossaryProcessedNodes.add(node);
            const text = node.data;
            const fragment = document.createDocumentFragment();
            let cursor = 0;
            let foundTerm = false;
            glossaryExpression.lastIndex = 0;

            for (const match of text.matchAll(glossaryExpression)) {
                const matchedText = match[0];
                const start = match.index;
                const end = start + matchedText.length;
                const startsWithWord = isGlossaryWordCharacter(matchedText[0]);
                const endsWithWord = isGlossaryWordCharacter(matchedText[matchedText.length - 1]);
                if ((startsWithWord && isGlossaryWordCharacter(text[start - 1])) || (endsWithWord && isGlossaryWordCharacter(text[end]))) continue;

                const exactDetails = glossaryByLabel.get(matchedText.toLocaleLowerCase('pt-BR'));
                const details = exactDetails || (/^\$[A-Za-z_][A-Za-z0-9_]*$/.test(matchedText)
                    ? {label: 'variável PHP', ...glossaryTerms['variável PHP']}
                    : null);
                if (! details) continue;
                fragment.append(document.createTextNode(text.slice(cursor, start)));
                const term = document.createElement('span');
                term.className = 'glossary-term';
                term.dataset.glossaryKey = details.label;
                term.textContent = matchedText;
                term.tabIndex = 0;
                term.setAttribute('role', 'term');
                term.setAttribute('aria-describedby', 'glossary-tooltip');
                term.setAttribute('aria-label', `${matchedText}: ${details.definition}`);
                fragment.append(term);
                cursor = end;
                foundTerm = true;
            }

            if (! foundTerm) return;
            fragment.append(document.createTextNode(text.slice(cursor)));
            node.replaceWith(fragment);
        });
    }

    function showGlossary(term) {
        const details = glossaryTerms[term.dataset.glossaryKey];
        if (! details || ! glossaryTooltip) return;
        clearTimeout(glossaryHideTimer);
        activeGlossaryTerm?.classList.remove('active');
        activeGlossaryTerm = term;
        term.classList.add('active');
        glossaryTooltip.querySelector('[data-glossary-label]').textContent = term.textContent;
        glossaryTooltip.querySelector('[data-glossary-definition]').textContent = details.definition;
        const example = glossaryTooltip.querySelector('[data-glossary-example]');
        example.textContent = details.example || '';
        example.hidden = ! details.example;
        glossaryTooltip.hidden = false;
        glossaryTooltip.classList.add('visible');

        const termRect = term.getBoundingClientRect();
        const tooltipRect = glossaryTooltip.getBoundingClientRect();
        const margin = 12;
        const left = Math.max(margin, Math.min(window.innerWidth - tooltipRect.width - margin, termRect.left + termRect.width / 2 - tooltipRect.width / 2));
        let top = termRect.top - tooltipRect.height - 10;
        let placement = 'top';
        if (top < margin) {
            top = Math.min(window.innerHeight - tooltipRect.height - margin, termRect.bottom + 10);
            placement = 'bottom';
        }
        glossaryTooltip.dataset.placement = placement;
        glossaryTooltip.style.left = `${left}px`;
        glossaryTooltip.style.top = `${Math.max(margin, top)}px`;
    }

    function hideGlossary(delay = 0) {
        clearTimeout(glossaryHideTimer);
        glossaryHideTimer = setTimeout(() => {
            activeGlossaryTerm?.classList.remove('active');
            activeGlossaryTerm = null;
            glossaryTooltip?.classList.remove('visible');
            if (glossaryTooltip) glossaryTooltip.hidden = true;
        }, delay);
    }

    updateSoundButton();

    async function navigate(url, push = true) {
        setLoading(true);
        try {
            const response = await fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}});
            if (!response.ok) throw new Error('Não foi possível abrir esta página.');
            const html = await response.text();
            const page = new DOMParser().parseFromString(html, 'text/html');
            const newShell = page.querySelector('.shell');
            const currentShell = document.querySelector('.shell');
            if (!newShell || !currentShell) {
                location.href = url;
                return;
            }
            currentShell.replaceWith(newShell);
            enhanceGlossary();
            restoreEditors();
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

    document.addEventListener('mouseover', event => {
        const term = event.target.closest?.('.glossary-term');
        if (term) showGlossary(term);
    });

    document.addEventListener('mouseout', event => {
        const term = event.target.closest?.('.glossary-term');
        if (term && ! term.contains(event.relatedTarget)) hideGlossary(90);
    });

    document.addEventListener('focusin', event => {
        const term = event.target.closest?.('.glossary-term');
        if (term) showGlossary(term);
    });

    document.addEventListener('focusout', event => {
        if (event.target.closest?.('.glossary-term')) hideGlossary(90);
    });

    addEventListener('scroll', () => hideGlossary(), {passive: true});
    addEventListener('resize', () => hideGlossary(), {passive: true});

    document.addEventListener('click', (event) => {
        const glossaryTerm = event.target.closest?.('.glossary-term');
        if (glossaryTerm) {
            event.preventDefault();
            showGlossary(glossaryTerm);
            return;
        }
        if (! glossaryTooltip?.hidden) hideGlossary();
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
            if (form && form.dataset.starterCode) {
                const bytes = Uint8Array.from(atob(form.dataset.starterCode), character => character.charCodeAt(0));
                const editor = form.querySelector('[name="code"]');
                if (editor) {
                    editor.value = new TextDecoder().decode(bytes);
                    localStorage.removeItem(editorStorageKey(editor));
                }
            }
            const exerciseResult = document.querySelector('#exercise-result');
            if (exerciseResult) exerciseResult.innerHTML = '';
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
        const rewardForm = event.target.closest('[data-reward-form]');
        if (rewardForm) {
            event.preventDefault();
            const button = event.submitter;
            const rewardTitle = rewardForm.closest('[data-reward-card]')?.querySelector('h3')?.textContent || 'esta recompensa';
            if (! window.confirm(`Resgatar ${rewardTitle}? O custo será descontado do seu saldo disponível.`)) return;
            const oldText = button?.textContent;
            const feedback = document.querySelector('#reward-feedback');
            if (button) {
                button.disabled = true;
                button.textContent = 'Resgatando...';
            }
            setLoading(true);
            try {
                const response = await fetch(rewardForm.action, {method: 'POST', body: new FormData(rewardForm), headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}});
                const data = await response.json();
                if (!response.ok) throw new Error(Object.values(data.errors || {}).flat()[0] || data.message || 'Não foi possível resgatar.');
                if (feedback) {
                    feedback.innerHTML = '<div class="feedback ok reward-toast" role="status"><strong></strong><span></span></div>';
                    const strong = feedback.querySelector('strong');
                    if (strong) strong.textContent = data.message;
                    const span = feedback.querySelector('span');
                    if (span) span.textContent = `Código da conquista: ${data.code}`;
                }
                const availEl = document.querySelector('[data-reward-available]');
                if (availEl) availEl.textContent = data.summary.available;
                const spentEl = document.querySelector('[data-reward-spent]');
                if (spentEl) spentEl.textContent = data.summary.spent;
                const countEl = document.querySelector('[data-reward-count]');
                if (countEl) countEl.textContent = data.summary.redeemed;
                const card = document.querySelector(`[data-reward-card="${data.rewardId}"]`);
                card?.classList.add('redeemed');
                card?.setAttribute('data-redeemed', 'true');
                if (button) {
                    button.textContent = 'Resgatada';
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-secondary');
                }
                document.querySelectorAll('[data-reward-card]').forEach(rewardCard => {
                    if (rewardCard.dataset.redeemed === 'true') return;
                    const rewardButton = rewardCard.querySelector('.reward-button');
                    if (rewardButton && Number(rewardCard.dataset.rewardCost) > Number(data.summary.available)) {
                        rewardButton.disabled = true;
                        rewardButton.textContent = 'Saldo insuficiente';
                        rewardButton.classList.remove('btn-primary');
                        rewardButton.classList.add('btn-secondary');
                    }
                });
                const history = document.querySelector('[data-reward-history]');
                if (history) {
                    history.querySelector('.empty-ranking')?.remove();
                    const historyItem = document.createElement('article');
                    const historyCopy = document.createElement('div');
                    const historyTitle = document.createElement('strong');
                    const historyDate = document.createElement('span');
                    const historyCode = document.createElement('code');
                    historyTitle.textContent = data.rewardTitle;
                    historyDate.textContent = data.redeemedAt;
                    historyCode.textContent = data.code;
                    historyCopy.append(historyTitle, historyDate);
                    historyItem.append(historyCopy, historyCode);
                    history.prepend(historyItem);
                }
                feedback?.scrollIntoView({behavior: 'smooth', block: 'nearest'});
            } catch (error) {
                if (feedback) {
                    feedback.innerHTML = '<p class="feedback bad reward-toast" role="alert"></p>';
                    const p = feedback.querySelector('p');
                    if (p) p.textContent = error.message || 'Falha de conexão. Tente novamente.';
                }
                if (button) {
                    button.disabled = false;
                    if (oldText !== undefined) button.textContent = oldText;
                }
            } finally {
                setLoading(false);
            }
            return;
        }

        const profileForm = event.target.closest('[data-profile-form]');
        if (profileForm) {
            event.preventDefault();
            const button = event.submitter;
            const oldText = button?.textContent;
            if (button) { button.disabled = true; button.textContent = 'Salvando...'; }
            setLoading(true);
            try {
                const response = await fetch(profileForm.action, {method: 'POST', body: new FormData(profileForm), headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}});
                const data = await response.json();
                const feedback = document.querySelector('#profile-feedback');
                if (!response.ok) {
                    if (feedback) {
                        feedback.innerHTML = '<p class="feedback bad" role="alert"></p>';
                        const p = feedback.querySelector('p');
                        if (p) p.textContent = Object.values(data.errors || {}).flat()[0] || data.message;
                    }
                    return;
                }
                if (feedback) feedback.innerHTML = '<p class="feedback ok">Nome atualizado com sucesso.</p>';
                document.querySelectorAll('.ranking-table tr.current .rank-name').forEach(cell => {
                    if (cell.childNodes[0]) cell.childNodes[0].textContent = data.displayName;
                });
            } catch (error) {
                const feedback = document.querySelector('#profile-feedback');
                if (feedback) feedback.innerHTML = '<p class="feedback bad">Falha de conexão. Tente novamente.</p>';
            } finally {
                if (button) { button.disabled = false; if (oldText !== undefined) button.textContent = oldText; }
                setLoading(false);
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
            const responseText = await response.text();
            let data;
            try {
                data = JSON.parse(responseText);
            } catch (error) {
                console.error('Resposta inesperada do servidor:', responseText);
                throw new Error(`O servidor respondeu com erro ${response.status}. Atualize a página e tente novamente.`);
            }
            const exerciseResult = document.querySelector('#exercise-result');
            if (!response.ok) {
                const message = Object.values(data.errors || {}).flat()[0] || data.message || 'Não foi possível concluir a ação.';
                if (exerciseResult) {
                    exerciseResult.innerHTML = `<section class="result-card"><div class="feedback bad" role="alert"></div></section>`;
                    const feedbackEl = exerciseResult.querySelector('.feedback');
                    if (feedbackEl) feedbackEl.textContent = message;
                }
                return;
            }
            if (exerciseResult) {
                exerciseResult.innerHTML = data.html;
                if (data.progressWarning) {
                    const warning = document.createElement('p');
                    warning.className = 'feedback bad';
                    warning.setAttribute('role', 'alert');
                    warning.textContent = data.progressWarning;
                    exerciseResult.prepend(warning);
                }
            }
            if (data.gamification?.type) {
                try {
                    showMascot(data.gamification.type);
                } catch (error) {
                    console.error('Não foi possível mostrar o mascote:', error);
                }
            }
            exerciseResult?.scrollIntoView({behavior: 'smooth', block: 'nearest'});
            if (data.stats) {
                const percentEl = document.querySelector('[data-progress-percent]');
                if (percentEl) percentEl.textContent = `${data.stats.percent}%`;
                const barEl = document.querySelector('[data-progress-bar]');
                if (barEl) barEl.style.width = `${data.stats.percent}%`;
                const countEl = document.querySelector('[data-progress-count]');
                if (countEl) countEl.textContent = `${data.stats.completed} de ${data.stats.total} exercícios`;
                const xpBadge = document.querySelector('[data-xp]');
                const xpValue = xpBadge?.querySelector('[data-xp-value]');
                if (xpValue) xpValue.textContent = `${data.stats.xp} XP`;
                xpBadge?.classList.remove('xp-pop');
                requestAnimationFrame(() => xpBadge?.classList.add('xp-pop'));
                const status = document.querySelector(`[data-exercise-id="${data.exerciseId}"] .exercise-status`);
                if (status && data.html && data.html.includes('Resposta correta!')) status.textContent = '✓';
            }
        } catch (error) {
            const exerciseResult = document.querySelector('#exercise-result');
            if (exerciseResult) {
                exerciseResult.innerHTML = '<section class="result-card"><div class="feedback bad" role="alert"></div></section>';
                const feedbackEl = exerciseResult.querySelector('.feedback');
                if (feedbackEl) feedbackEl.textContent = error.message || 'Não foi possível falar com o servidor. Verifique sua conexão e tente novamente.';
            }
        } finally {
            if (button) { button.disabled = false; if (oldText !== undefined) button.textContent = oldText; }
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
        if (event.key === 'Escape' && ! glossaryTooltip?.hidden) {
            hideGlossary();
            activeGlossaryTerm?.focus();
            return;
        }
        if (event.key === 'Escape' && mascotToast?.classList.contains('visible')) {
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
    enhanceGlossary();
    if (document.body) {
        new MutationObserver(() => {
            restoreEditors();
            enhanceGlossary();
        }).observe(document.body, {childList:true, subtree:true});
    }
})();
</script>
</body></html>
