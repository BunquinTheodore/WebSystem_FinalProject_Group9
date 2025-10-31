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
