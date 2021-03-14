<?php

namespace App\Http\Controllers\Gambler;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $game = Game::findorFail($request->id);
        $game->competition;
        $game->stadium->country;
        $game->teamHome->players;
        $game->teamHome->country;
        $game->teamGuest->players;
        $game->teamGuest->country;

        return Inertia::render('Gambler/Competition/game', [
            'game' => $game,
        ]);
    }
}
