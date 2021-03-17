<?php

use App\Http\Controllers\Adm\TeamController;
use App\Http\Controllers\Adm\CountryController;
use App\Http\Controllers\Adm\GameController;
use App\Http\Controllers\Adm\OfficialController;
use App\Http\Controllers\Adm\CompetitionController;
use App\Http\Controllers\Adm\PlayerController;
use App\Http\Controllers\Adm\StadiumController;

use App\Http\Controllers\Gambler\CompetitionController as GamblerCompetitionController;
use App\Http\Controllers\Gambler\Dashboard as GamblerDashboard;
use App\Http\Controllers\Gambler\GeneralController;
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
        Route::get('/official/competitions', [OfficialController::class, 'competitions'])->name('official.competitions');
        Route::get('/official/competition', [OfficialController::class, 'competition'])->name('official.competition');
        Route::get('/official/game', [OfficialController::class, 'game'])->name('official.game');

        Route::post('/official/calculate-score', [OfficialController::class, 'calculateScore'])->name('official.calculate-score');

        /** UPDATES WITH IMAGE */
        Route::post('/competition/updateWithImage', [CompetitionController::class, 'updateWithImage'])->name('competition.update-with-image');
        Route::post('/team/updateWithImage', [TeamController::class, 'updateWithImage'])->name('team.update-with-image');

        /** RESOURCES */
        Route::resource('country', CountryController::class);
        Route::resource('competition', CompetitionController::class);
        Route::resource('player', PlayerController::class);
        Route::resource('stadium', StadiumController::class);
        Route::resource('game', GameController::class);
        Route::resource('team', TeamController::class);
    });

    Route::prefix('gambler')->name('gambler.')->group(function () {

        Route::get('/dashboard', [GamblerDashboard::class, 'index'])->name('dashboard');

        Route::get('/competitions', [GamblerCompetitionController::class, 'competitions'])->name('competitions');
        Route::get('/competition', [GamblerCompetitionController::class, 'competition'])->name('competition');
        Route::get('/game', [GamblerCompetitionController::class, 'game'])->name('game');
        Route::post('/storeGame', [GamblerCompetitionController::class, 'storeGame'])->name('store-game');

        Route::get('/score-report', [GeneralController::class, 'scoreReport'])->name('score-report');
        Route::get('/score-rules', [GeneralController::class, 'scoreRules'])->name('score-rules');
    });
});


