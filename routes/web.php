<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ClassSubjectController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\NoticeController;

use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Parent\ResultController as ParentResultController;
use App\Http\Controllers\Parent\FeeChallanController as ParentFeeChallanController;
use App\Http\Controllers\Parent\PaymentController as ParentPaymentController;
use App\Http\Controllers\Parent\ProfileController as ParentProfileController;
use App\Http\Controllers\Parent\AttendanceController as ParentAttendanceController;

use App\Http\Controllers\ExamController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\Admin\NurseryActivityAssessmentController;
use App\Http\Controllers\Admin\NurseryResultController;
use App\Http\Controllers\Admin\AcademicSessionController;
use App\Http\Controllers\Admin\FeeTypeController;
use App\Http\Controllers\Admin\FeeStructureController;
use App\Http\Controllers\Admin\StudentFeeAssignmentController;
use App\Http\Controllers\Admin\FeeChallanController;
use App\Http\Controllers\Admin\FeePaymentController;
use App\Http\Controllers\Admin\FeeReportController;
use App\Http\Controllers\Teacher\ExamController as TeacherExamController;
use App\Http\Controllers\Teacher\MarkController as TeacherMarkController;
use App\Http\Controllers\Teacher\ResultController as TeacherResultController;
use App\Http\Controllers\Teacher\SubjectController as TeacherSubjectController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;

/*
| Public Website
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');


/*
| Main Dashboard
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
| Authenticated User Profile
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
 Admin Routes
*/

Route::middleware(['auth', 'admin'])->group(function () {

    /*
     Class Rooms
    */

    Route::resource('class-rooms', ClassRoomController::class);


    /*
    Teachers
    */

    Route::resource('teachers', TeacherController::class);


    /*
     Students
    */

    Route::get('/students/{student}/id-card', [StudentController::class, 'idCard'])
        ->name('students.idcard');

    Route::resource('students', StudentController::class);



/*
Shift Management
*/

Route::resource('shifts', ShiftController::class);


//status toggle route
Route::patch(
    '/shifts/{shift}/toggle-status',
    [ShiftController::class, 'toggleStatus']
)->name('shifts.toggle-status');

/*
Academic Session Management
*/

Route::resource(
    'academic-sessions',
    AcademicSessionController::class
)->except(['show', 'destroy']);

Route::patch(
    '/academic-sessions/{academicSession}/toggle-status',
    [AcademicSessionController::class, 'toggleStatus']
)->name('academic-sessions.toggle-status');

    /*
     Subjects
    */

    Route::resource('subjects', SubjectController::class);


    /*
 Class Subject Assignments
    */

    Route::resource('class-subjects', ClassSubjectController::class);


    /*
    Exams
    */

    Route::resource('exams', ExamController::class);




    /*
    Marks Management
    */

    Route::get(
        '/marks/class/{classRoomId}/subjects',
        [MarkController::class, 'getSubjects']
    )->name('marks.get-subjects');

    Route::get(
        '/marks/students/load',
        [MarkController::class, 'getStudents']
    )->name('marks.get-students');

    Route::resource('marks', MarkController::class);



     //results management

    Route::get('/results', [ResultController::class, 'index'])
    ->name('results.index');

Route::get(
    '/results/{exam}/{student}',
    [ResultController::class, 'show']
)->name('results.show');


//nursery assessments management
Route::get(
    '/nursery-assessments',
    [NurseryActivityAssessmentController::class, 'index']
)->name('nursery-assessments.index');

Route::get(
    '/nursery-assessments/create',
    [NurseryActivityAssessmentController::class, 'create']
)->name('nursery-assessments.create');

Route::post(
    '/nursery-assessments',
    [NurseryActivityAssessmentController::class, 'store']
)->name('nursery-assessments.store');

Route::delete(
    '/nursery-assessments/student/{student}',
    [NurseryActivityAssessmentController::class, 'destroy']
)->name('nursery-assessments.destroy');


//nursery results management
Route::get(
    '/nursery-results/{student}/{exam}',
    [NurseryResultController::class,'show']
)->name('nursery-results.show');



//
Route::post(
    '/nursery-assessments/{student}/{exam}/publish',
    [NurseryActivityAssessmentController::class,'publish']
)->name('nursery-assessments.publish');

Route::post(
    '/nursery-assessments/{student}/{exam}/unpublish',
    [NurseryActivityAssessmentController::class,'unpublish']
)->name('nursery-assessments.unpublish');

/*
Fee Type Management
*/

Route::resource(
    'fee-types',
    FeeTypeController::class
)->except(['show', 'destroy']);

/*
 Fee Structure Management
*/

Route::resource(
    'fee-structures',
    FeeStructureController::class
)->except(['show', 'destroy']);


/*
 Student Fee Assignment Management
*/

Route::resource(
    'student-fee-assignments',
    StudentFeeAssignmentController::class
)->except(['show', 'destroy']);


/*
| Fee Challan Management
*/

Route::get(
    '/fee-challans',
    [FeeChallanController::class, 'index']
)->name('fee-challans.index');

Route::get(
    '/fee-challans/create',
    [FeeChallanController::class, 'create']
)->name('fee-challans.create');

Route::post(
    '/fee-challans',
    [FeeChallanController::class, 'store']
)->name('fee-challans.store');

Route::get(
    '/fee-challans/{feeChallan}',
    [FeeChallanController::class, 'show']
)->name('fee-challans.show');




/*
| Fee Payment Management
*/

Route::get(
    '/fee-challans/{feeChallan}/payment',
    [FeePaymentController::class, 'create']
)->name('fee-payments.create');

Route::post(
    '/fee-challans/{feeChallan}/payment',
    [FeePaymentController::class, 'store']
)->name('fee-payments.store');

Route::get(
    '/fee-payments/{feePayment}',
    [FeePaymentController::class, 'show']
)->name('fee-payments.show');

/*
| Fee Reports
*/

Route::get(
    '/fee-reports',
    [FeeReportController::class, 'index']
)->name('fee-reports.index');

Route::get(
    '/fee-reports/student/{student}',
    [FeeReportController::class, 'studentHistory']
)->name('fee-reports.student');


/* notice management */
Route::resource('notices', NoticeController::class);

    /*
    Admin Attendance Management
    */

    Route::get('/attendance', [AdminAttendanceController::class, 'index'])
        ->name('admin.attendance.index');

    Route::put('/attendance/{attendance}', [AdminAttendanceController::class, 'update'])
        ->name('admin.attendance.update');

});

/*
| Parent Routes
*/

Route::middleware(['auth'])
    ->prefix('parent')
    ->name('parent.')
    ->group(function () {

        Route::get(
            '/results',
            [ParentResultController::class, 'index']
        )->name('results.index');

        Route::get(
            '/results/{exam}',
            [ParentResultController::class, 'show']
        )->name('results.show');

Route::get(
    '/fee-challans',
    [ParentFeeChallanController::class, 'index']
)->name('fee-challans.index');

Route::get(
    '/fee-challans/{feeChallan}',
    [ParentFeeChallanController::class, 'show']
)->name('fee-challans.show');

Route::get(
    '/payments',
    [ParentPaymentController::class, 'index']
)->name('payments.index');

Route::get(
    '/payments/{payment}',
    [ParentPaymentController::class, 'show']
)->name('payments.show');

Route::get(
    '/profile',
    [ParentProfileController::class, 'edit']
)->name('profile.edit');

Route::put(
    '/profile',
    [ParentProfileController::class, 'update']
)->name('profile.update');

Route::get(
    '/attendance',
    [ParentAttendanceController::class, 'index']
)->name('attendance.index');

    });

/*
| Teacher Routes
*/

Route::middleware(['auth'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        Route::get(
            '/attendance',
            [TeacherAttendanceController::class, 'index']
        )->name('attendance');

        Route::post(
            '/attendance',
            [TeacherAttendanceController::class, 'store']
        )->name('attendance.store');

        Route::get(
            '/attendance-history',
            [TeacherAttendanceController::class, 'history']
        )->name('attendance.history');


        Route::resource(
            'exams',
            TeacherExamController::class
        )->except(['show', 'destroy']);


        Route::get(
            '/marks',
            [TeacherMarkController::class, 'index']
        )->name('marks.index');

        Route::post(
            '/marks',
            [TeacherMarkController::class, 'store']
        )->name('marks.store');

        Route::get(
    '/results',
    [TeacherResultController::class, 'index']
)->name('results.index');

Route::get(
    '/results/{exam}/{student}',
    [TeacherResultController::class, 'show']
)->name('results.show');
Route::resource(
    'subjects',
    TeacherSubjectController::class
)->except(['show', 'destroy']);

Route::get(
    '/profile',
    [TeacherProfileController::class, 'edit']
)->name('profile.edit');

Route::put(
    '/profile',
    [TeacherProfileController::class, 'update']
)->name('profile.update');

    });

require __DIR__ . '/auth.php';