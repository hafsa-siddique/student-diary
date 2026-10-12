
@extends('layouts.super-admin')

@section('title', 'Manage Institutes')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-primary">Manage Institutes</h1>
            <p class="mt-1 text-sm text-slate-500">View and manage all registered institutes.</p>
        </div>
        
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="relative overflow-hidden rounded-2xl border border-[#D4E2F4] bg-[#E8F0FA] p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute inset-y-0 left-0 w-1 bg-[#0D3B66]"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total institutes</p>
                    <p id="totalInstitutes" class="mt-2 text-3xl font-bold tracking-tight text-[#0D3B66]">—</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#D4E4F8] text-[#0D3B66]">
                    <span class="material-symbols-rounded">domain</span>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-2xl border border-[#CBE7D8] bg-[#E5F4EC] p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute inset-y-0 left-0 w-1 bg-[#187443]"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Active institutes</p>
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
                    <p class="text-sm font-medium text-slate-500">Inactive institutes</p>
                    <p id="inactiveInstitutes" class="mt-2 text-3xl font-bold tracking-tight text-[#B85C16]">—</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FFE0C2] text-[#B85C16]">
                    <span class="material-symbols-rounded">pause_circle</span>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-5 sm:px-6">
            <div>
                <h3 class="font-bold text-slate-800">All Institutes</h3>
                <p id="instituteCount" class="mt-1 text-sm text-slate-500">Loading institutes...</p>
            </div>
            <a href="" class="inline-flex items-center gap-1 rounded-lg bg-secondary/85 px-4 py-1 text-sm font-semibold text-primary transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                <span class="material-symbols-rounded text-lg">add</span> Add Institute
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Institute</th>
                        <th class="px-6 py-4 font-semibold">Code</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 text-center font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody id="instituteTable">
                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Loading institutes...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-5 py-4">
            <p id="paginationInfo" class="text-sm text-slate-500"></p>
            <div class="flex items-center gap-2">
                <button id="previousPage" type="button" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-[#F4A261] hover:bg-orange-50 disabled:cursor-not-allowed disabled:opacity-40">Previous</button>
                <span id="pageNumber" class="px-2 text-sm font-semibold text-slate-700"></span>
                <button id="nextPage" type="button" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-[#F4A261] hover:bg-orange-50 disabled:cursor-not-allowed disabled:opacity-40">Next</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let currentPage = 1;
    const table = document.getElementById('instituteTable');

    document.getElementById('previousPage').addEventListener('click', () => {
        if (currentPage > 1) loadInstitutes(currentPage - 1);
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        loadInstitutes(currentPage + 1);
    });

    async function loadInstitutes(page = 1) {
        const token = localStorage.getItem('student_diary_token');
        table.innerHTML = '<tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Loading institutes...</td></tr>';

        try {
            const response = await fetch(`/api/v1/super-admin/institutes?per_page=10&page=${page}`, {
                headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
            });

            if (!response.ok) throw new Error('Failed to load institutes');

            const result = await response.json();
            const stats = result.statistics;
            const pagination = result.pagination;
            currentPage = pagination.current_page;

            document.getElementById('totalInstitutes').textContent = stats.total;
            document.getElementById('activeInstitutes').textContent = stats.active;
            document.getElementById('inactiveInstitutes').textContent = stats.inactive;
            document.getElementById('instituteCount').textContent = `${pagination.total} institutes registered`;
            document.getElementById('paginationInfo').textContent = pagination.total
                ? `Showing ${(currentPage - 1) * pagination.per_page + 1}–${Math.min(currentPage * pagination.per_page, pagination.total)} of ${pagination.total}`
                : 'No institutes found';
            document.getElementById('pageNumber').textContent = `Page ${currentPage} of ${pagination.last_page}`;
            document.getElementById('previousPage').disabled = currentPage <= 1;
            document.getElementById('nextPage').disabled = currentPage >= pagination.last_page;

            table.replaceChildren();

            if (!result.data.length) {
                table.innerHTML = '<tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">No institutes found.</td></tr>';
                return;
            }

            result.data.forEach(institute => {
                const row = document.createElement('tr');
                row.className = 'border-t border-slate-100 transition-colors hover:bg-slate-50/70';

                [institute.name, institute.code].forEach(value => {
                    const cell = document.createElement('td');
                    cell.className = 'px-6 py-4 text-slate-700';
                    cell.textContent = value ?? '—';
                    row.appendChild(cell);
                });

                const isActive = [1, true, '1', 'active'].includes(
                    typeof institute.status === 'string' ? institute.status.toLowerCase() : institute.status
                );

                const statusCell = document.createElement('td');
                statusCell.className = 'px-6 py-4';
                const badge = document.createElement('span');
                badge.className = `rounded-full px-3 py-1 text-xs font-semibold ${isActive ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-700'}`;
                badge.textContent = isActive ? 'Active' : 'Inactive';
                statusCell.appendChild(badge);
                row.appendChild(statusCell);

                const actionCell = document.createElement('td');
                actionCell.className = 'px-6 py-4 text-center';

                const viewButton = document.createElement('a');
                viewButton.href = `/super-admin/institutes/${encodeURIComponent(institute.id)}`;
                viewButton.className = 'inline-flex items-center rounded-lg p-2 text-slate-600 transition hover:text-secondary';
                viewButton.title = 'View institute';
                viewButton.setAttribute('aria-label', `View ${institute.name}`);
                viewButton.innerHTML = '<span class="material-symbols-rounded">visibility</span>';
                actionCell.appendChild(viewButton);

                const statusButton = document.createElement('button');
                statusButton.type = 'button';
                statusButton.className = 'ml-1 inline-flex items-center rounded-lg p-2 text-slate-600 transition hover:text-secondary';
                statusButton.title = isActive ? 'Deactivate institute' : 'Activate institute';
                statusButton.setAttribute('aria-label', statusButton.title);
                statusButton.innerHTML = `<span class="material-symbols-rounded">${isActive ? 'person_off' : 'how_to_reg'}</span>`;
                statusButton.addEventListener('click', () => toggleInstituteStatus(institute, badge, statusButton));
                actionCell.appendChild(statusButton);

                row.appendChild(actionCell);
                table.appendChild(row);
            });
        } catch (error) {
            console.error(error);
            table.innerHTML = '<tr><td colspan="4" class="px-6 py-12 text-center text-red-500">Unable to load institutes. Please check your login and try again.</td></tr>';
            document.getElementById('instituteCount').textContent = 'Unable to load institutes';
        }
    }

    loadInstitutes();
    async function toggleInstituteStatus(institute, badge, button) {
        const token = localStorage.getItem('student_diary_token');
        button.disabled = true;
        try {
            const response = await fetch(`/api/v1/super-admin/institutes/${institute.id}/status`, {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Failed to update institute status');
            const isActive = [1, true, '1', 'active'].includes(
                typeof result.data.status === 'string' ? result.data.status.toLowerCase() : result.data.status
            );
            institute.status = result.data.status;
            badge.className = `rounded-full px-3 py-1 text-xs font-semibold ${isActive ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-700'}`;
            badge.textContent = isActive ? 'Active' : 'Inactive';
            button.title = isActive ? 'Deactivate institute' : 'Activate institute';
            button.setAttribute('aria-label', button.title);
            button.innerHTML = `<span class="material-symbols-rounded">${isActive ? 'person_off' : 'how_to_reg'}</span>`;
        } catch (error) {
            console.error(error);
            alert(error.message || 'Unable to update institute status.');
        } finally {
            button.disabled = false;
        }
    }
});
</script>
@endsection
