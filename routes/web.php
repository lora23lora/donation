<?php

use App\Models\Beneficiary;
use App\Models\Donation;
use App\Models\Storage;
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

Route::get('/donation-pdf', function () {

    $modelIds = request()->query('models');
    $models = Donation::whereIn('id', explode(',', $modelIds))->get();

    $pdf = PDF::loadView('pdf.donation', compact('models'));

    return $pdf->stream('document.pdf');

})->name('donation-pdf');

Route::get('/beneficiary-pdf', function () {

    $modelIds = request()->query('models');
    $models = Beneficiary::whereIn('id', explode(',', $modelIds))->get();

    $pdf = PDF::loadView('pdf.beneficiary', compact('models'));

    return $pdf->stream('document.pdf');

})->name('beneficiary-pdf');

Route::get('/items-pdf', function () {

    $modelIds = request()->query('models');
    $models = Storage::whereIn('item_id', explode(',', $modelIds))->get();

    $pdf = PDF::loadView('pdf.Items', compact('models'));

    return $pdf->stream('document.pdf');

})->name('items-pdf');
