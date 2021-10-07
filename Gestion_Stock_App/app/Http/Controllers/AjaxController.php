<?php

namespace App\Http\Controllers;
use App\Product;
use App\Store;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Fournisseur;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //
    public function prix($produit, $client){
        $p = Product::findOrFail($produit);
        $c = Client::findOrFail($client);
        if($c->type == "detaillant"){
            $prix = $p->prix_vente_detaillant;
        }
        if($c->type == "grossiste"){
            $prix = $p->prix_vente_grossite;
        }
        $tva = $p->tva;
        $data = array();
        $categorie = $p->category->libelle;
        $data['produit']="$categorie  $p->libelle $p->marque $p->descriptif_technique";
        $data['prix'] = $prix;
        $data['tva'] = $tva;
        $data['type_client'] = $c->type;
        return $data;
    }

    public function prix_achat($produit, $fournisseur){
        $p = Product::findOrFail($produit);
        $c = Fournisseur::findOrFail($fournisseur);
        $prix = $p->prix_achat;
        $tva = $p->tva;
        $data = array();
        $categorie = $p->category->libelle;
        $data['produit']="$categorie  $p->libelle $p->marque $p->descriptif_technique";
        $data['prix'] = $prix;
        $data['tva'] = $tva;
        $data['fournisseur'] = $c->nom;
        return $data;
    }

    public function type($client){
        $c = Client::findOrFail($client);
        $data = "Le client '$c->nom' est un '$c->type'";        
        return $data;
    }
}
