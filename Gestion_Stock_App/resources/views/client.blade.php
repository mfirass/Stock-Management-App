@extends('layouts.userHome')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title "><b>Clients</b></h4>
          <p class="card-category">Les clients du magasin</p>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-md-3">
              <button class="btn btn-primary" rel="tooltip" title="Ajouter un nouveau client" data-toggle="modal" data-target="#addClient">
                <i class="material-icons">create</i> &nbsp; Ajouter un Client
              </button>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-4">
              <form class="navbar-form">
                <div class="input-group no-border">
                  <input type="text" value="" class="form-control" placeholder="Chercher un client par nom ..." id="myInput" onkeyup="myFunction()">
                  <button type="submit" class="btn btn-white btn-round btn-just-icon">
                    <i class="material-icons">search</i>
                    <div class="ripple-container"></div>
                  </button>
                </div>
              </form>
            </div>
          </div>    <br>

          <div class="table-responsive">
            <table class="table" id="myTable">
              <thead class=" text-primary font-weight-bold">
                <th>
                  Nom
                </th>
                <th>
                  Telephone
                </th>
                <th>
                  E-Mail
                </th>
                <th>
                  Type
                </th>
                <th>
                  Crédit
                </th>
                <th>

                </th>
              </thead>
              <tbody class="font-weight-light">
                @forelse ($clients as $client)
                <tr>
                  <td>
                    {{ $client -> nom }}
                  </td>
                  <td>
                    {{ $client -> telephone }}
                  </td>
                  <td>
                    {{ $client -> email }}
                  </td>
                  <td class="text-uppercase">
                    <span class="badge {{$client->type == 'grossiste' ? 'badge-info' : 'badge-warning'}} ">                    
                      {{ $client -> type }}
                    </span>
                  </td>
                  <td class="{{ $client -> credit > 0 ? 'text-danger' : 'text-primary' }}">
                    {{ $client -> credit }} Dhs
                  </td>
                  <td class="text-right td-actions">
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-info btn-link btn-sm" rel="tooltip" title="A propos" data-toggle="modal" data-target="#client{{$client->id}}">
                        <i class="material-icons">info</i>&ensp;
                      </button>&ensp;
                      <button type="button" rel="tooltip" title="Editer" class="btn btn-success btn-link btn-sm" data-toggle="modal" data-target="#clientEdit{{$client->id}}">
                        <i class="material-icons">edit</i>&ensp;
                      </button>
                      &ensp;
                    <form action="{{ route('client.delete1', $client->id) }}" method="POST" id="deleteClientForm{{ $client -> id }}">
                      @csrf
                      @method('DELETE')
                    </form>  
                    <button type="button" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Supprimer" id="deleteClientBtn{{ $client -> id }}"> 
                      <i class="material-icons">close</i>&ensp;
                    </button>
                    </div>
                  </td>
                </tr>

                <script>
                  $(document).ready(function(){
                    $("#deleteClientBtn{{$client->id}}").click(function(){
                      Swal.fire({
                    title: 'Confirmer de la suppression',
                    text: "Êtes-vous sûr de vouloir supprimer ce Client ?",
                    type: 'warning',
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonColor: '#e60000',
                    cancelButtonColor: '#d7d7c1',
                    reverseButtons: true,
                    focusCancel: true,
                    confirmButtonText: 'Oui, Supprimer',
                    cancelButtonText: 'Fermer'
                  }).then((result) => {
                    if (result.value) {
                      $("#deleteClientForm{{$client->id}}").submit();
                    }
                  })
                    });
                      });
                  </script>

                  <!-- Client Modal -->
                  <div class="modal fade" id="client{{$client->id}}">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <!-- Modal body -->
                        <div class="modal-body">
                          <div class="card card-profile">
                            <div class="card-body">
                              <h6 class="card-category text-gray">Client &ensp; {{ $client->type }}</h6>
                            <h4 class="card-title">{{ $client -> nom }}</h4>
                              <p class="card-description mx-auto">
                                Télephone : {{ $client -> telephone }} <br>
                                E-Mail : {{ $client -> email }} <br>
                                Crédit : {{ $client -> credit }} Dhs<br>
                                Client depuis : {{ $client -> created_at }} <br>
                              </p>
                            </div>
                          </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <!-- Client Modal -->

                  <!-- Edit Modal -->
                  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="clientEdit{{$client->id}}">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="card">
                          <div class="card-header card-header-primary">
                            <h4 class="card-title">Clients</h4>
                            <p class="card-category">Editer les informations du client</p>
                          </div>
                          <div class="card-body modal-body">
                            <form method="POST" action="{{ route('client.update1',$client->id) }}">
                              @csrf
                              @method('PUT')
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label class="bmd-label-floating">Nom du client</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$client->nom}}">
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
                                    <label class="bmd-label-floating">E-Mail du client</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$client->email}}">
                                    @error('email')
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
                                    <label class="bmd-label-floating">Telephone du client</label>
                                    <input type="tel" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="0{{$client->telephone}}">
                                    @error('telephone')
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
                                    <label class="bmd-label-floating">Crédit</label>
                                    <input type="tel" id="telephone" name="credit" class="form-control @error('credit') is-invalid @enderror" value="{{$client->credit}}">
                                    @error('credit')
                                       <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                    @enderror
                                  </div>
                                </div>
                              </div>
                              
                              <div class="row">
                              <div class="input-group col-md-12">
                                <div class="form-check form-group form-check-inline">
                                  <label class="form-check-label">
                                      <input class="form-check-input" id="" name="type" type="radio" value="grossiste" {{$client->type == 'grossiste' ? 'checked' : ''}}>
                                        Grossiste
                                      <span class="form-check-sign">
                                          <span class="check"></span>
                                      </span>
                                  </label>
                              </div> &emsp; &emsp;
                              <div class="form-check form-group form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" id="" name="type" type="radio" value="detaillant" {{$client->type == 'detaillant' ? 'checked' : ''}} >
                                      Détaillant
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                              </div>
                              </div>
                  
                              <button type="submit" class="btn btn-primary pull-right"><i class="material-icons">create</i>Appliquer les changements</button>
                              <div class="clearfix"></div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Edit Modal -->

                @empty
                   <tr>Ce magasin n'a aucun client</tr> 
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection

<!-- AddClientModal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addClient">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">Clients</h4>
          <p class="card-category">Ajouter un nouveau client</p>
        </div>
        <div class="card-body modal-body">
          <form method="POST" action="{{ route('client.add1') }}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Nom du client</label>
                  <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
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
                  <label class="bmd-label-floating">E-Mail du client</label>
                  <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
                  @error('email')
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
                  <label class="bmd-label-floating">Telephone du client</label>
                  <input type="tel" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror">
                  @error('telephone')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
            </div>
            
            <div class="row">
            <div class="input-group col-md-12">
              <div class="form-check form-group form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" id="" name="type" type="radio" value="grossiste">
                      Grossiste
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                </label>
            </div> &emsp; &emsp;
            <div class="form-check form-group form-check-inline">
              <label class="form-check-label">
                  <input class="form-check-input" id="" name="type" type="radio" value="detaillant">
                    Détaillant
                  <span class="form-check-sign">
                      <span class="check"></span>
                  </span>
              </label>
          </div>
            </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right"><i class="material-icons">create</i>Ajouter le client</button>
            <div class="clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End AddClientrModal -->

<script>
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
</script>