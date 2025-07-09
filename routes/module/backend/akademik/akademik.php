<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RombelController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\ClassroomController;
use App\Http\Controllers\Backend\AcademicYearsController;
use App\Http\Controllers\Backend\AnggotaRombelController;

// PESERTA DIDIK AKTIF
Route::middleware(['permission:edit_pd'])->prefix('academic/students')->group(function () {
    Route::get('/all', [StudentController::class, 'index'])->name('students.all');
    Route::get('/data', [StudentController::class, 'getStudents'])->name('students.data');
    Route::post('/create', [StudentController::class, 'store'])->name('students.store');
    Route::delete('/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/delete-selected', [StudentController::class, 'deleteSelectedStudents'])->name('students.delete.selected');
    Route::get('/{id}/fetch', [StudentController::class, 'fetchStudentsById'])->name('students.fetch');
    Route::put('/{id}/update', [StudentController::class, 'update'])->name('students.update');

    // PESERTA DIDIK NON AKTIF / ALUMNI
    Route::get('/non-active', [StudentController::class, 'studentsNonActive'])->name('students.non.active');
    Route::get('/data/non-active', [StudentController::class, 'getStudentsNonActive'])->name('students.data.non.active');
    Route::post('/mark-as-alumni', [StudentController::class, 'markAsAlumni'])->name('students.markAsAlumni');
    Route::post('/restore-as-student', [StudentController::class, 'restoreAlumni'])->name('students.restoreAlumni');

    // IMPORT PESERTA DIDIK
    Route::post('/preview-import', [StudentController::class, 'previewImport'])->name('student.previewImport');
    Route::post('/import', [StudentController::class, 'import'])->name('student.import');
    Route::match(['get', 'post'], '/import-form', [StudentController::class, 'importForm'])->name('student.importForm');
});

// AKADEMIK - TAHUN PELAJARAN
Route::middleware(['permission:edit_tahun_pelajaran'])->prefix('academic/academic_years')->group(function () {
    Route::get('/all', [AcademicYearsController::class, 'index'])->name('academic.years.index');
    Route::get('/data', [AcademicYearsController::class, 'getAcademicYears'])->name('academic.years.data');
    Route::delete('/{id}', [AcademicYearsController::class, 'destroy'])->name('academic.years.destroy');
    Route::post('/delete-selected', [AcademicYearsController::class, 'deleteSelectedAcademicYears'])->name('academic.years.delete.selected');
    Route::post('/create', [AcademicYearsController::class, 'store'])->name('academic.years.store');
    Route::get('/{id}/fetch', [AcademicYearsController::class, 'fetchAcademicYearsById'])->name('academic.years.fetch');
    Route::put('/{id}/update', [AcademicYearsController::class, 'update'])->name('academic.years.update');
});

// AKADEMIK - KELAS
Route::middleware(['permission:edit_kelas'])->prefix('academic/classrooms')->group(function () {
    Route::get('/', [ClassroomController::class, 'index'])->name('classrooms.all');
    Route::get('/data', [ClassroomController::class, 'getClassrooms'])->name('classrooms.data');
    Route::post('/create', [ClassroomController::class, 'store'])->name('classrooms.store');
    Route::delete('/{id}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');
    Route::post('/delete-selected', [ClassroomController::class, 'deleteSelectedClassrooms'])->name('classrooms.delete.selected');
    Route::get('/{id}/fetch', [ClassroomController::class, 'fetchClassromsById'])->name('classrooms.fetch');
    Route::put('/{id}/update', [ClassroomController::class, 'update'])->name('classrooms.update');
});

// AKADEMIK - ROMBONGAN BELAJAR
Route::middleware(['permission:edit_rombel'])->prefix('academic/rombels')->group(function () {
    Route::get('/all', [RombelController::class, 'index'])->name('rombels.index');
    Route::get('/filter', [RombelController::class, 'filter'])->name('rombels.filter');
    Route::get('/create', [RombelController::class, 'daftarRombel'])->name('rombels.create');
    Route::get('/data', [RombelController::class, 'getDaftarRombel'])->name('rombels.data');
    Route::post('/create', [RombelController::class, 'store'])->name('rombongan_belajar.store');
    Route::delete('/{id}', [RombelController::class, 'destroy'])->name('rombels.destroy');
    Route::post('/delete-selected', [RombelController::class, 'deleteSelectedRombels'])->name('rombels.delete.selected');
    Route::get('/{id}/fetch', [RombelController::class, 'fetchRombelsById'])->name('rombels.fetch');
    Route::put('/{id}/update', [RombelController::class, 'update'])->name('rombels.update');

    Route::get('/members', [RombelController::class, 'anggotaRombel'])->name('rombels.members');
    Route::get('/students/data', [RombelController::class, 'getStudents'])->name('rombels.students.data');
    Route::get('/anggota/data', [RombelController::class, 'getFilteredStudents'])->name('rombels.anggota.data');
    Route::get('/rombel-id', [RombelController::class, 'getRombelId']);

    Route::post('/anggota-rombel/store', [AnggotaRombelController::class, 'store']);
    Route::post('/anggota-rombel/destroy', [AnggotaRombelController::class, 'destroy']);
    Route::post('/anggota/store', [AnggotaRombelController::class, 'store'])->name('anggota.store');
    Route::post('/anggota/delete-selected', [AnggotaRombelController::class, 'deleteSelected']);
});
