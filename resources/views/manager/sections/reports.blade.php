 
 <div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Financial Report</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:12px">Opening and closing shift financial details</div>
  <form id="mgr-reports-unified" method="POST" action="{{ route('manager.reports.unified') }}" enctype="multipart/form-data" data-no-loader novalidate>
    @csrf
    <div style="display:grid;gap:12px;grid-template-columns:1fr 1fr">
      <div style="border:1px solid #e3e3e0;border-radius:8px;padding:12px;background:#f0f9ff">
        <div style="font-weight:600;color:#0f172a;margin-bottom:8px">Opening Shift</div>
        <div style="display:grid;gap:8px">
          <input name="opening_cash" type="number" step="0.01" placeholder="Cash (₱)" value="{{ old('opening_cash') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="opening_wallet" type="number" step="0.01" placeholder="Digital Wallet (₱)" value="{{ old('opening_wallet') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="opening_bank" type="number" step="0.01" placeholder="Bank Amount (₱)" value="{{ old('opening_bank') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="opening_turnover_cash" type="number" step="0.01" placeholder="Turnover Cash (₱)" value="{{ old('opening_turnover_cash') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="opening_turnover_wallet" type="number" step="0.01" placeholder="Turnover Digital Wallet (₱)" value="{{ old('opening_turnover_wallet') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="opening_turnover_bank" type="number" step="0.01" placeholder="Turnover Bank Amount (₱)" value="{{ old('opening_turnover_bank') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="opening_image" type="file" accept="image/*" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px;background:#fff" required />
        </div>
      </div>
      <div style="border:1px solid #e3e3e0;border-radius:8px;padding:12px;background:#fff7ed">
        <div style="font-weight:600;color:#0f172a;margin-bottom:8px">Closing Shift</div>
        <div style="display:grid;gap:8px">
          <input name="closing_cash" type="number" step="0.01" placeholder="Cash (₱)" value="{{ old('closing_cash') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="closing_wallet" type="number" step="0.01" placeholder="Digital Wallet (₱)" value="{{ old('closing_wallet') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="closing_bank" type="number" step="0.01" placeholder="Bank Amount (₱)" value="{{ old('closing_bank') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="closing_turnover_cash" type="number" step="0.01" placeholder="Turnover Cash (₱)" value="{{ old('closing_turnover_cash') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="closing_turnover_wallet" type="number" step="0.01" placeholder="Turnover Digital Wallet (₱)" value="{{ old('closing_turnover_wallet') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="closing_turnover_bank" type="number" step="0.01" placeholder="Turnover Bank Amount (₱)" value="{{ old('closing_turnover_bank') }}" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px" required />
          <input name="closing_image" type="file" accept="image/*" style="width:97%;padding:8px;border:1px solid #e3e3e0;border-radius:6px;background:#fff" required />
        </div>
      </div>
    </div>
    
    

</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">APEPO Report</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Audit, People, Equipment, Product, Others</div>
  <div style="display:grid;gap:10px">
    <input name="audit" placeholder="A - Audit: findings and observations..." value="{{ old('audit') }}" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" required />
    <input name="people" placeholder="P - People: employee/role notes..." value="{{ old('people') }}" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" required />
    <input name="equipment" placeholder="E - Equipment: status and maintenance..." value="{{ old('equipment') }}" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" required />
    <input name="product" placeholder="P - Product: quality and inventory notes..." value="{{ old('product') }}" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" required />
    <input name="others" placeholder="O - Others: additional observations..." value="{{ old('others') }}" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px;background:#f3f4f6" required />
    <input name="notes" placeholder="Notes (optional)" value="{{ old('notes') }}" style="width:97%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
  </div>

</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Manager Fund</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Daily manager fund tracking</div>
  <div style="display:grid;gap:10px">
    <input name="fund_amount" type="number" step="0.01" placeholder="Amount (₱)" value="{{ old('fund_amount') }}" style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" required />
    <div style="display:flex;gap:8px;align-items:center">
      <input name="fund_image" type="file" accept="image/*" style="flex:1;padding:8px;border:1px solid #e3e3e0;border-radius:8px;background:#fff" required />
    </div>
  </div>
</div>

<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px;margin-top:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Expenses</div>
  <div style="font-size:12px;color:#6b7280;margin-bottom:10px">Record daily expenses</div>
  <div style="display:grid;gap:10px">
    <input name="expense_amount" type="number" step="0.01" min="0" placeholder="Amount (₱)" value="{{ old('expense_amount') }}" style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" required />
    <textarea name="expense_note" rows="4" placeholder="Expense details (no character limit)..." style="width:98%;padding:10px;border:1px solid #e3e3e0;border-radius:8px" required>{{ old('expense_note') }}</textarea>
  </div>
</div>

<div style="margin-top:12px">
  <button id="mgr-reports-submit" type="submit" data-confirm="Submit all reports now?" data-confirm-title="Confirm Submission" data-confirm-ok="Submit" style="width:100%;background:#16a34a;color:#fff;border-radius:8px;padding:10px 14px">Submit All</button>
</div>

</form>

<script>
  (function(){
    const form = document.getElementById('mgr-reports-unified');
    if(!form) return;
    const ENABLE_IMG_OPT = false; // set true to re-enable client-side image compression

    function validateAllFields(){
      const required = [
        { name:'opening_cash', label:'Opening Cash' },
        { name:'opening_wallet', label:'Opening Wallet' },
        { name:'opening_bank', label:'Opening Bank' },
        { name:'opening_turnover_cash', label:'Opening Turnover Cash' },
        { name:'opening_turnover_wallet', label:'Opening Turnover Wallet' },
        { name:'opening_turnover_bank', label:'Opening Turnover Bank' },
        { name:'opening_image', label:'Opening Photo', type:'file' },
        { name:'closing_cash', label:'Closing Cash' },
        { name:'closing_wallet', label:'Closing Wallet' },
        { name:'closing_bank', label:'Closing Bank' },
        { name:'closing_turnover_cash', label:'Closing Turnover Cash' },
        { name:'closing_turnover_wallet', label:'Closing Turnover Wallet' },
        { name:'closing_turnover_bank', label:'Closing Turnover Bank' },
        { name:'closing_image', label:'Closing Photo', type:'file' },
        { name:'audit', label:'APEPO - Audit' },
        { name:'people', label:'APEPO - People' },
        { name:'equipment', label:'APEPO - Equipment' },
        { name:'product', label:'APEPO - Product' },
        { name:'others', label:'APEPO - Others' },
        { name:'fund_amount', label:'Manager Fund Amount' },
        { name:'fund_image', label:'Manager Fund Photo', type:'file' },
        { name:'expense_amount', label:'Expense Amount' },
        { name:'expense_note', label:'Expense Note' },
      ];
      const missing = [];
      let firstEl = null;
      for(const r of required){
        // Look up globally to avoid missing fields if DOM nesting changes
        const el = document.querySelector('[name="'+r.name+'"]');
        if(!el){
          // If the field cannot be found at all, treat as missing so it shows in the toast
          missing.push(r.label);
          if(!firstEl) firstEl = form; // keep focus within form
          continue;
        }
        if(r.type === 'file'){
          if(!(el.files && el.files.length)){
            missing.push(r.label);
            if(!firstEl) firstEl = el;
          }
        } else {
          const val = (el.value||'').toString().trim();
          if(val === ''){
            missing.push(r.label);
            if(!firstEl) firstEl = el;
          }
        }
      }
      return { missing, firstEl };
    }

    function readFileAsDataURL(file){
      return new Promise((resolve, reject)=>{
        const r = new FileReader();
        r.onload = () => resolve(r.result);
        r.onerror = reject;
        r.readAsDataURL(file);
      });
    }

    function loadImage(url){
      return new Promise((resolve, reject)=>{
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = reject;
        img.src = url;
      });
    }

    async function compressFile(file, targetBytes = 1.2 * 1024 * 1024){
      try{
        let dataUrl = await readFileAsDataURL(file);
        let img = await loadImage(dataUrl);
        let maxW = 1600, maxH = 1600, quality = 0.78;
        for(let attempt=0; attempt<4; attempt++){
          const ratio = Math.min(maxW / img.width, maxH / img.height, 1);
          const w = Math.round(img.width * ratio);
          const h = Math.round(img.height * ratio);
          const canvas = document.createElement('canvas');
          canvas.width = w; canvas.height = h;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(img, 0, 0, w, h);
          const blob = await new Promise(resolve=> canvas.toBlob(resolve, 'image/jpeg', quality));
          if(!blob) break;
          if (blob.size <= targetBytes) {
            return new File([blob], (file.name || 'image').replace(/\.[^.]+$/, '') + '.jpg', { type:'image/jpeg' });
          }
          // tighten constraints and try again
          quality = Math.max(0.5, quality - 0.1);
          maxW = Math.round(maxW * 0.85);
          maxH = Math.round(maxH * 0.85);
        }
        // final output with last blob even if larger
        const finalBlob = await new Promise(resolve=> {
          const ratio = Math.min(maxW / img.width, maxH / img.height, 1);
          const w = Math.round(img.width * ratio);
          const h = Math.round(img.height * ratio);
          const canvas = document.createElement('canvas');
          canvas.width = w; canvas.height = h;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(img, 0, 0, w, h);
          canvas.toBlob(resolve, 'image/jpeg', quality);
        });
        if(finalBlob){
          return new File([finalBlob], (file.name || 'image').replace(/\.[^.]+$/, '') + '.jpg', { type:'image/jpeg' });
        }
        return file;
      }catch(_){
        return file;
      }
    }

    async function maybeCompressInput(input){
      const f = input && input.files ? input.files[0] : null;
      if(!f) return;
      // Skip small files (< 600KB)
      if(f.size && f.size < 600 * 1024) return;
      const compressed = await compressFile(f);
      if(compressed && compressed.size < f.size){
        // Replace the input's file with compressed one
        const dt = new DataTransfer();
        dt.items.add(compressed);
        input.files = dt.files;
      }
    }

    form.addEventListener('submit', async function(e){
      try{
        // Validate all fields (since Submit All requires all inputs completed)
        const { missing, firstEl } = validateAllFields();
        if(missing.length){
          e.preventDefault();
          try{
            if(window.toast){
              const msg = 'Please complete: ' + missing.join(', ');
              window.toast(msg, 'error');
            } else {
              alert('Please complete required fields:\n- ' + missing.join('\n- '));
            }
          } catch(_){}
          try{ if(firstEl && firstEl.focus){ firstEl.focus(); firstEl.scrollIntoView({ behavior:'smooth', block:'center' }); } }catch(_){ }
          return; // stop submit
        }

        if(ENABLE_IMG_OPT){
          // only intercept if there are image files
          const inputs = [
            form.querySelector('input[name="opening_image"]'),
            form.querySelector('input[name="closing_image"]'),
            form.querySelector('input[name="fund_image"]'),
          ].filter(Boolean);
          const anyFile = inputs.some(i => i.files && i.files.length);
          if(!anyFile) return; // proceed normally
          e.preventDefault();
          // Optional visual hint using global overlay if present
          try{
            const overlay = document.getElementById('loading-overlay');
            const textEl = document.getElementById('loading-text');
            if(overlay && textEl){ textEl.textContent = 'Optimizing photos…'; overlay.classList.add('show'); }
          }catch(_){ }
          for(const inp of inputs){ await maybeCompressInput(inp); }
          // if still very large, warn and abort
          const total = inputs.reduce((sum, i)=> sum + (i.files && i.files[0] ? i.files[0].size : 0), 0);
          if(total > 5 * 1024 * 1024){
            try{
              if(window.toast) window.toast('Attached photos are too large even after optimization. Please choose smaller images.', 'error');
            }catch(_){ alert('Attached photos are too large even after optimization. Please choose smaller images.'); }
            const overlay = document.getElementById('loading-overlay'); if(overlay) overlay.classList.remove('show');
            return; // do not submit
          }
          // submit after compression
          this.submit();
        }
      }catch(_){ try{ this.submit(); }catch(e){} }
    });
    // Also validate on click and force submit when valid
    try{
      var submitBtn = document.getElementById('mgr-reports-submit');
      if(submitBtn){
        submitBtn.addEventListener('click', function(ev){
          const res = validateAllFields();
          if(res.missing.length){
            ev.preventDefault();
            try{
              if(window.toast){
                const msg = 'Please complete: ' + res.missing.join(', ');
                window.toast(msg, 'error');
              } else {
                alert('Please complete required fields:\n- ' + res.missing.join('\n- '));
              }
            }catch(_){ }
            try{ if(res.firstEl && res.firstEl.focus){ res.firstEl.focus(); res.firstEl.scrollIntoView({ behavior:'smooth', block:'center' }); } }catch(_){ }
          } else {
          }
        });
      }
    }catch(_){ }
    // Show server-side validation errors as a toast on load
    try{
      @if(session('req_missing'))
        if(window.toast){ window.toast(@json(session('req_missing')), 'error'); }
      @endif
      @if($errors && $errors->any())
        if(window.toast){ window.toast(@json(implode('\n', $errors->all())), 'error'); }
      @endif
    }catch(_){ }
  })();
</script>

<!-- Lists moved outside the unified POST form to avoid nested forms -->

