    <div id="store" class="owner-section" data-section="store" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
  <button data-owner-back onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <h3 class="section-title" style="margin:0">Store Tasks</h3>
      </div>
      <!-- Enhanced Stats Grid -->
      <div style="display:grid;gap:24px;grid-template-columns:repeat(2,1fr);margin-bottom:32px;max-width:1000px">
        @php
          $openList = $openingTaskList ?? [];
          $closeList = $closingTaskList ?? [];
          $openTotal = count($openList) ?: (int)($openingTotal ?? 0);
          $closeTotal = count($closeList) ?: (int)($closingTotal ?? 0);
          $openDone = count(array_filter($openList, function($t){ return !empty($t['completed']); })) ?: (int)($openingCompleted ?? 0);
          $closeDone = count(array_filter($closeList, function($t){ return !empty($t['completed']); })) ?: (int)($closingCompleted ?? 0);
          $allDone = $openDone + $closeDone;
          $allTotal = $openTotal + $closeTotal;
          $allPending = max($allTotal - $allDone, 0);
        @endphp
        
        <!-- Opening Card -->
        <div style="background:linear-gradient(135deg,#ecfdf5 0%,#d1fae5 100%);border:2px solid #6ee7b7;border-radius:20px;padding:28px;position:relative;overflow:hidden;transition:all 0.4s cubic-bezier(0.4,0,0.2,1);cursor:pointer" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 25px 50px -12px rgba(16,185,129,0.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          <div style="position:absolute;top:-30px;right:-30px;width:150px;height:150px;background:rgba(16,185,129,0.15);border-radius:50%;filter:blur(50px)"></div>
          <div style="display:flex;justify-content:space-between;align-items:flex-start;position:relative">
            <div>
              <div style="color:#047857;font-size:13px;font-weight:800;margin-bottom:12px;text-transform:uppercase;letter-spacing:1.2px">☀️ Opening Tasks</div>
              <div style="font-size:48px;font-weight:900;color:#065f46;line-height:1;margin-bottom:10px">
                {{ $openingCompleted ?? 0 }}
                <span style="font-size:28px;color:#10b981;font-weight:700">/{{ $openingTotal ?? 0 }}</span>
              </div>
              <div style="margin-top:12px;font-size:14px;color:#059669;font-weight:700">
                {{ $openingTotal > 0 ? round(($openingCompleted / $openingTotal) * 100) : 0 }}% Complete
              </div>
            </div>
            <script>
              (function(){
                var bars = document.querySelectorAll('.store-progress');
                bars.forEach(function(el){
                  var pct = parseFloat(el.getAttribute('data-pct')||'0');
                  if(isFinite(pct)) el.style.width = pct + '%';
                });
              })();
            </script>
            <div style="width:64px;height:64px;background:linear-gradient(135deg,#10b981 0%,#059669 100%);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:32px;box-shadow:0 10px 20px rgba(16,185,129,0.4)">✅</div>
          </div>
          @php
            $openingPct = $openingTotal > 0 ? (($openingCompleted / $openingTotal) * 100) : 0;
          @endphp
          <div style="margin-top:16px;height:8px;background:#d1fae5;border-radius:999px;overflow:hidden;box-shadow:inset 0 2px 4px rgba(0,0,0,0.1)">
            <div class="store-progress" data-pct="{{ $openingPct }}" style="height:100%;background:linear-gradient(90deg,#10b981 0%,#059669 100%);border-radius:999px;transition:width 0.6s cubic-bezier(0.4,0,0.2,1)"></div>
          </div>
        </div>

        <!-- Closing Card -->
        <div style="background:linear-gradient(135deg,#fff7ed 0%,#ffedd5 100%);border:2px solid #fdba74;border-radius:20px;padding:28px;position:relative;overflow:hidden;transition:all 0.4s cubic-bezier(0.4,0,0.2,1);cursor:pointer" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 25px 50px -12px rgba(249,115,22,0.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          <div style="position:absolute;top:-30px;right:-30px;width:150px;height:150px;background:rgba(249,115,22,0.15);border-radius:50%;filter:blur(50px)"></div>
          <div style="display:flex;justify-content:space-between;align-items:flex-start;position:relative">
            <div>
              <div style="color:#c2410c;font-size:13px;font-weight:800;margin-bottom:12px;text-transform:uppercase;letter-spacing:1.2px">🌙 Closing Tasks</div>
              <div style="font-size:48px;font-weight:900;color:#7c2d12;line-height:1;margin-bottom:10px">
                {{ $closingCompleted ?? 0 }}
                <span style="font-size:28px;color:#ea580c;font-weight:700">/{{ $closingTotal ?? 0 }}</span>
              </div>
              <div style="margin-top:12px;font-size:14px;color:#ea580c;font-weight:700">
                {{ $closingTotal > 0 ? round(($closingCompleted / $closingTotal) * 100) : 0 }}% Complete
              </div>
            </div>
            <div style="width:64px;height:64px;background:linear-gradient(135deg,#f97316 0%,#ea580c 100%);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:32px;box-shadow:0 10px 20px rgba(249,115,22,0.4)">⏱️</div>
          </div>
          @php
            $closingPct = $closingTotal > 0 ? (($closingCompleted / $closingTotal) * 100) : 0;
          @endphp
          <div style="margin-top:16px;height:8px;background:#ffedd5;border-radius:999px;overflow:hidden;box-shadow:inset 0 2px 4px rgba(0,0,0,0.1)">
            <div class="store-progress" data-pct="{{ $closingPct }}" style="height:100%;background:linear-gradient(90deg,#f97316 0%,#ea580c 100%);border-radius:999px;transition:width 0.6s cubic-bezier(0.4,0,0.2,1)"></div>
          </div>
        </div>

        <!-- Total Pending Card -->
        <div style="background:linear-gradient(135deg,#f8fafc 0%,#e5e7eb 100%);border:2px solid #cbd5e1;border-radius:20px;padding:28px;position:relative;overflow:hidden;transition:all 0.4s cubic-bezier(0.4,0,0.2,1);cursor:pointer" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 25px 50px -12px rgba(100,116,139,0.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          <div style="position:absolute;top:-30px;right:-30px;width:150px;height:150px;background:rgba(100,116,139,0.15);border-radius:50%;filter:blur(50px)"></div>
          <div style="display:flex;justify-content:space-between;align-items:flex-start;position:relative">
            <div>
              <div style="color:#334155;font-size:13px;font-weight:800;margin-bottom:12px;text-transform:uppercase;letter-spacing:1.2px">🕓 Total Pending</div>
              <div style="font-size:48px;font-weight:900;color:#0f172a;line-height:1;margin-bottom:10px">
                {{ $allPending }}
                <span style="font-size:28px;color:#64748b;font-weight:700">/{{ $allTotal }}</span>
              </div>
              <div style="margin-top:12px;font-size:14px;color:#64748b;font-weight:700">Across Opening + Closing</div>
            </div>
            <div style="width:64px;height:64px;background:linear-gradient(135deg,#94a3b8 0%,#64748b 100%);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:32px;box-shadow:0 10px 20px rgba(100,116,139,0.35)">⏳</div>
          </div>
        </div>

        <!-- Total Completed Card -->
        <div style="background:linear-gradient(135deg,#ecfdf5 0%,#d1fae5 100%);border:2px solid #86efac;border-radius:20px;padding:28px;position:relative;overflow:hidden;transition:all 0.4s cubic-bezier(0.4,0,0.2,1);cursor:pointer" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 25px 50px -12px rgba(16,185,129,0.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          <div style="position:absolute;top:-30px;right:-30px;width:150px;height:150px;background:rgba(16,185,129,0.15);border-radius:50%;filter:blur(50px)"></div>
          <div style="display:flex;justify-content:space-between;align-items:flex-start;position:relative">
            <div>
              <div style="color:#047857;font-size:13px;font-weight:800;margin-bottom:12px;text-transform:uppercase;letter-spacing:1.2px">✅ Total Completed</div>
              <div style="font-size:48px;font-weight:900;color:#065f46;line-height:1;margin-bottom:10px">
                {{ $allDone }}
                <span style="font-size:28px;color:#10b981;font-weight:700">/{{ $allTotal }}</span>
              </div>
              <div style="margin-top:12px;font-size:14px;color:#059669;font-weight:700">Across Opening + Closing</div>
            </div>
            <div style="width:64px;height:64px;background:linear-gradient(135deg,#10b981 0%,#059669 100%);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:32px;box-shadow:0 10px 20px rgba(16,185,129,0.4)">🏁</div>
          </div>
        </div>
      </div>

      <!-- Modern Tab Toggle -->
      <div id="store-toggle" style="position:relative;display:inline-flex;background:#f9fafb;border:3px solid #e5e7eb;border-radius:20px;padding:6px;margin-bottom:28px;box-shadow:inset 0 2px 6px rgba(0,0,0,0.08)">
        <div id="store-toggle-indicator" style="position:absolute;top:6px;left:6px;height:calc(100% - 12px);width:calc(50% - 6px);border-radius:16px;background:linear-gradient(135deg,#0891b2 0%,#06b6d4 100%);transition:all 0.4s cubic-bezier(0.4,0,0.2,1);box-shadow:0 6px 10px -1px rgba(8,145,178,0.3)"></div>
        <button class="tab-btn is-active" data-tab="opening" style="position:relative;padding:14px 36px;border:none;background:transparent;color:#fff;z-index:1;font-weight:800;font-size:16px;transition:all 0.3s ease;cursor:pointer;border-radius:16px">☀️ Opening</button>
        <button class="tab-btn" data-tab="closing" style="position:relative;padding:14px 36px;border:none;background:transparent;color:#6b7280;z-index:1;font-weight:800;font-size:16px;transition:all 0.3s ease;cursor:pointer;border-radius:16px">🌙 Closing</button>
      </div>
      
      <style>
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(10px); }
          to { opacity: 1; transform: translateY(0); }
        }
      </style>
      <!-- Task List Container -->
      <style>
        .store-task{display:flex;justify-content:space-between;align-items:center;border:2px solid #e5e7eb;background:#ffffff;border-radius:14px;padding:18px 20px;transition:all .3s cubic-bezier(.4,0,.2,1);cursor:pointer}
        .store-task.is-done{border-color:#86efac;background:linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%)}
        .loc-badge{padding:6px 14px;border-radius:12px;font-size:13px;font-weight:700;border:2px solid transparent}
        .loc-kitchen{background:#eff6ff;border-color:#93c5fd;color:#1e40af}
        .loc-coffee{background:#fefce8;border-color:#fcd34d;color:#92400e}
        .loc-default{background:#f3f4f6;border-color:#d1d5db;color:#4b5563}
        .task-badge-done{display:flex;align-items:center;gap:6px;background:linear-gradient(135deg,#10b981 0%,#059669 100%);color:#fff;padding:6px 14px;border-radius:12px;font-size:12px;font-weight:700;box-shadow:0 2px 4px rgba(16,185,129,0.3)}
        .task-badge-pending{background:#fef3c7;color:#92400e;padding:6px 14px;border-radius:12px;font-size:12px;font-weight:700;border:2px solid #fcd34d}
      </style>
      <div id="store-task-list" style="background:#ffffff;border:3px solid #e5e7eb;border-radius:20px;padding:32px;display:grid;gap:14px;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1),0 2px 4px -1px rgba(0,0,0,0.06);max-width:1000px">
          <div class="store-list" data-type="opening" style="animation:fadeIn 0.4s ease-out">
            <div style="margin:0 0 24px;padding-bottom:20px;border-bottom:4px solid #f3f4f6">
              <div style="display:flex;justify-content:space-between;align-items:center">
                <div>
                  <div style="font-weight:900;color:#111827;font-size:24px;margin-bottom:6px;letter-spacing:-0.5px">☀️ Opening Tasks</div>
                  <div style="font-size:15px;color:#6b7280;font-weight:700">{{ ($openingCompleted ?? 0) }} of {{ ($openingTotal ?? 0) }} tasks completed</div>
                </div>
              </div>
            </div>
            @foreach(($openingTaskList ?? []) as $t)
              @php
                $isCompleted = !empty($t['completed']);
                $loc = $t['location'] ?: 'Unassigned';
                $time = !empty($t['time']) ? \Carbon\Carbon::parse($t['time'])->format('g:i A') : '';
                $emp = !empty($t['employee']) ? ('By '.$t['employee']) : '';
                $sub = trim(($emp.' '.($time?('at '.$time):'')));
                $bgColor = $isCompleted ? 'linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%)' : '#ffffff';
                $borderColor = $isCompleted ? '#86efac' : '#e5e7eb';
                $locLower = strtolower($loc);
                $locMap = ['kitchen'=>['#eff6ff','#93c5fd','#1e40af'], 'coffee'=>['#fefce8','#fcd34d','#92400e']];
                $locColor = $locMap[$locLower] ?? ['#f3f4f6','#d1d5db','#4b5563'];
              @endphp
              <div class="store-task {{ $isCompleted ? 'is-done' : '' }}" data-location="{{ $locLower }}" onmouseover="this.style.transform='translateX(8px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                <div style="flex:1;min-width:0">
                  <div style="font-weight:800;color:#111827;font-size:16px;margin-bottom:6px;line-height:1.3">{{ e($t['title']) }}</div>
                  <div style="font-size:13px;color:#6b7280;font-weight:500">{!! $sub ?: '<span style="color:#d1d5db">No details</span>' !!}</div>
                </div>
                <div style="display:flex;gap:12px;align-items:center;flex-shrink:0;margin-left:16px">
                  <div class="loc-badge {{ 'loc-'.($locLower==='kitchen'?'kitchen':($locLower==='coffee'?'coffee':'default')) }}">{{ e($loc) }}</div>
                  @if($isCompleted)
                    <div class="task-badge-done"><span>✓</span><span>Done</span></div>
                  @else
                    <div class="task-badge-pending">⏳ Pending</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
          
          <div class="store-list" data-type="closing" style="display:none;animation:fadeIn 0.4s ease-out">
            <div style="margin:0 0 24px;padding-bottom:20px;border-bottom:4px solid #f3f4f6">
              <div style="display:flex;justify-content:space-between;align-items:center">
                <div>
                  <div style="font-weight:900;color:#111827;font-size:24px;margin-bottom:6px;letter-spacing:-0.5px">🌙 Closing Tasks</div>
                  <div style="font-size:15px;color:#6b7280;font-weight:700">{{ ($closingCompleted ?? 0) }} of {{ ($closingTotal ?? 0) }} tasks completed</div>
                </div>
              </div>
            </div>
            @foreach(($closingTaskList ?? []) as $t)
              @php
                $isCompleted = !empty($t['completed']);
                $loc = $t['location'] ?: 'Unassigned';
                $time = !empty($t['time']) ? \Carbon\Carbon::parse($t['time'])->format('g:i A') : '';
                $emp = !empty($t['employee']) ? ('By '.$t['employee']) : '';
                $sub = trim(($emp.' '.($time?('at '.$time):'')));
                $bgColor = $isCompleted ? 'linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%)' : '#ffffff';
                $borderColor = $isCompleted ? '#86efac' : '#e5e7eb';
                $locLower = strtolower($loc);
                $locMap = ['kitchen'=>['#eff6ff','#93c5fd','#1e40af'], 'coffee'=>['#fefce8','#fcd34d','#92400e']];
                $locColor = $locMap[$locLower] ?? ['#f3f4f6','#d1d5db','#4b5563'];
              @endphp
              <div class="store-task {{ $isCompleted ? 'is-done' : '' }}" data-location="{{ $locLower }}" onmouseover="this.style.transform='translateX(8px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                <div style="flex:1;min-width:0">
                  <div style="font-weight:800;color:#111827;font-size:16px;margin-bottom:6px;line-height:1.3">{{ e($t['title']) }}</div>
                  <div style="font-size:13px;color:#6b7280;font-weight:500">{!! $sub ?: '<span style="color:#d1d5db">No details</span>' !!}</div>
                </div>
                <div style="display:flex;gap:12px;align-items:center;flex-shrink:0;margin-left:16px">
                  <div class="loc-badge {{ 'loc-'.($locLower==='kitchen'?'kitchen':($locLower==='coffee'?'coffee':'default')) }}">{{ e($loc) }}</div>
                  @if($isCompleted)
                    <div class="task-badge-done"><span>✓</span><span>Done</span></div>
                  @else
                    <div class="task-badge-pending">⏳ Pending</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
