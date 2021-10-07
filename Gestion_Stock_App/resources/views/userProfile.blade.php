@extends('layouts.userHome')

@section('content')
<div class="row">
    <div class="col-md-8">


      <div class="card">
        <div class="card-header card-header-info">
          <h4 class="card-title">Edit profil</h4>
          <p class="card-category">Completer votre profil</p>
        </div>
        <div class="card-body">
          <form method="POST" action="{{route('user.modifie',$user)}}">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                <label class="bmd-label-floating">Magasin {{$user->store->id}}</label>
                  <input type="text" class="form-control" disabled>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Nom</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{$user->name}}" name="name">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                 @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="bmd-label-floating">Adresse E-Mail</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}" name="email"> 
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                 @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="bmd-label-floating">Telephone</label>
                  <input type="tel" class="form-control @error('telephone') is-invalid @enderror" value="{{$user->telephone}}" name="telephone" id="telephone">
                  @error('telephone')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                 @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="bmd-label-floating">Mot de passe</label>
                  <input type="password" class="form-control @error('current_password') is-invalid @enderror" value="" name="current_password" id="current_password" required>
                  @error('current_password')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                 @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label class="bmd-label-floating">Nouveau mot de passe</label>
                  <input type="password" class="form-control @error('new_password') is-invalid @enderror" value="" name="new_password" id="new_password">
                  @error('new_password')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                 @enderror
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label class="bmd-label-floating">Confirmation du nouveau mot de passe</label>
                  <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" value="" name="password_confirm" id="password_confirm">
                  @error('password_confirm')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                 @enderror
                </div>
              </div>
            </div>

             <br>
            <button type="submit" class="btn btn-info pull-right">Modifier Profile</button>
            <div class="clearfix"></div>
          </form>
        </div>
      </div>

      
    </div>
    <div class="col-md-4">
      <div class="card card-profile">
        <div class="card-avatar">
          <a href="javascript:;">
            <br>
          </a>
        </div>
        <div class="card-body">
            <h6 class="card-category text-gray">{{ $user -> is_admin == 1 ? 'Administrateur' : 'Utilisateur'  }}</h6>
            <h4 class="card-title">{{ $user -> name }}</h4>
            <p class="card-description">
                Télephone : {{ $user -> telephone }} <br>
                E-Mail : {{ $user -> email }} <br>
                Membre depuis : {{ $user -> created_at }} <br>
            </p>
        </div>
      </div>
    </div>
  </div>
  @if(Session::has('success'))
  <script>
    aFunction();
  </script>
  @endif
  @if(Session::has('error'))
<script>
  bFunction();
</script>
@endif
@endsection
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