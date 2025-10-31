    <div id="requests" class="owner-section" data-section="requests" style="display:none;background:#f9fafb;padding:32px;border-radius:12px;max-width:1200px;margin:0 auto 40px auto">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff">📋</div>
        <div style="display:flex;flex-direction:column">
          <div style="font-weight:700;font-size:20px;color:#0f172a;line-height:1">Shop Requests</div>
          <div style="font-size:13px;color:#6b7280">Manager-submitted requests</div>
        </div>
      </div>

      @php
        $totalReq = $requests->count();
        $lowCount = $requests->where('priority','low')->count();
        $mediumCount = $requests->where('priority','medium')->count();
        $highCount = $requests->where('priority','high')->count();
      @endphp
      <div style="display:grid;gap:16px;grid-template-columns:repeat(4,1fr);margin-bottom:24px">
        <!-- Low Priority -->
        <div style="background:linear-gradient(135deg,#f0f9ff 0%,#e0f2fe 100%);border:2px solid #7dd3fc;border-radius:14px;padding:20px;box-shadow:0 2px 8px rgba(14,165,233,0.1)">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
            <div style="font-size:13px;color:#075985;font-weight:600">Low Priority</div>
            <div style="width:40px;height:40px;background:#06b6d4;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff">📄</div>
          </div>
          <div style="font-size:32px;font-weight:900;color:#0c4a6e">{{ $lowCount }}</div>
        </div>
        <!-- Medium Priority -->
        <div style="background:linear-gradient(135deg,#fffbeb 0%,#fef3c7 100%);border:2px solid #fcd34d;border-radius:14px;padding:20px;box-shadow:0 2px 8px rgba(245,158,11,0.1)">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
            <div style="font-size:13px;color:#92400e;font-weight:600">Medium Priority</div>
            <div style="width:40px;height:40px;background:#f59e0b;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff">📄</div>
          </div>
          <div style="font-size:32px;font-weight:900;color:#78350f">{{ $mediumCount }}</div>
        </div>
        <!-- High Priority -->
        <div style="background:linear-gradient(135deg,#fef2f2 0%,#fee2e2 100%);border:2px solid #fca5a5;border-radius:14px;padding:20px;box-shadow:0 2px 8px rgba(220,38,38,0.1)">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
            <div style="font-size:13px;color:#991b1b;font-weight:600">High Priority</div>
            <div style="width:40px;height:40px;background:#dc2626;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff">📄</div>
          </div>
          <div style="font-size:32px;font-weight:900;color:#7f1d1d">{{ $highCount }}</div>
        </div>
        <!-- Total Requests -->
        <div style="background:linear-gradient(135deg,#f3f4f6 0%,#e5e7eb 100%);border:2px solid #d1d5db;border-radius:14px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.05)">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
            <div style="font-size:13px;color:#374151;font-weight:600">Total Requests</div>
            <div style="width:40px;height:40px;background:#6b7280;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff">📄</div>
          </div>
          <div style="font-size:32px;font-weight:900;color:#1f2937">{{ $totalReq }}</div>
        </div>
      </div>

      <div style="display:grid;gap:16px">
        @forelse($requests as $q)
          @php
            $badgeText = strtoupper($q->priority);
            $badgeBg = $q->priority==='high' ? '#dc2626' : ($q->priority==='medium' ? '#f59e0b' : '#06b6d4');
            $cardBorder = $q->priority==='high' ? '#fca5a5' : ($q->priority==='medium' ? '#fcd34d' : '#7dd3fc');
            $cardBg = '#fff';
          @endphp
          <div style="background:{{ $cardBg }};border:2px solid {{ $cardBorder }};border-radius:14px;padding:20px;position:relative;box-shadow:0 2px 8px rgba(0,0,0,0.05)">
            <div style="position:absolute;right:20px;top:20px">
              <span style="display:inline-block;padding:6px 14px;border-radius:8px;color:#fff;background:{{ $badgeBg }};font-size:13px;font-weight:700;letter-spacing:0.5px">{{ $badgeText }}</span>
            </div>
            <div style="font-weight:700;font-size:18px;color:#0f172a;margin-right:100px;margin-bottom:6px">{{ $q->item }}</div>
            <div style="font-size:13px;color:#6b7280;margin-bottom:16px">By {{ $q->manager_username }} • {{ \Carbon\Carbon::parse($q->created_at)->format('M d, Y - g:i A') }}</div>

            <div style="display:grid;gap:12px;grid-template-columns:repeat(2,1fr);margin-bottom:16px">
              <div style="border:1px solid #e5e7eb;background:#f9fafb;border-radius:10px;padding:12px">
                <div style="font-size:12px;color:#6b7280;margin-bottom:6px;font-weight:600">Quantity</div>
                <div style="font-weight:700;font-size:16px;color:#0f172a">{{ $q->quantity }}</div>
              </div>
              <div style="border:1px solid #e5e7eb;background:#f9fafb;border-radius:10px;padding:12px">
                <div style="font-size:12px;color:#6b7280;margin-bottom:6px;font-weight:600">Priority</div>
                <div style="font-weight:700;font-size:16px;color:#0f172a">{{ ucfirst($q->priority) }}</div>
              </div>
            </div>

            @if(!empty($q->remarks))
            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:12px;margin-bottom:16px">
              <div style="font-size:12px;color:#6b7280;margin-bottom:6px;font-weight:600">Remarks</div>
              <div style="font-size:14px;color:#374151;line-height:1.5">{{ $q->remarks }}</div>
            </div>
            @endif

            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
              <div>
                <span style="display:inline-block;padding:8px 14px;border-radius:8px;border:2px solid #e5e7eb;background:#f9fafb;font-size:13px;color:#374151;font-weight:600">Status: <strong style="color:#0f172a">{{ ucfirst($q->status) }}</strong></span>
              </div>
              <div style="display:flex;gap:8px">
                @if($q->status === 'pending')
                  <form class="owner-req-form" data-result="approved" method="POST" action="{{ route('owner.request.approve', ['id' => $q->id]) }}" style="display:inline">@csrf<button style="padding:10px 18px;background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;border-radius:10px;font-weight:600;border:none;cursor:pointer;transition:all 0.2s ease;box-shadow:0 2px 6px rgba(22,163,74,0.3)" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 12px rgba(22,163,74,0.4)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 6px rgba(22,163,74,0.3)'">✓ Approve</button></form>
                  <form class="owner-req-form" data-result="rejected" method="POST" action="{{ route('owner.request.deny', ['id' => $q->id]) }}" style="display:inline">@csrf<button style="padding:10px 18px;background:linear-gradient(135deg,#dc2626,#b91c1c);color:#fff;border-radius:10px;font-weight:600;border:none;cursor:pointer;transition:all 0.2s ease;box-shadow:0 2px 6px rgba(220,38,38,0.3)" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 12px rgba(220,38,38,0.4)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 6px rgba(220,38,38,0.3)'">✗ Deny</button></form>
                @else
                  <span style="color:#6b7280;font-size:13px">No actions available</span>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div style="color:#6b7280;text-align:center;padding:40px">No requests yet.</div>
        @endforelse
      </div>
    </div>
