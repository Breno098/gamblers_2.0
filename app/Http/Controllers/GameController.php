<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stadium;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::where('type', 'oficial')->orderBy('date')->get();
        foreach ($games as &$game) {
            $game->country;
            $game->stadium->country;
            $game->teamHome->country;
            $game->teamGuest->country;
        }

        return Inertia::render('Adm/Game', [
            'games' => $games,
        ]);
    }

    public function create()
    {
        return Inertia::render('Adm/Game/create', [
            'country' => Country::orderBy('name')->get(),
            'teams' => Team::orderBy('name')->get(),
            'stadia' => Stadium::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_home_id' => 'required',
            'team_guest_id' => 'required',
            'stadium_id' => 'required',
            'date' => 'required|date',
            'time' => 'required'
        ], [
            'team_home_id.required' => 'Informe o time mandante.',
            'team_guest_id.required' => 'Informe o time visitante.',
            'stadium_id.required' => 'Selecione o estádio.',
            'date.required' => 'Informe a data da partida.',
            'time.required' => 'Informe o horário da partida.'
        ]);

        Game::create([
            'team_home_id' => $request->team_home_id,
            'team_guest_id' => $request->team_guest_id,
            'stadium_id' => $request->stadium_id,
            'date' => $request->date,
            'time' => $request->time,
            'type' => 'oficial',
            'status' => 'open'
        ]);

        return Redirect::route('adm.game.index');
    }

    public function edit($id)
    {
        return Inertia::render('Adm/Game/create', [
            'game' => Game::findOrFail($id),
            'country' => Country::orderBy('name')->get(),
            'teams' => Team::orderBy('name')->get(),
            'stadia' => Stadium::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'team_home_id' => 'required',
            'team_guest_id' => 'required',
            'stadium_id' => 'required',
            'date' => 'required|date',
            'time' => 'required'
        ], [
            'team_home_id.required' => 'Informe o time mandante.',
            'team_guest_id.required' => 'Informe o time visitante.',
            'stadium_id.required' => 'Selecione o estádio.',
            'date.required' => 'Informe a data da partida.',
            'time.required' => 'Informe o horário da partida.'
        ]);

        if($id){
            Game::find($id)->update([
                'team_home_id' => $request->team_home_id,
                'team_guest_id' => $request->team_guest_id,
                'stadium_id' => $request->stadium_id,
                'date' => $request->date,
                'time' => $request->time,
                'type' => 'oficial',
                'status' => 'open'
            ]);

            return Redirect::route('adm.game.index');
        }
    }

    public function show($id)
    {
        return $this->index();
    }

    public function destroy($id)
    {
        try {
            Game::find($id)->delete();
        } catch(Exception $e){
            return $this->redirectErrorPage(
                $e->getCode() === 23000 ? "Para deletar o registro, atualize ou exclua suas dependencias." : $e->getMessage(),
                $e->getCode()
            );
        }

        return Redirect::route('adm.game.index');
    }
}
