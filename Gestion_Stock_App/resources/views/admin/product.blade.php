@extends('layouts.adminHome')


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
                  <input type="text" value="" class="form-control search-input" placeholder="Chercher ..." data-table="customers-list">
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
            <table class="table table-hover customers-list">
              <br>
              <thead class=" text-success text-uppercase font-weight-bold">
                <th>
                  <b>Référence</b>
                </th>
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
                    {{ $product -> reference }}
                   </td>
                  <td>
                    {{ $product -> libelle }}
                  </td>
                  <td>
                    {{$product->category->libelle }}
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
                      <div class="badge {{ $quantite_reel > $quantite_min ? 'badge-info' : 'badge-danger'}}">{{ $quantite_reel > $quantite_min ? 'Disponible' : 'Faible'}}</div>
                  </td>
                  <td class="text-right td-actions">
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                      <button type="button" class="btn btn-info btn-link btn-sm" rel="tooltip" title="Details" data-toggle="modal" data-target="#product{{$product->id}}">
                        <i class="material-icons">info</i>&ensp;
                      </button>&ensp;
                    <button type="button" class="btn btn-success btn-link btn-sm btn-sm" rel="tooltip" title="Editer" data-toggle="modal" data-target="#productEdit{{$product->id}}"> 
                      <i class="material-icons">edit</i>&ensp;
                    </button>
                    &ensp;
                    <form action=" {{route('product.delete', $product -> id)}} " id="deleteProductForm{{ $product-> id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    </form>
                    <button type="button" class="btn btn-danger btn-link btn-sm btn-sm" rel="tooltip" title="Supprimer" id="deleteProductBtn{{ $product-> id }}"> 
                      <i class="material-icons">close</i>&ensp;
                    </button>
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

                  <!-- ProductEdit Modal -->
                  <div class="modal fade" id="productEdit{{$product->id}}">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="card">
                            <div class="card-header card-header-success">
                              <h4 class="card-title">Produit</h4>
                              <p class="card-category">Editer les informations du produit</p>
                            </div>
                            <div class="card-body">
                            <form method="POST" action="{{ route('product.update', $product->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="bmd-label-floating">Libelle</label>
                                    <input type="text" class="form-control @error('libelle') is-invalid @enderror"" name="libelle" value="{{ $product -> libelle }}">
                                    @error('libelle')
                                             <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                             </span>
                                    @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="bmd-label-floating">Référence</label>
                                    <input type="text" class="form-control @error('reference') is-invalid @enderror"" name="reference" value="{{ $product -> reference }}">
                                    @error('reference')
                                             <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                             </span>
                                    @enderror
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <div class="input-group-prepend">
                                          <label class="bmd-label-floating">Catégorie</label>
                                        </div>
                                        <select class="form-control form-control-sm custom-select form-control" data-style="btn btn-link" name="category" id="navbarDropdownCat"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-valuetext="{{ $product->category->libelle }}" required>
                                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                          @foreach ($categories as $category)
                                          <option class="dropdown-item" value="{{ $category -> id }}" {{ $category == $product -> category ? 'selected' : ''}} >
                                            {{ $category -> libelle }}
                                          </option>
                                          @endforeach
                                          </div>
                                        </select>
                                         @error('categorie')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                         @enderror
                                      </div>
                                    </div>
                                  </div>
                        
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label class="bmd-label-floating">La marque</label>
                                        <input type="text" id="marque" name="marque" class="form-control @error('marque') is-invalid @enderror" value=" {{ $product->marque }}">
                                        @error('marque')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label class="bmd-label-floating">Pois/Capacité</label>
                                        <input type="text" id="descriptif_technique" name="descriptif_technique" class="form-control @error('descriptif_technique') is-invalid @enderror" value="{{ $product -> descriptif_technique }}" required>
                                        @error('descriptif_technique')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label class="bmd-label-floating">La quantité minimum</label>
                                        <input type="number" id="quantite_min" name="quantite_min" class="form-control @error('quantite_min') is-invalid @enderror" value="{{ $quantite_min }}" required min="0">
                                        @error('quantite_min')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label class="bmd-label-floating">La quantité reel</label>
                                        <input type="number" id="quantite_reel" name="quantite_reel" class="form-control @error('quantite_reel') is-invalid @enderror" value="{{$quantite_reel}}" min="0">
                                        @error('quantite_reel')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                      </div>
                                    </div>
                                  </div>
                        
                        
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label class="bmd-label-floating">Prix d'achat</label>
                                        <input type="number" id="prix_achat" name="prix_achat" class="form-control @error('prix_achat') is-invalid @enderror" value=" {{ $product->prix_achat }} " step="any" min="0">
                                        @error('prix_achat')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                      </div>
                                    </div>
                                    <div class="col-md-6" style="margin-top: 3px">
                                      <div class="form-group">
                                      <select class="form-control form-control-sm form-control" data-style="btn btn-link" name="tva" id="tva" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <option value="" disabled selected>TVA</option>
                                        <option value="0" {{$product->tva == 0 ? 'selected' : ''}}>0%</option>
                                        <option value="7" {{$product->tva == 7 ? 'selected' : ''}}>7%</option>
                                        <option value="14" {{$product->tva == 14 ? 'selected' : ''}}>14%</option>
                                        <option value="20" {{$product->tva == 20 ? 'selected' : ''}}>20%</option>
                                      </select>
                                      </div>
                                    </div>
                                  </div>
                        
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label class="bmd-label-floating">Prix de vente pour Grossites</label>
                                        <input type="number" id="prix_vente_grossite" name="prix_vente_grossite" class="form-control @error('prix_vente_grossite') is-invalid @enderror" value="{{$product-> prix_vente_grossite}}" step="any" min="0">
                                        @error('prix_vente_grossite')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label class="bmd-label-floating">Prix de vente pour Détaillants</label>
                                        <input type="number" id="prix_vente_detaillant" name="prix_vente_detaillant" class="form-control @error('prix_vente_detaillant') is-invalid @enderror" value="{{$product-> prix_vente_detaillant}}" step="any" min="0">
                                        @error('prix_vente_detaillant')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                      </div>
                                    </div>
                                  </div>
                        
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label class="bmd-label-floating">Defectueux</label>
                                        <input type="number" id="defectueux" name="defectueux" class="form-control @error('defectueux') is-invalid @enderror" value=" {{ $defectueux }} " max="{{ $quantite_reel }}" min="0">
                                        @error('diffectueux')
                                           <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                      </div>
                                    </div>
                                  </div>
                        
                                  <br>
                                <button type="submit" class="btn btn-success pull-right">
                                  <i class="material-icons">edit</i>  Appliquer les changements
                                </button>
                                <div class="clearfix"></div>
                              </form>
                            </div>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- ProductDetails Modal -->
                  <div class="modal fade" id="product{{$product->id}}">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header card-header-info">
                                    <h4 class="card-title">{{$product -> libelle }} {{$product -> marque}} {{$product -> descriptif_technique }} </h4>
                                    <p class="category">{{ $product->category->libelle }} </p>
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
            <div class="mx-auto">
              {{$products->links()}}
            </div>
          </div>
      </div>
      </div>
</div>

    <div class="row mx-auto">
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header card-header-danger">
            <h4 class="card-title">Produit defectueux</h4>
            <p class="card-category">Tous les produits defectueux en stock</p>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-danger">
                <th>
                  Produit &ensp;&ensp;&ensp;
                </th>
                <th>
                  Défectueux
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
                    @if ($defectueux > 0)
                    <tr>
                      <td>
                        {{ $product->category->libelle }}&ensp;&ensp;{{ $product -> libelle }}&ensp;{{$product -> marque}}&ensp;{{$product -> descriptif_technique }}
                      </td>
                      <td>
                        {{ $defectueux }}
                      </td>
                      <td class="text-right td-actions">
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <form action="{{route('product.replace',$product)}}" method="POST">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-info btn-link btn-sm btn-sm" rel="tooltip" title="Remplacer par le fournisseur" id=""> 
                            <i class="material-icons">check</i>&ensp;
                        </form>
                        <form action="{{route('product.diff',$product)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-link btn-sm btn-sm" rel="tooltip" title="Supprimer la quantité défectueux" id=""> 
                          <i class="material-icons">close</i>&ensp;
                        </form>
                        </div>
                      </td>
                    </tr>
                    @endif
                @empty
                    <tr>
                       Il n'ya aucun produit defectueux en stock maintenent.
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title">Produits en état faible</h4>
            <p class="card-category">Tous les Produits en état faible en stock</p>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>Produit</th>
                <th>Quantité</th>
                <th>Qté Minimale</th>
                <th>Etat</th>
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
                  <td>
                    {{ $product -> libelle }} {{$product -> marque}}  type {{$product -> descriptif_technique }}
                  </td>
                  <td>
                    {{$quantite_reel}}
                  </td>
                  <td>
                    {{$quantite_min}}
                  </td>

                  <td>

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
    @if (Session::has('success'))
        <script>
          aFunction();
        </script>
    @endif
    @if (Session::has('error'))
        <script>
          bFunction();
        </script>
    @endif
@endsection


<!-- Filter table function -->
<script>
  (function(document) {
      'use strict';

      var TableFilter = (function(myArray) {
          var search_input;

          function _onInputSearch(e) {
              search_input = e.target;
              var tables = document.getElementsByClassName(search_input.getAttribute('data-table'));
              myArray.forEach.call(tables, function(table) {
                  myArray.forEach.call(table.tBodies, function(tbody) {
                      myArray.forEach.call(tbody.rows, function(row) {
                          var text_content = row.textContent.toLowerCase();
                          var search_val = search_input.value.toLowerCase();
                          row.style.display = text_content.indexOf(search_val) > -1 ? '' : 'none';
                      });
                  });
              });
          }

          return {
              init: function() {
                  var inputs = document.getElementsByClassName('search-input');
                  myArray.forEach.call(inputs, function(input) {
                      input.oninput = _onInputSearch;
                  });
              }
          };
      })(Array.prototype);

      document.addEventListener('readystatechange', function() {
          if (document.readyState === 'complete') {
              TableFilter.init();
          }
      });

  })(document);
</script>
<!-- Search -->
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
<!-- Errors handling -->
<script>
  function aFunction(){
    $(document).ready(function(){
      Swal.fire({
        title: "{{ session()->get('success') }}",
        type: 'success',
        showCancelButton: false,
        showConfirmButton: false,
        timer: 3000
      })
    });
  }

  function bFunction(){
    $(document).ready(function(){
      Swal.fire({
        title: "{{ session()->get('error') }}",
        type: 'error',
        showCancelButton: false,
        showConfirmButton: false,
      })
    });
  }
</script>
