<?php

namespace App\Http\Controllers;

use App\Models\Sat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SatKontroler extends Controller
{

    public function vratiSatove()
    {
        $sviSatovi = Sat::all();
        return response()->json(['sviSatovi' => $sviSatovi]);
    }


    public function dodajSat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brend' => 'required|string',
            'model' => 'required|string',
            'cena' =>  'required',
            'pol' => 'required|string',
            'narukvica' => 'required|string',
            'mehanizam' => 'required|string',
            'garancija' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['Info' => 'Please fill in all the fields!']);
        }

        $noviSat = new Sat();

        $noviSat->brend = $request->input('brend');
        $noviSat->model = $request->input('model');
        $noviSat->cena = $request->input('cena');
        $noviSat->pol = $request->input('pol');
        $noviSat->narukvica = $request->input('narukvica');
        $noviSat->mehanizam = $request->input('mehanizam');
        $noviSat->garancija = $request->input('garancija');


        if ($request->hasFile('slika')) {
            $file = $request->file('slika');
            $extension = $file->getClientOriginalExtension();
            $filename = $noviSat->brend . $noviSat->model . '.' . $extension;
            $file->move('slike/', $filename);
            $noviSat->slika = 'slike/' . $filename;
        }

        $noviSat->save();

        return response()->json([
            'Info' => 'The watch has been added successfully!'
        ]);
    }


    public function deleteSat($ID)
    {
        $deleteSat = Sat::find($ID);

        if ($deleteSat) {
            $deleteSat->delete();

            return response()->json(['Info' => 'The watch has been deleted successfully!']);
        }
    }
}
