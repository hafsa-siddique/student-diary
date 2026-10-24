@extends('layouts.parent')

@section('title', 'Parent Portal - Dashboard')

@section('content')
<div class="flex flex-col w-full">
    {{-- Hero Banner --}}
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-space-md mt-4">
        <div class="max-w-2xl">
            <h1 id="parentGreeting" class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                Welcome back
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                Select a child to view their daily diary, homework updates, and teacher remarks.
            </p>
        </div>
        <div class="flex items-center gap-space-sm self-start md:self-auto bg-surface-container-lowest/10 p-1.5 rounded-xl backdrop-blur-md">
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-lowest text-primary font-label-md text-label-md shadow-sm">
                <span class="material-symbols-outlined text-[16px]">group</span>
                Active (<span id="activeChildrenCount">0</span>)
            </div>
        </div>
    </div>

    {{-- Loading State --}}
    <div id="dashboardLoading" class="flex flex-col items-center justify-center py-16">
        <span class="material-symbols-outlined text-primary text-[40px] animate-spin">progress_activity</span>
        <p class="font-body-md text-body-md text-on-surface-variant mt-3">Loading dashboard...</p>
    </div>

    {{-- Dashboard Content --}}
    <div id="dashboardContent" class="hidden mt-3">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md mb-space-lg">
            <div class="flex items-center gap-space-md p-space-md bg-surface-container-lowest rounded-xl shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">school</span>
                </div>
                <div>
                    <p class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Enrolled Students</p>
                    <p id="totalChildren" class="font-headline-sm text-headline-sm text-on-surface font-tabular-numeric">
                        0 Students
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-space-md p-space-md bg-surface-container-lowest rounded-xl shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-surface-container-low flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[24px]">menu_book</span>
                </div>
                <div>
                    <p class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Diaries Published Today</p>
                    <p id="totalDiariesToday" class="font-headline-sm text-headline-sm text-on-surface font-tabular-numeric">
                        0 Entries Total
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-space-md p-space-md bg-surface-container-lowest rounded-xl shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">verified</span>
                </div>
                <div>
                    <p class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Academic Session</p>
                    <p id="academicSession" class="font-headline-sm text-headline-sm text-on-surface">
                        —
                    </p>
                </div>
            </div>
        </div>

        {{-- Children List --}}
        <div id="childrenViewContainer" class="flex flex-col w-full">
            <div class="flex items-end justify-between pb-space-sm mb-space-md">
                <div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">My Children</h2>
                </div>
            </div>

            <div id="childrenGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg mb-space-xl"></div>
             <div id="viewAllChildrenContainer" class="hidden justify-center mb-space-xl">
                <a id="viewAllChildren"
                href="/parent/children"
                data-spa-link
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-on-primary font-label-lg text-label-lg hover:bg-primary-container transition-colors shadow-sm">
                    View All Children
                    <span class="material-symbols-outlined text-[18px]">
                        arrow_forward
                    </span>
                </a>
            </div>
        </div>

        {{-- Empty State --}}
        <div id="emptyViewContainer" class="hidden flex-col items-center justify-center text-center p-space-xl bg-surface-container-lowest rounded-xl shadow-sm mb-space-xl py-16">
            <div class="w-20 h-20 rounded-full bg-surface-container-low flex items-center justify-center text-on-surface-variant mb-space-md">
                <span class="material-symbols-outlined text-[40px] text-primary">person_search</span>
            </div>

            <h3 class="font-headline-md text-headline-md text-on-surface mb-space-xs">
                No children found
            </h3>

            <p class="font-body-md text-body-md text-on-surface-variant max-w-md mb-space-lg">
                There are no students linked to your parent account yet. Please contact your institute administration to attach your child's student record.
            </p>
        </div>

        {{-- Support Footer --}}
        <div class="rounded-xl bg-surface-container-lowest p-space-md lg:p-space-lg flex flex-col sm:flex-row sm:items-center justify-between gap-space-md shadow-sm">
            <div class="flex items-center gap-space-md">
                <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center text-primary shrink-0 shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">badge</span>
                </div>

                <div>
                    <p class="font-headline-sm text-headline-sm text-on-surface">
                        Need to link another child?
                    </p>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Child linking and guardian verification are managed by your institute administration.
                    </p>
                    <div class="flex flex-wrap items-center gap-4 mt-3">
                        <a id="adminPhone" href="#"
                        class="flex items-center gap-2 text-primary font-body-sm">
                            <span class="material-symbols-outlined text-[18px]">call</span>
                            <span class="text-xs hover:text-secondary">—</span>
                        </a>
                        <a id="adminEmail" href="#"
                        class="flex items-center gap-2 text-primary font-body-sm">
                            <span class="material-symbols-outlined text-[18px]">mail</span>
                            <span class="text-xs hover:text-secondary">—</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Error State --}}
    <div id="dashboardError" class="hidden flex-col items-center justify-center text-center p-space-xl bg-surface-container-lowest rounded-xl shadow-sm py-16">
        <div class="w-20 h-20 rounded-full bg-surface-container-low flex items-center justify-center mb-space-md">
            <span class="material-symbols-outlined text-[40px] text-error">error_outline</span>
        </div>

        <h3 class="font-headline-md text-headline-md text-on-surface mb-space-xs">
            Unable to load dashboard
        </h3>

        <p id="dashboardErrorMessage" class="font-body-md text-body-md text-on-surface-variant max-w-md mb-space-lg">
            Something went wrong while loading your dashboard.
        </p>

        <button onclick="loadDashboard()" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary text-on-primary font-label-lg text-label-lg hover:bg-primary-container transition-colors">
            <span class="material-symbols-outlined text-[18px]">refresh</span>
            Try Again
        </button>
    </div>
</div>
<!-- Center Popup Modal (Initial View) -->
<div id="announcementPopup" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl border border-slate-200 text-slate-800 relative animate-scale-up">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <div class="flex items-center gap-2 text-amber-600">
                <span class="material-symbols-outlined">campaign</span>
                <h3 class="font-bold text-slate-800 text-sm">Today's Important Announcement</h3>
            </div>
            <button type="button" onclick="minimizeAnnouncement()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="py-2">
            <p id="popupMessageContent" class="text-sm text-slate-700 leading-relaxed whitespace-pre-line"></p>
        </div>
        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="button" onclick="minimizeAnnouncement()" class="px-4 py-2 rounded-xl bg-primary text-xs font-semibold text-white hover:brightness-110">Got it</button>
        </div>
    </div>
</div>

<!-- Floating Side Icon (Minimized View) -->
<button id="floatingAnnouncementIcon" onclick="openAnnouncementPopup()" class="fixed bottom-6 right-6 z-40 hidden flex items-center gap-2 rounded-full bg-secondary px-4 py-3 text-white shadow-lg hover:brightness-110 transition animate-bounce">
    <span class="material-symbols-outlined text-xl">campaign</span>
</button>
<script>
(()=>{
const token = localStorage.getItem('student_diary_token');
const instituteCode = localStorage.getItem('student_diary_institute_code');
const API_BASE = '/api/v1';

const headers = {
    Authorization: `Bearer ${token}`,
    Accept: 'application/json',
    'Content-Type': 'application/json'
};

if (!token) {
    window.location.href = instituteCode ? `/login/${instituteCode}` : '/';
}

function handleUnauthorized(response) {
    if (response.status === 401) {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.href = instituteCode ? `/login/${instituteCode}` : '/';
        return true;
    }
    return false;
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
async function loadParent() {
    const response = await fetchJson(`${API_BASE}/parent/me`);
    return response?.data || null;
}

async function loadChildren() {
    const response = await fetchJson(`${API_BASE}/parent/children`);
    return response?.data?.data ?? response?.data ?? [];
}
async function loadConfiguration() {
    const response = await fetchJson(`${API_BASE}/parent/configuration`);
    return response?.data ?? null;
}

async function loadTodayDiaries(studentId) {
    const today = new Date();
    const date = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

    try {
        const response = await fetchJson(
            `${API_BASE}/parent/students/${studentId}/diaries?date=${date}`
        );

        return response?.data?.data ?? response?.data ?? [];
    } catch (error) {
        console.error(`Unable to load diaries for student ${studentId}:`, error);
        return [];
    }
}

function getParentName(parent) {
    return parent?.name || parent?.user?.name || 'Parent';
}

function getStudentImage(student) {
    return student.profile_picture || null;
}

function getStatusBadge(active) {
    if (active) {
        return `
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-low text-secondary font-label-sm text-label-sm font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                Active
            </span>
        `;
    }

    return `
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
    const image = getStudentImage(child);

    return `
        <div class="group bg-surface-container-lowest rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden">
            <div class="p-space-lg flex flex-col gap-space-md">
                <div class="flex items-start justify-between gap-3">
                    <div class="relative shrink-0">
                        ${image
                            ? `<img
                                src="${image}"
                                alt="${escapeHtml(child.name || 'Student')}"
                                class="w-16 h-16 rounded-full object-cover shadow-sm ring-2 ring-secondary"
                            >`
                            : `<div
                                class="w-16 h-16 rounded-full flex items-center justify-center bg-primary text-on-secondary text-xl font-semibold shadow-sm ring-2 ring-secondary"
                            >
                                ${escapeHtml((child.name || 'S').charAt(0).toUpperCase())}
                            </div>`
                        }

                        ${active ? `
                            <span class="absolute bottom-0 right-0 w-4 h-4 bg-secondary-fixed rounded-full ring-2 ring-surface-container-lowest" title="Active student"></span>
                        ` : ''}
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
                        <span class="material-symbols-outlined text-[16px] text-primary">menu_book</span>
                        Diaries Today
                    </span>

                    <span class="font-semibold text-on-surface font-tabular-numeric">
                        ${diaryCount}
                    </span>
                </div>
            </div>

            <div class="p-space-lg pt-0">
                <a
                    href="/parent/children/${child.id}/diary" data-spa-link
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

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

function showError(message) {
    document.getElementById('dashboardLoading').classList.add('hidden');
    document.getElementById('dashboardContent').classList.add('hidden');

    const error = document.getElementById('dashboardError');
    error.classList.remove('hidden');
    error.classList.add('flex');

    document.getElementById('dashboardErrorMessage').textContent = message;
}

function renderChildren(children) {
    const childrenGrid = document.getElementById('childrenGrid');
    const viewAllContainer = document.getElementById('viewAllChildrenContainer');
    const visibleChildren = children.slice(0, 3);
    childrenGrid.innerHTML = visibleChildren.map(renderChildCard).join('');
    if (children.length > 3) {
        viewAllContainer.classList.remove('hidden');
        viewAllContainer.classList.add('flex');
    } else {
        viewAllContainer.classList.add('hidden');
        viewAllContainer.classList.remove('flex');
    }
}

async function loadDashboard() {
    const loading = document.getElementById('dashboardLoading');
    const content = document.getElementById('dashboardContent');
    const error = document.getElementById('dashboardError');
    console.log('dashboardLoading:', loading);
    console.log('dashboardContent:', content);
    console.log('dashboardError:', error);

    if (!loading || !content || !error) {
        console.error('Dashboard element is missing.');
        return;
    }
    loading.classList.remove('hidden');
    loading.classList.add('flex');
    content.classList.add('hidden');
    error.classList.add('hidden');
    error.classList.remove('flex');

    try {
        const [parent, children, config] = await Promise.all([
            loadParent(),
            loadChildren(),
            loadConfiguration()
        ]);
        if (config?.contact_phone) {
            const phone = document.getElementById('adminPhone');
            phone.href = `tel:${config.contact_phone}`;
            phone.querySelector('span:last-child').textContent = config.contact_phone;
        }

        if (config?.contact_email) {
            const email = document.getElementById('adminEmail');
            email.href = `mailto:${config.contact_email}`;
            email.querySelector('span:last-child').textContent = config.contact_email;
        }
        console.log('Configuration:', config);
        console.log('Parent:', parent);
        console.log('Children:', children);

        document.getElementById('parentGreeting').textContent =
            `Welcome back, ${getParentName(parent)}`;
        window.dashboardChildren = children;
        const activeChildren = children.filter(child => Boolean(child.status));

        document.getElementById('activeChildrenCount').textContent =
            activeChildren.length;

        document.getElementById('totalChildren').textContent =
            `${children.length} ${children.length === 1 ? 'Student' : 'Students'}`;

        const sessions = children
            .map(child => child.academic_session?.name)
            .filter(Boolean);

        document.getElementById('academicSession').textContent =
            sessions[0] || '—';

        const diaryResults = await Promise.all(
            children.map(async child => {
                const diaries = await loadTodayDiaries(child.id);
                child.diaries_count = diaries.length;
                return diaries.length;
            })
        );

        const totalDiaries = diaryResults.reduce(
            (total, count) => total + count,
            0
        );

        document.getElementById('totalDiariesToday').textContent =
            `${totalDiaries} ${totalDiaries === 1 ? 'Entry' : 'Entries'} Total`;

        const childrenGrid = document.getElementById('childrenGrid');
        const childrenContainer = document.getElementById('childrenViewContainer');
        const emptyContainer = document.getElementById('emptyViewContainer');

        if (children.length === 0) {
            childrenGrid.innerHTML = '';
            childrenContainer.classList.add('hidden');
            emptyContainer.classList.remove('hidden');
            emptyContainer.classList.add('flex');
        } else {
            renderChildren(children);

            childrenContainer.classList.remove('hidden');
            emptyContainer.classList.add('hidden');
            emptyContainer.classList.remove('flex');
        }

        loading.classList.add('hidden');
        loading.classList.remove('flex');
        content.classList.remove('hidden');
        await checkTodayAnnouncement();

    } catch (error) {
        console.error('Parent dashboard error:', error);
        showError(error.message || 'Unable to load dashboard.');
    }
}
async function checkTodayAnnouncement() {
    const token = localStorage.getItem('student_diary_token');
    try {
        const response = await fetch('/api/v1/user/active-announcement', {
            headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
        });
        const result = await response.json();
        
        if (response.ok && result.data && result.data.message) {
            const popupMsg = document.getElementById('popupMessageContent');
            if (popupMsg) popupMsg.textContent = result.data.message;
            const user = JSON.parse(localStorage.getItem('student_diary_user') || '{}');
            const userId = user.id || 'guest';
            const todayDate = new Date().toISOString().split('T')[0];
            const dismissedDate = localStorage.getItem(`announcement_dismissed_date_${userId}`);
            
            if (dismissedDate !== todayDate) {
                document.getElementById('announcementPopup')?.classList.remove('hidden');
            } else {
                document.getElementById('floatingAnnouncementIcon')?.classList.remove('hidden');
            }
        }
    } catch (err) {
        console.error('Failed to load announcement', err);
    }
}
loadDashboard();
})();
function minimizeAnnouncement() {
    document.getElementById('announcementPopup')?.classList.add('hidden');
    document.getElementById('floatingAnnouncementIcon')?.classList.remove('hidden');
    const user = JSON.parse(localStorage.getItem('student_diary_user') || '{}');
    const userId = user.id || 'guest';
    const todayDate = new Date().toISOString().split('T')[0];
    localStorage.setItem(`announcement_dismissed_date_${userId}`, todayDate);
}

function openAnnouncementPopup() {
    document.getElementById('floatingAnnouncementIcon')?.classList.add('hidden');
    document.getElementById('announcementPopup')?.classList.remove('hidden');
}
</script>
@endsection



