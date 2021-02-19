<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\League;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Team;
use Illuminate\Support\Facades\Redirect;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('name')->get();
        foreach ($teams as &$team) {
            $team->country;
            $team->leagues;
        }

        return Inertia::render('Adm/Team', [
            'teams' => $teams
        ]);
    }

    public function create()
    {
        return Inertia::render('Adm/Team/create', [
            'countrys' => Country::orderBy('name')->get(),
            'leagues' => League::where('active', 1)->orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required',
            'country_id' => 'required',
            'leagues'    => 'required',
        ], [
            'name.required' => 'Nome obrigatório.',
            'country_id.required' => 'Escolha um país.',
            'leagues.required' => 'Seleciona as ligas.',
        ]);

        $team = Team::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
        ]);

        $team->leagues()->sync($request->leagues);

        return Redirect::route('adm.team.index');
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $team->country;
        $team->leagues;

        return Inertia::render('Adm/Team/create', [
            'countrys' =>  Country::orderBy('name')->get(),
            'leagues' => League::where('active', 1)->orderBy('name')->get(),
            'team' => $team
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required',
            'country_id' => 'required',
            'leagues'    => 'required',
        ], [
            'name.required' => 'Nome obrigatório.',
            'country_id.required' => 'Escolha um país.',
            'leagues.required' => 'Seleciona as ligas.',
        ]);

        if($id){
            $team= Team::find($id);

            $team->update([
                'name' => $request->name,
                'country_id' => $request->country_id,
            ]);

            $team->leagues()->sync($request->leagues);

            return Redirect::route('adm.team.index');
        }
    }

    public function show($id)
    {
        return $this->index();
    }

    public function destroy($id)
    {
        Team::find($id)->delete();
        return Redirect::route('adm.team.index');
    }
}
