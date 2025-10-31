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
      <a href="#" class="owner-topbar-icon" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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


    <div id="store" class="owner-section" data-section="store" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </button>
        <h3 class="section-title" style="margin:0">Store Tasks</h3>
      </div>
      <div style="display:grid;gap:12px;grid-template-columns:repeat(4,minmax(0,1fr));margin-bottom:12px">
        @php
          $openList = $openingTaskList ?? [];
          $closeList = $closingTaskList ?? [];
          $openTotalCalc = count($openList) ?: (int)($openingTotal ?? 0);
          $closeTotalCalc = count($closeList) ?: (int)($closingTotal ?? 0);
          $openDoneCalc = count(array_filter($openList, function($t){ return !empty($t['completed']); })) ?: (int)($openingCompleted ?? 0);
          $closeDoneCalc = count(array_filter($closeList, function($t){ return !empty($t['completed']); })) ?: (int)($closingCompleted ?? 0);
          $allDoneCalc = $openDoneCalc + $closeDoneCalc;
          $allTotalCalc = $openTotalCalc + $closeTotalCalc;
          $allPendingCalc = max($allTotalCalc - $allDoneCalc, 0);
        @endphp
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="color:#166534;font-size:12px;margin-bottom:4px">Opening Completed</div>
            <div style="font-size:22px;font-weight:700;color:#065f46">{{ $openDoneCalc }}/{{ $openTotalCalc }}</div>
          </div>
          <div style="font-size:22px;color:#16a34a">✅</div>
        </div>
        <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="color:#9a3412;font-size:12px;margin-bottom:4px">Closing Completed</div>
            <div style="font-size:22px;font-weight:700;color:#7c2d12">{{ $closeDoneCalc }}/{{ $closeTotalCalc }}</div>
          </div>
          <div style="font-size:22px;color:#ea580c">⏱️</div>
        </div>
        <div style="background:#f8fafc;border:1px solid #cbd5e1;border-radius:10px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="color:#334155;font-size:12px;margin-bottom:4px">Total Pending</div>
            <div style="font-size:22px;font-weight:700;color:#0f172a">{{ $allPendingCalc }}/{{ $allTotalCalc }}</div>
          </div>
          <div style="font-size:22px;color:#475569">⏳</div>
        </div>
        <div style="background:#ecfdf5;border:1px solid #86efac;border-radius:10px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="color:#047857;font-size:12px;margin-bottom:4px">Total Completed</div>
            <div style="font-size:22px;font-weight:700;color:#065f46">{{ $allDoneCalc }}/{{ $allTotalCalc }}</div>
          </div>
          <div style="font-size:22px;color:#10b981">🏁</div>
        </div>
        
      </div>

      
      <div id="store-toggle" style="position:relative;display:inline-flex;background:#f3f4f6;border:1px solid #e5e7eb;border-radius:999px;overflow:hidden;margin-bottom:12px">
        <div id="store-toggle-indicator" style="position:absolute;top:2px;left:2px;height:calc(100% - 4px);width:50%;border-radius:999px;background:#111827;transition:all .2s ease"></div>
        <button class="tab-btn is-active" data-tab="opening" style="position:relative;padding:8px 14px;border:none;background:transparent;color:#fff;z-index:1">Opening Tasks</button>
        <button class="tab-btn" data-tab="closing" style="position:relative;padding:8px 14px;border:none;background:transparent;color:#111827;z-index:1">Closing Tasks</button>
      </div>
      <div id="store-task-list" style="background:#fff;border:1px solid #e3e3e0;border-radius:12px;padding:16px;margin-bottom:12px;display:grid;gap:8px">
          @php
            $renderTask = function($t){
              $badge = $t['completed'] ? '<span style="background:#22c55e;color:#fff;padding:4px 8px;border-radius:999px;font-size:12px">Completed</span>' : '<span style="background:#e5e7eb;color:#111827;padding:4px 8px;border-radius:999px;font-size:12px">Pending</span>';
              $loc = $t['location'] ?: 'Unassigned';
              $time = $t['time'] ? \Carbon\Carbon::parse($t['time'])->format('g:i A') : '';
              $emp = $t['employee'] ? ('By '. $t['employee']) : '';
              $sub = trim(($emp.' '.($time?('at '.$time):'')));
              return '<div class="store-task" data-location="'.strtolower($loc).'" style="display:flex;justify-content:space-between;align-items:center;border:1px solid #e5e7eb;background:'.($t['completed'] ? '#ecfdf5' : '#fff').' ;border-radius:10px;padding:12px 14px">'
                .'<div>'
                  .'<div style="font-weight:600;color:#0f172a">'.e($t['title']).'</div>'
                  .'<div style="font-size:12px;color:#6b7280">'.($sub ?: '&nbsp;').'</div>'
                .'</div>'
                .'<div style="display:flex;gap:8px;align-items:center">'
                  .'<span style="background:#eef2ff;border:1px solid #dbe2ff;padding:4px 8px;border-radius:999px;font-size:12px">'.e($loc).'</span>'
                  .$badge.
                '</div>'
              .'</div>';
            };
          @endphp
          <div class="store-list" data-type="opening">
            <div style="margin:4px 0 8px">
              <div style="font-weight:600;color:#0f172a">Opening Tasks</div>
              <div style="font-size:12px;color:#6b7280">{{ ($openingCompleted ?? 0) }} of {{ ($openingTotal ?? 0) }} completed</div>
            </div>
            @foreach(($openingTaskList ?? []) as $t)
              {!! $renderTask($t) !!}
            @endforeach
          </div>
          <div class="store-list" data-type="closing" style="display:none">
            <div style="margin:4px 0 8px">
              <div style="font-weight:600;color:#0f172a">Closing Tasks</div>
              <div style="font-size:12px;color:#6b7280">{{ ($closingCompleted ?? 0) }} of {{ ($closingTotal ?? 0) }} completed</div>
            </div>
            @foreach(($closingTaskList ?? []) as $t)
              {!! $renderTask($t) !!}
            @endforeach
          </div>
        </div>
      </div>

      </div>
    </div>

    @include('owner.sections.sales')

    <div id="apepo" class="owner-section" data-section="apepo" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </button>
        <h3 class="section-title" style="margin:0">Recent APEPO Reports</h3>
      </div>
      <form id="apepo-filter-form" method="GET" action="{{ route('owner.home') }}" style="margin:8px 0 12px;display:grid;gap:8px;grid-template-columns:1.5fr 1fr 1fr auto">
        <div>
          <input id="mgr-input" list="apepo-managers" placeholder="Type manager name, then Add" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px;width:100%" />
          <div id="mgr-chips" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:6px">
            @php
              $mgrParam = request()->query('manager');
              $mgrVals = is_array($mgrParam) ? $mgrParam : (strlen((string)$mgrParam) ? [(string)$mgrParam] : []);
            @endphp
            @foreach($mgrVals as $val)
              <span class="mgr-chip" data-value="{{ $val }}" style="display:inline-flex;align-items:center;gap:6px;background:#eef2ff;border:1px solid #dbe2ff;color:#1b1b18;padding:4px 8px;border-radius:999px">
                <span>{{ $val }}</span>
                <button type="button" class="chip-x" aria-label="Remove" style="background:transparent;border:none;color:#555;cursor:pointer">×</button>
              </span>
            @endforeach
          </div>
          <div id="mgr-hidden" aria-hidden="true" style="display:none">
            @foreach($mgrVals as $val)
              <input type="hidden" name="manager[]" value="{{ $val }}" />
            @endforeach
          </div>
        </div>
        <input name="from" type="date" value="{{ request('from') }}" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <input name="to" type="date" value="{{ request('to') }}" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px" />
        <div style="display:flex;gap:8px;align-items:center">
          <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Filter</button>
          <a href="{{ route('owner.home') }}" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18;text-decoration:none">Clear</a>
        </div>
      </form>
      <datalist id="apepo-managers">
        @foreach(($apepoManagers ?? []) as $m)
          <option value="{{ $m }}"></option>
        @endforeach
      </datalist>
      <div style="display:grid;gap:10px">
        @forelse($apepo as $p)
          <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Section</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Details</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">Audit</td>
                  <td style="padding:8px">{{ $p->audit }}</td>
                  <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($p->created_at)->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td style="padding:8px">People</td>
                  <td style="padding:8px">{{ $p->people }}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Equipment</td>
                  <td style="padding:8px">{{ $p->equipment }}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Product</td>
                  <td style="padding:8px">{{ $p->product }}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                <tr>
                  <td style="padding:8px">Others</td>
                  <td style="padding:8px">{{ $p->others }}</td>
                  <td style="padding:8px;color:#706f6c"></td>
                </tr>
                @if(!empty($p->notes))
                <tr>
                  <td style="padding:8px">Notes</td>
                  <td style="padding:8px" colspan="2">{{ $p->notes }}</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        @empty
        @endforelse
      </div>
      <div style="margin-top:8px">
        {!! $apepo->appends(request()->query())->links() !!}
      </div>
    </div>

    <div id="requests" class="owner-section" data-section="requests" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </button>
        <div>
          <h3 class="section-title" style="margin:0;color:#0f172a">Shop Requests</h3>
          <div style="font-size:12px;color:#6b7280">Manager-submitted requests</div>
        </div>
      </div>

      @php
        $totalReq = $requests->count();
        $highCount = $requests->where('priority','high')->count();
      @endphp
      <div style="display:grid;gap:12px;grid-template-columns:repeat(2,minmax(0,1fr));margin:10px 0 16px">
        <div style="background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:14px">
          <div style="display:flex;align-items:center;justify-content:space-between">
            <div>
              <div style="font-size:12px;color:#64748b">Total Requests</div>
              <div style="font-size:28px;font-weight:800;color:#0f172a">{{ $totalReq }}</div>
            </div>
            <div style="width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#ecfeff;border:1px solid #c7f7fb">📄</div>
          </div>
        </div>
        <div style="background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:14px">
          <div style="display:flex;align-items:center;justify-content:space-between">
            <div>
              <div style="font-size:12px;color:#64748b">High Priority</div>
              <div style="font-size:28px;font-weight:800;color:#b91c1c">{{ $highCount }}</div>
            </div>
            <div style="width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#fff1f2;border:1px solid #fecdd3">📄</div>
          </div>
        </div>
      </div>

      <div style="display:grid;gap:12px">
        @forelse($requests as $q)
          @php
            $badgeText = strtoupper($q->priority);
            $badgeBg = $q->priority==='high' ? '#ef4444' : ($q->priority==='medium' ? '#f59e0b' : '#06b6d4');
            $cardBorder = $q->priority==='high' ? '#fecaca' : ($q->priority==='medium' ? '#fde68a' : '#bae6fd');
            $cardBg = $q->priority==='high' ? '#fff7f7' : ($q->priority==='medium' ? '#fffbeb' : '#f0f9ff');
          @endphp
          <div style="background:{{ $cardBg }};border:1px solid {{ $cardBorder }};border-radius:12px;padding:14px;position:relative">
            <div style="position:absolute;right:12px;top:12px"><span style="display:inline-block;padding:4px 10px;border-radius:999px;color:#fff;background:{{ $badgeBg }};font-size:12px;font-weight:700">{{ $badgeText }}</span></div>
            <div style="font-weight:700;color:#0f172a;margin-right:80px">{{ $q->item }}</div>
            <div style="font-size:12px;color:#6b7280;margin:2px 0 10px">By {{ $q->manager_username }} • {{ \Carbon\Carbon::parse($q->created_at)->format('M d, Y • g:i A') }}</div>

            <div style="display:grid;gap:10px;grid-template-columns:repeat(2,minmax(0,1fr))">
              <div style="border:1px solid #e5e7eb;background:#fff;border-radius:10px;padding:8px 10px">
                <div style="font-size:11px;color:#9ca3af;margin-bottom:4px">Quantity</div>
                <div style="font-weight:600">{{ $q->quantity }}</div>
              </div>
              <div style="border:1px solid #e5e7eb;background:#fff;border-radius:10px;padding:8px 10px">
                <div style="font-size:11px;color:#9ca3af;margin-bottom:4px">Priority</div>
                <div style="font-weight:600">{{ ucfirst($q->priority) }}</div>
              </div>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:12px;flex-wrap:wrap">
              <div>
                <span style="display:inline-block;padding:4px 10px;border-radius:999px;border:1px solid #e5e7eb;background:#fff;font-size:12px;color:#111827">Status: <strong>{{ ucfirst($q->status) }}</strong></span>
              </div>
              <div>
                @if($q->status === 'pending')
                  <form class="owner-req-form" data-result="approved" method="POST" action="{{ route('owner.request.approve', ['id' => $q->id]) }}" style="display:inline">@csrf<button style="padding:8px 12px;background:#16a34a;color:#fff;border-radius:8px">Approve</button></form>
                  <form class="owner-req-form" data-result="rejected" method="POST" action="{{ route('owner.request.deny', ['id' => $q->id]) }}" style="display:inline;margin-left:6px">@csrf<button style="padding:8px 12px;background:#b91c1c;color:#fff;border-radius:8px">Deny</button></form>
                @else
                  <span style="color:#706f6c">No actions</span>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div style="color:#706f6c">No requests yet.</div>
        @endforelse
      </div>
    </div>

    <div id="inventory" class="owner-section" data-section="inventory" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </button>
        <div>
          <h3 class="section-title" style="margin:0;color:#0f172a">Inventory</h3>
          <div style="font-size:12px;color:#6b7280">Current stock levels</div>
        </div>
      </div>

      <div style="display:grid;gap:10px;grid-template-columns:repeat(2,minmax(0,1fr));margin:8px 0 12px">
        <div style="display:flex;align-items:center;gap:10px;background:#fff6f6;border:1px solid #f7c6c6;color:#991b1b;border-radius:10px;padding:10px">
          <div style="font-size:18px">⚠️</div>
          <div>
            <div style="font-weight:600">{{ (int)($invCriticalCount ?? 0) }} Critical Items</div>
            <div style="font-size:12px;color:#b42318">Immediate restocking needed</div>
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;background:#fff7ed;border:1px solid #fde7c7;color:#a04900;border-radius:10px;padding:10px">
          <div style="font-size:18px">⚠️</div>
          <div>
            <div style="font-weight:600">{{ (int)($invLowCount ?? 0) }} Low Stock Items</div>
            <div style="font-size:12px;color:#9a6700">Plan to restock soon</div>
          </div>
        </div>
      </div>

      <div id="inventory-filters" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:10px">
        <button class="pill inv-pill is-active" data-filter="all" style="padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:#111827;color:#fff">All Products</button>
        <button class="pill inv-pill" data-filter="kitchen" style="padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:#fff">Kitchen Section</button>
        <button class="pill inv-pill" data-filter="coffee" style="padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:#fff">Coffee Bar Section</button>
      </div>

      <form id="inv-bulk-form" method="POST" action="{{ route('owner.inventory.bulkDelete') }}" style="margin:0">
        @csrf
        <div style="border:1px solid #e3e3e0;border-radius:12px;overflow:hidden">
          <table id="inv-table" style="width:100%;border-collapse:collapse">
            <thead>
              <tr style="background:#f8fafc">
                @if(session('role') === 'owner')
                  <th style="padding:8px;border-bottom:1px solid #f0f0ef;width:1%"><input id="inv-check-all" type="checkbox" /></th>
                @endif
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Product Name</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Unit</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Sealed</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Loose</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Delivered</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date Delivered</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Status</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Last Updated</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Total Delivered</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Owner Date Delivered</th>
              </tr>
            </thead>
            <tbody>
              @forelse(($inventory ?? []) as $it)
                @php
                  $cat = strtolower((string)($it->category ?? ''));
                  $rowBg = $it->status === 'Critical' ? '#fff1f2' : ($it->status === 'Low Stock' ? '#fff7ed' : '#fff');
                  $badgeBg = $it->status === 'Critical' ? '#dc2626' : ($it->status === 'Low Stock' ? '#f59e0b' : '#16a34a');
                @endphp
                <tr class="inv-row" data-cat="{{ $cat }}" style="background:<?php echo e($rowBg); ?>">
                  @if(session('role') === 'owner')
                    <td style="padding:8px;border-bottom:1px solid #f6f6f5"><input class="inv-check" type="checkbox" name="ids[]" value="{{ $it->id }}" /></td>
                  @endif
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $it->name }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $it->unit }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ (int)($it->sealed ?? 0) }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ (int)($it->loose ?? 0) }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><input type="number" placeholder="Qty" style="width:80px;padding:4px 6px;border:1px solid #e5e7eb;border-radius:6px" /></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><input type="date" style="padding:4px 6px;border:1px solid #e5e7eb;border-radius:6px" /></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><span style="display:inline-block;padding:3px 8px;border-radius:999px;color:#fff;background:<?php echo e($badgeBg); ?>;font-size:12px">{{ $it->status }}</span></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5;color:#6b7280">{{ \Carbon\Carbon::parse($it->updated_at ?? now())->format('M d, Y') }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ (int)($it->delivered_total ?? 0) ?: 'Qty' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><input type="date" style="padding:4px 6px;border:1px solid #e5e7eb;border-radius:6px" /></td>
                </tr>
              @empty
                <tr><td colspan="11" style="padding:10px;color:#706f6c">No inventory items yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if(session('role') === 'owner')
          <div style="position:sticky;bottom:0;background:#fff;border-top:1px solid #e3e3e0;padding:10px;border-bottom-left-radius:12px;border-bottom-right-radius:12px;display:flex;justify-content:space-between;gap:8px;align-items:center;flex-wrap:wrap">
            <div style="display:flex;gap:8px;align-items:center">
              <button id="inv-bulk-delete" type="submit" style="padding:10px 14px;background:#1d4ed8;color:#fff;border-radius:8px">Delete Selected</button>
            </div>
            <button type="button" style="padding:10px 14px;background:#1f2937;color:#fff;border-radius:8px">Save Delivery Information</button>
          </div>
        @endif
      </form>
    </div>

    <div id="employees" class="owner-section" data-section="employees" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 8px">Employees</h3>
      <div style="color:#706f6c">Manage staff assignments and performance. Coming soon.</div>
    </div>
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
        // Indicator sizing/position
        if(ind){
          ind.style.width = openingBtn.offsetWidth + 'px';
          ind.style.left = isOpen ? '2px' : (openingBtn.offsetWidth + 4) + 'px';
        }
        // Text colors for visibility
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
          const tr = closestRow(form);
          const statusCell = tr ? tr.querySelector('.req-status') : null;
          const actionsCell = tr ? tr.querySelector('td:last-child') : null;
          const result = (form.getAttribute('data-result') || '').toLowerCase();
          // Smoothly update status text
          if(statusCell){
            statusCell.style.transition = 'opacity 160ms ease';
            statusCell.style.opacity = '0';
            setTimeout(function(){
              statusCell.textContent = result ? (result.charAt(0).toUpperCase()+result.slice(1)) : 'Updated';
              statusCell.style.opacity = '1';
            }, 160);
          }
          // Fade out buttons, then replace with "No actions"
          if(actionsCell){
            actionsCell.style.transition = 'opacity 160ms ease';
            actionsCell.style.opacity = '0';
            setTimeout(function(){
              actionsCell.innerHTML = '<span style="color:#706f6c">No actions</span>';
              actionsCell.style.opacity = '1';
            }, 160);
          }
          // Row highlight feedback
          if(tr){
            tr.style.transition = 'background-color 320ms ease, box-shadow 320ms ease';
            tr.style.background = (result === 'approved') ? '#eaf7ee' : '#fdecea';
            tr.style.boxShadow = 'inset 0 0 0 1px ' + ((result === 'approved') ? '#a7e1b2' : '#f5b5b5');
            setTimeout(function(){ tr.style.background=''; tr.style.boxShadow=''; }, 900);
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
