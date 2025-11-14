@extends('layouts.app')

@section('title', 'Owner')

@section('content')
<style>
  /* Override parent layout for owner dashboard */
  body {
    background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%) !important;
    min-height: 100vh;
    margin: 0;
    padding: 0;
  }
  .app-header {
    display: none !important;
  }
  .app-shell {
    max-width: none !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  body::before {
    display: none !important;
  }
  
  /* Top navigation bar */
  .owner-topbar {
    background: #fff;
    padding: 12px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  .owner-topbar-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 18px;
    font-weight: 600;
    color: #0891b2;
  }
  .owner-topbar-right {
    display: flex;
    align-items: center;
    gap: 20px;
  }
  
  .owner-topbar-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0f9ff;
    color: #0891b2;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
  }
  .owner-topbar-icon:hover {
    background: #0891b2;
    color: #fff;
    transform: scale(1.05);
  }
  .owner-topbar-user {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: default;
    padding: 6px 12px;
    border-radius: 999px;
    transition: background 0.2s ease;
  }
  .owner-topbar-user:hover {
    background: #f0f9ff;
  }
  .owner-topbar-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #0891b2;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
  }
  .owner-topbar-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
  .owner-topbar-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 14px;
  }
  .owner-topbar-role {
    font-size: 12px;
    color: #64748b;
  }
  
  /* Dashboard cards */
  .owner-dashboard-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px 24px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
  }
  .owner-dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1);
  }
  .owner-dashboard-card:active {
    transform: translateY(-2px);
    transition: all 0.1s ease;
  }
  .owner-dashboard-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    transition: transform 0.3s ease;
  }
  .owner-dashboard-card:hover .owner-dashboard-icon {
    transform: scale(1.1) rotate(5deg);
  }
  .owner-dashboard-title {
    font-weight: 600;
    font-size: 16px;
    color: #0f172a;
    margin: 0;
  }
  .owner-dashboard-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0;
  }
  
  /* Universal hover reactions for functional controls on Owner dashboard */
  .owner-topbar-icon { transition: background-color .15s ease, color .15s ease, box-shadow .15s ease; }
  .owner-topbar-icon:hover { box-shadow: 0 6px 14px rgba(0,0,0,.08); }
  .owner-topbar-icon:active { transform: scale(0.98); }

  /* Buttons and clickable links inside sections */
  .owner-section button,
  .owner-section a {
    transition: box-shadow .15s ease, filter .15s ease, background-color .15s ease, color .15s ease;
  }
  .owner-section button:hover,
  .owner-section a:hover {
    box-shadow: 0 6px 14px rgba(0,0,0,.08);
    filter: brightness(0.98);
  }
  .owner-section button:active,
  .owner-section a:active { filter: brightness(0.96); }

  /* Keyboard focus visibility for accessibility */
  .owner-section button:focus-visible,
  .owner-section a:focus-visible,
  .owner-topbar-icon:focus-visible {
    outline: 3px solid #38bdf8;
    outline-offset: 2px;
  }

  
</style>

  <!-- Top Navigation Bar -->
  <div class="owner-topbar">
    <div class="owner-topbar-logo">
      <img src="{{ asset('images/bluemoon-logo.png') }}" alt="Bluemoon" style="height:48px;width:auto;object-fit:contain">
    </div>
    <div class="owner-topbar-right">
      <a href="{{ url('/owner/manage-tasks') }}" class="owner-topbar-icon" title="Manage Tasks">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="12" y1="18" x2="12" y2="12"/>
          <line x1="9" y1="15" x2="15" y2="15"/>
        </svg>
      </a>
      <a href="#" class="owner-topbar-icon" title="Logout" data-logout-confirm data-form="#logout-form">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M10 17l-5-5 5-5"/>
          <path d="M15 12H5"/>
          <path d="M19 21V3a2 2 0 0 0-2-2H9"/>
        </svg>
      </a>
      <div class="owner-topbar-user">
        <div class="owner-topbar-avatar">{{ strtoupper(substr(session('username', 'O'), 0, 1)) }}</div>
        <div class="owner-topbar-info">
          <div class="owner-topbar-name">{{ session('username', 'Owner') }}</div>
          <div class="owner-topbar-role">Owner</div>
        </div>
      </div>
      <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display:none">@csrf</form>
    </div>
  </div>

  <div style="max-width:1100px;margin:0 auto;padding:40px 20px">
    <div id="owner-welcome" style="text-align:center;padding:20px 12px 40px">
      <h1 style="margin:0 0 8px;font-size:32px;color:#0f172a;font-weight:400">Welcome back, {{ session('username', 'owner') }}!</h1>
      <div style="color:#64748b;font-size:15px">Choose a section to view details</div>
    </div>

    <div id="owner-nav" class="owner-nav" style="display:grid;gap:24px;grid-template-columns:repeat(3,minmax(0,1fr));max-width:920px;margin:0 auto">
      <a href="#store" data-target="store" class="owner-dashboard-card">
        <div class="owner-dashboard-icon" style="background:#dbeafe">
          <span>🏬</span>
        </div>
        <div>
          <div class="owner-dashboard-title">Store</div>
          <div class="owner-dashboard-subtitle">Opening & Closing Tasks</div>
        </div>
      </a>
      <a href="#sales" data-target="sales" class="owner-dashboard-card">
        <div class="owner-dashboard-icon" style="background:#d1fae5">
          <span>💵</span>
        </div>
        <div>
          <div class="owner-dashboard-title">Sales</div>
          <div class="owner-dashboard-subtitle">Reports & Performance</div>
        </div>
      </a>
      <a href="#inventory" data-target="inventory" class="owner-dashboard-card">
        <div class="owner-dashboard-icon" style="background:#e9d5ff">
          <span>📦</span>
        </div>
        <div>
          <div class="owner-dashboard-title">Inventory</div>
          <div class="owner-dashboard-subtitle">Stock Levels</div>
        </div>
      </a>
      <a href="#requests" data-target="requests" class="owner-dashboard-card">
        <div class="owner-dashboard-icon" style="background:#fed7aa">
          <span>📝</span>
        </div>
        <div>
          <div class="owner-dashboard-title">Requests</div>
          <div class="owner-dashboard-subtitle">Shop Needs</div>
        </div>
      </a>
      <a href="#apepo" data-target="apepo" class="owner-dashboard-card">
        <div class="owner-dashboard-icon" style="background:#fde68a">
          <span>📊</span>
        </div>
        <div>
          <div class="owner-dashboard-title">Audit / Payroll</div>
          <div class="owner-dashboard-subtitle">Employee Payments</div>
        </div>
      </a>
      <a href="#employees" data-target="employees" class="owner-dashboard-card">
        <div class="owner-dashboard-icon" style="background:#ddd6fe">
          <span>👥</span>
        </div>
        <div>
          <div class="owner-dashboard-title">Employees</div>
          <div class="owner-dashboard-subtitle">Staff Management</div>
        </div>
      </a>
    </div>


    @include('owner.sections.store')

    @include('owner.sections.sales')

    @include('owner.sections.apepo')

    @include('owner.sections.requests')

    @include('owner.sections.inventory')

    @include('owner.sections.employees')
  </div>
  
  
  <script>
    function backToMain() {
      document.querySelectorAll('.owner-section').forEach(function(section) {
        section.style.display = 'none';
      });
      document.getElementById('owner-welcome').style.display = 'block';
      document.getElementById('owner-nav').style.display = 'grid';
    }
    
    (function(){
      var invFilters = document.getElementById('inventory-filters');
      function applyInvFilter(){
        var active = invFilters ? invFilters.querySelector('.inv-pill.is-active') : null;
        var key = active ? active.getAttribute('data-filter') : 'all';
        document.querySelectorAll('#inv-table .inv-row').forEach(function(r){
          var cat = (r.getAttribute('data-cat')||'');
          var show = (key==='all') || (key==='kitchen' && cat.indexOf('kitchen')!==-1) || (key==='coffee' && cat.indexOf('coffee')!==-1);
          r.style.display = show ? '' : 'none';
        });
      }
      if(invFilters){
        invFilters.addEventListener('click', function(ev){
          var p = ev.target.closest('.inv-pill');
          if(!p) return;
          ev.preventDefault();
          invFilters.querySelectorAll('.inv-pill').forEach(function(x){ x.classList.remove('is-active'); x.style.background='#fff'; x.style.color=''; x.style.borderColor='#e5e7eb'; });
          p.classList.add('is-active'); p.style.background='#111827'; p.style.color='#fff'; p.style.borderColor='#111827';
          applyInvFilter();
        });
        applyInvFilter();
      }
      var checkAll = document.getElementById('inv-check-all');
      if(checkAll){
        checkAll.addEventListener('change', function(){
          document.querySelectorAll('.inv-check').forEach(function(c){ c.checked = !!checkAll.checked; });
        });
      }
      var nav = document.getElementById('owner-nav');
      var welcome = document.getElementById('owner-welcome');
      function showSection(key){
        document.querySelectorAll('.owner-section').forEach(function(el){
          el.style.display = (el.getAttribute('data-section') === key) ? '' : 'none';
        });
        if(nav){ nav.style.display = 'none'; }
        if(welcome){ welcome.style.display = 'none'; }
        if(key === 'store'){
          setTimeout(function(){ if(typeof applyToggleStyles === 'function') applyToggleStyles(); }, 0);
        }
        var targetFirst = document.querySelector('.owner-section[data-section="'+key+'"]');
        if(targetFirst){ targetFirst.scrollIntoView({ behavior:'smooth', block:'start' }); }
      }
      function backToMain(){
        document.querySelectorAll('.owner-section').forEach(function(el){ el.style.display = 'none'; });
        if(nav){ nav.style.display = 'grid'; }
        if(welcome){ welcome.style.display = ''; }
        history.replaceState(null, '', location.pathname); // clear hash
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
      if(nav){
        nav.addEventListener('click', function(ev){
          var a = ev.target.closest('a[data-target]');
          if(!a) return;
          ev.preventDefault();
          var key = a.getAttribute('data-target');
          location.hash = key; // keep deep-link; hashchange handler will call showSection
        });
      }
      // Ensure any element marked as owner-back triggers main view
      document.addEventListener('click', function(ev){
        var backEl = ev.target.closest('[data-owner-back]');
        if(!backEl) return;
        ev.preventDefault();
        backToMain();
      });
      window.addEventListener('hashchange', function(){
        var h = (location.hash||'').replace('#','');
        if(h){ showSection(h); } else { backToMain(); }
      });
      if(location.hash){
        var h = (location.hash||'').replace('#','');
        if(h){ showSection(h); }
      }

      // Store tasks UI
      var tabs = document.getElementById('store-toggle');
      var lists = document.querySelectorAll('.store-list');
      function applyToggleStyles(){
        if(!tabs) return;
        var ind = document.getElementById('store-toggle-indicator');
        var btns = tabs.querySelectorAll('.tab-btn');
        if(btns.length < 2) return;
        var openingBtn = btns[0];
        var closingBtn = btns[1];
        var active = tabs.querySelector('.tab-btn.is-active') || openingBtn;
        var isOpen = active.getAttribute('data-tab') === 'opening';
        if(ind){
          var w = openingBtn.offsetWidth;
          if(w && w > 0){
            ind.style.width = w + 'px';
            ind.style.left = isOpen ? '2px' : (w + 4) + 'px';
          } else {
            ind.style.width = '';
            ind.style.left = isOpen ? '6px' : '';
            setTimeout(applyToggleStyles, 50);
          }
        }
        openingBtn.style.color = isOpen ? '#fff' : '#111827';
        closingBtn.style.color = isOpen ? '#111827' : '#fff';
      }
      function setActiveTab(tab){
        if(!tabs) return;
        tabs.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('is-active'); });
        var btn = tabs.querySelector('.tab-btn[data-tab="'+tab+'"]');
        if(btn){ btn.classList.add('is-active'); }
        lists.forEach(function(el){ el.style.display = (el.getAttribute('data-type')===tab)?'':'none'; });
        applyToggleStyles();
      }
      if(tabs){
        // Default to opening tab on load and ensure styles after layout
        setActiveTab('opening');
        setTimeout(applyToggleStyles, 0);
        window.addEventListener('load', applyToggleStyles);
        tabs.addEventListener('click', function(ev){
          var btn = ev.target.closest('.tab-btn');
          if(!btn) return;
          ev.preventDefault();
          setActiveTab(btn.getAttribute('data-tab'));
        });
        window.addEventListener('resize', function(){ applyToggleStyles(); });
      }
      
      function closestRow(el){ while(el && el.tagName && el.tagName.toLowerCase() !== 'tr'){ el = el.parentElement; } return el; }
      document.addEventListener('submit', async function(ev){
        const ajaxForm = ev.target.closest('form.owner-ajax');
        if(ajaxForm){
          ev.preventDefault();
          try {
            const fd = new FormData(ajaxForm);
            const res = await fetch(ajaxForm.action, { method:'POST', body: fd, headers: { 'X-Requested-With':'XMLHttpRequest' } });
            if(!res.ok) throw new Error('Request failed');
            if(ajaxForm.id === 'owner-add-location') { location.reload(); return; }
            const locForm = ajaxForm.classList.contains('task-location');
            if(locForm && window.toast){ window.toast('Task updated','success'); }
            if(!locForm){ location.reload(); }
          } catch(e){ ajaxForm.submit(); }
          return;
        }
        const form = ev.target.closest('form.owner-req-form');
        if(!form) return;
        ev.preventDefault();
        const btn = form.querySelector('button');
        const msg = (btn && btn.getAttribute('data-confirm')) || 'Are you sure?';
        let proceed = true;
        if(window.modalConfirm){
          try { proceed = await window.modalConfirm(msg, { title: 'Please confirm' }); } catch(_) { proceed = false; }
        } else {
          proceed = window.confirm(msg);
        }
        if(!proceed) return;
        try {
          const fd = new FormData(form);
          const res = await fetch(form.action, { method:'POST', body: fd, headers: { 'X-Requested-With':'XMLHttpRequest' } });
          if(!res.ok){ throw new Error('Request failed'); }
          // Update the card UI (not table rows)
          const card = form.closest('.req-card');
          const statusEl = card ? card.querySelector('[data-req-status]') : null;
          const actionsEl = card ? card.querySelector('[data-req-actions]') : null;
          const result = (form.getAttribute('data-result') || '').toLowerCase();
          // Smoothly update status text within the badge
          if(statusEl){
            statusEl.style.transition = 'opacity 160ms ease';
            statusEl.style.opacity = '0';
            setTimeout(function(){
              const strong = statusEl.querySelector('strong');
              if(strong){ strong.textContent = result ? (result.charAt(0).toUpperCase()+result.slice(1)) : 'Updated'; }
              statusEl.style.opacity = '1';
            }, 160);
          }
          // Fade out actions, then replace with "No actions available"
          if(actionsEl){
            actionsEl.style.transition = 'opacity 160ms ease';
            actionsEl.style.opacity = '0';
            setTimeout(function(){
              actionsEl.innerHTML = '<span style="color:#6b7280;font-size:13px">No actions available</span>';
              actionsEl.style.opacity = '1';
            }, 160);
          }
          // Card highlight feedback
          if(card){
            card.style.transition = 'background-color 320ms ease, box-shadow 320ms ease';
            card.style.background = (result === 'approved') ? '#eaf7ee' : '#fdecea';
            card.style.boxShadow = 'inset 0 0 0 1px ' + ((result === 'approved') ? '#a7e1b2' : '#f5b5b5');
            setTimeout(function(){ card.style.background=''; card.style.boxShadow=''; }, 900);
          }
          if(window.toast){ window.toast('Request '+(result||'updated')+'.','success'); }
        } catch(err){
          // Fallback: normal submission
          form.submit();
        }
      });
    })();
  </script>
@endsection
@push('scripts')
<script>
(function(){
  const form = document.getElementById('apepo-filter-form');
  const input = document.getElementById('mgr-input');
  const chips = document.getElementById('mgr-chips');
  const hidden = document.getElementById('mgr-hidden');
  function addManager(val){
    val = String(val||'').trim();
    if(!val) return;
    // Prevent duplicates (case-insensitive)
    const exists = Array.from(hidden.querySelectorAll('input[name="manager[]"]')).some(i => (i.value||'').toLowerCase() === val.toLowerCase());
    if(exists) { input.value=''; return; }
    const chip = document.createElement('span');
    chip.className = 'mgr-chip';
    chip.setAttribute('data-value', val);
    chip.style.display = 'inline-flex';
    chip.style.alignItems = 'center';
    chip.style.gap = '6px';
    chip.style.background = '#eef2ff';
    chip.style.border = '1px solid #dbe2ff';
    chip.style.color = '#1b1b18';
    chip.style.padding = '4px 8px';
    chip.style.borderRadius = '999px';
    const label = document.createElement('span');
    label.textContent = val;
    const x = document.createElement('button');
    x.type = 'button';
    x.className = 'chip-x';
    x.setAttribute('aria-label','Remove');
    x.style.background = 'transparent';
    x.style.border = 'none';
    x.style.color = '#555';
    x.style.cursor = 'pointer';
    x.textContent = '×';
    x.addEventListener('click', function(){
      const h = hidden.querySelector('input[name="manager[]"][value="'+CSS.escape(val)+'"]');
      if(h && h.parentElement) h.parentElement.removeChild(h);
      if(chip && chip.parentElement) chip.parentElement.removeChild(chip);
    });
    chip.appendChild(label);
    chip.appendChild(x);
    chips.appendChild(chip);
    const h = document.createElement('input');
    h.type = 'hidden';
    h.name = 'manager[]';
    h.value = val;
    hidden.appendChild(h);
    input.value = '';
  }
  if(form && input && chips && hidden){
    // Add with Enter key in input
    input.addEventListener('keydown', function(ev){
      if(ev.key === 'Enter') { ev.preventDefault(); addManager(input.value); }
    });
  }
})();
</script>
@endpush
