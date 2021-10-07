@extends('layouts.adminHome')
@section('content')
<div class="card">
        <br> <h2>&ensp; Ajouter une commande du client</h2>
    
    <div class="card-body">
        <form action="" method="POST" id="myform">
            @csrf
            <div class="card">
                <div class="card-header card-header-primary">
                     <h4 style="margin-bottom: 10px"><i>Client</i></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group-prepend">
                                    <label class="bmd-label-floating">Magasin</label>
                                  </div>
                                  <select class="form-control form-control-sm form-control mselect" data-style="btn btn-link" name="store" id="store" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                                      <option disabled selected>Selectionner un Magasin ..</option>
                                      @foreach ($stores as $store)
                                      <option class="" value="{{ $store->id }}">{{ $store->ville }}</option>
                                      @endforeach
                                  </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group" style="margin-top: 18px">
                                  <label class="bmd-label-floating">Client</label>
                                  <input type="text" name="client" id="client" list="clients" class="form-control">
                                <datalist class="" id="clients">
                                    @foreach ($clients as $client)
                                    <option class="" value="{{ $client->id }}">{{ $client->nom }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                                <button type="button" class="btn btn-default" id="" rel="tooltip" title="Ajouter un nouveau client" data-toggle="modal" data-target="#addClient">
                                    <i class="material-icons">add</i>&ensp; Ajouter un client
                                </button>
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
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group" style="margin-top: 18px">
                                <label class="bmd-label-floating">Produit</label>
                                <input type="text" name="p" list="p" class="form-control" id="pr">
                                <datalist id="p">
                                    @foreach ($products as $p)
                                        <option class="" value="{{ $p->id }}" aria-placeholder="{{ $p->libelle }}&ensp;{{ $p->marque }}&ensp;{{ $p->descriptif_technique }}">
                                           {{ $p->libelle }}&ensp;{{ $p->marque }}&ensp;{{ $p->descriptif_technique }}
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="col-md-3" style="">
                          <div class="form-group">
                                <button type="button" class="btn btn-default" id="" rel="tooltip" title="Ajouter un nouveau produit" data-toggle="modal" data-target="#addproduct">
                                    <i class="material-icons">add</i>&ensp; Ajouter un produit
                                </button>
                        </div>
                        </div>
                    </div>
                    <div id="data_produit" style="text-transform: uppercase; color:#669999; font-weight: bold;">

                    </div><br>
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
                </div>
            </div>
        </form>
        <div class="mx-auto text-center">
            <button type="button" class="btn btn-primary" id="btnsubmit">
                 <i class="material-icons">add</i>&ensp; Ajouter Produit
            </button>
            <br> <br>
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

<!-- AddClientModal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addClient">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Clients</h4>
            <p class="card-category">Ajouter un nouveau client</p>
          </div>
          <div class="card-body modal-body">
            <form method="POST" action="{{ route('client.add') }}">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Nom du client</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
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
                    <label class="bmd-label-floating">E-Mail du client</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
                    @error('email')
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
                    <label class="bmd-label-floating">Telephone du client</label>
                    <input type="tel" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror">
                    @error('telephone')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
              </div>
              
              <div class="row">
              <div class="input-group col-md-12">
                <div class="form-check form-group form-check-inline">
                  <label class="form-check-label">
                      <input class="form-check-input" id="" name="type" type="radio" value="grossiste">
                        Grossiste
                      <span class="form-check-sign">
                          <span class="check"></span>
                      </span>
                  </label>
              </div> &emsp; &emsp;
              <div class="form-check form-group form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" id="" name="type" type="radio" value="detaillant">
                      Détaillant
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
              </div>
              </div>
  
              <button type="submit" class="btn btn-primary pull-right"><i class="material-icons">create</i>Ajouter le client</button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- End AddClientrModal -->

<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
        $(document).ready(function () {
        $("#btnsubmit").click(function(){
            $("#myform").prop("action",'{{route('demande.add')}}');
            $("#myform").submit();
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
$("#client, #pr").keyup(function(){
  //prix_vente($("#p").val(), $("#client").val());
  let produit = $("#pr").val();
  let client = $("#client").val();
  $.get('/prix/'+produit+'/'+client,function(data){
    //alert(data);
    $("#data_produit").text(data['produit']);
    $("#prix_vente").val(data['prix']);
    $("#tvaa").val(data['tva']);
    $("#tvaa").focus();
    $("#prix_vente").focus();
    //console.log(data['client_type']);
  });
}); 

$("#client").keyup(function(){
  let client = $("#client").val();
  $.get('/type/'+client,function(data){
    $("#client_type").text(data);
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
