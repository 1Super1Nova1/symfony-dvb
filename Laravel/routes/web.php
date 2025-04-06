<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlerPatients;
use App\Http\Controllers\ControlerDiagnoses;
use App\Http\Controllers\ControlerDoctors;
use App\Http\Controllers\ControlerSchedule;
use App\Http\Controllers\ControlerTreatment;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;


Route::get('/', function () {
    return view('welcome');
});


// patients  ==============================================================
Route::get('/api/v1/patients', [
    ControlerPatients::class,
    'getPatients'
]);

Route::get('/api/v1/patients/{id}', [
    ControlerPatients::class,
    'getPatientsItem'
]);

Route::post('/api/v1/patients', [
    ControlerPatients::class,
    'createPatients'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::delete('/api/v1/patients/{id}', [
    ControlerPatients::class,
    'deletPatients'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::patch('/api/v1/patients/{id}', [
    ControlerPatients::class,
    'updatePatients'
])->withoutMiddleware([VerifyCsrfToken::class]);


// doctors  ==============================================================
Route::get('/api/v1/doctors', [
    ControlerDoctors::class,
    'getDoctors'
]);

Route::get('/api/v1/doctors/{id}', [
    ControlerDoctors::class,
    'getDoctorsItem'
]);

Route::post('/api/v1/doctors', [
    ControlerDoctors::class,
    'createDoctors'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::delete('/api/v1/doctors/{id}', [
    ControlerDoctors::class,
    'deletDoctors'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::patch('/api/v1/doctors/{id}', [
    ControlerDoctors::class,
    'updateDoctors'
])->withoutMiddleware([VerifyCsrfToken::class]);


// diagnoses  ==============================================================
Route::get('/api/v1/diagnoses', [
    ControlerDiagnoses::class,
    'getDiagnoses'
]);

Route::get('/api/v1/diagnoses/{id}', [
    ControlerDiagnoses::class,
    'getDiagnosesItem'
]);

Route::post('/api/v1/diagnoses', [
    ControlerDiagnoses::class,
    'creatDiagnoses'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::delete('/api/v1/diagnoses/{id}', [
    ControlerDiagnoses::class,
    'deletDiagnoses'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::patch('/api/v1/diagnoses/{id}', [
    ControlerDiagnoses::class,
    'updateDiagnoses'
])->withoutMiddleware([VerifyCsrfToken::class]);


// schedule  ==============================================================
Route::get('/api/v1/schedule', [
    ControlerSchedule::class,
    'getSchedule'
]);

Route::get('/api/v1/schedule/{id}', [
    ControlerSchedule::class,
    'getScheduleItem'
]);

Route::post('/api/v1/schedule', [
    ControlerSchedule::class,
    'createSchedule'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::delete('/api/v1/schedule/{id}', [
    ControlerSchedule::class,
    'deletSchedule'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::patch('/api/v1/schedule/{id}', [
    ControlerSchedule::class,
    'updateSchedule'
])->withoutMiddleware([VerifyCsrfToken::class]);


// treatment  ==============================================================
Route::get('/api/v1/treatment', [
    ControlerTreatment::class,
    'getTreatment'
]);

Route::get('/api/v1/treatment/{id}', [
    ControlerTreatment::class,
    'getTreatmentItem'
]);

Route::post('/api/v1/treatment', [
    ControlerTreatment::class,
    'createTreatment'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::delete('/api/v1/treatment/{id}', [
    ControlerTreatment::class,
    'deletTreatment'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::patch('/api/v1/treatment/{id}', [
    ControlerTreatment::class,
    'updateTreatment'
])->withoutMiddleware([VerifyCsrfToken::class]);