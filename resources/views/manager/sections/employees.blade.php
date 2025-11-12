<div style="background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
 <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
   <div>
     <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Employee Management</div>
     <div style="font-size:12px;color:#6b7280">View and manage employee information</div>
   </div>
   <button type="button" onclick="toggleMgrAddEmp()" style="display:inline-flex;align-items:center;gap:8px;background:#0ea5e9;color:#fff;border-radius:8px;padding:8px 12px;border:1px solid #7dd3fc">
     <span aria-hidden="true">＋</span>
     <span>Add Employee</span>
   </button>
 </div>
 <div style="display:grid;gap:12px;grid-template-columns:repeat(3,minmax(0,1fr));margin-bottom:12px">
   @php
     $empCollection = collect($employees ?? []);
     $empTotal = $empCollection->count();
     $empFull = $empCollection->filter(fn($e)=>strtolower($e->employment_type ?? '')==='fulltime')->count();
     $empPart = $empCollection->filter(fn($e)=>strtolower($e->employment_type ?? '')==='parttime')->count();
   @endphp
   <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
     <div>
       <div style="font-size:12px;color:#0f172a;margin-bottom:4px">Total Employees</div>
       <div style="font-size:26px;font-weight:800;color:#0f172a">{{ (int)$empTotal }}</div>
     </div>
     <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:#4338ca;border:1px solid #dbe2ff">👥</div>
   </div>
   <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
     <div>
       <div style="font-size:12px;color:#065f46;margin-bottom:4px">Full-Time</div>
       <div style="font-size:26px;font-weight:800;color:#065f46">{{ (int)$empFull }}</div>
     </div>
     <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#ecfdf5;color:#047857;border:1px solid #bbf7d0">👤</div>
   </div>
   <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between">
     <div>
       <div style="font-size:12px;color:#9a3412;margin-bottom:4px">Part-Time</div>
       <div style="font-size:26px;font-weight:800;color:#9a3412">{{ (int)$empPart }}</div>
     </div>
     <div aria-hidden="true" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#fffbeb;color:#b45309;border:1px solid #fed7aa">👥</div>
   </div>
 </div>
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
     <form class="mgr-del-form" method="POST" action="{{ route('manager.employees.delete', ['id'=>$emp->id]) }}" style="margin:0">
       @csrf
       <button style="padding:6px;border:1px solid #e3e3e0;border-radius:6px;background:#fff;color:#b91c1c" data-confirm="Delete this employee?">🗑</button>
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

<div id="mgr-add-emp" class="card" style="display:none;margin-top:12px;background:#fff;border:1px solid #e3e3e0;padding:16px;border-radius:12px">
  <div style="font-weight:700;color:#0f172a;margin-bottom:4px">Add New Employee</div>
  <form id="mgr-add-emp-form" method="POST" action="{{ route('manager.employees.store') }}">
    @csrf
    <div style="display:grid;gap:10px">
      <!-- Row 1: Name, Employment Type, Position (match owner layout proportions) -->
      <div style="display:grid;gap:6px;grid-template-columns:1.2fr 1fr 1fr">
        <input name="name" placeholder="Full name" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        <!-- Manager expects 'status' values 'full-time'|'part-time' → map to owner-style Employment Type label -->
        <select name="status" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px">
          <option value="full-time">Full-time</option>
          <option value="part-time">Part-time</option>
        </select>
        <input name="role" placeholder="Position" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
      </div>
      <!-- Row 2: Birthday, Email, Contact, Join Date (owner-style grid) -->
      <div style="display:grid;gap:6px;grid-template-columns:1fr 1fr 1fr 1fr">
        <input name="birthday" type="date" placeholder="Birthday" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        <input name="email" type="email" placeholder="Email" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        <input name="contact" placeholder="Contact" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
        <input name="join_date" type="date" placeholder="Join date" style="padding:10px;border:1px solid #e3e3e0;border-radius:8px" />
      </div>
      <div style="display:flex;gap:8px;justify-content:flex-end">
        <button type="button" onclick="document.getElementById('mgr-add-emp').style.display='none'" style="padding:10px 14px;border:1px solid #e3e3e0;border-radius:8px;background:#fff;color:#1b1b18">Cancel</button>
        <button style="padding:10px 14px;background:#16a34a;color:#fff;border-radius:8px">Add Employee</button>
      </div>
    </div>
  </form>
</div>

<script>
  function toggleMgrAddEmp(){
    var el = document.getElementById('mgr-add-emp');
    if(!el) return;
    el.style.display = (el.style.display==='none' || el.style.display==='') ? 'block' : 'none';
  }
</script>
<!-- Removed force-hash script to prevent sticky redirect to #employees on refresh -->
