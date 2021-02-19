<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StadiumController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Auth/Login');
});

Route::prefix('adm')->name('adm.')->group(function () {
    Route::resource('team', TeamController::class);

    Route::resource('country', CountryController::class);

    Route::resource('league', LeagueController::class);

    Route::resource('player', PlayerController::class);

    Route::resource('stadium', StadiumController::class);
});

// Route::middleware(['auth:sanctum', 'verified'])->group(function() {

//     Route::prefix('adm')->name('adm.')->group(function () {
//         Route::resource('team', TeamController::class);

//         Route::resource('country', CountryController::class);

//         Route::resource('league', LeagueController::class);
//     });

// });


