<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Redirect;

class CountryController extends Controller
{
    public function index()
    {
        return Inertia::render('Adm/Country', [
            'countrys' => Country::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Adm/Country/create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required'], ['name.required' => 'Nome obrigatório.']);

        Country::create([
            'name' => $request->name,
        ]);

        return Redirect::route('adm.country.index');
    }

    public function edit($id)
    {
        return Inertia::render('Adm/Country/create', [
            'country' => Country::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required'], ['name.required' => 'Nome obrigatório.']);

        if($id){
            Country::find($id)->update([
                'name' => $request->name,
            ]);

            return Redirect::route('adm.country.index');
        }
    }

    public function show($id)
    {
        return $this->index();
    }

    public function destroy($id)
    {
        try {
            Country::find($id)->delete();
        } catch(Exception $e){
            return $this->redirectErrorPage(
                $e->getCode() === '23000' ? "Por esse país estar vinculado a um time, você não pode apaga-lo. Para deletar o registro, atualize ou exclua suas dependencias." : $e->getMessage(),
                $e->getCode()
            );
        }

        return Redirect::route('adm.country.index');
    }
}
