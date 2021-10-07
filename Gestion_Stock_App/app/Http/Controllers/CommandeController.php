<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Commande;
use Illuminate\Http\Request;
use App\Product;
use App\Fournisseur;
use App\Store;
use App\Paiement;
use DB;
use PDF;
class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $store = Auth::user()->store;
        $commandes = Commande::all();
        $products = Auth::user()->store->products;
        $test = DB::table('commande_product')->get();
        $paiements = Paiement::all();
        $c =    DB::table('commande_store')
                ->select('commande_id')
                ->where('store_id', $store->id)
                ->distinct()
                ->get();
        $array = array();
        foreach($c as $s){
        array_push($array, $s->commande_id);
        }
        $commandes1 = Commande::whereIn('id',$array)->get();
        if($request->is('admin*')){
            return view('admin.commande',[
                'commandes'=>$commandes , 'products'=>$products, 'test'=>$test, 'store'=>$store, 'paiements'=>$paiements
                ]);
        }
        return view('commande',[
            'commandes1'=>$commandes1 , 'products'=>$products, 'test'=>$test, 'store'=>$store, 'paiements'=>$paiements
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $stores = Store::all();
        $products = Product::all();
        $fournisseurs = Fournisseur::all();
        return view('admin.commandeCreate',[
            'products'=>$products, 'fournisseurs'=>$fournisseurs, 'stores'=>$stores
            ]);
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
       /* $request->validate([
            'fournisseur'=>'required', 
            'p'=>'required', 
            'store'=>'required', 
            'prix_a' => 'required,'
        ],[
            'required'=>'Ce champ ne doit pas etre vide']);*/

        $stores = Store::all();
        $products = Product::all();
        //Création de la commande
        $commande = new commande();
        $commande->id_fournisseur = $request->fournisseur;
        $commande->total = 0;
        $commande -> save();
        //resources pour établir la relation commande-produit
        $commande_id = $commande->id;
        $product_id = $request->p;
        $quantite = $request->quantite;
        $prix_achat = $request->prix_a;
        $fournisseur = $commande -> fournisseur ;
        $product = Product::findOrFail($product_id) ;
        //Recalculer le prix d'achat du produit 
        $somme = DB::table('product_store')->sum('quantite_reel');
        $product->prix_achat = (($product->prix_achat * $somme) + ($prix_achat * $quantite))/($somme + $quantite);
        $product->save();
        //Calculer le montant total de la commande
        $commande->total = $commande->total + $prix_achat * $quantite ;
        $commande -> save();
        //etablir la relation commande-produit
        DB::table('commande_product')->insert([
            'product_id'=>$product_id, 'commande_id'=>$commande_id, 'quantite'=>$quantite, 'store_id'=>$request->store, 'prix_achat'=>$prix_achat
        ]);
        //etablir la relation commande-magasin
        DB::table('commande_store')->insert([
            'commande_id'=>$commande_id, 'store_id'=>$request->store
        ]);
        $last_store = Store::find($request->store);
        //redirection pour compléter la commande
        $test = DB::table('commande_product')->get();
        return view('admin.commandeCreate1',[
            'commande'=>$commande, 'products'=>$products, 'stores'=>$stores, 'last_store'=>$last_store, 'test'=>$test,
            'commande_total'=>$commande->total,
            ]);
    }

        //Compléter la commande.
        public function addProduct(Commande $commande, Request $request)
        {
            //
            $request->validate([
                'fournisseur'=>'required',
                'p'=>'required',
                'store'=>'required',
            ],[
                'required'=>'Champ :attribute ne peut pas etre vide'
            ]);

            $products = Product::all();
            $stores = Store::all();
            //resources pour établir la relation commande-produit
            $prix_achat = $request->prix_a;
            $commande_id = $commande->id;
            $quantite = $request->quantite;
            $product_id = $request->p;
            $product = Product::findOrFail($product_id);
            //Recalculer le prix d'achat du produit 
            $somme = DB::table('product_store')->sum('quantite_reel');
            $product->prix_achat = (($product->prix_achat * $somme) + ($prix_achat * $quantite))/($somme + $quantite);
            $product->save();
            //Calculer le montant total de la commande
                $commande -> total += $prix_achat * $quantite;
            $commande -> save();
            //etablir la relation commande-produit
            DB::table('commande_product')->insert([
                'commande_id'=>$commande_id, 'product_id'=>$product_id, 'quantite'=>$quantite, 'store_id'=>$request->store, 'prix_achat'=>$prix_achat
            ]);
            //etablir la relation commande-magasin
            DB::table('commande_store')->insert([
                'commande_id'=>$commande_id, 'store_id'=>$request->store
            ]);

            $last_store = Store::find($request->store);
            $test = DB::table('commande_product')->get();
            return view('admin.commandeCreate1',[
                'commande'=>$commande, 'products'=>$products, 'stores'=>$stores, 'last_store'=>$last_store, 'test'=>$test,
                'commande_total'=>$commande->total,
                ]);
        }

        public function fin(){
            return redirect()->route('admin.commandes')->with("success","Commande ajouté avec succès");
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
        $c = Commande::findOrFail($commande);
        $stores = Store::all();
        $last_store = Auth::user()->store;
        $products = Product::all();
        $test = DB::table('commande_product')->get();

        return view('admin.commandeCreate1',[
            'commande'=>$c, 'products'=>$products, 'stores'=>$stores, 'last_store'=>$last_store, 'test'=>$test,
            'commande_total'=>$c->total,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
        $commande->delete();
        return back()->with("success","Commande supprimé");
    }

    public function verifie(Commande $commande){
       /* request()->validate([
            'montant_paye'=>'required',
            'mode_payment'=>'required'
        ],[
            'required'=>':attribute ne peut pas etre vide'
        ]); */


        $fields = DB::table('commande_product')
        ->where('commande_id', $commande->id)
        ->get();
        foreach ($fields as $field) {
            $p = DB::table('product_store')
                ->where('store_id', $field->store_id)
                ->where('product_id', $field->product_id)
                ->first();
            if(is_null($p)){
                DB::table('product_store')->insert([
                    'store_id'=>$field->store_id, 'product_id'=>$field->product_id, 'quantite_reel'=>$field->quantite,
                ]);
            }
            else{
                $q = $p->quantite_reel + $field->quantite;
                DB::table('product_store')
                ->where('store_id', $field->store_id)
                ->where('product_id', $field->product_id)
                ->update([
                    'quantite_reel'=>$q,
                ]);
            }
        }



       /* $montant_paye = request('montant_paye');
        $mode_payment = request('mode_payment');
        Paiement::create([
            'commande_id'=>$commande->id, 'mode_paiement'=>$mode_payment, 'montant_paye'=>$montant_paye,
        ]);*/
        $credit = $commande->total;
        $fournisseur = $commande->fournisseur; 
        $fournisseur->credit += $credit;
        $fournisseur->save();
        $commande->update([
            'delivre'=>1,
        ]);

        return back()->with("success","La commande est verifié");
    }

    public function pay(Commande $commande){
        request()->validate([
            'montant_paye'=>'required',
            'mode_payment'=>'required'
        ],[
            'required'=>':attribute ne peut pas etre vide'
        ]);
        $montant_paye = request('montant_paye');
        $mode_payment = request('mode_payment');
        Paiement::create([
            'commande_id'=>$commande->id, 'mode_paiement'=>$mode_payment, 'montant_paye'=>$montant_paye,
        ]);
        $credit = $commande->credit;
        $credit -= $montant_paye;
        $fournisseur = $commande->fournisseur; 
        $fournisseur->credit -= $montant_paye;
        $fournisseur->save();
        $commande->update([
            'credit'=>$credit,
       ]);
       return back()->with("success","Paiement a été ajouté");
    }

    public function commandePdf(Commande $commande){
        $paiements = Paiement::all();
        $test = DB::table('commande_product')->get();

        $pdf = PDF::loadView('commande_pdf',[
            'commande'=>$commande, 'paiements'=>$paiements, 'test'=>$test,
        ]);
        $name = "commandeNo-".$commande->id.".pdf";
        return $pdf->download($name);
    }
}
