<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Submit Shop Request</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Request items needed for the shop</div>
  <form method="POST" action="{{ route('manager.request') }}">
    @csrf
    <table style="width:100%;border-collapse:collapse">
      <tbody>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px;width:180px">Item</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="item" placeholder="Item" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Quantity</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><input name="quantity" type="number" min="1" value="1" style="width:100%"></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Priority</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px"><select name="priority" style="width:100%"><option>low</option><option selected>medium</option><option>high</option></select></td>
        </tr>
        <tr>
          <th style="text-align:left;border-bottom:1px solid #e3e3e0;padding:8px">Remarks</th>
          <td style="border-bottom:1px solid #e3e3e0;padding:8px">
            <textarea name="remarks" rows="3" placeholder="Additional notes or specifications..." style="width:100%;padding:8px;border:1px solid #e3e3e0;border-radius:6px"></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="padding:8px">
            <button style="width:100%;background:#f97316;color:#fff;border-radius:6px;padding:10px 14px">Submit Request to Owner</button>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <ul style="margin-top:10px">
    @forelse($requests as $q)
      <li style="display:flex;justify-content:space-between;align-items:center;gap:8px">
        <span>{{ $q->item }} × {{ $q->quantity }} • {{ ucfirst($q->priority) }}</span>
        <span style="display:flex;align-items:center;gap:8px">
          <span style="color:#706f6c">{{ ucfirst($q->status) }}</span>
          @if(session('username') === ($q->manager_username ?? null))
            <form class="mgr-del-form" method="POST" action="{{ route('manager.request.delete', ['id' => $q->id]) }}">
              @csrf
              <button style="padding:4px 8px;background:#b91c1c;color:#fff;border-radius:6px" data-confirm="Remove this request?">Delete</button>
            </form>
          @endif
        </span>
      </li>
    @empty
      <li style="color:#706f6c">No requests yet.</li>
    @endforelse
  </ul>
</div>