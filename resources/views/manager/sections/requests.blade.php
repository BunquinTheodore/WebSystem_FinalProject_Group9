<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Submit Shop Request</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Request items needed for the shop</div>
  <form method="POST" action="{{ route('manager.request') }}" style="display:grid;gap:14px">
    @csrf
    <!-- Row: Item / Quantity / Priority side-by-side -->
    <div style="display:grid;gap:10px;grid-template-columns:2fr 1fr 1fr">
      <div style="display:flex;flex-direction:column;gap:4px">
        <label style="font-size:12px;color:#0f172a">Item</label>
        <input name="item" placeholder="Item name" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
      </div>
      <div style="display:flex;flex-direction:column;gap:4px">
        <label style="font-size:12px;color:#0f172a">Quantity</label>
        <input name="quantity" type="number" min="1" value="1" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
      </div>
      <div style="display:flex;flex-direction:column;gap:4px">
        <label style="font-size:12px;color:#0f172a">Priority</label>
        <select name="priority" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px">
          <option value="low">Low</option>
          <option value="medium" selected>Medium</option>
          <option value="high">High</option>
        </select>
      </div>
    </div>
    <!-- Remarks full width -->
    <div style="display:flex;flex-direction:column;gap:4px">
      <label style="font-size:12px;color:#0f172a">Remarks</label>
      <textarea name="remarks" rows="3" placeholder="Additional notes or specifications..." style="padding:10px;border:1px solid #e3e3e0;border-radius:8px;resize:vertical"></textarea>
    </div>
    <div style="display:flex;justify-content:flex-end">
      <button style="background:#f97316;color:#fff;border-radius:8px;padding:10px 16px">Submit Request to Owner</button>
    </div>
  </form>
  <div style="margin-top:10px;display:flex;align-items:center;gap:12px;flex-wrap:wrap">
    <div style="display:flex;align-items:center;gap:6px">
      <label for="req-filter-priority" style="font-size:12px;color:#0f172a">Filter Priority:</label>
      <select id="req-filter-priority" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
        <option value="">All</option>
        <option value="low">Low</option>
        <option value="medium" selected>Medium</option>
        <option value="high">High</option>
      </select>
    </div>
    <div style="font-size:12px;color:#6b7280">Click headers to sort</div>
  </div>
  <style>
    .req-badge{display:inline-block;padding:4px 8px;border-radius:999px;font-size:12px;font-weight:500;line-height:1;border:1px solid transparent}
    .req-badge-low{background:#f1f5f9;color:#475569;border-color:#e2e8f0}
    .req-badge-medium{background:#fef9c3;color:#a16207;border-color:#fde68a}
    .req-badge-high{background:#fee2e2;color:#b91c1c;border-color:#fecaca}
    .req-badge-pending{background:#ede9fe;color:#5b21b6;border-color:#ddd6fe}
    .req-badge-approved{background:#dcfce7;color:#166534;border-color:#bbf7d0}
    .req-badge-rejected{background:#fee2e2;color:#991b1b;border-color:#fecaca}
    th.req-sortable{cursor:pointer;position:relative;user-select:none}
    th.req-sortable:after{content:"";position:absolute;right:6px;top:50%;width:0;height:0;border-left:4px solid transparent;border-right:4px solid transparent;border-top:6px solid #9ca3af;transform:translateY(-30%);opacity:.4}
    th.req-sortable.sorted-asc:after{border-top:6px solid #0f172a;transform:translateY(-70%) rotate(180deg);opacity:1}
    th.req-sortable.sorted-desc:after{border-top:6px solid #0f172a;opacity:1}
  </style>
  <div style="margin-top:6px;overflow:auto">
    <table id="mgr-requests-table" style="width:100%;border-collapse:separate;border-spacing:0;min-width:980px">
      <thead>
        <tr>
          <th data-key="item" class="req-sortable" style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Item</th>
          <th data-key="quantity" class="req-sortable" style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:80px">Qty</th>
          <th data-key="priority" class="req-sortable" style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:120px">Priority</th>
          <th data-key="status" class="req-sortable" style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:140px">Status</th>
          <th data-key="created_at" class="req-sortable" style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Created At</th>
          <th data-key="manager_username" class="req-sortable" style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Requested By</th>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:1%">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($requests as $q)
          @php
            $p = strtolower($q->priority ?? 'medium');
            $s = strtolower($q->status ?? 'pending');
            $priorityClass = 'req-badge-' . (in_array($p,['low','medium','high']) ? $p : 'medium');
            $statusClass = 'req-badge-' . (in_array($s,['pending','approved','rejected']) ? $s : 'pending');
          @endphp
          <tr data-priority="{{ $p }}">
            <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $q->item }}</td>
            <td style="padding:8px;border-bottom:1px solid #f6f6f5" data-value="{{ (int)($q->quantity ?? 0) }}">{{ (int)($q->quantity ?? 0) }}</td>
            <td style="padding:8px;border-bottom:1px solid #f6f6f5"><span class="req-badge {{ $priorityClass }}">{{ ucfirst($p) }}</span></td>
            <td style="padding:8px;border-bottom:1px solid #f6f6f5"><span class="req-badge {{ $statusClass }}">{{ ucfirst($s) }}</span></td>
            <td style="padding:8px;border-bottom:1px solid #f6f6f5" data-value="{{ !empty($q->created_at ?? null) ? \Carbon\Carbon::parse($q->created_at)->timestamp : 0 }}">{{ !empty($q->created_at ?? null) ? \Carbon\Carbon::parse($q->created_at)->format('M d, Y h:i A') : '—' }}</td>
            <td style="padding:8px;border-bottom:1px solid #f6f6f5">{{ $q->manager_username ?? '—' }}</td>
            <td style="padding:8px;border-bottom:1px solid #f6f6f5">
              @if(session('username') === ($q->manager_username ?? null))
                <form class="mgr-del-form" method="POST" action="{{ route('manager.request.delete', ['id' => $q->id]) }}" style="margin:0">
                  @csrf
                  <button style="padding:6px 10px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this request?" data-confirm-title="Confirm Delete" data-confirm-ok="Delete" data-confirm-type="danger">Delete</button>
                </form>
              @else
                <span style="color:#9ca3af">—</span>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="padding:8px;color:#706f6c">No requests yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <script>
    (function(){
      var table = document.getElementById('mgr-requests-table');
      var filter = document.getElementById('req-filter-priority');
      if(!table) return;
      var tbody = table.querySelector('tbody');
      function applyFilter(){
        var val = (filter.value||'').toLowerCase();
        Array.from(tbody.querySelectorAll('tr')).forEach(function(r){
          if(!r.hasAttribute('data-priority')) return;
          var p = r.getAttribute('data-priority');
          r.style.display = (!val || p===val) ? '' : 'none';
        });
      }
      if(filter){ filter.addEventListener('change', applyFilter); applyFilter(); }
      var currentSort = { key:null, dir:1 };
      function sortBy(key){
        var rows = Array.from(tbody.querySelectorAll('tr')).filter(function(r){ return r.hasAttribute('data-priority'); });
        var dir = (currentSort.key===key) ? -currentSort.dir : 1; // toggle
        currentSort = { key:key, dir:dir };
        rows.sort(function(a,b){
          var avEl = a.querySelector('[data-value]') && key!=='item' ? a.querySelector('[data-value]') : null;
          var bvEl = b.querySelector('[data-value]') && key!=='item' ? b.querySelector('[data-value]') : null;
          var av, bv;
          if(key==='quantity' || key==='created_at'){
            av = parseFloat(a.querySelector('td[data-value]')?.getAttribute('data-value')||'0');
            bv = parseFloat(b.querySelector('td[data-value]')?.getAttribute('data-value')||'0');
          } else {
            var aCell = a.querySelector('td:nth-child('+({item:1,quantity:2,priority:3,status:4,created_at:5,manager_username:6}[key])+')');
            var bCell = b.querySelector('td:nth-child('+({item:1,quantity:2,priority:3,status:4,created_at:5,manager_username:6}[key])+')');
            av = (aCell?.innerText||'').toLowerCase();
            bv = (bCell?.innerText||'').toLowerCase();
          }
          if(av<bv) return -1*dir;
          if(av>bv) return 1*dir;
          return 0;
        });
        rows.forEach(function(r){ tbody.appendChild(r); });
        // Update header classes
        table.querySelectorAll('th.req-sortable').forEach(function(th){ th.classList.remove('sorted-asc','sorted-desc'); });
        var th = table.querySelector('th[data-key="'+key+'"]');
        if(th){ th.classList.add(dir===1?'sorted-asc':'sorted-desc'); }
      }
      table.querySelectorAll('th.req-sortable').forEach(function(th){
        th.addEventListener('click', function(){ sortBy(th.getAttribute('data-key')); });
      });
    })();
  </script>
</div>