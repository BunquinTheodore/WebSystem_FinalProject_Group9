<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name', 'Bluemoon'))</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Vite (if available) -->
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <!-- Global look & feel -->
  @include('partials.background')
  <style>
    html { color-scheme: light; }
    body { color: #1b1b18; font-family: 'Open Sans', ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; }
    a { color: #0891b2; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .app-header { max-width: 1100px; margin: 0 auto; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1000; background:#fff; border-bottom:1px solid #e5e7eb; box-shadow: 0 1px 0 rgba(0,0,0,0.04); }
    .app-shell { max-width: 1100px; margin: 16px auto 40px; padding: 0 16px; }
    .btn { display:inline-block; padding: 8px 12px; border-radius: 8px; border: 1px solid #e3e3e0; background:#fff; color:#1b1b18; cursor:pointer; }
    .btn-primary { background: #0891b2; color: #fff; border-color: #0891b2; }
    .card { background:#fff; border:1px solid #e3e3e0; border-radius:12px; box-shadow:0 6px 16px rgba(0,0,0,.04); }
  /* Prominent section titles */
  .section-title{margin:0 0 12px;font-size:24px;line-height:30px;font-weight:800;letter-spacing:.3px;color:#1b1b18;display:flex;align-items:center;gap:10px}
  .section-title::before{content:"";display:inline-block;width:6px;height:20px;background:#0891b2;border-radius:4px;box-shadow:0 0 0 2px rgba(8,145,178,.06)}
    /* Toasts */
    .toast-wrap { position: fixed; right: 16px; bottom: 16px; z-index: 9999; display: grid; gap: 10px; width: min(360px, calc(100vw - 32px)); }
  .toast { display:flex; align-items:flex-start; gap:10px; background: rgba(17,24,39,.6); color:#fff; border-radius:12px; padding:12px 14px; box-shadow: 0 12px 30px rgba(0,0,0,.25); border:1px solid rgba(255,255,255,.18); opacity:0; transform: translateY(8px); transition: all .25s ease; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); }
    .toast.show { opacity: 1; transform: translateY(0); }
    .toast-title { font-weight:700; font-size:14px; }
    .toast-msg { font-size:13px; line-height:1.4; }
    .toast-close { margin-left:auto; background:transparent; color:#fff; border:none; cursor:pointer; font-size:16px; line-height:1; opacity:.8; }
  .toast--success { background: rgba(5,150,105,.55); border-color: rgba(16,185,129,.35); }
  .toast--error { background: rgba(185,28,28,.55); border-color: rgba(239,68,68,.35); }
  .toast--info { background: rgba(8,145,178,.55); border-color: rgba(8,145,178,.35); }
    /* Modal */
    .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);display:none;align-items:center;justify-content:center;z-index:9998}
    .modal-overlay.show{display:flex}
    .modal-card{background:#fff;border-radius:12px;border:1px solid #e3e3e0;max-width:420px;width:calc(100vw - 40px);box-shadow:0 10px 30px rgba(0,0,0,.25)}
    .modal-head{padding:14px 16px;border-bottom:1px solid #f0f0ef;font-weight:700}
    .modal-body{padding:14px 16px;color:#1b1b18}
    .modal-actions{display:flex;gap:8px;justify-content:flex-end;padding:12px 16px;border-top:1px solid #f0f0ef}
    .btn-danger{background:#b91c1c;color:#fff;border-color:#991b1b}

  /* Loading overlay (minimal) */
  .loading-overlay{position:fixed;inset:0;background:rgba(255,255,255,.75);backdrop-filter:blur(1px);display:none;align-items:center;justify-content:center;z-index:10000;--accent:#0891b2}
    .loading-overlay.show{display:flex}
  .loading-box{display:grid;justify-items:center;gap:6px;padding:14px 16px;border-radius:10px;background:#fff;border:1px solid #eef2f7;box-shadow:none}
  .loading-emoji{display:none}
  .loading-spinner{width:30px;height:30px;border:2px solid transparent;border-top-color:var(--accent);border-radius:50%;animation:spin .9s linear infinite}
  .loading-text{font-weight:600;color:#1b1b18;font-size:13px}
  .loading-sub{font-size:11px;color:#6b7280}
    @keyframes spin{to{transform:rotate(360deg)}}
  </style>
</head>
<body>
  @unless(request()->routeIs('login'))
  <header class="app-header">
    <div style="display:flex;align-items:center;gap:10px">
      @if(!View::hasSection('hide-back-button') && !(request()->routeIs('login') || request()->is('/')) && !request()->routeIs('dashboard'))
        <a href="{{ route('dashboard') }}" class="btn" id="app-back-btn" aria-label="Go back">&#x2190; Back</a>
      @endif
      <img src="{{ asset('images/bluemoon-logo.png') }}" alt="Bluemoon" style="height:28px;width:auto" />
    </div>
    <div style="display:flex;align-items:center;gap:10px">
      @if(session()->has('role'))
        <span style="font-size:12px;color:#706f6c">{{ ucfirst(session('role')) }}: {{ session('username') }}</span>
  <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn" data-confirm="Log out from this session?" data-confirm-title="Confirm Logout" data-confirm-ok="Logout" data-confirm-type="danger">Logout</button></form>
      @elseif(!View::hasSection('hide-auth-button') && !(request()->routeIs('login') || request()->is('/')))
        <a class="btn" href="{{ route('login') }}">Login</a>
      @endif
    </div>
  </header>
  @endunless

  <main class="app-shell">
    @yield('content')
  </main>
  <div class="toast-wrap" id="toast-wrap" aria-live="polite" aria-atomic="true"
    @if(session('status')) data-status="{{ e(session('status')) }}" @endif
    @if($errors->any()) data-error="{{ e($errors->first()) }}" @endif
  ></div>
  <div id="loading-overlay" class="loading-overlay" role="status" aria-live="polite" aria-hidden="true">
    <div class="loading-box" aria-label="Loading">
      <div class="loading-emoji" id="loading-emoji" aria-hidden="true">⏳</div>
      <div class="loading-spinner" aria-hidden="true"></div>
      <div class="loading-text" id="loading-text">Loading…</div>
      <div class="loading-sub" id="loading-sub" style="display:none"></div>
    </div>
  </div>
  <div id="app-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-card" role="document">
      <div class="modal-head" id="app-modal-title">Confirm</div>
      <div class="modal-body" id="app-modal-message">Are you sure?</div>
      <div class="modal-actions">
        <button type="button" class="btn" id="app-modal-cancel">Cancel</button>
        <button type="button" class="btn btn-danger" id="app-modal-ok">Confirm</button>
      </div>
    </div>
  </div>
    <script>
      (function(){
        var b = document.getElementById('app-back-btn');
        if (!b) return;
        b.addEventListener('click', function(ev){
          try {
            if (document.referrer && window.history.length > 1) {
              ev.preventDefault();
              window.history.back();
            }
          } catch (_) { /* no-op */ }
        });
      })();
    </script>
    <script>
      (function(){
        function el(tag, cls){ var x = document.createElement(tag); if(cls) x.className = cls; return x; }
        function makeToast(msg, type){
          var wrap = document.getElementById('toast-wrap'); if(!wrap) return;
          var t = el('div', 'toast toast--'+(type||'info'));
          var c = el('div', 'toast-msg'); c.textContent = msg;
          var btn = el('button', 'toast-close'); btn.type='button'; btn.innerHTML='&times;';
          btn.addEventListener('click', function(){ t.remove(); });
          t.appendChild(c); t.appendChild(btn); wrap.appendChild(t);
          setTimeout(function(){ t.classList.add('show'); }, 10);
          setTimeout(function(){ t.classList.remove('show'); setTimeout(function(){ t.remove(); }, 250); }, 3500);
        }
        window.toast = makeToast;
      })();
    </script>
    <script>
      (function(){
        var overlay = document.getElementById('app-modal');
        var titleEl = document.getElementById('app-modal-title');
        var msgEl = document.getElementById('app-modal-message');
        var okBtn = document.getElementById('app-modal-ok');
        var cancelBtn = document.getElementById('app-modal-cancel');
        var lastResolve = null, lastReject = null;

        function close(result){
          overlay.classList.remove('show');
          overlay.setAttribute('aria-hidden','true');
          document.removeEventListener('keydown', onKey);
          if(result && lastResolve) lastResolve(true); else if(lastResolve) lastResolve(false);
          lastResolve = lastReject = null;
        }
        function onKey(e){ if(e.key === 'Escape'){ e.preventDefault(); close(false); } }
        if(overlay){ overlay.addEventListener('click', function(e){ if(e.target === overlay) close(false); }); }
        if(cancelBtn){ cancelBtn.addEventListener('click', function(){ close(false); }); }
        if(okBtn){ okBtn.addEventListener('click', function(){ close(true); }); }

        window.modalConfirm = function(message, opts){
          opts = opts || {}; var title = opts.title || 'Confirm';
          var confirmText = opts.confirmText || 'Confirm';
          var cancelText = opts.cancelText || 'Cancel';
          var danger = opts.type === 'danger';
          titleEl.textContent = title; msgEl.textContent = typeof message === 'string' ? message : String(message);
          okBtn.textContent = confirmText; cancelBtn.textContent = cancelText;
          okBtn.classList.toggle('btn-danger', danger);
          overlay.classList.add('show');
          overlay.setAttribute('aria-hidden','false');
          setTimeout(function(){ document.addEventListener('keydown', onKey); }, 0);
          return new Promise(function(resolve){ lastResolve = resolve; });
        };
      })();
    </script>
    <script>
      // Global modal-confirm fallback: any form that contains a [data-confirm] submit will use modal.
      // Manager has a richer handler for .mgr-del-form; skip those here to avoid double prompts.
      (function(){
        document.addEventListener('submit', async function(e){
          try{
            if(e.defaultPrevented) return;
            var form = e.target && e.target.closest ? e.target.closest('form') : e.target;
            if(!form || form.classList && form.classList.contains('mgr-del-form')) return;
            if(form.dataset && form.dataset.modalConfirmed === '1') return; // already confirmed
            var confirmEl = form.querySelector('[data-confirm]');
            if(!confirmEl) return; // nothing to confirm
            e.preventDefault();
            var msg = confirmEl.getAttribute('data-confirm') || 'Are you sure?';
            var title = confirmEl.getAttribute('data-confirm-title') || 'Please confirm';
            var okText = confirmEl.getAttribute('data-confirm-ok') || 'Confirm';
            var type = confirmEl.getAttribute('data-confirm-type') || 'danger';
            var ok = true;
            if(window.modalConfirm){
              try { ok = await window.modalConfirm(msg, { type:type, confirmText:okText, title:title }); } catch(_){ ok = false; }
            } else {
              ok = window.confirm(msg);
            }
            if(!ok) return;
            if(form.dataset) form.dataset.modalConfirmed = '1';
            form.submit();
          }catch(_){ /* ignore */ }
        }, true);
      })();
    </script>
    <script>
      // Logout confirmation for custom triggers (icons/avatars) that submit hidden logout forms
      (function(){
        document.addEventListener('click', async function(e){
          try{
            var el = e.target && e.target.closest ? e.target.closest('[data-logout-confirm]') : null;
            if(!el) return;
            e.preventDefault();
            var formSel = el.getAttribute('data-form');
            var form = null;
            if(formSel){ try { form = document.querySelector(formSel); } catch(_) { form = null; } }
            if(!form){ form = document.getElementById('logout-form-mgr') || document.getElementById('logout-form') || document.querySelector('form[action$="/logout"]'); }
            var msg = el.getAttribute('data-msg') || 'Log out from this session?';
            var title = el.getAttribute('data-title') || 'Confirm Logout';
            var okText = el.getAttribute('data-ok') || 'Logout';
            var ok = true;
            if(window.modalConfirm){
              try { ok = await window.modalConfirm(msg, { type:'danger', confirmText: okText, title: title }); } catch(_){ ok = false; }
            } else {
              ok = window.confirm('Logout?');
            }
            if(ok && form) form.submit();
          }catch(_){ /* ignore */ }
        }, true);
      })();
    </script>
    <script>
      (function(){
        var wrap = document.getElementById('toast-wrap');
        if(!wrap) return;
        var statusMsg = wrap.getAttribute('data-status');
        var errMsg = wrap.getAttribute('data-error');
        if(statusMsg){ window.toast(statusMsg, 'success'); }
        if(errMsg){ window.toast(errMsg, 'error'); }
      })();
    </script>
    <script>
      // Global loading overlay for navigation and form submissions (context-aware)
      (function(){
        var overlay = document.getElementById('loading-overlay');
        var textEl = document.getElementById('loading-text');
        var emojiEl = document.getElementById('loading-emoji');
        var subEl = document.getElementById('loading-sub');
        if(!overlay) return;
        var lastMeta = null;
        function setMeta(meta){
          lastMeta = meta || null;
          if(!meta) return;
          if(textEl) textEl.textContent = meta.label || 'Loading…';
          if(emojiEl) emojiEl.textContent = meta.emoji || '⏳';
          if(subEl){ if(meta.sub){ subEl.textContent = meta.sub; subEl.style.display='block'; } else { subEl.textContent=''; subEl.style.display='none'; } }
          overlay.style.setProperty('--accent', meta.accent || '#0891b2');
        }
        function show(meta){ if(meta) setMeta(meta); overlay.classList.add('show'); overlay.setAttribute('aria-hidden','false'); }
        function hide(){ overlay.classList.remove('show'); overlay.setAttribute('aria-hidden','true'); }

        // Ensure hidden on load
        document.addEventListener('DOMContentLoaded', hide);
        window.addEventListener('pageshow', hide);

        function deriveMetaFromUrl(raw, method){
          try{
            var url = new URL(raw, window.location.origin);
            var p = url.pathname || '/';
            var isPost = (method||'GET').toUpperCase() !== 'GET';
            var meta = { label: isPost ? 'Saving…' : 'Loading…', emoji: isPost ? '💾' : '⏳', accent: '#0891b2' };
            var set = function(label, emoji, accent, sub){ meta.label=label; meta.emoji=emoji; meta.accent=accent; if(sub) meta.sub=sub; };
            // Specific POST endpoints and flags
            if(isPost){
              try{
                if(/^\/login(\/|$)/.test(p)) { set('Signing you in…','🔐','#3b82f6'); return meta; }
                if(/^\/logout(\/|$)/.test(p)) { set('Signing out…','🚪','#ef4444'); return meta; }
                if(/^\/register(\/|$)/.test(p)) { set('Creating user…','➕','#10b981'); return meta; }
                if(/^\/manager\/employees(\/|$)?/.test(p)) {
                  try { sessionStorage.setItem('justAddedEmployee','manager'); } catch(_){}
                  set('Adding employee…','👥','#10b981');
                  return meta;
                }
                if(/^\/owner\/employees(\/|$)?/.test(p)) {
                  try { sessionStorage.setItem('justAddedEmployee','owner'); } catch(_){}
                  set('Adding employee…','👥','#10b981');
                  return meta;
                }
              }catch(_){ /* ignore */ }
              // Default POST retains generic 'Saving…'
              return meta;
            }
            // If we've just added an employee, tune the subsequent GET label once
            try{
              var flag = sessionStorage.getItem('justAddedEmployee');
              if(flag){
                if(flag === 'manager' && /^\/manager(\/|$)/.test(p)) { set('Employee added! Opening Manager Panel…','👥','#10b981'); }
                if(flag === 'owner' && /^\/owner(\/|$)/.test(p)) { set('Employee added! Opening Owner Dashboard…','👥','#10b981'); }
                sessionStorage.removeItem('justAddedEmployee');
                return meta;
              }
            }catch(_){ /* ignore */ }
            if(/^\/owner(\/|$)/.test(p)){
              if(/^\/owner\/manage-tasks/.test(p)) set('Opening Manage Tasks…','🗂️','#06b6d4');
              else set('Opening Owner Dashboard…','👑','#0891b2');
            } else if(/^\/manager(\/|$)/.test(p)){
              set('Opening Manager Panel…','🧑‍💼','#9333ea');
            } else if(/^\/employee(\/|$)/.test(p)){
              set('Opening Employee Portal…','👤','#10b981');
            } else if(/^\/login(\/|$)/.test(p)){
              set('Opening Login…','🔐','#3b82f6');
            } else if(/^\/logout(\/|$)/.test(p)){
              set('Signing out…','🚪','#ef4444');
            } else if(/^\/register(\/|$)/.test(p)){
              set('Opening Registration…','➕','#10b981');
            }
            return meta;
          }catch(_){
            return { label: 'Loading…', emoji: '⏳', accent: '#0891b2' };
          }
        }

        // Suppress overlay for marked links
        var suppressLoader = false;
        window.addEventListener('pageshow', function(){ suppressLoader = false; });
        window.addEventListener('beforeunload', function(){
          if (suppressLoader) return;
          // Some browsers limit DOM changes here, but toggling a class usually works
          show(lastMeta || { label:'Loading…', emoji:'⏳', accent:'#0891b2' });
        });

        // Show immediately on in-page navigation triggers
        document.addEventListener('click', function(e){
          var a = e.target && e.target.closest ? e.target.closest('a') : null;
          if(!a) return;
          var href = a.getAttribute('href');
          if(!href) return;
          if (a.hasAttribute('data-no-loader') || (a.classList && a.classList.contains('no-loader'))){
            suppressLoader = true;
            return;
          }
          if (href.startsWith('#') || href.startsWith('javascript:')) return;
          if (a.hasAttribute('download')) return;
          if (a.target && a.target !== '_self') return;
          if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
          if (e.defaultPrevented) return;
          // Only apply for same-origin navigations
          try{ var u = new URL(href, location.origin); if(u.origin !== location.origin) return; }catch(_){ return; }
          show(deriveMetaFromUrl(href, 'GET'));
        }, true);

        document.addEventListener('submit', function(e){
          if (e.defaultPrevented) return;
          var form = e.target && e.target.closest ? e.target.closest('form') : e.target;
          if(!form) { show(); return; }
          var action = form.getAttribute('action') || window.location.href;
          var method = (form.getAttribute('method') || 'GET').toUpperCase();
          show(deriveMetaFromUrl(action, method));
        }, true);
      })();
    </script>
    {{-- Render any view-pushed scripts (e.g., @push('scripts')) --}}
    @stack('scripts')
</body>
</html>
