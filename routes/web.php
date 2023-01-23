<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OffenseCategoryController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('index');
// });

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('/students', StudentController::class);
    Route::post('/students/template', [StudentController::class, 'downloadTemplateExcel'])
        ->name('students.template');
    Route::post('/students/import', [StudentController::class, 'importTemplateExcel'])
        ->name('students.import');

    Route::resource('/teachers', TeacherController::class);
    Route::post('/teachers/template', [TeacherController::class, 'downloadTemplateExcel'])
        ->name('teachers.template');
    Route::post('/teachers/import', [TeacherController::class, 'importTemplateExcel'])
        ->name('teachers.import');

    Route::resource('/classes', ClassController::class);
    Route::post('/classes/template', [ClassController::class, 'downloadTemplateExcel'])
        ->name('classes.template');
    Route::post('/classes/import', [ClassController::class, 'importTemplateExcel'])
        ->name('classes.import');
    Route::post('/classes/pindah-kelas', [ClassController::class, 'pindahKelasSiswa'])
        ->name('classes.pindah-kelas');


    Route::resource('/parents', ParentController::class);
    Route::post('/parents/template', [ParentController::class, 'downloadTemplateExcel'])
        ->name('parents.template');
    Route::post('/parents/import', [ParentController::class, 'importTemplateExcel'])
        ->name('parents.import');

    Route::resource('/offense-categories', OffenseCategoryController::class);

    Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::middleware('guest')->group(function () {
    // auth
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});
