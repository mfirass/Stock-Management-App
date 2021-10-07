<?php

namespace App\Http\Controllers;

use App\Charge;
use App\Employee;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;


class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //Charges
        $charges = Charge::where('store_id', Auth::user()->store->id)->first();
        $salaire = Employee::where('store_id', Auth::user()->store->id)->sum('salaire');
        return view('admin.charges', compact('charges', 'salaire'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Charge $charge)
    {
        //
        $request->validate([
            'loyers'=>'nullable|min:0',
            'a'=>'nullable|min:0',
            'frais_vehicule'=>'nullable|min:0',
            'frais_emballage'=>'nullable|min:0',
            'conception'=>'nullable|min:0',
            'autres'=>'nullable|min:0',
        ],[
            'min'=>'Valeur doit etre positive'
        ]);

        $charge->salaires = Employee::sum('salaire');
        $charge->loyers = $request->loyers;
        $charge->assurance = $request->a;
        $charge->frais_vehicule = $request->frais_vehicule;
        $charge->frais_emballage = $request->frais_emballage;
        $charge->conception = $request->conception;
        $charge->autres = $request->autres;
        $charge->save();
        /*
        $charge->update([
            'loyers'=>$request->loyers, 'assurance'=>$request->a, 'frais_vehicule'=>$request->frais_vehicule,
            'frais_emballage'=>$request->frais_emballage, 'conception'=>$request->conception, 'autres'=>$request->autres,
        ]);*/
        return back()->with("success", "Les charges sont modifié");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
