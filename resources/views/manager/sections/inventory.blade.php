<style>
  .inv-mgr-card{background:#fff;border:1px solid #e3e3e0;border-radius:8px;padding:18px}
  .inv-mgr-title{font-weight:700;font-size:18px;color:#0f172a;margin-bottom:4px}
  .inv-mgr-sub{font-size:12px;color:#6b7280;margin-bottom:14px}
  .inv-add-form{display:grid;grid-template-columns:1fr auto auto auto auto;gap:12px;align-items:center;margin-bottom:18px}
  .inv-add-input{padding:10px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;outline:none}
  .inv-add-input:focus{border-color:#0891b2;box-shadow:0 0 0 2px rgba(8,145,178,0.1)}
  .inv-add-btn{padding:10px 24px;background:#0891b2;color:#fff;border:none;border-radius:6px;cursor:pointer;font-weight:600;transition:all 0.2s}
  .inv-add-btn:hover{background:#0e7490;transform:translateY(-1px);box-shadow:0 4px 12px rgba(8,145,178,0.25)}
  .inv-table{width:100%;border-collapse:collapse}
  .inv-table thead th{text-align:left;border-bottom:2px solid #e5e7eb;padding:10px 8px;font-size:13px;font-weight:600;color:#374151}
  .inv-table tbody tr{border-bottom:1px solid #f3f4f6}
  .inv-table tbody td{padding:10px 8px}
  .qty-ctrl{display:inline-flex;align-items:center;gap:8px}
  .qty-btn{width:28px;height:28px;border:1px solid #d1d5db;background:#fff;border-radius:4px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:all 0.15s}
  .qty-btn:hover{background:#f9fafb;border-color:#9ca3af}
  .qty-val{min-width:36px;text-align:center;font-weight:600;font-size:14px}
  .submit-inv-btn{width:100%;padding:14px;background:#0891b2;color:#fff;border:none;border-radius:6px;font-weight:700;font-size:15px;cursor:pointer;margin-top:16px;transition:all 0.2s}
  .submit-inv-btn:hover{background:#0e7490;box-shadow:0 4px 16px rgba(8,145,178,0.3)}
  .del-btn{color:#dc2626;cursor:pointer;font-size:18px;padding:4px 8px;transition:all 0.15s}
  .del-btn:hover{color:#b91c1c;transform:scale(1.15)}
</style>
<div class="inv-mgr-card">
  <div class="inv-mgr-title">Inventory Management</div>
  <div class="inv-mgr-sub">Track and update stock levels</div>

  <form id="inv-add-form" class="inv-add-form" method="POST" action="{{ route('manager.inventory.add') }}">
    @csrf
    <input class="inv-add-input" name="product_name" placeholder="Product name" required />
    <input class="inv-add-input" name="sealed" type="number" min="0" placeholder="Sealed qty" style="width:110px" />
    <input class="inv-add-input" name="loose" type="number" min="0" placeholder="Loose qty" style="width:110px" />
    <select class="inv-add-input" name="unit" style="width:100px">
      <option value="kg">kg</option>
      <option value="pcs">pcs</option>
      <option value="no. of package">no. of package</option>
      <option value="bottle">bottle</option>
      <option value="L">L</option>
    </select>
    <button type="submit" class="inv-add-btn">+</button>
  </form>

  <div style="overflow:auto">
    <table class="inv-table">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Unit</th>
          <th>Sealed</th>
          <th>Loose</th>
          <th>Delivered</th>
          <th>Last Updated</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="inv-tbody">
        @forelse(($managerInventory ?? []) as $item)
          <tr data-id="{{ $item->id }}">
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->unit }}</td>
            <td>
              <div class="qty-ctrl">
                <button type="button" class="qty-btn" data-action="sealed" data-dir="-1">-</button>
                <span class="qty-val" data-field="sealed">{{ $item->sealed }}</span>
                <button type="button" class="qty-btn" data-action="sealed" data-dir="1">+</button>
              </div>
            </td>
            <td>
              <div class="qty-ctrl">
                <button type="button" class="qty-btn" data-action="loose" data-dir="-1">-</button>
                <span class="qty-val" data-field="loose">{{ $item->loose }}</span>
                <button type="button" class="qty-btn" data-action="loose" data-dir="1">+</button>
              </div>
            </td>
            <td>
              <div class="qty-ctrl">
                <button type="button" class="qty-btn" data-action="delivered" data-dir="-1">-</button>
                <span class="qty-val" data-field="delivered">{{ $item->delivered }}</span>
                <button type="button" class="qty-btn" data-action="delivered" data-dir="1">+</button>
              </div>
            </td>
            <td>{{ optional($item->updated_at)->format('m/d/Y') ?? '-' }}</td>
            <td>
              <button type="button" class="del-btn" data-delete="{{ $item->id }}" title="Delete">🗑</button>
            </td>
          </tr>
        @empty
          <tr id="empty-row"><td colspan="7" style="text-align:center;color:#9ca3af;padding:20px">No products yet. Add one above!</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <button type="button" id="submit-inv-btn" class="submit-inv-btn">Submit Inventory to Owner</button>
</div>

<script>
(function(){
  const CSRF = '{{ csrf_token() }}';
  const tbody = document.getElementById('inv-tbody');
  const emptyRow = document.getElementById('empty-row');

  // Quantity controls
  tbody.addEventListener('click', async function(e){
    const btn = e.target.closest('.qty-btn');
    if(!btn) return;
    const tr = btn.closest('tr');
    if(!tr) return;
    const id = tr.getAttribute('data-id');
    const field = btn.getAttribute('data-action');
    const dir = parseInt(btn.getAttribute('data-dir') || '0');
    const span = tr.querySelector('.qty-val[data-field="'+field+'"]');
    if(!span) return;
    let val = parseInt(span.textContent || '0');
    val = Math.max(0, val + dir);
    span.textContent = val;
    // Update backend
    try{
      await fetch('{{ route('manager.inventory.update') }}', {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'},
        body: JSON.stringify({ id:id, field:field, value:val })
      });
    }catch(_){}
  });

  // Delete
  tbody.addEventListener('click', async function(e){
    const delBtn = e.target.closest('.del-btn');
    if(!delBtn) return;
    const id = delBtn.getAttribute('data-delete');
    if(!id) return;
    if(!confirm('Delete this product?')) return;
    try{
      const res = await fetch('{{ url('/manager/inventory') }}/'+id, {
        method:'DELETE',
        headers:{'X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'}
      });
      if(!res.ok) throw new Error();
      const tr = delBtn.closest('tr');
      if(tr) tr.remove();
      if(tbody.querySelectorAll('tr[data-id]').length === 0){
        if(emptyRow) emptyRow.style.display='';
      }
      if(window.toast) window.toast('Product deleted','success');
    }catch(_){
      if(window.toast) window.toast('Failed to delete','error');
    }
  });

  // Submit to Owner
  document.getElementById('submit-inv-btn').addEventListener('click', async function(){
    if(!confirm('Submit current inventory to Owner?')) return;
    try{
      const res = await fetch('{{ route('manager.inventory.submit') }}', {
        method:'POST',
        headers:{'X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'}
      });
      if(!res.ok) throw new Error();
      if(window.toast) window.toast('Inventory submitted to Owner!','success');
      else alert('Inventory submitted!');
    }catch(_){
      if(window.toast) window.toast('Failed to submit','error');
      else alert('Submit failed');
    }
  });
})();
</script>