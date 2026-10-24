@extends('layouts.teacher')

@section('title', 'Uniform & Cleanliness - Student Diary')

@section('content')

<div class="flex flex-col w-full gap-space-lg">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
        <div>
            <h1 class="mt-4 font-headline-lg text-headline-lg text-on-surface tracking-tight">
                Uniform & Cleanliness
            </h1>
            <p id="classSubtitle" class="mt-0.5 font-body-md text-body-md text-on-surface-variant">
                Loading class and section information...
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span id="totalStudentsBadge" class="rounded-lg bg-primary/10 px-4 py-2 text-sm font-semibold text-primary">
                Total Students: 0
            </span>
            <button type="button"
                id="saveReportsBtn"
                onclick="submitReports()"
                class="flex items-center gap-1.5 rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Save Reports
            </button>
        </div>
    </div>
    
    <!-- Filters / Date Selection -->
    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-end gap-4">
            <div class="flex-1">
                <label for="reportDate" class="mb-1 block text-sm font-medium text-on-surface">
                    Report Date
                </label>
                <input type="date"
                    id="reportDate"
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
            </div>
            <div class="flex-1">
                <label for="studentSearchInput" class="mb-1 block text-sm font-medium text-on-surface">
                    Search Student
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-outline">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                    </span>
                    <input type="text"
                        id="studentSearchInput"
                        placeholder="Type student name or roll number..."
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

    <!-- Alert Box -->
    <div id="alertBox" class="hidden rounded-lg p-4 text-sm" role="alert"></div>

    <!-- Students Checklist Table -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-space-md border-b border-outline-variant">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">
                    Class Students Checklist
                </h2>
            </div>
            <p id="tableStatusInfo" class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                Loading student checklist...
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Roll #</th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">Student Name</th>
                        <th class="text-center px-4 py-3 font-label-sm text-label-sm text-outline">Uniform Status</th>
                        <th class="text-center px-4 py-3 font-label-sm text-label-sm text-outline">Cleanliness Status</th>
                        <th class="text-center px-4 py-3 font-label-sm text-label-sm text-outline">Parents Signature</th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody" class="divide-y divide-outline-variant">
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-on-surface-variant">
                            Loading students list...
                        </td>
                    </tr>
                </tbody>
            </table>
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
(() => {
    const API_BASE = '/api/v1/teacher';
    const token = localStorage.getItem('student_diary_token');

    if (!token) {
        window.location.replace('/');
        return;
    }

    const headers = {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    };

    const $ = id => document.getElementById(id);

    // Set today's date in datepicker by default
    const todayStr = new Date().toISOString().split('T')[0];
    $('reportDate').value = todayStr;

    let currentClassInfo = null;
    let rawStudentsList = [];
    let currentReportsMap = {};

    async function loadInchargeData(selectedDate = '') {
        const dateParam = selectedDate || $('reportDate').value || todayStr;

        try {
            $('studentsTableBody').innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-on-surface-variant">
                        Loading students list...
                    </td>
                </tr>`;

            const response = await fetch(`${API_BASE}/incharge-students?date=${dateParam}`, { headers });
            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Failed to load class information.');
            }

            currentClassInfo = result.class_info;
            rawStudentsList = result.students || [];
            currentReportsMap = result.existing_reports || {};

            const className = currentClassInfo.school_class?.name || 'Class';
            const sectionName = currentClassInfo.section?.name || '';
            $('classSubtitle').textContent = `Class In-charge: ${className} — ${sectionName}`;
            $('totalStudentsBadge').textContent = `Total Students: ${rawStudentsList.length}`;
            $('tableStatusInfo').textContent = `Showing ${rawStudentsList.length} students`;

            renderStudentsTable(rawStudentsList, currentReportsMap);
        } catch (error) {
            console.error(error);
            showAlert(error.message, 'error');
            $('studentsTableBody').innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-error">
                        ${escapeHtml(error.message)}
                    </td>
                </tr>`;
            $('classSubtitle').textContent = 'Unable to load class info.';
        }
    }

    function renderStudentsTable(students, reports) {
        if (!students.length) {
            $('studentsTableBody').innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-on-surface-variant">
                        No students found in your assigned class.
                    </td>
                </tr>`;
            return;
        }

        // Check karein ke selected date ki report pehle se maujood hai ya nahi
        const hasExistingReports = Object.keys(reports).length > 0;
        const saveBtn = $('saveReportsBtn');

        if (hasExistingReports) {
            saveBtn.disabled = true;
            saveBtn.className = "flex items-center gap-1.5 rounded-lg bg-outline-variant px-5 py-2 text-sm font-semibold text-outline cursor-not-allowed opacity-80";
            saveBtn.innerHTML = `<span class="material-symbols-outlined text-[18px]">check_circle</span> Submitted`;
        } else {
            saveBtn.disabled = false;
            saveBtn.className = "flex items-center gap-1.5 rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90 transition-opacity";
            saveBtn.innerHTML = `<span class="material-symbols-outlined text-[18px]">save</span> Save Reports`;
        }

        $('studentsTableBody').innerHTML = students.map((student, index) => {
            const report = reports[student.id];
            const isSubmitted = Boolean(report);

            const uniformStatus = report?.uniform_status || 'Proper';
            const cleanlinessStatus = report?.cleanliness_status || 'Good';
            const parentSigned = Boolean(report?.parent_signed);

            const studentName = student.name || student.user?.name || '—';
            const rollNumber = student.roll_number || student.admission_no || `${index + 1}`;

            return `
                <tr class="hover:bg-surface-container-low/50 transition-colors" data-student-id="${student.id}">
                    <td class="px-4 py-3 font-body-sm text-body-sm text-on-surface-variant">
                        ${escapeHtml(rollNumber)}
                    </td>
                    <td class="px-4 py-3 font-medium text-on-surface">
                        ${escapeHtml(studentName)}
                    </td>

                    <!-- Uniform Status Column -->
                    <td class="px-4 py-3 text-center">
                        ${isSubmitted ? `
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${
                                uniformStatus === 'Proper' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'
                            }">
                                ${escapeHtml(uniformStatus)}
                            </span>
                        ` : `
                            <div class="inline-flex items-center gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="uniform_${student.id}" value="Proper" 
                                        ${uniformStatus === 'Proper' ? 'checked' : ''} 
                                        class="text-primary focus:ring-primary h-4 w-4">
                                    <span class="text-xs font-medium text-on-surface">Proper</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="uniform_${student.id}" value="Improper" 
                                        ${uniformStatus === 'Improper' ? 'checked' : ''} 
                                        class="text-red-600 focus:ring-red-500 h-4 w-4">
                                    <span class="text-xs font-medium text-on-surface">Improper</span>
                                </label>
                            </div>
                        `}
                    </td>

                    <!-- Cleanliness Status Column -->
                    <td class="px-4 py-3 text-center">
                        ${isSubmitted ? `
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${
                                cleanlinessStatus === 'Good' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'
                            }">
                                ${escapeHtml(cleanlinessStatus)}
                            </span>
                        ` : `
                            <div class="inline-flex items-center gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="cleanliness_${student.id}" value="Good" 
                                        ${cleanlinessStatus === 'Good' ? 'checked' : ''} 
                                        class="text-primary focus:ring-primary h-4 w-4">
                                    <span class="text-xs font-medium text-on-surface">Good</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="cleanliness_${student.id}" value="Needs Improvement" 
                                        ${cleanlinessStatus === 'Needs Improvement' ? 'checked' : ''} 
                                        class="text-red-600 focus:ring-red-500 h-4 w-4">
                                    <span class="text-xs font-medium text-on-surface">Needs Improvement</span>
                                </label>
                            </div>
                        `}
                    </td>

                    <!-- Parent Signature Status Column -->
                    <td class="px-4 py-3 text-center">
                        ${isSubmitted ? (
                            parentSigned ? `
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                    Signed
                                </span>
                            ` : `
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">
                                    Pending Signature
                                </span>
                            `
                        ) : `
                            <span class="text-xs text-outline">—</span>
                        `}
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Date Picker Change Listener
    $('reportDate').addEventListener('change', (e) => {
        loadInchargeData(e.target.value);
    });

    $('filterButton').addEventListener('click', () => {
        loadInchargeData($('reportDate').value);
    });

    window.submitReports = async function() {
        if (!currentClassInfo) return;

        const selectedDate = $('reportDate').value || todayStr;
        const rows = document.querySelectorAll('#studentsTableBody tr[data-student-id]');
        const reportsPayload = [];

        rows.forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            const uniform = row.querySelector(`input[name="uniform_${studentId}"]:checked`)?.value || 'Proper';
            const cleanliness = row.querySelector(`input[name="cleanliness_${studentId}"]:checked`)?.value || 'Good';

            reportsPayload.push({
                student_id: studentId,
                class_id: currentClassInfo.class_id,
                section_id: currentClassInfo.section_id,
                report_date: selectedDate,
                uniform_status: uniform,
                cleanliness_status: cleanliness
            });
        });

        const saveBtn = $('saveReportsBtn');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';

        try {
            const response = await fetch(`${API_BASE}/daily-reports`, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({ 
                    report_date: selectedDate,
                    reports: reportsPayload 
                })
            });

            const result = await response.json();
            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Failed to save daily reports.');
            }

            showToast(result.message || 'Uniform & cleanliness reports saved successfully.');
            // Reload data to convert input rows into read-only badges
            await loadInchargeData(selectedDate);
        } catch (error) {
            console.error(error);
            showAlert(error.message, 'error');
            saveBtn.disabled = false;
            saveBtn.innerHTML = `<span class="material-symbols-outlined text-[18px]">save</span> Save Reports`;
        }
    };

    // Search filter implementation
    $('studentSearchInput').addEventListener('input', e => {
        const query = e.target.value.toLowerCase().trim();
        const filtered = rawStudentsList.filter(s => {
            const name = (s.name || s.user?.name || '').toLowerCase();
            const roll = String(s.roll_number || s.admission_no || '').toLowerCase();
            return name.includes(query) || roll.includes(query);
        });
        renderStudentsTable(filtered, currentReportsMap);
    });

    $('resetFilters').addEventListener('click', () => {
        $('studentSearchInput').value = '';
        $('reportDate').value = todayStr;
        loadInchargeData(todayStr);
    });

    function showAlert(message, type = 'success') {
        const box = $('alertBox');
        box.className = `mb-4 p-4 rounded-lg text-sm ${type === 'error' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-green-50 text-green-700 border border-green-200'}`;
        box.textContent = message;
        box.classList.remove('hidden');
        setTimeout(() => box.classList.add('hidden'), 4000);
    }

    function showToast(message) {
        const toast = $('toastNotification');
        $('toastMessage').textContent = message;

        toast.classList.remove('translate-y-16', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add('translate-y-16', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Initial load
    loadInchargeData(todayStr);
})();
</script>

@endsection