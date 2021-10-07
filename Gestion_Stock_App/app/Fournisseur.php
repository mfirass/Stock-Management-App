<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    //

    protected $fillable = [
        'nom', 'email', 'telephone', 'credit',
    ];

    
    public function commandes(){
        return $this->hasMany('App\Commande');
    }
}
