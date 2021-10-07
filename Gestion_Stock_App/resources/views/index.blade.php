@extends('layouts.indexL')


@section('content')
  <div id="heading">
    <div class="page-header" data-parallax="true" style="background-image: url('../assets/img/stock.jpg');">
      <div class="filter"></div>
      <div class="container">
        <div class="motto text-center">
          <h1><b>CONTRÔLEUR DES STOCKS</b></h1>
          <h3><b><i>Pour une bonne gestion de votre stock.</i></b></h3>
          <br />
          <a href="{{ route('login') }}"><button type="button" class="btn btn-outline-neutral btn-round">Se Connecter Maintenant !</button></a>
        </div>
      </div>
    </div>
  </div>
@endsection