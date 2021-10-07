<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Demande;
use App\FactureDemande;
use PDF;
use DB;
use App\Paiement;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $clients = Client::orderBy('nom')->paginate(20);
        if($request->is('admin/*')){
            return view('admin.client',['clients' => $clients]);
        }
        return view('client',['clients' => $clients]);
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
            'name' => ['required' , 'string' , 'max:40' ],
            'email' => ['required', 'string', 'email', 'max:255'],
            'telephone' => ['nullable', 'numeric', 'digits:10','phone_number'],
            'type' => 'required',
        ],[
            'required'=>'Champ ne doit pas etre vide',
            'max'=>'Le nom doit être au max :max caractères',
            'phone_number'=>'Numéro du telephone doit être valide',
        ]);

        $client = new Client() ;
        $client->nom = request('name') ;
        $client->email = request('email') ;
        $client->telephone = request('telephone') ;
        $client->type = request('type') ;
        $client->credit = 0 ;
        $client->save() ;
        return back()->with("success","Client a été ajouté avec succès");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Client $client)
    {
        //
        request() -> validate([
            'name' => ['required' , 'string' , 'max:40' ],
            'email' => ['required', 'string', 'email', 'max:255'],
            'telephone' => ['nullable', 'numeric', 'digits:10','phone_number'],
            'type' => 'required' ,
        ],[
            'required'=>'Champ ne doit pas etre vide',
            'max'=>'Le nom doit être au max :max caractères',
            'phone_number'=>'Numéro du telephone doit être valide',
        ]);

        $client->update([
            'nom'=>request('name'), 'email'=>request('email'), 'telephone'=>request('telephone'),
            'type'=>request('type'), 'credit'=>request('credit'),
        ]);

        return back()->with("success", "Profile du client modifié avec succès");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(client $client)
    {
        //
        $client -> delete();
        return back()->with("success","Client a été supprimé");
    }

    public function facturePdf(Client $client){
    $i = 0;
    $bons_livraison = Demande::where('id_client', $client->id)
                    ->where('delivre', 1)
                    ->where('id_facture_demande', null)
                    ->get();
    if (empty($bons_livraison->toArray()) && $client->credit == 0){
        return back()->with("info", "Le client $client->nom n'a aucune facture");
    }
    if (empty($bons_livraison->toArray()) && $client->credit > 0){
        $i = 1;
    }


    $total = Demande::where('id_client', $client->id)
            ->where('delivre', 1)
            ->where('id_facture_demande', null)
            ->sum('total');
    
    //Paiement
    $montant_paye = request('montant_paye');
    $mode_payment = request('mode_payment');
    Paiement::create([
        'client_id'=>$client->id, 'mode_paiement'=>$mode_payment, 'montant_paye'=>$montant_paye,
    ]);
    $client->credit -= $montant_paye;
    $client->save();

    $Facture = new FactureDemande();
    $Facture->id_client = $client->id;
    $Facture->total = $total;
    $Facture->montant_paye = $montant_paye;
    $Facture->save();

   Demande::where('id_client', $client->id)
            ->where('delivre', 1)
            ->where('id_facture_demande', null)
            ->update([
                'id_facture_demande'=> $Facture->id
            ]);


    $array = array();
    foreach($bons_livraison as $bon){
        array_push($array, $bon->id);
    }

    $test1 = DB::table('demande_product')
            ->whereIn('demande_id',$array)
            ->get();

   /* foreach ($test1 as $t) {
        //dd($t);
        //array_push($array1, $t);
    }*/
    /*$test = DB::table('demande_product')
    ->whereIn('id', $array1)
    ->get();*/
    $pdf = \PDF::loadView('admin.factureClient', compact('bons_livraison', 'test1', 'Facture', 'client', 'i'));
    return $pdf->download("Facture $Facture->id Client $client->id");
    }
}
