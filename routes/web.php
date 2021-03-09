<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\OficialGameController;
use App\Http\Controllers\CompetitionController;
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



Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', function(){
        return Inertia::render('Adm/Dashboard');
    })->name('dashboard');

    Route::prefix('adm')->name('adm.')->group(function () {
        Route::get('/oficial-game/list-by-competition', [OficialGameController::class, 'listByCompetition'])->name('oficial-game.list-by-competition');

        Route::post('/competition/updateWithImage', [CompetitionController::class, 'updateWithImage'])->name('competition.update-with-image');
        Route::post('/team/updateWithImage', [TeamController::class, 'updateWithImage'])->name('team.update-with-image');

        /** RESOURCES */
        Route::resource('country', CountryController::class);
        Route::resource('competition', CompetitionController::class);
        Route::resource('player', PlayerController::class);
        Route::resource('stadium', StadiumController::class);
        Route::resource('game', GameController::class);
        Route::resource('oficial-game', OficialGameController::class);
        Route::resource('team', TeamController::class);
    });
});


