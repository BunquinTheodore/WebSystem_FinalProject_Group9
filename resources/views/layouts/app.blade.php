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
    .toast { display:flex; align-items:flex-start; gap:10px; background:#1b1b18; color:#fff; border-radius:10px; padding:12px 14px; box-shadow: 0 10px 30px rgba(0,0,0,.25); border:1px solid rgba(255,255,255,.08); opacity:0; transform: translateY(8px); transition: all .25s ease; }
    .toast.show { opacity: 1; transform: translateY(0); }
    .toast-title { font-weight:700; font-size:14px; }
    .toast-msg { font-size:13px; line-height:1.4; }
    .toast-close { margin-left:auto; background:transparent; color:#fff; border:none; cursor:pointer; font-size:16px; line-height:1; opacity:.8; }
    .toast--success { background:#14532d; border-color:#16a34a40; }
    .toast--error { background:#7f1d1d; border-color:#ef444440; }
    .toast--info { background:#0c4a6e; border-color:#0891b240; }
    /* Modal */
    .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);display:none;align-items:center;justify-content:center;z-index:9998}
    .modal-overlay.show{display:flex}
    .modal-card{background:#fff;border-radius:12px;border:1px solid #e3e3e0;max-width:420px;width:calc(100vw - 40px);box-shadow:0 10px 30px rgba(0,0,0,.25)}
    .modal-head{padding:14px 16px;border-bottom:1px solid #f0f0ef;font-weight:700}
    .modal-body{padding:14px 16px;color:#1b1b18}
    .modal-actions{display:flex;gap:8px;justify-content:flex-end;padding:12px 16px;border-top:1px solid #f0f0ef}
    .btn-danger{background:#b91c1c;color:#fff;border-color:#991b1b}

    /* Loading overlay */
    .loading-overlay{position:fixed;inset:0;background:rgba(255,255,255,.9);backdrop-filter:blur(2px);display:none;align-items:center;justify-content:center;z-index:10000}
    .loading-overlay.show{display:flex}
    .loading-box{display:grid;justify-items:center;gap:12px;padding:24px 28px;border-radius:14px;background:#fff;border:1px solid #e5e7eb;box-shadow:0 10px 30px rgba(0,0,0,.12)}
    .loading-spinner{width:56px;height:56px;border:5px solid #e5e7eb;border-top-color:#0891b2;border-radius:50%;animation:spin 1s linear infinite}
    .loading-text{font-weight:700;color:#1b1b18}
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
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn">Logout</button></form>
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
      <div class="loading-spinner" aria-hidden="true"></div>
      <div class="loading-text">Loading…</div>
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
      // Global loading overlay for navigation and form submissions
      (function(){
        var overlay = document.getElementById('loading-overlay');
        if(!overlay) return;
        function show(){ overlay.classList.add('show'); overlay.setAttribute('aria-hidden','false'); }
        function hide(){ overlay.classList.remove('show'); overlay.setAttribute('aria-hidden','true'); }

        // Ensure hidden on load
        document.addEventListener('DOMContentLoaded', hide);
        window.addEventListener('pageshow', hide);

        // Show when navigating away
        window.addEventListener('beforeunload', function(){
          // Some browsers limit DOM changes here, but toggling a class usually works
          show();
        });

        // Show immediately on in-page navigation triggers
        document.addEventListener('click', function(e){
          var a = e.target && e.target.closest ? e.target.closest('a') : null;
          if(!a) return;
          var href = a.getAttribute('href');
          if(!href) return;
          if (href.startsWith('#') || href.startsWith('javascript:')) return;
          if (a.hasAttribute('download')) return;
          if (a.target && a.target !== '_self') return;
          if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
          if (e.defaultPrevented) return;
          show();
        }, true);

        document.addEventListener('submit', function(e){
          if (e.defaultPrevented) return;
          show();
        }, true);
      })();
    </script>
</body>
</html>
