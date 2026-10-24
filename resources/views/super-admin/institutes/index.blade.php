
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
            <button type="button" onclick="openAddInstituteModal()" class="inline-flex items-center gap-1 rounded-lg bg-secondary/85 px-4 py-1 text-sm font-semibold text-primary transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                <span class="material-symbols-rounded text-lg">add</span> Add Institute
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">
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

<!-- Add Institute Modal -->
<div id="addInstituteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div class="relative w-full max-w-xl rounded-2xl bg-white p-6 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <h3 class="font-bold text-slate-800 text-lg">Add New Institute</h3>
            <button type="button" onclick="closeAddInstituteModal()" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 transition">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>

        <form id="addInstituteForm" onsubmit="submitNewInstitute(event)" class="space-y-4">
            <!-- Section 1: Institute Information -->
            <div class="space-y-3">
                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-400">Institute Info</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Institute Name *</label>
                        <input type="text" id="add_inst_name" required placeholder="e.g. Beaconhouse Campus" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Institute Code *</label>
                        <input type="text" id="add_inst_code" required placeholder="e.g. BHC-01" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:border-primary focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Section 2: Administrator Account -->
            <div class="space-y-3 pt-2">
                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-400">Institute Admin Account</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Admin Name *</label>
                        <input type="text" id="add_admin_name" required placeholder="Full Name" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Admin Email *</label>
                        <input type="email" id="add_admin_email" required placeholder="admin@institute.com" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:border-primary focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Admin Password *</label>
                    <input type="password" id="add_admin_password" required placeholder="Minimum 8 characters" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-800 focus:border-primary focus:outline-none">
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeAddInstituteModal()" class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                <button type="submit" class="rounded-xl bg-primary px-5 py-2 text-xs font-semibold text-white shadow-sm hover:brightness-110 transition">Create Institute</button>
            </div>
        </form>
    </div>
</div>

<div id="toastNotification" class="fixed bottom-5 right-5 z-50 hidden transform translate-y-2 opacity-0 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700">
    <span id="toastIcon" class="material-symbols-rounded text-emerald-400 text-xl">check_circle</span>
    <p id="toastMessage" class="text-sm font-medium">Institute Saved successfully!</p>
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
            const response = await fetch(`/api/v1/super-admin/institutes?per_page=5&page=${page}`, {
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
                row.className = 'border-t border-slate-300 transition-colors hover:bg-slate-50/70';

                [institute.name, institute.code].forEach(value => {
                    const cell = document.createElement('td');
                    cell.className = 'px-6 py-2 text-slate-700';
                    cell.textContent = value ?? '—';
                    row.appendChild(cell);
                });

                const isActive = [1, true, '1', 'active'].includes(
                    typeof institute.status === 'string' ? institute.status.toLowerCase() : institute.status
                );

                const statusCell = document.createElement('td');
                statusCell.className = 'px-6 py-2';
                const badge = document.createElement('span');
                badge.className = `rounded-full px-3 py-1 text-xs font-semibold ${isActive ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-700'}`;
                badge.textContent = isActive ? 'Active' : 'Inactive';
                statusCell.appendChild(badge);
                row.appendChild(statusCell);

                const actionCell = document.createElement('td');
                actionCell.className = 'px-6 py-2 text-center relative';

                const dropdownWrapper = document.createElement('div');
                dropdownWrapper.className = 'relative inline-block text-left';

                const dotsButton = document.createElement('button');
                dotsButton.type = 'button';
                dotsButton.className = 'inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition';
                dotsButton.innerHTML = '<span class="material-symbols-rounded">more_vert</span>';

                const dropdownMenu = document.createElement('div');
                dropdownMenu.className = 'hidden absolute right-0 mt-2 w-44 rounded-xl bg-white shadow-xl border border-slate-200 z-50 py-1 text-left';

                const viewOption = document.createElement('a');
                viewOption.href = `/super-admin/institutes/${encodeURIComponent(institute.id)}/view`;
                viewOption.className = 'w-full flex items-center gap-2 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition';
                viewOption.innerHTML = '<span class="material-symbols-rounded text-sm text-slate-500">visibility</span> View Details';
                dropdownMenu.appendChild(viewOption);

                const statusOption = document.createElement('button');
                statusOption.type = 'button';
                statusOption.className = 'w-full flex items-center gap-2 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition';
                statusOption.innerHTML = `<span class="material-symbols-rounded text-sm text-slate-500">${isActive ? 'person_off' : 'how_to_reg'}</span> ${isActive ? 'Deactivate' : 'Activate'}`;
                statusOption.addEventListener('click', () => {
                    toggleInstituteStatus(institute, badge, statusOption);
                    dropdownMenu.classList.add('hidden');
                });
                dropdownMenu.appendChild(statusOption);

                const impersonateOption = document.createElement('button');
                impersonateOption.type = 'button';
                impersonateOption.className = 'ml-2 inline-flex items-center gap-1 rounded-lg bg-primary px-3 py-1.5 text-xs font-semibold text-white transition hover:brightness-110';
                impersonateOption.innerHTML = '<span class="material-symbols-rounded text-sm">login</span> Login as Admin';
                impersonateOption.addEventListener('click', () => impersonateInstitute(institute.id));
                dropdownMenu.appendChild(impersonateOption);

                dotsButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.querySelectorAll('.absolute.right-0').forEach(menu => {
                        if (menu !== dropdownMenu) menu.classList.add('hidden');
                    });
                    dropdownMenu.classList.toggle('hidden');
                });
                dropdownWrapper.appendChild(dotsButton);
                dropdownWrapper.appendChild(dropdownMenu);
                actionCell.appendChild(dropdownWrapper);
                row.appendChild(actionCell);
                table.appendChild(row);
            });
        } catch (error) {
            console.error(error);
            table.innerHTML = '<tr><td colspan="4" class="px-6 py-12 text-center text-red-500">Unable to load institutes. Please check your login and try again.</td></tr>';
            document.getElementById('instituteCount').textContent = 'Unable to load institutes';
        }
    }
    window.addEventListener('click', () => {
        document.querySelectorAll('.absolute.right-0').forEach(menu => {
            menu.classList.add('hidden');
        });
    });
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
function openAddInstituteModal() {
    document.getElementById('addInstituteForm').reset();
    document.getElementById('addInstituteModal').classList.remove('hidden');
}

function closeAddInstituteModal() {
    document.getElementById('addInstituteModal').classList.add('hidden');
}
async function submitNewInstitute(e) {
    e.preventDefault();
    const token = localStorage.getItem('student_diary_token');

    const payload = {
        name: document.getElementById('add_inst_name').value,
        code: document.getElementById('add_inst_code').value,
        admin_name: document.getElementById('add_admin_name').value,
        admin_email: document.getElementById('add_admin_email').value,
        admin_password: document.getElementById('add_admin_password').value,
    };

    try {
        const response = await fetch('/api/v1/super-admin/institutes/complete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Failed to create institute.');

        showToast('Institute and admin created successfully!');
        closeAddInstituteModal();
        
        if (typeof fetchInstitutesList === 'function') fetchInstitutesList();
    } catch (error) {
        showToast(error.message, true);
    }
}
function showToast(message, isError = false) {
    const toast = document.getElementById('toastNotification');
    const msgEl = document.getElementById('toastMessage');
    const iconEl = document.getElementById('toastIcon');

    msgEl.textContent = message;
    if (isError) {
        iconEl.textContent = 'error';
        iconEl.className = 'material-symbols-rounded text-red-400 text-xl';
        toast.className = 'fixed bottom-5 right-5 z-50 transform translate-y-0 opacity-100 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-red-500/50';
    } else {
        iconEl.textContent = 'check_circle';
        iconEl.className = 'material-symbols-rounded text-emerald-400 text-xl';
        toast.className = 'fixed bottom-5 right-5 z-50 transform translate-y-0 opacity-100 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700';
    }

    // Auto-hide after 3.5 seconds
    setTimeout(() => {
        toast.className = 'fixed bottom-5 right-5 z-50 hidden transform translate-y-2 opacity-0 transition-all duration-300 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700';
    }, 3500);
}
async function impersonateInstitute(instituteId) {
    const token = localStorage.getItem('student_diary_token');
    
    try {
        const response = await fetch(`/api/v1/super-admin/institutes/${instituteId}/impersonate`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        });

        const result = await response.json();
        if (!response.ok || !result.status) {
            throw new Error(result.message || 'Failed to impersonate institute admin.');
        }
        localStorage.setItem('backup_super_admin_token', token);
        localStorage.setItem('student_diary_token', result.token);
        localStorage.setItem('student_diary_user', JSON.stringify(result.user));
        localStorage.setItem('is_impersonating', 'true');

        showToast('Successfully switched to institute admin view!');
                setTimeout(() => {
            window.location.href = '/admin/dashboard'; 
        }, 800);

    } catch (error) {
        console.error(error);
        showToast(error.message, true);
    }
}
</script>
@endsection
