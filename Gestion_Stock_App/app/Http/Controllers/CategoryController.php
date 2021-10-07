<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use DB ;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories= Category::all() ;
        return view('category', ['categories' => $categories]);
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
        request() -> validate([
            'libelle' => ['required' , 'string','min:3' , 'max:40', 'unique:categories' ],
            'description' => ['nullable', 'string'],
        ],[
            'required'=>'Ce champ ne peut pas etre vide',
            'min'=>'Valeur est petite',
            'max'=>'Valeur est grande',
            'unique'=>'Catégorie existe déja'
        ]);

        $category = new category() ;
        $category -> libelle = request('libelle') ; 
        $category -> description = request('description') ; 
        $category -> save() ;

        return back()->with("success", "Catégorie est bien ajouté");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }
}
