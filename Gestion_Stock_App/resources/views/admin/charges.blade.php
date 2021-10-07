@extends('layouts.adminHome')

@section('content')
<!-- Tables -->
<div class="row">
<div class="col-md-12">
    <div class="card">
    <div class="card-header card-header-info">
        <h4 class="card-title"><b>Les charges du magasin</b></h4>
        <div class="card-category">
        Les charges du magasin par mois 
        </div>
    </div>
    <div class="card-body table-responsive">
        <div class="row">
            <div class="col-md-3">
              <button class="btn btn-info" rel="tooltip" title="" data-toggle="modal" data-target="#modifierCharge">
                <i class="material-icons">create</i> &nbsp; Editer les charges
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
          </div> <br>
        <table class="table table-hover customers-list">
            <tr>
            <td class="text-info">
                Salaire des employés
            </td>
            <td>
                {{is_null($salaire) ? '0Dhs' : $salaire.'Dhs'}}
                @php
                    $t = 0;
                    $t = $salaire; 
                @endphp
            </td> 
            </tr>
            <tr>
            <td class="text-info">
                Loyers du magasin
            </td>
            <td>
                {{is_null($charges->loyers) ? '0Dhs' : $charges->loyers.'Dhs'}} 
                @php
                    $t += $charges->loyers;
                @endphp
            </td>
            </tr>
            <tr>
            <td class="text-info">
                Assurance
            </td>
            <td>
                {{is_null($charges->assurance) ? '0Dhs' : $charges->assurance.'Dhs'}}
                @php
                $t += $charges->assurance;
                @endphp
            </td>
            </tr>
            <tr>
            <td class="text-info">
                Frais Véhicule
            </td>
            <td>
                {{is_null($charges->frais_vehicule) ? '0Dhs' : $charges->frais_vehicule.'Dhs'}}
                @php
                $t += $charges->frais_vehicule;
                @endphp
            </td>
            </tr>
            <tr>
            <td class="text-info">
                Frais Emballage
            </td>
            <td>
                {{is_null($charges->frais_emballage) ? '0Dhs' : $charges->frais_emballage.'Dhs'}}
                @php
                $t += $charges->frais_emballage;
                @endphp
            </td>
            </tr>
            <tr>
            <td class="text-info">
                Conception
            </td>
            <td>
                {{is_null($charges->conception) ? '0Dhs' : $charges->conception.'Dhs'}}
                @php
                $t += $charges->conception;
                @endphp
            </td>
            </tr>
            <tr>
            <td class="text-info">
                Autres
            </td>
            <td>
                {{is_null($charges->autres) ? '0Dhs' : $charges->autres.'Dhs'}}
            </td>
            </tr>
            <tr>
            <td class="text-info">
                Total
            </td>
            <td class="text-warning">
                <b>{{is_null($t) ? '0Dhs' : $t.'Dhs'}}</b>
            </td>
            </tr>
        </table>
    </div>
    <!--
    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-4">
    <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#modifierCharge">
        <i class="material-icons">create</i>Editer les charges des magasins
    </button>
        </div> -->
    </div>
    </div>
</div>
</div>
@endsection

<div class="modal fade" id="modifierCharge">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <!-- Modal body -->
        <div class="modal-body">
          <div class="card">
            <div class="card-header card-header-info">
              Les charges du magasin
            </div>
            <div class="card-body">
              <form action="{{route('charge.update',$charges)}}" method="POST" id="myform">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Loyers</label>
                    <input type="text" id="loyers" name="loyers" class="form-control @error('loyers') is-invalid @enderror" value="{{$charges->loyers}}">
                    @error('loyers')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Assurance</label>
                    <input type="text" id="assurance" name="a" class="form-control @error('assurance') is-invalid @enderror" value="{{$charges->assurance}}">
                    @error('a')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Frais Véhicule</label>
                    <input type="text" id="frais_vehicule" name="frais_vehicule" class="form-control @error('frais_vehicule') is-invalid @enderror" value="{{$charges->frais_vehicule}}">
                    @error('frais_vehicule')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Frais Emballage</label>
                    <input type="text" id="frais_emballage" name="frais_emballage" class="form-control @error('frais_emballage') is-invalid @enderror" value="{{$charges->frais_emballage}}">
                    @error('frais_emballage')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Conception</label>
                    <input type="text" id="conception" name="conception" class="form-control @error('conception') is-invalid @enderror" value="{{$charges->conception}}">
                    @error('conception')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Autres</label>
                    <input type="text" id="autres" name="autres" class="form-control @error('autres') is-invalid @enderror" value="{{$charges->autres}}">
                    @error('autres')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                    @enderror
                  </div>
                </div>
              </div>
              
        <button type="submit" class="btn btn-info pull-right" id="mybtn">
          <i class="material-icons">create</i>Appliquer les chagement
        </button></form>
            </div>
          </div>
        </div>
        <!-- Modal footer -->
        
      </div>
    </div>
</div>

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