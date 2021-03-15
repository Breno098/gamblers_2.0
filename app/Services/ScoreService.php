<?php

namespace App\Services;

use App\Models\Goal;
use App\Models\Scoreboard;
use Illuminate\Support\Facades\Log;

class ScoreService
{
    public function saveRequest($request, $type, $user_id = null)
    {
        if($user_id){
            $scoreboard = Scoreboard::where('game_id', $request->game['id'])->where('user_id', $user_id)->where('type', 'bet')->first();
        } else {
            $scoreboard = Scoreboard::where('game_id', $request->game['id'])->where('type', 'official')->first();
        }

        if($scoreboard){
            $scoreboard->update([
                'team_home_scoreboard' => count($request->goalsHome) ?? 0,
                'team_guest_scoreboard' => count($request->goalsGuest) ?? 0
            ]);
        } else {
            $scoreboard = Scoreboard::create([
                'game_id'   => $request->game['id'],
                'team_home_scoreboard' => count($request->goalsHome) ?? 0,
                'team_guest_scoreboard' => count($request->goalsGuest) ?? 0,
                'type'      => $type,
                'user_id'   => $user_id,
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

    public function calculate($request)
    {
        $official = Scoreboard::where('game_id', $request->game['id'])->where('type', 'official')->first();

        $scoreboard_bets = Scoreboard::where('game_id', $request->game['id'])->where('type', 'bet')->get();

        collect($scoreboard_bets)->each(function($bet) use ($official) {

            $score = 0;

            if($bet->team_home_scoreboard === $official->team_home_scoreboard && $bet->team_guest_scoreboard === $official->team_guest_scoreboard){
                $score = $score + 3;
                Log::info('Placar exato 3 pontos');

            } else if($bet->team_home_scoreboard > $bet->team_guest_scoreboard && $official->team_home_scoreboard > $official->team_guest_scoreboard){
                $score++;
                Log::info('ponto por ganhador 1 ponto');

            } else if($bet->team_home_scoreboard < $bet->team_guest_scoreboard && $official->team_home_scoreboard < $official->team_guest_scoreboard){
                $score++;
                Log::info('ponto por ganhador 1 ponto');

            } else if($bet->team_home_scoreboard === $bet->team_guest_scoreboard && $official->team_home_scoreboard === $official->team_guest_scoreboard){
                $score++;
                Log::info('ponto por empate 1 ponto');

            }

        });

    }
}
