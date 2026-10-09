@extends('layouts.teacher')

@section('title', 'My Assignments - Student Diary')

@section('content')
<div class="flex flex-col w-full gap-space-lg mt-8">
    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden mt-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-space-md border-b border-outline-variant">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">My Assignments</h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">View your assigned classes, sections and subjects.</p>
            </div>
            <span id="assignmentCount" class="font-body-sm text-body-sm text-on-surface-variant">0 assignments</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Subject</th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Class</th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Section</th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Academic Session</th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Status</th>
                    </tr>
                </thead>
                <tbody id="assignmentsTable">
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-on-surface-variant">Loading assignments...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="assignmentFooter" class="px-4 py-3 border-t border-outline-variant text-sm text-on-surface-variant">
        </div>
    </div>
</div>

<div id="toastNotification" class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300">
    <span id="toastIcon" class="material-symbols-outlined text-secondary-fixed text-[20px]">check_circle</span>
    <span id="toastMessage" class="font-body-sm text-body-sm">Operation completed successfully.</span>
</div>

<script>
(async () => {
    const token = localStorage.getItem('student_diary_token');
    const table = document.getElementById('assignmentsTable');
    let assignments = [];

    if (!token) {
        const code = localStorage.getItem('student_diary_institute_code');
        window.location.href = code ? `/login/${code}` : '/';
        return;
    }

    const headers = {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
    };

    const escapeHtml = value => {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    };

    const logout = () => {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.href = '/';
    };

    const showToast = (message, icon = 'check_circle') => {
        const toast = document.getElementById('toastNotification');
        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toastIcon').textContent = icon;
        toast.classList.remove('translate-y-16', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');
        clearTimeout(window.toastTimeout);
        window.toastTimeout = setTimeout(() => {
            toast.classList.add('translate-y-16', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    };

    const statusBadge = active => active
        ? `<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-secondary text-xs font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>Active</span>`
        : `<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-surface-container-low text-on-surface-variant text-xs font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-outline"></span>Inactive</span>`;

    const renderAssignments = () => {

        document.getElementById('assignmentCount').textContent =
            `${assignments.length} ${assignments.length === 1 ? 'assignment' : 'assignments'}`;

        if (!assignments.length) {
            table.innerHTML = `<tr><td colspan="5" class="px-4 py-10 text-center text-on-surface-variant">No assignments match your filters.</td></tr>`;
            return;
        }

        table.innerHTML = assignments.map(item => {
            const active = item.status === true || item.status === 1 || item.status === '1';

            return `
                <tr class="border-t border-outline-variant hover:bg-surface-container-low transition-colors">
                    <td class="px-4 py-3">
                        <div class="font-label-md text-on-surface font-semibold">${escapeHtml(item.subject?.name || '—')}</div>
                        <div class="text-sm text-on-surface-variant">${escapeHtml(item.subject?.code || '')}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-on-surface">${escapeHtml(item.class?.name || item.school_class?.name || '—')}</td>
                    <td class="px-4 py-3 text-sm text-on-surface">${escapeHtml(item.section?.name || '—')}</td>
                    <td class="px-4 py-3 text-sm text-on-surface">${escapeHtml(item.academic_session?.name || '—')}</td>
                    <td class="px-4 py-3">${statusBadge(active)}</td>
                </tr>
            `;
        }).join('');
    };

    try {
        const response = await fetch('/api/v1/teacher/assignments', { headers });

        if (response.status === 401) {
            logout();
            return;
        }

        const result = await response.json();

        if (!response.ok || result.status === false) {
            throw new Error(result.message || 'Failed to load assignments.');
        }

        assignments = result.data || [];

        renderAssignments();
    } catch (error) {
        table.innerHTML = `<tr><td colspan="5" class="px-4 py-10 text-center text-red-600">${escapeHtml(error.message || 'Unable to load assignments.')}</td></tr>`;
        showToast(error.message || 'Unable to load assignments.', 'error');
    }
})();
</script>
@endsection
