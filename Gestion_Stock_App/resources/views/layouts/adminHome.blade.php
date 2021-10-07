<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('../assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('../assets/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title> Stock Controller </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.17/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  
  <!-- CSS Files -->
  <link href="{{ asset('../css/bootstrap.css') }}" rel="stylesheet" />
  <link href="{{ asset('../assets/css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
  <link href="{{ asset('../css/mon_style.css') }}" rel="stylesheet" />
</head>

<body class="">

    <!-- SideBar -->
    <div class="wrapper ">
      <div class="sidebar" data-color="green" data-background-color="white" data-image="{{asset('../assets/img/sidebar-3.jpg')}}">
        <div class="logo"><a href="{{ route('admin.home') }}" class="simple-text logo-normal">
            T-CREATIVE
          </a></div>
        <div class="sidebar-wrapper">
          <ul class="nav">
            <li class="{{ Request::is('admin/home*') ? 'nav-item active' : 'nav-item'}}" >
            <a class="nav-link" href="{{ route('admin.home') }}">
                <i class="material-icons">dashboard</i>
                <p>Accueil</p>
              </a>
            </li> 
            <li class="{{ Request::is('admin/users*') ? 'nav-item active' : 'nav-item'}}">
              <a class="nav-link" href="{{ route('admin.users') }}">
                <i class="material-icons">person</i>
                <p>Utilisateurs</p>
              </a>
            </li>
            <li class="{{ Request::is('admin/products*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{ route('admin.produits') }}">
                <i class="material-icons">category</i>
                <p>Stock</p>
              </a>
            </li>
            <li class="{{ Request::is('admin/demandes*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{ route('admin.demandes') }}">
                <i class="material-icons">content_paste</i>
                <p>Commandes Clients</p>
              </a>
            </li>
            <li class="{{ Request::is('admin/commandes*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{ route('admin.commandes') }}">
                <i class="material-icons">content_paste</i>
                <p>Commandes Fournisseurs</p>
              </a>
            </li>
            <li class="{{ Request::is('admin/clients*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{ route('admin.clients') }}">
                <i class="material-icons">person</i>
                <p>Clients</p>
              </a>
            </li>
            <li class="{{ Request::is('admin/fournisseurs*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{ route('admin.fournisseurs') }}">
                <i class="material-icons">person</i>
                <p>Fournisseurs</p>
              </a>
            </li>
            <li class="{{ Request::is('admin/employees*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{route('admin.employees')}}">
                <i class="material-icons">person</i>
                <p>Employés</p>
              </a>
            </li>
            <li class="{{ Request::is('admin/charges*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{route('charges')}}">
                <i class="material-icons">analytics</i>
                <p>Charges</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    <!-- EndSideBar -->


    <div class="main-panel">


      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">
              @if ( Request :: is('admin/home*') )
                  Accueil
              @endif
              @if ( Request :: is('admin/users*') )
                  Utilisateurs
              @endif
              @if ( Request :: is('admin/categories*') )
                  Catégories
              @endif
              @if ( Request :: is('admin/products*') )
                  Stock
              @endif
              @if ( Request :: is('admin/clients*') )
                  Clients
              @endif
              @if ( Request :: is('admin/fournisseurs*') )
                  Fournisseurs
              @endif
              @if ( Request :: is('admin/demandes*') )
                  Commandes Client
              @endif
              @if ( Request :: is('admin/commandes*') )
                  Demandes
              @endif
              @if ( Request :: is('admin/charges*') )
              Charges
              @endif
              
            </a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            {{ Auth::user()->name }} &ensp;
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="{{route('admin.home')}} ">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Statistique
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="{{route('admin.profil', Auth::user())}} ">Profile</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                   Déconnectez-vous
               </a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                   @csrf
               </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->


      <div class="content">
        <div class="container-fluid">

          <!-- Options -->
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">person</i>
                  </div>
                  <p class="card-category">Ajouter</p>
                  <h4 class="card-title"><b>Utilisateur</b></h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  <a href="#adduser" data-toggle="modal">
                    Ajouter un nouveau employe du stock.
                  </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">Revenu</p>
                  <h4 class="card-title"><b>{{$revenu}} Dhs</b></h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i>Ce jour.
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">category</i>
                  </div>
                  <p class="card-category">Ajouter</p>
                  <h4 class="card-title"><b>Catégorie</b></h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <a href="" data-toggle="modal" data-target="#addcategory">
                       Ajouter une nouvelle catégorie.</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">add_shopping_cart</i>
                  </div>
                  <p class="card-category">Ajouter</p>
                  <h4 class="card-title"><b>Produit</b></h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                   <a href="" data-toggle="modal" data-target="#addproduct">
                      Ajouter un nouveau produit.</a> 
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- EndOptions -->

          @yield('content')
          
        </div>
      </div>

      <!-- Footer -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>,
            T-CREATIVE.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- EndFooter -->

  <!-- Plugin -->

  <!-- EndPlugin -->

  <!-- Modals -->
<!-- AddUserModal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="adduser">
  <div class="modal-dialog modal-lg modal-signup modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="card-header card-header-success">
          <h4 class="card-title">Utilisateurs</h4>
          <p class="card-category">Ajouter un chef de stock</p>
        </div>
        <div class="card-body modal-body">
          <form method="POST" action="{{ route('admin.users') }}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Nom de l'utilisateur</label>
                  <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required>
                  @error('name')
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
                  <label class="bmd-label-floating">Email</label>
                  <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" required>
                  @error('email')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Telephone</label>
                  <input type="tel" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{old('telephone')}}">
                  @error('telephone')
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
                  <label class="bmd-label-floating">Mot de passe</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                  @error('password')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating"> Confirmer le mot de passe</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                </div>
              </div>
            </div>

            
            <div class="row">
            <div class="input-group col-md-5">
              <div class="form-check form-group">
                <label class="form-check-label">
                    <input class="form-check-input" id="is_admin" name="is_admin" type="checkbox" value="" onchange="document.getElementById('is_admin').value = this.checked ? 1 : 0">
                      Administrateur
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
            </div>
          </div>

            <button type="submit" class="btn btn-success pull-right"><i class="material-icons">create</i>Ajouter l'utilisateur</button>
            <div class="clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End AdduserModal -->

<!-- AddCategoryModal --> 
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addcategory">
  <div class="modal-dialog modal-lg modal-signup modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="card-header card-header-success">
          <h4 class="card-title">Catégories</h4>
          <p class="card-category">Ajouter une catégorie</p>
        </div>
        <div class="card-body modal-body">
        <form method="POST" action="{{ route('category.add') }}">
            @csrf
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="bmd-label-floating">Libelle</label>
                  <input type="text" id="libelle" name="libelle" class="form-control @error('libelle') is-invalid @enderror" required>
                  @error('libelle')
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
                  <label class="bmd-label-floating">Description</label>
                  <textarea type="" id="description" name="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                  @error('description')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-success pull-right"><i class="material-icons">create</i>Ajouter la catégorie</button>
            <div class="clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End AddCategoryModal -->

<!-- AddProductModal -->    
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addproduct">
  <div class="modal-dialog modal-lg modal-signup modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="card-header card-header-success">
          <h4 class="card-title">Produits</h4>
          <p class="card-category">Ajouter un produit au stock</p>
        </div>
        <div class="card-body modal-body">
        <form method="POST" action="{{ route('produits.add') }}">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Libelle</label>
                  <input type="text" id="libelle" name="libelle" class="form-control @error('libelle') is-invalid @enderror" required>
                  @error('libelle')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Référence</label>
                  <input type="text" id="reference" name="reference" class="form-control @error('reference') is-invalid @enderror" required>
                  @error('reference')
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
                  <div class="input-group-prepend">
                    <label class="bmd-label-floating">Catégorie</label>
                  </div>
                  <div class="">
                  <select class="form-control form-control-sm form-control" data-style="btn btn-link" name="category" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="myFunction0()" required>
                    <option value="" disabled selected>Selectionner une catégorie ..</option>
                    @foreach ($categories as $category)
                    <option class="dropdown-item" value="{{ $category -> id }}">{{ $category -> libelle }}</option>
                    @endforeach
                  </select>
                </div>
                   @error('categorie')
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
                  <label class="bmd-label-floating">La marque</label>
                  <input type="text" id="marque" name="marque" class="form-control @error('marque') is-invalid @enderror" required>
                  @error('marque')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Pois/Capacité</label>
                  <input type="number" id="descriptif_technique" name="descriptif_technique" class="form-control @error('descriptif_technique') is-invalid @enderror" required step="any">
                  @error('descriptif_technique')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-2" style="margin-top: 3px">
                <div class="form-group">
                <select class="form-control form-control-sm form-control" data-style="btn btn-link" name="unite" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                  <option value="" disabled selected>Unité</option>
                  <option value="Kg">Kg</option>
                  <option value="g">g</option>
                  <option value="L">L</option>
                  <option value="ml">ml</option>
                </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">La quantité minimum</label>
                  <input type="number" id="quantite_min" name="quantite_min" class="form-control @error('quantite_min') is-invalid @enderror" required>
                  @error('quantite_min')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6" style="margin-top: 3px">
                <div class="form-group">
                <select class="form-control form-control-sm form-control" data-style="btn btn-link" name="tva" id="tva" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                  <option value="" disabled selected>TVA</option>
                  <option value="0">0%</option>
                  <option value="7">7%</option>
                  <option value="14">14%</option>
                  <option value="20">20%</option>
                </select>
                </div>
              </div>
            </div>


            <button type="submit" class="btn btn-success pull-right"><i class="material-icons">create</i>Ajouter le Produit</button>
            <div class="clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End AddProductModal --> 

  <!-- EndModals -->

<!--   Core JS Files   -->
<script src="{{asset('../assets/js/core/jquery.min.js')}}"></script>
<script src="{{asset('../assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('../assets/js/core/bootstrap-material-design.min.js')}}"></script>
<script src="{{asset('../assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
<!-- Plugin for the momentJs  -->
<script src="{{asset('../assets/js/plugins/moment.min.js')}}"></script>
<!--  Plugin for Sweet Alert -->
<script src="{{asset('../assets/js/plugins/sweetalert2.js')}}"></script>
<!-- Forms Validations Plugin -->
<script src="{{asset('../assets/js/plugins/jquery.validate.min.js')}}"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{asset('../assets/js/plugins/jquery.bootstrap-wizard.js')}}"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{asset('../assets/js/plugins/bootstrap-selectpicker.js')}}"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{asset('../assets/js/plugins/bootstrap-datetimepicker.min.js')}}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="{{asset('../assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="{{asset('../assets/js/plugins/bootstrap-tagsinput.js')}}"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{asset('../assets/js/plugins/jasny-bootstrap.min.js')}}"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{asset('../assets/js/plugins/fullcalendar.min.js')}}"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{{asset('../assets/js/plugins/jquery-jvectormap.js')}}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{asset('../assets/js/plugins/nouislider.min.js')}}"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="{{asset('../assets/js/plugins/arrive.min.js')}}"></script>
<!-- Chartist JS -->
<script src="{{asset('../assets/js/plugins/chartist.min.js')}}"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('../assets/js/plugins/bootstrap-notify.js')}}"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{asset('../assets/js/material-dashboard.js?v=2.1.2')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
  $(document).ready(function() {
    $().ready(function() {
      $sidebar = $('.sidebar');

      $sidebar_img_container = $sidebar.find('.sidebar-background');

      $full_page = $('.full-page');

      $sidebar_responsive = $('body > .navbar-collapse');

      window_width = $(window).width();

      fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

      if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
        if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
          $('.fixed-plugin .dropdown').addClass('open');
        }

      }

      $('.fixed-plugin a').click(function(event) {
        // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
        if ($(this).hasClass('switch-trigger')) {
          if (event.stopPropagation) {
            event.stopPropagation();
          } else if (window.event) {
            window.event.cancelBubble = true;
          }
        }
      });

      $('.fixed-plugin .active-color span').click(function() {
        $full_page_background = $('.full-page-background');

        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var new_color = $(this).data('color');

        if ($sidebar.length != 0) {
          $sidebar.attr('data-color', new_color);
        }

        if ($full_page.length != 0) {
          $full_page.attr('filter-color', new_color);
        }

        if ($sidebar_responsive.length != 0) {
          $sidebar_responsive.attr('data-color', new_color);
        }
      });

      $('.fixed-plugin .background-color .badge').click(function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var new_color = $(this).data('background-color');

        if ($sidebar.length != 0) {
          $sidebar.attr('data-background-color', new_color);
        }
      });

      $('.fixed-plugin .img-holder').click(function() {
        $full_page_background = $('.full-page-background');

        $(this).parent('li').siblings().removeClass('active');
        $(this).parent('li').addClass('active');


        var new_image = $(this).find("img").attr('src');

        if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
          $sidebar_img_container.fadeOut('fast', function() {
            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $sidebar_img_container.fadeIn('fast');
          });
        }

        if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
          var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

          $full_page_background.fadeOut('fast', function() {
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
            $full_page_background.fadeIn('fast');
          });
        }

        if ($('.switch-sidebar-image input:checked').length == 0) {
          var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
          var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

          $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
          $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
        }

        if ($sidebar_responsive.length != 0) {
          $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
        }
      });

      $('.switch-sidebar-image input').change(function() {
        $full_page_background = $('.full-page-background');

        $input = $(this);

        if ($input.is(':checked')) {
          if ($sidebar_img_container.length != 0) {
            $sidebar_img_container.fadeIn('fast');
            $sidebar.attr('data-image', '#');
          }

          if ($full_page_background.length != 0) {
            $full_page_background.fadeIn('fast');
            $full_page.attr('data-image', '#');
          }

          background_image = true;
        } else {
          if ($sidebar_img_container.length != 0) {
            $sidebar.removeAttr('data-image');
            $sidebar_img_container.fadeOut('fast');
          }

          if ($full_page_background.length != 0) {
            $full_page.removeAttr('data-image', '#');
            $full_page_background.fadeOut('fast');
          }

          background_image = false;
        }
      });

      $('.switch-sidebar-mini input').change(function() {
        $body = $('body');

        $input = $(this);

        if (md.misc.sidebar_mini_active == true) {
          $('body').removeClass('sidebar-mini');
          md.misc.sidebar_mini_active = false;

          $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

        } else {

          $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

          setTimeout(function() {
            $('body').addClass('sidebar-mini');

            md.misc.sidebar_mini_active = true;
          }, 300);
        }

        // we simulate the window Resize so the charts will get updated in realtime.
        var simulateWindowResize = setInterval(function() {
          window.dispatchEvent(new Event('resize'));
        }, 180);

        // we stop the simulation of Window Resize after the animations are completed
        setTimeout(function() {
          clearInterval(simulateWindowResize);
        }, 1000);

      });
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts();

  });
</script>

<script>
$(document).ready(function(){
  $(".confirm").click(function(){


    Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})


  });
});
</script>
<script>
  // To style all selects
$('select').selectpicker();
$('datalist').selectpicker();
</script>

   

</body>

</html>