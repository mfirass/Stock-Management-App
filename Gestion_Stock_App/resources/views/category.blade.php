@extends('layouts.adminHome')

@section('content')
@foreach ($categories as $category)
<div class="row">
<div class="card card-nav-tabs" style="width: 20rem;">
  <div class="card-body">
    <h4 class="card-title">{{ $category -> libelle }}</h4>
    <h6 class="card-subtitle mb-2 text-muted"> Produits</h6>
    <p class="card-text">{{ $category -> description }}.</p>
    <div class="text-right row">
      <div class="col-md-4">
    <a href="#0" class="card-link">
      <button type="button" rel="tooltip" title="Lister les produits de {{ $category -> libelle }}" class="btn btn-info btn-link btn-sm">
        <i class="material-icons">subject</i> &nbsp;
      </button>
    </a>
       </div>
       <div class="col-md-4">
    <a href="#0" class="card-link">
      <button type="button" rel="tooltip" title="Modifier {{ $category -> libelle }}" class="btn btn-success btn-link btn-sm">
        <i class="material-icons">edit</i> &nbsp;
      </button>
    </a>
       </div>
       <div class="col-md-4">
    <a href="#0" class="card-link">
      <button type="button" rel="tooltip" title="Supprimer {{ $category -> libelle }}" class="btn btn-danger btn-link btn-sm">
        <i class="material-icons">close</i> &nbsp;
    </button>
    </a>
       </div>
  </div>
  </div>
</div>
</div>
@endforeach
@endsection