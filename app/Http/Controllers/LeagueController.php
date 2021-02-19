<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Redirect;

class LeagueController extends Controller
{
    public function index()
    {
        return Inertia::render('Adm/League', [
            'leagues' => League::where('active', 1)->orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Adm/League/create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required'], ['name.required' => 'Nome obrigatório.']);

        League::create([
            'name' => $request->name,
            'active' => 1
        ]);

        return Redirect::route('adm.league.index');
    }

    public function edit($id)
    {
        return Inertia::render('Adm/League/create', [
            'league' => League::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required'], ['name.required' => 'Nome obrigatório.']);

        if($id){
            League::find($id)->update([
                'name' => $request->name,
                'active' => intval('0')
            ]);

            return Redirect::route('adm.league.index');
        }
    }

    public function show($id)
    {
        return $this->index();
    }

    public function destroy($id)
    {
        League::find($id)->update([ 'active' => 0 ]);
        return Redirect::route('adm.league.index');
    }
}
