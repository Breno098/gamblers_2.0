<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Redirect;

class OfficialController extends Controller
{
    public function competitions()
    {
        $competitions = Competition::where('active', 1)->orderBy('name')->get();

        return Inertia::render('Gambler/Official/competitions', [
            'competitions' => $competitions,
        ]);
    }

    public function competition(Request $request)
    {
        $games = Game::where('type', 'official')->where('competition_id', $request->competition_id)->orderBy('date', 'desc')->get();
        foreach ($games as &$game) {
            $game->competition;
            $game->stadium->country;
            $game->teamHome;
            $game->teamGuest;
        }

        return Inertia::render('Adm/Official/competition', [
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

        return Inertia::render('Adm/Official/game', [
            'game' => $game,
        ]);
    }

    public function calculateScore(Request $request)
    {
        dd($request);
    }
}
