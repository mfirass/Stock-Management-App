@extends('layouts.adminHome')

@section('content') 
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
            <input type="text" class="form-control @error('libelle') is-invalid @enderror"" name="libelle" value="{{ $product -> libelle }}" required>
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
            <input type="text" class="form-control @error('referenece') is-invalid @enderror"" name="referenece" value="{{ $product -> referenece }}" required>
            @error('referenece')
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
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-valuetext="{{ $product -> category -> libelle }}" required>
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
                <input type="text" id="marque" name="marque" class="form-control @error('marque') is-invalid @enderror" value=" {{ $product -> marque }}" required>
                @error('marque')
                   <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                   </span>
                @enderror
              </div>
            </div>
            <div class="col-md-4">
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

          @php
            $quantite_reel = App\Product::quantite_reel($product);
            $quantite_min = App\Product::quantite_min($product);
            $defectueux = App\Product::defectueux($product); 
          @endphp
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="bmd-label-floating">La quantité minimum</label>
                <input type="number" id="quantite_min" name="quantite_min" class="form-control @error('quantite_min') is-invalid @enderror" value=" {{ $quantite_min }} " required>
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
                <input type="number" id="quantite_reel" name="quantite_reel" class="form-control @error('quantite_reel') is-invalid @enderror" value=" {{ $quantite_reel }} " required>
                @error('quantite_reel')
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
                <label class="bmd-label-floating">Prix d'achat</label>
                <input type="number" id="prix_achat" name="prix_achat" class="form-control @error('prix_achat') is-invalid @enderror" value=" {{ $product -> prix_achat }} " required step="any">
                @error('prix_achat')
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
                <label class="bmd-label-floating">Prix de vente pour Grossites</label>
                <input type="number" id="prix_vente_grossite" name="prix_vente_grossite" class="form-control @error('prix_vente_grossite') is-invalid @enderror" value="{{$product-> prix_vente_grossite}}" required step="any">
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
                <input type="number" id="prix_vente_detaillant" name="prix_vente_detaillant" class="form-control @error('prix_vente_detaillant') is-invalid @enderror" value="{{$product-> prix_vente_detaillant}}" required step="any">
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
@endsection