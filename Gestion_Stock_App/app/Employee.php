<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $fillable = [
        'nom', 'telephone', 'email','salaire',
    ];

    public function store(){
        return $this->belongsTo('App\Store','store_id');
    }
}
