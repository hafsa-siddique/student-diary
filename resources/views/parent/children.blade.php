@extends('layouts.parent')

@section('title', 'My Children - Parent Portal')

@section('content')
<div class="flex flex-col w-full">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md mt-4 mb-space-lg">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                My Children
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                View your children's information and daily diary updates.
            </p>
        </div>

        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-low text-primary font-label-md text-label-md">
            <span class="material-symbols-outlined text-[18px]">group</span>
            <span id="childrenCount">0 Children</span>
        </div>
    </div>

    <div id="childrenLoading" class="flex flex-col items-center justify-center py-16">
        <span class="material-symbols-outlined text-primary text-[40px] animate-spin">
            progress_activity
        </span>
        <p class="font-body-md text-body-md text-on-surface-variant mt-3">
            Loading children...
        </p>
    </div>

    <div id="childrenContent" class="hidden">
        <div id="childrenGrid"
             class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg">
        </div>
    </div>

    <div id="childrenEmpty"
         class="hidden flex-col items-center justify-center text-center p-space-xl bg-surface-container-lowest rounded-xl shadow-sm py-16">

        <div class="w-20 h-20 rounded-full bg-surface-container-low flex items-center justify-center mb-space-md">
            <span class="material-symbols-outlined text-[40px] text-primary">
                person_search
            </span>
        </div>

        <h3 class="font-headline-md text-headline-md text-on-surface mb-space-xs">
            No children found
        </h3>

        <p class="font-body-md text-body-md text-on-surface-variant max-w-md">
            There are no students linked to your parent account yet.
            Please contact your institute administration.
        </p>
    </div>

    <div id="childrenError"
         class="hidden flex-col items-center justify-center text-center p-space-xl bg-surface-container-lowest rounded-xl shadow-sm py-16">

        <div class="w-20 h-20 rounded-full bg-surface-container-low flex items-center justify-center mb-space-md">
            <span class="material-symbols-outlined text-[40px] text-error">
                error_outline
            </span>
        </div>

        <h3 class="font-headline-md text-headline-md text-on-surface mb-space-xs">
            Unable to load children
        </h3>

        <p id="childrenErrorMessage"
           class="font-body-md text-body-md text-on-surface-variant max-w-md mb-space-lg">
            Something went wrong while loading your children.
        </p>

        <button type="button"
                onclick="loadChildrenPage()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary text-on-primary font-label-lg text-label-lg hover:bg-primary-container transition-colors">
            <span class="material-symbols-outlined text-[18px]">refresh</span>
            Try Again
        </button>
    </div>

</div>

<script>
(async () => {
    const token = localStorage.getItem('student_diary_token');
    const instituteCode = localStorage.getItem('student_diary_institute_code');
    const API_BASE = '/api/v1';

    const headers = {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
        'Content-Type': 'application/json'
    };

    if (!token) {
        window.location.href = instituteCode
            ? `/login/${instituteCode}`
            : '/';
        return;
    }

    function handleUnauthorized(response) {
        if (response.status !== 401) return false;

        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');

        window.location.href = instituteCode
            ? `/login/${instituteCode}`
            : '/';

        return true;
    }

    async function fetchJson(url) {
        const response = await fetch(url, {
            method: 'GET',
            headers
        });

        if (handleUnauthorized(response)) return null;

        const data = await response.json();

        if (!response.ok || data.status === false) {
            throw new Error(data.message || 'Request failed.');
        }

        return data;
    }

    async function getChildren() {
        const response = await fetchJson(`${API_BASE}/parent/children`);
        return response?.data?.data ?? response?.data ?? [];
    }

    async function getTodayDiaries(studentId) {
        const today = new Date();
        const date =
            `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

        try {
            const response = await fetchJson(
                `${API_BASE}/parent/students/${studentId}/diaries?date=${date}`
            );

            return response?.data?.data ?? response?.data ?? [];
        } catch (error) {
            console.error(
                `Unable to load diaries for student ${studentId}:`,
                error
            );

            return [];
        }
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function getStatusBadge(active) {
        return active
            ? `
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-low text-secondary font-label-sm text-label-sm font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                    Active
                </span>
            `
            : `
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-on-surface-variant"></span>
                    Inactive
                </span>
            `;
    }

    function renderChildCard(child) {
        const active = Boolean(child.status);
        const className = child.class?.name || '—';
        const sectionName = child.section?.name || '—';
        const sessionName = child.academic_session?.name || '—';
        const diaryCount = child.diaries_count ?? 0;
        const image = child.profile_picture || null;

        return `
            <div class="group bg-surface-container-lowest rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden">

                <div class="p-space-lg flex flex-col gap-space-md">

                    <div class="flex items-start justify-between gap-3">
                        <div class="relative shrink-0">
                            ${
                                image
                                    ? `
                                        <img
                                            src="${escapeHtml(image)}"
                                            alt="${escapeHtml(child.name || 'Student')}"
                                            class="w-16 h-16 rounded-full object-cover shadow-sm ring-2 ring-secondary"
                                        >
                                    `
                                    : `
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center bg-primary text-on-primary text-xl font-semibold shadow-sm ring-2 ring-secondary">
                                            ${escapeHtml((child.name || 'S').charAt(0).toUpperCase())}
                                        </div>
                                    `
                            }

                            ${
                                active
                                    ? `
                                        <span
                                            class="absolute bottom-0 right-0 w-4 h-4 bg-secondary-fixed rounded-full ring-2 ring-surface-container-lowest"
                                            title="Active student">
                                        </span>
                                    `
                                    : ''
                            }
                        </div>

                        ${getStatusBadge(active)}
                    </div>

                    <div>
                        <div class="flex items-baseline justify-between gap-2">
                            <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">
                                ${escapeHtml(child.name || 'Unnamed Student')}
                            </h3>

                            <span class="shrink-0 font-label-sm text-label-sm text-on-surface-variant font-tabular-numeric bg-surface-container-low px-2 py-0.5 rounded">
                                ${escapeHtml(child.student_code || '—')}
                            </span>
                        </div>

                        <div class="mt-space-xs flex items-center gap-space-xs text-on-surface-variant font-body-md text-body-md">
                            <span class="font-medium text-on-surface">
                                ${escapeHtml(className)}
                            </span>
                            <span>•</span>
                            <span>
                                ${escapeHtml(sectionName)}
                            </span>
                        </div>
                    </div>

                    <div class="bg-surface-container-low/60 rounded-lg p-space-sm flex items-center justify-between text-on-surface-variant">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider">
                            Session
                        </span>

                        <span class="font-label-md text-label-md text-on-surface font-tabular-numeric">
                            ${escapeHtml(sessionName)}
                        </span>
                    </div>

                    <div class="flex items-center justify-between bg-surface-container-low/40 rounded-lg px-space-sm py-2.5">
                        <span class="flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                            <span class="material-symbols-outlined text-[16px] text-primary">
                                menu_book
                            </span>
                            Diaries Today
                        </span>

                        <span class="font-semibold text-on-surface font-tabular-numeric">
                            ${diaryCount}
                        </span>
                    </div>

                </div>

                <div class="p-space-lg pt-0">
                    <a
                        href="/parent/children/${child.id}/diary"
                        data-spa-link
                        class="w-full h-11 flex items-center justify-center gap-2 bg-primary-container text-on-primary rounded-lg font-label-lg text-label-lg hover:bg-primary transition-all duration-200 shadow-sm group-hover:shadow"
                    >
                        View Diary
                        <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">
                            arrow_forward
                        </span>
                    </a>
                </div>

            </div>
        `;
    }

    function showError(message) {
        document.getElementById('childrenLoading').classList.add('hidden');

        document.getElementById('childrenContent').classList.add('hidden');

        const error = document.getElementById('childrenError');
        error.classList.remove('hidden');
        error.classList.add('flex');

        document.getElementById('childrenErrorMessage').textContent =
            message;
    }

    async function loadChildrenPage() {
        const loading = document.getElementById('childrenLoading');
        const content = document.getElementById('childrenContent');
        const empty = document.getElementById('childrenEmpty');
        const error = document.getElementById('childrenError');
        const grid = document.getElementById('childrenGrid');

        loading.classList.remove('hidden');
        loading.classList.add('flex');
        content.classList.add('hidden');
        empty.classList.add('hidden');
        empty.classList.remove('flex');
        error.classList.add('hidden');
        error.classList.remove('flex');

        try {
            const children = await getChildren();

            document.getElementById('childrenCount').textContent =
                `${children.length} ${children.length === 1 ? 'Child' : 'Children'}`;

            if (!children.length) {
                grid.innerHTML = '';
                loading.classList.add('hidden');
                loading.classList.remove('flex');
                empty.classList.remove('hidden');
                empty.classList.add('flex');
                return;
            }

            const diaryResults = await Promise.all(
                children.map(async child => {
                    const diaries = await getTodayDiaries(child.id);
                    child.diaries_count = diaries.length;
                    return diaries.length;
                })
            );

            grid.innerHTML = children.map(renderChildCard).join('');

            loading.classList.add('hidden');
            loading.classList.remove('flex');
            content.classList.remove('hidden');

        } catch (error) {
            console.error('Parent children page error:', error);
            showError(
                error.message || 'Unable to load children.'
            );
        }
    }

    window.loadChildrenPage = loadChildrenPage;

    await loadChildrenPage();
})();
</script>
@endsection
