<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facture </title>
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
            Facture NO {{$Facture->id}} <br>
            {{$Facture->created_at}} <br>
            Client : {{$client->nom}}  <b style="text-transform: uppercase">{{$client->type}}</b> <br>
            Email : {{$client->email}} <br>
            Tel : {{$client->telephone}} <br>

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
                <th>Total</th>
            </tr>
            
                @foreach ($test1 as $t)
                <tr>
                        <td>
                            @php
                                $produit = App\Product::findOrFail($t->product_id);
                            @endphp
                           <p>{{$produit->category->libelle}} {{$produit->libelle}} {{$produit->marque}}</p> 
                        </td>
                        <td>
                            @php
                                $s = App\Store::findOrFail($t->store_id);
                            @endphp
                              <p>{{$s->ville}}</p>
                        </td>
                        <td>
                            @php
                                $q = $t->quantite;
                            @endphp
                             <p>{{$q}}</p>
                        </td>
                        <td>
                            @php
                            if($client->type == 'grossiste')
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
                    </tr>
            @endforeach
        </table>
    </div>
</body>
</html>