<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    //
    protected $fillable = [
        'libelle', 'marque', 'descriptif_technique','prix_vente_grossite',
        'prix_vente_detaillant', 'prix_achat',
    ];    

    public static function quantite_reel(Product $p){
    $store  = Auth::user()->store;
    $field = DB::table('product_store')
    ->where('store_id', $store->id)
    ->where('product_id', $p->id)
    ->get()->toArray()[0];
    return $field->quantite_reel;
    }

    public static function quantite_min(Product $p){
        $store  = Auth::user()->store;
        $field = DB::table('product_store')
        ->where('store_id', $store->id)
        ->where('product_id', $p->id)
        ->get()->toArray()[0];
        return $field->quantite_min;
        }

    public static function defectueux(Product $p){
        $store  = Auth::user()->store;
        $field = DB::table('product_store')
        ->where('store_id', $store->id)
        ->where('product_id', $p->id)
        ->get()->toArray()[0];
        return $field->defectueux;
        }

   /* public static function cat(Product $p){
        if(is_object($p->category))
        return $p->category->libelle;
    }*/

    public function category(){
        return $this->belongsTo('App\Category');
    }


    public function store(){
        return $this->belongsToMany('App\Store','product_store')->withPivot('quantite')
        ->withPivot('quantite_reel', 'quantite_min', 'defectueux');
    }

    public function demandes(){
        return $this->belongsToMany('App\Demande','demande_product')->withPivot('quantite');
    }

    public function commandes(){
        return $this->belongsToMany('App\Commande','commande_product')->withPivot('quantite', 'prix_achat');
    }
    
}
