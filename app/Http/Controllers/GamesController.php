<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Redirect;

class GamesController extends Controller
{
    public function index()
    {
        $players = Player::orderBy('name')->get();
        foreach ($players as &$player) {
            $player->country;
            $player->team;
        }

        return Inertia::render('Adm/Player', [
            'players' => $players,
        ]);
    }

    public function create()
    {
        return Inertia::render('Adm/Player/create', [
            'countrys' => Country::orderBy('name')->get(),
            'teams' => Team::orderBy('name')->get(),
            'positions' => ['GO', 'ZAG', 'LT', 'VOL', 'MEI', 'ATA']
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'country_id' => 'required',
            'team_id' => 'required'
        ], [
            'name.required' => 'Nome obrigatório.',
            'position.required' => 'Informe a posição.',
            'country_id.required' => 'Selecione o país.',
            'team_id.required' => 'Selecione o time.'
        ]);

        Player::create([
            'name' => $request->name,
            'position' => $request->position,
            'country_id' => $request->country_id,
            'team_id' => $request->team_id
        ]);

        return Redirect::route('adm.player.index');
    }

    public function edit($id)
    {
        return Inertia::render('Adm/Player/create', [
            'player' => Player::findOrFail($id),
            'countrys' => Country::orderBy('name')->get(),
            'teams' => Team::orderBy('name')->get(),
            'positions' => ['GO', 'ZAG', 'LT', 'VOL', 'MEI', 'ATA']
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'country_id' => 'required',
            'team_id' => 'required'
        ], [
            'name.required' => 'Nome obrigatório.',
            'position.required' => 'Informe a posição.',
            'country_id.required' => 'Selecione o país.',
            'team_id.required' => 'Selecione o time.'
        ]);

        if($id){
            Player::find($id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'country_id' => $request->country_id,
                'team_id' => $request->team_id
            ]);

            return Redirect::route('adm.player.index');
        }
    }

    public function show($id)
    {
        return $this->index();
    }

    public function destroy($id)
    {
        try {
            Player::find($id)->delete();
        } catch(Exception $e){
            return $this->redirectErrorPage(
                $e->getCode() === 23000 ? "Para deletar o registro, atualize ou exclua suas dependencias." : $e->getMessage(),
                $e->getCode()
            );
        }

        return Redirect::route('adm.player.index');
    }
}
