<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function products(){
        return $this->belongsToMany('App\Product','product_store')
        ->withPivot('quantite_reel', 'quantite_min', 'defectueux');
    }

    public function commandes(){
        return $this->belongsToMany('App\Commande','commande_store');
    }

    public function demandes(){
        return $this->belongsToMany('App\Demande','demande_store');
    }

    public function charge(){
        return $this->hasOne('App\Charge');
    }

    public function employees(){
        return $this->hasMany('App\Employee');
    }
    
}
