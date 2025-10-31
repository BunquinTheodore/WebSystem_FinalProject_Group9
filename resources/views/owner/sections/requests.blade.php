    <div id="requests" class="owner-section" data-section="requests" style="display:none;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
        <button onclick="backToMain()" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#f0f9ff;color:#0891b2;border:none;cursor:pointer;transition:all 0.2s ease" onmouseover="this.style.background='#0891b2'; this.style.color='#fff'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f0f9ff'; this.style.color='#0891b2'; this.style.transform='scale(1)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
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
