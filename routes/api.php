<?php

use App\Http\Controllers\Api\v1\Admin\TeacherController;
use App\Http\Controllers\Api\v1\SuperAdmin\InstituteAdminController;
use App\Http\Controllers\API\v1\Admin\AcademicSessionController;
use App\Http\Controllers\API\v1\Admin\ClassController;
use App\Http\Controllers\API\v1\Admin\ClassSubjectController;
use App\Http\Controllers\API\v1\Admin\ParentController;
use App\Http\Controllers\API\v1\Admin\PasswordController;
use App\Http\Controllers\API\v1\Admin\SectionController;
use App\Http\Controllers\API\v1\Admin\StudentController;
use App\Http\Controllers\API\v1\Admin\StudentEnrollmentController;
use App\Http\Controllers\API\v1\Admin\SubjectController;
use App\Http\Controllers\API\v1\Admin\TeacherAssignmentController;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\Parent\DiaryController;
use App\Http\Controllers\API\v1\Parent\ParentController as ParentParentController;
use App\Http\Controllers\API\v1\SuperAdmin\ConfigurationController;
use App\Http\Controllers\API\v1\SuperAdmin\InstituteController;
use App\Http\Controllers\API\v1\Teacher\DiaryAttachmentController;
use App\Http\Controllers\API\v1\Teacher\DiaryEntryController;
use App\Http\Controllers\API\v1\Teacher\TeacherController as TeacherTeacherController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function (){
    //Public Route
    Route::post('/login',[AuthController::class,'login']);

    //Authenticated Route
    Route::middleware('auth:sanctum')->group(function (){
        Route::post('/logout',[AuthController::class,'logout']);
        Route::get('/me',[AuthController::class,'me']);
    });

    Route::middleware(['auth:sanctum','role:super_admin'])->group(function (){
        Route::apiResource('super-admin/institutes',InstituteController::class);
        Route::patch('super-admin/institutes/{institute}/status',[InstituteController::class,'updateStatus']);
        Route::get('super-admin/institutes/{institute}/configuration',[ConfigurationController::class,'show']);
        Route::put('super-admin/institutes/{institute}/configuration',[ConfigurationController::class,'update']);
        Route::get('super-admin/institutes/{institute}/admin',[InstituteAdminController::class,'show']);
        Route::post('super-admin/institutes/{institute}/admin',[InstituteAdminController::class,'store']);
        Route::put('super-admin/institutes/{institute}/admin',[InstituteAdminController::class,'update']);
        Route::patch('super-admin/institutes/{institute}/admin/status',[InstituteAdminController::class,'updateStatus']);

        // Route::get('/super-admin/test', function (Request $request) {
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Super Admin access granted.',
        //         'user' => $request->user()->name,
        //     ]);
        // });
    });

    Route::middleware(['auth:sanctum','role:admin'])->group(function (){
        Route::get('admin/configuration',[ConfigurationController::class, 'myConfiguration']);
        Route::get('admin/profile',[ConfigurationController::class, 'profile']);
        Route::post('admin/password/verify', [PasswordController::class, 'verify']);
        Route::put('admin/password', [PasswordController::class, 'update']);
        Route::get('/admin/teachers/next-code',[TeacherController::class, 'nextCode']);
        Route::apiResource('admin/teachers',TeacherController::class);
        Route::patch('admin/teachers/{teacher}/status',[TeacherController::class,'updateStatus']);
        Route::get('admin/parents/{parent}/students',[ParentController::class,'students']);
        Route::patch('admin/parents/{parent}/status',[ParentController::class,'updateStatus']);
        Route::apiResource('admin/parents',ParentController::class);
        Route::get('/admin/students/next-code', [StudentController::class, 'nextCode']);
        Route::apiResource('admin/students',StudentController::class);
        Route::patch('admin/students/{student}/status',[StudentController::class,'updateStatus']);
        Route::post('admin/students/register-with-enrollment',[StudentController::class, 'storeWithEnrollment']);
        Route::apiResource('admin/classes',ClassController::class);
        Route::get('admin/classes/{class}/sections',[ClassController::class,'sections']);
        Route::patch('admin/classes/{class}/status',[ClassController::class,'updateStatus']);
        Route::apiResource('admin/sections',SectionController::class);
        Route::patch('admin/sections/{section}/status',[SectionController::class,'updateStatus']);
        Route::apiResource('admin/subjects',SubjectController::class);
        Route::patch('admin/subjects/{subject}/status',[SubjectController::class,'updateStatus']);
        Route::post('admin/classes/{class}/subjects',[ClassSubjectController::class, 'assign']);
        Route::get('admin/classes/{class}/subjects',[ClassSubjectController::class, 'subjects']);
        Route::get('admin/subjects/{subject}/classes',[ClassSubjectController::class, 'classes']);
        Route::delete('admin/classes/{class}/subjects/{subject}',[ClassSubjectController::class, 'remove']);
        Route::apiResource('admin/academic-sessions',AcademicSessionController::class);
        Route::patch('admin/academic-sessions/{academicSession}/status',[AcademicSessionController::class,'updateStatus']);
        Route::apiResource('admin/student-enrollments',StudentEnrollmentController::class);
        Route::patch('admin/student-enrollments/{studentEnrollment}/status',[StudentEnrollmentController::class,'updateStatus']);
        Route::get('admin/students/{student}/enrollments',[StudentEnrollmentController::class, 'studentEnrollments']);
        Route::get('admin/classes/{class}/students',[StudentEnrollmentController::class, 'classStudents']);
        Route::apiResource('admin/teacher-assignments',TeacherAssignmentController::class);
        Route::patch('admin/teacher-assignments/{teacherAssignment}/status',[TeacherAssignmentController::class, 'updateStatus']);
        Route::get('admin/teachers/{teacher}/assignments',[TeacherAssignmentController::class, 'teacherAssignments']);
        Route::get('admin/classes/{class}/teacher-assignments',[TeacherAssignmentController::class, 'classAssignments']);

    });

    Route::middleware(['auth:sanctum','role:teacher'])->group(function(){
        Route::get('teacher/me',[TeacherTeacherController::class,'me']);
        Route::get('teacher/configuration',[ConfigurationController::class, 'myConfiguration']);
        Route::get('teacher/profile',[ConfigurationController::class, 'profile']);
        Route::post('teacher/password/verify', [PasswordController::class, 'verify']);
        Route::put('teacher/password', [PasswordController::class, 'update']);
        Route::post('teacher/change-password',[TeacherTeacherController::class,'changePassword']);
        Route::get('teacher/assignments',[TeacherTeacherController::class,'myAssignments']);
        Route::get('teacher/diaries/available-assignments', [DiaryEntryController::class, 'availableAssignments']);
        Route::apiResource('teacher/diaries',DiaryEntryController::class);
        Route::get('teacher/diaries/{diary}/attachments',[DiaryAttachmentController::class,'index']);
        Route::post('teacher/diaries/{diary}/attachments',[DiaryAttachmentController::class,'store']);
        Route::delete('teacher/diaries/{diary}/attachments/{attachment}',[DiaryAttachmentController::class,'destroy']);

    });

    Route::middleware(['auth:sanctum','role:parent','activeparent'])->group(function(){
        Route::get('parent/me',[ParentParentController::class,'me']);
        Route::get('parent/configuration',[ConfigurationController::class, 'myConfiguration']);
        Route::get('parent/profile',[ConfigurationController::class, 'profile']);
        Route::post('parent/password/verify', [PasswordController::class, 'verify']);
        Route::put('parent/password', [PasswordController::class, 'update']);
        Route::post('parent/change-password',[ParentParentController::class,'changePassword']);
        Route::get('parent/children',[ParentParentController::class,'children']);
        Route::get('parent/students/{student}/diaries',[DiaryController::class, 'studentDiaries']);
        Route::get('parent/diaries/{diary}',[DiaryController::class, 'show']);
        Route::get('parent/diaries/{diary}/attachments',[DiaryController::class, 'attachments']);
        Route::get('parent/diaries/{diary}/attachments/{attachment}/download',[DiaryController::class, 'downloadAttachment']);
        
    });
});
