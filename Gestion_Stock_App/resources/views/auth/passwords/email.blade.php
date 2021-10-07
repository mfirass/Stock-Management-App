@extends('layouts.indexL')

@section('content')
<div class="page-header" style="background-image: url('../assets/img/stock.jpg');">
    <div class="filter"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 ml-auto mr-auto">
          <div class="card card-register">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                Le lien de récupération a été envoyé.
            </div>
            @endif
            <h4 class="title mx-auto">Réinitialiser le mot de passe</h4>
            <div class="social-line text-center">
                
            </div>
            <form method="POST" action="{{ route('password.email') }}" class="register-form">
            @csrf
              <label>Email</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" >
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              <button type="submit" class="btn btn-danger btn-block btn-round">Envoyer le lien de réinitialisation</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection
