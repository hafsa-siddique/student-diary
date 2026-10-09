@extends('layouts.teacher')

@section('title', 'My Diaries - Student Diary')

@section('content')

<div class="flex flex-col w-full gap-space-lg">

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
    <div>
        <h1 class="mt-4 font-headline-lg text-headline-lg text-on-surface tracking-tight">
            My Diaries
        </h1>
        <p class="mt-0.5 font-body-md text-body-md text-on-surface-variant">
            View and manage all your classroom diary entries.
        </p>
        
    </div>
    <a href="/teacher/diaries/create" id="openCreateDiaryModal"
        class="flex items-center gap-1.5 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">
        <span class="material-symbols-outlined text-[18px]">edit_note</span>
        Create Diary
    </a>
</div>

<!-- Filters -->
<div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
    <div class="flex flex-col lg:flex-row lg:items-end gap-4">

        <div class="flex-1">
            <label for="filterDate" class="mb-1 block text-sm font-medium text-on-surface">
                Diary Date
            </label>
            <input
                type="date"
                id="filterDate"
                class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
            >
        </div>

        <div class="flex-1">
            <label for="filterStatus" class="mb-1 block text-sm font-medium text-on-surface">
                Status
            </label>
            <select
                id="filterStatus"
                class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
            >
                <option value="">All Diaries</option>
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="scheduled">Scheduled</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="button"
                id="filterButton"
                class="flex items-center gap-1.5 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white"
            >
                <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                Filter
            </button>

            <button
                type="button"
                id="resetFilters"
                class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container"
            >
                Reset
            </button>
        </div>

    </div>
</div>

<!-- Diaries -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-space-md border-b border-outline-variant">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">
                Diary Entries
            </h2>
        </div>
        <p id="diaryCount" class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
            Loading diaries...
        </p>
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
                        Homework
                    </th>
                    <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                        Status
                    </th>
                    <th class="text-right px-5 py-3 font-label-sm text-label-sm text-outline">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody id="diariesTable">
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-on-surface-variant">
                        Loading diaries...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination"
         class="hidden flex flex-col sm:flex-row items-center justify-between gap-3 px-4 py-3 border-t border-outline-variant">
    </div>

</div>

</div>

<!-- Schedule Modal -->

<div id="scheduleModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
     role="dialog"
     aria-modal="true">

<div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">

    <div class="flex items-center justify-between border-b border-outline-variant p-5">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">
                Schedule Diary
            </h2>
            <p class="mt-1 text-sm text-on-surface-variant">
                Select when this diary should be published.
            </p>
        </div>

        <button type="button" id="closeScheduleModal"
                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="p-5">

        <label for="scheduleDateTime"
               class="mb-1 block text-sm font-medium text-on-surface">
            Scheduled At *
        </label>

        <input
            type="datetime-local"
            id="scheduleDateTime"
            class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
        >

        <div id="scheduleError"
             class="hidden mt-3 rounded-lg bg-red-50 p-3 text-sm text-red-700">
        </div>

    </div>

    <div class="flex justify-end gap-3 border-t border-outline-variant p-5">
        <button type="button"
                id="cancelSchedule"
                class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
            Cancel
        </button>

        <button type="button"
                id="confirmSchedule"
                class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white">
            Schedule
        </button>
    </div>

</div>

</div>
<!-- Create Diary Modal -->
<div id="createDiaryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="createDiaryModalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="createDiaryModalTitle" class="font-headline-md text-headline-md text-on-surface">
                    Create Diary
                </h2>
                <p class="mt-1 text-sm text-on-surface-variant">
                    Add a diary entry for one of your assigned classes and subjects.
                </p>
            </div>

            <button
                type="button"
                id="closeCreateDiaryModal"
                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
                aria-label="Close modal"
            >
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="createDiaryForm" class="flex flex-col min-h-0">

            <!-- Modal Body -->
            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">

                <div class="sm:col-span-2">
                    <label
                        for="diaryAssignment"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Subject / Class / Section *
                    </label>

                    <select
                        id="diaryAssignment"
                        name="teacher_assignment_id"
                        required
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                        <option value="">Select subject, class & section</option>
                    </select>

                    <p class="mt-1 text-xs text-on-surface-variant">
                        Only your assigned subjects, classes and sections are available.
                    </p>
                </div>

                <div>
                    <label
                        for="diaryDate"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Diary Date *
                    </label>

                    <input
                        type="date"
                        id="diaryDate"
                        name="diary_date"
                        required
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                </div>

                <div>
                    <label
                        for="diaryDueDate"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Due Date
                    </label>

                    <input
                        type="date"
                        id="diaryDueDate"
                        name="due_date"
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                </div>

                <div class="sm:col-span-2 mt-2 border-t border-outline-variant pt-4">
                    <h3 class="font-semibold text-on-surface">Diary Details</h3>
                    <p class="mt-1 text-sm text-on-surface-variant">
                        Enter the classwork, homework and any instructions for students.
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <label
                        for="diaryClasswork"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Classwork
                    </label>

                    <textarea
                        id="diaryClasswork"
                        name="classwork"
                        rows="3"
                        placeholder="Enter today's classwork"
                        class="w-full resize-none rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label
                        for="diaryHomework"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Homework
                    </label>

                    <textarea
                        id="diaryHomework"
                        name="homework"
                        rows="3"
                        placeholder="Enter homework"
                        class="w-full resize-none rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label
                        for="diaryInstructions"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Instructions
                    </label>

                    <textarea
                        id="diaryInstructions"
                        name="instructions"
                        rows="2"
                        placeholder="Enter any additional instructions"
                        class="w-full resize-none rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    ></textarea>
                </div>

                <div>
                    <label
                        for="diaryStatus"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Status *
                    </label>

                    <select
                        id="diaryStatus"
                        name="status"
                        required
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="scheduled">Scheduled</option>
                    </select>
                </div>

                <div id="scheduledAtGroup" class="hidden">
                    <label
                        for="diaryScheduledAt"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Scheduled At *
                    </label>

                    <input
                        type="datetime-local"
                        id="diaryScheduledAt"
                        name="scheduled_at"
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                </div>

            </div>

            <!-- Error -->
            <div
                id="createDiaryError"
                class="hidden mx-5 mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700"
                role="alert"
            ></div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">

                <button
                    type="button"
                    id="cancelCreateDiary"
                    class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    id="saveCreateDiary"
                    class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    Create Diary
                </button>

            </div>

        </form>
    </div>
</div>
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
(() => {
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

    const statusBadge = status => {
        const value = String(status || '').toLowerCase();

        if (value === 'published') {
            return `
                <span class="inline-flex items-center gap-1 px-1 py-1 rounded-full
                             text-secondary
                             font-label-sm text-label-sm font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                    Published
                </span>
            `;
        }

        if (value === 'scheduled') {
            return `
                <span class="inline-flex items-center gap-1 px-1 py-1 rounded-full
                             text-primary
                             font-label-sm text-label-sm font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                    Scheduled
                </span>
            `;
        }

        return `
            <span class="inline-flex items-center gap-1 px-1 py-1 rounded-full
                         text-outline
                         font-label-sm text-label-sm font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                Draft
            </span>
        `;
    };

    const formatDate = date => {
    if (!date) return '—';

    const match = String(date).match(/^(\d{4})-(\d{2})-(\d{2})/);

    if (match) {
        const [, year, month, day] = match;

        return new Date(Number(year), Number(month) - 1, Number(day))
            .toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
    }

    return date;
};

    const renderActions = diary => {
        if (diary.status !== 'draft') {
            return `
                <span class="text-xs text-on-surface-variant">-</span>
            `;
        }

        return `
            <div class="flex items-center justify-end gap-1">

                <button
                    type="button"
                    title="Publish Diary"
                    data-action="publish"
                    data-id="${diary.id}"
                    class="flex items-center justify-center w-9 h-9 rounded-lg
                           text-secondary transition-colors">
                    <span class="material-symbols-outlined text-[19px]">publish</span>
                </button>

                <button
                    type="button"
                    title="Schedule Diary"
                    data-action="schedule"
                    data-id="${diary.id}"
                    class="flex items-center justify-center w-9 h-9 rounded-lg
                           text-primary hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined text-[19px]">schedule</span>
                </button>

            </div>
        `;
    };

    const renderDiaries = result => {
    const container = document.getElementById('diariesTable');
    const diaries = result.data || [];
    const paginationData = result.pagination || {};

    window.currentDiaries = diaries;

    document.getElementById('diaryCount').textContent =
        `${paginationData.total ?? diaries.length} diary entries found`;

    if (!diaries.length) {
        container.innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-12 text-center">
                    <div class="flex flex-col items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[36px]">menu_book</span>
                        <span class="font-body-sm text-body-sm">
                            No diary entries found.
                        </span>
                    </div>
                </td>
            </tr>
        `;
        renderPagination(paginationData);
        return;
    }

    container.innerHTML = diaries.map(diary => `
        <tr class="border-t border-outline-variant hover:bg-surface-container-low transition-colors">

            <td class="px-4 py-3">
                <div class="font-label-md text-label-md text-on-surface font-semibold">
                    ${escapeHtml(diary.subject?.name || '—')}
                </div>
                <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                    ${escapeHtml(diary.subject?.code || '')}
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

            <td class="px-4 py-3 max-w-xs">
                <span class="font-body-sm text-body-sm text-on-surface-variant">
                    ${escapeHtml(diary.homework || 'No homework')}
                </span>
            </td>

            <td class="px-4 py-3">
                ${statusBadge(diary.status)}
            </td>

            <td class="px-4 py-3">
                ${renderActions(diary)}
            </td>

        </tr>
    `).join('');

    renderPagination(paginationData);
};

    const renderPagination = paginationData => {
    const pagination = document.getElementById('pagination');

    if (!paginationData.last_page || paginationData.last_page <= 1) {
        pagination.classList.add('hidden');
        pagination.innerHTML = '';
        return;
    }

    pagination.classList.remove('hidden');

    pagination.innerHTML = `
        <span class="text-sm text-on-surface-variant">
            Page ${paginationData.current_page} of ${paginationData.last_page}
        </span>

        <div class="flex items-center gap-2">
            <button
                type="button"
                data-page="${paginationData.current_page - 1}"
                ${paginationData.current_page <= 1 ? 'disabled' : ''}
                class="rounded-lg border border-outline-variant px-3 py-1.5 text-sm
                       text-on-surface disabled:opacity-40">
                Previous
            </button>

            <button
                type="button"
                data-page="${paginationData.current_page + 1}"
                ${paginationData.current_page >= paginationData.last_page ? 'disabled' : ''}
                class="rounded-lg border border-outline-variant px-3 py-1.5 text-sm
                       text-on-surface disabled:opacity-40">
                Next
            </button>
        </div>
    `;
};

    const loadDiaries = async (page = 1) => {
        const date = document.getElementById('filterDate').value;
        const status = document.getElementById('filterStatus').value;

        const params = new URLSearchParams({ page });

        if (date) params.set('diary_date', date);
        if (status) params.set('status', status);

        const container = document.getElementById('diariesTable');

        container.innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-10 text-center text-on-surface-variant">
                    Loading diaries...
                </td>
            </tr>
        `;

        try {
            const response = await fetch(
                `/api/v1/teacher/diaries?${params.toString()}`,
                { headers }
            );

            if (response.status === 401) {
                logout();
                return;
            }

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Failed to load diaries.');
            }

            currentPage = result.pagination?.current_page || page;
            renderDiaries(result);

        } catch (error) {
            console.error('My diaries error:', error);

            container.innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-red-600">
                        Unable to load diaries.
                    </td>
                </tr>
            `;
        }
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

        const response = await fetch(`/api/v1/teacher/diaries/${diary.id}`, {
            method: 'PUT',
            headers,
            body: JSON.stringify(payload)
        });

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

    const publishDiary = async diary => {
    try {
        const result = await updateDiary(diary, 'published');
        alert(result.message || 'Diary published successfully.');
        await loadDiaries(currentPage);
    } catch (error) {
        alert(error.message);
    }
};

    const openScheduleModal = diary => {
        currentDiary = diary;

        document.getElementById('scheduleDateTime').value = '';
        document.getElementById('scheduleError').classList.add('hidden');
        document.getElementById('scheduleModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    const closeScheduleModal = () => {
        currentDiary = null;
        document.getElementById('scheduleModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    const scheduleDiary = async () => {
        if (!currentDiary) return;

        const input = document.getElementById('scheduleDateTime');
        const error = document.getElementById('scheduleError');
        const scheduledAt = input.value;

        error.classList.add('hidden');

        if (!scheduledAt) {
            error.textContent = 'Please select a date and time.';
            error.classList.remove('hidden');
            return;
        }

        if (new Date(scheduledAt) <= new Date()) {
            error.textContent = 'Scheduled date and time must be in the future.';
            error.classList.remove('hidden');
            return;
        }

        const button = document.getElementById('confirmSchedule');
        button.disabled = true;

        try {
            await updateDiary(currentDiary, 'scheduled', scheduledAt);
            closeScheduleModal();
            await loadDiaries(currentPage);
        } catch (error) {
            document.getElementById('scheduleError').textContent = error.message;
            document.getElementById('scheduleError').classList.remove('hidden');
        } finally {
            button.disabled = false;
        }
    };

    document.getElementById('filterButton').addEventListener('click', () => {
        loadDiaries(1);
    });

    document.getElementById('resetFilters').addEventListener('click', () => {
        document.getElementById('filterDate').value = '';
        document.getElementById('filterStatus').value = '';
        loadDiaries(1);
    });

    document.getElementById('diariesTable').addEventListener('click', event => {
        const button = event.target.closest('[data-action]');
        if (!button) return;

        const id = Number(button.dataset.id);
        const diaries = window.currentDiaries || [];
        const diary = diaries.find(item => item.id === id);

        if (!diary) return;

        if (button.dataset.action === 'publish') {
            publishDiary(diary);
        }

        if (button.dataset.action === 'schedule') {
            openScheduleModal(diary);
        }
    });

    document.getElementById('pagination').addEventListener('click', event => {
        const button = event.target.closest('[data-page]');
        if (!button || button.disabled) return;

        const page = Number(button.dataset.page);

        if (page > 0) {
            loadDiaries(page);
        }
    });

    document.getElementById('closeScheduleModal').addEventListener('click', closeScheduleModal);
    document.getElementById('cancelSchedule').addEventListener('click', closeScheduleModal);
    document.getElementById('confirmSchedule').addEventListener('click', scheduleDiary);

    document.getElementById('scheduleModal').addEventListener('click', event => {
        if (event.target === event.currentTarget) {
            closeScheduleModal();
        }
    });

    document.addEventListener('keydown', event => {
        if (
            event.key === 'Escape' &&
            !document.getElementById('scheduleModal').classList.contains('hidden')
        ) {
            closeScheduleModal();
        }
    });

    const originalRenderDiaries = renderDiaries;

    window.currentDiaries = [];

    const observer = new MutationObserver(() => {
        const tableRows = document.querySelectorAll('#diariesTable tr');
        if (!tableRows.length) return;
    });

    observer.observe(document.getElementById('diariesTable'), {
        childList: true
    });

    const originalLoadDiaries = loadDiaries;

    window.loadTeacherDiaries = async page => {
        await originalLoadDiaries(page);
    };
const getLocalDate = () => {
    const date = new Date();
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
};

const loadAvailableDiaryAssignments = async () => {
    const select = document.getElementById('diaryAssignment');
    const diaryDate = document.getElementById('diaryDate').value;

    select.innerHTML = '<option value="">Loading assignments...</option>';
    select.disabled = true;

    if (!diaryDate) {
        select.innerHTML = '<option value="">Select diary date first</option>';
        return;
    }

    try {
        const response = await fetch(
            `/api/v1/teacher/diaries/available-assignments?diary_date=${encodeURIComponent(diaryDate)}`,
            { headers }
        );

        if (response.status === 401) {
            logout();
            return;
        }

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Unable to load assignments.');
        }

        select.innerHTML = '<option value="">Select subject, class & section</option>';

        if (!result.data?.length) {
            select.innerHTML = '<option value="">No assignments available for this date</option>';
            return;
        }

        result.data.forEach(assignment => {
            const option = document.createElement('option');

            option.value = assignment.id;
            option.textContent =
                `${assignment.subject?.name || 'Unknown Subject'} — ` +
                `${assignment.school_class?.name || assignment.class?.name || 'Unknown Class'} — ` +
                `${assignment.section?.name || 'Unknown Section'}`;

            select.appendChild(option);
        });

        select.disabled = false;
    } catch (error) {
        console.error('Available assignments error:', error);
        select.innerHTML = '<option value="">Unable to load assignments</option>';
    }
};

const showCreateDiaryError = message => {
    const errorBox = document.getElementById('createDiaryError');
    errorBox.textContent = message;
    errorBox.classList.remove('hidden');
};

const clearCreateDiaryError = () => {
    const errorBox = document.getElementById('createDiaryError');
    errorBox.textContent = '';
    errorBox.classList.add('hidden');
};

const openCreateDiaryModal = () => {
    const modal = document.getElementById('createDiaryModal');
    const form = document.getElementById('createDiaryForm');

    form.reset();
    clearCreateDiaryError();

    document.getElementById('diaryDate').value = getLocalDate();
    document.getElementById('scheduledAtGroup').classList.add('hidden');
    document.getElementById('diaryScheduledAt').value = '';

    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    loadAvailableDiaryAssignments();
};

const closeCreateDiaryModal = () => {
    document.getElementById('createDiaryModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
};

document.getElementById('openCreateDiaryModal').addEventListener('click', event => {
    event.preventDefault();
    openCreateDiaryModal();
});

document.getElementById('closeCreateDiaryModal').addEventListener('click', closeCreateDiaryModal);
document.getElementById('cancelCreateDiary').addEventListener('click', closeCreateDiaryModal);

document.getElementById('createDiaryModal').addEventListener('click', event => {
    if (event.target === event.currentTarget) {
        closeCreateDiaryModal();
    }
});

document.getElementById('diaryDate').addEventListener('change', loadAvailableDiaryAssignments);

document.getElementById('diaryStatus').addEventListener('change', event => {
    const group = document.getElementById('scheduledAtGroup');
    const input = document.getElementById('diaryScheduledAt');

    if (event.target.value === 'scheduled') {
        group.classList.remove('hidden');
        input.required = true;
    } else {
        group.classList.add('hidden');
        input.required = false;
        input.value = '';
    }
});

document.getElementById('createDiaryForm').addEventListener('submit', async event => {
    event.preventDefault();

    const form = event.currentTarget;
    const button = document.getElementById('saveCreateDiary');
    const status = document.getElementById('diaryStatus').value;
    const scheduledAt = document.getElementById('diaryScheduledAt').value;

    clearCreateDiaryError();

    if (!form.teacher_assignment_id.value) {
        showCreateDiaryError('Please select a subject, class and section.');
        return;
    }

    if (status === 'scheduled') {
        if (!scheduledAt) {
            showCreateDiaryError('Please select the scheduled date and time.');
            return;
        }

        if (new Date(scheduledAt) <= new Date()) {
            showCreateDiaryError('Scheduled date and time must be in the future.');
            return;
        }
    }

    const payload = {
        teacher_assignment_id: Number(form.teacher_assignment_id.value),
        diary_date: form.diary_date.value,
        classwork: form.classwork.value.trim() || null,
        homework: form.homework.value.trim() || null,
        instructions: form.instructions.value.trim() || null,
        due_date: form.due_date.value || null,
        status,
        scheduled_at: status === 'scheduled' ? scheduledAt : null
    };

    const originalButton = button.innerHTML;

    button.disabled = true;
    button.innerHTML = `
        <span class="material-symbols-outlined animate-spin text-[18px]">
            progress_activity
        </span>
        Saving...
    `;

    try {
        const response = await fetch('/api/v1/teacher/diaries', {
            method: 'POST',
            headers,
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        if (response.status === 401) {
            logout();
            return;
        }

        if (!response.ok) {
            const errors = result.errors
                ? Object.values(result.errors).flat().join(' ')
                : result.message || 'Failed to create diary.';

            throw new Error(errors);
        }

        closeCreateDiaryModal();
        await loadDiaries(currentPage);

    } catch (error) {
        showCreateDiaryError(error.message);
    } finally {
        button.disabled = false;
        button.innerHTML = originalButton;
    }
});

document.addEventListener('keydown', event => {
    if (
        event.key === 'Escape' &&
        !document.getElementById('createDiaryModal').classList.contains('hidden')
    ) {
        closeCreateDiaryModal();
    }
});
    loadDiaries(1);
    setInterval(() => {
        loadDiaries(currentPage);
    }, 10000);
})();
</script>

@endsection
