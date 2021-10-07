@extends('layouts.adminHome')
@section('content')
<div class="row">
  <div class="col-md-3">
    <a href="{{route('demande.create')}}">
    <button class="btn btn-primary" rel="tooltip" title="Ajouter une commande">
      <i class="material-icons">create</i> &nbsp; Ajouter une commande client
    </button>
    </a>
  </div>
  <div class="col-md-4"></div>
  <div class="col-md-5">
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
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <br>
        <h2 style="margin-left: 12px">
          Devis
        </h2>
        <br>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table customers-list">
              <thead class=" text-primary font-weight-bold">
                <th>
                  Commande
                </th>
                <th>
                  Client
                </th>
                <th>
                  E-Mail
                </th>
                <th>
                  Type client
                </th>
                <th>
                  Date
                </th>
                <th>
                  Total TTC
                </th>
                <th>
                  Etat
                </th>
                <th>

                </th>
              </thead>
              <tbody>
                @forelse ($demandes as $demande)
                @if (! $demande->delivre )
                <tr>
                  <td>
                    {{ $demande->id }}
                  </td>
                  <td>
                    {{ $demande->client->nom }}
                  </td>
                  <td>
                    {{ $demande->client->email }}
                  </td>
                  <td class="text-uppercase">
                    <span class="badge {{$demande->client->type == 'grossiste' ? 'badge-info' : 'badge-warning'}} ">                    
                      {{ $demande->client -> type }}
                    </span>
                  </td>
                  <td class="">
                    {{ substr($demande -> created_at, 0, 10) }}
                  </td>
                  <td class="text-primary">
                    {{ $demande -> total }} Dhs
                  </td>
                  <td class="text-uppercase">
                    <span class="badge {{$demande->delivre == 1 ? 'badge-info' : 'badge-warning'}} ">                    
                      {{$demande->delivre == 1 ? 'delivré' : 'en cours'}}
                    </span>
                  </td>
                  <td class="text-right td-actions">
                    <div class="btn-group btn-group-sm" role="group">
                      <a href="{{route('demande.update',$demande->id)}}" class="btn btn-link btn-sm">
                        <button type="button"class="btn btn-link btn-sm btn-warning" rel="tooltip" title="Ajouter un produit au devis">
                          <i class="material-icons">edit</i>&ensp;
                        </button>&ensp;
                      </a>
                      <button type="button"class="btn btn-link btn-sm btn-info" rel="tooltip" title="Details du devis" data-toggle="modal" data-target="#demande{{$demande->id}}">
                        <i class="material-icons">info</i>&ensp;
                      </button>&ensp;
                      <a href="{{route('demande.pdf',$demande)}}" class="btn btn-link">
                        <button type="button" class="btn btn-link btn-sm btn-primary" rel="tooltip" title="Imprimer devis">
                          <i class="material-icons">content_paste</i>&ensp;
                        </button>
                      </a>&ensp;
                      <form action="{{route('demande.verifie',$demande)}}" method="POST" id="verify{{$demande->id}}">
                        @csrf
                        @method('PATCH')
                      </form>
                      <button type="button" class="btn btn-link btn-sm btn-success" rel="tooltip" title="Vérifier devis" id="verifie{{$demande->id}}">
                        <i class="material-icons">check</i>&ensp;
                      </button>
                      &ensp;
                      <form action="{{route('demande.delete',$demande->id)}}" method="POST" id="deleteForm{{$demande->id}}">
                      @csrf
                      @method('DELETE')
                      </form>
                      <button type="button" class="btn btn-sm btn-link btn-danger" rel="tooltip" title="Supprimer la demande" id="deleteBtn{{$demande->id}}">
                        <i class="material-icons">close</i>&ensp;
                      </button>
                    </div>
                  </td>
                </tr>  
                <script>
                  $(document).ready(function(){
                    $("#deleteBtn{{$demande->id}}").click(function(){
                      Swal.fire({
                    title: 'Confirmer de la suppression',
                    text: "Êtes-vous sûr de vouloir supprimer cette demande ? cette demande n'est pas encore delivré !",
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
                      $("#deleteForm{{$demande->id}}").submit();
                    }
                  })
                    });

                  $("#verifie{{$demande->id}}").click(function(){
                    $("#verify{{$demande->id}}").submit();
                  });
                      });
                  </script>
                @endif
                @empty
                    <tr>
                      <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background-color:#ffff66; color: black;">
                        <strong>Il n' y a aucune devis.</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    </tr>
                @endforelse
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <br>
      <h2 style="margin-left: 12px">Bons de livraison</h2>
      <br>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table customers-list">
            <thead class="text-primary font-weight-bold">
              <th>
                Commande
              </th>
              <th>
                Client
              </th>
              <th>
                E-Mail
              </th>
              <th>
                Type client
              </th>
              <th>
                Date
              </th>
              <th>
                Total TTC
              </th>
              <th>
                Etat
              </th>
              <th>

              </th>
            </thead>
            <tbody>
              @forelse ($demandes as $demande)
                  @if ($demande->delivre)
                      <tr>
                        <td>
                          {{ $demande->id }}
                        </td>
                        <td>
                          {{ $demande->client->nom }}
                        </td>
                        <td>
                          {{ $demande->client->email }}
                        </td>
                        <td class="text-uppercase">
                          <span class="badge {{$demande->client->type == 'grossiste' ? 'badge-info' : 'badge-warning'}} ">                    
                            {{ $demande->client->type }}
                          </span>
                        </td>
                        <td class="">
                          {{ substr($demande->created_at, 0, 10) }}
                        </td>
                        <td class="text-primary">
                          {{ $demande->total }} Dhs
                        </td>
                        <td class="text-uppercase">
                          <span class="badge {{$demande->delivre == 1 ? 'badge-info' : 'badge-warning'}} ">                    
                            {{$demande->delivre == 1 ? 'delivré' : 'en cours'}}
                          </span>
                        </td>
                        <td class="text-right td-actions">
                          <div class="btn-group btn-group-sm" role="group">
                            <button type="button"class="btn btn-link btn-sm btn-info" rel="tooltip" title="Details de la demande" data-toggle="modal" data-target="#demande{{$demande->id}}">
                              <i class="material-icons">info</i>&ensp;
                            </button>&ensp;
                            <a href="{{route('demande.pdf',$demande)}}" class="btn btn-link">
                              <button type="button" class="btn btn-link btn-sm btn-primary" rel="tooltip" title="Imprimer bon de livraison">
                                <i class="material-icons">content_paste</i>&ensp;
                              </button>
                            </a>
                            &ensp;
                            <!--
                            <button type="button" class="btn btn-link btn-sm btn-success" rel="tooltip" title="Ajouter montant" data-toggle="modal" data-target="#montant">
                              <i class="material-icons">attach_money</i>&ensp;
                            </button>
                            &ensp; -->
                            <form action="{{route('demande.delete',$demande->id)}}" method="POST" id="deleteForm{{$demande->id}}">
                            @csrf
                            @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-sm btn-link btn-danger" rel="tooltip" title="Supprimer devis" id="deleteBtn{{$demande->id}}">
                              <i class="material-icons">close</i>&ensp;
                            </button>
                          </div>
                        </td>
                      </tr>
                      <script>
                        $(document).ready(function(){
                          $("#deleteBtn{{$demande->id}}").click(function(){
                            Swal.fire({
                          title: 'Confirmer de la suppression',
                          text: "Êtes-vous sûr de vouloir supprimer cette demande ?",
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
                            $("#deleteForm{{$demande->id}}").submit();
                          }
                        })
                          });
                            });
                        </script>
                  @endif
              @empty
              <tr>
                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background-color:#ffff66; color: black;">
                  <strong>Il n' y a aucune demande.</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
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


<!-- details modal -->
@foreach ($demandes as $demande)
  <!-- The Modal -->
  <div class="modal fade" id="demande{{$demande->id}}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <!-- Modal body -->
        <div class="modal-body">
            <div class="card">
                <h3>Details de la demande {{$demande->id}}</h3>
                <div class="card-body">
                    <div class="card text-center">
                        <div class="card-header card-header-primary">
                            <h4>Général</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-description mx-auto">
                                {{$demande->created_at}} <br>
                                  Client :  <b class="text-uppercase"> 
                                 "{{$demande->client->nom}}" &ensp; "{{$demande->client->type}}" &ensp;
                                "{{$demande->client->telephone}}" &ensp; "{{$demande->client->email}}"</b> <br>
                            </p>
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="card-header card-header-success">
                            <h4>Produits</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table">
                                <thead class="">
                                    <th>Produit</th>
                                    <th>Magasin</th>
                                    <th>Quantité</th>
                                    <th>Total HT</th>
                                    <th>TVA</th>
                                </thead>
                                <tbody>
                                  @foreach ($test as $t)
                                  @if ($t->demande_id == $demande->id)
                                      <tr>
                                          <td>
                                              @php
                                                  $produit = App\Product::findOrFail($t->product_id);
                                              @endphp
                                              {{$produit->category->libelle}}&ensp;&ensp;{{$produit->libelle}}&ensp;{{$produit->marque}}&ensp;{{ $produit->descriptif_technique }}
                                          </td>
                                          <td>
                                            @php
                                                $s = App\Store::findOrFail($t->store_id);
                                            @endphp
                                              {{$s->ville}}
                                          </td>
                                          <td>
                                              @php
                                                  $q = $t->quantite;
                                              @endphp
                                              {{$q}}
                                          </td>
                                          <td>
                                              @php
                                              if($demande->client->type == 'grossiste')
                                              {
                                                  $n = $q * $t->prix_vente;
                                              }
                                              else
                                              {
                                                  $n = $q * $t->prix_vente;
                                              }
                                              @endphp
                                              {{$n}} Dhs
                                          </td>
                                          <td>
                                            {{$produit->tva}}%
                                          </td>
                                      </tr>
                                  @endif
                              @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="card text-center">
                       <h4><b>Total TTC</b></h4>
                      <div class="card-body">
                        {{$demande->total}} Dhs
                      </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Modal footer -->
      </div>
    </div>
@endforeach




<!-- ajouter montant modal -->
@foreach ($demandes as $demande)
<div class="modal fade" id="montant{{$demande->id}}">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content mx-auto">
      <div class="modal-body">
        <div class="card">
          <div class="card-header card-header-primary">
             <h4 class="card-title"><b>Paiement</b></h4>
             <p class="card-category">Ajouter paiement</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h5><b>Montant total à payer : {{$demande->total}} Dhs</b> </h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h5><b>Montant restant à payer : {{$demande->credit}} Dhs</b> </h5>
              </div>
            </div><br>
            <form action="{{route('demande.pay',$demande)}}" method="POST">
              @csrf
              @method('PATCH')
              <div class="row">
                <div class="col-md-12">
                   <h5><b>Mode de paiement :</b></h5>
                </div>
              </div>
              <div class="row">
                <div class="input-group col-md-4">
                  <div class="form-check form-group">
                    <label class="form-check-label">
                        <input class="form-check-input" id="mode_payment" name="mode_payment" type="checkbox" value="especes" required>
                          En Espèces
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
              </div>
              <div class="input-group col-md-4">
                <div class="form-check form-group">
                  <label class="form-check-label">
                      <input class="form-check-input" id="mode_payment" name="mode_payment" type="checkbox" value="cheque">
                        En Chèque
                      <span class="form-check-sign">
                          <span class="check"></span>
                      </span>
                  </label>
              </div>
            </div>
            <div class="input-group col-md-4">
              <div class="form-check form-group">
                <label class="form-check-label">
                    <input class="form-check-input" id="mode_payment" name="mode_payment" type="checkbox" value="virement">
                      En Virment
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
          </div>
              </div><br>
              <div class="row">
                <div class="col-md-12">
                   <h5><b>Montant payé :</b></h5>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Montant</label>
                    <input type="number" id="montant_paye" name="montant_paye" class="form-control" required step="any">
                  </div>
                </div>
              </div>
              <div class="">
                <button type="submit" class="btn btn-success pull-right">
                  <i class="material-icons">check</i>Ajouter montant payé
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach

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

  function myFunction1() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable1");
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

  function myFunction2(){
    myFunction();
    myFunction1();
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