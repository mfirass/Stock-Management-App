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
                                      <option value="" disabled selected>Selectionner un Magasin ..</option>
                                      @foreach ($stores as $store)
                                      <option class="" value="{{ $store->id }}">Magasin{{ $store->id }}</option>
                                      @endforeach
                                  </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group" style="margin-top: 18px">
                                  <label class="bmd-label-floating">Fournisseur</label>
                                  <input type="text" class="form-control" name="fournisseur" id="fournisseur" list="f" required>
                                <datalist id="f">
                                    @foreach ($fournisseurs as $fournisseur)
                                    <option class="" value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-default" id="" rel="tooltip" title="Ajouter un nouveau fournisseur" data-toggle="modal" data-target="#addF">
                                <i class="material-icons">add</i>&ensp; Ajouter un fournisseur
                            </button>
                        </div>
                    </div>
                  </div>
                  <div id="fournisseurr" style="text-transform: uppercase; color:#669999; font-weight: bold;">

                  </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header card-header-success">
                     <h4>Produits</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="bmd-label-floating">Produit</label>
                                <input type="text" id="p" name="p" list="ps" class="form-control" required>
                                <datalist id="ps">
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
                </div>
            </div>
        </form>
        <div class="mx-auto text-center">
            <button type="button" class="btn btn-info" id="btnsubmit">
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
<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
        $(document).ready(function () {
        $("#btnsubmit").click(function(){
            $("#myform").prop("action",'{{route('commande.add')}}');
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

<!-- AddFournisseurModal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addF">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Fournisseurs</h4>
            <p class="card-category">Ajouter un nouveau fournisseur</p>
          </div>
          <div class="card-body modal-body">
            <form method="POST" action="{{ route('fournisseur.add') }}">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Nom du fournisseur</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
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
                    <label class="bmd-label-floating">E-Mail du fournisseur</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
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
                    <label class="bmd-label-floating">Telephone du fournisseur</label>
                    <input type="tel" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror">
                    @error('telephone')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">ICE</label>
                    <input type="number" id="ice" name="ice" class="form-control @error('ice') is-invalid @enderror">
                    @error('ice')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-info pull-right"><i class="material-icons">create</i>Ajouter le fournisseur</button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- End AddFournisseurrModal -->

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