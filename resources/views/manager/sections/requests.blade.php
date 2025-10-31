<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:8px">
  <h3 class="section-title">Requests</h3>
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
          <td colspan="2" style="padding:8px">
            <div style="display:flex;justify-content:flex-end;gap:8px">
              <button type="button" onclick="this.form.reset()" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Clear</button>
              <button style="background:#0891b2;color:#fff;border-radius:6px;padding:8px 12px">Submit</button>
            </div>
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