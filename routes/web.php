<?php

use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::view('/studentdiary', 'auth.super-admin-login')
    ->name('super-admin-login');    
Route::view('/super-admin/dashboard', 'super-admin.dashboard')
    ->name('super-admin.dashboard');
Route::view('/super-admin/institutes', 'super-admin.institutes.index')
    ->name('super-admin.institutes');

Route::get('/login/{institute}', [AuthController::class, 'showInstituteLogin'])
    ->name('institute.login');
Route::view('/admin/dashboard', 'admin.dashboard')
    ->name('admin.dashboard');
Route::view('/admin/teachers', 'admin.teachers.index')
    ->name('admin.teachers');
Route::view('/admin/parents', 'admin.parents.index')
    ->name('admin.parents');
Route::view('/admin/students', 'admin.students.index')
    ->name('admin.students');
Route::view('/admin/classes', 'admin.classes.index')
    ->name('admin.classes');
Route::view('/admin/subjects', 'admin.subjects.index')
    ->name('admin.subjects');
Route::view('/admin/teacher-assignments', 'admin.teacherassignments.index')
    ->name('admin.teacher-assignments');
Route::view('/admin/student-enrollments', 'admin.studentenrollments.index')
    ->name('admin.student-enrollments');
Route::view('/admin/profile', 'admin.profile')
    ->name('admin.profile');

Route::view('/teacher/dashboard', 'teacher.dashboard')
    ->name('teacher.dashboard');
Route::view('/teacher/profile', 'teacher.profile')
    ->name('teacher.profile');    
Route::view('/teacher/diaries', 'teacher.diaries.index')
    ->name('teacher.diaries');    
Route::view('/teacher/assignments', 'teacher.assignments.index')
    ->name('teacher.assignments');    
Route::view('/teacher/scheduledDiaries', 'teacher.diaries.scheduled-diaries')
    ->name('teacher.scheduled-diaries');    

Route::view('/parent/dashboard', 'parent.dashboard')
    ->name('parent.dashboard');    
Route::view('/parent/children/{student}/diary', 'parent.diary')
    ->name('parent.diary');
Route::view('/parent/diaries/{diary}', 'parent.diary-details')
    ->name('parent.diary.details');   
Route::view('/parent/children', 'parent.children')
    ->name('parent.children');         
Route::view('/parent/profile', 'parent.profile')
    ->name('parent.profile');         