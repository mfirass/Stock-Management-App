<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('../assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('../assets/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
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
        <div class="logo"><a href="{{ route('user.home') }}" class="simple-text logo-normal">
            T-CREATIVE
          </a></div>
        <div class="sidebar-wrapper">
          <ul class="nav">
            <li class="{{ Request::is('products*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{ route('user.produits') }}">
                <i class="material-icons">category</i>
                <p>Stock</p>
              </a>
            </li>
            <li class="{{ Request::is('demandes*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{ route('user.demandes') }}">
                <i class="material-icons">content_paste</i>
                <p>Demandes</p>
              </a>
            </li>
            <li class="{{ Request::is('commandes*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{ route('user.commandes') }}">
                <i class="material-icons">content_paste</i>
                <p>Commandes</p>
              </a>
            </li>
            <li class="{{ Request::is('employees*') ? 'nav-item active' : 'nav-item'}} ">
              <a class="nav-link" href="{{route('user.employees')}}">
                <i class="material-icons">person</i>
                <p>Employés</p>
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
              @if ( Request :: is('home*') )
                  Accueil
              @endif
              @if ( Request :: is('products*') )
                  Stock
              @endif
              @if ( Request :: is('clients*') )
                  Clients
              @endif
              @if ( Request :: is('fournisseurs*') )
                  Fournisseurs
              @endif
              @if ( Request :: is('demandes*') )
                  Demandes
              @endif
              @if ( Request :: is('commandes*') )
                  Commandes
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
                <a class="nav-link" href="{{route('user.home')}} ">
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
                  <a class="dropdown-item" href="{{route('user.profil', Auth::user())}}">Profile</a>
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
        <form method="POST" action="{{ route('category.add1') }}">
            @csrf
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="bmd-label-floating">Libelle</label>
                  <input type="text" id="libelle" name="libelle" class="form-control @error('libelle') is-invalid @enderror">
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
        <form method="POST" action="{{ route('produits.add1') }}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Libelle</label>
                  <input type="text" id="libelle" name="libelle" class="form-control @error('libelle') is-invalid @enderror">
                  @error('libelle')
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
                  <select class="form-control form-control-sm form-control" data-style="btn btn-link" name="category" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="myFunction0()" >
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
                  <input type="text" id="marque" name="marque" class="form-control @error('marque') is-invalid @enderror">
                  @error('marque')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Pois/Capacité</label>
                  <input type="text" id="descriptif_technique" name="descriptif_technique" class="form-control @error('descriptif_technique') is-invalid @enderror">
                  @error('descriptif_technique')
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
                  <label class="bmd-label-floating">La quantité minimum</label>
                  <input type="text" id="quantite_min" name="quantite_min" class="form-control @error('quantite_min') is-invalid @enderror">
                  @error('quantite_min')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">La quantité maximum</label>
                  <input type="text" id="quantite_max" name="quantite_max" class="form-control @error('quantite_max') is-invalid @enderror">
                  @error('quantite_max')
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
                  <label class="bmd-label-floating">La quantité reel</label>
                  <input type="text" id="quantite_reel" name="quantite_reel" class="form-control @error('quantite_reel') is-invalid @enderror">
                  @error('quantite_reel')
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
                  <label class="bmd-label-floating">Prix d'achat</label>
                  <input type="text" id="prix_achat" name="prix_achat" class="form-control @error('prix_achat') is-invalid @enderror">
                  @error('prix_achat')
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
                  <label class="bmd-label-floating">Prix de vente pour Grossistes</label>
                  <input type="text" id="prix_vente_grossite" name="prix_vente_grossite" class="form-control @error('prix_vente_grossite') is-invalid @enderror">
                  @error('prix_vente_grossite')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Prix de vente pour Détaillants</label>
                  <input type="text" id="prix_vente_detaillant" name="prix_vente_detaillant" class="form-control @error('prix_vente_detaillant') is-invalid @enderror">
                  @error('prix_vente_detaillant')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
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
</script>
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


</body>

</html>