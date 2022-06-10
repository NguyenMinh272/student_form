<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SubjectController;

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
Route::resource('faculties', FacultyController::class);
Route::resource('subjects', SubjectController::class);
Route::resource('students', StudentController::class);

Route::get('students/{id}/edit?',[StudentController::class, 'edit']);

Route::get('/students/subjects/{id}',
    [StudentController::class, 'createSubjects'])->name('students.subjects.createSubjects');
Route::post('/students/subjects/{id}',
    [StudentController::class, 'storeSubject'])->name('students.subjects.storeSubject');

Route::get('/students/subjects/mark/{id}',
    [StudentController::class, 'createMark'])->name('students.subjects.marks.createMark');
Route::post('/students/subjects/mark',
    [StudentController::class, 'storeMark'])->name('students.subjects.marks.storeMark');

Route::post('student/update/{id}', [StudentController::class, 'updateApi'])->name('student_update_api');
