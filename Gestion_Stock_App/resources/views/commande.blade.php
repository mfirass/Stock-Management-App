@extends('layouts.userHome')

@section('content')
<div class="row">
    <div class="col-md-7"></div>
    <div class="col-md-5">
      <form class="navbar-form">
        <div class="input-group no-border">
          <input type="text" value="" class="form-control" placeholder="Chercher par fournisseur..." id="myInput" onkeyup="myFunction2()">
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
            Commandes
          </h2>
          <br>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="myTable">
                <thead class=" text-info font-weight-bold">
                  <th>
                    Commande
                  </th>
                  <th>
                    Fournisseur
                  </th>
                  <th>
                    E-Mail
                  </th>
                  <th>
                    Date
                  </th>
                  <th>
                    Total
                  </th>
                  <th>
                    Etat
                  </th>
                  <th>
  
                  </th>
                </thead>
                <tbody>
                  @forelse ($commandes1 as $commande)
                  <tr>
                    <td>
                      {{ $commande->id }}
                    </td>
                    <td>
                      {{ $commande->fournisseur->nom }}
                    </td>
                    <td>
                      {{ $commande->fournisseur->email }}
                    </td>
                    <td class="">
                      {{ substr($commande -> created_at, 0, 10) }}
                    </td>
                    <td class="text-info">
                      {{ $commande -> total }} Dhs
                    </td>
                    <td class="text-uppercase">
                      <span class="badge {{$commande->delivre == 1 ? 'badge-info' : 'badge-warning'}} ">                    
                        {{$commande->delivre == 1 ? 'delivré' : 'en cours'}}
                      </span>
                    </td>
                    <td class="text-right td-actions">
                      <div class="btn-group btn-group-sm" role="group">
                        <button type="button"class="btn btn-link btn-sm btn-info" rel="tooltip" title="Details de la commande" data-toggle="modal" data-target="#commande{{$commande->id}}">
                          <i class="material-icons">info</i>Details&ensp;
                        </button>&ensp;
                      </div>
                    </td>
                  </tr>  
                  <script>
                    $(document).ready(function(){
                      $("#deleteBtn{{$commande->id}}").click(function(){
                        Swal.fire({
                      title: 'Confirmer de la suppression',
                      text: "Êtes-vous sûr de vouloir supprimer cette commande ? cette commande n'est pas encore delivré !",
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
                        $("#deleteForm{{$commande->id}}").submit();
                      }
                    })
                      });
                        });
                    </script>
                  @empty
                      <tr>
                          Il n' y a aucune commande.
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
@foreach ($commandes1 as $commande)
  <!-- The Modal -->
  <div class="modal fade" id="commande{{$commande->id}}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <!-- Modal body -->
        <div class="modal-body">
            <div class="card">
                <h3>Details de la commande {{$commande->id}}</h3>
                <div class="card-body">
                    <div class="card text-center">
                        <div class="card-header card-header-info">
                            <h4>Général</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-description mx-auto">
                                {{$commande->created_at}} <br>
                                  fournisseur :  <b class="text-uppercase"> 
                                 "{{$commande->fournisseur->nom}}" &ensp; "{{$commande->fournisseur->type}}" &ensp;
                                "{{$commande->fournisseur->telephone}}" &ensp; "{{$commande->fournisseur->email}}"</b> <br>
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
                                  @if ($t->commande_id == $commande->id)
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
                                                  $n = $q * $t->prix_achat;
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