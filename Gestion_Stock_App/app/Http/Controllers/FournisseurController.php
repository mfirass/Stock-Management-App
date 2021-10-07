<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $fournisseurs = Fournisseur::orderBy('nom')->paginate(20);
        if($request->is('admin*')){
            return view('admin.fournisseur',['fournisseurs' => $fournisseurs]);
        }
        return view('fournisseur',['fournisseurs' => $fournisseurs]);
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
    public function store()
    {
        //
        $store = Auth::user()->store;

        request() -> validate([
            'name' => ['required' , 'string','min:4' , 'max:40' ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
            'telephone' => ['nullable', 'numeric', 'digits:10','phone_number'],
        ]);

        $fournisseur = new Fournisseur() ;
        $fournisseur -> nom = request('name') ;
        $fournisseur -> email = request('email') ;
        $fournisseur -> telephone = request('telephone') ;
        $fournisseur -> ice = request('ice') ;
        $fournisseur -> credit = 0 ;
        $fournisseur -> save() ;
        return back()->with("success", "Fournisseur a été ajouté avec succès");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show(fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit(fournisseur $fournisseur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(Fournisseur $fournisseur)
    {
        //
        request() -> validate([
            'name' => ['required' , 'string','min:4' , 'max:40' ],
            'email' => ['required', 'string', 'email', 'max:255'],
            'telephone' => ['nullable', 'numeric', 'digits:10','phone_number'],
        ]);

        $fournisseur->update([
            'nom'=>request('name'), 'email'=>request('email'), 'telephone'=>request('telephone'),
            'credit'=>request('credit'),
        ]);
        
        return back()->with("success", "Profile du fournisseur modifié avec succès");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy(fournisseur $fournisseur)
    {
        //
        $fournisseur -> delete() ;
        return back()->with("success", "Fournisseur a été supprimé") ;
    }
}
