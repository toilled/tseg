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
    return view('pages.meters');
});

Route::get('/meters/add', function () {
    return view('pages.add-meter');
});

Route::put('/meters/new', [MeterController::class, 'new']);

Route::get('/meters/{mpxn}', function (string $mpxn) {
    return view('pages.meter', ['mpxn' => $mpxn]);
});

Route::get('/readings/{mpxn}', function (string $mpxn) {
    return view('pages.add-reading', ['mpxn' => $mpxn]);
});

Route::put('/readings/{mpxn}/new', [ReadingController::class, 'new']);
