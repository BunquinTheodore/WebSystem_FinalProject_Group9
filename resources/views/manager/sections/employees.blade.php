<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
 <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Employee Management</div>
 <div style="font-size:12px;color:#6b7280;margin-bottom:10px">View and manage employee information</div>
 <style>
   .mgr-emp-badge{display:inline-block;padding:4px 8px;border-radius:9999px;font-size:12px}
   .mgr-emp-badge-full{background:#e0f2fe;color:#0369a1}
   .mgr-emp-badge-part{background:#f3e8ff;color:#6b21a8}
 </style>
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
 <td style="padding:8px">{{ !empty($emp->birthday ?? null) ? \Carbon\Carbon::parse($emp->birthday)->format('m/d/Y') : '-' }}</td>
 <td style="padding:8px">
 @php
   $et = strtolower($emp->employment_type ?? '');
   $isFull = $et === 'fulltime';
 @endphp
 <span class="mgr-emp-badge {{ $isFull ? 'mgr-emp-badge-full' : 'mgr-emp-badge-part' }}">
   {{ $isFull ? 'Full-time' : ($et==='parttime' ? 'Part-time' : 'Unknown') }}
 </span>
 </td>
 <td style="padding:8px">{{ $emp->email ?? '-' }}</td>
 <td style="padding:8px">{{ $emp->contact ?? $emp->phone ?? '-' }}</td>
 <td style="padding:8px">
   <div style="display:flex;gap:8px;align-items:center">
     <button type="button" onclick="document.getElementById('edit-emp-{{ $emp->id }}').style.display = (document.getElementById('edit-emp-{{ $emp->id }}').style.display==='none' || document.getElementById('edit-emp-{{ $emp->id }}').style.display==='') ? 'table-row' : 'none'" style="padding:6px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#0f172a">✎</button>
     <form method="POST" action="{{ route('manager.employees.delete', ['id'=>$emp->id]) }}" onsubmit="return confirm('Delete this employee?')" style="margin:0">
       @csrf
       <button style="padding:6px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#b91c1c">🗑</button>
     </form>
   </div>
 </td>
 </tr>
 <tr id="edit-emp-{{ $emp->id }}" style="display:none;background:#fafafa">
   <td colspan="7" style="padding:8px">
     <form method="POST" action="{{ route('manager.employees.update', ['id'=>$emp->id]) }}" style="display:grid;gap:10px">
       @csrf
       <div style="display:grid;gap:8px;grid-template-columns:1fr 1fr">
         <input name="name" value="{{ $emp->name }}" placeholder="Full name" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
         <input name="role" value="{{ $emp->position ?? $emp->role ?? '' }}" placeholder="Role/Position" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
       </div>
       <div style="display:grid;gap:8px;grid-template-columns:1fr 1fr 1fr">
         <input name="birthday" type="date" value="{{ !empty($emp->birthday ?? null) ? \Carbon\Carbon::parse($emp->birthday)->format('Y-m-d') : '' }}" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
         @php
           $editEt = strtolower($emp->employment_type ?? 'fulltime');
         @endphp
         <select name="status" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px">
           <option value="full-time" {{ $editEt==='fulltime' ? 'selected' : '' }}>Full-time</option>
           <option value="part-time" {{ $editEt==='parttime' ? 'selected' : '' }}>Part-time</option>
         </select>
         <input name="contact" value="{{ $emp->contact ?? '' }}" placeholder="Contact" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
       </div>
       <input name="email" type="email" value="{{ $emp->email ?? '' }}" placeholder="Email" style="padding:8px;border:1px solid #e3e3e0;border-radius:6px" />
       <div style="display:flex;gap:8px;justify-content:flex-end">
         <button type="button" onclick="document.getElementById('edit-emp-{{ $emp->id }}').style.display='none'" style="padding:8px 12px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#1b1b18">Cancel</button>
         <button style="padding:8px 12px;background:#16a34a;color:#fff;border-radius:6px">Save</button>
       </div>
     </form>
   </td>
 </tr>
 @empty
 <tr><td colspan="7" style="padding:8px;color:#706f6c">No employees found.</td></tr>
 @endforelse
 </tbody>
 </table>
 </div>
  <div style="margin-top:12px"></div>
</div>

<div id="mgr-add-emp" class="card" style="display:block;margin-top:12px;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Add New Employee</div>
  <form id="mgr-add-emp-form" method="POST" action="{{ route('manager.employees.store') }}">
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
      <div style="display:flex;gap:8px;justify-content:flex-end">
        <button type="button" onclick="document.getElementById('mgr-add-emp').style.display='none'" style="padding:10px 14px;border:1px solid #e3e3e0;border-radius:8px;background:#fff;color:#1b1b18">Cancel</button>
        <button style="padding:10px 14px;background:#16a34a;color:#fff;border-radius:8px">Add Employee</button>
      </div>
    </div>
  </form>
</div>

<!-- Removed force-hash script to prevent sticky redirect to #employees on refresh -->
