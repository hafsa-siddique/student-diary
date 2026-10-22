@extends('layouts.teacher')

@section('title', 'Homework Review - Student Diary')

@section('content')

<div class="flex flex-col w-full gap-space-lg">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
        <div>
            <h1 class="mt-4 font-headline-lg text-headline-lg text-on-surface tracking-tight">
                Classes Review
            </h1>
            <p class="mt-0.5 font-body-md text-body-md text-on-surface-variant">
                Review yesterday's student completion status and parent remarks.
            </p>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-end gap-4">
            <div class="flex-1">
                <label for="reviewDate" class="mb-1 block text-sm font-medium text-on-surface">
                    Review Date
                </label>
                <input type="date"
                    id="reviewDate"
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
            </div>
            <div class="flex-1">
                <label for="classSearchInput" class="mb-1 block text-sm font-medium text-on-surface">
                    Search Class / Subject
                </label>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-outline">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                    </span>

                    <input type="text"
                        id="classSearchInput"
                        placeholder="Type class, section, or subject..."
                        class="w-full pl-9 pr-3 py-2 rounded-lg border border-outline-variant bg-surface text-on-surface">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button"
                    id="filterButton"
                    class="flex items-center gap-1.5 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">
                    <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                    Filter
                </button>
                <button type="button"
                    id="resetFilters"
                    class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Assigned Classes / Lectures Table -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-space-md border-b border-outline-variant">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">
                    Assigned Classes
                </h2>
            </div>
            <p id="lectureCount" class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                Loading assigned classes...
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Class / Section
                        </th>

                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Subject
                        </th>

                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Academic Session
                        </th>

                        <th class="text-center px-5 py-3 font-label-sm text-label-sm text-outline">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody id="lecturesTable">
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-on-surface-variant">
                            Loading assigned classes...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODAL 1: HOMEWORK REVIEW MODAL ================= -->
<div id="studentReviewModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
     role="dialog"
     aria-modal="true">
    <div class="w-full max-w-4xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="modalTitle" class="font-headline-md text-headline-md text-on-surface">
                    Student Homework Status
                </h2>
                <p id="modalSubtitle" class="mt-1 text-sm text-on-surface-variant">
                    Review student completion status and parent notes.
                </p>
            </div>
            <button type="button"
                    onclick="closeStudentModal()"
                    class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
                    aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Summary Cards Inside Modal -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-5 border-b border-outline-variant bg-surface-container-low/50 shrink-0">
            <div class="bg-surface-container p-3 rounded-xl border border-outline-variant/60 border-l-4 border-l-primary shadow-2xs flex items-center justify-between">
                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-medium">Total</span>
                <p id="statTotal" class="font-headline-sm text-headline-sm font-bold text-on-surface">0</p>
            </div>

            <div class="bg-green-50/50 p-3 rounded-xl border border-outline-variant/60 border-l-4 border-l-green-600 shadow-2xs flex items-center justify-between">
                <span class="font-label-sm text-label-sm text-green-700 uppercase font-medium">Completed</span>
                <p id="statCompleted" class="font-headline-sm text-headline-sm font-bold text-green-600">0</p>
            </div>

            <div class="bg-red-50/50 p-3 rounded-xl border border-outline-variant/60 border-l-4 border-l-red-600 shadow-2xs flex items-center justify-between">
                <span class="font-label-sm text-label-sm text-red-700 uppercase font-medium">Pending</span>
                <p id="statPending" class="font-headline-sm text-headline-sm font-bold text-red-600">0</p>
            </div>

            <div class="bg-amber-50/50 p-3 rounded-xl border border-outline-variant/60 border-l-4 border-l-amber-500 shadow-2xs flex items-center justify-between">
                <span class="font-label-sm text-label-sm text-amber-700 uppercase font-medium">Parent Remarks</span>
                <p id="statRemarks" class="font-headline-sm text-headline-sm font-bold text-amber-600">0</p>
            </div>
        </div>

        <!-- Student List Table -->
        <div class="overflow-y-auto flex-1 min-h-0">
            <table class="w-full">
                <thead class="sticky top-0 bg-surface-container-low z-10">
                    <tr>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Roll #</th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Student Name</th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Homework Status</th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Parent Remarks</th>
                        <th class="text-right px-5 py-3 font-label-sm text-label-sm text-outline">Actions</th>
                    </tr>
                </thead>

                <tbody id="studentListContainer" class="divide-y divide-outline-variant">
                    <!-- Dynamic student rows -->
                </tbody>
            </table>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
            <button type="button"
                    onclick="closeStudentModal()"
                    class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toastNotification"
     class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300">
    <span id="toastIcon" class="material-symbols-outlined text-secondary-fixed text-[20px]">
        check_circle
    </span>
    <span id="toastMessage" class="font-body-sm text-body-sm">
        Action completed successfully.
    </span>
</div>

<script>
(()=>{
const token = localStorage.getItem('student_diary_token');
const API_BASE = '/api/v1';
const headers = {
    Authorization: `Bearer ${token}`,
    Accept: 'application/json',
    'Content-Type': 'application/json'
};

let allAssignments = [];

const yesterday = new Date();
yesterday.setDate(yesterday.getDate() - 1);
document.getElementById('reviewDate').value = yesterday.toISOString().split('T')[0];

function showToast(message, isError = false) {
    const toast = document.getElementById('toastNotification');
    const toastMessage = document.getElementById('toastMessage');
    const toastIcon = document.getElementById('toastIcon');

    toastMessage.textContent = message;
    toastIcon.textContent = isError ? 'error' : 'check_circle';
    toastIcon.className = `material-symbols-outlined text-[20px] ${isError ? 'text-red-400' : 'text-secondary-fixed'}`;

    toast.classList.remove('translate-y-16', 'opacity-0', 'pointer-events-none');
    setTimeout(() => {
        toast.classList.add('translate-y-16', 'opacity-0', 'pointer-events-none');
    }, 3000);
}

async function fetchJson(url) {
    const res = await fetch(url, { headers });
    const data = await res.json();
    if (!res.ok) {
        throw new Error(data.message || 'API Request Failed');
    }
    return data;
}

async function loadAssignedLectures() {
    const tbody = document.getElementById('lecturesTable');
    const countLabel = document.getElementById('lectureCount');

    try {
        const response = await fetchJson(`${API_BASE}/teacher/assignments`);
        allAssignments = response.data || [];
        
        countLabel.textContent = `Showing ${allAssignments.length} Assigned Classes`;
        renderLecturesTable(allAssignments);

    } catch (err) {
        console.error('Failed to load assigned classes:', err);
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-10 text-center text-red-600">
                    Failed to load assigned classes.
                </td>
            </tr>
        `;
        countLabel.textContent = '0 Classes';
    }
}

function renderLecturesTable(data) {
    const tbody = document.getElementById('lecturesTable');

    if (!data.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-10 text-center text-on-surface-variant">
                    No assigned classes found.
                </td>
            </tr>
        `;
        return;
    }

    // CHECK FOR LAST WORKING DAY (5 = Friday, 6 = Saturday)
    const today = new Date();
    const dayOfWeek = today.getDay(); 
    const isLastWorkingDay = (dayOfWeek === 1 || dayOfWeek === 3);

    tbody.innerHTML = data.map(item => {
        const classObj = item.school_class || item.class || {};
        const sectionObj = item.section || {};
        const subjectObj = item.subject || {};

        const className = classObj.name || item.class_name || '—';
        const sectionName = sectionObj.name || item.section_name || '—';
        const subjectName = subjectObj.name || item.subject_name || '—';

        const classId = classObj.id || item.class_id;
        const sectionId = sectionObj.id || item.section_id;

        return `
            <tr class="border-b border-outline-variant hover:bg-surface-container-low/50 transition-colors">
                <td class="px-4 py-3 font-medium text-on-surface">
                    ${className} (${sectionName})
                </td>

                <td class="px-4 py-3 text-primary font-medium">
                    ${subjectName}
                </td>

                <td class="px-4 py-3 text-on-surface-variant text-sm">
                    ${item.academic_session?.name || 'Current Session'}
                </td>

                <td class="px-5 py-3 text-center flex items-center justify-center gap-2">
                    <button type="button"
                            onclick="openStudentReview(${item.id}, '${className}', '${sectionName}', '${subjectName}')"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-primary text-white px-3.5 py-1.5 text-xs font-semibold hover:bg-primary hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                        Review Homework
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

function filterLectures() {
    const query = document.getElementById('classSearchInput').value.toLowerCase().trim();
    const filtered = allAssignments.filter(item => {
        const className = (item.school_class?.name || item.class_name || '').toLowerCase();
        const sectionName = (item.section?.name || item.section_name || '').toLowerCase();
        const subjectName = (item.subject?.name || item.subject_name || '').toLowerCase();
        return className.includes(query) || sectionName.includes(query) || subjectName.includes(query);
    });
    renderLecturesTable(filtered);
    document.getElementById('lectureCount').textContent = `Showing ${filtered.length} of ${allAssignments.length} Classes`;
}

document.getElementById('filterButton').addEventListener('click', filterLectures);
document.getElementById('classSearchInput').addEventListener('keyup', filterLectures);

document.getElementById('resetFilters').addEventListener('click', () => {
    document.getElementById('classSearchInput').value = '';
    renderLecturesTable(allAssignments);
    document.getElementById('lectureCount').textContent = `Showing ${allAssignments.length} Assigned Classes`;
});

window.openStudentReview = async function(assignmentId, className, sectionName, subjectName) {
    const date = document.getElementById('reviewDate').value;
    const modal = document.getElementById('studentReviewModal');
    const tbody = document.getElementById('studentListContainer');

    document.getElementById('modalTitle').textContent = `${className} (${sectionName}) - ${subjectName}`;
    document.getElementById('modalSubtitle').textContent = `Reviewing Homework Status for Date: ${date}`;

    tbody.innerHTML = `
        <tr>
            <td colspan="5" class="px-4 py-10 text-center text-on-surface-variant">
                Loading students status...
            </td>
        </tr>
    `;

    modal.classList.remove('hidden');

    try {
        const response = await fetchJson(`${API_BASE}/teacher/assignments/${assignmentId}/homework-review?date=${date}`);
        const result = response.data;

        document.getElementById('statTotal').textContent = result.summary.total;
        document.getElementById('statCompleted').textContent = result.summary.completed;
        document.getElementById('statPending').textContent = result.summary.pending;
        document.getElementById('statRemarks').textContent = result.summary.new_remarks;

        if (!result.students.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-on-surface-variant">
                        No active students found for this class & section.
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = result.students.map(student => `
            <tr class="border-b border-outline-variant hover:bg-surface-container-low/50 transition-colors">
                <td class="px-4 py-3 font-medium text-on-surface">${student.student_id}</td>
                <td class="px-4 py-3 font-semibold text-on-surface">${student.student_name}</td>
                <td class="px-4 py-3">
                    ${student.is_completed ? `
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Completed
                        </span>
                    ` : `
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-red-100 text-red-800 text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Pending
                        </span>
                    `}
                </td>
                <td class="px-4 py-3 max-w-xs">
                    ${student.remarks ? `
                        <div class="bg-surface p-2 rounded-lg border border-outline-variant text-xs text-on-surface">
                            "${student.remarks}"
                        </div>
                    ` : `<span class="text-xs text-outline italic">No remarks written</span>`}
                </td>
                <td class="px-5 py-3 text-right">
                    ${student.feedback_id && student.remarks ? `
                        ${student.teacher_acknowledged ? `
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-green-50 text-green-700 text-xs font-semibold">
                                <span class="material-symbols-outlined text-[16px]">done_all</span> Seen
                            </span>
                        ` : `
                            <button type="button"
                                    onclick="acknowledgeRemark(${student.feedback_id}, this)"
                                    class="rounded-lg bg-primary px-3 py-1.5 text-xs font-semibold text-white hover:opacity-90 transition-opacity">
                                Mark as Seen
                            </button>
                        `}
                    ` : `<span class="text-xs text-outline">—</span>`}
                </td>
            </tr>
        `).join('');

    } catch (err) {
        console.error('Error fetching homework status:', err);
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-10 text-center text-red-600">
                    Failed to load homework data.
                </td>
            </tr>
        `;
    }
};

window.closeStudentModal = function() {
    document.getElementById('studentReviewModal').classList.add('hidden');
};

window.acknowledgeRemark = async function(feedbackId, btn) {
    try {
        const res = await fetch(`${API_BASE}/teacher/feedbacks/${feedbackId}/acknowledge`, {
            method: 'POST',
            headers
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message);

        showToast('Parent remark marked as seen.');

        btn.outerHTML = `
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-green-50 text-green-700 text-xs font-semibold">
                <span class="material-symbols-outlined text-[16px]">done_all</span> Seen
            </span>
        `;
    } catch (err) {
        showToast(err.message || 'Error updating status', true);
    }
};

loadAssignedLectures();
})();
</script>

@endsection