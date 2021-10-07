<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'nom', 'email', 'telephone', 'type', 'credit',
    ];


    public function demandes(){
        return hasMany('App\Demande');
    }
}
