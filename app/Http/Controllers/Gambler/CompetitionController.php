<?php

namespace App\Http\Controllers\Gambler;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Goal;
use App\Models\Scoreboard;
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

        return Inertia::render('Gambler/Competition/game', [
            'game' => $game,
        ]);
    }

    public function storeGame(Request $request)
    {
        // dd($request);

        $scoreboard = Scoreboard::where('game_id', $request->game['id'])
                                ->where('user_id', Auth::user()->id)
                                ->where('type', 'bet')
                                ->first();

        if($scoreboard){
            $scoreboard->update([
                'team_home_scoreboard' => count($request->goalsHome) ?? '0',
                'team_guest_scoreboard' => count($request->goalsGuest) ?? '0',
            ]);
        } else {
            $scoreboard = Scoreboard::create([
                'game_id'   => $request->game['id'],
                'user_id'   => Auth::user()->id,
                'team_home_scoreboard' => count($request->goalsHome) ?? '0',
                'team_guest_scoreboard' => count($request->goalsGuest) ?? '0',
                'type'      => 'bet'
            ]);
        }

        Goal::where('scoreboard_id', $scoreboard->id)->delete();

        $goalsHome = $request->goalsHome;
        collect($goalsHome)->each(function($player) use ($scoreboard) {
            Goal::create([
                'player_id' => $player['id'],
                'team_id'   => $player['team_id'],
                'scoreboard_id' => $scoreboard->id
            ]);
        });

        $goalsGuest = $request->goalsGuest;
        collect($goalsGuest)->each(function($player) use ($scoreboard) {
            Goal::create([
                'player_id' => $player['id'],
                'team_id'   => $player['team_id'],
                'scoreboard_id' => $scoreboard->id
            ]);
        });
    }
}
