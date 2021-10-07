<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Commande {{$commande->id}} </title>
        <style>
            table{
              border-collapse: collapse;
              border: 1px solid black;
              table-layout: auto;
              width: 100%; 
            }
            th, td {
                border: 1px solid black;
            }
            .center {
              margin: auto;
              width: 60%;
              padding: 10px;
            }
            </style>
</head>
<body>
        <div class="row">
                <p>
                    Commande NO {{$commande->id}} <br>
                    {{$commande->created_at}} <br>
                    Fournisseur : {{$commande->fournisseur->nom}}  <br>
                    Email : {{$commande->fournisseur->email}} <br>
                    Tel : {{$commande->fournisseur->telephone}} <br>
                </p>
        </div>
        <div class="center">
            <h3>Produits</h3>
            <table>
                <tr>
                    <th>Produit</th>
                    <th>Magasin</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
                
                    @foreach ($test as $t)
                    @if ($t->commande_id == $commande->id)
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
                                    $n = $q * $produit->prix_achat;
                                @endphp
                                 <p>{{$n}} Dhs</p>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
        <div class="center">
            <h4><b>Paiements</b></h4>
              <table>
                <tr>
                  <th>Montant payé</th>
                  <th>Mode paiement</th>
                  <th>Date</th>
                </tr>
                <tbody>
            @foreach ($paiements as $paiement)
            @if ($paiement->commande_id == $commande->id)
                  <tr>
                    <td><p>{{$paiement->montant_paye}} Dhs</p> </td>
                    <td class="text-uppercase"><p>{{$paiement->mode_paiement}}</p> </td>
                    <td><p>{{$paiement->created_at}} </p></td>
                  </tr>
            @endif
            @endforeach
                </tbody>
              </table>
        </div>
              <h4><b>Total</b></h4>
              {{$commande->total}} Dhs
              <br>
              <h4><b>Réstant à payer</b></h4>{{$commande->credit}} Dhs
 </body>
    </html>