@extends('layouts.adminHome')

@section('content') 
<div class="card">
    <div class="card-header card-header-success">
      <h4 class="card-title">Utilisateur</h4>
      <p class="card-category">Modifer le profil de l'utilisateur</p>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col-md-10">
            <div class="form-group">
              <label class="bmd-label-floating">Nom</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user -> name }} " required>
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
                <label class="bmd-label-floating">E-mail</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user -> email }}" required>
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
                <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ is_null($user->telephone) ? '' : '0'.$user->telephone }}">
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
              <div class="form-check form-group">
                <label class="form-check-label">
                    <input class="form-check-input" id="is_admin" name="is_admin" type="checkbox" value="" {{ $user -> is_admin == 1 ? 'checked' : '' }}
                     onchange="document.getElementById('is_admin').value = this.checked ? 1 : 0">
                      Administrateur
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                </label>
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