@extends('layouts.teacher')

@section('title', 'Scheduled Diaries - Student Diary')

@section('content')

<div class="flex flex-col w-full gap-space-lg">

    <!-- Scheduled Diaries Table -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden mt-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-space-md border-b border-outline-variant">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">
                    Scheduled Diaries
                </h2>

                <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                    Only your scheduled diary entries are shown here.
                </p>
            </div>

            <span id="diaryCount"
                  class="font-body-sm text-body-sm text-on-surface-variant">
                0 scheduled diaries
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Subject
                        </th>

                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Class / Section
                        </th>

                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Diary Date
                        </th>

                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Scheduled At
                        </th>

                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Status
                        </th>

                        <th class="text-right px-4 py-3 font-label-sm text-label-sm text-outline">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody id="scheduledDiariesTable">
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-on-surface-variant">
                            Loading scheduled diaries...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination"
             class="flex items-center justify-between gap-3 px-4 py-3 border-t border-outline-variant">
        </div>
    </div>
</div>

<!-- Edit Schedule Modal -->
<div id="editScheduleModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
     role="dialog"
     aria-modal="true">

    <div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">

        <div class="flex items-center justify-between border-b border-outline-variant p-5">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">
                    Edit Schedule
                </h2>

                <p class="mt-1 text-sm text-on-surface-variant">
                    Change when this diary should be published.
                </p>
            </div>

            <button type="button"
                    id="closeEditScheduleModal"
                    class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="p-5">

            <div class="mb-4 rounded-lg bg-surface-container-low p-3">
                <p id="scheduleDiarySubject"
                   class="font-label-md text-label-md text-on-surface font-semibold">
                    —
                </p>

                <p id="scheduleDiaryClass"
                   class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                    —
                </p>
            </div>

            <label for="editScheduledAt"
                   class="mb-1 block text-sm font-medium text-on-surface">
                Scheduled Date & Time *
            </label>

            <input type="datetime-local"
                   id="editScheduledAt"
                   class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">

            <div id="scheduleError"
                 class="hidden mt-3 rounded-lg bg-red-50 p-3 text-sm text-red-700">
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t border-outline-variant p-5">
            <button type="button"
                    id="cancelEditSchedule"
                    class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                Cancel
            </button>

            <button type="button"
                    id="saveSchedule"
                    class="flex items-center gap-2 rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-60">
                Save Schedule
            </button>
        </div>
    </div>
</div>

<!-- Toast -->
<div
    id="toastNotification"
    class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300">

    <span id="toastIcon" class="material-symbols-outlined text-secondary-fixed text-[20px]">
        check_circle
    </span>

    <span id="toastMessage" class="font-body-sm text-body-sm">
        Operation completed successfully.
    </span>
</div>

<script>
(async () => {
    const token = localStorage.getItem('student_diary_token');

    if (!token) {
        const code = localStorage.getItem('student_diary_institute_code');
        window.location.href = code ? `/login/${code}` : '/';
        return;
    }

    const headers = {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    let currentPage = 1;
    let currentDiary = null;

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
        if (!toast) return;

        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toastIcon').textContent = icon;

        toast.classList.remove(
            'translate-y-16',
            'opacity-0',
            'pointer-events-none'
        );

        toast.classList.add(
            'translate-y-0',
            'opacity-100'
        );

        clearTimeout(window.toastTimeout);

        window.toastTimeout = setTimeout(() => {
            toast.classList.add(
                'translate-y-16',
                'opacity-0',
                'pointer-events-none'
            );

            toast.classList.remove(
                'translate-y-0',
                'opacity-100'
            );
        }, 3000);
    };

    const formatDate = date => {
        if (!date) return '—';

        const value = String(date);
        const isoMatch = value.match(/^(\d{4})-(\d{2})-(\d{2})/);

        if (isoMatch) {
            const [, year, month, day] = isoMatch;

            return new Date(
                Number(year),
                Number(month) - 1,
                Number(day)
            ).toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        }

        return value;
    };

    const statusBadge = () => `
        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full
                      text-primary
                     font-label-sm text-label-sm font-semibold">
            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
            Scheduled
        </span>
    `;

    const parseScheduledDate = value => {
        if (!value) return '';

        const match = String(value).match(
            /^(\d{2})-(\d{2})-(\d{4})\s+(\d{1,2}):(\d{2})\s+(AM|PM)$/i
        );

        if (!match) return '';

        let [, day, month, year, hour, minute, period] = match;

        hour = Number(hour);

        if (period.toUpperCase() === 'PM' && hour !== 12) {
            hour += 12;
        }

        if (period.toUpperCase() === 'AM' && hour === 12) {
            hour = 0;
        }

        return `${year}-${month}-${day}T${String(hour).padStart(2, '0')}:${minute}`;
    };

    const formatScheduledAt = value => {
        if (!value) return '—';
        return value;
    };

    const loadScheduledDiaries = async page => {
        try {
            const response = await fetch(
                `/api/v1/teacher/diaries?status=scheduled&page=${page}`,
                { headers }
            );

            if (response.status === 401) {
                logout();
                return;
            }

            const result = await response.json();

            if (!response.ok) {
                throw new Error(
                    result.message || 'Failed to load scheduled diaries.'
                );
            }

            currentPage = result.pagination?.current_page || page;

            renderDiaries(result);
        } catch (error) {
            console.error('Scheduled diaries error:', error);

            document.getElementById('scheduledDiariesTable').innerHTML = `
                <tr>
                    <td colspan="6"
                        class="px-4 py-10 text-center text-red-600">
                        Unable to load scheduled diaries.
                    </td>
                </tr>
            `;
        }
    };

    const renderDiaries = result => {
        const container = document.getElementById('scheduledDiariesTable');
        const diaries = result.data || [];
        const pagination = result.pagination || {};

        window.currentScheduledDiaries = diaries;

        const total = pagination.total ?? diaries.length;
        document.getElementById('diaryCount').textContent =
            `${total} scheduled ${total === 1 ? 'diary' : 'diaries'}`;

        if (!diaries.length) {
            container.innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center">
                        <div class="flex flex-col items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[36px]">
                                schedule
                            </span>

                            <span class="font-body-sm text-body-sm">
                                No scheduled diaries found.
                            </span>
                        </div>
                    </td>
                </tr>
            `;

            renderPagination(pagination);
            return;
        }

        container.innerHTML = diaries.map(diary => `
            <tr class="border-t border-outline-variant hover:bg-surface-container-low transition-colors">

                <td class="px-4 py-3">
                    <div class="font-label-md text-label-md text-on-surface font-semibold">
                        ${escapeHtml(diary.subject?.name || '—')}
                    </div>

                    <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                        ${escapeHtml(diary.classwork || 'No classwork added')}
                    </div>
                </td>

                <td class="px-4 py-3">
                    <div class="font-label-md text-label-md text-on-surface">
                        ${escapeHtml(diary.class?.name || '—')}
                    </div>

                    <div class="font-body-sm text-body-sm text-on-surface-variant">
                        ${escapeHtml(diary.section?.name || '—')}
                    </div>
                </td>

                <td class="px-4 py-3">
                    <span class="font-body-sm text-body-sm text-on-surface">
                        ${escapeHtml(formatDate(diary.diary_date))}
                    </span>
                </td>

                <td class="px-4 py-3">
                    <div class="font-label-md text-label-md text-on-surface font-semibold">
                        ${escapeHtml(formatScheduledAt(diary.scheduled_at))}
                    </div>
                </td>

                <td class="px-4 py-3">
                    ${statusBadge()}
                </td>

                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-1">

                        <button
                            type="button"
                            title="Edit Schedule"
                            data-action="edit"
                            data-id="${diary.id}"
                            class="flex items-center justify-center w-9 h-9 rounded-lg
                                   text-primary hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[19px]">
                                edit_calendar
                            </span>
                        </button>

                        <button
                            type="button"
                            title="Publish Now"
                            data-action="publish"
                            data-id="${diary.id}"
                            class="flex items-center justify-center w-9 h-9 rounded-lg
                                   text-secondary hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[19px]">
                                publish
                            </span>
                        </button>

                    </div>
                </td>
            </tr>
        `).join('');

        renderPagination(pagination);
    };

    const renderPagination = pagination => {
        const container = document.getElementById('pagination');

        if (!pagination.last_page || pagination.last_page <= 1) {
            container.innerHTML = '';
            return;
        }

        const current = pagination.current_page || 1;
        const last = pagination.last_page || 1;

        container.innerHTML = `
            <div class="text-sm text-on-surface-variant">
                Page ${current} of ${last}
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="button"
                    data-page="${current - 1}"
                    ${current <= 1 ? 'disabled' : ''}
                    class="px-3 py-1.5 rounded-lg border border-outline-variant
                           text-sm text-on-surface disabled:opacity-40
                           disabled:cursor-not-allowed hover:bg-surface-container-low">
                    Previous
                </button>

                <button
                    type="button"
                    data-page="${current + 1}"
                    ${current >= last ? 'disabled' : ''}
                    class="px-3 py-1.5 rounded-lg border border-outline-variant
                           text-sm text-on-surface disabled:opacity-40
                           disabled:cursor-not-allowed hover:bg-surface-container-low">
                    Next
                </button>
            </div>
        `;
    };

    const updateDiary = async (diary, status, scheduledAt = null) => {
        const payload = {
            teacher_assignment_id: diary.teacher_assignment_id,
            diary_date: diary.diary_date,
            classwork: diary.classwork || null,
            homework: diary.homework || null,
            instructions: diary.instructions || null,
            due_date: diary.due_date || null,
            status,
            scheduled_at: scheduledAt
        };

        const response = await fetch(
            `/api/v1/teacher/diaries/${diary.id}`,
            {
                method: 'PUT',
                headers,
                body: JSON.stringify(payload)
            }
        );

        if (response.status === 401) {
            logout();
            return null;
        }

        const result = await response.json();

        if (!response.ok) {
            const errors = result.errors
                ? Object.values(result.errors).flat().join(' ')
                : result.message || 'Failed to update diary.';

            throw new Error(errors);
        }

        return result;
    };

    const openEditScheduleModal = diary => {
        currentDiary = diary;

        document.getElementById('scheduleDiarySubject').textContent =
            diary.subject?.name || '—';

        document.getElementById('scheduleDiaryClass').textContent =
            `${diary.class?.name || '—'} · Section ${diary.section?.name || '—'}`;

        document.getElementById('editScheduledAt').value =
            parseScheduledDate(diary.scheduled_at);

        document.getElementById('scheduleError').classList.add('hidden');

        document.getElementById('editScheduleModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    const closeEditScheduleModal = () => {
        currentDiary = null;

        document.getElementById('editScheduleModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    const publishDiary = async diary => {
        if (!confirm('Are you sure you want to publish this diary now?')) {
            return;
        }

        try {
            const result = await updateDiary(diary, 'published');

            showToast(
                result?.message || 'Diary published successfully.',
                'check_circle'
            );

            await loadScheduledDiaries(currentPage);
        } catch (error) {
            showToast(error.message, 'error');
        }
    };

    const saveSchedule = async () => {
        if (!currentDiary) return;

        const input = document.getElementById('editScheduledAt');
        const errorBox = document.getElementById('scheduleError');
        const button = document.getElementById('saveSchedule');

        errorBox.textContent = '';
        errorBox.classList.add('hidden');

        if (!input.value) {
            errorBox.textContent = 'Please select the scheduled date and time.';
            errorBox.classList.remove('hidden');
            return;
        }

        if (new Date(input.value) <= new Date()) {
            errorBox.textContent =
                'Scheduled date and time must be in the future.';
            errorBox.classList.remove('hidden');
            return;
        }

        const originalButton = button.innerHTML;

        button.disabled = true;
        button.innerHTML = `
            <span class="material-symbols-outlined animate-spin text-[18px]">
                progress_activity
            </span>
            Saving...
        `;

        try {
            const result = await updateDiary(
                currentDiary,
                'scheduled',
                input.value
            );

            closeEditScheduleModal();

            showToast(
                result?.message || 'Diary schedule updated successfully.',
                'check_circle'
            );

            await loadScheduledDiaries(currentPage);
        } catch (error) {
            errorBox.textContent = error.message;
            errorBox.classList.remove('hidden');
        } finally {
            button.disabled = false;
            button.innerHTML = originalButton;
        }
    };

    document.getElementById('scheduledDiariesTable').addEventListener(
        'click',
        event => {
            const button = event.target.closest('[data-action]');
            if (!button) return;

            const id = Number(button.dataset.id);

            const diary = (window.currentScheduledDiaries || [])
                .find(item => item.id === id);

            if (!diary) return;

            if (button.dataset.action === 'edit') {
                openEditScheduleModal(diary);
            }

            if (button.dataset.action === 'publish') {
                publishDiary(diary);
            }
        }
    );

    document.getElementById('pagination').addEventListener(
        'click',
        event => {
            const button = event.target.closest('[data-page]');
            if (!button || button.disabled) return;

            const page = Number(button.dataset.page);

            if (page > 0) {
                loadScheduledDiaries(page);
            }
        }
    );

    document.getElementById('closeEditScheduleModal')
        .addEventListener('click', closeEditScheduleModal);

    document.getElementById('cancelEditSchedule')
        .addEventListener('click', closeEditScheduleModal);

    document.getElementById('saveSchedule')
        .addEventListener('click', saveSchedule);

    document.getElementById('editScheduleModal').addEventListener(
        'click',
        event => {
            if (event.target === event.currentTarget) {
                closeEditScheduleModal();
            }
        }
    );

    document.addEventListener('keydown', event => {
        if (
            event.key === 'Escape' &&
            !document.getElementById('editScheduleModal').classList.contains('hidden')
        ) {
            closeEditScheduleModal();
        }
    });

    await loadScheduledDiaries(1);
    setInterval(() => {
        loadScheduledDiaries(currentPage);
    }, 10000);
})();
</script>

@endsection
