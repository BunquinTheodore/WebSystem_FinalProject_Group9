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
  /* Added-row flash to ensure visibility */
  .flash-add{animation:flashAdd 1.2s ease}
  @keyframes flashAdd{0%{background:#ecfeff}50%{background:#fff}100%{background:transparent}}
  /* Submitted rows style removed: keep rows fully editable after submit */
  .name-wrap{display:flex;align-items:center;gap:8px}
  .badge-submitted{display:inline-block;padding:2px 6px;font-size:11px;font-weight:600;color:#6b21a8;border:1px solid #c084fc;border-radius:999px;background:#faf5ff}
  /* Inline edit inputs */
  .inv-edit-input{padding:8px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;width:100%;box-sizing:border-box}
  .inv-edit-input:focus{border-color:#0891b2;box-shadow:0 0 0 2px rgba(8,145,178,0.1)}
  .inv-edit-select{padding:8px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px}
</style>
<div class="inv-mgr-card">
  <div class="inv-mgr-title">Inventory Management</div>
  <div class="inv-mgr-sub">Track and update stock levels</div>

  <form id="inv-add-form" class="inv-add-form" method="POST" action="{{ route('manager.inventory.add') }}" autocomplete="off" data-no-loader>
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
    <button type="submit" class="inv-add-btn" title="Add item">+</button>
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
            <td>
              <div class="name-wrap">
                <input type="text" class="inv-edit-input" value="{{ $item->product_name }}" data-field="product_name" placeholder="Product name" />
                @if(!empty($item->is_submitted))
                  <span class="badge-submitted" title="Submitted to Owner">Submitted</span>
                @endif
              </div>
            </td>
            <td>
              <select class="inv-edit-select" data-field="unit">
                @php($units=['kg','pcs','no. of package','bottle','L'])
                @foreach($units as $u)
                  <option value="{{ $u }}" @selected($item->unit===$u)>{{ $u }}</option>
                @endforeach
              </select>
            </td>
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
            <td><span class="last-updated">{{ optional($item->updated_at)->format('m/d/Y') ?? '-' }}</span></td>
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

  <div style="margin-top:16px">
    <button type="button" id="submit-owner-btn" class="submit-inv-btn" style="width:100%;background:#9333ea">Submit to Owner</button>
  </div>
</div>

<script>
(function(){
  const CSRF = `{{ csrf_token() }}`;
  const tbody = document.getElementById('inv-tbody');
  const emptyRow = document.getElementById('empty-row');
  const addForm = document.getElementById('inv-add-form');
  const tableScrollContainer = addForm ? addForm.nextElementSibling : null; // the div with overflow:auto
  const INV_UPDATE_URL = `{{ route('manager.inventory.update') }}`;
  const INV_SUBMIT_URL = `{{ route('manager.inventory.submit') }}`;
  const INV_ADD_URL = `{{ route('manager.inventory.add') }}`;
  const INV_BASE_URL = `{{ url('/manager/inventory') }}`;

  // Normalize event target (handle Text nodes)
  function elFromEventTarget(t){ return (t && t.nodeType === 3) ? t.parentNode : t; }

  // Persist add-form inputs locally so values are not lost
  const DRAFT_KEY = 'mgr:inv:add:draft';
  function readDraft(){
    try{ return JSON.parse(localStorage.getItem(DRAFT_KEY) || '{}'); }catch(_){ return {}; }
  }
  function saveDraft(obj){
    try{ localStorage.setItem(DRAFT_KEY, JSON.stringify(obj||{})); }catch(_){ /* ignore */ }
  }
  function applyDraft(){
    if(!addForm) return;
    const d = readDraft();
    if('product_name' in d) addForm.querySelector('[name="product_name"]').value = d.product_name || '';
    if('unit' in d) addForm.querySelector('[name="unit"]').value = d.unit || 'kg';
    if('sealed' in d) addForm.querySelector('[name="sealed"]').value = (d.sealed!==undefined?d.sealed:'');
    if('loose' in d) addForm.querySelector('[name="loose"]').value = (d.loose!==undefined?d.loose:'');
  }
  function captureDraft(){
    if(!addForm) return;
    const fd = new FormData(addForm);
    const draft = {
      product_name: (fd.get('product_name')||'').toString(),
      unit: (fd.get('unit')||'kg').toString(),
      sealed: (fd.get('sealed')||'').toString(),
      loose: (fd.get('loose')||'').toString(),
    };
    saveDraft(draft);
  }
  if(addForm){
    // Load saved values on init
    applyDraft();
    // Save on any changes
    addForm.addEventListener('input', captureDraft);
    addForm.addEventListener('change', captureDraft);
  }

  // Quantity controls
  tbody.addEventListener('click', async function(e){
    const el = elFromEventTarget(e.target);
    const btn = el && el.closest ? el.closest('.qty-btn') : null;
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
    const prev = span.textContent;
    span.textContent = val; // optimistic update
    btn.disabled = true;
    try{
      const res = await fetch(INV_UPDATE_URL, {
        method:'POST',
        headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'},
        body: JSON.stringify({ id:id, field:field, value:val })
      });
      if(!res.ok){
        span.textContent = prev; // revert
        if(window.toast) window.toast('Update failed','error');
      } else {
        const json = await res.json().catch(()=>({}));
        const updatedAt = json.updated_at || '';
        const lastCell = tr.querySelector('.last-updated');
        if(lastCell && updatedAt) lastCell.textContent = updatedAt;
        if(window.toast) window.toast(field.charAt(0).toUpperCase()+field.slice(1)+' updated','success');
      }
    }catch(_){
      span.textContent = prev; // revert on network error
      if(window.toast) window.toast('Network error','error');
    }finally{
      btn.disabled = false;
    }
  });

  // Delete
  tbody.addEventListener('click', async function(e){
    const el = elFromEventTarget(e.target);
    const delBtn = el && el.closest ? el.closest('.del-btn') : null;
    if(!delBtn) return;
    const id = delBtn.getAttribute('data-delete');
    if(!id) return;
    if(!confirm('Delete this product?')) return;
    try{
      const res = await fetch(INV_BASE_URL+'/'+id, {
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

  // Removed Update Inventory button (inline edits save automatically)

  // Submit to Owner button (adds visual badge, does not lock editing)
  const submitOwnerBtn = document.getElementById('submit-owner-btn');
  if(submitOwnerBtn){
    submitOwnerBtn.addEventListener('click', async function(){
      let ok = true;
      try{
        if(window.modalConfirm){
          ok = await window.modalConfirm('Submit current inventory to Owner?', { title: 'Confirm Submission', confirmText: 'Submit' });
        } else {
          ok = window.confirm('Submit current inventory to Owner?');
        }
      }catch(_){ ok = false; }
      if(!ok) return;
      try{
        const res = await fetch(INV_SUBMIT_URL, {
          method:'POST',
          headers:{'X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'}
        });
        if(!res.ok) throw new Error();
        // Add visual submitted badge without locking editing
        tbody.querySelectorAll('tr[data-id]').forEach(function(tr){
          const wrap = tr.querySelector('.name-wrap');
          if(wrap && !wrap.querySelector('.badge-submitted')){
            const badge = document.createElement('span');
            badge.className = 'badge-submitted';
            badge.title = 'Submitted to Owner';
            badge.textContent = 'Submitted';
            wrap.appendChild(badge);
          }
        });
        if(window.toast) window.toast('Inventory submitted to Owner','success');
      }catch(_){
        if(window.toast) window.toast('Submit failed','error');
      }
    });
  }

  // Inline edits for product_name and unit
  tbody.addEventListener('change', async function(e){
    const el = e.target;
    const tr = el && el.closest ? el.closest('tr[data-id]') : null;
    if(!tr) return;
    const id = tr.getAttribute('data-id');
    if(!id) return;
    const field = el.getAttribute('data-field');
    if(!field || (field!=='product_name' && field!=='unit')) return;
    const value = (el.value||'').trim();
    try{
      const res = await fetch(INV_UPDATE_URL, {
        method:'POST',
        headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'},
        body: JSON.stringify({ id, field, value })
      });
      if(!res.ok){
        const err = await res.json().catch(()=>({}));
        const msg = err.message || 'Failed to update';
        if(window.toast) window.toast(msg,'error');
        return;
      }
      const json = await res.json().catch(()=>({}));
      const updatedAt = json.updated_at || '';
      const lastCell = tr.querySelector('.last-updated');
      if(lastCell && updatedAt) lastCell.textContent = updatedAt;
      if(window.toast) window.toast('Updated','success');
    }catch(_){ if(window.toast) window.toast('Failed to update','error'); }
  });

  // Also save on blur for text inputs to catch edits without change event firing
  tbody.addEventListener('blur', function(e){
    const el = e.target;
    if(!el || el.getAttribute('data-field') !== 'product_name') return;
    // Trigger change to reuse handler
    const evt = new Event('change', { bubbles:true });
    el.dispatchEvent(evt);
  }, true);

  // Add new inventory item (AJAX, append row without redirect)
  addForm.addEventListener('submit', async function(e){
    e.preventDefault();
    const fd = new FormData(addForm);
    const product_name = (fd.get('product_name')||'').trim();
    const unit = (fd.get('unit')||'').trim();
    const sealed = parseInt(fd.get('sealed')||'0')||0;
    const loose = parseInt(fd.get('loose')||'0')||0;
    if(!product_name){ if(window.toast) window.toast('Product name required','error'); return; }
    try{
      const res = await fetch(INV_ADD_URL, {
        method:'POST',
        headers:{
          'Content-Type':'application/json',
          'Accept':'application/json',
          'X-CSRF-TOKEN':CSRF,
          'X-Requested-With':'XMLHttpRequest'
        },
        body: JSON.stringify({ product_name, unit, sealed, loose })
      });
      if(!res.ok){
        // Try to surface validation errors to user
        try{
          const err = await res.json();
          const msg = (err && (err.message || (err.errors && Object.values(err.errors).flat().join(', ')))) || 'Failed to add item';
          if(window.toast) window.toast(msg,'error');
        }catch(_){ /* ignore */ }
        throw new Error('bad response');
      }
      const json = await res.json().catch(()=>({}));
      // Expect backend returns inserted id; if not, we fallback to refresh.
      const newItem = json.item || {};
      const newId = json.id || json.insert_id || newItem.id || null;
      const sealedVal = (typeof newItem.sealed === 'number') ? newItem.sealed : sealed;
      const looseVal = (typeof newItem.loose === 'number') ? newItem.loose : loose;
      const unitVal = newItem.unit || unit;
      const nameVal = newItem.product_name || product_name;
      // Remove empty placeholder
      if(emptyRow) emptyRow.style.display='none';
      // Build new row
      const tr = document.createElement('tr');
      if(newId) tr.setAttribute('data-id', newId);
      tr.innerHTML = `<td><div class="name-wrap"><input type="text" class="inv-edit-input" value="${escapeHtml(nameVal)}" data-field="product_name" placeholder="Product name" /></div></td>
        <td><select class="inv-edit-select" data-field="unit">
              ${['kg','pcs','no. of package','bottle','L'].map(u=>`<option value="${u}" ${u===unitVal?'selected':''}>${u}</option>`).join('')}
            </select></td>
        <td><div class="qty-ctrl">
              <button type="button" class="qty-btn" data-action="sealed" data-dir="-1">-</button>
              <span class="qty-val" data-field="sealed">${sealedVal}</span>
              <button type="button" class="qty-btn" data-action="sealed" data-dir="1">+</button>
            </div></td>
        <td><div class="qty-ctrl">
              <button type="button" class="qty-btn" data-action="loose" data-dir="-1">-</button>
              <span class="qty-val" data-field="loose">${looseVal}</span>
              <button type="button" class="qty-btn" data-action="loose" data-dir="1">+</button>
            </div></td>
        <td><div class="qty-ctrl">
              <button type="button" class="qty-btn" data-action="delivered" data-dir="-1">-</button>
              <span class="qty-val" data-field="delivered">0</span>
              <button type="button" class="qty-btn" data-action="delivered" data-dir="1">+</button>
            </div></td>
        <td><span class="last-updated">${(new Date()).toLocaleDateString()}</span></td>
        <td><button type="button" class="del-btn" data-delete="${newId||''}" title="Delete">🗑</button></td>`;
      tbody.prepend(tr);
      // Ensure visibility: scroll to top and flash
      if(tableScrollContainer && typeof tableScrollContainer.scrollTop === 'number'){
        tableScrollContainer.scrollTop = 0;
      }
      tr.classList.add('flash-add');
      setTimeout(()=>tr.classList.remove('flash-add'), 1200);
      // Keep inputs as-is to "save" what user typed
      // Sync draft with possibly sanitized/trimmed values from server
      const current = readDraft();
      current.product_name = nameVal;
      current.unit = unitVal;
      current.sealed = String(sealedVal);
      current.loose = String(looseVal);
      saveDraft(current);
      // Optional: focus the product name for quick subsequent edits
      const first = addForm.querySelector('[name="product_name"]');
      if(first && first.focus) first.focus();
      if(window.toast) window.toast('Item added','success');
    }catch(_){
      if(window.toast) window.toast('Failed to add (refreshing...)','error');
      // Fallback: reload to reflect new data
      setTimeout(()=>window.location.reload(), 600);
    }
  });

  function escapeHtml(str){
    return String(str).replace(/[&<>"']/g, function(ch){
      return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[ch]) || ch;
    });
  }
})();
</script>