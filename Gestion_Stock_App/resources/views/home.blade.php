@extends('layouts.userHome')


@section('content')
          <!-- Statistisues -->
          <div class="row">

            <div class="col-md-1">
            </div>
            <div class="col-md-5">
              <div class="card">
                {{$chart->container()}}
              </div>
            </div>

            <div class="col-md-5">
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
                        <td class="text-info" style="font-size: 18px">
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
                        <td class="text-info" style="font-size: 18px">
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
                        <td class="text-info" style="font-size: 18px">
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
                        <td class="text-info" style="font-size: 18px">
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
                        <td class="text-info" style="font-size: 18px">
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
                        <td class="text-info" style="font-size: 18px">
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
                        <td class="text-info" style="font-size: 18px">
                          Autres
                        </td>
                        <td>

                        </td>
                      </tr>
                      <tr>
                        <td class="text-info" style="font-size: 18px">
                          Totale
                        </td>
                        <td>
                          {{$t}} Dhs
                        </td>
                      </tr>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-1">
            </div>
          </div>
          <!-- EndStatistiques -->

          <!-- Tables -->
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">

              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card">

              </div>
            </div>
          </div>
          <!-- EndTables -->

          {{$chart->script()}}
@endsection
