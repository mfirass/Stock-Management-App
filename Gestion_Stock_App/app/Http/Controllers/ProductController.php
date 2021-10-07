<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use DB;
use Route;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
       // $products = Auth::user()->store->products;
        $store = Auth::user()->store->id;
        $fields = DB::table('product_store')->where('store_id', $store)->get();
        $array = array();
        foreach($fields as $field){
            array_push($array, $field->product_id);
        }
        $products = Product::whereIn('id', $array)->paginate(14);
        //$products = Product::chunk(14)->paginate(1);
        //dd($array);
        //$categories = Category::all();

        /*foreach($product as $pr){
                    dd($pr->category->libelle);

        }*/
        
       if($request->is('admin/*')){
            return view('admin.product',[ 'products' => $products]);
        }
        return view('product',[ 'products' => $products ]);
       /* $route = Route::currentRouteAction();
        dd($route);*/
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

        $customMessages = [
            'required' => 'Ce champ ne doit pas être vide .',
        ];

        $validator = request() -> validate([
            'libelle' => ['required' , 'string','min:3' , 'max:40' ],
            'marque' => ['required', 'string'],
            'descriptif_technique' => ['required', 'string'],
            'unite'=>['required'],
            'tva'=>['required'],
            'quantite_min' => ['required', 'integer'],
            'category' => 'required',
        ], $customMessages);

        $product = new Product() ;
        $product -> libelle = request('libelle');
        $product -> reference = request('reference');
        $product -> marque = request('marque') ;
        $unite = request('unite');
        $capacite = request('descriptif_technique');
        $product -> descriptif_technique = "$capacite$unite";
        $product -> category_id = request('category');
        $product->tva = request('tva');
        $product ->save();

        $quantite_min = request('quantite_min') ;
        $defectueux = 0 ;

        DB::table('product_store')->insert([
            'quantite_reel'=>0,'product_id'=>$product->id, 'store_id'=>$store->id,
            'quantite_min'=>$quantite_min, 'defectueux'=>$defectueux,
        ]);
            return redirect()->route('admin.produits');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
        return view('admin.productEdit',['product'=>$product]);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product)
    {
        //
        $store = Auth::user()->store;

       /* $customMessages = [
            'required' => 'Ce champ ne doit pas être vide .',
            'greater_than_field' => "Prix de vente doit être supérieur au prix d'achat",            
        ];*/
        //Administrateur
        if(Auth::user()->is_admin == 1){
       /* $validator = request() -> validate([
            'libelle' => ['required' , 'string', 'max:40'],
            'marque' => ['required', 'string'],
            'descriptif_technique' => ['required', 'string'],
            'quantite_reel' => ['nullable', 'integer'],
            'quantite_min' => ['required', 'integer'],
            'prix_achat' => ['nullable', ''],
            'category' => 'required',
        ],$customMessages); */

        $product->update([
            'libelle'=>request('libelle'), 'marque'=>request('marque'), 'descriptif_technique'=>request('descriptif_technique'),
            'prix_achat'=>request('prix_achat'), 'prix_vente_grossite'=>request('prix_vente_grossite'), 
            'prix_vente_detaillant'=>request('prix_vente_detaillant'), 'category'=>request('category'), 'tva'=>request('tva')
        ]);

        $quantite_reel = request('quantite_reel') ;
        $quantite_min = request('quantite_min') ;
        $defectueux = request('defectueux') ;

        DB::table('product_store')
        ->where('product_id', $product->id)
        ->where('store_id', $store->id)
        ->update([
            'quantite_reel'=>$quantite_reel,
            'quantite_min'=>$quantite_min, 'defectueux'=>$defectueux,
        ]);

        
            return redirect()->back()->with("success", "Produit modifié");
        }
        //Utilisateur
        else{
            request()->validate([
                'quantite_min' => ['required', 'integer'],
            ],[
                'required'=>'Ce champ no doit pas etre vide',
                'integer'=> 'Ce champ doit etre un entier positif',
            ]);
            $quantite_min = request('quantite_min');
    
            DB::table('product_store')
            ->where('product_id', $product->id)
            ->where('store_id', $store->id)
            ->update([
                'quantite_min'=>$quantite_min
            ]);
            return redirect()->route('user.produits');
        }
        
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
        $product -> delete() ;
        return back() ;
    }



    public function replace(Product $product){
        $store = Auth::user()->store;
        //Cas de la suppression
        if(Route::currentRouteName()=='product.diff'){
            $field = DB::table('product_store')
            ->where('product_id', $product->id)
            ->where('store_id', $store->id)
            ->first();
        $quantite = $field->quantite_reel;
        $defectueux = $field->defectueux;
        $quantite = $quantite - $defectueux;
        $defectueux = 0;
        DB::table('product_store')
            ->where('product_id', $product->id)
            ->where('store_id', $store->id)
            ->update([
            'quantite_reel'=>$quantite, 'defectueux'=>$defectueux,
        ]); 
        return back()->with("success", "La quantité defectueux a été supprimer");
        }
        //Cas de rempacement
        if(Route::currentRouteName()=='product.replace'){
            DB::table('product_store')
            ->where('product_id', $product->id)
            ->where('store_id', $store->id)
            ->update([
                'defectueux'=>0
            ]);

            return back()->with("success", "Le produit a été remplacer par la fournisseur");   
        }
        return back()->with("error", "Error");
    }
}