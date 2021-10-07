@extends('layouts.adminHome')


@section('content')
@if(Session::has('success'))
<script>
  aFunction();
</script>
@endif
@if (Session::has('error'))
  <script>
    bFunction();
  </script>    
@endif
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-success">
          <h4 class="card-title "><b>Utilisateurs</b></h4>
          <p class="card-category">Utilisateurs de l'application</p>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-8"></div>
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
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-hover customers-list">
              <thead class=" text-success font-weight-bold">
                <th class="text-left">
                 <b>Nom</b> 
                </th>
                <th class="text-left">
                 <b>Role</b> 
                </th>
                <th class="text-left">
                 <b>Telephone</b> 
                </th>
                <th class="text-left">
                 <b>Email</b> 
                </th>
                <th class="text-left">
                 <b>Depuis</b> 
                </th>
                <th>
                  
                </th>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr class="">
                  <td class="text-left">
                    {{ $user -> name }}
                  </td>
                  <td class="text-left">
                    <div class=""><b>
                      @if ($user -> is_admin == 1)
                          <span class="badge badge-primary">Administrateur</span>
                      @else
                      <span class="badge badge-warning">Utilisateur</span>
                      @endif
                    </b></div>
                  </td>
                  <td class="text-left">
                    {{ is_null($user->telephone) ? '' : '0'.$user->telephone }}
                  </td>
                  <td class="text-left">
                   {{ $user -> email }} 
                  </td>
                  <td class="text-left">
                    {{ substr($user -> created_at, 0, 10) }}
                  </td>
                  <td class="text-right td-actions">
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                    <button type="button" class="btn btn-info btn-link btn-sm " rel="tooltip" title="Profile de l'utilisateur" data-toggle="modal" data-target="#userProfile{{$user->id}}">
                      <i class="material-icons">person</i>&ensp;
                    </button>&ensp;
                  <a href="{{ route('user.edit', $user->id) }}" class="btn btn-link">
                    <button type="button" rel="tooltip" title="Editer" class="btn btn-success btn-link btn-sm ">
                      <i class="material-icons">edit</i>&ensp;
                    </button></a>
                    &ensp;
                  <form action="{{ route('user.delete', $user->id) }}" method="POST" id="deleteUserForm{{ $user -> id }}">
                    @csrf
                    @method('DELETE')
                  </form>  
                  <button type="button" class="btn btn-danger btn-link btn-sm p-2" rel="tooltip" title="Supprimer l'utilisateur" id="deleteUserBtn{{ $user -> id }}"> 
                    <i class="material-icons">close</i>&ensp;
                  </button>
                </div>
                </td>
                </tr>
                <script>
                  $(document).ready(function(){
                    $("#deleteUserBtn{{$user->id}}").click(function(){
                      Swal.fire({
                    title: 'Confirmer de la suppression',
                    text: "Êtes-vous sûr de vouloir supprimer cet utilisateur ?",
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
                      $("#deleteUserForm{{$user->id}}").submit();
                    }
                  })
                    });
                      });
                  </script>

                    <!-- The Modal -->
                  <div class="modal fade" id="userProfile{{$user->id}}">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                      
                        <!-- Modal Header -->
                        <!-- Modal body -->
                        <div class="modal-body">
                          <div class="card card-profile">
                            <div class="card-avatar">
                              <a href="javascript:;">
                                <br>
                              </a>
                            </div>
                            <div class="card-body">
                              <h6 class="card-category text-gray">{{ $user -> is_admin == 1 ? 'Administrateur' : 'Utilisateur'  }}</h6>
                            <h4 class="card-title">{{ $user -> name }}</h4>
                              <p class="card-description mx-auto">
                                Télephone : {{ is_null($user->telephone) ? '' : '0'.$user->telephone }} <br>
                                E-Mail : {{ $user -> email }} <br>
                                Membre depuis : {{ $user -> created_at }} <br>
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
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection


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