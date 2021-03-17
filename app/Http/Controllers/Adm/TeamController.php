<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adm\TeamRequest;
use App\Models\Competition;
use App\Models\Country;
use App\Models\Player;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Team;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('name')->get();
        foreach ($teams as &$team) {
            $team->country;
            $team->competitions;
        }

        return Inertia::render('Adm/Team', [
            'teams' => $teams
        ]);
    }

    public function create()
    {
        return Inertia::render('Adm/Team/create', [
            'countrys' => Country::orderBy('name')->get(),
            'competitions' => Competition::where('active', 1)->orderBy('name')->get()
        ]);
    }

    public function store(TeamRequest $request)
    {
        $name_photo = Carbon::now()->format('YmdHis') . $request->file('photo')->getClientOriginalName();

        if(!$request->file('photo')->storeAs('teams', $name_photo)){
            return $this->redirectErrorPage("Erro ao fazer o upload da foto");
        }

        $team = Team::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'name_photo' => $name_photo
        ]);
        $team->competitions()->sync($request->competitions);

        Player::create([
            'name' => 'Gol Contra',
            'team_id' => $team->id,
        ]);

        return Redirect::route('adm.team.index');
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $team->country;
        $team->competitions;

        return Inertia::render('Adm/Team/create', [
            'countrys' =>  Country::orderBy('name')->get(),
            'competitions' => Competition::where('active', 1)->orderBy('name')->get(),
            'team' => $team
        ]);
    }

    public function update(Request $request, $id)
    {

    }

    public function updateWithImage(TeamRequest $request)
    {
        $name_photo = $request->file('photo') ? Carbon::now()->format('YmdHis') . $request->file('photo')->getClientOriginalName() : false;

        if($name_photo && !$request->file('photo')->storeAs('teams', $name_photo)){
            return $this->redirectErrorPage("Erro ao fazer o upload da foto");
        }

        if($request->id){
            $team = Team::find($request->id);

            if($name_photo && Storage::exists('teams/' . $team->name_photo)){
                Storage::delete('teams/' . $team->name_photo);
            }

            $team->update([
                'name' => $request->name,
                'country_id' => $request->country_id,
                'name_photo' => $name_photo ?: $team->name_photo
            ]);

            $team->competitions()->sync($request->competitions);

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
            $team = Team::find($id);
            $competitions = $team->competitions;
            $team->competitions()->sync([]);
            $team->delete();

            return Redirect::route('adm.team.index');
        } catch(\Exception $e){
            $team->competitions()->sync($competitions);

            return $this->redirectErrorPage(
                $e->getCode() === '23000' ? "Para deletar o registro, atualize ou exclua suas dependencias." : $e->getMessage(),
                $e->getCode()
            );
        }
    }
}
