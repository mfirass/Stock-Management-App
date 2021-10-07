<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demande{{$demande->id}}</title>
<style>
table{
  border-collapse: collapse;
  border: 1px solid black;
  table-layout: auto;
  width: 100%; 
}
th, td {
    border: 1px solid black;
    font-size: 15px;
}
.center {
  margin: auto;
  width: 100%;
  padding: 1px;
}
body {
    font-family: serif;
}
</style>
</head>
<body>        
    <div style="float: right">
            <p>
                {{$demande->delivre ? 'Bon de livraison' : 'Devis'}} ; Commande NO {{$demande->id}} <br>
                {{$demande->created_at}} <br>
                Client : {{$demande->client->nom}}  <b style="text-transform: uppercase">{{$demande->client->type}}</b> <br>
                Email : {{$demande->client->email}} <br>
                Tel : {{$demande->client->telephone}} <br>

            </p>
        </div>
        <div style="">
            <p>
                <b class="text-uppercase">T-CREATIVE</b><br>
                Email : {{Auth::user()->email}} <br>
                Tel : {{Auth::user()->telephone}} <br>

            </p>
        </div>
 
        <div class="center">
            <br> <br>
            <h4>Produits</h4>
            <table>
                <tr>
                    <th>Produit</th>
                    <th>Magasin</th>
                    <th>Quantité</th>
                    <th>Total HT</th>
                    <th>TVA</th>
                </tr>
                
                    @foreach ($test as $t)
                    @if ($t->demande_id == $demande->id)
                    <tr>
                            <td>
                                @php
                                    $produit = App\Product::findOrFail($t->product_id);
                                @endphp
                               <p>{{$produit->category->libelle}} {{$produit->libelle}} {{$produit->marque}}</p> 
                            </td>
                            <td>
                                  <p>Magasin   {{$t->store_id}}</p>
                            </td>
                            <td>
                                @php
                                    $q = $t->quantite;
                                @endphp
                                 <p>{{$q}}</p>
                            </td>
                            <td>
                                @php
                                if($demande->client->type == 'grossiste')
                                {
                                    $n = $q * $produit->prix_vente_grossite;
                                }
                                else
                                {
                                    $n = $q * $produit->prix_vente_detaillant;
                                }
                                @endphp
                                 <p>{{$n}} Dhs</p>
                            </td>
                            <td>
                                {{$produit->tva}}%
                            </td>
                        </tr>
                    @endif
                @endforeach
                
            </table>
            <h4><b>Total TTC</b></h4>
            {{$demande->total}} Dhs
            <br> 
        </div>
 </body>
    </html>