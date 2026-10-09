@extends('layouts.admin')

@section('title', 'Student Directory')

@section('content')

<div class="flex flex-col gap-space-lg w-full">
<!-- Page Header -->
<div class="flex flex-col gap-1">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mt-2">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                Students
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                Manage students belonging to your institute and monitor their enrollment status.
            </p>
        </div>

        <button
            type="button"
            id="openAddStudentModal"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-container text-on-primary hover:bg-primary transition-all rounded-lg shadow-sm font-label-lg text-label-lg active:scale-[0.98]"
        >
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span>Add Student</span>
        </button>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
        <div class="flex flex-col">
            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                Total Students
            </span>
            <span id="totalStudents" class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">
                —
            </span>
            <span class="font-body-sm text-body-sm text-primary flex items-center gap-1 mt-0.5">
                <span class="material-symbols-outlined text-[16px]">groups</span>
                All institute students
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[26px]">groups</span>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
        <div class="flex flex-col">
            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                Active Students
            </span>
            <span id="activeStudents" class="font-display-lg text-display-lg text-secondary mt-1 font-tabular-numeric">
                —
            </span>
            <span id="activeStudentsPercentage" class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                Loading...
            </span>
        </div>

        <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined text-[26px]">person_check</span>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
        <div class="flex flex-col">
            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                Inactive Students
            </span>
            <span id="inactiveStudents" class="font-display-lg text-display-lg text-tertiary mt-1 font-tabular-numeric">
                —
            </span>
            <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                <span class="material-symbols-outlined text-[16px]">person_off</span>
                Inactive accounts
            </span>
        </div>

        <div class="w-12 h-12 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary">
            <span class="material-symbols-outlined text-[26px]">person_off</span>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
        <div class="flex flex-col">
            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                Active Percentage
            </span>
            <span id="activePercentage" class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">
                0%
            </span>
            <span id="currentSessionName" class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                Loading session...
            </span>
        </div>

        <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[26px]">percent</span>
        </div>
    </div>

</div>

<!-- Search & Filter -->
<div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-space-md">

    <div class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center gap-3">

        <div class="relative flex-1 min-w-[280px]">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">
                search
            </span>

            <input
                type="text"
                id="searchInput"
                class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface text-on-surface font-body-sm text-body-sm placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:shadow-sm transition-all"
                placeholder="Search students by name or student code..."
            >
        </div>

        <div class="relative">
            <select
                id="statusFilter"
                class="h-10 pl-3 pr-8 rounded-lg bg-surface font-label-md text-label-md text-on-surface appearance-none cursor-pointer focus:outline-none"
            >
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">
                expand_more
            </span>
        </div>

    </div>

</div>

<!-- Students Table -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="py-3 px-4 w-12 text-center">#</th>
                    <th class="py-3 px-10">Student</th>
                    <th class="py-3 px-4">Student Code</th>
                    <th class="py-3 px-4">Date Of Birth</th>
                    <th class="py-3.5 px-4 text-center">Gender</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody
                id="studentTableBody"
                class="divide-y divide-surface-container font-body-md text-body-md text-on-surface"
            >
                <tr>
                    <td colspan="7" class="py-10 text-center text-on-surface-variant">
                        <div class="flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined animate-spin text-[22px]">
                                progress_activity
                            </span>
                            Loading students...
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-space-md bg-surface-container-lowest flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container">
        <div id="studentPaginationInfo" class="font-body-sm text-body-sm text-on-surface-variant">
            Loading...
        </div>

        <div id="studentPagination" class="flex items-center gap-1 font-label-md text-label-md"></div>
    </div>
</div>

</div>

<!-- Add Student Modal -->

<div
    id="addStudentModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="addStudentModalTitle"
>
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">
    <!-- Modal Header -->
    <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
        <div>
            <h2 id="addStudentModalTitle" class="font-headline-md text-headline-md text-on-surface">
                Add New Student
            </h2>
            <p class="mt-1 text-sm text-on-surface-variant">
                Register a student and enroll them in a class.
            </p>
        </div>

        <button
            type="button"
            id="closeAddStudentModal"
            class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
            aria-label="Close modal"
        >
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <form id="addStudentForm" enctype="multipart/form-data" class="flex flex-col min-h-0">

        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">

            <!-- Student Code -->
            <div>
                <label for="student_code" class="mb-1 block text-sm font-medium text-on-surface">
                    Student Code
                </label>

                <input
                    type="text"
                    id="student_code"
                    name="student_code"
                    readonly
                    class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface"
                    value="Loading..."
                >
            </div>

            <!-- Parent -->
            <div>
                <label for="student_parent_id" class="mb-1 block text-sm font-medium text-on-surface">
                    Parent / Guardian *
                </label>

                <select
                    id="student_parent_id"
                    name="parent_id"
                    required
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                >
                    <option value="">Loading parents...</option>
                </select>
            </div>

            <!-- Name -->
            <div class="sm:col-span-2">
                <label for="student_name" class="mb-1 block text-sm font-medium text-on-surface">
                    Student Full Name *
                </label>

                <input
                    type="text"
                    id="student_name"
                    name="name"
                    required
                    placeholder="Student full name"
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface placeholder:text-outline focus:outline-none"
                >
            </div>

            <!-- Date of Birth -->
            <div>
                <label for="student_date_of_birth" class="mb-1 block text-sm font-medium text-on-surface">
                    Date of Birth
                </label>

                <input
                    type="date"
                    id="student_date_of_birth"
                    name="date_of_birth"
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface focus:outline-none"
                >
            </div>

            <!-- Gender -->
            <div>
                <label for="student_gender" class="mb-1 block text-sm font-medium text-on-surface">
                    Gender
                </label>

                <select
                    id="student_gender"
                    name="gender"
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                >
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- Profile Picture -->
            <div class="sm:col-span-2">
                <label for="student_profile_picture" class="mb-1 block text-sm font-medium text-on-surface">
                    Profile Picture
                </label>

                <input
                    type="file"
                    id="student_profile_picture"
                    name="profile_picture"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-sm text-on-surface"
                >
            </div>

            <!-- Class -->
            <div>
                <label for="student_class_id" class="mb-1 block text-sm font-medium text-on-surface">
                    Class *
                </label>

                <select
                    id="student_class_id"
                    name="class_id"
                    required
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                >
                    <option value="">Loading classes...</option>
                </select>
            </div>

            <!-- Section -->
            <div>
                <label for="student_section_id" class="mb-1 block text-sm font-medium text-on-surface">
                    Section *
                </label>

                <select
                    id="student_section_id"
                    name="section_id"
                    required
                    disabled
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                >
                    <option value="">Select a class first</option>
                </select>
            </div>

            <!-- Academic Session -->
            <div>
                <label for="student_academic_session_id" class="mb-1 block text-sm font-medium text-on-surface">
                    Academic Session *
                </label>

                <select
                    id="student_academic_session_id"
                    name="academic_session_id"
                    required
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                >
                    <option value="">Loading sessions...</option>
                </select>
            </div>

            <!-- Enrollment Date -->
            <div>
                <label for="student_enrollment_date" class="mb-1 block text-sm font-medium text-on-surface">
                    Enrollment Date *
                </label>

                <input
                    type="date"
                    id="student_enrollment_date"
                    name="enrollment_date"
                    required
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                >
            </div>

            <!-- Student Status -->
            <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-3">
                <div>
                    <span class="text-sm font-semibold text-on-surface">Student Status</span>
                    <span class="mt-0.5 block text-sm text-on-surface-variant">
                        Allow student access to the system.
                    </span>
                </div>

                <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" id="new_student_active" class="sr-only peer" checked>

                    <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                </label>
            </div>

            <!-- Enrollment Status -->
            <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-3">
                <div>
                    <span class="text-sm font-semibold text-on-surface">Enrollment Status</span>
                    <span class="mt-0.5 block text-sm text-on-surface-variant">
                        Keep the enrollment active.
                    </span>
                </div>

                <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" id="new_enrollment_active" class="sr-only peer" checked>

                    <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                </label>
            </div>

        </div>

        <div id="addStudentError" class="hidden mx-5 mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>

        <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
            <button
                type="button"
                id="cancelAddStudent"
                class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container"
            >
                Cancel
            </button>

            <button
                type="submit"
                id="saveStudentButton"
                class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90"
            >
                Save Student & Enroll
            </button>
        </div>

    </form>
</div>


</div>

<!-- Toast -->

<div
    id="toastNotification"
    class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300"
>
    <span id="toastIcon" class="material-symbols-outlined text-secondary-fixed text-[20px]">
        check_circle
    </span>

<span id="toastMessage" class="font-body-sm text-body-sm">
    Operation completed successfully.
</span>

</div>

<!-- Delete Student Modal -->

<div
    id="deleteStudentModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="deleteStudentModalTitle"
>
    <div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-outline-variant p-5">
        <div>
            <h2
                id="deleteStudentModalTitle"
                class="font-headline-md text-headline-md text-on-surface"
            >
                Delete Student
            </h2>

            <p
                id="deleteStudentModalSubtitle"
                class="mt-1 text-sm text-on-surface-variant"
            >
                Confirm this action.
            </p>
        </div>

        <button
            type="button"
            id="closeDeleteStudentModal"
            class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
            aria-label="Close modal"
        >
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Body -->
    <div class="p-5">
        <div
            id="deleteStudentMessage"
            class="rounded-lg bg-red-50 p-4 text-sm text-red-700"
        >
            Checking student records...
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-3 border-t border-outline-variant p-5">

        <button
            type="button"
            id="cancelDeleteStudent"
            class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container"
        >
            Cancel
        </button>

        <button
            type="button"
            id="confirmDeleteStudent"
            class="hidden rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white hover:bg-red-700"
        >
            Delete Student
        </button>

        <button
            type="button"
            id="confirmDeactivateStudent"
            class="hidden rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90"
        >
            Deactivate Student
        </button>

    </div>
</div>

</div>

<!-- View Student Modal -->

<div
    id="viewStudentModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="viewStudentModalTitle"
>
    <div class="w-full max-w-lg rounded-2xl bg-surface-container-lowest shadow-xl">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-outline-variant p-5">
        <div>
            <h2
                id="viewStudentModalTitle"
                class="font-headline-md text-headline-md text-on-surface"
            >
                Student Details
            </h2>

            <p class="mt-1 text-sm text-on-surface-variant">
                View student information
            </p>
        </div>

        <button
            type="button"
            id="closeViewStudentModal"
            class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
            aria-label="Close modal"
        >
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Student Profile -->
    <div class="p-5">

        <div class="flex items-center gap-4 pb-5">
            <div id="viewStudentAvatar"></div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between w-full gap-4 flex-wrap">
                    <h3
                        id="viewStudentName"
                        class="text-lg font-semibold text-on-surface"
                    >
                        —
                    </h3>

                    <div id="viewStudentStatus" class="flex items-center">
                        —
                    </div>
                </div>

                <p
                    id="viewStudentCode"
                    class="mt-1 text-sm text-on-surface-variant"
                >
                    —
                </p>
            </div>
        </div>

        <!-- Details -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="rounded-lg bg-surface-container-low p-4">
                <p class="text-xs text-on-surface-variant">Date of Birth</p>

                <p
                    id="viewStudentDob"
                    class="mt-1 font-medium text-on-surface"
                >
                    —
                </p>
            </div>

            <div class="rounded-lg bg-surface-container-low p-4">
                <p class="text-xs text-on-surface-variant">Gender</p>

                <p
                    id="viewStudentGender"
                    class="mt-1 font-medium text-on-surface"
                >
                    —
                </p>
            </div>

            <div class="rounded-lg bg-surface-container-low p-4 sm:col-span-2">
                <p class="text-xs text-on-surface-variant">Enrollments</p>

                <div id="viewStudentEnrollments" class="space-y-3">
                    <p class="text-sm text-on-surface-variant">
                        No enrollments found.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="flex justify-end border-t border-outline-variant p-5">
        <button
            type="button"
            id="closeViewStudentButton"
            class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container"
        >
            Close
        </button>
    </div>

</div>

</div>

<script>
(() => {
    const API_URL = '/api/v1/admin/students';
    const modal = document.getElementById('addStudentModal');
    const form = document.getElementById('addStudentForm');
    const errorBox = document.getElementById('addStudentError');
    const saveButton = document.getElementById('saveStudentButton');
    const studentCodeInput = document.getElementById('student_code');
    const parentSelect = document.getElementById('student_parent_id');
    const classSelect = document.getElementById('student_class_id');
    const sectionSelect = document.getElementById('student_section_id');
    const sessionSelect = document.getElementById('student_academic_session_id');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const tableBody = document.getElementById('studentTableBody');
    const totalStudents = document.getElementById('totalStudents');
    const activeStudents = document.getElementById('activeStudents');
    const inactiveStudents = document.getElementById('inactiveStudents');
    const activePercentage = document.getElementById('activePercentage');
    const activeStudentsPercentage = document.getElementById('activeStudentsPercentage');
    const currentSessionName = document.getElementById('currentSessionName');
    const paginationInfo = document.getElementById('studentPaginationInfo');
    const pagination = document.getElementById('studentPagination');
    const deleteModal = document.getElementById('deleteStudentModal');
    const deleteStudentMessage = document.getElementById('deleteStudentMessage');
    const confirmDeleteStudentButton = document.getElementById('confirmDeleteStudent');
    const confirmDeactivateStudentButton = document.getElementById('confirmDeactivateStudent');
    const closeDeleteStudentButton = document.getElementById('closeDeleteStudentModal');
    const cancelDeleteStudentButton = document.getElementById('cancelDeleteStudent');
    const viewStudentModal = document.getElementById('viewStudentModal');
    const closeViewStudentModalButton = document.getElementById('closeViewStudentModal');
    const closeViewStudentButton = document.getElementById('closeViewStudentButton');
    const viewStudentAvatar = document.getElementById('viewStudentAvatar');
    const viewStudentName = document.getElementById('viewStudentName');
    const viewStudentCode = document.getElementById('viewStudentCode');
    const viewStudentDob = document.getElementById('viewStudentDob');
    const viewStudentGender = document.getElementById('viewStudentGender');
    const viewStudentStatus = document.getElementById('viewStudentStatus');
    const viewStudentEnrollments = document.getElementById('viewStudentEnrollments');

    let selectedStudentId = null;
    let students = [];
    let sections = [];
    let currentPage = 1;
    let lastPage = 1;
    let perPage = 5;
    let searchTimer;

    const today = new Date();
    const localToday = [
        today.getFullYear(),
        String(today.getMonth() + 1).padStart(2, '0'),
        String(today.getDate()).padStart(2, '0')
    ].join('-');

    document.getElementById('student_enrollment_date').value = localToday;

    function getToken() {
        return localStorage.getItem('student_diary_token');
    }

    function logout() {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.replace('/');
    }

    async function apiRequest(url, options = {}) {
        const token = getToken();

        if (!token) {
            logout();
            throw new Error('Your session has expired. Please log in again.');
        }

        const response = await fetch(url, {
            ...options,
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`,
                ...(options.headers || {})
            }
        });

        const result = await response.json().catch(() => ({}));

        if (response.status === 401) {
            logout();
            throw new Error('Your session has expired. Please log in again.');
        }

        if (!response.ok || result.status === false) {
            const validationMessages = result.errors
                ? Object.values(result.errors).flat().join(' ')
                : '';

            throw new Error(
                validationMessages ||
                result.message ||
                'The request could not be completed.'
            );
        }

        return result;
    }

    function showError(message) {
        errorBox.textContent = message;
        errorBox.classList.remove('hidden');
    }

    function clearError() {
        errorBox.textContent = '';
        errorBox.classList.add('hidden');
    }

    function showToast(message, icon = 'check_circle') {
        const toast = document.getElementById('toastNotification');
        if (!toast) return;

        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toastIcon').textContent = icon;

        toast.classList.remove('translate-y-16', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');

        clearTimeout(window.studentToastTimeout);

        window.studentToastTimeout = setTimeout(() => {
            toast.classList.add('translate-y-16', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function getInitials(name) {
        if (!name) return 'ST';

        return name
            .split(' ')
            .filter(Boolean)
            .slice(0, 2)
            .map(word => word[0])
            .join('')
            .toUpperCase();
    }

    function getProfilePictureUrl(path) {
        if (!path) return null;

        if (path.startsWith('http://') || path.startsWith('https://')) {
            return path;
        }

        return `/storage/${path}`;
    }

    function fillSelect(select, items, placeholder, getLabel) {
        select.replaceChildren();

        const firstOption = document.createElement('option');
        firstOption.value = '';
        firstOption.textContent = placeholder;
        select.appendChild(firstOption);

        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = getLabel(item);
            select.appendChild(option);
        });
    }

    function extractList(result, alternativeKeys = []) {
        const candidates = [
            result?.data?.data,
            result?.data,
            ...alternativeKeys.map(key => result?.[key])
        ];

        return candidates.find(Array.isArray) || [];
    }

    async function loadStudents(page = 1) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="px-5 py-10 text-center text-sm text-on-surface-variant">
                    Loading students...
                </td>
            </tr>
        `;

        try {
            const params = new URLSearchParams();
            params.set('page', page);

            const search = searchInput.value.trim();
            const status = statusFilter.value;

            if (search) params.set('search', search);
            if (status !== 'all') params.set('status', status);

            const result = await apiRequest(`${API_URL}?${params.toString()}`);

            students = Array.isArray(result.data) ? result.data : [];

            const meta = result.meta || {};

            currentPage = Number(meta.current_page || page);
            lastPage = Number(meta.last_page || 1);
            perPage = Number(meta.per_page || 5);

            updateStatistics(result);
            renderStudents();
            renderPagination(meta);
        } catch (error) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-5 py-10 text-center text-sm text-red-600">
                        ${escapeHtml(error.message)}
                    </td>
                </tr>
            `;

            paginationInfo.textContent = 'Unable to load students.';
            pagination.innerHTML = '';
        }
    }

    function updateStatistics(result) {
        const statistics = result.statistics || {};
        const total = Number(statistics.total_students ?? 0);
        const active = Number(statistics.active_students ?? 0);
        const inactive = Number(statistics.inactive_students ?? 0);

        totalStudents.textContent = total;
        activeStudents.textContent = active;
        inactiveStudents.textContent = inactive;

        const percentage = total
            ? Math.round((active / total) * 100)
            : 0;

        activePercentage.textContent = `${percentage}%`;
        activeStudentsPercentage.textContent = `${percentage}% active`;

        const currentSession = result.data?.[0]?.academic_session;

        currentSessionName.textContent =
            currentSession?.name || 'No active session';
    }

    function renderStudents() {
        if (!students.length) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-12 text-center text-on-surface-variant">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-[34px]">
                                person_search
                            </span>
                            <span>No students found.</span>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tableBody.innerHTML = students.map((student, index) => {
            const picture = getProfilePictureUrl(student.profile_picture);
            const initials = getInitials(student.name);

            const avatar = picture
                ? `
                    <img src="${picture}" alt="${escapeHtml(student.name)}"
                         class="w-9 h-9 rounded-full object-cover">
                `
                : `
                    <div class="w-9 h-9 rounded-full bg-primary text-on-primary
                                flex items-center justify-center font-semibold">
                        ${escapeHtml(initials)}
                    </div>
                `;

            const active = Boolean(student.status);

            const statusBadge = active
                ? `
                    <span class="inline-flex items-center gap-1.5 px-2 py-1
                                 rounded-full text-xs font-semibold text-secondary">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                        Active
                    </span>
                `
                : `
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1
                                 rounded-full text-xs font-semibold text-outline">
                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                        Inactive
                    </span>
                `;

            const gender = student.gender
                ? student.gender.charAt(0).toUpperCase() +
                  student.gender.slice(1).toLowerCase()
                : '—';

            return `
                <tr class="hover:bg-surface-container-low">
                    <td class="px-5 py-4 text-sm text-on-surface-variant">
                        ${(currentPage - 1) * perPage + index + 1}
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            ${avatar}
                            <div>
                                <p class="font-medium text-on-surface">
                                    ${escapeHtml(student.name)}
                                </p>
                                <p class="text-xs text-on-surface-variant">
                                    Student
                                </p>
                            </div>
                        </div>
                    </td>

                    <td class="py-3.5 px-4">
                        <span class="bg-surface-container px-2 py-1 rounded font-semibold">
                            ${escapeHtml(student.student_code || '—')}
                        </span>
                    </td>

                    <td class="px-5 py-4 text-sm text-on-surface">
                        ${escapeHtml(student.date_of_birth || '—')}
                    </td>

                    <td class="px-5 py-4 text-sm text-on-surface text-center">
                        ${escapeHtml(gender)}
                    </td>

                    <td class="px-5 py-4 text-center">
                        ${statusBadge}
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex justify-end gap-1">
                            <button type="button"
                                onclick="viewStudent(${student.id})"
                                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
                                title="View student">
                                <span class="material-symbols-outlined text-[20px]">
                                    visibility
                                </span>
                            </button>

                            <button type="button"
                                onclick="toggleStudentStatus(${student.id})"
                                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
                                title="${active ? 'Deactivate student' : 'Activate student'}">
                                <span class="material-symbols-outlined text-[20px]">
                                    ${active ? 'person_off' : 'person_check'}
                                </span>
                            </button>

                            <button type="button"
                                onclick="deleteStudent(${student.id})"
                                class="rounded-lg p-2 text-red-600 hover:bg-red-50"
                                title="Delete student">
                                <span class="material-symbols-outlined text-[20px]">
                                    delete
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function renderPagination(meta) {
        const from = Number(meta.from || 0);
        const to = Number(meta.to || 0);
        const total = Number(meta.total || 0);

        paginationInfo.textContent = total
            ? `Showing ${from} - ${to} of ${total} students`
            : 'No students found';

        pagination.innerHTML = '';

        if (lastPage <= 1) return;

        const createButton = (label, page, disabled = false) => {
            const button = document.createElement('button');

            button.type = 'button';
            button.textContent = label;
            button.disabled = disabled;

            button.className = disabled
                ? 'h-9 min-w-9 rounded-lg px-3 text-sm text-outline cursor-not-allowed'
                : 'h-9 min-w-9 rounded-lg px-3 text-sm text-on-surface-variant hover:bg-surface-container';

            if (!disabled) {
                button.addEventListener('click', () => loadStudents(page));
            }

            return button;
        };

        pagination.appendChild(
            createButton('‹', currentPage - 1, currentPage === 1)
        );

        for (let page = 1; page <= lastPage; page++) {
            const button = document.createElement('button');

            button.type = 'button';
            button.textContent = page;

            button.className = page === currentPage
                ? 'h-9 min-w-9 rounded-lg bg-primary px-3 text-sm font-semibold text-white'
                : 'h-9 min-w-9 rounded-lg px-3 text-sm text-on-surface-variant hover:bg-surface-container';

            button.addEventListener('click', () => loadStudents(page));
            pagination.appendChild(button);
        }

        pagination.appendChild(
            createButton('›', currentPage + 1, currentPage === lastPage)
        );
    }

    async function loadFormOptions() {
        try {
            const [
                parentsResult,
                classesResult,
                sectionsResult,
                sessionsResult
            ] = await Promise.all([
                apiRequest('/api/v1/admin/parents'),
                apiRequest('/api/v1/admin/classes'),
                apiRequest('/api/v1/admin/sections'),
                apiRequest('/api/v1/admin/academic-sessions')
            ]);

            const parents = extractList(parentsResult, ['parents']);
            const classes = extractList(classesResult, ['classes']);
            sections = extractList(sectionsResult, ['sections']);

            const sessions = extractList(
                sessionsResult,
                ['academic_sessions', 'sessions']
            );

            const currentSession = sessionsResult.current_session;

            if (
                currentSession?.id &&
                !sessions.some(
                    session => Number(session.id) === Number(currentSession.id)
                )
            ) {
                sessions.unshift(currentSession);
            }

            fillSelect(
                parentSelect,
                parents,
                parents.length
                    ? 'Select parent / guardian'
                    : 'No parents available',
                parent =>
                    parent.user?.name ||
                    parent.name ||
                    parent.user?.email ||
                    `Parent #${parent.id}`
            );

            fillSelect(
                classSelect,
                classes,
                classes.length ? 'Select class' : 'No classes available',
                schoolClass =>
                    schoolClass.name || `Class #${schoolClass.id}`
            );

            fillSelect(
                sessionSelect,
                sessions,
                sessions.length
                    ? 'Select academic session'
                    : 'No sessions available',
                session =>
                    session.name || `Session #${session.id}`
            );

            sectionSelect.replaceChildren();

            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Select a class first';
            sectionSelect.appendChild(option);
            sectionSelect.disabled = true;

            if (currentSession?.id) {
                sessionSelect.value = String(currentSession.id);
            }
        } catch (error) {
            showError(error.message);
        }
    }

    function updateSections() {
        const classId = classSelect.value;

        const matchingSections = sections.filter(
            section => Number(section.class_id) === Number(classId)
        );

        fillSelect(
            sectionSelect,
            matchingSections,
            classId
                ? matchingSections.length
                    ? 'Select section'
                    : 'No sections available'
                : 'Select a class first',
            section => section.name || `Section #${section.id}`
        );

        sectionSelect.disabled =
            !classId || matchingSections.length === 0;
    }

    async function loadNextStudentCode() {
        studentCodeInput.value = 'Loading...';

        try {
            const result = await apiRequest(`${API_URL}/next-code`);
            studentCodeInput.value = result.data.student_code;
        } catch (error) {
            studentCodeInput.value = '';
            showError(`Could not generate student code: ${error.message}`);
        }
    }

    function openModal() {
        form.reset();
        clearError();

        document.getElementById('student_enrollment_date').value = localToday;
        document.getElementById('new_student_active').checked = true;
        document.getElementById('new_enrollment_active').checked = true;

        sectionSelect.replaceChildren();

        const option = document.createElement('option');
        option.value = '';
        option.textContent = 'Select a class first';
        sectionSelect.appendChild(option);
        sectionSelect.disabled = true;

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        loadNextStudentCode();
        loadFormOptions();
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        form.reset();
        clearError();
    }

    document.getElementById('openAddStudentModal')
        .addEventListener('click', openModal);

    document.getElementById('closeAddStudentModal')
        .addEventListener('click', closeModal);

    document.getElementById('cancelAddStudent')
        .addEventListener('click', closeModal);

    modal.addEventListener('click', event => {
        if (event.target === modal) closeModal();
    });

    classSelect.addEventListener('change', updateSections);

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(() => {
            loadStudents(1);
        }, 300);
    });

    statusFilter.addEventListener('change', () => {
        loadStudents(1);
    });

    form.addEventListener('submit', async event => {
        event.preventDefault();
        clearError();

        if (!sectionSelect.value) {
            showError('Please select a class and its section.');
            return;
        }

        const formData = new FormData(form);

        formData.set(
            'status',
            document.getElementById('new_student_active').checked ? '1' : '0'
        );

        formData.set(
            'enrollment_status',
            document.getElementById('new_enrollment_active').checked ? '1' : '0'
        );

        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';

        try {
            const result = await apiRequest(
                '/api/v1/admin/students/register-with-enrollment',
                { method: 'POST', body: formData }
            );

            closeModal();

            showToast(
                result.message || 'Student created and enrolled successfully.'
            );

            await loadStudents(currentPage);
        } catch (error) {
            showError(error.message);
        } finally {
            saveButton.disabled = false;
            saveButton.textContent = 'Save Student & Enroll';
        }
    });

    window.viewStudent = async function(id) {
        viewStudentModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        viewStudentName.textContent = 'Loading...';
        viewStudentCode.textContent = '';
        viewStudentDob.textContent = '—';
        viewStudentGender.textContent = '—';
        viewStudentEnrollments.textContent = '—';
        viewStudentStatus.innerHTML = '';

        viewStudentAvatar.innerHTML = `
            <div class="w-14 h-14 rounded-full bg-surface-container
                        flex items-center justify-center">
                <span class="material-symbols-outlined animate-spin text-primary">
                    progress_activity
                </span>
            </div>
        `;

        try {
            const result = await apiRequest(`${API_URL}/${id}`);
            const student = result.data;

            const picture = getProfilePictureUrl(student.profile_picture);
            const initials = getInitials(student.name);

            viewStudentAvatar.innerHTML = picture
                ? `
                    <img src="${picture}" alt="${escapeHtml(student.name)}"
                         class="w-14 h-14 rounded-full object-cover">
                `
                : `
                    <div class="w-14 h-14 rounded-full bg-primary text-on-primary
                                flex items-center justify-center text-lg font-semibold">
                        ${escapeHtml(initials)}
                    </div>
                `;

            viewStudentName.textContent = student.name || '—';
            viewStudentCode.textContent = student.student_code || '—';

            viewStudentStatus.innerHTML = student.status
                ? `
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-secondary">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                        Active
                    </span>
                `
                : `
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-outline">
                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                        Inactive
                    </span>
                `;

            viewStudentDob.textContent = student.date_of_birth || '—';

            viewStudentGender.textContent = student.gender
                ? student.gender.charAt(0).toUpperCase() +
                  student.gender.slice(1).toLowerCase()
                : '—';

            const enrollments = Array.isArray(student.enrollments)
                ? student.enrollments
                : [];

            if (!enrollments.length) {
                viewStudentEnrollments.innerHTML = `
                    <div class="rounded-lg bg-surface-container p-4">
                        <p class="text-sm text-on-surface-variant">
                            No enrollment records found.
                        </p>
                    </div>
                `;
                return;
            }

            viewStudentEnrollments.innerHTML = enrollments.map(enrollment => {
                const statusBadge = enrollment.status
                    ? `
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-secondary">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                            Active
                        </span>
                    `
                    : `
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-outline">
                            <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                            Inactive
                        </span>
                    `;

                return `
                    <div class="rounded-xl bg-surface-container-low p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs text-on-surface-variant">Class</p>
                                <p class="mt-1 font-semibold text-on-surface">
                                    ${escapeHtml(enrollment.class || '—')}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-on-surface-variant">Section</p>
                                <p class="mt-1 font-semibold text-on-surface">
                                    ${escapeHtml(enrollment.section || '—')}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-on-surface-variant">
                                    Academic Session
                                </p>
                                <p class="mt-1 font-semibold text-on-surface">
                                    ${escapeHtml(enrollment.academic_session || '—')}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-outline-variant
                                    flex items-center justify-between">
                            <div>
                                <p class="text-xs text-on-surface-variant">
                                    Enrollment Date
                                </p>
                                <p class="mt-1 text-sm font-medium text-on-surface">
                                    ${escapeHtml(enrollment.enrollment_date || '—')}
                                </p>
                            </div>

                            <div>${statusBadge}</div>
                        </div>
                    </div>
                `;
            }).join('');
        } catch (error) {
            closeViewStudentModal();
            showToast(error.message, 'error');
        }
    };

    function closeViewStudentModal() {
        viewStudentModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    closeViewStudentModalButton.addEventListener(
        'click',
        closeViewStudentModal
    );

    closeViewStudentButton.addEventListener(
        'click',
        closeViewStudentModal
    );

    viewStudentModal.addEventListener('click', event => {
        if (event.target === viewStudentModal) {
            closeViewStudentModal();
        }
    });

    window.toggleStudentStatus = async function(id) {
        try {
            const result = await apiRequest(`${API_URL}/${id}/status`, {
                method: 'PATCH'
            });

            showToast(
                result.message || 'Student status updated successfully.'
            );

            await loadStudents(currentPage);
        } catch (error) {
            showToast(error.message, 'error');
        }
    };

    window.deleteStudent = async function(id) {
        selectedStudentId = id;

        deleteStudentMessage.textContent =
            'Checking student enrollment records...';

        confirmDeleteStudentButton.classList.add('hidden');
        confirmDeactivateStudentButton.classList.add('hidden');

        deleteModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        try {
            const result = await apiRequest(`${API_URL}/${id}`);
            const student = result.data;

            const enrollments = Array.isArray(student.enrollments)
                ? student.enrollments
                : [];

            const enrollmentCount = Math.max(
                Number(student.enrollments_count ?? 0),
                enrollments.length
            );

            if (enrollmentCount > 0) {
                deleteStudentMessage.className =
                    'rounded-lg bg-amber-50 p-4 text-sm text-amber-700';

                deleteStudentMessage.textContent =
                    `Student "${student.name}" cannot be deleted because they have enrollment records. You can deactivate the student instead.`;

                confirmDeactivateStudentButton.classList.remove('hidden');
            } else {
                deleteStudentMessage.className =
                    'rounded-lg bg-red-50 p-4 text-sm text-red-700';

                deleteStudentMessage.textContent =
                    `Are you sure you want to delete "${student.name}"? This action cannot be undone.`;

                confirmDeleteStudentButton.classList.remove('hidden');
            }
        } catch (error) {
            deleteStudentMessage.className =
                'rounded-lg bg-red-50 p-4 text-sm text-red-700';

            deleteStudentMessage.textContent = error.message;
        }
    };

    confirmDeleteStudentButton.addEventListener('click', async () => {
        if (!selectedStudentId) return;

        confirmDeleteStudentButton.disabled = true;
        confirmDeleteStudentButton.textContent = 'Deleting...';

        try {
            const result = await apiRequest(
                `${API_URL}/${selectedStudentId}`,
                { method: 'DELETE' }
            );

            closeDeleteModal();

            showToast(
                result.message || 'Student deleted successfully.'
            );

            await loadStudents(currentPage);
        } catch (error) {
            deleteStudentMessage.textContent = error.message;
        } finally {
            confirmDeleteStudentButton.disabled = false;
            confirmDeleteStudentButton.textContent = 'Delete Student';
        }
    });

    confirmDeactivateStudentButton.addEventListener('click', async () => {
        if (!selectedStudentId) return;

        confirmDeactivateStudentButton.disabled = true;
        confirmDeactivateStudentButton.textContent = 'Deactivating...';

        try {
            const result = await apiRequest(
                `${API_URL}/${selectedStudentId}/status`,
                { method: 'PATCH' }
            );

            closeDeleteModal();

            showToast(
                result.message || 'Student deactivated successfully.'
            );

            await loadStudents(currentPage);
        } catch (error) {
            deleteStudentMessage.textContent = error.message;
        } finally {
            confirmDeactivateStudentButton.disabled = false;
            confirmDeactivateStudentButton.textContent = 'Deactivate Student';
        }
    });

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        selectedStudentId = null;
        confirmDeleteStudentButton.classList.add('hidden');
        confirmDeactivateStudentButton.classList.add('hidden');
    }

    closeDeleteStudentButton.addEventListener(
        'click',
        closeDeleteModal
    );

    cancelDeleteStudentButton.addEventListener(
        'click',
        closeDeleteModal
    );

    deleteModal.addEventListener('click', event => {
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });

    document.addEventListener('keydown', event => {
        if (event.key !== 'Escape') return;

        if (!modal.classList.contains('hidden')) {
            closeModal();
        }

        if (!deleteModal.classList.contains('hidden')) {
            closeDeleteModal();
        }

        if (!viewStudentModal.classList.contains('hidden')) {
            closeViewStudentModal();
        }
    });

    loadStudents();
    setInterval(() => {
        if (
            modal.classList.contains('hidden') &&
            viewStudentModal.classList.contains('hidden') &&
            deleteModal.classList.contains('hidden')
        ) {
            loadStudents(currentPage);
        }
    }, 10000);
})();
</script>

@endsection
