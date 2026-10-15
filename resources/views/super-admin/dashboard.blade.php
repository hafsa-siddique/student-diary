@extends('layouts.super-admin')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
    <div>
        <h1 class="text-2xl font-bold text-primary">Welcome to Student Diary</h1>
        <p class="mt-1 text-sm text-slate-500">Manage institutes, oversee platform activity, and keep your school diary ecosystem organized from one place.</p>
    </div>
</div>

<section>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="group relative overflow-hidden rounded-2xl border border-[#D4E2F4] bg-[#E8F0FA] p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute inset-y-0 left-0 w-1 bg-[#0D3B66]"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total institutes</p>
                    <p id="totalInstitutes" class="mt-2 text-3xl font-bold tracking-tight text-slate-800">—</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-primary">
                    <span class="material-symbols-rounded">domain</span>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-2xl border border-[#CBE7D8] bg-[#E5F4EC] p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute inset-y-0 left-0 w-1 bg-[#187443]"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Active institutes</p>
                    <p id="activeInstitutes" class="mt-2 text-3xl font-bold tracking-tight text-[#187443]">—</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#CDEBDD] text-[#187443]">
                    <span class="material-symbols-rounded">check_circle</span>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-2xl border border-[#F6D8BB] bg-[#FFF0E3] p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute inset-y-0 left-0 w-1 bg-[#B85C16]"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Inactive institutes</p>
                    <p id="inactiveInstitutes" class="mt-2 text-3xl font-bold tracking-tight text-[#B85C16]">—</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FFE0C2] text-[#B85C16]">
                    <span class="material-symbols-rounded">pause_circle</span>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-2xl border border-[#E0D3F0] bg-[#F0EAF8] p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute inset-y-0 left-0 w-1 bg-[#68428B]"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Active institute rate</p>
                    <p id="instituteSummary" class="mt-2 text-3xl font-bold tracking-tight text-[#68428B]">—</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E3D6F3] text-[#68428B]">
                    <span class="material-symbols-rounded">monitoring</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white xl:col-span-2 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-5 sm:px-6">
            <div>
                <h3 class="font-bold text-slate-800">Institute Management</h3>
                <p class="mt-1 text-sm text-slate-500">Review institute records and their current status.</p>
            </div>
            <a href="{{ url('/super-admin/institutes') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:text-secondary">
                View all <span class="material-symbols-rounded">arrow_forward</span>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[540px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-2 font-semibold">Institute</th>
                        <th class="px-6 py-2 font-semibold">Code</th>
                        <th class="px-6 py-2 font-semibold">Status</th>
                        <th class="px-6 py-2 text-center font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody id="instituteTable">
                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Loading institutes...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6 mb-6">
        <h3 class="font-bold text-slate-800">Quick Actions</h3>
        <p class="mt-1 text-sm text-slate-500">Common platform tasks.</p>
        <div class="mt-5 space-y-3">
            <a href="{{ url('/super-admin/institutes') }}" class="group flex items-center gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-primary/30 hover:bg-blue-50/50">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-primary"><span class="material-symbols-rounded">add_business</span></span>
                <span class="min-w-0 flex-1"><span class="block text-sm font-semibold">Manage Institutes</span><span class="mt-1 block text-xs text-slate-500">Create or update institutes</span></span>
                <span class="material-symbols-rounded text-slate-400 group-hover:text-primary">chevron_right</span>
            </a>
            <a href="{{ url('/super-admin/configurations') }}" class="group flex items-center gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-primary/30 hover:bg-blue-50/50">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600"><span class="material-symbols-rounded">settings</span></span>
                <span class="min-w-0 flex-1"><span class="block text-sm font-semibold">Platform Settings</span><span class="mt-1 block text-xs text-slate-500">Review configuration options</span></span>
                <span class="material-symbols-rounded text-slate-400 group-hover:text-primary">chevron_right</span>
            </a>
            <div class="flex items-center gap-3 rounded-xl border border-slate-200 p-4">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><span class="material-symbols-rounded">verified_user</span></span>
                <span><span class="block text-sm font-semibold">Access Control</span><span class="mt-1 block text-xs text-slate-500">Super Admin role</span></span>
            </div>
        </div>

        <div class="mt-5 rounded-xl bg-[#FFF5EA] p-4">
            <div class="flex gap-3">
                <span class="material-symbols-rounded text-[#C77932]">info</span>
                <div>
                    <p class="text-sm font-semibold text-primary">Platform tip</p>
                    <p class="mt-1 text-xs leading-5 text-slate-600">Deactivate an institute when it should no longer access the platform, instead of deleting records you may need later.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', loadInstituteStats);

const isInstituteActive = status => [1, true, '1', 'active'].includes(
    typeof status === 'string' ? status.toLowerCase() : status
);

async function loadInstituteStats() {
    const token = localStorage.getItem('student_diary_token');
    const table = document.getElementById('instituteTable');

    try {
        const response = await fetch('/api/v1/super-admin/institutes', {
            headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
        });
        if (!response.ok) throw new Error('Failed to load institutes');

        const result = await response.json();
        const stats = result.statistics;

        document.getElementById('totalInstitutes').textContent = stats.total;
        document.getElementById('activeInstitutes').textContent = stats.active;
        document.getElementById('inactiveInstitutes').textContent = stats.inactive;
        document.getElementById('instituteSummary').textContent = stats.total
            ? `${Math.round(stats.active / stats.total * 100)}%`
            : '0%';

        table.replaceChildren();

        if (!result.data?.length) {
            table.innerHTML = '<tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">No institutes found.</td></tr>';
            return;
        }

        result.data.forEach(institute => {
            const row = document.createElement('tr');
            row.className = 'border-t border-slate-300';

            [institute.name, institute.code].forEach(value => {
                const cell = document.createElement('td');
                cell.className = 'px-6 py-2 text-slate-700';
                cell.textContent = value ?? '—';
                row.appendChild(cell);
            });

            const isActive = isInstituteActive(institute.status);
            const statusCell = document.createElement('td');
            statusCell.className = 'px-6 py-2';

            const badge = document.createElement('span');
            badge.className = `rounded-full px-3 py-1 text-xs font-semibold ${isActive ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-700'}`;
            badge.textContent = isActive ? 'Active' : 'Inactive';
            statusCell.appendChild(badge);
            row.appendChild(statusCell);

            const actionCell = document.createElement('td');
            actionCell.className = 'px-6 py-2 text-center';

            const viewButton = document.createElement('a');
            viewButton.href = `/super-admin/institutes/${encodeURIComponent(institute.id)}/view`;
            viewButton.className = 'p-2 rounded-lg text-on-surface-variant hover:text-secondary inline-flex items-center';
            viewButton.title = 'View institute';
            viewButton.innerHTML = '<span class="material-symbols-rounded text-[20px]">visibility</span>';
            actionCell.appendChild(viewButton);

            const statusButton = document.createElement('button');
            statusButton.type = 'button';
            statusButton.className = 'ml-1 p-2 rounded-lg text-on-surface-variant hover:text-secondary';
            statusButton.title = isActive ? 'Deactivate' : 'Activate';
            statusButton.innerHTML = `<span class="material-symbols-rounded text-[20px]">${isActive ? 'person_off' : 'how_to_reg'}</span>`;
            statusButton.onclick = () => toggleInstituteStatus(institute, badge, statusButton);
            actionCell.appendChild(statusButton);

            row.appendChild(actionCell);
            table.appendChild(row);
        });
    } catch (error) {
        console.error(error);
        table.innerHTML = '<tr><td colspan="4" class="px-6 py-12 text-center text-red-500">Unable to load institutes.</td></tr>';
    }
}

async function toggleInstituteStatus(institute, badge, button) {
    const token = localStorage.getItem('student_diary_token');
    const isActive = isInstituteActive(institute.status);
    button.disabled = true;

    try {
        const response = await fetch(`/api/v1/super-admin/institutes/${encodeURIComponent(institute.id)}/status`, {
            method: 'PATCH',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        });

        const result = await response.json();
        if (!response.ok || !result.status) throw new Error(result.message || 'Unable to update institute status.');

        institute.status = result.data.status;
        const updatedIsActive = isInstituteActive(institute.status);

        badge.className = `rounded-full px-3 py-1 text-xs font-semibold ${updatedIsActive ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-700'}`;
        badge.textContent = updatedIsActive ? 'Active' : 'Inactive';

        button.innerHTML = `<span class="material-symbols-rounded text-[20px]">${updatedIsActive ? 'person_off' : 'how_to_reg'}</span>`;
        button.title = updatedIsActive ? 'Deactivate' : 'Activate';

        await loadInstituteStats();
    } catch (error) {
        alert(error.message || 'Unable to update institute status.');
    } finally {
        button.disabled = false;
    }
}
</script>
@endsection
