@extends('layouts.userHome')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-success">
          <h4 class="card-title "><b>Produits</b></h4>
          <p class="card-category"> Tout les produits en stock.</p>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-4">
              <form class="navbar-form">
                <div class="input-group no-border">
                  <input type="text" value="" class="form-control" placeholder="Chercher un produit par catégorie ..." id="myInput" onkeyup="myFunction()">
                  <button type="submit" class="btn btn-white btn-round btn-just-icon">
                    <i class="material-icons">search</i>
                    <div class="ripple-container"></div>
                  </button>
                </div>
              </form>
            </div>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-hover" id="myTable">
              <br>
              <thead class=" text-success text-uppercase font-weight-bold">
                <th>
                  <b>Libelle</b>
                </th>
                <th>
                  <b>Catégorie</b>
                </th>
                <th>
                  <b>Marque</b>
                </th>
                <th>
                 <b>Pois/Capacité</b> 
                </th>
                <th>
                 <b>Quantité</b> 
                </th>
                <th>
                 <b>Etat</b> 
                </th>
                <th>
                  
                </th>
              </thead>
              <tbody>
                @forelse ($products as $product)
                @php
                    $quantite_reel = App\Product::quantite_reel($product);
                    $quantite_min = App\Product::quantite_min($product);
                    $defectueux = App\Product::defectueux($product);
                @endphp
                 <tr>
                  <td>
                    {{ $product -> libelle }}
                  </td>
                  <td>
                    {{ $product -> category ->libelle }}
                  </td>
                  <td>
                    {{ $product -> marque }}
                  </td>
                  <td>
                    {{ $product -> descriptif_technique }}
                  </td>
                  <td class="">
                    {{ $quantite_reel }}
                  </td>

                  <td class="">

                  </td>
                  <td class="text-right td-actions">
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                      <button type="button" class="btn btn-info btn-link btn-sm" rel="tooltip" title="Details du produit" data-toggle="modal" data-target="#product{{$product->id}}">
                        <i class="material-icons">info</i>&ensp;
                      </button>&ensp;
                    <button type="button" class="btn btn-success btn-link btn-sm btn-sm" rel="tooltip" title="Editer la quantité min et max" data-toggle="modal" data-target="#productEdit{{$product->id}}"> 
                      <i class="material-icons">edit</i>&ensp;
                    </button>
                    &ensp;
                    </div>
                  </td>
                </tr>   
                <script>
                  $(document).ready(function(){
                    $("#deleteProductBtn{{$product->id}}").click(function(){
                      Swal.fire({
                    title: 'Confirmer de la suppression',
                    text: "Êtes-vous sûr de vouloir supprimer ce produit ?",
                    type: 'warning',
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonColor: '#e60000',
                    cancelButtonColor: '#d7d7c1',
                    reverseButtons: true,
                    focusCancel: true,
                    confirmButtonText: 'Oui, Supprimer',
                    cancelButtonText: 'Fermer'
                  }).then((result) => {
                    if (result.value) {
                      $("#deleteProductForm{{$product->id}}").submit();
                    }
                  })
                    });
                      });
                  </script>

                  <!-- The Modal -->
                  <div class="modal fade" id="product{{$product->id}}">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                      
                        <!-- Modal Header -->
                        <!-- Modal body -->
                        <div class="modal-body">
                          
                          
                            <div class="card">
                                <div class="card-header card-header-info">
                                    <h4 class="card-title">{{$product -> libelle }} {{$product -> marque}} {{$product -> descriptif_technique }} </h4>
                                    <p class="category">{{ $product -> category -> libelle }} </p>
                                </div>
                                <div class="card-body">
                                    <p class="mx-auto card-description">
                                      {{ $product -> libelle }} de marque {{$product -> marque}} et de type {{$product -> descriptif_technique }} <br>
                                      <span class="badge {{ $quantite_reel > $quantite_min ? 'badge-success' : 'badge-danger'}}">
                                        {{ $quantite_reel > $quantite_min ? 'ETAT NORMALE' : 'ETAT FAIBLE'}}</span> <br>
                                        Quantité disponible : {{$quantite_reel}} <br>
                                        Quantité Minimale : {{$quantite_min}} <br>
                                        Nombre des produit defectueux : <span class="badge {{ $defectueux == 0 ? 'badge-success' : 'badge-danger'}}">
                                          {{ $defectueux }}</span> <br>
                                        Prix d'achat : {{$product->prix_achat}} Dhs <br>
                                        Prix de vente pour GROSSISTE : {{$product-> prix_vente_grossite}} Dhs <br>
                                        Prix de vente pour DETAILLANT : {{$product-> prix_vente_detaillant}} Dhs <br>
                                    </p>
                                </div>
                            </div>
                          

                        </div>
                        </div>
                        <!-- Modal footer -->
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="productEdit{{$product->id}}">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="card">
                            <h3>Quantité Minimale</h3>
                            <div class="card-body">
                              <form action="{{route('product.update1', $product->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="bmd-label-floating">La quantité minimale</label>
                                      <input type="number" id="quantite_min" name="quantite_min" class="form-control @error('quantite_min') is-invalid @enderror" value="{{ $quantite_min }}" min="0">
                                      @error('quantite_min')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                         </span>
                                      @enderror
                                    </div>
                                  </div>
                                </div>
                                <button type="submit" class="btn btn-success pull-right"><i class="material-icons">create</i>Modifier</button>
                                <div class="clearfix"></div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @empty
                  <tr>
                    Il n'y a aucune produit en stock maintenant.
                  </tr>
                @endforelse
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

<div class="row mx-auto text-center">

  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-danger">
        <h4 class="card-title">Produits en état faible</h4>
        <p class="card-category">Tous les Produits en état faible en stock</p>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-hover">
          <thead class="text-danger">
            <th>Produit &ensp;</th>
            <th>Quantité &ensp;</th>
            <th>Quantité Minimale &ensp;</th>
            <th>Etat &ensp;</th>
          </thead>
          <tbody>
            @forelse ($products as $product)
            @php
            $quantite_reel = App\Product::quantite_reel($product);
            $quantite_min = App\Product::quantite_min($product);
            $defectueux = App\Product::defectueux($product);
            @endphp
            @if ($quantite_reel < $quantite_min)
            <tr>
              <td class="text-center">
                {{ $product -> libelle }}&ensp;{{$product -> marque}}&ensp; type {{$product -> descriptif_technique }}
              </td>
              <td class="text-center">
                {{$quantite_reel}}
              </td>
              <td class="text-center">
                {{$quantite_min}}
              </td class="text-center">
              @php
                  $a=App\Product::quantite_pourcentage($product);
              @endphp
              <td class="text-center">
                <div class="progress" style="height: 10px">
                  <div class="progress-bar bg-danger" role="progressbar" style="width:{{$a}}% ; height:10px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </td>
            </tr>
            @endif
            @empty
                <tr> Il n'y a aucun produit en état faible en stock. </tr> 
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection


<script>
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
</script>
