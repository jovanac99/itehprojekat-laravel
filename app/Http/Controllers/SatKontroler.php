<?php

namespace App\Http\Controllers;

use App\Models\Sat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


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


    public function editSat($ID)
    {
        $editSat = Sat::find($ID);

        if ($editSat) {
            return response()->json(['editSat' => $editSat]);
        }
    }


    public function saveSat(Request $request, $ID)
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
            return response()->json(['Info' => $validator->errors()]);
        } else {
            $sat = Sat::find($ID);

            if ($sat) {

                $sat->brend = $request->input('brend');
                $sat->model = $request->input('model');
                $sat->cena = $request->input('cena');
                $sat->pol = $request->input('pol');
                $sat->narukvica = $request->input('narukvica');
                $sat->mehanizam = $request->input('mehanizam');
                $sat->garancija = $request->input('garancija');

                if ($request->hasFile('slika')) {
                    $path = $sat->slika;

                    if (File::exists($path)) {
                        File::delete($path);
                    }

                    $file = $request->file('slika');
                    $extension = $file->getClientOriginalExtension();
                    $filename = $sat->brend . $sat->model . '.' . $extension;
                    $file->move('slike/', $filename);
                    $sat->slika = 'slike/' . $filename;
                }

                $sat->update();

                return response()->json([
                    'Info' => 'The watch has been updated successfully!'
                ]);
            }
        }
    }
}
