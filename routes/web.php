<?php

use App\Models\Donation;
use Illuminate\Support\Facades\Route;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

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
    return redirect('/nova');
});

Route::get('/purchase-pdf', function () {

    $modelIds = request()->query('models');
    $models = Donation::whereIn('id', explode(',', $modelIds))->get();

    $pdf = PDF::loadView('pdf.donation', compact('models'));

    return $pdf->stream('document.pdf');

})->name('purchase-pdf');
