<?php

namespace App;
use App\Product;
use App\Store;
use DB;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    //
    protected $fillable = ['credit', 'total','delivre'];

    public function stores(){
        return $this->belongsToMany('App\Store','demande_store');
    }

    public function client(){
        return $this->belongsTo('App\Client','id_client');
    }

    public function products(){
        return $this->belongsToMany('App\Product','demande_product')->withPivot('quantite');
    }

    public static function product_quantite(Demande $d, Product $p, Store $s){
        $field=DB::table('demande_product')
        ->where('demande_id', $d->id)
        ->where('product_id', $p->id)
        ->where('store_id', $s->id)
        ->get()->toArray()[0];
        return $field->quantite;
    }
    
}
