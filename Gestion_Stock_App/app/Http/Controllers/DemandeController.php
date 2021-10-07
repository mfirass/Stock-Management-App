<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Demande;
use App\Product;
use App\Client;
use App\Store;
use App\Paiement;
use Illuminate\Http\Request;
use DB;
use PDF;

class DemandeController extends Controller
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
        $demandes = Demande::all();
        $products = Auth::user()->store->products;
        $test = DB::table('demande_product')->get();
        $paiements = Paiement::all();
        $c =    DB::table('demande_store')
                    ->select('demande_id')
                    ->where('store_id', $store->id)
                    ->where('delivre', 1)
                    ->distinct()
                    ->get();
        $b =    DB::table('demande_store')
                ->select('demande_id')
                ->where('store_id', $store->id)
                ->whereNull('delivre')
                ->distinct()
                ->get();
        $array = array();
        $array1 = array();
        foreach($c as $s){
            array_push($array, $s->demande_id);
        }
        foreach($b as $s){
            array_push($array1, $s->demande_id);
        }
        $demandes1 = Demande::whereIn('id',$array)->get();
        $demandes2 = Demande::whereIn('id',$array1)->get();
       if($request->is('admin*')){
            return view('admin.demande',[
                'demandes'=>$demandes , 'products'=>$products, 'test'=>$test, 'store'=>$store, 'paiements'=>$paiements
                ]);
        }
        return view('demande',[
            'demandes1'=>$demandes1 , 'demandes2'=>$demandes2, 'products'=>$products, 'test'=>$test, 'store'=>$store, 'paiements'=>$paiements
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
        $products = DB::table('products')->get();
        $clients = Client::all();
        //dd($products);
        return view('admin.demandeCreate',[
            'products'=>$products, 'clients'=>$clients, 'stores'=>$stores
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
        $stores = Store::all();
        $products = Product::all();
        //Control de la quantité demandée
        $p = DB::table('product_store')
        ->where('store_id', $request->store)
        ->where('product_id', $request->p)
        ->first();
        if(is_null($p)){
            return back()->with('error', "Magasin $request->store n'a pas les produits demandés");
        }
        if($request->quantite > $p->quantite_reel){
            return back()->with('error', "Magasin $request->store n'a pas la quantité demandée");
        }
        //Création de la demande
        $demande = new Demande();
        $demande->id_client = $request->client;
        $demande->total = 0;
        $demande -> save();
        //resources pour établir la relation demande-produit
        $demande_id = $demande->id;
        $product_id = $request->p;
        $quantite = $request->quantite;
        $tva = $request->tva;
        $client = $demande -> client ;
        $product = Product::findOrFail($product_id) ;
        //Calculer le montant total de la demande
        if($client->type == 'grossiste'){
            if(!is_null(request('prix_vente'))){
            $product->prix_vente_grossite = request('prix_vente');
            $product->save(); 
            }
            if(is_null(request('prix_vente')) && ($product->prix_vente_grossite==0 || is_null($product->prix_vente_grossite))){
                return back()->with("error", "Prix de vente non-définie");
            }
            $demande->total = $demande->total + $product->prix_vente_grossite * $quantite + $product->prix_vente_grossite * $quantite * $tva/100 ;
        }
        if($client->type == 'detaillant'){
            if(!is_null(request('prix_vente'))){
            $product->prix_vente_detaillant = request('prix_vente');
            $product->save(); 
            }
            if(is_null(request('prix_vente')) && ($product->prix_vente_detaillant==0 || is_null($product->prix_vente_detaillant))){
                return back()->with("error", "Prix de vente non-définie");
            }
            $demande->total = $demande->total + $product->prix_vente_detaillant * $quantite + $product->prix_vente_detaillant * $quantite * $tva/100 ;
        }
        $demande -> save();

        //etablir la relation demande-produit
        DB::table('demande_product')->insert([
            'product_id'=>$product_id, 'demande_id'=>$demande_id, 'quantite'=>$quantite, 'store_id'=>$request->store, 'prix_vente'=>$request->prix_vente
        ]);
        //etablir la relation demande-magasin
        DB::table('demande_store')->insert([
            'demande_id'=>$demande_id, 'store_id'=>$request->store
        ]);
        $last_store = Store::find($request->store);
        //redirection pour compléter la demande
        $test = DB::table('demande_product')->get();
        return view('admin.demandeCreate1',[
            'demande'=>$demande, 'products'=>$products, 'stores'=>$stores, 'last_store'=>$last_store, 'test'=>$test,
            'demande_total'=>$demande->total,
            ]);
            
    }


        //Compléter la demande.
    public function addProduct(demande $demande, Request $request)
    {
        $products = Product::all();
        $stores = Store::all();
        //Control de la quantité demandée
        $p = DB::table('product_store')
        ->where('store_id', $request->store)
        ->where('product_id', $request->p)
        ->first();
        if(is_null($p)){
            return back()->with('error', "Magasin $request->store n'a pas les produits demandés");
        }
        if($request->quantite > $p->quantite_reel){
            return back()->with('error', "Magasin $request->store n'a pas la quantité demandée");
        }
        //resources pour établir la relation demande-produit
        $demande_id = $demande->id;
        $quantite = $request->quantite;
        $tva = $request->tva;
        $product_id = $request->p;
        $produit = Product::findOrFail($product_id);
        //Calculer le montant total de la demande
        if($demande->client->type == 'grossiste'){
            if(!is_null(request('prix_vente'))){
                $produit->prix_vente_grossite = request('prix_vente');
                $produit->save(); 
                }
                if(is_null(request('prix_vente')) && ($produit->prix_vente_grossite==0 || is_null($produit->prix_vente_grossite))){
                    return back()->with("error", "Prix de vente non-définie");
                }
            $demande -> total += $produit->prix_vente_grossite * $quantite + $produit->prix_vente_grossite * $quantite * $tva/100;
        }
        if($demande->client->type == 'detaillant'){
            if(!is_null(request('prix_vente'))){
                $produit->prix_vente_detaillant = request('prix_vente');
                $produit->save(); 
                }
                if(is_null(request('prix_vente')) && ($produit->prix_vente_detaillant==0 || is_null($produit->prix_vente_detaillant))){
                    return back()->with("error", "Prix de vente non-définie");
                }
            $demande -> total += $produit->prix_vente_detaillant * $quantite + $produit->prix_vente_detaillant * $quantite * $tva/100;
        }
        $demande -> save();
        //etablir la relation demande-produit
        DB::table('demande_product')->insert([
            'demande_id'=>$demande_id, 'product_id'=>$product_id, 'quantite'=>$quantite, 'store_id'=>$request->store
        ]);
        //etablir la relation demande-magasin
        DB::table('demande_store')->insert([
            'demande_id'=>$demande_id, 'store_id'=>$request->store
        ]);

        $last_store = Store::find($request->store);
        $test = DB::table('demande_product')->get();
        return view('admin.demandeCreate1',[
            'demande'=>$demande, 'products'=>$products, 'stores'=>$stores, 'last_store'=>$last_store, 'test'=>$test,
            'demande_total'=>$demande->total,
            ]);
    }

    public function fin(){
        return redirect()->route('admin.demandes')->with("success", "Demande a été ajouté");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function show(demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function edit($demande)
    {
        //
        $d = Demande::findOrFail($demande);
        $stores = Store::all();
        $last_store = Auth::user()->store;
        $products = Product::all();
        $test = DB::table('demande_product')->get();

        return view('admin.demandeCreate1',[
            'demande'=>$d, 'products'=>$products, 'stores'=>$stores, 'last_store'=>$last_store, 'test'=>$test,
            'demande_total'=>$d->total,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demande $demande)
    {
        //
        Paiement::where('demande_id', $demande->id)->delete();
        $demande->delete();
        return back()->with("success", "Demande supprimé");
    }

    public function verifie(Demande $demande){
        $fields = DB::table('demande_product')
        ->where('demande_id', $demande->id)
        ->get();
        $array = array();
        foreach($fields as $field){
            $p = DB::table('product_store')
                ->where('store_id', $field->store_id)
                ->where('product_id', $field->product_id)
                ->first();
            if(is_null($p)){
                return back()->with('error', "Magasin $field->store_id n'a pas les produits demandés");
            }
            if($field->quantite > $p->quantite_reel){
                return back()->with('error', "Magasin $field->store_id n'a pas la quantité demandée");
            }
                array_push($array, $p);
        }
        foreach ($array as $a) {
            $field = $fields->where('product_id', $a->product_id)
                            ->where('store_id', $a->store_id)
                            ->first();
            $v = $a->quantite_reel - $field->quantite;
            DB::table('product_store')
                ->where('store_id', $a->store_id)
                ->where('product_id', $a->product_id)
                ->update([
                    'quantite_reel'=> $v
                ]);
        }
        $client = $demande->client; 
        $client->credit += $demande->total;
        $client->save();

        /*
        $montant_paye = request('montant_paye');
        $mode_payment = request('mode_payment');
        Paiement::create([
            'demande_id'=>$demande->id, 'mode_paiement'=>$mode_payment, 'montant_paye'=>$montant_paye,
        ]);
        $credit = $demande->total - $montant_paye;
        $client = $demande->client; 
        $client->credit += $credit;
        $client->save();*/
        $demande->update([
            'delivre'=>1
        ]);

        return back()->with("success","Demande vérifié avec succès");
    }

    //Verification by user
    public function verifie1(Demande $demande){
        $store = Auth::user()->store->id;
        $fields = DB::table('demande_store')
                ->where('store_id', $store)
                ->where('demande_id', $demande->id)
                ->update(['delivre'=>1]);//->get();
        return back()->with("success", "Demande vérifiée");
        //dd($store, $demande->id, $fields);
    }

    public function pay(Demande $demande){
        $montant_paye = request('montant_paye');
        $mode_payment = request('mode_payment');
        Paiement::create([
            'client_id'=>$demande->id, 'mode_paiement'=>$mode_payment, 'montant_paye'=>$montant_paye,
        ]);
        $credit = $demande->credit;
        $credit -= $montant_paye;
        $client = $demande->client; 
        $client->credit -= $montant_paye;
        $client->save();
        $demande->update([
            'credit'=>$credit,
       ]);
       return back();
    }

    public function demandePdf(Demande $demande){
        $paiements = Paiement::all();
        $test = DB::table('demande_product')->get();
        $pdf = \PDF::loadView('admin.demande_pdf', compact('demande', 'paiements', 'test'));
        return $pdf->download("factureDemande $demande->id");
    }

    public function prix(Product $produit, Client $client){
        $produit = Product::findOrFail($produit);
        $client = Client::findOrFail($client);
        if($client->type == 'grossiste'){
            $d = $produit->prix_vente_grossite;
        }

        if($client->type == 'detaillant'){
            $d = $produit->prix_vente_detaillant;
        }
        $data['data'] = $d;
        echo json_encode($data);
        exit;
    }
}
