@extends('layouts.adminHome')

@section('content')
          <!-- Statistisues -->
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                {{ $chart2->container() }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                {{ $chart1->container() }}
              </div>
            </div>
          </div>
          <!-- EndStatistiques -->


          {!! $chart->script() !!}
          {!! $chart1->script() !!}
          {!! $chart2->script() !!}
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