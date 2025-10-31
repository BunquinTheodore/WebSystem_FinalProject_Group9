@extends('layouts.app')

@section('title', 'Owner')

@section('content')
  <div style="max-width:1000px;margin:0 auto;display:grid;gap:16px">

    <div id="owner-welcome" style="text-align:center;padding:20px 12px">
      <h1 style="margin:0 0 6px;font-size:28px;color:#0f172a">Welcome back, owner</h1>
      <div style="color:#64748b">Choose a section to view details</div>
    </div>

    <div id="owner-nav" class="owner-nav" style="display:grid;gap:16px;grid-template-columns:repeat(3,minmax(0,1fr));padding:0 8px">
      <a href="#store" data-target="store" style="display:flex;flex-direction:column;align-items:center;gap:10px;background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:24px 16px;text-decoration:none;color:#0f172a;box-shadow:0 1px 0 rgba(0,0,0,0.02)">
        <div style="width:56px;height:56px;border-radius:999px;background:#e0f2fe;display:flex;align-items:center;justify-content:center">
          <span style="font-size:28px">🏬</span>
        </div>
        <div style="text-align:center">
          <div style="font-weight:600">Store</div>
          <div style="font-size:12px;color:#64748b">Opening & Closing Tasks</div>
        </div>
      </a>
      <a href="#sales" data-target="sales" style="display:flex;flex-direction:column;align-items:center;gap:10px;background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:24px 16px;text-decoration:none;color:#0f172a;box-shadow:0 1px 0 rgba(0,0,0,0.02)">
        <div style="width:56px;height:56px;border-radius:999px;background:#dcfce7;display:flex;align-items:center;justify-content:center">
          <span style="font-size:28px">💵</span>
        </div>
        <div style="text-align:center">
          <div style="font-weight:600">Sales</div>
          <div style="font-size:12px;color:#64748b">Reports & Performance</div>
        </div>
      </a>
      <a href="#inventory" data-target="inventory" style="display:flex;flex-direction:column;align-items:center;gap:10px;background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:24px 16px;text-decoration:none;color:#0f172a;box-shadow:0 1px 0 rgba(0,0,0,0.02)">
        <div style="width:56px;height:56px;border-radius:999px;background:#f1f5ff;display:flex;align-items:center;justify-content:center">
          <span style="font-size:28px">📦</span>
        </div>
        <div style="text-align:center">
          <div style="font-weight:600">Inventory</div>
          <div style="font-size:12px;color:#64748b">Stock Levels</div>
        </div>
      </a>
      <a href="#requests" data-target="requests" style="display:flex;flex-direction:column;align-items:center;gap:10px;background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:24px 16px;text-decoration:none;color:#0f172a;box-shadow:0 1px 0 rgba(0,0,0,0.02)">
        <div style="width:56px;height:56px;border-radius:999px;background:#fff7ed;display:flex;align-items:center;justify-content:center">
          <span style="font-size:28px">📝</span>
        </div>
        <div style="text-align:center">
          <div style="font-weight:600">Requests</div>
          <div style="font-size:12px;color:#64748b">Shop Needs</div>
        </div>
      </a>
      <a href="#apepo" data-target="apepo" style="display:flex;flex-direction:column;align-items:center;gap:10px;background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:24px 16px;text-decoration:none;color:#0f172a;box-shadow:0 1px 0 rgba(0,0,0,0.02)">
        <div style="width:56px;height:56px;border-radius:999px;background:#fef3c7;display:flex;align-items:center;justify-content:center">
          <span style="font-size:28px">📊</span>
        </div>
        <div style="text-align:center">
          <div style="font-weight:600">Audit / Payroll</div>
          <div style="font-size:12px;color:#64748b">Employee Payments</div>
        </div>
      </a>
      <a href="#employees" data-target="employees" style="display:flex;flex-direction:column;align-items:center;gap:10px;background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:24px 16px;text-decoration:none;color:#0f172a;box-shadow:0 1px 0 rgba(0,0,0,0.02)">
        <div style="width:56px;height:56px;border-radius:999px;background:#eef2ff;display:flex;align-items:center;justify-content:center">
          <span style="font-size:28px">👥</span>
        </div>
        <div style="text-align:center">
          <div style="font-weight:600">Employees</div>
          <div style="font-size:12px;color:#64748b">Staff Management</div>
        </div>
      </a>
    </div>


    <div id="store" class="owner-section" data-section="store" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 12px">Store Tasks</h3>
      <div style="display:grid;gap:12px;grid-template-columns:repeat(4,minmax(0,1fr));margin-bottom:12px">
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="color:#166534;font-size:12px;margin-bottom:4px">Opening Completed</div>
            <div style="font-size:22px;font-weight:700;color:#065f46">{{ $openingCompleted ?? 0 }}/{{ $openingTotal ?? 0 }}</div>
          </div>
          <div style="font-size:22px;color:#16a34a">✅</div>
        </div>
        <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="color:#9a3412;font-size:12px;margin-bottom:4px">Closing Completed</div>
            <div style="font-size:22px;font-weight:700;color:#7c2d12">{{ $closingCompleted ?? 0 }}/{{ $closingTotal ?? 0 }}</div>
          </div>
          <div style="font-size:22px;color:#ea580c">⏱️</div>
        </div>
        <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="color:#1e40af;font-size:12px;margin-bottom:4px">Kitchen Tasks</div>
            <div style="font-size:22px;font-weight:700;color:#1d4ed8">{{ $kitchenTasks ?? 0 }}</div>
          </div>
          <div style="font-size:22px;color:#2563eb">👩‍🍳</div>
        </div>
        <div style="background:#fff7ed;border:1px solid #fde68a;border-radius:10px;padding:14px;display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="color:#92400e;font-size:12px;margin-bottom:4px">Coffee Bar Tasks</div>
            <div style="font-size:22px;font-weight:700;color:#b45309">{{ $coffeeBarTasks ?? 0 }}</div>
          </div>
          <div style="font-size:22px;color:#b45309">☕</div>
        </div>
        <div id="emp-add-actions" style="display:none;margin-top:8px;text-align:right">
          <button form="emp-add-form" class="btn btn-primary" type="submit">Save</button>
        </div>
      </div>

      <div id="store-stations" style="display:flex;gap:8px;flex-wrap:wrap;margin:8px 0 10px">
          <button class="pill station-pill is-active" data-station="all" style="padding:6px 12px;border-radius:999px;border:1px solid #dbe2ff;background:#111827;color:#fff">All Stations</button>
          <button class="pill station-pill" data-station="kitchen" style="padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:#fff;display:inline-flex;align-items:center;gap:6px">
            <span style="font-size:14px">👩‍🍳</span>
            <span>Kitchen</span>
          </button>
          <button class="pill station-pill" data-station="coffee" style="padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:#fff;display:inline-flex;align-items:center;gap:6px">
            <span style="font-size:14px">☕</span>
            <span>Coffee Bar</span>
          </button>
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

    <div id="sales-overview" class="owner-section" data-section="sales" style="display:none;background:#f8fffe;border:1px solid #daf1ee;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
        <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#e7fff9;border:1px solid #c8ede7">💰</div>
        <div>
          <h2 class="section-title" style="margin:0;color:#0f172a">Sales & Reports</h2>
          <div style="font-size:12px;color:#6b7280">Financial and operational reports</div>
        </div>
      </div>

      <div style="display:grid;gap:12px;grid-template-columns:repeat(2,minmax(0,1fr));margin-top:8px">
        <div style="background:#effafc;border:1px solid #ccebf4;border-radius:12px;padding:14px">
          <div style="font-weight:600;color:#0f172a">Opening Shift</div>
          <div style="font-size:12px;color:#64748b;margin-bottom:8px">Morning financial summary</div>
          <div style="display:grid;gap:8px">
            <div style="display:flex;justify-content:space-between;border:1px solid #e9f4f8;background:#fff;border-radius:8px;padding:8px 10px"><span>Cash</span><strong>₱{{ number_format(($openingSales->cash ?? 0), 0) }}</strong></div>
            <div style="display:flex;justify-content:space-between;border:1px solid #e9f4f8;background:#fff;border-radius:8px;padding:8px 10px"><span>Digital Wallet</span><strong>₱{{ number_format(($openingSales->wallet ?? 0), 0) }}</strong></div>
            <div style="display:flex;justify-content:space-between;border:1px solid #e9f4f8;background:#fff;border-radius:8px;padding:8px 10px"><span>Bank Amount</span><strong>₱{{ number_format(($openingSales->bank ?? 0), 0) }}</strong></div>
            <div style="border-top:2px solid #c9e8f3;margin:2px 0"></div>
            <div style="display:flex;justify-content:space-between;color:#0f172a"><span>Total</span><strong>₱{{ number_format(($openingSales->total ?? 0), 0) }}</strong></div>
          </div>
        </div>
        <div style="background:#fff8ef;border:1px solid #fde9cc;border-radius:12px;padding:14px">
          <div style="font-weight:600;color:#7a3f00">Closing Shift</div>
          <div style="font-size:12px;color:#9a6700;margin-bottom:8px">Evening financial summary</div>
          <div style="display:grid;gap:8px">
            <div style="display:flex;justify-content:space-between;border:1px solid #feefd8;background:#fff;border-radius:8px;padding:8px 10px"><span>Cash</span><strong>₱{{ number_format(($closingSales->cash ?? 0), 0) }}</strong></div>
            <div style="display:flex;justify-content:space-between;border:1px solid #feefd8;background:#fff;border-radius:8px;padding:8px 10px"><span>Digital Wallet</span><strong>₱{{ number_format(($closingSales->wallet ?? 0), 0) }}</strong></div>
            <div style="display:flex;justify-content:space-between;border:1px solid #feefd8;background:#fff;border-radius:8px;padding:8px 10px"><span>Bank Amount</span><strong>₱{{ number_format(($closingSales->bank ?? 0), 0) }}</strong></div>
            <div style="border-top:2px solid #f6d5a7;margin:2px 0"></div>
            <div style="display:flex;justify-content:space-between;color:#7a3f00"><span>Total</span><strong>₱{{ number_format(($closingSales->total ?? 0), 0) }}</strong></div>
          </div>
        </div>
      </div>

      <div style="margin-top:12px;background:#f0fff8;border:1px solid #c8f1dd;border-radius:12px;padding:16px;display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:14px;color:#047857">Total Daily Earnings</div>
        <div style="font-size:24px;font-weight:700;color:#047857">₱{{ number_format(($dailyEarnings ?? 0), 0) }}</div>
      </div>
    </div>

    <!-- Recent Reports below header -->
    <div id="reports" class="owner-section" data-section="sales" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 8px">Recent Reports</h3>
      <div style="display:grid;gap:10px">
        @forelse($reports as $r)
          <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Shift</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Cash (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Wallet (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Bank (₱)</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Submitted</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">{{ strtoupper($r->shift) }}</td>
                  <td style="padding:8px">₱{{ number_format($r->cash,2) }}</td>
                  <td style="padding:8px">₱{{ number_format($r->wallet,2) }}</td>
                  <td style="padding:8px">₱{{ number_format($r->bank,2) }}</td>
                  <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y H:i') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        @empty
          <div style="color:#706f6c">No reports yet.</div>
        @endforelse
      </div>
    </div>

    <div id="apepo" class="owner-section" data-section="apepo" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 8px">Recent APEPO Reports</h3>
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
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
        <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#fff7ed;border:1px solid #fde9cc">📝</div>
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
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
        <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#eef2ff;border:1px solid #dbe2ff">📊</div>
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
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
        <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#eef2ff;border:1px solid #dbe2ff">👥</div>
        <div>
          <h3 class="section-title" style="margin:0;color:#0f172a">Employees</h3>
          <div style="font-size:12px;color:#6b7280">Staff directory and management</div>
        </div>
      </div>

      <div style="display:grid;gap:12px;grid-template-columns:repeat(3,minmax(0,1fr));margin:8px 0 16px">
        <div style="background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:14px">
          <div style="display:flex;align-items:center;justify-content:space-between">
            <div>
              <div style="font-size:12px;color:#64748b">Total Employees</div>
              <div style="font-size:26px;font-weight:800;color:#111827">{{ (int)($empTotal ?? 0) }}</div>
            </div>
            <div style="width:42px;height:42px;border-radius:10px;background:#eef2ff;border:1px solid #dbe2ff;display:flex;align-items:center;justify-content:center">👤</div>
          </div>
        </div>
        <div style="background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:14px">
          <div style="display:flex;align-items:center;justify-content:space-between">
            <div>
              <div style="font-size:12px;color:#64748b">Full-Time</div>
              <div style="font-size:26px;font-weight:800;color:#1d4ed8">{{ (int)($empFull ?? 0) }}</div>
            </div>
            <div style="width:42px;height:42px;border-radius:10px;background:#eef2ff;border:1px solid #dbe2ff;display:flex;align-items:center;justify-content:center">🏢</div>
          </div>
        </div>
        <div style="background:#ffffff;border:1px solid #e3e3e0;border-radius:12px;padding:14px">
          <div style="display:flex;align-items:center;justify-content:space-between">
            <div>
              <div style="font-size:12px;color:#64748b">Part-Time</div>
              <div style="font-size:26px;font-weight:800;color:#0ea5e9">{{ (int)($empPart ?? 0) }}</div>
            </div>
            <div style="width:42px;height:42px;border-radius:10px;background:#ecfeff;border:1px solid #a5f3fc;display:flex;align-items:center;justify-content:center">🕒</div>
          </div>
        </div>
      </div>

      <div class="card" style="padding:14px">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:8px">
          <div>
            <div style="font-weight:700;color:#0f172a">All Employees</div>
            <div style="font-size:12px;color:#6b7280">Complete staff directory</div>
          </div>
          <button id="emp-add-toggle" type="button" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:6px">+ Add Employee</button>
        </div>


        <div style="overflow:auto">
          <table style="width:100%;border-collapse:separate;border-spacing:0;min-width:980px">
            <thead>
              <tr>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Employee</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Status</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Position</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Birthday</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Email</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Contact</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Join Date</th>
                <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Inline Add Employee Row -->
              <tr id="emp-add-row" style="display:none;background:#f9fafb">
                <td style="padding:8px;border-bottom:1px solid #eef2f7">
                  <form id="emp-add-form" class="owner-ajax" method="POST" action="{{ route('owner.employee.create') }}">
                    @csrf
                    <input type="hidden" name="role" value="employee">
                    <input name="name" placeholder="Full name" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                  </form>
                </td>
                <td style="padding:8px;border-bottom:1px solid #eef2f7">
                  <select form="emp-add-form" name="employment_type" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                    <option value="fulltime">Full-time</option>
                    <option value="parttime">Part-time</option>
                  </select>
                </td>
                <td style="padding:8px;border-bottom:1px solid #eef2f7">
                  <input form="emp-add-form" name="position" placeholder="Position" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </td>
                <td style="padding:8px;border-bottom:1px solid #eef2f7">
                  <input form="emp-add-form" name="birthday" type="date" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </td>
                <td style="padding:8px;border-bottom:1px solid #eef2f7">
                  <input form="emp-add-form" name="email" type="email" placeholder="Email" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </td>
                <td style="padding:8px;border-bottom:1px solid #eef2f7">
                  <input form="emp-add-form" name="contact" placeholder="Contact" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </td>
                <td style="padding:8px;border-bottom:1px solid #eef2f7">
                  <input form="emp-add-form" name="join_date" type="date" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </td>
                <td style="padding:8px;border-bottom:1px solid #eef2f7;white-space:nowrap"></td>
              </tr>

              @foreach(($employees ?? []) as $e)
                @php
                  $statusClr = ($e->employment_type === 'parttime') ? ['#06b6d4','#ecfeff','#a5f3fc'] : ['#2563eb','#eef2ff','#bfdbfe'];
                @endphp
                <tr>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $e->name }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><span style="display:inline-block;padding:4px 8px;border-radius:999px;color:{{ $statusClr[0] }};background:{{ $statusClr[1] }};border:1px solid {{ $statusClr[2] }};font-size:12px">{{ $e->employment_type === 'parttime' ? 'Part-time' : 'Full-time' }}</span></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $e->position ?? '—' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $e->birthday ? \Carbon\Carbon::parse($e->birthday)->format('M d, Y') : '—' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $e->email ?? '—' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $e->contact ?? '—' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $e->join_date ? \Carbon\Carbon::parse($e->join_date)->format('M d, Y') : '—' }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">
                    <button type="button" class="btn" data-emp-edit="{{ $e->id }}">Edit</button>
                    <form class="owner-ajax" method="POST" action="{{ route('owner.employee.delete', ['id'=>$e->id]) }}" style="display:inline">@csrf<button class="btn" type="submit" onclick="return window.modalConfirm ? (event.preventDefault(), modalConfirm('Remove this employee?', {title:'Confirm delete'}).then(function(ok){ if(ok) event.target.closest('form').submit(); })) : confirm('Remove this employee?')">Delete</button></form>
                  </td>
                </tr>
                <tr id="emp-edit-row-{{ $e->id }}" style="display:none;background:#f9fafb">
                  <td colspan="8" style="padding:8px;border-bottom:1px solid #eef2f7">
                    <form class="owner-ajax" method="POST" action="{{ route('owner.employee.update', ['id'=>$e->id]) }}" style="display:grid;gap:8px;grid-template-columns:2fr 1fr 2fr 1fr auto">
                      @csrf
                      <input name="name" value="{{ $e->name }}" placeholder="Full name" style="padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                      <select name="role" style="padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                        <option value="employee" {{ $e->role==='employee'?'selected':'' }}>Employee</option>
                        <option value="manager" {{ $e->role==='manager'?'selected':'' }}>Manager</option>
                        <option value="owner" {{ $e->role==='owner'?'selected':'' }}>Owner</option>
                      </select>
                      <input name="email" type="email" value="{{ $e->email ?? '' }}" placeholder="Email" style="padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                      <select name="employment_type" style="padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                        <option value="fulltime" {{ $e->employment_type==='fulltime'?'selected':'' }}>Full-time</option>
                        <option value="parttime" {{ $e->employment_type==='parttime'?'selected':'' }}>Part-time</option>
                      </select>
                      <button class="btn btn-primary" type="submit">Update</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <script>
        (function(){
          var addBtn = document.getElementById('emp-add-toggle');
          var addRow = document.getElementById('emp-add-row');
          var addActions = document.getElementById('emp-add-actions');
          function toggleAdd(show){
            var s = (typeof show==='boolean') ? show : (addRow.style.display==='none' || addRow.style.display==='');
            addRow.style.display = s ? 'table-row' : 'none';
            if(addActions) addActions.style.display = s ? '' : 'none';
          }
          if(addBtn && addRow){ addBtn.addEventListener('click', function(){ toggleAdd(); }); }
          document.addEventListener('click', function(ev){
            var btn = ev.target.closest('[data-emp-edit]');
            if(!btn) return;
            var id = btn.getAttribute('data-emp-edit');
            var row = document.getElementById('emp-edit-row-'+id);
            if(row){ row.style.display = (row.style.display==='none'||row.style.display==='') ? 'table-row' : 'none'; }
          });
        })();
      </script>
    </div>
  </div>
  <script>
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
        filterByStation();
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
      var stationWrap = document.getElementById('store-stations');
      function filterByStation(){
        var active = stationWrap ? stationWrap.querySelector('.station-pill.is-active') : null;
        var key = active ? active.getAttribute('data-station') : 'all';
        var activeTab = (tabs && tabs.querySelector('.tab-btn.is-active')) ? tabs.querySelector('.tab-btn.is-active').getAttribute('data-tab') : 'opening';
        var container = document.querySelector('.store-list[data-type="'+activeTab+'"]');
        if(!container) return;
        container.querySelectorAll('.store-task').forEach(function(card){
          var loc = (card.getAttribute('data-location')||'').toLowerCase();
          var show = (key==='all') || (loc.indexOf(key) !== -1);
          card.style.display = show ? '' : 'none';
        });
      }
      if(stationWrap){
        stationWrap.addEventListener('click', function(ev){
          var pill = ev.target.closest('.station-pill');
          if(!pill) return;
          ev.preventDefault();
          stationWrap.querySelectorAll('.station-pill').forEach(function(p){ p.classList.remove('is-active'); p.style.background='#fff'; p.style.color=''; p.style.borderColor='#e5e7eb'; });
          pill.classList.add('is-active'); pill.style.background='#111827'; pill.style.color='#fff'; pill.style.borderColor='#111827';
          filterByStation();
        });
      }
      filterByStation();
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
