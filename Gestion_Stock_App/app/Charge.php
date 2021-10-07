<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    //
    protected $fillable = [
        'loyers', 'asssurance', 'frais_vehicule', 'frais_emballage', 'conception', 'autres',
    ];

    public function store(){
        return $this->belongsTo('App\Store','store_id');
    }
}
