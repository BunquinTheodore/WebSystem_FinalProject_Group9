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
        <div id="store-toggle-indicator" style="position:absolute;top:2px;left:2px;height:calc(100% - 4px);width:0;border-radius:999px;background:#111827;transition:all .2s ease"></div>
        <button class="tab-btn is-active" data-tab="opening" style="position:relative;padding:8px 14px;border:none;background:transparent;color:#111827;z-index:1">Opening Tasks</button>
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

        <div>
          <h4 style="margin:0 0 8px">Locations</h4>
          <div style="border:1px solid #e3e3e0;border-radius:8px;overflow:hidden">
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Name</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">QR Payload</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse(($locations ?? []) as $loc)
                <tr>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $loc->name }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5"><code style="font-size:12px">{{ $loc->qrcode_payload }}</code></td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">
                    <form class="owner-ajax" method="POST" action="{{ route('owner.location.regen', ['id'=>$loc->id]) }}" style="display:inline">@csrf<button style="padding:6px 10px;border:1px solid #e3e3e0;border-radius:6px;background:#fff">Regenerate</button></form>
                    <form class="owner-ajax" method="POST" action="{{ route('owner.location.delete', ['id'=>$loc->id]) }}" style="display:inline;margin-left:6px">@csrf<button style="padding:6px 10px;background:#b91c1c;color:#fff;border-radius:6px">Delete</button></form>
                  </td>
                </tr>
                @empty
                <tr><td colspan="3" style="padding:8px;color:#706f6c">No locations yet.</td></tr>
                @endforelse
                <tr>
                  <td colspan="3" style="padding:8px">
                    <form id="owner-add-location" class="owner-ajax" method="POST" action="{{ route('owner.location.create') }}" style="display:flex;gap:8px;align-items:center">
                      @csrf
                      <input name="name" required placeholder="Add new location (e.g., Kitchen, Coffee Bar)" style="flex:1;padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
                      <button style="padding:8px 12px;background:#0891b2;color:#fff;border-radius:6px">Add</button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div>
          <h4 style="margin:0 0 8px">Task Location Mapping</h4>
          <div style="border:1px solid #e3e3e0;border-radius:8px;overflow:auto;max-height:360px">
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Task</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Type</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Location</th>
                </tr>
              </thead>
              <tbody>
                @forelse(($ownerTasks ?? []) as $t)
                <tr>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $t->title }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ ucfirst($t->type) }}</td>
                  <td style="padding:8px;border-bottom:1px solid #f6f6f5">
                    <form class="owner-ajax task-location" method="POST" action="{{ route('owner.task.setLocation', ['id'=>$t->id]) }}" style="display:flex;gap:8px;align-items:center">
                      @csrf
                      <select name="location_id" style="padding:6px 8px;border:1px solid #e3e3e0;border-radius:6px">
                        <option value="">Unassigned</option>
                        @foreach(($locations ?? []) as $l)
                          <option value="{{ $l->id }}" @if((int)$t->location_id === (int)$l->id) selected @endif>{{ $l->name }}</option>
                        @endforeach
                      </select>
                      <button style="padding:6px 10px;border:1px solid #e3e3e0;border-radius:6px;background:#fff">Save</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr><td colspan="3" style="padding:8px;color:#706f6c">No tasks found.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div style="margin-top:8px;color:#706f6c;font-size:12px">Assign each task to the correct physical location. Employees must scan the location QR when submitting proof.</div>
        </div>
      </div>
    </div>

    <div id="sales-overview" class="owner-section" data-section="sales" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h2 class="section-title" style="margin:0 0 8px">Overview</h2>
      <div>Current Fund Balance: <strong>₱{{ number_format($fundBalance ?? 0, 2) }}</strong></div>
      <div>Total Expenses: <strong>₱{{ number_format($expensesTotal ?? 0, 2) }}</strong></div>
      <div>Available Balance: <strong>₱{{ number_format($availableBalance ?? 0, 2) }}</strong></div>
    </div>

  <div style="display:grid;gap:16px;grid-template-columns:2fr 1fr">
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

      <div id="sales" class="owner-section" data-section="sales" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
        <h3 class="section-title" style="margin:0 0 8px">Recent Expenses</h3>
        <div style="display:grid;gap:10px">
          @forelse($expenses as $e)
            <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
              <table style="width:100%;border-collapse:collapse">
                <thead>
                  <tr>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Amount (₱)</th>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Description</th>
                    <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="padding:8px">₱{{ number_format(($e->amount ?? 0), 2) }}</td>
                    <td style="padding:8px">{{ $e->note }}</td>
                    <td style="padding:8px;color:#706f6c">{{ \Carbon\Carbon::parse($e->created_at)->format('M d, Y H:i') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          @empty
            <div style="color:#706f6c">No expenses yet.</div>
          @endforelse
        </div>
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
          <div style="color:#706f6c">No APEPO reports yet.</div>
        @endforelse
      </div>
      <div style="margin-top:8px">
        {!! $apepo->appends(request()->query())->links() !!}
      </div>
    </div>

    <div id="requests" class="owner-section" data-section="requests" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 8px">Requests</h3>
      <table style="width:100%;border-collapse:collapse">
        <thead>
          <tr>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Item</th>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Qty</th>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Priority</th>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Status</th>
            <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requests as $q)
            <tr>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">{{ $q->item }}</td>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">{{ $q->quantity }}</td>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">{{ ucfirst($q->priority) }}</td>
              <td class="req-status" style="border-bottom:1px solid #f0f0ef;padding:8px">{{ ucfirst($q->status) }}</td>
              <td style="border-bottom:1px solid #f0f0ef;padding:8px">
                @if($q->status === 'pending')
                  <form class="owner-req-form" data-result="approved" method="POST" action="{{ route('owner.request.approve', ['id' => $q->id]) }}" style="display:inline">@csrf<button style="padding:6px 10px;background:#16a34a;color:#fff;border-radius:6px" data-confirm="Approve this request?">Approve</button></form>
                  <form class="owner-req-form" data-result="denied" method="POST" action="{{ route('owner.request.deny', ['id' => $q->id]) }}" style="display:inline;margin-left:6px">@csrf<button style="padding:6px 10px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Deny this request?">Deny</button></form>
                @else
                  <span style="color:#706f6c">No actions</span>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="5" style="color:#706f6c;padding:8px">No requests yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div id="inventory" class="owner-section" data-section="inventory" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 8px">Inventory</h3>
      <div style="display:grid;gap:10px">
        @forelse(($inventory ?? []) as $it)
          <div class="card" style="border-radius:8px;border:1px solid #e3e3e0;overflow:hidden">
            <table style="width:100%;border-collapse:collapse">
              <thead>
                <tr>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Item</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Category</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Qty</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Min</th>
                  <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Unit</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding:8px">{{ $it->name }}</td>
                  <td style="padding:8px">{{ $it->category }}</td>
                  <td style="padding:8px"><span @if($it->quantity <= $it->min_threshold) style="color:#b91c1c;font-weight:600" @endif>{{ $it->quantity }}</span></td>
                  <td style="padding:8px">{{ $it->min_threshold }}</td>
                  <td style="padding:8px">{{ $it->unit }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        @empty
          <div style="color:#706f6c">No inventory items yet.</div>
        @endforelse
      </div>
    </div>

    <div id="employees" class="owner-section" data-section="employees" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <h3 class="section-title" style="margin:0 0 8px">Employees</h3>
      <div style="color:#706f6c">Manage staff assignments and performance. Coming soon.</div>
    </div>
  </div>
  <script>
    (function(){
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
