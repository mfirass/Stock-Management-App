@extends('layouts.adminHome')
@section('content')
<div class="row">
  <div class="col-md-3">
    <a href="{{route('commande.create')}}">
    <button class="btn btn-info" rel="tooltip" title="Ajouter une demande">
      <i class="material-icons">create</i> &nbsp; Ajouter une demande
    </button>
    </a>
  </div>
  <div class="col-md-4"></div>
  <div class="col-md-5">
    <form class="navbar-form">
      <div class="input-group no-border">
        <input type="text" class="form-control search-input" placeholder="Chercher ..." data-table="customers-list"
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
          Demandes en cours
        </h2>
        <br>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table customers-list">
              <thead class=" text-info font-weight-bold">
                <th>
                  Demande
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
                  Total TTC
                </th>
                <th>
                  Etat
                </th>
                <th>

                </th>
              </thead>
              <tbody>
                @forelse ($commandes as $commande)
                @if (! $commande->delivre )
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
                      <a href="{{route('commande.update',$commande->id)}}" class="btn btn-link btn-sm">
                        <button type="button"class="btn btn-link btn-sm btn-info" rel="tooltip" title="Ajouter un produit à la demande">
                          <i class="material-icons">edit</i>&ensp;
                        </button>&ensp;
                      </a>
                      <button type="button"class="btn btn-link btn-sm btn-info" rel="tooltip" title="Details de la demande" data-toggle="modal" data-target="#commande{{$commande->id}}">
                        <i class="material-icons">info</i>&ensp;
                      </button>&ensp;
                      <form action="{{route('commande.verifie',$commande)}}" method="POST" class="btn btn-link btn-sm">
                        @csrf
                        @method('PATCH')
                      <button type="submit" class="btn btn-link btn-sm btn-success" rel="tooltip" title="Vérifier la demande">
                        <i class="material-icons">check</i>&ensp;
                      </button>
                      &ensp;
                      </form>
                      <form action="{{route('commande.delete',$commande->id)}}" method="POST" id="deleteForm{{$commande->id}}">
                      @csrf
                      @method('DELETE')
                      </form>
                      <button type="button" class="btn btn-sm btn-link btn-danger" rel="tooltip" title="Supprimer la demande" id="deleteBtn{{$commande->id}}">
                        <i class="material-icons">close</i>&ensp;
                      </button>
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
                @endif
                @empty
                    <tr>
                        Il n' y a aucune demande en cours.
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
      <h2>Demandes vérifiées</h2>
      <br>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="myTable1">
            <thead class="text-info font-weight-bold">
              <th>
                Demande
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
              @forelse ($commandes as $commande)
                  @if ($commande->delivre)
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
                          {{ substr($commande->created_at, 0, 10) }}
                        </td>
                        <td>
                          {{ $commande->total }} Dhs
                        </td>
                        <td class="text-uppercase">
                          <span class="badge {{$commande->delivre == 1 ? 'badge-info' : 'badge-warning'}} ">                    
                            {{$commande->delivre == 1 ? 'delivré' : 'en cours'}}
                          </span>
                        </td>
                        <td class="text-right td-actions">
                          <div class="btn-group btn-group-sm" role="group">
                            <button type="button"class="btn btn-link btn-sm btn-info" rel="tooltip" title="Details de la demande" data-toggle="modal" data-target="#commande{{$commande->id}}">
                              <i class="material-icons">info</i>&ensp;
                            </button>&ensp;
                            <a href="{{route('commande.pdf',$commande)}}" class="btn btn-link">
                              <button type="button" class="btn btn-link btn-sm btn-primary" rel="tooltip" title="Imprimer la facture">
                                <i class="material-icons">content_paste</i>&ensp;
                              </button>
                            </a>
                            &ensp;
                            <form action="{{route('commande.delete',$commande->id)}}" method="POST" id="deleteForm{{$commande->id}}">
                            @csrf
                            @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-sm btn-link btn-danger" rel="tooltip" title="Supprimer la commande" id="deleteBtn{{$commande->id}}">
                              <i class="material-icons">close</i>&ensp;
                            </button>
                          </div>
                        </td>
                      </tr>
                      <script>
                        $(document).ready(function(){
                          $("#deleteBtn{{$commande->id}}").click(function(){
                            Swal.fire({
                          title: 'Confirmer de la suppression',
                          text: "Êtes-vous sûr de vouloir supprimer cette commande ?",
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
                  @endif
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
@foreach ($commandes as $commande)
  <!-- The Modal -->
  <div class="modal fade" id="commande{{$commande->id}}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <!-- Modal body -->
        <div class="modal-body">
            <div class="card">
                <h3>Details de la demande {{$commande->id}}</h3>
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
                                      <tr>
                                          <td>
                                              @php
                                                  $produit = App\Product::findOrFail($t->product_id);
                                              @endphp
                                              {{$produit->category->libelle}}&ensp;&ensp;{{$produit->libelle}}&ensp;{{$produit->marque}}
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
                                                  $n = $q * $t->prix_achat;
                                              @endphp
                                              {{$n}} Dhs
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
                       <h4><b>Total</b></h4>
                      <div class="card-body">
                        {{$commande->total}} Dhs
                        @if ($commande->delivre)
                            <br>
                            <h4><b>Réstant à payer</b></h4>{{$commande->credit}} Dhs
                            <h4><b>Paiements</b></h4>
                            <div class="table-responsive">
                              <table class="table">
                                <thead>
                                  <th>Montant payé</th>
                                  <th>Mode paiement</th>
                                  <th>Date</th>
                                </thead>
                                <tbody>
                            @foreach ($paiements as $paiement)
                            @if ($paiement->commande_id == $commande->id)
                                  <tr>
                                    <td>{{$paiement->montant_paye}} Dhs</td>
                                    <td class="text-uppercase">{{$paiement->mode_paiement}}</td>
                                    <td>{{$paiement->created_at}}</td>
                                  </tr>
                            @endif
                            @endforeach
                                </tbody>
                              </table>
                            </div> 
                        @endif
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

<!-- verification modal -->
@foreach ($commandes as $commande)
<div class="modal fade" id="verifie{{$commande->id}}">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content mx-auto">
      <div class="modal-body">
        <div class="card">
          <div class="card-header card-header-info">
             <h4 class="card-title"><b>Vérifier</b></h4>
             <p class="card-category">Vérifier la commande</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h5><b>Montant total : {{$commande->total}} Dhs</b> </h5>
              </div>
            </div><br>
            <form action="{{route('commande.verifie',$commande)}}" method="POST">
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
                      En Virement
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
                    <input type="number" id="montant_paye" name="montant_paye" class="form-control" step="any" required>
                  </div>
                </div>
              </div>
              <div class="">
                <button type="submit" class="btn btn-success pull-right">
                  <i class="material-icons">check</i>Vérifier la commande
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


<!-- ajouter montant modal -->
@foreach ($commandes as $commande)
<div class="modal fade" id="montant{{$commande->id}}">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content mx-auto">
      <div class="modal-body">
        <div class="card">
          <div class="card-header card-header-info">
             <h4 class="card-title"><b>Paiement</b></h4>
             <p class="card-category">Ajouter paiement</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h5><b>Montant total à payer : {{$commande->total}} Dhs</b> </h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h5><b>Montant restant à payer : {{$commande->credit}} Dhs</b> </h5>
              </div>
            </div><br>
            <form action="{{route('commande.pay',$commande)}}" method="POST">
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
                    <input type="number" id="montant_paye" name="montant_paye" class="form-control" step="any" required>
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