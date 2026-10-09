@extends('layouts.admin')

@section('title', 'Dashboard - Student Diary')

@section('content')
<div class="flex flex-col w-full gap-space-lg">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
        <div class="flex flex-col">
            <div class="flex items-center gap-2 mt-4">
                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Good morning, Admin</h1>
                <span class="font-label-sm text-label-sm bg-secondary-container text-on-secondary-container font-semibold px-2 py-0.5 rounded-full">Active</span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Manage your institute's people and academic setup from one place.</p>
        </div>

        <div class="flex items-center gap-space-sm">
            <button type="button" id="openAddStudentModal" class="flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white transition-all shadow-sm font-label-md text-label-md">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                <span>+ Add Student</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-space-md">
        <!-- 1. Total Teachers -->
        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Teachers</span>
                <div class="p-1.5 rounded-lg bg-surface-container-low text-primary">
                    <span class="material-symbols-outlined text-[20px]">school</span>
                </div>
            </div>
            <div class="mt-space-md">
                <div id="teacher-count" class="font-display-lg text-display-lg text-on-surface font-tabular-numeric"></div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Active faculty members</p>
            </div>
        </div>

        <!-- 2. Total Parents -->
        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Parents</span>
                <div class="p-1.5 rounded-lg bg-surface-container-low text-primary">
                    <span class="material-symbols-outlined text-[20px]">group</span>
                </div>
            </div>
            <div class="mt-space-md">
                <div id="parent-count" class="font-display-lg text-display-lg text-on-surface font-tabular-numeric">0</div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Registered parent accounts</p>
            </div>
        </div>

        <!-- 3. Total Students -->
        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Students</span>
                <div class="p-1.5 rounded-lg bg-surface-container-low text-primary">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                </div>
            </div>
            <div class="mt-space-md">
                <div id="student-count" class="font-display-lg text-display-lg text-on-surface font-tabular-numeric">0</div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Enrolled student records</p>
            </div>
        </div>

        <!-- 4. Active Classes -->
        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Classes</span>
                <div class="p-1.5 rounded-lg bg-surface-container-low text-primary">
                    <span class="material-symbols-outlined text-[20px]">domain</span>
                </div>
            </div>
            <div class="mt-space-md">
                <div id="class-count" class="font-display-lg text-display-lg text-on-surface font-tabular-numeric">0</div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Class 1 through Class 10</p>
            </div>
        </div>

        <!-- 5. Active Session -->
        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Current Session</span>
                <div class="p-1.5 rounded-lg bg-surface-container-low text-primary">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                </div>
            </div>
            <div class="mt-space-md">
                <div id="active-session" class="font-headline-md text-headline-md text-on-surface font-tabular-numeric">-</div>
                <p id="active-session-dates" class="font-body-sm text-body-sm text-on-surface-variant mt-1">-</p>
            </div>
        </div>

        <!-- 6. Teacher Assignments -->
        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Assignments</span>
                <div class="p-1.5 rounded-lg bg-surface-container-low text-primary">
                    <span class="material-symbols-outlined text-[20px]">assignment</span>
                </div>
            </div>
            <div class="mt-space-md">
                <div id="assignment-count" class="font-display-lg text-display-lg text-on-surface font-tabular-numeric">0</div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Class-Subject allocations</p>
            </div>
        </div>
    </div>

    <!-- Functional Quick-Action Grid Strip -->
    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Administrative Shortcuts</span>
            <span class="font-label-sm text-label-sm text-on-surface-variant font-tabular-numeric">6 Configured Actions</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
            <button type="button" id="openModalBtn" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface hover:bg-surface-container text-on-surface hover:text-primary transition-all text-left">
                <span class="material-symbols-outlined text-primary text-[18px]">person_add</span>
                <span class="font-label-md text-label-md">Add Teacher</span>
            </button>

            <button type="button" id="openParentModalBtn" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface hover:bg-surface-container text-on-surface hover:text-primary transition-all text-left">
                <span class="material-symbols-outlined text-primary text-[18px]">group_add</span>
                <span class="font-label-md text-label-md">Add Parent</span>
            </button>

            <button type="button" id="openAddStudentModalShortcut" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface hover:bg-surface-container text-on-surface hover:text-primary transition-all text-left">
                <span class="material-symbols-outlined text-primary text-[18px]">how_to_reg</span>
                <span class="font-label-md text-label-md">Add Student</span>
            </button>

            <button type="button" id="openClassModalBtn" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface hover:bg-surface-container text-on-surface hover:text-primary transition-all text-left">
                <span class="material-symbols-outlined text-primary text-[18px]">add_home_work</span>
                <span class="font-label-md text-label-md">Create Class</span>
            </button>

            <button type="button" id="openSubjectModalBtn" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface hover:bg-surface-container text-on-surface hover:text-primary transition-all text-left">
                <span class="material-symbols-outlined text-primary text-[18px]">library_add</span>
                <span class="font-label-md text-label-md">Add Subject</span>
            </button>

            <button type="button" id="openAssignTeacherModalBtn" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface hover:bg-surface-container text-on-surface hover:text-primary transition-all text-left">
                <span class="material-symbols-outlined text-primary text-[18px]">post_add</span>
                <span class="font-label-md text-label-md">Assign Teacher</span>
            </button>
        </div>
    </div>

    <!-- Two-Column Lower Core Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">

        <!-- LEFT COLUMN -->
        <div class="lg:col-span-7 flex flex-col gap-space-lg">

            <!-- Academic Overview Card -->
            <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                <div class="flex items-center justify-between pb-space-sm bg-surface-container-lowest">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">calendar_today</span>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Academic Overview</h2>
                    </div>

                    <span class="font-label-sm text-label-sm inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-container text-on-secondary-container">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                        Active Session
                    </span>
                </div>

                <!-- Session Meta Strip -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-sm p-space-md rounded-lg bg-surface">
                    <div>
                        <span class="font-label-sm text-label-sm text-outline uppercase block">Current Term</span>
                        <span id="overview-session-name" class="font-headline-sm text-headline-sm text-primary font-tabular-numeric">-</span>
                    </div>

                    <div>
                        <span class="font-label-sm text-label-sm text-outline uppercase block">Term Start</span>
                        <span id="overview-session-start" class="font-body-md text-body-md text-on-surface font-tabular-numeric">-</span>
                    </div>

                    <div>
                        <span class="font-label-sm text-label-sm text-outline uppercase block">Term End</span>
                        <span id="overview-session-end" class="font-body-md text-body-md text-on-surface font-tabular-numeric">-</span>
                    </div>
                </div>

                <!-- Teacher Assignment Breakdown -->
                <div class="flex flex-col gap-3 pt-2">
                    <div class="flex items-center justify-between">
                        <span class="font-label-md text-label-md text-on-surface font-semibold">Teacher Allocation Coverage</span>
                        <span id="allocation-coverage" class="font-label-md text-label-md text-primary font-tabular-numeric font-semibold">0% Covered</span>
                    </div>

                    <div class="w-full h-2 rounded-full bg-surface-container-high overflow-hidden flex">
                        <div id="allocation-progress" class="h-full bg-primary rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mt-2">
                        <div class="p-3 rounded-lg bg-surface flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline">Assigned Teachers</span>
                            <span id="overview-teacher-count" class="font-headline-md text-headline-md text-on-surface font-tabular-numeric mt-0.5">0</span>
                        </div>

                        <div class="p-3 rounded-lg bg-surface flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline">Active Allocations</span>
                            <span id="overview-assignment-count" class="font-headline-md text-headline-md text-on-surface font-tabular-numeric mt-0.5">0</span>
                        </div>

                        <div class="p-3 rounded-lg bg-tertiary-fixed/30 flex flex-col">
                            <div class="flex items-center gap-1 text-tertiary">
                                <span class="material-symbols-outlined text-[16px]">warning</span>
                                <span class="font-label-sm text-label-sm">Unassigned Allocations</span>
                            </div>
                            <span id="unassigned-count" class="font-headline-md text-headline-md text-tertiary font-tabular-numeric mt-0.5">0</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 p-2.5 rounded-lg bg-tertiary-fixed/20 text-on-tertiary-fixed-variant">
                        <span class="material-symbols-outlined text-[18px]">info</span>
                        <span id="allocation-message" class="font-body-sm text-body-sm">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="lg:col-span-5 flex flex-col gap-space-lg">

            <!-- Class Distribution -->
            <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Class Distribution</h3>
                    <span id="active-class-count" class="font-label-sm text-label-sm text-outline">0 Active Classes</span>
                </div>

                <div id="class-distribution" class="flex flex-wrap gap-1.5 pt-1">
                    <span class="font-body-sm text-outline">Loading...</span>
                </div>
            </div>

            <!-- Recent Enrolled Students -->
            <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col flex-1">
                <div class="flex items-center justify-between pb-space-sm mb-space-sm">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">badge</span>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Recent Enrollments</h2>
                    </div>

                    <a id="recent-enrollments-link" class="font-label-sm text-label-sm text-primary hover:text-primary-container font-semibold transition-colors" href="/admin/student-enrollments">
                        See all
                    </a>
                </div>

                <div id="recent-enrollments" class="flex flex-col gap-3">
                    <span class="font-body-sm text-outline">Loading enrollments...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div id="addStudentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="addStudentModalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="addStudentModalTitle" class="font-headline-md text-headline-md text-on-surface">Add New Student</h2>
                <p class="mt-1 text-sm text-on-surface-variant">Enter student details and assign their class, section, and academic session.</p>
            </div>

            <button type="button" id="closeAddStudentModal" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="addStudentForm" enctype="multipart/form-data" class="flex flex-col min-h-0">
            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">

                <div>
                    <label for="student_name" class="mb-1 block text-sm font-medium text-on-surface">Student Name *</label>
                    <input type="text" id="student_name" name="name" required maxlength="255" pattern="[A-Za-z ]+" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Enter student name">
                </div>

                <div>
                    <label for="student_code" class="mb-1 block text-sm font-medium text-on-surface">Student Code *</label>
                    <input type="text" id="student_code" name="student_code" required readonly maxlength="50" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Loading...">
                </div>

                <div>
                    <label for="student_parent_id" class="mb-1 block text-sm font-medium text-on-surface">Parent / Guardian *</label>
                    <select id="student_parent_id" name="parent_id" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Loading parents...</option>
                    </select>
                </div>

                <div>
                    <label for="student_date_of_birth" class="mb-1 block text-sm font-medium text-on-surface">Date of Birth</label>
                    <input type="date" id="student_date_of_birth" name="date_of_birth" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                </div>

                <div>
                    <label for="student_gender" class="mb-1 block text-sm font-medium text-on-surface">Gender</label>
                    <select id="student_gender" name="gender" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="student_profile_picture" class="mb-1 block text-sm font-medium text-on-surface">Profile Picture</label>
                    <input type="file" id="student_profile_picture" name="profile_picture" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-sm text-on-surface">
                    <p class="mt-1 text-xs text-on-surface-variant">JPG, PNG or WebP; maximum 2 MB.</p>
                </div>

                <div class="sm:col-span-2 mt-2 border-t border-outline-variant pt-4">
                    <h3 class="font-semibold text-on-surface">Enrollment Details</h3>
                    <p class="mt-1 text-sm text-on-surface-variant">The student and enrollment will be saved together.</p>
                </div>

                <div>
                    <label for="student_class_id" class="mb-1 block text-sm font-medium text-on-surface">Class *</label>
                    <select id="student_class_id" name="class_id" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Loading classes...</option>
                    </select>
                </div>

                <div>
                    <label for="student_section_id" class="mb-1 block text-sm font-medium text-on-surface">Section *</label>
                    <select id="student_section_id" name="section_id" required disabled class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Select a class first</option>
                    </select>
                </div>

                <div>
                    <label for="student_academic_session_id" class="mb-1 block text-sm font-medium text-on-surface">Academic Session *</label>
                    <select id="student_academic_session_id" name="academic_session_id" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Loading sessions...</option>
                    </select>
                </div>

                <div>
                    <label for="student_enrollment_date" class="mb-1 block text-sm font-medium text-on-surface">Enrollment Date *</label>
                    <input type="date" id="student_enrollment_date" name="enrollment_date" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="new_student_active" checked>
                    <label for="new_student_active" class="text-sm text-on-surface">Student account active</label>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="new_enrollment_active" checked>
                    <label for="new_enrollment_active" class="text-sm text-on-surface">Enrollment active</label>
                </div>
            </div>

            <div id="addStudentError" class="hidden mx-5 mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
                <button type="button" id="cancelAddStudent" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                    Cancel
                </button>

                <button type="submit" id="saveStudentButton" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    Save Student & Enroll
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Teacher Modal -->
<div id="teacherModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <!-- Modal Header - Fixed -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="modalTitle" class="font-headline-md text-headline-md text-on-surface">Add New Teacher</h2>
                <p id="modalSubtitle" class="mt-1 text-sm text-on-surface-variant">Register a teaching faculty member for this institute.</p>
            </div>

            <button type="button" id="closeModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="teacherForm" class="flex flex-col min-h-0">
            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">

                <div>
                    <label for="formName" class="mb-1 block text-sm font-medium text-on-surface">Teacher Full Name *</label>
                    <input type="text" id="formName" name="name" required maxlength="255" pattern="[A-Za-z ]+" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Enter teacher full name">
                </div>

                <div>
                    <label for="formCode" class="mb-1 block text-sm font-medium text-on-surface">Employee Code</label>
                    <input type="text" id="formCode" readonly class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Loading...">
                    <p class="mt-1 text-xs text-on-surface-variant">Automatically generated by the system.</p>
                </div>

                <div>
                    <label for="formPhone" class="mb-1 block text-sm font-medium text-on-surface">Phone *</label>
                    <input type="text" id="formPhone" name="phone" required maxlength="30" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="+92 300 1234567">
                </div>

                <div>
                    <label for="formEmail" class="mb-1 block text-sm font-medium text-on-surface">Email *</label>
                    <input type="email" id="formEmail" name="email" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="teacher@example.com">
                </div>

                <div class="sm:col-span-2">
                    <label for="formProfilePicture" class="mb-1 block text-sm font-medium text-on-surface">Profile Picture</label>
                    <input type="file" id="formProfilePicture" name="profile_picture" accept=".jpg,.jpeg,.png,.webp,.jfif,image/jpeg,image/png,image/webp" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-sm text-on-surface">
                    <p class="mt-1 text-xs text-on-surface-variant">JPG, JPEG, PNG, WEBP or JFIF; maximum 2 MB.</p>
                </div>

                <div>
                    <label for="formPassword" class="mb-1 block text-sm font-medium text-on-surface">
                        Password <span id="passwordRequired" class="text-error">*</span>
                    </label>
                    <input type="password" id="formPassword" name="password" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Temporary password">
                </div>

                <div>
                    <label for="formConfirmPassword" class="mb-1 block text-sm font-medium text-on-surface">
                        Confirm Password <span id="confirmPasswordRequired" class="text-error">*</span>
                    </label>
                    <input type="password" id="formConfirmPassword" name="password_confirmation" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Confirm password">
                </div>

                <!-- Account Status -->
                <div class="sm:col-span-2 mt-2">
                    <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-4">
                        <div>
                            <span class="block text-sm font-semibold text-on-surface">Account Status</span>
                            <span class="mt-1 block text-sm text-on-surface-variant">Allow teacher access to the system.</span>
                        </div>

                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" id="formStatusToggle" name="status" class="sr-only peer" checked>

                            <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                        </label>
                    </div>
                </div>

                <!-- Error -->
                <div id="formError" class="hidden sm:col-span-2 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>
            </div>

            <!-- Modal Footer - Fixed -->
            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
                <button type="button" id="cancelModalBtn" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                    Cancel
                </button>

                <button type="submit" id="saveTeacherBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    <span id="saveTeacherText">Save Teacher</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Parent Modal -->
<div id="parentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="parentModalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <!-- Modal Header - Fixed -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="parentModalTitle" class="font-headline-md text-headline-md text-on-surface">Add New Parent</h2>
                <p id="parentModalSubtitle" class="mt-1 text-sm text-on-surface-variant">Create a new parent or guardian account.</p>
            </div>

            <button type="button" id="closeParentModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="parentForm" class="flex flex-col min-h-0">
            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">

                <!-- Parent Name -->
                <div>
                    <label for="parentName" class="mb-1 block text-sm font-medium text-on-surface">Parent / Guardian Name *</label>
                    <input type="text" id="parentName" name="name" required maxlength="255" pattern="[A-Za-z ]+" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Enter parent name">
                </div>

                <!-- Phone -->
                <div>
                    <label for="parentPhone" class="mb-1 block text-sm font-medium text-on-surface">Phone *</label>
                    <input type="text" id="parentPhone" name="phone" required maxlength="30" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="+92 300 1234567">
                </div>

                <!-- Email -->
                <div>
                    <label for="parentEmail" class="mb-1 block text-sm font-medium text-on-surface">Email *</label>
                    <input type="email" id="parentEmail" name="email" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="parent@example.com">
                </div>

                <!-- Relationship -->
                <div>
                    <label for="parentRelationship" class="mb-1 block text-sm font-medium text-on-surface">Relationship *</label>
                    <select id="parentRelationship" name="relationship" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Select relationship</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Guardian">Guardian</option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label for="parentPassword" class="mb-1 block text-sm font-medium text-on-surface">
                        Password <span id="parentPasswordRequired" class="text-error">*</span>
                    </label>
                    <input type="password" id="parentPassword" name="password" required minlength="8" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Enter password">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="parentConfirmPassword" class="mb-1 block text-sm font-medium text-on-surface">
                        Confirm Password <span id="parentConfirmPasswordRequired" class="text-error">*</span>
                    </label>
                    <input type="password" id="parentConfirmPassword" name="password_confirmation" required minlength="8" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Confirm password">
                </div>

                <!-- Account Status -->
                <div class="sm:col-span-2 mt-2">
                    <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-4">
                        <div>
                            <span class="block text-sm font-semibold text-on-surface">Account Status</span>
                            <span class="mt-1 block text-sm text-on-surface-variant">Allow parent to access the system.</span>
                        </div>

                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" id="parentStatusToggle" name="status" class="sr-only peer" checked>
                            <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                        </label>
                    </div>
                </div>

                <!-- Error -->
                <div id="parentFormError" class="hidden sm:col-span-2 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>
            </div>

            <!-- Modal Footer - Fixed -->
            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
                <button type="button" id="cancelParentModalBtn" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                    Cancel
                </button>

                <button type="submit" id="saveParentBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    <span id="saveParentText">Save Parent</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Class Modal -->
<div id="classModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="classModalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <!-- Modal Header - Fixed -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="classModalTitle" class="font-headline-md text-headline-md text-on-surface">Add New Class</h2>
                <p id="classModalSubtitle" class="mt-1 text-sm text-on-surface-variant">Create a new class and its sections.</p>
            </div>

            <button type="button" id="closeClassModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="classForm" class="flex flex-col min-h-0">
            <div class="p-5 overflow-y-auto">

                <!-- Class Name -->
                <div>
                    <label for="className" class="mb-1 block text-sm font-medium text-on-surface">Class Name *</label>
                    <input type="text" id="className" name="name" required maxlength="255" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="e.g. Class 5">
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <label for="classDescription" class="mb-1 block text-sm font-medium text-on-surface">Description</label>
                    <textarea id="classDescription" name="description" rows="3" maxlength="1000" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface resize-none" placeholder="Enter class description (optional)"></textarea>
                </div>

                <!-- Sections -->
                <div class="mt-5">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <label class="block text-sm font-medium text-on-surface">Sections *</label>
                            <p class="mt-1 text-xs text-on-surface-variant">Add at least one section for this class.</p>
                        </div>

                        <button type="button" id="addSectionBtn" class="flex items-center gap-1 rounded-lg bg-secondary-container px-3 py-2 text-sm font-semibold text-on-secondary-container hover:opacity-90">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            Add Section
                        </button>
                    </div>

                    <div id="sectionsContainer" class="space-y-3"></div>
                </div>

                <!-- Class Status -->
                <div class="mt-5">
                    <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-4">
                        <div>
                            <span class="block text-sm font-semibold text-on-surface">Class Status</span>
                            <span class="mt-1 block text-sm text-on-surface-variant">Allow this class to be used in the system.</span>
                        </div>

                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" id="classStatusToggle" name="status" class="sr-only peer" checked>
                            <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                        </label>
                    </div>
                </div>

                <!-- Error -->
                <div id="classFormError" class="hidden mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>
            </div>

            <!-- Modal Footer - Fixed -->
            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
                <button type="button" id="cancelClassModalBtn" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                    Cancel
                </button>

                <button type="submit" id="saveClassBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    <span id="saveClassText">Save Class</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Subject Modal -->
<div id="subjectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="subjectModalTitle">
    <div class="w-full max-w-2xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <!-- Modal Header - Fixed -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="subjectModalTitle" class="font-headline-md text-headline-md text-on-surface">Add New Subject</h2>
                <p id="subjectModalSubtitle" class="mt-1 text-sm text-on-surface-variant">Create a new subject for your institute.</p>
            </div>

            <button type="button" id="closeSubjectModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="subjectForm" class="flex flex-col min-h-0">
            <div class="grid grid-cols-1 gap-4 p-5 overflow-y-auto sm:grid-cols-2">

                <!-- Subject Name -->
                <div>
                    <label for="subjectName" class="mb-1 block text-sm font-medium text-on-surface">Subject Name *</label>
                    <input type="text" id="subjectName" name="name" required maxlength="100" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="e.g. Mathematics">
                </div>

                <!-- Subject Code -->
                <div>
                    <label for="subjectCode" class="mb-1 block text-sm font-medium text-on-surface">Subject Code *</label>
                    <input type="text" id="subjectCode" name="code" required maxlength="50" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="e.g. MATH">
                </div>

                <!-- Description -->
                <div class="sm:col-span-2">
                    <label for="subjectDescription" class="mb-1 block text-sm font-medium text-on-surface">Description</label>
                    <textarea id="subjectDescription" name="description" rows="3" maxlength="1000" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface resize-none" placeholder="Enter subject description (optional)"></textarea>
                </div>

                <!-- Subject Status -->
                <div class="sm:col-span-2 mt-1">
                    <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-4">
                        <div>
                            <span class="block text-sm font-semibold text-on-surface">Subject Status</span>
                            <span class="mt-1 block text-sm text-on-surface-variant">Allow this subject to be used in the system.</span>
                        </div>

                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" id="subjectStatusToggle" name="status" class="sr-only peer" checked>
                            <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                        </label>
                    </div>
                </div>

                <!-- Error -->
                <div id="subjectFormError" class="hidden sm:col-span-2 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>
            </div>

            <!-- Modal Footer - Fixed -->
            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
                <button type="button" id="cancelSubjectModalBtn" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                    Cancel
                </button>

                <button type="submit" id="saveSubjectBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    <span id="saveSubjectText">Save Subject</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Assign Teacher Modal -->
<div id="assignTeacherModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="assignTeacherModalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="assignTeacherModalTitle" class="font-headline-md text-headline-md text-on-surface">Assign Teacher</h2>
                <p class="mt-1 text-sm text-on-surface-variant">Assign a teacher to a class, section, subject, and academic session.</p>
            </div>

            <button type="button" id="closeAssignTeacherModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="assignTeacherForm" class="flex flex-col min-h-0">
            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">

                <div class="sm:col-span-2">
                    <label for="assignmentTeacherId" class="mb-1 block text-sm font-medium text-on-surface">Teacher *</label>
                    <select id="assignmentTeacherId" name="teacher_id" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Loading teachers...</option>
                    </select>
                </div>

                <div>
                    <label for="assignmentClassId" class="mb-1 block text-sm font-medium text-on-surface">Class *</label>
                    <select id="assignmentClassId" name="class_id" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Loading classes...</option>
                    </select>
                </div>

                <div>
                    <label for="assignmentSectionId" class="mb-1 block text-sm font-medium text-on-surface">Section *</label>
                    <select id="assignmentSectionId" name="section_id" required disabled class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Select a class first</option>
                    </select>
                </div>

                <div>
                    <label for="assignmentSubjectId" class="mb-1 block text-sm font-medium text-on-surface">Subject *</label>
                    <select id="assignmentSubjectId" name="subject_id" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Loading subjects...</option>
                    </select>
                </div>

                <div>
                    <label for="assignmentAcademicSessionId" class="mb-1 block text-sm font-medium text-on-surface">Academic Session *</label>
                    <select id="assignmentAcademicSessionId" name="academic_session_id" required class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                        <option value="">Loading sessions...</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex items-center gap-2">
                    <input type="checkbox" id="assignmentStatusToggle" name="status" value="1" checked>
                    <label for="assignmentStatusToggle" class="text-sm text-on-surface">Assignment active</label>
                </div>
            </div>

            <div id="assignTeacherFormError" class="hidden mx-5 mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
                <button type="button" id="cancelAssignTeacherModalBtn" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                    Cancel
                </button>

                <button type="submit" id="saveAssignmentBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    <span id="saveAssignmentText">Assign Teacher</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Success Message --}}
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
    if (!token) return;

    const headers = {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
    };

    const teacherCount = document.getElementById('teacher-count');
    const parentCount = document.getElementById('parent-count');
    const studentCount = document.getElementById('student-count');
    const classCount = document.getElementById('class-count');
    const activeSession = document.getElementById('active-session');
    const assignmentCount = document.getElementById('assignment-count');
    const recentEnrollments = document.getElementById('recent-enrollments');

    async function fetchApi(endpoint) {
        const response = await fetch(endpoint, { method: 'GET', headers,  cache: 'no-store' });

        if (response.status === 401) {
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.replace('/');
            return null;
        }

        if (!response.ok) throw new Error(`API request failed: ${endpoint}`);
        return await response.json();
    }
    async function loadDashboard() {
        try {
            const [teachersResult, parentsResult, studentsResult, classesResult, sessionsResult, assignmentsResult, enrollmentsResult] = await Promise.all([
                fetchApi('/api/v1/admin/teachers'),
                fetchApi('/api/v1/admin/parents'),
                fetchApi('/api/v1/admin/students'),
                fetchApi('/api/v1/admin/classes'),
                fetchApi('/api/v1/admin/academic-sessions'),
                fetchApi('/api/v1/admin/teachers'),
                fetchApi('/api/v1/admin/student-enrollments')
            ]);
            
            console.log('Teachers Api',teachersResult);
            if (teachersResult?.status) teacherCount.textContent = teachersResult.statistics?.total_faculty ?? 0;
            if (parentsResult?.status) parentCount.textContent = parentsResult.count ?? 0;
            if (studentsResult?.status) studentCount.textContent = studentsResult.statistics?.total_students ?? 0;

        if (classesResult?.status) {
                classCount.textContent = classesResult.count ?? 0;
                const classes = classesResult.class_distribution ?? [];
                const activeClassCount = document.getElementById('active-class-count');
                const classDistribution = document.getElementById('class-distribution');
                activeClassCount.textContent =
                    `${classesResult.statistics?.active ?? 0} Active Classes`;
                if (classes.length > 0) {
                    classDistribution.innerHTML = classes.map(schoolClass => `
                        <span class="px-2.5 py-1 rounded-lg bg-surface text-on-surface font-tabular-numeric font-label-md text-label-md">
                            ${schoolClass.name}: <strong class="text-primary font-semibold">${schoolClass.student_count}</strong>
                        </span>
                    `).join('');
                } else {
                    classDistribution.innerHTML =
                        `<span class="font-body-sm text-outline">No class enrollment data available.</span>`;
                }
            }

            if (sessionsResult?.status) {
                const currentSession = sessionsResult.current_session;

                document.getElementById('overview-session-name').textContent = currentSession?.name ?? '—';
                document.getElementById('overview-session-start').textContent = currentSession ? currentSession.start_date : '—';
                document.getElementById('overview-session-end').textContent = currentSession ? currentSession.end_date : '—';
                activeSession.textContent = currentSession?.name ?? '—';
                document.getElementById('active-session-dates').textContent = currentSession ? `${currentSession.start_date} – ${currentSession.end_date}` : 'No active session';
            }

            if (assignmentsResult?.status) {
                const stats = assignmentsResult.statistics ?? {};
                const activeAllocations = Number(stats.assignment_count ?? 0);
                const assignedTeachers = Number(stats.assigned_count ?? 0);
                const totalFaculty = Number(stats.active_staff ?? 0);
                const unassigned = Number(stats.unassigned_count ?? 0);
                assignmentCount.textContent = activeAllocations;
                document.getElementById('overview-teacher-count').textContent = assignedTeachers;
                document.getElementById('overview-assignment-count').textContent = activeAllocations;
                document.getElementById('unassigned-count').textContent = unassigned;

                document.getElementById('allocation-message').textContent =
                    unassigned > 0
                        ? `${unassigned} free period${unassigned === 1 ? '' : 's'} remain across the teaching staff for the current academic session.`
                        : 'All required teacher periods are fully allocated for the current academic session.';
                const requiredAllocations = totalFaculty * 6;
                const coverage = requiredAllocations > 0
                    ? Math.round((activeAllocations / requiredAllocations) * 100)
                    : 0;
                document.getElementById('allocation-coverage').textContent = `${coverage}% Covered`;
                document.getElementById('allocation-progress').style.width = `${coverage}%`;
            }

            if (enrollmentsResult?.status) {
                const enrollments = enrollmentsResult.data?.data ?? enrollmentsResult.data ?? [];

                if (enrollments.length === 0) {
                    recentEnrollments.innerHTML = `<span class="font-body-sm text-outline">No enrollments found.</span>`;
                } else {
                    recentEnrollments.innerHTML = enrollments.slice(0, 2).map(enrollment => {
                        const student = enrollment.student;
                        const studentName = student?.name ?? 'Unknown Student';
                        const initials = studentName.split(' ').map(word => word.charAt(0)).join('').substring(0, 2).toUpperCase();
                        const className = enrollment.class?.name ?? '—';
                        const sectionName = enrollment.section?.name ?? '—';
                        const status = enrollment.status == 1 ? 'Enrolled' : 'Inactive';

                        return `
                            <div class="p-3 rounded-lg bg-surface hover:bg-surface-container-low transition-colors flex items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-full bg-primary-container text-on-primary flex items-center justify-center font-label-md text-label-md font-bold shrink-0">${initials}</div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-label-md text-label-md text-on-surface font-semibold truncate">${studentName}</span>
                                        <span class="font-body-sm text-body-sm text-outline font-tabular-numeric">ID: ${student?.id ?? '—'}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 shrink-0">
                                    <div class="text-right">
                                        <span class="font-label-sm text-label-sm text-on-surface font-medium block">${className}</span>
                                        <span class="font-label-sm text-label-sm text-outline">${sectionName}</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">${status}</span>
                                </div>
                            </div>
                        `;
                    }).join('');
                }

                const seeAllLink = document.getElementById('recent-enrollments-link');

                if (seeAllLink && enrollmentsResult.data?.total !== undefined) {
                    seeAllLink.textContent = `See all (${enrollmentsResult.data.total})`;
                }
            }
        } catch (error) {
            console.error('Error loading dashboard statistics:', error);
            teacherCount.textContent = '0';
            parentCount.textContent = '0';
            studentCount.textContent = '0';
            classCount.textContent = '0';
            activeSession.textContent = '—';
            assignmentCount.textContent = '0';
        }
    }
        loadDashboard();
    window.dashboardCleanup = () => {
        if (window.dashboardRefreshInterval) {
            clearInterval(window.dashboardRefreshInterval);
            window.dashboardRefreshInterval = null;
        }
        window.dashboardCleanup = null;
    };

    window.dashboardRefreshInterval = setInterval(loadDashboard, 30000);

    window.showToast = function(message, icon = 'check_circle') {
        const toast = document.getElementById('toastNotification');
        if (!toast) return;

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
})();
</script>

<!-- Add Student Modal -->
<script>
(() => {
    const modal = document.getElementById('addStudentModal');
    const form = document.getElementById('addStudentForm');
    const errorBox = document.getElementById('addStudentError');
    const saveButton = document.getElementById('saveStudentButton');
    const studentCodeInput = document.getElementById('student_code');
    const parentSelect = document.getElementById('student_parent_id');
    const classSelect = document.getElementById('student_class_id');
    const sectionSelect = document.getElementById('student_section_id');
    const sessionSelect = document.getElementById('student_academic_session_id');

    let sections = [];
    let listsLoaded = false;

    const today = new Date();
    const localToday = [today.getFullYear(), String(today.getMonth() + 1).padStart(2, '0'), String(today.getDate()).padStart(2, '0')].join('-');

    document.getElementById('student_enrollment_date').value = localToday;

    function getToken() {
        return localStorage.getItem('student_diary_token');
    }

    async function apiRequest(url, options = {}) {
        const token = getToken();

        if (!token) {
            window.location.replace('/');
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
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.replace('/');
            throw new Error('Your session has expired. Please log in again.');
        }

        if (!response.ok || result.status === false) {
            const validationMessages = result.errors ? Object.values(result.errors).flat().join('\n') : '';
            throw new Error(validationMessages || result.message || 'The request could not be completed.');
        }

        return result;
    }

    function extractList(result, alternativeKeys = []) {
        const candidates = [result?.data?.data, result?.data, ...alternativeKeys.map(key => result?.[key])];
        return candidates.find(Array.isArray) || [];
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

    function showError(message) {
        errorBox.textContent = message;
        errorBox.classList.remove('hidden');
    }

    function clearError() {
        errorBox.textContent = '';
        errorBox.classList.add('hidden');
    }

    async function loadFormOptions() {
        const [parentsResult, classesResult, sectionsResult, sessionsResult] = await Promise.all([
            apiRequest('/api/v1/admin/parents'),
            apiRequest('/api/v1/admin/classes'),
            apiRequest('/api/v1/admin/sections'),
            apiRequest('/api/v1/admin/academic-sessions')
        ]);

        const parents = extractList(parentsResult, ['parents']);
        const classes = extractList(classesResult, ['classes']);
        sections = extractList(sectionsResult, ['sections']);
        let sessions = extractList(sessionsResult, ['academic_sessions', 'sessions']);

        const currentSession = sessionsResult.current_session;

        if (currentSession?.id && !sessions.some(session => Number(session.id) === Number(currentSession.id))) {
            sessions.unshift(currentSession);
        }

        fillSelect(parentSelect, parents, parents.length ? 'Select parent / guardian' : 'No parents available', parent => parent.user?.name || parent.name || parent.user?.email || `Parent #${parent.id}`);
        fillSelect(classSelect, classes, classes.length ? 'Select class' : 'No classes available', schoolClass => schoolClass.name || schoolClass.class_name || `Class #${schoolClass.id}`);
        fillSelect(sessionSelect, sessions, sessions.length ? 'Select academic session' : 'No sessions available', session => session.name || `Session #${session.id}`);

        sectionSelect.replaceChildren();

        const sectionPlaceholder = document.createElement('option');
        sectionPlaceholder.value = '';
        sectionPlaceholder.textContent = 'Select a class first';
        sectionSelect.appendChild(sectionPlaceholder);
        sectionSelect.disabled = true;

        if (currentSession?.id) sessionSelect.value = String(currentSession.id);

        listsLoaded = true;
    }

    function updateSections() {
        const classId = classSelect.value;
        const matchingSections = sections.filter(section => Number(section.class_id) === Number(classId));

        fillSelect(
            sectionSelect,
            matchingSections,
            classId ? (matchingSections.length ? 'Select section' : 'No sections for this class') : 'Select a class first',
            section => section.name || section.section_name || `Section #${section.id}`
        );

        sectionSelect.disabled = !classId || matchingSections.length === 0;
    }

    async function loadNextStudentCode() {
        studentCodeInput.value = 'Loading...';

        try {
            const result = await apiRequest('/api/v1/admin/students/next-code');
            studentCodeInput.value = result.data.student_code;
        } catch (error) {
            studentCodeInput.value = '';
            showError(`Could not generate student code: ${error.message}`);
        }
    }

    function openModal() {
        clearError();
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        loadNextStudentCode();

        if (!listsLoaded) {
            loadFormOptions().catch(error => showError(error.message));
        }
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.getElementById('openAddStudentModal').addEventListener('click', openModal);
    document.getElementById('openAddStudentModalShortcut').addEventListener('click', openModal);
    document.getElementById('closeAddStudentModal').addEventListener('click', closeModal);
    document.getElementById('cancelAddStudent').addEventListener('click', closeModal);

    modal.addEventListener('click', event => {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });

    classSelect.addEventListener('change', updateSections);

    form.addEventListener('submit', async event => {
        event.preventDefault();
        clearError();

        if (!listsLoaded) {
            showError('Please wait while the form options finish loading.');
            return;
        }

        if (!sectionSelect.value) {
            showError('Please select a class and its section.');
            return;
        }

        const formData = new FormData(form);

        formData.set('status', document.getElementById('new_student_active').checked ? '1' : '0');
        formData.set('enrollment_status', document.getElementById('new_enrollment_active').checked ? '1' : '0');

        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';

        try {
            const result = await apiRequest('/api/v1/admin/students/register-with-enrollment', {
                method: 'POST',
                body: formData
            });

            closeModal();
            form.reset();
            document.getElementById('student_enrollment_date').value = localToday;
            listsLoaded = false;
            showToast(
                result.message || 'Student created successfully.',
                'check_circle'
            );
        } catch (error) {
            showError(error.message);
        } finally {
            saveButton.disabled = false;
            saveButton.textContent = 'Save Student & Enroll';
        }
    });
})();
</script>

<!-- Add Teacher Modal -->
<script>
(() => {
    const teacherModal = document.getElementById('teacherModal');
    const openTeacherModalBtn = document.getElementById('openModalBtn');
    const closeTeacherModalBtn = document.getElementById('closeModalBtn');
    const cancelTeacherModalBtn = document.getElementById('cancelModalBtn');
    const teacherForm = document.getElementById('teacherForm');
    const formTeacherId = document.getElementById('formTeacherId');
    const formName = document.getElementById('formName');
    const formCode = document.getElementById('formCode');
    const formPhone = document.getElementById('formPhone');
    const formEmail = document.getElementById('formEmail');
    const formProfilePicture = document.getElementById('formProfilePicture');
    const formPassword = document.getElementById('formPassword');
    const formConfirmPassword = document.getElementById('formConfirmPassword');
    const formStatusToggle = document.getElementById('formStatusToggle');
    const formError = document.getElementById('formError');
    const saveTeacherBtn = document.getElementById('saveTeacherBtn');
    const saveTeacherText = document.getElementById('saveTeacherText');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const passwordRequired = document.getElementById('passwordRequired');
    const confirmPasswordRequired = document.getElementById('confirmPasswordRequired');

    async function openTeacherModal() {
        teacherForm.reset();
        formError.classList.add('hidden');
        formError.textContent = '';

        if (formTeacherId) formTeacherId.value = '';

        formStatusToggle.checked = true;
        modalTitle.textContent = 'Add Teacher';
        modalSubtitle.textContent = 'Create a new teacher account';
        saveTeacherText.textContent = 'Save Teacher';

        formPassword.required = true;
        formConfirmPassword.required = true;

        if (passwordRequired) passwordRequired.classList.remove('hidden');
        if (confirmPasswordRequired) confirmPasswordRequired.classList.remove('hidden');

        teacherModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        await loadNextEmployeeCode();
    }

    function closeTeacherModal() {
        teacherModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        teacherForm.reset();
        formError.classList.add('hidden');
        formError.textContent = '';
    }

    async function apiRequest(url, options = {}) {
        const token = localStorage.getItem('student_diary_token');

        const headers = {
            'Accept': 'application/json',
            ...(options.headers || {})
        };

        if (token) headers['Authorization'] = `Bearer ${token}`;

        const response = await fetch(url, { ...options, headers });

        if (response.status === 401) {
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.href = '/';
            return null;
        }

        return response;
    }

    async function loadNextEmployeeCode() {
        formCode.value = 'Generating...';

        try {
            const response = await apiRequest('/api/v1/admin/teachers/next-code');

            if (!response) return;

            const result = await response.json();

            if (!response.ok || !result.status) {
                formCode.value = '';
                showTeacherError(result.message || 'Unable to generate employee code.');
                return;
            }

            formCode.value = result.employee_code;
        } catch (error) {
            console.error('Employee code error:', error);
            formCode.value = '';
            showTeacherError('Unable to generate employee code.');
        }
    }

    function showTeacherError(message) {
        formError.textContent = message;
        formError.classList.remove('hidden');
    }

    teacherForm.addEventListener('submit', async event => {
        event.preventDefault();
        formError.classList.add('hidden');
        formError.textContent = '';

        if (formPassword.value !== formConfirmPassword.value) {
            showTeacherError('Password and confirm password do not match.');
            return;
        }

        saveTeacherBtn.disabled = true;
        saveTeacherText.textContent = 'Saving...';

        try {
            const formData = new FormData();

            formData.append('name', formName.value.trim());
            formData.append('phone', formPhone.value.trim());
            formData.append('email', formEmail.value.trim());
            formData.append('password', formPassword.value);
            formData.append('password_confirmation', formConfirmPassword.value);
            formData.append('status', formStatusToggle.checked ? '1' : '0');

            if (formProfilePicture && formProfilePicture.files.length > 0) {
                formData.append('profile_picture', formProfilePicture.files[0]);
            }

            const response = await apiRequest('/api/v1/admin/teachers', {
                method: 'POST',
                body: formData
            });

            if (!response) return;

            const result = await response.json();

            if (response.status === 422) {
                if (result.errors) {
                    const messages = Object.values(result.errors).flat().join(' ');
                    showTeacherError(messages);
                } else {
                    showTeacherError(result.message || 'Please check the entered information.');
                }

                return;
            }

            if (!response.ok) {
                showTeacherError(result.message || 'Failed to create teacher.');
                return;
            }

            if (result.status === true) {
                closeTeacherModal();
                showToast(
                    result.message || 'Student created successfully.',
                    'check_circle'
                );
            } else {
                showTeacherError(result.message || 'Failed to create teacher.');
            }
        } catch (error) {
            console.error('Teacher creation error:', error);
            showTeacherError('Something went wrong. Please try again.');
        } finally {
            saveTeacherBtn.disabled = false;
            saveTeacherText.textContent = 'Save Teacher';
        }
    });

    openTeacherModalBtn.addEventListener('click', openTeacherModal);
    closeTeacherModalBtn.addEventListener('click', closeTeacherModal);
    cancelTeacherModalBtn.addEventListener('click', closeTeacherModal);

    teacherModal.addEventListener('click', event => {
        if (event.target === teacherModal) closeTeacherModal();
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !teacherModal.classList.contains('hidden')) closeTeacherModal();
    });
})();
</script>

<!-- Add Parent Modal -->
<script>
(() => {
    const parentModal = document.getElementById('parentModal');
    const openParentModalBtn = document.getElementById('openParentModalBtn');
    const closeParentModalBtn = document.getElementById('closeParentModalBtn');
    const cancelParentModalBtn = document.getElementById('cancelParentModalBtn');
    const parentForm = document.getElementById('parentForm');
    const parentName = document.getElementById('parentName');
    const parentPhone = document.getElementById('parentPhone');
    const parentEmail = document.getElementById('parentEmail');
    const parentRelationship = document.getElementById('parentRelationship');
    const parentPassword = document.getElementById('parentPassword');
    const parentConfirmPassword = document.getElementById('parentConfirmPassword');
    const parentStatusToggle = document.getElementById('parentStatusToggle');
    const parentFormError = document.getElementById('parentFormError');
    const saveParentBtn = document.getElementById('saveParentBtn');
    const saveParentText = document.getElementById('saveParentText');

    function openParentModal() {
        parentForm.reset();
        parentFormError.classList.add('hidden');
        parentFormError.textContent = '';
        parentStatusToggle.checked = true;
        parentModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeParentModal() {
        parentModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        parentForm.reset();
        parentFormError.classList.add('hidden');
        parentFormError.textContent = '';
    }

    async function apiRequest(url, options = {}) {
        const token = localStorage.getItem('student_diary_token');

        const headers = {
            'Accept': 'application/json',
            ...(options.headers || {})
        };

        if (token) headers['Authorization'] = `Bearer ${token}`;

        const response = await fetch(url, { ...options, headers });

        if (response.status === 401) {
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.href = '/';
            return null;
        }

        return response;
    }

    function showParentError(message) {
        parentFormError.textContent = message;
        parentFormError.classList.remove('hidden');
    }

    parentForm.addEventListener('submit', async event => {
        event.preventDefault();

        parentFormError.classList.add('hidden');
        parentFormError.textContent = '';

        if (parentPassword.value !== parentConfirmPassword.value) {
            showParentError('Password and confirm password do not match.');
            return;
        }

        saveParentBtn.disabled = true;
        saveParentText.textContent = 'Saving...';

        try {
            const formData = new FormData();

            formData.append('name', parentName.value.trim());
            formData.append('phone', parentPhone.value.trim());
            formData.append('email', parentEmail.value.trim());
            formData.append('relationship', parentRelationship.value);
            formData.append('password', parentPassword.value);
            formData.append('password_confirmation', parentConfirmPassword.value);
            formData.append('status', parentStatusToggle.checked ? '1' : '0');

            const response = await apiRequest('/api/v1/admin/parents', {
                method: 'POST',
                body: formData
            });

            if (!response) return;

            const result = await response.json();

            if (response.status === 422) {
                if (result.errors) {
                    const messages = Object.values(result.errors).flat().join(' ');
                    showParentError(messages);
                } else {
                    showParentError(result.message || 'Please check the entered information.');
                }

                return;
            }

            if (!response.ok) {
                showParentError(result.message || 'Failed to create parent.');
                return;
            }

            if (result.status === true) {
                closeParentModal();
                showToast(
                    result.message || 'Student created successfully.',
                    'check_circle'
                );
            } else {
                showParentError(result.message || 'Failed to create parent.');
            }
        } catch (error) {
            console.error('Parent creation error:', error);
            showParentError('Something went wrong. Please try again.');
        } finally {
            saveParentBtn.disabled = false;
            saveParentText.textContent = 'Save Parent';
        }
    });

    openParentModalBtn.addEventListener('click', openParentModal);
    closeParentModalBtn.addEventListener('click', closeParentModal);
    cancelParentModalBtn.addEventListener('click', closeParentModal);

    parentModal.addEventListener('click', event => {
        if (event.target === parentModal) closeParentModal();
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !parentModal.classList.contains('hidden')) {
            closeParentModal();
        }
    });
})();
</script>

<!-- Add Class Modal -->
<script>
(() => {
    const classModal = document.getElementById('classModal');
    const openClassModalBtn = document.getElementById('openClassModalBtn');
    const closeClassModalBtn = document.getElementById('closeClassModalBtn');
    const cancelClassModalBtn = document.getElementById('cancelClassModalBtn');
    const classForm = document.getElementById('classForm');
    const className = document.getElementById('className');
    const classDescription = document.getElementById('classDescription');
    const classStatusToggle = document.getElementById('classStatusToggle');
    const classFormError = document.getElementById('classFormError');
    const saveClassBtn = document.getElementById('saveClassBtn');
    const saveClassText = document.getElementById('saveClassText');
    const addSectionBtn = document.getElementById('addSectionBtn');
    const sectionsContainer = document.getElementById('sectionsContainer');

    function openClassModal() {
        classForm.reset();
        classFormError.classList.add('hidden');
        classFormError.textContent = '';
        classStatusToggle.checked = true;
        sectionsContainer.replaceChildren();
        addSection();
        classModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeClassModal() {
        classModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        classForm.reset();
        classFormError.classList.add('hidden');
        classFormError.textContent = '';
        sectionsContainer.replaceChildren();
    }

    function addSection() {
        const sectionRow = document.createElement('div');
        sectionRow.className = 'flex items-center gap-3';

        sectionRow.innerHTML = `
            <input type="text" name="sections[]" required maxlength="255" class="flex-1 rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="e.g. A">
            <button type="button" class="removeSectionBtn rounded-lg p-2 text-error hover:bg-red-50" aria-label="Remove section">
                <span class="material-symbols-outlined">delete</span>
            </button>
        `;

        sectionRow.querySelector('.removeSectionBtn').addEventListener('click', () => {
            sectionRow.remove();
        });

        sectionsContainer.appendChild(sectionRow);
    }

    async function apiRequest(url, options = {}) {
        const token = localStorage.getItem('student_diary_token');

        const headers = {
            'Accept': 'application/json',
            ...(options.headers || {})
        };

        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        const response = await fetch(url, {
            ...options,
            headers
        });

        if (response.status === 401) {
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.href = '/';
            return null;
        }

        return response;
    }

    function showClassError(message) {
        classFormError.textContent = message;
        classFormError.classList.remove('hidden');
    }

    addSectionBtn.addEventListener('click', addSection);

    classForm.addEventListener('submit', async event => {
        event.preventDefault();

        classFormError.classList.add('hidden');
        classFormError.textContent = '';

        const sectionInputs = sectionsContainer.querySelectorAll('input[name="sections[]"]');

        if (sectionInputs.length === 0) {
            showClassError('Please add at least one section.');
            return;
        }

        const sections = Array.from(sectionInputs)
            .map(input => input.value.trim())
            .filter(name => name !== '');

        if (sections.length === 0) {
            showClassError('Please enter at least one section name.');
            return;
        }

        if (new Set(sections.map(name => name.toLowerCase())).size !== sections.length) {
            showClassError('Section names must be unique.');
            return;
        }

        saveClassBtn.disabled = true;
        saveClassText.textContent = 'Saving...';

        try {
            const formData = new FormData();

            formData.append('name', className.value.trim());
            formData.append('description', classDescription.value.trim());
            formData.append('status', classStatusToggle.checked ? '1' : '0');

            sections.forEach(section => {
                formData.append('sections[]', section);
            });

            const response = await apiRequest('/api/v1/admin/classes', {
                method: 'POST',
                body: formData
            });

            if (!response) return;

            const result = await response.json();

            if (response.status === 422) {
                if (result.errors) {
                    const messages = Object.values(result.errors).flat().join(' ');
                    showClassError(messages);
                } else {
                    showClassError(result.message || 'Please check the entered information.');
                }
                return;
            }

            if (!response.ok) {
                showClassError(result.message || 'Failed to create class.');
                return;
            }

            if (result.status === true) {
                closeClassModal();
                showToast(
                    result.message || 'Student created successfully.',
                    'check_circle'
                );
            } else {
                showClassError(result.message || 'Failed to create class.');
            }

        } catch (error) {
            console.error('Class creation error:', error);
            showClassError('Something went wrong. Please try again.');
        } finally {
            saveClassBtn.disabled = false;
            saveClassText.textContent = 'Save Class';
        }
    });

    openClassModalBtn.addEventListener('click', openClassModal);
    closeClassModalBtn.addEventListener('click', closeClassModal);
    cancelClassModalBtn.addEventListener('click', closeClassModal);

    classModal.addEventListener('click', event => {
        if (event.target === classModal) {
            closeClassModal();
        }
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !classModal.classList.contains('hidden')) {
            closeClassModal();
        }
    });
})();
</script>

<!-- Add Subject Modal -->
<script>
(() => {
    const subjectModal = document.getElementById('subjectModal');
    const openSubjectModalBtn = document.getElementById('openSubjectModalBtn');
    const closeSubjectModalBtn = document.getElementById('closeSubjectModalBtn');
    const cancelSubjectModalBtn = document.getElementById('cancelSubjectModalBtn');
    const subjectForm = document.getElementById('subjectForm');
    const subjectName = document.getElementById('subjectName');
    const subjectCode = document.getElementById('subjectCode');
    const subjectDescription = document.getElementById('subjectDescription');
    const subjectStatusToggle = document.getElementById('subjectStatusToggle');
    const subjectFormError = document.getElementById('subjectFormError');
    const saveSubjectBtn = document.getElementById('saveSubjectBtn');
    const saveSubjectText = document.getElementById('saveSubjectText');

    function openSubjectModal() {
        subjectForm.reset();
        subjectFormError.classList.add('hidden');
        subjectFormError.textContent = '';
        subjectStatusToggle.checked = true;
        subjectModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeSubjectModal() {
        subjectModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        subjectForm.reset();
        subjectFormError.classList.add('hidden');
        subjectFormError.textContent = '';
    }

    async function apiRequest(url, options = {}) {
        const token = localStorage.getItem('student_diary_token');

        const headers = {
            'Accept': 'application/json',
            ...(options.headers || {})
        };

        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        const response = await fetch(url, {
            ...options,
            headers
        });

        if (response.status === 401) {
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.href = '/';
            return null;
        }

        return response;
    }

    function showSubjectError(message) {
        subjectFormError.textContent = message;
        subjectFormError.classList.remove('hidden');
    }

    subjectForm.addEventListener('submit', async event => {
        event.preventDefault();

        subjectFormError.classList.add('hidden');
        subjectFormError.textContent = '';

        saveSubjectBtn.disabled = true;
        saveSubjectText.textContent = 'Saving...';

        try {
            const formData = new FormData();

            formData.append('name', subjectName.value.trim());
            formData.append('code', subjectCode.value.trim());
            formData.append('description', subjectDescription.value.trim());
            formData.append('status', subjectStatusToggle.checked ? '1' : '0');

            const response = await apiRequest('/api/v1/admin/subjects', {
                method: 'POST',
                body: formData
            });

            if (!response) return;

            const result = await response.json();

            if (response.status === 422) {
                if (result.errors) {
                    const messages = Object.values(result.errors).flat().join(' ');
                    showSubjectError(messages);
                } else {
                    showSubjectError(result.message || 'Please check the entered information.');
                }
                return;
            }

            if (!response.ok) {
                showSubjectError(result.message || 'Failed to create subject.');
                return;
            }

            if (result.status === true) {
                closeSubjectModal();
                showToast(
                    result.message || 'Subject created successfully.',
                    'check_circle'
                );
            } else {
                showSubjectError(result.message || 'Failed to create subject.');
            }

        } catch (error) {
            console.error('Subject creation error:', error);
            showSubjectError('Something went wrong. Please try again.');
        } finally {
            saveSubjectBtn.disabled = false;
            saveSubjectText.textContent = 'Save Subject';
        }
    });

    openSubjectModalBtn.addEventListener('click', openSubjectModal);
    closeSubjectModalBtn.addEventListener('click', closeSubjectModal);
    cancelSubjectModalBtn.addEventListener('click', closeSubjectModal);

    subjectModal.addEventListener('click', event => {
        if (event.target === subjectModal) {
            closeSubjectModal();
        }
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !subjectModal.classList.contains('hidden')) {
            closeSubjectModal();
        }
    });
})();
</script>

<!-- Assign Teacher Modal -->
<script>
(() => {
    const modal = document.getElementById('assignTeacherModal');
    const form = document.getElementById('assignTeacherForm');
    const teacherSelect = document.getElementById('assignmentTeacherId');
    const classSelect = document.getElementById('assignmentClassId');
    const sectionSelect = document.getElementById('assignmentSectionId');
    const subjectSelect = document.getElementById('assignmentSubjectId');
    const sessionSelect = document.getElementById('assignmentAcademicSessionId');
    const statusToggle = document.getElementById('assignmentStatusToggle');
    const errorBox = document.getElementById('assignTeacherFormError');
    const saveButton = document.getElementById('saveAssignmentBtn');
    const saveText = document.getElementById('saveAssignmentText');

    let sections = [];

    function getToken() {
        return localStorage.getItem('student_diary_token');
    }

    async function apiRequest(url, options = {}) {
        const token = getToken();

        if (!token) {
            window.location.replace('/');
            throw new Error('Your session has expired.');
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
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.replace('/');
            throw new Error('Your session has expired.');
        }

        if (!response.ok || result.status === false) {
            const messages = result.errors ? Object.values(result.errors).flat().join(' ') : '';
            throw new Error(messages || result.message || 'The request could not be completed.');
        }

        return result;
    }

    function extractList(result, keys = []) {
        const candidates = [result?.data?.data, result?.data, ...keys.map(key => result?.[key])];
        return candidates.find(Array.isArray) || [];
    }

    function fillSelect(select, items, placeholder, label) {
        select.replaceChildren();

        const option = document.createElement('option');
        option.value = '';
        option.textContent = placeholder;
        select.appendChild(option);

        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = label(item);
            select.appendChild(option);
        });
    }

    function clearError() {
        errorBox.textContent = '';
        errorBox.classList.add('hidden');
    }

    function showError(message) {
        errorBox.textContent = message;
        errorBox.classList.remove('hidden');
    }

    async function loadOptions() {
        const [teachersResult, classesResult, sectionsResult, subjectsResult, sessionsResult] = await Promise.all([
            apiRequest('/api/v1/admin/teachers'),
            apiRequest('/api/v1/admin/classes'),
            apiRequest('/api/v1/admin/sections'),
            apiRequest('/api/v1/admin/subjects'),
            apiRequest('/api/v1/admin/academic-sessions')
        ]);

        const teachers = extractList(teachersResult, ['teachers']);
        const classes = extractList(classesResult, ['classes']);
        sections = extractList(sectionsResult, ['sections']);
        const subjects = extractList(subjectsResult, ['subjects']);
        const sessions = extractList(sessionsResult, ['academic_sessions', 'sessions']);

        fillSelect(
            teacherSelect,
            teachers,
            teachers.length ? 'Select teacher' : 'No teachers available',
            teacher => teacher.user?.name || teacher.name || teacher.user?.email || `Teacher #${teacher.id}`
        );

        fillSelect(
            classSelect,
            classes,
            classes.length ? 'Select class' : 'No classes available',
            item => item.name || `Class #${item.id}`
        );

        fillSelect(
            subjectSelect,
            subjects,
            subjects.length ? 'Select subject' : 'No subjects available',
            item => item.name || item.code || `Subject #${item.id}`
        );

        fillSelect(
            sessionSelect,
            sessions,
            sessions.length ? 'Select academic session' : 'No sessions available',
            item => item.name || `Session #${item.id}`
        );

        sectionSelect.replaceChildren();

        const option = document.createElement('option');
        option.value = '';
        option.textContent = 'Select class first';
        sectionSelect.appendChild(option);
        sectionSelect.disabled = true;

        if (sessionsResult.current_session?.id) {
            sessionSelect.value = String(sessionsResult.current_session.id);
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
                ? (matchingSections.length ? 'Select section' : 'No sections available')
                : 'Select class first',
            section => section.name || `Section #${section.id}`
        );

        sectionSelect.disabled = !classId || matchingSections.length === 0;
    }

    function openModal() {
        form.reset();
        clearError();
        statusToggle.checked = true;
        sectionSelect.disabled = true;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        loadOptions().catch(error => showError(error.message));
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        form.reset();
        clearError();
    }

    document.getElementById('openAssignTeacherModalBtn').addEventListener('click', openModal);
    document.getElementById('closeAssignTeacherModalBtn').addEventListener('click', closeModal);
    document.getElementById('cancelAssignTeacherModalBtn').addEventListener('click', closeModal);

    classSelect.addEventListener('change', updateSections);

    modal.addEventListener('click', event => {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    form.addEventListener('submit', async event => {
        event.preventDefault();
        clearError();

        saveButton.disabled = true;
        saveText.textContent = 'Assigning...';

        try {
            const formData = new FormData();

            formData.append('teacher_id', teacherSelect.value);
            formData.append('class_id', classSelect.value);
            formData.append('section_id', sectionSelect.value);
            formData.append('subject_id', subjectSelect.value);
            formData.append('academic_session_id', sessionSelect.value);
            formData.append('status', statusToggle.checked ? '1' : '0');

            const result = await apiRequest('/api/v1/admin/teacher-assignments', {
                method: 'POST',
                body: formData
            });

            closeModal();

            showToast(
                result.message || 'Teacher assigned successfully.',
                'check_circle'
            );
        } catch (error) {
            showError(error.message);
        } finally {
            saveButton.disabled = false;
            saveText.textContent = 'Assign Teacher';
        }
    });
})();
</script>
@endsection