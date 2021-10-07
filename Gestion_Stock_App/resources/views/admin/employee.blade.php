@extends('layouts.adminHome')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-success">
          <h4 class="card-title "><b>Employees</b></h4>
          <p class="card-category"> Les employees des magasins</p>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-md-3">
              <button class="btn btn-success" rel="tooltip" title="Ajouter un nouveau employee" data-toggle="modal" data-target="#addemployee">
                <i class="material-icons">create</i> &nbsp; Ajouter un employee
              </button>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-4">
              <form class="navbar-form">
                <div class="input-group no-border">
                  <input type="text" value="" class="form-control search-input" placeholder="Chercher ..." data-table="customers-list">
                  <button type="submit" class="btn btn-white btn-round btn-just-icon">
                    <i class="material-icons">search</i>
                    <div class="ripple-container"></div>
                  </button>
                </div>
              </form>
            </div>
          </div>    <br>

          <div class="table-responsive">
            <table class="table customers-list">
              <thead class=" text-success font-weight-bold">
                <th>
                  Nom
                </th>
                <th>
                  Magasin
                </th>
                <th>
                  Telephone
                </th>
                <th>
                  E-Mail
                </th>
                <th>
                  Salaire
                </th>
                <th>

                </th>
              </thead>
              <tbody class="font-weight-light">
                @forelse ($employees as $employee)
                <tr>
                  <td>
                    {{ $employee -> nom }}
                  </td>
                  <td>
                    {{ $employee->store->ville }}
                  </td>
                  <td>
                    {{ $employee -> telephone }}
                  </td>
                  <td>
                    {{ $employee -> email }}
                  </td>
                  <td class="">
                    {{ $employee -> salaire }} Dhs
                  </td>
                  <td class="text-right td-actions">
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-info btn-link btn-sm" rel="tooltip" title="A propos" data-toggle="modal" data-target="#employee{{$employee->id}}">
                        <i class="material-icons">info</i>&ensp;
                      </button>&ensp;
                      <button type="button" rel="tooltip" title="Editer" class="btn btn-success btn-link btn-sm" data-toggle="modal" data-target="#employeeEdit{{$employee->id}}">
                        <i class="material-icons">edit</i>&ensp;
                      </button>
                      &ensp;
                    <form action="{{ route('employee.delete1', $employee->id) }}" method="POST" id="deleteemployeeForm{{ $employee -> id }}">
                      @csrf
                      @method('DELETE')
                    </form>  
                    <button type="button" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Supprimer" id="deleteemployeeBtn{{ $employee -> id }}"> 
                      <i class="material-icons">close</i>&ensp;
                    </button>
                    </div>
                  </td>
                </tr>

                <script>
                  $(document).ready(function(){
                    $("#deleteemployeeBtn{{$employee->id}}").click(function(){
                      Swal.fire({
                    title: 'Confirmer de la suppression',
                    text: "Êtes-vous sûr de vouloir supprimer ce employee ?",
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
                      $("#deleteemployeeForm{{$employee->id}}").submit();
                    }
                  })
                    });
                      });
                  </script>

                  <!-- employee Modal -->
                  <div class="modal fade" id="employee{{$employee->id}}">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <!-- Modal body -->
                        <div class="modal-body">
                          <div class="card card-profile">
                            <div class="card-body">
                            <h6 class="card-category text-gray">employee Magasin {{$employee->store->ville}}</h6>
                            <h4 class="card-title">{{ $employee -> nom }}</h4>
                              <p class="card-description mx-auto">
                                Télephone : {{ $employee -> telephone }} <br>
                                E-Mail : {{ $employee -> email }} <br>
                                Salaire : {{ $employee -> salaire }} Dhs<br>
                                Employee depuis : {{ $employee -> created_at }} <br>
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
                  <!-- employee Modal -->

                  <!-- Edit Modal -->
                  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="employeeEdit{{$employee->id}}">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="card">
                          <div class="card-header card-header-success">
                            <h4 class="card-title">employees</h4>
                            <p class="card-category">Editer les informations du employee</p>
                          </div>
                          <div class="card-body modal-body">
                            <form method="POST" action="{{ route('employee.update1',$employee->id) }}">
                              @csrf
                              @method('PUT')
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label class="bmd-label-floating">Nom de l'employee</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$employee->nom}}" required>
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
                                    <label class="bmd-label-floating">E-Mail du employee</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$employee->email}}" required>
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
                                    <label class="bmd-label-floating">Telephone du employee</label>
                                    <input type="tel" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="0{{$employee->telephone}}">
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
                                    <label class="bmd-label-floating">Salaire</label>
                                    <input type="text" id="salaire" name="salaire" class="form-control @error('salaire') is-invalid @enderror" value="{{$employee->salaire}}" required>
                                    @error('salaire')
                                       <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                    @enderror
                                  </div>
                                </div>
                              </div>
                              <button type="submit" class="btn btn-success pull-right"><i class="material-icons">create</i>Appliquer les changements</button>
                              <div class="clearfix"></div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Edit Modal -->

                @empty
                   <tr>Ce magasin n'a aucun employee</tr> 
                @endforelse
              </tbody>
            </table>
            {{ $employees->links() }}
          </div>
        </div>
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

<!-- AddemployeeModal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addemployee">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="card-header card-header-success">
          <h4 class="card-title">employees</h4>
          <p class="card-category">Ajouter un nouveau employee</p>
        </div>
        <div class="card-body modal-body">
          <form method="POST" action="{{route('employee.add1')}}">
            @csrf

            <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <div class="input-group-prepend">
                          <label class="bmd-label-floating">Magasin</label>
                        </div>
                        <select class="form-control form-control-sm form-control mselect" data-style="btn btn-link" name="store" id="store" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                            <option value="" disabled selected>Selectionner un Magasin ..</option>
                            @foreach ($stores as $store)
                            <option class="" value="{{ $store->id }}">Magasin{{ $store->id }}</option>
                            @endforeach
                        </select>
                  </div>
              </div>
          </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Nom de l'employee</label>
                  <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
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
                  <label class="bmd-label-floating">E-Mail du employee</label>
                  <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
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
                  <label class="bmd-label-floating">Telephone du employee</label>
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
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Salaire</label>
                    <input type="text" id="salaire" name="salaire" class="form-control @error('salaire') is-invalid @enderror" required>
                    @error('salaire')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
              </div>

            <button type="submit" class="btn btn-success pull-right"><i class="material-icons">create</i>Ajouter l'employee</button>
            <div class="clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End AddemployeerModal -->

<!-- Filter table function -->
<script>
  (function(document) {
      'use strict';

      var TableFilter = (function(myArray) {
          var search_input;

          function _onInputSearch(e) {
              search_input = e.target;
              var tables = document.getElementsByClassName(search_input.getAttribute('data-table'));
              myArray.forEach.call(tables, function(table) {
                  myArray.forEach.call(table.tBodies, function(tbody) {
                      myArray.forEach.call(tbody.rows, function(row) {
                          var text_content = row.textContent.toLowerCase();
                          var search_val = search_input.value.toLowerCase();
                          row.style.display = text_content.indexOf(search_val) > -1 ? '' : 'none';
                      });
                  });
              });
          }

          return {
              init: function() {
                  var inputs = document.getElementsByClassName('search-input');
                  myArray.forEach.call(inputs, function(input) {
                      input.oninput = _onInputSearch;
                  });
              }
          };
      })(Array.prototype);

      document.addEventListener('readystatechange', function() {
          if (document.readyState === 'complete') {
              TableFilter.init();
          }
      });

  })(document);
</script>
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