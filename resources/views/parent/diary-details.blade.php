@extends('layouts.parent')

@section('title', 'Diary Details')

@section('content')

<div class="flex flex-col w-full gap-space-lg">

    <!-- Diary Information -->
    <section id="diaryContent" class="hidden flex flex-col gap-space-lg">
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg mt-4">
            <!-- Subject -->
            <div class="flex items-center gap-3 pb-5 border-b border-outline-variant/30">
                <a href="javascript:history.back()" class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-container-low text-primary hover:bg-primary hover:text-on-primary transition-colors" title="Back"> 
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span> 
                </a>
                <div>
                    <h2 id="subjectName" class="text-lg font-semibold text-on-surface">
                        —
                    </h2>
                </div>
            </div>
            <!-- Student Details -->
            <div class="flex flex-wrap items-center gap-x-6 gap-y-4 pt-5">
                <!-- Student -->
                <div>
                    <p class="text-xs text-on-surface-variant">Student</p>
                    <p id="studentName" class="text-sm font-semibold text-on-surface">
                        —
                    </p>
                </div>
                <!-- Teacher -->
                <div>
                    <p class="text-xs text-on-surface-variant">Teacher</p>
                    <p id="teacherName" class="text-sm font-semibold text-on-surface">
                        —
                    </p>
                </div>
                <!-- Class -->
                <div>
                    <p class="text-xs text-on-surface-variant">Class</p>
                    <p id="studentClass" class="text-sm font-semibold text-on-surface">
                        —
                    </p>
                </div>
                <!-- Section -->
                <div>
                    <p class="text-xs text-on-surface-variant">Section</p>
                    <p id="studentSection" class="text-sm font-semibold text-on-surface">
                        —
                    </p>
                </div>
                <!-- Diary Date -->
                <div>
                    <p class="text-xs text-on-surface-variant">Diary Date</p>
                    <p id="diaryDate" class="text-sm font-semibold text-on-surface">
                        —
                    </p>
                </div>

            </div>
        </div>

        <!-- Homework + Classwork -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">

            <!-- Homework -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden border-l-4 border-primary">
                <div class="p-space-lg">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 rounded-lg bg-surface flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">assignment</span>
                        </div>

                        <div>
                            <h3 class="font-semibold text-on-surface">Homework</h3>
                            <span id="homeworkDeadline"
                                class="text-xs text-primary font-medium">
                                No deadline
                            </span>
                        </div>
                    </div>

                    <div id="homeworkContent"
                        class="text-sm text-on-surface leading-7 whitespace-pre-line">
                        No homework assigned.
                    </div>

                </div>
            </div>

            <!-- Classwork -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden border-l-4 border-secondary">
                <div class="p-space-lg">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 rounded-lg bg-surface flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary">menu_book</span>
                        </div>

                        <div>
                            <h3 class="font-semibold text-on-surface">Classwork</h3>
                            <p class="text-sm text-on-surface-variant">
                                Work completed in class
                            </p>
                        </div>
                    </div>

                    <div id="classworkContent"
                        class="text-sm text-on-surface leading-7 whitespace-pre-line">
                        No classwork recorded.
                    </div>

                </div>
            </div>

        </div>

        <!-- Teacher Instructions -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden border-l-4 border-tertiary">
            <div class="p-space-lg">

                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 rounded-lg bg-tertiary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-tertiary">campaign</span>
                    </div>

                    <div>
                        <h3 class="font-semibold text-on-surface">
                            Teacher's Instructions for Parents
                        </h3>
                        <p class="text-sm text-on-surface-variant">
                            Important information from the teacher
                        </p>
                    </div>
                </div>

                <div id="instructionsContent"
                    class="text-sm text-on-surface leading-7 whitespace-pre-line">
                    No instructions provided.
                </div>

            </div>
        </div>

    </section>

    <!-- Loading -->
    <div id="loadingState"
         class="flex items-center justify-center py-16 text-on-surface-variant">
        Loading diary details...
    </div>

    <!-- Error -->
    <div id="errorState"
         class="hidden text-center py-16">
        <span class="material-symbols-outlined text-4xl text-error">error</span>
        <p class="mt-3 text-on-surface">Unable to load diary details.</p>
    </div>

</div>

<script>
(()=>{
const token = localStorage.getItem('student_diary_token');
const API_BASE = '/api/v1';
const diaryId = @json(request()->route('diary'));

const headers = {
    Authorization: `Bearer ${token}`,
    Accept: 'application/json',
    'Content-Type': 'application/json'
};

async function loadDiaryDetails() {
    try {
        const response = await fetch(`${API_BASE}/parent/diaries/${diaryId}`, {
            method: 'GET',
            headers
        });

        if (response.status === 401) {
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.href = '/login';
            return;
        }

        const result = await response.json();

        if (!response.ok || !result.status) {
            throw new Error(result.message || 'Unable to load diary.');
        }

        renderDiary(result.data);
    } catch (error) {
        console.error(error);
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('errorState').classList.remove('hidden');
    }
}

function renderDiary(diary) {
    document.getElementById('loadingState').classList.add('hidden');
    document.getElementById('diaryContent').classList.remove('hidden');

    document.getElementById('subjectName').textContent =
        diary.subject?.name || '—';

    document.getElementById('studentName').textContent =
        diary.student?.name || '—';

    document.getElementById('teacherName').textContent =
        diary.teacher?.name || '—';

    document.getElementById('studentClass').textContent =
        diary.class?.name || '—';

    document.getElementById('studentSection').textContent =
        diary.section?.name || '—';

    document.getElementById('diaryDate').textContent =
        diary.diary_date || '—';

    document.getElementById('homeworkContent').textContent =
        diary.homework || 'No homework assigned.';

    document.getElementById('classworkContent').textContent =
        diary.classwork || 'No classwork recorded.';

    document.getElementById('instructionsContent').textContent =
        diary.instructions || 'No instructions provided.';

    document.getElementById('homeworkDeadline').textContent =
        diary.due_date
            ? `Deadline: ${formatDate(diary.due_date)}`
            : 'No deadline';
}

function formatDate(value) {
    if (!value) return 'No deadline';

    const [day, month, year] = value.split('-').map(Number);

    return new Date(year, month - 1, day).toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

loadDiaryDetails();
})();
</script>

@endsection