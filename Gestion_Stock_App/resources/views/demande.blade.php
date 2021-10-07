@extends('layouts.userHome')

@section('content')
<div class="row">
    <div class="col-md-7"></div>
    <div class="col-md-5">
      <form class="navbar-form">
        <div class="input-group no-border">
          <input type="text" value="" class="form-control" placeholder="Chercher par client..." id="myInput" onkeyup="myFunction2()">
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
        <h2>
          Demandes
        </h2>
        <br>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="myTable">
              <thead class=" text-primary font-weight-bold">
                <th>
                  Demande
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
                  Total
                </th>
                
                <th>

                </th>
              </thead>
              <tbody>
                @forelse ($demandes2 as $demande)
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

                  <td class="text-right td-actions">
                    <div class="btn-group btn-group-sm" role="group">
                      <form method="POST" action="{{route('demande.verifie1', $demande->id)}}">
                        @csrf
                        @method('PUT')
                        <button type="submit"class="btn btn-link btn-sm btn-success" rel="tooltip" title="Vérifer la demande">
                          <i class="material-icons">check</i>Vérifier&ensp;
                        </button>
                      </form>
                      <button type="button"class="btn btn-link btn-sm btn-info" rel="tooltip" title="Details de la demande" data-toggle="modal" data-target="#demande{{$demande->id}}">
                        <i class="material-icons">info</i>Details&ensp;
                      </button>&ensp;    
                    </div>
                  </td>
                </tr>  
                @empty
                    <tr>
                        Il n' y a aucune demande.
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
      <h2>
        Demandes Vérifiées
      </h2>
      <br>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="myTable">
            <thead class=" text-primary font-weight-bold">
              <th>
                Demande
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
                Total
              </th>
              <th>

              </th>
            </thead>
            <tbody>
              @forelse ($demandes1 as $demande)
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
                <td class="text-right td-actions">
                  <div class="btn-group btn-group-sm" role="group">
                    <button type="button"class="btn btn-link btn-sm btn-info" rel="tooltip" title="Details de la demande" data-toggle="modal" data-target="#demande{{$demande->id}}">
                      <i class="material-icons">info</i>Details&ensp;
                    </button>&ensp;    
                  </div>
                </td>
              </tr>  
              @empty
                  <tr>
                      Il n' y a aucune demande vérifiée.
                  </tr>
              @endforelse
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<!-- details modal -->
@foreach ($demandes1 as $demande)
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
                                    <th></th>
                                </thead>
                                <tbody>
                                  @foreach ($test as $t)
                                  @if ($t->demande_id == $demande->id)
                                  @if ($t->store_id == $store->id)
                                      <tr>
                                          <td>
                                              @php
                                                  $produit = App\Product::findOrFail($t->product_id);
                                              @endphp
                                              {{$produit->category->libelle}}&ensp;&ensp;{{$produit->libelle}}&ensp;{{$produit->marque}}
                                          </td>
                                          <td>
                                               Magasin &ensp; {{$t->store_id}}
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
                                                  $n = $q * $produit->prix_vente_grossite;
                                              }
                                              else
                                              {
                                                  $n = $q * $produit->prix_vente_detaillant;
                                              }
                                              @endphp
                                              {{$n}} Dhs
                                          </td>
                                      </tr>
                                  @endif    
                                  @endif
                              @endforeach
                                </tbody>
                            </table>
                            </div>
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

<!-- details modal -->
@foreach ($demandes2 as $demande)
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
                                    <th></th>
                                </thead>
                                <tbody>
                                  @foreach ($test as $t)
                                  @if ($t->demande_id == $demande->id)
                                  @if ($t->store_id == $store->id)
                                      <tr>
                                          <td>
                                              @php
                                                  $produit = App\Product::findOrFail($t->product_id);
                                              @endphp
                                              {{$produit->category->libelle}}&ensp;&ensp;{{$produit->libelle}}&ensp;{{$produit->marque}}
                                          </td>
                                          <td>
                                               Magasin &ensp; {{$t->store_id}}
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
                                                  $n = $q * $produit->prix_vente_grossite;
                                              }
                                              else
                                              {
                                                  $n = $q * $produit->prix_vente_detaillant;
                                              }
                                              @endphp
                                              {{$n}} Dhs
                                          </td>
                                      </tr>
                                  @endif    
                                  @endif
                              @endforeach
                                </tbody>
                            </table>
                            </div>
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