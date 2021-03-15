<?php

namespace App\Http\Controllers\Gambler;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Goal;
use App\Models\Scoreboard;
use App\Services\ScoreService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompetitionController extends Controller
{
    public function competitions()
    {
        $competitions = Competition::where('active', 1)->orderBy('name')->get();

        return Inertia::render('Gambler/Competition/competitions', [
            'competitions' => $competitions,
        ]);
    }

    public function competition(Request $request)
    {
        $games = Game::where('competition_id', $request->competition_id)->orderBy('date', 'desc')->get();
        foreach ($games as &$game) {
            $game->competition;
            $game->stadium->country;
            $game->teamHome;
            $game->teamGuest;

            $game->addScoreboardByUserId( Auth::user()->id );
        }

        return Inertia::render('Gambler/Competition/competition', [
            'games' => $games,
        ]);
    }

    public function game(Request $request)
    {
        $game = Game::findorFail($request->id);
        $game->competition;
        $game->stadium->country;
        $game->teamHome->players;
        $game->teamHome->country;
        $game->teamGuest->players;
        $game->teamGuest->country;

        $game->addScoreboardAndGoalsByUserId( Auth::user()->id );

        return Inertia::render('Gambler/Competition/game', [
            'game' => $game,
        ]);
    }

    public function storeGame(Request $request, ScoreService $scoreService)
    {
        $scoreService->saveRequest($request, 'bet', Auth::user()->id);

        return Redirect::route('gambler.competition', [
            'competition_id' => $request->game['competition']['id']
        ]);
    }
}
