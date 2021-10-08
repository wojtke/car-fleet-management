<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $search = $request->query('search');
        $searchBy = $request->query('searchBy');
        $sortBy = $request->query('sortBy');
        $sortDir = $request->query('sortDir');
        
        $cars = DB::table('cars');

        if ($search!="") { 
            $cars = $cars->where($searchBy, 'like', $search.'%');
        }

        if ($sortBy!="") {
            $cars = $cars->orderBy($sortBy, $sortDir);
        }

        return $cars->simplePaginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nazwa'=> ['required', 'max:255'],
            'rejestracja'=>'required|max:255',
            'stan_licznika'=>'required|integer|max:99999999',
            'stan_licznika_wymiana_oleju'=>'integer|max:99999999',
            'ostatni_przeglad_data' => 'nullable|date',
            'marka' => 'nullable|max:255', 
            'model' => 'nullable|max:255', 
            'kolor' => 'nullable|max:255',
        ]);

        return Car::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Car::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $car = Car::find($id);
        $car->update($request->all());
        return $car;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Car::destroy($id);
    }

    /**
     * Search for a name
     *
     * @param  str $name
     * @return \Illuminate\Http\Response
     */
    public function search($nazwa)
    {
        return Car::where('nazwa', 'like', '%'.$nazwa.'%')->get();
    }
}
