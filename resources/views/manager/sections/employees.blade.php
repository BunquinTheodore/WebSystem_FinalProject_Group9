<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
 <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Employee Management</div>
 <div style="font-size:12px;color:#6b7280;margin-bottom:10px">View and manage employee information</div>
 <div style="overflow:auto">
 <table style="width:100%;border-collapse:collapse">
 <thead>
 <tr>
 <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Name</th>
 <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Role</th>
 <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Birthday</th>
 <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Status</th>
 <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Email</th>
 <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px">Contact</th>
 <th style="text-align:left;border-bottom:1px solid #f0f0ef;padding:8px;width:1%">Actions</th>
 </tr>
 </thead>
 <tbody>
 @forelse(($employees ?? []) as $emp)
 <tr>
 <td style="padding:8px">{{ $emp->name ?? (($emp->first_name ?? '').' '.($emp->last_name ?? '')) }}</td>
 <td style="padding:8px">{{ $emp->role ?? $emp->position ?? '-' }}</td>
 <td style="padding:8px">{{ optional($emp->birthday ?? null) ? \Carbon\Carbon::parse($emp->birthday)->format('m/d/Y') : '-' }}</td>
 <td style="padding:8px">
 @php($status = strtolower($emp->status ?? ''))
 <span style="display:inline-block;padding:4px 8px;border-radius:9999px;font-size:12px;{{ $status==='full-time' ? 'background:#e0f2fe;color:#0369a1' : 'background:#f3e8ff;color:#6b21a8' }}">
 {{ ucfirst($emp->status ?? 'Unknown') }}
 </span>
 </td>
 <td style="padding:8px">{{ $emp->email ?? '-' }}</td>
 <td style="padding:8px">{{ $emp->contact ?? $emp->phone ?? '-' }}</td>
 <td style="padding:8px">
 <div style="display:flex;gap:8px;align-items:center">
 <button title="Edit (view-only)" disabled style="padding:6px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#9ca3af;cursor:not-allowed">✎</button>
 <button title="Delete (owner-only)" disabled style="padding:6px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#9ca3af;cursor:not-allowed">🗑</button>
 </div>
 </td>
 </tr>
 @empty
 <tr><td colspan="7" style="padding:8px;color:#706f6c">No employees found.</td></tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div style="margin-top:12px">
 <button type="button" onclick="document.getElementById('mgr-add-emp').classList.toggle('open')" style="display:block;width:100%;text-align:center;background:#4f46e5;color:#fff;border-radius:8px;padding:10px 14px">+ Add New Employee</button>
 </div>
</div>

<div id="mgr-add-emp" class="card" style="display:none;margin-top:12px;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">New Employee</div>
  <form id="mgr-add-emp-form" method="POST" action="{{ \Illuminate\Support\Facades\Route::has('manager.employees.store') ? route('manager.employees.store') : route('manager.request') }}">
    @csrf
    <div style="display:grid;gap:10px">
      <div style="display:grid;gap:6px;grid-template-columns:1fr 1fr">
        <input name="name" placeholder="Full name" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        <input name="role" placeholder="Role/Position" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
      </div>
      <div style="display:grid;gap:6px;grid-template-columns:1fr 1fr 1fr">
        <input name="birthday" type="date" placeholder="Birthday" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        <select name="status" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px">
          <option value="full-time">Full-time</option>
          <option value="part-time">Part-time</option>
        </select>
        <input name="contact" placeholder="Contact" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
      </div>
      <input name="email" type="email" placeholder="Email" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />

      <input type="hidden" name="item" value="New Employee" />
      <input type="hidden" name="quantity" value="1" />
      <input type="hidden" name="priority" value="medium" />
      <input type="hidden" name="remarks" id="mgr-add-emp-remarks" />

      <div style="display:flex;gap:8px;justify-content:flex-end">
        <button type="button" onclick="document.getElementById('mgr-add-emp').classList.remove('open');document.getElementById('mgr-add-emp').style.display='none'" style="padding:10px 14px;border:1px solid #e3e3e0;border-radius:8px;background:#fff;color:#1b1b18">Cancel</button>
        <button style="padding:10px 14px;background:#16a34a;color:#fff;border-radius:8px">Submit</button>
      </div>
    </div>
  </form>
</div>

<script>
  (function(){
    var panel = document.getElementById('mgr-add-emp');
    if(panel){
      Object.defineProperty(panel, 'classListToggleApplied', {value:true, configurable:true});
      panel.addEventListener('transitionend', function(){});
    }
    var btnPanel = document.querySelector('button[onclick*="mgr-add-emp"]');
    if(btnPanel){
      btnPanel.addEventListener('click', function(){
        var p = document.getElementById('mgr-add-emp');
        if(p){ p.style.display = (p.style.display==='none' || p.style.display==='') ? 'block':'none'; }
      });
    }
    var form = document.getElementById('mgr-add-emp-form');
    if(form){
      form.addEventListener('submit', function(){
        var routeFallback = '{{ \Illuminate\Support\Facades\Route::has('manager.employees.store') ? '0' : '1' }}' === '1';
        if(routeFallback){
          var name = form.querySelector('[name=name]')?.value || '';
          var role = form.querySelector('[name=role]')?.value || '';
          var birthday = form.querySelector('[name=birthday]')?.value || '';
          var status = form.querySelector('[name=status]')?.value || '';
          var email = form.querySelector('[name=email]')?.value || '';
          var contact = form.querySelector('[name=contact]')?.value || '';
          var remarks = `Employee: ${name}\nRole: ${role}\nBirthday: ${birthday}\nStatus: ${status}\nEmail: ${email}\nContact: ${contact}`;
          var r = document.getElementById('mgr-add-emp-remarks');
          if(r){ r.value = remarks; }
        }
      });
    }
  })();
</script>
