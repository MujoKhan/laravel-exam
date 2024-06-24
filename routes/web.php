<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Admin\AdminContoller;
use App\Http\Controllers\Super\SuperController;


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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
Route::get('/{slug}', function(){
            return view('error');
        });

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// student
Route::prefix('student')->name('student.')->group(function(){
    Route::middleware('guest:student','PreventBackHistory')->group(function(){
        Route::view('/login','student.login')->name('login');
        Route::get('/register',[StudentController::class, 'index'])->name('register');
        Route::post('/create',[StudentController::class, 'create'])->name('create');
        Route::post('/check',[StudentController::class, 'check'])->name('check');
    });

    Route::middleware('auth:student','PreventBackHistory')->group(function(){
        Route::view('/home','student.home')->name('home');
        Route::get('/logout',[StudentController::class, 'logout'])->name('logout');
        Route::get('/task/{v}',[StudentController::class, 'show'])->name('task');
        Route::get('/pre-exam/{id}',[StudentController::class, 'preExam'])->name('pre-exam');
        Route::get('/exam-start/{id}',[StudentController::class, 'examStart'])->name('exam-start');
        Route::post('/que',[StudentController::class, 'que'])->name('que');
        Route::post('/exam-submit',[StudentController::class, 'examSubmit'])->name('exam-submit');
        Route::post('/update',[StudentController::class, 'profile'])->name('update');
        Route::get('/fetch',[StudentController::class, 'fetch'])->name('fetch');
        
        
    });
});

// teacher
Route::prefix('teacher')->name('teacher.')->group(function(){
    Route::middleware('guest:teacher','PreventBackHistory')->group(function(){
        Route::view('/login','teacher.login')->name('login');
        Route::post('/check',[TeacherController::class, 'check'])->name('check');
        
    });

    Route::middleware('auth:teacher','PreventBackHistory')->group(function(){
        
        Route::get('/logout',[TeacherController::class, 'logout'])->name('logout');
        Route::get('/task/{v}',[TeacherController::class, 'index'])->name('task');
        Route::get('/exam/{v}',[TeacherController::class, 'exam'])->name('exam');
        Route::post('/add-sub',[TeacherController::class, 'addsub'])->name('add-sub');
        Route::post('/update-sub',[TeacherController::class, 'updatesub'])->name('update-sub');
        Route::get('/trash/{id}/{v}',[TeacherController::class, 'trash'])->name('trash');
        Route::post('/exam-add',[TeacherController::class, 'examAdd'])->name('exam-add');
        Route::get('/exam-add/{id}',[TeacherController::class, 'manageExam'])->name('manage-exam');
        Route::post('/update-exam/{id}/{v}',[TeacherController::class, 'updateExam'])->name('update-exam');
        Route::post('/add-ques',[TeacherController::class, 'addQues'])->name('add-ques');
        Route::post('/update-ques',[TeacherController::class, 'updateQues'])->name('update-ques');
        Route::get('/delete-ques/{id}/{v}',[TeacherController::class, 'deleteQues'])->name('delete-ques');
        Route::get('/trash-exam/{id}',[TeacherController::class, 'examTrash'])->name('trash-exam');
        Route::get('/exam-backup/{id}/{v}',[TeacherController::class, 'examBackup'])->name('exam-backup');
        Route::get('/exam-schedule/{id}/{v}',[TeacherController::class, 'examSchedule'])->name('exam-schedule');
        Route::get('/examinee/{v}',[TeacherController::class, 'examinee'])->name('examinee');
        Route::get('/class-data/{id}',[TeacherController::class, 'classData'])->name('class-data');
        Route::post('/add-examinee',[TeacherController::class, 'addExaminee'])->name('add-examinee');
        Route::get('/examinee-permission/{id}/{v}',[TeacherController::class, 'examineePermission'])->name('examinee-permission');
        Route::get('/examinee-trash/{id}',[TeacherController::class, 'examineeTrash'])->name('examinee-trash');
        Route::get('/examinee-backup/{id}/{v}',[TeacherController::class, 'examineeBackUp'])->name('examinee-backup');
        Route::post('/examinee-update',[TeacherController::class, 'examineeUpdate'])->name('examinee-update');
        Route::post('/update',[TeacherController::class, 'profile'])->name('update');
        Route::get('/exam-done/{id}/{v}',[TeacherController::class, 'examDone'])->name('exam-done');
        Route::get('/fetch',[TeacherController::class, 'fetchData']);
       
        Route::view('/home','teacher.home')->name('home');
    });
});

// admin
Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware('guest:admin','PreventBackHistory')->group(function(){
        Route::view('/login','admin.login')->name('login');
        Route::post('/check',[AdminContoller::class, 'check'])->name('check');
    });

    Route::middleware('auth:admin','PreventBackHistory')->group(function(){
        Route::view('/home','admin.home')->name('home');
        Route::get('/logout',[AdminContoller::class, 'logout'])->name('logout');       
        Route::post('/update',[AdminContoller::class, 'profile'])->name('update');       
        Route::get('/fetch',[AdminContoller::class, 'fetch'])->name('fetch');       
        Route::get('/task/{v}',[AdminContoller::class, 'index'])->name('task');       
        Route::post('/add-teacher',[AdminContoller::class, 'addTeacher'])->name('add-teacher');       
        Route::post('/update-teacher',[AdminContoller::class, 'updateTeacher'])->name('update-teacher');       
        Route::get('/allow/{id}/{v}',[AdminContoller::class, 'allow'])->name('allow');       
        Route::get('/trash/{id}/{v}',[AdminContoller::class, 'trash'])->name('trash');       
        Route::get('/class/{v}',[AdminContoller::class, 'classManage'])->name('class');       
        Route::post('/add-class',[AdminContoller::class, 'classAdd'])->name('add-class');       
        Route::post('/update-class',[AdminContoller::class, 'classUpdate'])->name('update-class');       
        Route::get('/assign',[AdminContoller::class, 'assign'])->name('assign');       
        Route::post('/assign-class',[AdminContoller::class, 'classAssign'])->name('assign-class');       
    });
});

// super
Route::prefix('super')->name('super.')->group(function(){
    Route::middleware('guest:super','PreventBackHistory')->group(function(){
        Route::view('/login','super.login')->name('login');
        Route::post('/check',[SuperController::class, 'check'])->name('check');
    });

    Route::middleware('auth:super','PreventBackHistory')->group(function(){
        Route::view('/home','super.home')->name('home');
        Route::get('/logout',[SuperController::class, 'logout'])->name('logout');       
        Route::post('/update',[SuperController::class, 'profile'])->name('update');       
        Route::get('/fetch',[SuperController::class, 'fetch'])->name('fetch');       
        Route::get('/task/{v}',[SuperController::class, 'index'])->name('task');       
        Route::post('/update-admin',[SuperController::class, 'update'])->name('update-admin');       
        Route::post('/add-admin',[SuperController::class, 'addAdmin'])->name('add-admin');       
        Route::get('/trash/{id}/{v}',[SuperController::class, 'trash'])->name('trash');       
        Route::get('/restore/{id}/{v}',[SuperController::class, 'restore'])->name('restore');       
        Route::get('/allow/{id}/{v}',[SuperController::class, 'permission'])->name('allow');       
    });
});