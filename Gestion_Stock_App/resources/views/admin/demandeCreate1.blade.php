@extends('layouts.adminHome')
@section('content')
<div class="card">
        <br> <h2>&ensp; Ajouter une demande</h2>
    
    <div class="card-body">
        <form action="" method="POST" id="myform">
            @csrf
            <div class="card">
                <div class="card-header card-header-primary">
                     <h4 style="margin-bottom: 10px"><i>Client</i> </h4>
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
                                      <option class="" value="{{ $store->id }}" {{$store == $last_store ? 'selected' : ''}}>
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
                                  <label class="bmd-label-floating">Client</label>
                                </div>
                                <select class="form-control form-control-sm form-control mselect" data-style="btn btn-link" name="client" id="client" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <option class="" value="{{ $demande->client->id }}">{{ $demande->client->nom }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="client_type" style="text-transform: uppercase; color:#669999; font-weight: bold;">

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header card-header-success">
                     <h4 style="margin-bottom: 10px"><i>Produits</i> </h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="myform1">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Produit</label>
                                    <input type="text" name="p" id="p" required list="plist" class="form-control">
                                    <datalist class="" id="plist">
                                        @foreach ($products as $p)
                                            <option class="" value="{{ $p->id }}">
                                                {{ $p->category->libelle }}&ensp;&ensp;{{ $p->libelle }}&ensp;{{ $p->marque }}&ensp;{{ $p->descriptif_technique }}
                                            </option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 13px">
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
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="bmd-label-floating">Quantité</label>
                                <input type="number" name="quantite" id="quantite" class="form-control" value="1" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Prix de vente selon le type du client</label>
                                <input type="number" name="prix_vente" id="prix_vente" class="form-control" value="" min="0" step="any" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                              <label class="bmd-label-floating">TVA</label>
                              <input type="number" name="tva" list="tva" class="form-control" id="tvaa">
                              <datalist id="tva">
                              <option value="0">0%</option>
                              <option value="7">7%</option>
                              <option value="14">14%</option>
                              <option value="20">20%</option>
                              </datalist>
                            </div>
                          </div>
                    </div>
                    <br>
                    <div class="text-center mx-auto">
                        <button type="button" class="btn btn-primary" id="btnsubmit">
                            <i class="material-icons">add</i>&ensp; Ajouter Produit
                       </button>
                    </div>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 mx-auto">
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
        </form>
        <div class="mx-auto text-center">
            <a href="{{route('demande.fin')}}">
                <button type="button" class="btn btn-success">
                    <i class="material-icons">create</i>&ensp; Enregistrer la demande
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
            $("#myform").prop("action",'{{route('demande.addProduct', $demande)}}');
            $("#myform").submit();
        });

        $("#btnsubmit").click(function(){
            $("#myform1").prop("action",'{{route('demande.addProduct', $demande)}}');
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
    $("#client, #p").keyup(function(){
      //prix_vente($("#p").val(), $("#client").val());
      let produit = $("#p").val();
      let client = $("#client").val();
      $.get('/prix/'+produit+'/'+client,function(data){
        //alert(data);
        $("#data_produit").text(data['produit']);
        $("#prix_vente").val(data['prix']);
        $("#tvaa").val(data['tva']);
        $("#tvaa").focus();
        $("#prix_vente").focus();
        $("#client_type").text("Ce client est un "+data['type_client']);
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