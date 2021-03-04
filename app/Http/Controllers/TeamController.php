<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\League;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Team;
use Illuminate\Support\Carbon;
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
            'photo'      => 'required|file|image'
        ], [
            'name.required' => 'Nome obrigatório.',
            'country_id.required' => 'Escolha um país.',
            'leagues.required' => 'Selecione as ligas.',
            'photo.required' => 'Selecione uma foto.',
            'photo.image' => 'Parece que o arquivo não é uma imagem. Escolha uma foto e tente novamente.'
        ]);

        $name_photo = Carbon::now()->format('YmdHis') . $request->file('photo')->getClientOriginalName();

        if(!$request->file('photo')->storeAs('teams', $name_photo)){
            return $this->redirectErrorPage("Erro ao fazer o upload da foto");
        }

        $team = Team::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'name_photo' => $name_photo
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
        try {
            $team= Team::find($id);
            $team->leagues()->sync([]);
            $team->delete();
            return Redirect::route('adm.team.index');
        } catch(\Exception $e){
            return $this->redirectErrorPage(
                $e->getCode() === 23000 ? "Para deletar o registro, atualize ou exclua suas dependencias." : $e->getMessage(),
                $e->getCode()
            );
        }
    }
}
