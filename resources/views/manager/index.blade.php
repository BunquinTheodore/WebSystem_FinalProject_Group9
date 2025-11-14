@extends('layouts.app')

@section('title', 'Manager')

@section('content')
  <style>
    /* Match Owner dashboard background and layout */
    body {
      background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%) !important;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }
    body::before { display: none !important; }
    .app-header { display: none !important; }
    .app-shell { max-width: none !important; margin: 0 !important; padding: 0 !important; }

    /* Manager Topbar (mirrors Owner style) */
    .manager-topbar { background:#fff; padding:12px 32px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 3px rgba(0,0,0,0.1); }
    .manager-topbar-logo { display:flex; align-items:center; gap:8px; font-size:18px; font-weight:600; color:#0891b2; }
    .manager-topbar-right { display:flex; align-items:center; gap:20px; }
    .manager-topbar-icon { width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#f0f9ff; color:#0891b2; cursor:pointer; transition:all .2s ease; text-decoration:none; }
    .manager-topbar-icon:hover { background:#0891b2; color:#fff; transform: scale(1.05); }
    .manager-topbar-user { display:flex; align-items:center; gap:10px; cursor:default; padding:6px 12px; border-radius:999px; transition: background .2s ease; }
    .manager-topbar-user:hover { background:#f0f9ff; }
    .manager-topbar-avatar { width:36px; height:36px; border-radius:50%; background:#0891b2; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:600; font-size:14px; }
    .manager-topbar-name { font-weight:600; color:#0f172a; font-size:14px; }
    .manager-topbar-role { font-size:12px; color:#64748b; }

    /* Dashboard cards (mirrors Owner) */
    .manager-dashboard-card { background:#fff; border-radius:16px; padding:32px 24px; text-align:center; cursor:pointer; transition: all .3s cubic-bezier(0.4,0,0.2,1); box-shadow:0 1px 3px rgba(0,0,0,.05); text-decoration:none; display:flex; flex-direction:column; align-items:center; gap:16px; }
    .manager-dashboard-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
    .manager-dashboard-card:active { transform: translateY(-2px); transition: all .1s ease; }
    .manager-dashboard-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:32px; transition: transform .3s ease; }
    .manager-dashboard-card:hover .manager-dashboard-icon { transform: scale(1.1) rotate(5deg); }

  /* Match Owner card typography */
  .owner-dashboard-title { font-weight: 600; font-size: 16px; color: #0f172a; margin: 0; }
  .owner-dashboard-subtitle { font-size: 13px; color: #64748b; margin: 0; }

    /* Section action affordances */
    .manager-section button,
    .manager-section a { transition: box-shadow .15s ease, filter .15s ease, background-color .15s ease, color .15s ease; }
    .manager-section button:hover,
    .manager-section a:hover { box-shadow: 0 6px 14px rgba(0,0,0,.08); filter: brightness(0.98); }
    .manager-section button:active,
    .manager-section a:active { filter: brightness(0.96); }
    .manager-section button:focus-visible,
    .manager-section a:focus-visible,
    .manager-topbar-icon:focus-visible { outline:3px solid #38bdf8; outline-offset:2px; }
  </style>

  <!-- Top Navigation Bar (Manager) -->
  <div class="manager-topbar">
    <div class="manager-topbar-logo">
      <img src="{{ asset('images/bluemoon-logo.png') }}" alt="Bluemoon" style="height:48px;width:auto;object-fit:contain">
    </div>
    <div class="manager-topbar-right">
      <a href="#" class="manager-topbar-icon" title="Logout" data-logout-confirm data-form="#logout-form-mgr">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M10 17l-5-5 5-5"/>
          <path d="M15 12H5"/>
          <path d="M19 21V3a2 2 0 0 0-2-2H9"/>
        </svg>
      </a>
      <div class="manager-topbar-user">
        <div class="manager-topbar-avatar">{{ strtoupper(substr(session('username', 'M'), 0, 1)) }}</div>
        <div>
          <div class="manager-topbar-name">{{ session('username', 'Manager') }}</div>
          <div class="manager-topbar-role">Manager</div>
        </div>
      </div>
  <form id="logout-form-mgr" action="{{ url('/logout') }}" method="POST" style="display:none">@csrf</form>
    </div>
  </div>

  <div style="max-width:1100px;margin:0 auto;padding:40px 20px">
    <div id="manager-welcome" style="text-align:center;padding:20px 12px 40px">
      <h1 style="margin:0 0 8px;font-size:32px;color:#0f172a;font-weight:400">Welcome back, {{ session('username', 'manager') }}!</h1>
      <div style="color:#64748b;font-size:15px">Choose a section to view details</div>
    </div>

    <div id="mgr-nav" style="display:grid;gap:24px;grid-template-columns:repeat(3,minmax(0,1fr));max-width:920px;margin:0 auto">
      <a href="#tasks" data-target="tasks" class="manager-dashboard-card">
        <div class="manager-dashboard-icon" style="background:#dbeafe"><span>📋</span></div>
        <div><div class="owner-dashboard-title">Tasks</div><div class="owner-dashboard-subtitle">Your daily tasks</div></div>
      </a>
      <a href="#reports" data-target="reports" class="manager-dashboard-card">
        <div class="manager-dashboard-icon" style="background:#fde68a"><span>📊</span></div>
        <div><div class="owner-dashboard-title">Reports</div><div class="owner-dashboard-subtitle">Financial reporting</div></div>
      </a>
      <a href="#inventory" data-target="inventory" class="manager-dashboard-card">
        <div class="manager-dashboard-icon" style="background:#e9d5ff"><span>📦</span></div>
        <div><div class="owner-dashboard-title">Inventory</div><div class="owner-dashboard-subtitle">Stock levels</div></div>
      </a>
      <a href="#requests" data-target="requests" class="manager-dashboard-card">
        <div class="manager-dashboard-icon" style="background:#fed7aa"><span>📝</span></div>
        <div><div class="owner-dashboard-title">Requests</div><div class="owner-dashboard-subtitle">Shop needs</div></div>
      </a>
      <a href="#payroll" data-target="payroll" class="manager-dashboard-card">
        <div class="manager-dashboard-icon" style="background:#d1fae5"><span>💰</span></div>
        <div><div class="owner-dashboard-title">Payroll</div><div class="owner-dashboard-subtitle">Wages & notes</div></div>
      </a>
      <a href="#employees" data-target="employees" class="manager-dashboard-card">
        <div class="manager-dashboard-icon" style="background:#ddd6fe"><span>👥</span></div>
        <div><div class="owner-dashboard-title">Employees</div><div class="owner-dashboard-subtitle">Team directory</div></div>
      </a>
    </div>

    <!-- Manager Sections (mirroring Owner pattern) -->
    <div class="manager-section" data-section="tasks" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button data-manager-back onclick="backToMainMgr()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all .2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
        <h3 class="section-title" style="margin:0">Tasks</h3>
      </div>
      @include('manager.sections.tasks')
    </div>

    <div class="manager-section" data-section="reports" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button data-manager-back onclick="backToMainMgr()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all .2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
        <h3 class="section-title" style="margin:0">Reports</h3>
      </div>
      @include('manager.sections.reports')
    </div>

    <div class="manager-section" data-section="inventory" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button data-manager-back onclick="backToMainMgr()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all .2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
        <h3 class="section-title" style="margin:0">Inventory</h3>
      </div>
      @include('manager.sections.inventory')
    </div>

    <div class="manager-section" data-section="requests" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button data-manager-back onclick="backToMainMgr()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all .2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
        <h3 class="section-title" style="margin:0">Requests</h3>
      </div>
      @include('manager.sections.requests')
    </div>

    <div class="manager-section" data-section="payroll" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button data-manager-back onclick="backToMainMgr()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all .2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
        <h3 class="section-title" style="margin:0">Payroll</h3>
      </div>
      @include('manager.sections.payroll')
    </div>

    <div class="manager-section" data-section="employees" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button data-manager-back onclick="backToMainMgr()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all .2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
        <h3 class="section-title" style="margin:0">Employees</h3>
      </div>
      @include('manager.sections.employees')
    </div>
  </div>

  <script>
    // Manager dashboard navigation (mirrors Owner behavior)
    function backToMainMgr(){
      document.querySelectorAll('.manager-section').forEach(function(section){ section.style.display = 'none'; });
      var w = document.getElementById('manager-welcome'); if(w) w.style.display = 'block';
      var n = document.getElementById('mgr-nav'); if(n) n.style.display = 'grid';
      history.replaceState(null, '', location.pathname);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    (function(){
      var nav = document.getElementById('mgr-nav');
      var welcome = document.getElementById('manager-welcome');
      function showSection(key){
        document.querySelectorAll('.manager-section').forEach(function(el){ el.style.display = (el.getAttribute('data-section') === key) ? '' : 'none'; });
        if(nav) nav.style.display = 'none';
        if(welcome) welcome.style.display = 'none';
        var targetFirst = document.querySelector('.manager-section[data-section="'+key+'"]');
        if(targetFirst){ targetFirst.scrollIntoView({ behavior:'smooth', block:'start' }); }
      }
      if(nav){
        nav.addEventListener('click', function(ev){
          var a = ev.target.closest('a[data-target]');
          if(!a) return;
          ev.preventDefault();
          var key = a.getAttribute('data-target');
          location.hash = key; // triggers hashchange
        });
      }
      document.addEventListener('click', function(ev){
        var backEl = ev.target.closest('[data-manager-back]');
        if(!backEl) return;
        ev.preventDefault();
        backToMainMgr();
      });
      window.addEventListener('hashchange', function(){
        var h = (location.hash||'').replace('#','');
        if(h){ showSection(h); } else { backToMainMgr(); }
      });
      if(location.hash){
        var h = (location.hash||'').replace('#','');
        if(h){ showSection(h); }
      }
      // If there are server-side validation errors, auto-open the relevant section and scroll to the first missing field
      @if(($errors ?? null) && $errors->any())
        (function(){
          try{
            var keys = @json(array_keys($errors->toArray()));
            var targetEl = null;
            for(var i=0;i<keys.length;i++){
              var el = document.querySelector('[name="'+keys[i]+'"]');
              if(el){ targetEl = el; break; }
            }
            if(targetEl){
              var sectionEl = targetEl.closest('.manager-section');
              var sectionKey = sectionEl ? sectionEl.getAttribute('data-section') : null;
              if(sectionKey){
                if((location.hash||'').replace('#','') !== sectionKey){
                  location.hash = sectionKey;
                  showSection(sectionKey);
                } else {
                  showSection(sectionKey);
                }
              }
              try{ targetEl.focus(); }catch(_){}
              try{ targetEl.scrollIntoView({ behavior:'smooth', block:'center' }); }catch(_){}
            }
          }catch(_){ }
        })();
      @endif
      // If arriving from /login or with ?fresh=1, force clean dashboard (no hash)
      try {
        var ref = document.referrer || '';
        var url = new URL(window.location.href);
        var fresh = url.searchParams.get('fresh');
        if(/\/login(\b|$)/.test(ref) || (fresh && fresh !== '0')){
          if(location.hash){ history.replaceState(null, '', location.pathname + url.search.replace(/([?&])fresh=[^&]*(&|$)/,'$1').replace(/[?&]$/,'')); }
          backToMainMgr();
          // Clean up the fresh param from the URL
          try {
            url.searchParams.delete('fresh');
            history.replaceState(null, '', url.pathname + (url.search ? url.search : ''));
          } catch(_){ /* ignore */ }
        }
      } catch(_) { /* ignore */ }
    })();
  </script>
    <script>
      (function(){
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const EXP_DEL_BASE = "{{ url('/manager/expense') }}";
        const REP_DEL_BASE = "{{ url('/manager/report') }}";
        const APEPO_DEL_BASE = "{{ url('/manager/apepo') }}";
        function fmt(n){ try { return new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(Number(n || 0)); } catch(e){ return Number(n||0).toFixed(2); } }
        function dt(s){ try { const d = new Date(s); return d.toLocaleString(); } catch(e){ return s; } }
        function makeReportCard(rep){
          const wrapper = document.createElement('div');
          wrapper.className = 'card';
          wrapper.style.borderRadius = '8px';
          wrapper.style.border = '1px solid #e3e3e0';
          wrapper.style.overflow = 'hidden';
          const shift = String(rep.shift || '').toUpperCase();
          wrapper.innerHTML = `
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Shift</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Cash (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Wallet (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Bank (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">${shift}</td>
                  <td style="padding:8px">₱${fmt(rep.cash)}</td>
                  <td style="padding:8px">₱${fmt(rep.wallet)}</td>
                  <td style="padding:8px">₱${fmt(rep.bank)}</td>
                  <td style="padding:8px;color:#706f6c">${dt(rep.created_at)}</td>
                  <td style="padding:8px">
                    <form class="mgr-del-form" method="POST" action="${REP_DEL_BASE}/${rep.id}/delete" style="margin:0">
                      <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                      <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this report?">Delete</button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>`;
          return wrapper;
        }
        function makeExpenseCard(exp){
          const wrapper = document.createElement('div');
          wrapper.className = 'card';
          wrapper.style.borderRadius = '8px';
          wrapper.style.border = '1px solid #e3e3e0';
          wrapper.style.overflow = 'hidden';
          wrapper.innerHTML = `
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amount (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Description</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">₱${fmt(exp.amount)}</td>
                  <td style="padding:8px">${exp.note || ''}</td>
                  <td style="padding:8px;color:#706f6c">${dt(exp.created_at)}</td>
                  <td style="padding:8px">
                    <form class="mgr-del-form" method="POST" action="${EXP_DEL_BASE}/${exp.id}/delete" style="margin:0">
                      <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                      <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this expense?">Delete</button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>`;
          return wrapper;
        }
        function makeApepoCard(p){
          const wrapper = document.createElement('div');
          wrapper.className = 'card';
          wrapper.style.borderRadius = '8px';
          wrapper.style.border = '1px solid #e3e3e0';
          wrapper.style.overflow = 'hidden';
          wrapper.innerHTML = `
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Section</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Details</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">Audit</td>
                  <td style="padding:8px">${(p.audit||'')}</td>
                  <td style="padding:8px;color:#706f6c">${dt(p.created_at)}</td>
                  <td style="padding:8px" rowspan="5">
                    <form class="mgr-del-form" method="POST" action="${APEPO_DEL_BASE}/${p.id}/delete" style="margin:0">
                      <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                      <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this APEPO report?">Delete</button>
                    </form>
                  </td>
                </tr>
                <tr>
                  <td style="padding:8px">People</td>
                  <td style="padding:8px">${(p.people||'')}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Equipment</td>
                  <td style="padding:8px">${(p.equipment||'')}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Product</td>
                  <td style="padding:8px">${(p.product||'')}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Others</td>
                  <td style="padding:8px">${(p.others||'')}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                ${p.notes ? `<tr><td style="padding:8px">Notes</td><td style="padding:8px" colspan="2">${p.notes}</td></tr>` : ''}
              </tbody>
            </table>`;
          return wrapper;
        }
        async function refreshTotals(){
          try {
            const res = await fetch("{{ route('manager.totals') }}", { headers: { "X-Requested-With":"XMLHttpRequest" } });
            if(!res.ok) return;
            const data = await res.json();
            const f = document.getElementById('mgr-total-fund');
            const e = document.getElementById('mgr-total-exp');
            const a = document.getElementById('mgr-total-avail');
            if(f) f.innerHTML = 'Current balance: <strong>₱'+fmt(data.fundBalance)+'</strong>';
            if(e) e.innerHTML = 'Total expenses: <strong>₱'+fmt(data.expensesTotal)+'</strong>';
            if(a) a.innerHTML = 'Available balance: <strong>₱'+fmt(data.availableBalance)+'</strong>';
          } catch(err) { /* silent */ }
        }
        function pulse(el, color){
          if(!el) return;
          try{
            el.style.transition = 'background-color 320ms ease, box-shadow 320ms ease';
            el.style.background = color;
            el.style.boxShadow = 'inset 0 0 0 1px rgba(0,0,0,0.05)';
            setTimeout(function(){ if(el){ el.style.background=''; el.style.boxShadow=''; } }, 800);
          }catch(_){/* noop */}
        }
        function highlightTotals(opts){
          const f = document.getElementById('mgr-total-fund');
          const e = document.getElementById('mgr-total-exp');
          const a = document.getElementById('mgr-total-avail');
          if(opts && opts.fund) pulse(f, '#eaf7ee');
          if(opts && opts.exp) pulse(e, '#fdecea');
          if(opts && opts.avail) pulse(a, '#eef5ff');
        }
        async function submitAjax(form){
          try {
            const fd = new FormData(form);
            const res = await fetch(form.action, { method:"POST", body: fd, headers: { "X-Requested-With":"XMLHttpRequest" } });
            if(!res.ok){ throw new Error('Save failed'); }
            let payload = null; try { const ct = (res.headers.get('content-type')||'').toLowerCase(); if(ct.includes('application/json')) payload = await res.json(); } catch(_){}
            form.reset();
            await refreshTotals();
            // Highlight changed totals based on form
            if(form.id === 'mgr-fund-form'){
              highlightTotals({ fund:true, avail:true });
            } else if(form.id === 'mgr-expense-form'){
              highlightTotals({ exp:true, avail:true });
              // Try to append the newly created expense card without reload
              try {
                if(payload && payload.expense){
                  const host = document.getElementById('mgr-expense-list');
                  if(host){
                    const card = makeExpenseCard(payload.expense);
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.98)';
                    card.style.transition = 'opacity 180ms ease, transform 180ms ease';
                    host.prepend(card);
                    requestAnimationFrame(()=>{ card.style.opacity='1'; card.style.transform='scale(1)'; });
                  }
                }
              } catch(_){ /* ignore append errors */ }
            } else if(form.id === 'mgr-report-form'){
              // Append new report card
              try {
                if(payload && payload.report){
                  const host = document.getElementById('mgr-report-list');
                  if(host){
                    const card = makeReportCard(payload.report);
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.98)';
                    card.style.transition = 'opacity 180ms ease, transform 180ms ease';
                    host.prepend(card);
                    requestAnimationFrame(()=>{ card.style.opacity='1'; card.style.transform='scale(1)'; });
                  }
                }
              } catch(_){ /* ignore append errors */ }
            } else if(form.id === 'mgr-apepo-form'){
              // Append new APEPO card
              try {
                if(payload && payload.apepo){
                  const host = document.getElementById('mgr-apepo-list');
                  if(host){
                    const card = makeApepoCard(payload.apepo);
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.98)';
                    card.style.transition = 'opacity 180ms ease, transform 180ms ease';
                    host.prepend(card);
                    requestAnimationFrame(()=>{ card.style.opacity='1'; card.style.transform='scale(1)'; });
                  }
                }
              } catch(_){ /* ignore append errors */ }
            } else {
              highlightTotals({ avail:true });
            }
            if(window.toast){ window.toast('Saved. Totals updated.','success'); }
          } catch(err){
            // Fallback to normal submit if AJAX fails
            form.submit();
          }
        }
        const fundForm = document.getElementById('mgr-fund-form');
        if(fundForm){ fundForm.addEventListener('submit', function(ev){ ev.preventDefault(); submitAjax(fundForm); }); }
        const expForm = document.getElementById('mgr-expense-form');
        if(expForm){ expForm.addEventListener('submit', function(ev){ ev.preventDefault(); submitAjax(expForm); }); }
  const apepoForm = document.getElementById('mgr-apepo-form');
  if(apepoForm){ apepoForm.addEventListener('submit', function(ev){ ev.preventDefault(); submitAjax(apepoForm); }); }
        // Inventory forms
        const invItemForm = document.getElementById('inv-item-form');
        if(invItemForm){ invItemForm.addEventListener('submit', async function(ev){
          ev.preventDefault();
          try{
            const fd = new FormData(invItemForm);
            const res = await fetch(invItemForm.action, { method:'POST', body: fd, headers: { 'X-Requested-With':'XMLHttpRequest' } });
            if(!res.ok) throw new Error('Add failed');
            const data = await res.json();
            invItemForm.reset();
            if(data && data.item){
              const host = document.getElementById('inv-list');
              if(host){
                const card = document.createElement('div');
                card.className = 'card';
                card.style.borderRadius='8px'; card.style.border='1px solid #e3e3e0'; card.style.overflow='hidden';
                const it = data.item;
                card.innerHTML = `
                  <table style="width:100%;border-collapse:collapse">
                    <thead>
                      <tr>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Item</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Category</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Qty</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Min</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Unit</th>
                        <th style=\"text-align:left;border-bottom:1px solid #f0f0ef;padding:8px\">Adjust</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style=\"padding:8px\">${it.name||''}</td>
                        <td style=\"padding:8px\">${it.category||''}</td>
                        <td class=\"inv-qty\" data-id=\"${it.id}\" style=\"padding:8px\">${it.quantity||0}</td>
                        <td style=\"padding:8px\">${it.min_threshold||0}</td>
                        <td style=\"padding:8px\">${it.unit||''}</td>
                        <td style=\"padding:8px\">
                          <form class=\"inv-adjust\" method=\"POST\" action=\"{{ url('/manager/inventory') }}/${it.id}/adjust\" style=\"display:inline-flex;gap:6px;align-items:center\">
                            <input type=\"hidden\" name=\"_token\" value=\"${CSRF_TOKEN}\" />
                            <input name=\"delta\" type=\"number\" value=\"1\" style=\"width:80px\" />
                            <input name=\"reason\" placeholder=\"reason\" style=\"width:160px\" />
                            <button style=\"padding:6px 10px;background:#16a34a;color:#fff;border-radius:6px\">Apply</button>
                          </form>
                        </td>
                      </tr>
                    </tbody>
                  </table>`;
                card.style.opacity='0'; card.style.transform='scale(0.98)'; card.style.transition='opacity 180ms ease, transform 180ms ease';
                host.prepend(card);
                requestAnimationFrame(()=>{ card.style.opacity='1'; card.style.transform='scale(1)'; });
              }
            }
            if(window.toast){ window.toast('Item added.','success'); }
          }catch(err){ invItemForm.submit(); }
        }); }
        document.addEventListener('submit', async function(ev){
          const f = ev.target.closest('form.inv-adjust');
          if(!f) return;
          ev.preventDefault();
          try{
            const fd = new FormData(f);
            const res = await fetch(f.action, { method:'POST', body: fd, headers: { 'X-Requested-With':'XMLHttpRequest' } });
            if(!res.ok) throw new Error('Adjust failed');
            const data = await res.json();
            const rowQty = f.closest('tr')?.querySelector('.inv-qty');
            if(rowQty && data && typeof data.quantity !== 'undefined'){
              rowQty.textContent = data.quantity;
              // low-stock highlight when <= min
              const minCell = f.closest('tr')?.children[3];
              const min = minCell ? parseInt(minCell.textContent||'0',10) : 0;
              if(data.quantity <= min){ rowQty.style.color = '#b91c1c'; rowQty.style.fontWeight = '600'; } else { rowQty.style.color=''; rowQty.style.fontWeight=''; }
              // animate pulse
              rowQty.style.transition='background-color 320ms ease'; rowQty.style.background='#eef5ff'; setTimeout(()=>{ rowQty.style.background=''; }, 700);
            }
            if(window.toast){ window.toast('Inventory updated.','success'); }
          }catch(err){ f.submit(); }
        });
        // Deletion via AJAX for manager lists
        function findEntryContainer(el){
          let node = el;
          while(node){
            if(node.classList && node.classList.contains('card')) return node;
            if(node.tagName && node.tagName.toLowerCase() === 'li') return node;
            node = node.parentElement;
          }
          return null;
        }
        function animateRemove(el){
          if(!el) return false;
          try {
            const h = el.getBoundingClientRect().height;
            el.style.boxSizing = 'border-box';
            el.style.height = h + 'px';
            el.style.transition = 'height 180ms ease, opacity 160ms ease, transform 160ms ease, margin 160ms ease, padding 160ms ease';
            // Force reflow
            void el.offsetHeight;
            el.style.opacity = '0';
            el.style.transform = 'scale(0.98)';
            el.style.height = '0px';
            el.style.marginTop = '0px';
            el.style.marginBottom = '0px';
            el.style.paddingTop = '0px';
            el.style.paddingBottom = '0px';
            setTimeout(function(){ if(el && el.parentElement){ el.parentElement.removeChild(el); } }, 220);
            return true;
          } catch(_) { return false; }
        }
        async function handleDelete(form){
          try{
            const fd = new FormData(form);
            const res = await fetch(form.action, { method: 'POST', body: fd, headers: { "X-Requested-With":"XMLHttpRequest" } });
            if(!res.ok) throw new Error('Delete failed');
            const el = findEntryContainer(form);
            if(!animateRemove(el)){
              if(el && el.parentElement){ el.parentElement.removeChild(el); }
            }
            try {
              await refreshTotals();
              // Heuristic: if deleting an expense, highlight expenses + available
              const url = (form && form.action) || '';
              if(url.indexOf('/manager/expense/') !== -1){
                highlightTotals({ exp:true, avail:true });
              } else if(url.indexOf('/manager/report/') !== -1){
                // No totals change for reports; subtle available pulse for feedback
                highlightTotals({ avail:true });
              }
            } catch(e){}
              if(window.toast){ window.toast('Removed. Totals updated.','success'); }
          }catch(err){ form.submit(); }
        }
        document.addEventListener('submit', async function(ev){
          const form = ev.target.closest('form.mgr-del-form');
          if(form){
            if(form.dataset && form.dataset.modalConfirmed === '1') return; // already handled by global
            const btn = form.querySelector('button');
            const msg = (btn && btn.getAttribute('data-confirm')) || 'Remove this item?';
            ev.preventDefault();
            let ok = true;
            if(window.modalConfirm){
              try { ok = await window.modalConfirm(msg, { type:'danger', confirmText:'Delete', title:'Please confirm' }); } catch(_) { ok = false; }
            } else {
              ok = window.confirm(msg);
            }
            if(!ok) return;
            // mark to avoid double prompts from global handler
            try{ form.dataset.modalConfirmed = '1'; }catch(_){}
            handleDelete(form);
          }
        });
      })();
    </script>
  </div>
@endsection
