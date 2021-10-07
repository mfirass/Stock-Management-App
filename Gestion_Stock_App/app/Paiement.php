<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    //
    protected $table = "paiements";
    protected $fillable = [
        'demande_id', 'commande_id', 'mode_paiement','montant_paye',
    ];
}
