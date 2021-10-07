@extends('layouts.adminHome')
@section('content')
<div class="card">
        <br> <h2>&ensp; Ajouter une commande</h2>
    
    <div class="card-body">
        <form action="" method="POST" id="myform">
            @csrf
            <div class="card">
                <div class="card-header card-header-info">
                     <h4>Fournisseur</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group-prepend">
                                    <label class="bmd-label-floating">Magasin</label>
                                  </div>
                                  <select class="form-control form-control-sm form-control mselect" data-style="btn btn-link" name="store" id="store" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                                      @foreach ($stores as $store)
                                      <option class="" value="{{ $store->id }}" {{$store == $last_store ? 'selected' : ''}} >
                                        Magasin &ensp;{{ $store->id }}
                                      </option>
                                      @endforeach
                                  </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group-prepend">
                                  <label class="bmd-label-floating">Fournisseur</label>
                                </div>
                                <select class="form-control form-control-sm form-control mselect" data-style="btn btn-link" name="fournisseur" id="fournisseur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <option class="" value="{{ $commande->fournisseur->id }}">{{ $commande->fournisseur->nom }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header card-header-success">
                     <h4>Produits</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="myform1">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Produit</label>
                                    <input type="text" class="form-control" id="p" name="p" list="pr" required>
                                    <datalist id="pr">
                                        @foreach ($products as $p)
                                            <option class="" value="{{ $p->id }}">
                                                {{ $p->category->libelle }}&ensp;&ensp;{{ $p->libelle }}&ensp;{{ $p->marque }}&ensp;{{ $p->descriptif_technique }}
                                            </option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <button type="button" class="btn btn-default" id="" rel="tooltip" title="Ajouter un nouveau produit" data-toggle="modal" data-target="#addproduct">
                                      <i class="material-icons">add</i>&ensp; Ajouter un produit
                                  </button>
                                </div>
                              </div>
                        </div>
                        <div id="data_produit" style="text-transform: uppercase; color:#669999; font-weight: bold;">

                        </div><br>
                    </form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Quantité</label>
                                <input type="number" name="quantite" id="quantite" class="form-control" value="1" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Prix d'achat</label>
                                <input type="number" name="prix_a" id="prix_a" class="form-control" min="0" step="any" required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>Produit</th>
                                                <th>Magasin</th>
                                                <th>Quantité</th>
                                                <th>Total</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($test as $t)
                                                    @if ($t->commande_id == $commande->id)
                                                        <tr>
                                                            <td>
                                                                @php
                                                                    $produit = App\Product::findOrFail($t->product_id);
                                                                @endphp
                                                                {{$produit->category->libelle}}&ensp;&ensp;{{$produit->libelle}}&ensp;{{$produit->marque}}&ensp;{{ $p->descriptif_technique }}
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
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="card text-center">
                                <h4><b>Total</b></h4>
                               <div class="card-body">
                                 {{$commande->total}} Dhs
                               </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="mx-auto text-center">
            <button type="button" class="btn btn-info" id="btnsubmit">
                 <i class="material-icons">add</i>&ensp; Ajouter Produit
            </button>
            <br>
            <a href="{{route('commande.fin')}}">
                <button type="button" class="btn btn-success">
                    <i class="material-icons">create</i>&ensp; Enregistrer la commande
                </button>
            </a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
        $(document).ready(function () {
        $("#btnsubmit").click(function(){
            $("#myform").prop("action",'{{route('commande.addProduct', $commande)}}');
            $("#myform").submit();
        });

        $("#btnsubmit").click(function(){
            $("#myform1").prop("action",'{{route('commande.addProduct', $commande)}}');
            $("#myform1").submit();
        });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.17/js/bootstrap-select.min.js"></script>
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
  <script>

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    });
    
    $(document).ready(function(){
    $("#fournisseur, #p").keyup(function(){
      //prix_vente($("#p").val(), $("#client").val());
      let produit = $("#p").val();
      let fournisseur = $("#fournisseur").val();
      $.get('/prix-a/'+produit+'/'+fournisseur,function(data){
        //alert(data);
        $("#data_produit").text(data['produit']);
        $("#prix_a").val(data['prix']);
        $("#tvaa").val(data['tva']);
        $("#tvaa").focus();
        $("#prix_a").focus();
        $("#fournisseurr").text(data['fournisseur']);
        //console.log(data['client_type']);
      });
    }); 
    });
    
    
    function prix_vente(produit, client){
    
      $.get("/prix/"+client+"/"+produit,function(data){
        console.log(data);
      });
    /*  $.ajax({
             url: "prix/"+client+"/"+produit,
             type: 'get',
             dataType: 'json',
             success: function(response){
    
               var prix = 0;
               prix = response['data']; // prix de vente
              $("#prix_vente").val() = prix ;
              }
              });*/
    }
  </script>