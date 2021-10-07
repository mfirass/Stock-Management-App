@extends('layouts.indexL')

@section('content')
<div class="page-header" style="background-image: url('../assets/img/stock.jpg');">
    <div class="filter"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 ml-auto mr-auto">
          <div class="card card-register">
            <h3 class="title mx-auto">Bienvenue</h3>
            <div class="social-line text-center">
                
            </div>
            <form method="POST" action="{{ route('login') }}" class="register-form">
            @csrf
              <label>Email</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" >
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              <label>Mot de passe</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mot de passe">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              <button type="submit" class="btn btn-danger btn-block btn-round">Se Connecter</button>
            </form>
            @if (Route::has('password.request'))
            <div class="forgot">
              <a href="{{route('password.request')}} " class="btn btn-link btn-danger">Mot de passe oublié?</a>
            </div>
            @endif
            @if(session()->has('error'))
                <script>
                  aFunction();
                </script>
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
          </div>
        </div>
      </div>
    </div>
@endsection
<script>
  function aFunction(){
    $(document).ready(function(){
      Swal.fire({
        title: "{{ session()->get('error') }}",
        type: 'error',
        showCancelButton: false,
        showConfirmButton: false,
        timer: 4000,
      })
    }); 
  }
</script>