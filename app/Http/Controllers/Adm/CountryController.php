<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adm\CountryRequest;
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

    public function store(CountryRequest $request)
    {
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

    public function update(CountryRequest $request, $id)
    {
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
