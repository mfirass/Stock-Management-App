<?php

namespace App;
use App\Product;
use App\Store;
use DB;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    //

    protected $fillable = ['credit', 'total','delivre'];
    public function store(){
        return $this->belongsToMany('App\Store','commande_store');
    }

    public function fournisseur(){
        return $this->belongsTo('App\Fournisseur','id_fournisseur');
    }

    public function products(){
        return $this->belongsToMany('App\Product','commande_product')->withPivot('quantite', 'prix_achat');
    }

    public static function product_quantite(Commande $c, Product $p, Store $s){
        $field=DB::table('commande_product')
        ->where('commande_id', $c->id)
        ->where('product_id', $p->id)
        ->where('store_id', $s->id)
        ->get()->toArray()[0];
        return $field->quantite;
    }
}
