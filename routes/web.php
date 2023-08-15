<?php

use App\Http\Controllers\ReadingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.index');
});

Route::get('/meters', function () {
    return view('pages.meters');
});

Route::get('/meters/add', function () {
    return view('pages.add-meter');
});

Route::put('/meters/new', [MeterController::class, 'new']);

Route::get('/meters/{mpxn}/view', function (string $mpxn) {
    return view('pages.meter', ['mpxn' => $mpxn]);
});

Route::get('/meters/{mpxn}/eac', function (string $mpxn) {
    return view('pages.add-eac', ['mpxn' => $mpxn]);
});

Route::get('/meters/{mpxn}/eac/edit', function (string $mpxn) {
    return view('pages.edit-eac', ['mpxn' => $mpxn]);
});

Route::put('/meters/{mpxn}/eac', [MeterController::class, 'eac']);

Route::get('/meters/{mpxn}/readings/add', function (string $mpxn) {
    return view('pages.add-reading', ['mpxn' => $mpxn]);
});

Route::get('/meters/{mpxn}/readings/estimate', [ReadingController::class, 'createEstimate']);

Route::put('/meters/{mpxn}/readings/estimate', [ReadingController::class, 'calculateEstimate']);

Route::put('/meters/{mpxn}/readings/new', [ReadingController::class, 'new']);
