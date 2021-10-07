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
                  <input type="text" class="form-control" value="{{$user->name}}" name="name">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="bmd-label-floating">Adresse E-Mail</label>
                  <input type="email" class="form-control" value="{{$user->email}}" name="email"> 
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="bmd-label-floating">Telephone</label>
                  <input type="tel" class="form-control" value="{{$user->telephone}}" name="telephone">
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
            <img class="img" src="{{$user->image}}" />
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

@endsection


<!-- verification modal -->
@foreach ($demandes as $demande)
<div class="modal fade" id="verifie{{$demande->id}}">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content mx-auto">
      <div class="modal-body">
        <div class="card">
          <div class="card-header card-header-primary">
             <h4 class="card-title"><b>Vérifier</b></h4>
             <p class="card-category">Vérifier la demande</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h5><b>Montant total : {{$demande->total}} Dhs</b> </h5>
              </div>
            </div><br>
            <form action="{{route('demande.verifie',$demande)}}" method="POST">
              @csrf
              @method('PATCH')
              <div class="row">
                <div class="col-md-12">
                   <h5><b>Mode de paiement :</b></h5>
                </div>
              </div>
              <div class="row">
                <div class="input-group col-md-4">
                  <div class="form-check form-group">
                    <label class="form-check-label">
                        <input class="form-check-input" id="mode_payment" name="mode_payment" type="checkbox" value="especes" required>
                          En Espèces
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
              </div>
              <div class="input-group col-md-4">
                <div class="form-check form-group">
                  <label class="form-check-label">
                      <input class="form-check-input" id="mode_payment" name="mode_payment" type="checkbox" value="cheque">
                        En Chèque
                      <span class="form-check-sign">
                          <span class="check"></span>
                      </span>
                  </label>
              </div>
            </div>
            <div class="input-group col-md-4">
              <div class="form-check form-group">
                <label class="form-check-label">
                    <input class="form-check-input" id="mode_payment" name="mode_payment" type="checkbox" value="virement">
                      En Virement
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
          </div>
              </div><br>
              <div class="row">
                <div class="col-md-12">
                   <h5><b>Montant payé :</b></h5>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Montant</label>
                    <input type="text" id="montant_paye" name="montant_paye" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="">
                <button type="submit" class="btn btn-success pull-right">
                  <i class="material-icons">check</i>Vérifier la demande
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach


<!-- Paiements Details -->
@if ($demande->delivre)
<br>
<h4><b>Réstant à payer</b></h4>{{$demande->credit}} Dhs
<h4><b>Paiements</b></h4>
<div class="table-responsive">
  <table class="table">
    <thead>
      <th>Montant payé</th>
      <th>Mode paiement</th>
      <th>Date</th>
    </thead>
    <tbody>
@foreach ($paiements as $paiement)
@if ($paiement->demande_id == $demande->id)
      <tr>
        <td>{{$paiement->montant_paye}} Dhs</td>
        <td class="text-uppercase">{{$paiement->mode_paiement}}</td>
        <td>{{$paiement->created_at}}</td>
      </tr>
@endif
@endforeach
    </tbody>
  </table>
</div> 
@endif