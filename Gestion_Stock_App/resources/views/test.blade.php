          <!-- Tables -->
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title"><b>Les charges du magasin</b></h4>
                  <div class="card-category">
                    Les charges du magasin par mois 
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                      <tr>
                        <td class="text-info">
                          Salaire des employés
                        </td>
                        <td>
                          {{$salaire}} Dhs
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
                          {{$charges->loyers}} Dhs
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
                          {{$charges->assurance}} Dhs
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
                          {{$charges->frais_vehicule}} Dhs
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
                          {{$charges->frais_emballage}} Dhs
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
                          {{$charges->conception}} Dhs
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
                          {{$charges->autres}} Dhs
                        </td>
                      </tr>
                      <tr>
                        <td class="text-info">
                          Totale
                        </td>
                        <td>
                          {{$t}} Dhs
                        </td>
                      </tr>
                  </table>
                </div>
                <div class="row">
                  <div class="col-md-7"></div>
                  <div class="col-md-4">
                <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#modifierCharge">
                  <i class="material-icons">create</i>Editer les charges du magasin
                </button>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card">
                {{ $chart2->container() }}
              </div>
            </div>
          </div>
          <!-- EndTables -->
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