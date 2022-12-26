<?php

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend;
use App\Http\Controllers\Backend;
use App\Http\Controllers\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logout',[Auth\StudentAuthController::class,'logout'])->name('logout');
Route::get('/login',[Auth\StudentAuthController::class,'showLoginForm'])->name('login');
Route::post('/login',[Auth\StudentAuthController::class,'login'])->name('loginProcess');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login',[Auth\AdminAuthController::class,'showLoginForm'])->name('admin.login');
    Route::post('/login',[Auth\AdminAuthController::class,'login'])->name('admin.loginProcess');
    Route::get('/logout',[Auth\AdminAuthController::class,'logout'])->name('admin.logout');
    Route::group([
        'prefix' => 'exam'
    ], function () {
        Route::get('/', [Backend\ExamController::class,'index'])->name('admin.exam.index');
        Route::get('/get-data', [Backend\ExamController::class,'getData'])->name('admin.exam.get-data');
        Route::post('/store', [Backend\ExamController::class,'store'])->name('admin.exam.store');
        Route::put('/update/{id}', [Backend\ExamController::class,'update'])->name('admin.exam.update');
        Route::delete('/delete/{id}', [Backend\ExamController::class,'destroy'])->name('admin.exam.destroy');
        Route::put('/change-status/{id}',[Backend\ExamController::class,'changeStatus'])->name('admin.exam.change-status');
        Route::get('/{id}/edit',[Backend\ExamController::class,'edit'])->name('admin.exam.edit');
    });
    Route::get('/assignment', [Backend\ScheduleController::class,'assignmentIndex'])->name('admin.assignment.index');
    Route::put('/assignment/update', [Backend\ScheduleController::class,'assignmentUpdate'])->name('admin.assignment.update');
    Route::get('/schedule/class', [Backend\ScheduleController::class,'scheduleClass'])->name('admin.schedule.class');
    Route::get('/schedule/{id}', [Backend\ScheduleController::class,'scheduleByClass'])->name('admin.schedule.byClass');
    Route::get('/schedule-teacher', [Backend\ScheduleController::class,'scheduleByTeacher'])->name('scheduleTeacher');

    Route::group([
        'prefix' => 'point'
    ], function () {
        Route::get('/list-class/{id}', [Backend\PointController::class,'listClass'])->name('admin.list-class');
        Route::get('/{id}/{exId}', [Backend\PointController::class,'pointInClass'])->name('admin.point.class');
        Route::post('/store', [Backend\PointController::class,'store'])->name('admin.exam.store');
        Route::put('/update/{id}', [Backend\PointController::class,'update'])->name('admin.point.update');
        Route::delete('/delete/{id}', [Backend\PointController::class,'destroy'])->name('admin.exam.destroy');
        Route::put('/change-status/{id}',[Backend\PointController::class,'changeStatus'])->name('admin.exam.change-status');
        Route::get('/{id}/edit',[Backend\PointController::class,'edit'])->name('admin.exam.edit');
    });
    Route::middleware('auth.admin')->group(function (){
        Route::get('/',[Backend\DashboardController::class,'indexUser'])->name('admin.dashboard');

        Route::group(['prefix'=>'users'],function(){
            Route::get('/', [Backend\UserController::class,'index'])->name('admin.user.index');
            Route::get('/get-data', [Backend\UserController::class,'getData'])->name('admin.user.get-data');
            Route::post('/store', [Backend\UserController::class,'store'])->name('admin.user.store');
            Route::put('/update/{id}', [Backend\UserController::class,'update'])->name('admin.user.update');
            Route::delete('/delete/{id}', [Backend\UserController::class,'destroy'])->name('admin.user.destroy');
            Route::put('/change-status/{id}',[Backend\UserController::class,'changeStatus'])->name('admin.user.change-status');
            Route::get('/{id}/edit',[Backend\UserController::class,'edit'])->name('admin.user.edit');
        });

        Route::group(['prefix'=>'teachers'],function(){
            Route::get('/', [Backend\TeacherController::class,'index'])->name('admin.teacher.index');
            Route::get('/get-data', [Backend\TeacherController::class,'getData'])->name('admin.teacher.get-data');
            Route::post('/store', [Backend\TeacherController::class,'store'])->name('admin.teacher.store');
            Route::put('/update/{id}', [Backend\TeacherController::class,'update'])->name('admin.teacher.update');
            Route::delete('/delete/{id}', [Backend\TeacherController::class,'destroy'])->name('admin.teacher.destroy');
            Route::put('/change-status/{id}',[Backend\TeacherController::class,'changeStatus'])->name('admin.teacher.change-status');
            Route::get('/{id}/edit',[Backend\TeacherController::class,'edit'])->name('admin.teacher.edit');
        });

        Route::group([
            'prefix' => 'category',
            'as' => 'category.'
        ], function () {
            Route::get('/', [Backend\CategoryController::class, 'index'])->name('index');
            Route::get('/getData',  [Backend\CategoryController::class, 'getData'])->name('getData');
            Route::get('show/{id}',  [Backend\CategoryController::class, 'show'])->name('show');
            Route::get('create',  [Backend\CategoryController::class, 'create'])->name('create');
            Route::post('/store',  [Backend\CategoryController::class, 'store'])->name('store');
            Route::post('update/{id}',  [Backend\CategoryController::class, 'update'])->name('update');
            Route::delete('destroy/{id}',  [Backend\CategoryController::class, 'destroy'])->name('destroy');
            Route::get('{id}/edit',  [Backend\CategoryController::class, 'edit'])->name('edit');
            Route::post('/check-subject-id-unique',  [Backend\CategoryController::class, 'checkSubjectIdUnique']);
            Route::post('/check-subject-id-unique-update',  [Backend\CategoryController::class, 'checkSubjectIdUniqueUpdate']);
        });

        Route::group([
            'prefix' => 'facuty',
            'as' => 'facuty.'
        ], function () {
            Route::get('/', [Backend\FacutyController::class, 'index'])->name('index');
            Route::get('/getData',  [Backend\FacutyController::class, 'getData'])->name('getData');
            Route::get('show/{id}',  [Backend\FacutyController::class, 'show'])->name('show');
            Route::get('create',  [Backend\FacutyController::class, 'create'])->name('create');
            Route::post('/store',  [Backend\FacutyController::class, 'store'])->name('store');
            Route::put('update/{id}',  [Backend\FacutyController::class, 'update'])->name('update');
            Route::delete('destroy/{id}',  [Backend\FacutyController::class, 'destroy'])->name('destroy');
            Route::get('{id}/edit',  [Backend\FacutyController::class, 'edit'])->name('edit');
            Route::post('/check-subject-id-unique',  [Backend\FacutyController::class, 'checkSubjectIdUnique']);
            Route::post('/check-subject-id-unique-update',  [Backend\FacutyController::class, 'checkSubjectIdUniqueUpdate']);
        });

        Route::group([
            'prefix' => 'company',
            'as' => 'company.'
        ], function () {
            Route::get('/', [Backend\CompanyController::class, 'index'])->name('index');
            Route::get('/getData',  [Backend\CompanyController::class, 'getData'])->name('getData');
            Route::get('show/{id}',  [Backend\CompanyController::class, 'show'])->name('show');
            Route::get('create',  [Backend\CompanyController::class, 'create'])->name('create');
            Route::post('/store',  [Backend\CompanyController::class, 'store'])->name('store');
            Route::post('update/{id}',  [Backend\CompanyController::class, 'update'])->name('update');
            Route::delete('destroy/{id}',  [Backend\CompanyController::class, 'destroy'])->name('destroy');
            Route::get('{id}/edit',  [Backend\CompanyController::class, 'edit'])->name('edit');
            Route::post('/check-subject-id-unique',  [Backend\CompanyController::class, 'checkSubjectIdUnique']);
            Route::post('/check-subject-id-unique-update',  [Backend\CompanyController::class, 'checkSubjectIdUniqueUpdate']);
        });
        Route::group([
            'prefix' => 'team'
        ], function () {
            Route::get('/', [Backend\TeamController::class,'index'])->name('admin.team.index');
            Route::get('/get-data', [Backend\TeamController::class,'getData'])->name('admin.team.get-data');
            Route::post('/store', [Backend\TeamController::class,'store'])->name('admin.team.store');
            Route::put('/update/{id}', [Backend\TeamController::class,'update'])->name('admin.team.update');
            Route::delete('/delete/{id}', [Backend\TeamController::class,'destroy'])->name('admin.team.destroy');
            Route::put('/change-status/{id}',[Backend\TeamController::class,'changeStatus'])->name('admin.team.change-status');
            Route::get('/{id}/edit',[Backend\TeamController::class,'edit'])->name('admin.team.edit');
        });

        Route::group([
            'prefix' => 'division',
            'as' => 'division.'
        ], function () {
            Route::get('/', [Backend\DivisionController::class, 'index'])->name('index');
            });

        Route::group([
            'prefix' => 'post',
            'as' => 'post.'
        ], function () {
            Route::get('/', [Backend\PostController::class, 'index'])->name('index');
            Route::get('/get-data',  [Backend\PostController::class, 'getData'])->name('getData');
            Route::get('show/{id}',  [Backend\PostController::class, 'show'])->name('show');
            Route::get('create',  [Backend\PostController::class, 'create'])->name('create');
            Route::post('/store',  [Backend\PostController::class, 'store'])->name('store');
            Route::put('update/{id}',  [Backend\PostController::class, 'update'])->name('update');
            Route::delete('delete/{id}',  [Backend\PostController::class, 'destroy'])->name('destroy');
            Route::get('{id}/edit',  [Backend\PostController::class, 'edit'])->name('edit');
            Route::post('/check-subject-id-unique',  [Backend\PostController::class, 'checkSubjectIdUnique']);
            Route::post('/check-subject-id-unique-update',  [Backend\PostController::class, 'checkSubjectIdUniqueUpdate']);
            Route::post('/get-address/{id}',  [Backend\PostController::class, 'getAddress']);
            Route::put('/change-status/{id}',[Backend\PostController::class,'changeStatus'])->name('admin.user.change-status');
        });
    });

});

Route::group(['prefix' => 'teachers'], function () {
    Route::get('/login',[Auth\TeacherAuthController::class,'showLoginForm'])->name('teachers.login');
    Route::post('/login',[Auth\TeacherAuthController::class,'login'])->name('teachers.loginProcess');
    Route::get('/logout',[Auth\TeacherAuthController::class,'logout'])->name('teachers.logout');
    Route::get('/register',[Auth\TeacherAuthController::class,'showRegistrationForm'])->name('teachers.register');
    Route::post('/register',[Auth\TeacherAuthController::class,'register'])->name('teachers.registerProcess');

    Route::post('/companies/store',[Backend\CompanyController::class,'store'])->name('teachers.company.store');

    Route::middleware('auth.teacher')->group(function (){
        Route::get('/',[Backend\DashboardController::class,'indexTeacher'])->name('teachers.dashboard');

        Route::group([
            'prefix' => 'post',
            'as' => 'teacher.post.'
        ], function () {
            Route::get('/', [Backend\PostController::class, 'indexTeacher'])->name('index');
            Route::get('/get-data',  [Backend\PostController::class, 'getDataTeacher'])->name('getData');
            Route::get('show/{id}',  [Backend\PostController::class, 'show'])->name('show');
            Route::get('create',  [Backend\PostController::class, 'create'])->name('create');
            Route::post('/store',  [Backend\PostController::class, 'store'])->name('store');
            Route::put('update/{id}',  [Backend\PostController::class, 'update'])->name('update');
            Route::delete('delete/{id}',  [Backend\PostController::class, 'destroy'])->name('destroy');
            Route::get('{id}/edit',  [Backend\PostController::class, 'edit'])->name('edit');
            Route::post('/check-subject-id-unique',  [Backend\PostController::class, 'checkSubjectIdUnique']);
            Route::post('/check-subject-id-unique-update',  [Backend\PostController::class, 'checkSubjectIdUniqueUpdate']);
            Route::post('/get-address/{id}',  [Backend\PostController::class, 'getAddress']);
            Route::put('/change-status/{id}',[Backend\PostController::class,'changeStatus'])->name('admin.user.change-status');
        });
    });
});


//Route::get('/',[Frontend\HomeController::class, 'index'])->name('home');
Route::get('/',function (){
    return redirect('/admin');
})->name('home');

// Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['prefix'=>'students'],function(){
    Route::get('/', [Backend\StudentController::class,'index'])->name('student.index');
    Route::get('/get-data', [Backend\StudentController::class,'getData'])->name('student.get-data');
    Route::post('/store', [Backend\StudentController::class,'store'])->name('student.store');
    Route::put('/update/{id}', [Backend\StudentController::class,'update'])->name('student.update');
    Route::delete('/delete/{id}', [Backend\StudentController::class,'destroy'])->name('student.destroy');
    Route::put('/change-status/{id}',[Backend\StudentController::class,'changeStatus'])->name('student.change-status');
    Route::get('/{id}/edit',[Backend\StudentController::class,'edit'])->name('student.edit');
});
