@extends('layouts.parent')

@section('title', 'Daily Diary')

@section('content')

<div class="flex flex-col w-full">
    <!-- Loading -->
    <div id="diaryLoading"
         class="bg-surface-container-lowest rounded-xl shadow-sm p-12 flex flex-col items-center justify-center">
        <span class="material-symbols-outlined text-[40px] text-primary animate-spin">progress_activity</span>
        <p class="mt-3 font-body-md text-body-md text-on-surface-variant">
            Loading diary...
        </p>
    </div>

    <!-- Error -->
    <div id="diaryError"
         class="hidden bg-surface-container-lowest rounded-xl shadow-sm p-10 flex-col items-center justify-center text-center">
        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-error">
            <span class="material-symbols-outlined text-[32px]">error</span>
        </div>

        <h3 class="font-headline-md text-headline-md text-on-surface mt-4">
            Unable to Load Diary
        </h3>

        <p id="diaryErrorMessage"
           class="font-body-md text-body-md text-on-surface-variant mt-1">
            Something went wrong.
        </p>

        <button onclick="loadDiary()"
                class="mt-5 px-4 py-2 rounded-lg bg-primary text-on-primary font-label-md text-label-md">
            Try Again
        </button>
    </div>

    <!-- Content -->
    <div id="diaryContent" class="hidden flex-col w-full">

        <!-- Student Header -->
        <section class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg mb-space-lg mt-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">

                <div class="flex items-center gap-space-md">

                    <div class="relative">
                        <div id="studentImageWrapper"
                             class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-secondary font-headline-md font-bold overflow-hidden ring-2 ring-secondary">

                            <img id="studentImage"
                                 class="hidden w-full h-full object-cover"
                                 alt="Student">

                            <span id="studentInitial">S</span>
                        </div>

                        <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-surface-container-lowest flex items-center justify-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-secondary-fixed-dim"></span>
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex items-center gap-space-sm flex-wrap">
                            <h1 id="studentName"
                                class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                                —
                            </h1>

                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-secondary-fixed/25 text-on-secondary-container font-label-sm text-label-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                Active
                            </span>
                        </div>

                        <div class="flex items-center gap-x-space-sm gap-y-1 mt-1 text-on-surface-variant font-body-sm text-body-sm flex-wrap">

                            <span id="studentCode"
                                  class="font-tabular-numeric font-medium text-on-surface">
                                —
                            </span>

                            <span class="text-outline-variant">•</span>

                            <span class="font-medium text-on-surface">
                                <span id="studentClass">—</span>
                                •
                                <span id="studentSection">—</span>
                            </span>

                            <span class="text-outline-variant">•</span>

                            <span>
                                
                                <strong id="studentSession"
                                        class="font-tabular-numeric font-medium text-on-surface">
                                    —
                                </strong>
                            </span>

                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-space-sm">
                    <div class="flex items-center gap-space-sm bg-surface-container-low px-space-md py-space-sm rounded-lg self-start md:self-auto">
                        <div class="flex flex-col">
                            <span class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                                Diary Entries
                            </span>

                            <span id="diaryCount"
                                class="font-label-lg text-label-lg font-semibold text-primary">
                                0 Entries
                            </span>
                        </div>
                    </div>
                    <a href="/parent/dashboard" data-spa-link
                    class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-container-low text-primary hover:bg-primary hover:text-on-primary transition-colors"
                    title="Back to Dashboard">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Date Navigation -->
        <section class="bg-surface-container-lowest rounded-xl shadow-sm p-space-md mb-space-lg flex flex-col md:flex-row items-stretch md:items-center justify-between gap-space-md">

            <div class="flex items-center justify-between md:justify-start gap-space-sm">

                <button id="previousDay"
                        type="button"
                        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-surface-container-low text-on-surface hover:bg-surface-container transition-colors font-label-md text-label-md">
                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    <span>Previous Day</span>
                </button>

                <div class="flex items-center gap-space-xs bg-surface-container-low px-space-md py-2 rounded-lg">
                    <span class="material-symbols-outlined text-[18px] text-primary">
                        calendar_today
                    </span>

                    <span id="selectedDate"
                          class="font-label-lg text-label-lg text-on-surface font-semibold">
                        —
                    </span>

                    <span id="todayBadge"
                          class="hidden ml-1.5 px-2 py-0.5 rounded-full bg-primary-container text-on-primary font-label-sm text-label-sm">
                        Today
                    </span>
                </div>

                <button id="nextDay"
                        type="button"
                        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-surface-container-low text-on-surface hover:bg-surface-container transition-colors font-label-md text-label-md">
                    <span>Next Day</span>
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </button>

            </div>

        </section>

        <!-- Feed Header -->
        <div class="flex items-center justify-between mb-space-md">

            <div class="flex flex-col">

                <div class="flex items-center gap-2">

                    <h2 class="font-headline-md text-headline-md text-on-surface">
                        Daily Diary
                    </h2>

                    <span id="subjectCount"
                          class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-tabular-numeric text-label-sm font-semibold">
                        0 Subjects
                    </span>

                </div>

                <p id="diaryDescription"
                   class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                    Published diary entries
                </p>

            </div>

        </div>

        <!-- Diary Feed -->
        <div id="diaryFeed"
             class="flex flex-col gap-space-lg">
        </div>

        <!-- Empty -->
        <div id="emptyDiaryState"
             class="hidden bg-surface-container-lowest rounded-xl shadow-sm p-12 flex-col items-center justify-center text-center">

            <div class="w-20 h-20 rounded-full bg-surface-container-low flex items-center justify-center text-outline mb-space-md">
                <span class="material-symbols-outlined text-[40px]">event_busy</span>
            </div>

            <h3 class="font-headline-md text-headline-md text-on-surface mb-1">
                No Diary Entries for this Date
            </h3>

            <p class="font-body-md text-body-md text-on-surface-variant max-w-md">
                There are no published diary entries for this student on this date.
            </p>

        </div>

    </div>
</div>

<script>
(()=>{
const token = localStorage.getItem('student_diary_token');
const instituteCode = localStorage.getItem('student_diary_institute_code');
const API_BASE = '/api/v1';
const studentId = @json(request()->route('student'));

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

        window.location.href = instituteCode
            ? `/login/${instituteCode}`
            : '/';

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

function formatDate(date) {
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
}

function getSelectedDate() {
    const params = new URLSearchParams(window.location.search);
    return params.get('date') || formatDate(new Date());
}

function formatDisplayDate(dateString) {
    const [year, month, day] = dateString.split('-').map(Number);
    const date = new Date(year, month - 1, day);

    return date.toLocaleDateString('en-GB', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

function getStudentImage(student) {
    return student?.profile_picture || null;
}

async function loadStudent() {
    const response = await fetchJson(`${API_BASE}/parent/children`);
    const children = response?.data?.data ?? response?.data ?? [];

    return children.find(child => Number(child.id) === Number(studentId)) || null;
}

async function loadDiaryEntriesForDate(date) {
    const response = await fetchJson(
        `${API_BASE}/parent/students/${studentId}/diaries?date=${date}`
    );
    return response?.data?.data ?? response?.data ?? [];
}
async function loadDiaryEntries() {
    return loadDiaryEntriesForDate(getSelectedDate());
}

function renderStudent(student) {
    if (!student) return;

    document.getElementById('studentName').textContent =
        student.name || '—';

    document.getElementById('studentCode').textContent =
        student.student_code || '—';

    document.getElementById('studentClass').textContent =
        student.class?.name || '—';

    document.getElementById('studentSection').textContent =
        student.section?.name || '—';

    document.getElementById('studentSession').textContent =
        student.academic_session?.name || '—';

    document.getElementById('studentInitial').textContent =
        (student.name || 'S').charAt(0).toUpperCase();

    const image = getStudentImage(student);

    if (image) {
        document.getElementById('studentImage').src = image;
        document.getElementById('studentImage').classList.remove('hidden');
        document.getElementById('studentInitial').classList.add('hidden');
    }
}

function renderDate() {
    const date = getSelectedDate();
    const today = formatDate(new Date());

    document.getElementById('selectedDate').textContent =
        formatDisplayDate(date);

    document.getElementById('todayBadge').classList.toggle(
        'hidden',
        date !== today
    );

    document.getElementById('diaryDescription').textContent =
        `Published diary entries for ${formatDisplayDate(date)}`;

    const nextButton = document.getElementById('nextDay');

    nextButton.disabled = date >= today;
    nextButton.classList.toggle('opacity-50', date >= today);
    nextButton.classList.toggle('cursor-not-allowed', date >= today);
}

function renderEntries(entries) {
    const feed = document.getElementById('diaryFeed');
    const empty = document.getElementById('emptyDiaryState');

    feed.innerHTML = '';

    document.getElementById('diaryCount').textContent =
        `${entries.length} ${entries.length === 1 ? 'Entry' : 'Entries'}`;

    document.getElementById('subjectCount').textContent =
        `${entries.length} ${entries.length === 1 ? 'Subject' : 'Subjects'}`;

    if (!entries.length) {
        feed.classList.add('hidden');
        empty.classList.remove('hidden');
        empty.classList.add('flex');
        return;
    }

    feed.classList.remove('hidden');
    empty.classList.add('hidden');
    empty.classList.remove('flex');

    entries.forEach(entry => {
        feed.insertAdjacentHTML('beforeend', createDiaryCard(entry));
    });
}

function createDiaryCard(entry) {
    const homework = entry.homework || entry.homework_details;
    const classwork = entry.classwork || entry.classwork_details;

    return `
        <article class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg flex flex-col gap-space-md hover:shadow-md transition-shadow">

            <div class="flex items-start justify-between gap-space-md">
                <div class="flex items-center gap-space-sm">

                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[24px]">
                            ${entry.icon || 'menu_book'}
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex items-center gap-space-xs flex-wrap">

                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">
                                ${entry.subject?.name || entry.subject || 'Subject'}
                            </h3>

                            ${entry.period ? `
                                <span class="px-2 py-0.5 rounded-full bg-surface-container-high text-on-surface font-label-sm text-label-sm">
                                    Period ${entry.period}
                                </span>
                            ` : ''}

                        </div>

                        <span class="font-body-sm text-body-sm text-on-surface-variant">
                            Teacher: ${entry.teacher?.name || entry.teacher_name || '—'}
                        </span>
                    </div>
                </div>

                ${homework ? `
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed/20 text-on-secondary-fixed-variant font-label-sm text-label-sm font-semibold">
                        <span class="material-symbols-outlined text-[14px]">edit_note</span>
                        Homework
                    </span>
                ` : `
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">
                        <span class="material-symbols-outlined text-[14px]">done_all</span>
                        Class Completed
                    </span>
                `}
            </div>

            ${homework ? `
                <div class="bg-surface-container-low rounded-lg p-space-md relative overflow-hidden">

                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-secondary"></div>

                    <div class="pl-2">

                        <div class="flex items-center justify-between mb-1.5 flex-wrap gap-2">

                            <div class="inline-flex items-center gap-1.5 text-primary font-label-md text-label-md tracking-wider uppercase font-semibold">
                                <span class="material-symbols-outlined text-[18px]">assignment</span>
                                <span>HOMEWORK</span>
                            </div>

                            ${entry.due_date ? `
                                <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-container text-tertiary font-label-sm text-label-sm font-medium">
                                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                                    <span>Due: ${entry.due_date}</span>
                                </div>
                            ` : ''}

                        </div>

                        <p class="font-body-lg text-body-lg text-on-surface font-medium leading-relaxed">
                            ${homework}
                        </p>

                    </div>
                </div>
            ` : `
                <div class="bg-surface-container-low/60 rounded-lg p-space-md flex items-center gap-space-sm">

                    <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[18px]">task_alt</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="font-label-md text-label-md font-semibold text-primary">
                            No homework assigned today
                        </span>

                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            All classroom exercises were completed during the period.
                        </p>
                    </div>

                </div>
            `}

            ${classwork ? `
                <div class="bg-surface rounded-lg p-space-sm px-space-md flex items-start gap-space-xs text-on-surface-variant">

                    <span class="material-symbols-outlined text-[18px] text-outline mt-0.5">
                        school
                    </span>

                    <p class="font-body-md text-body-md text-on-surface leading-normal">
                        <span class="font-semibold text-on-surface">Classwork:</span>
                        ${classwork}
                    </p>

                </div>
            ` : ''}

            <div class="flex items-center justify-end pt-space-xs flex-wrap gap-space-sm">

                ${entry.attachments_count ? `
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-surface-container text-on-surface-variant font-label-sm text-label-sm">
                        <span class="material-symbols-outlined text-[16px]">attachment</span>
                        <span>${entry.attachments_count} Attachments</span>
                    </div>
                ` : ''}

                <a href="/parent/diaries/${entry.id}"
                data-spa-link
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-on-primary text-sm">
                    <span>View Details</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>

            </div>

        </article>
    `;
}

async function changeDate(days) {
    const [year, month, day] = getSelectedDate().split('-').map(Number);
    const date = new Date(year, month - 1, day);

    date.setDate(date.getDate() + days);

    const newDate = formatDate(date);
    const today = formatDate(new Date());

    if (newDate > today) return;

    const nextButton = document.getElementById('nextDay');
    const previousButton = document.getElementById('previousDay');

    nextButton.disabled = true;
    previousButton.disabled = true;

    try {
        const entries = await loadDiaryEntriesForDate(newDate);

        history.pushState(
            { date: newDate },
            '',
            `/parent/children/${studentId}/diary?date=${newDate}`
        );

        renderEntries(entries);
        renderDate();

    } catch (error) {
        console.error('Unable to change diary date:', error);
    } finally {
        previousButton.disabled = false;
        renderDate();
    }
}

async function loadDiary() {
    const loading = document.getElementById('diaryLoading');
    const content = document.getElementById('diaryContent');
    const error = document.getElementById('diaryError');

    loading.classList.remove('hidden');
    content.classList.add('hidden');
    error.classList.add('hidden');

    try {
        const [student, entries] = await Promise.all([
            loadStudent(),
            loadDiaryEntries()
        ]);

        if (!student) {
            throw new Error('Student not found.');
        }

        renderStudent(student);
        renderDate();
        renderEntries(entries);

        loading.classList.add('hidden');
        content.classList.remove('hidden');
        content.classList.add('flex');

    } catch (error) {
        console.error('Diary page error:', error);

        loading.classList.add('hidden');
        const errorBox = document.getElementById('diaryError');
        errorBox.classList.remove('hidden');
        errorBox.classList.add('flex');

        document.getElementById('diaryErrorMessage').textContent =
            error.message || 'Unable to load diary.';

    }
}

document.getElementById('previousDay').addEventListener(
    'click',
    () => changeDate(-1)
);

document.getElementById('nextDay').addEventListener(
    'click',
    () => changeDate(1)
);

loadDiary();
})();
</script>

@endsection