@extends('layouts.indexL')
 
@section('content')
<div class="page-header" style="background-image: url('../assets/img/stock.jpg');">
    <div class="filter"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 ml-auto mr-auto">
          <div class="card card-register">
            <h4 class="title mx-auto">Rénitialisation du mot de passe</h4>
            <div class="social-line text-center">
                
            </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                            <label for="email" class="">{{ __('E-Mail') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            <label for="password" class="">{{ __('Mot de passe') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            <label for="password-confirm" class="">{{ __('Confirmation du Mot de passe') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                <button type="submit" class="btn btn-danger btn-block btn-round">
                                    {{ __('Rénitialiser le mot de passe') }}
                                </button>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>

@endsection
