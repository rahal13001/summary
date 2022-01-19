<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Summary LPSPL Sorong</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="{{ asset('assets/images/logokkpgaruda.jpg') }}">

    
    <!-- FontAwesome JS-->
    <script defer src="/assets/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="/assets/css/portal.css">
    
    <!-- FontAwesome JS-->
    <script defer src="/assets/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">

     {{-- trix editor --}}
    <link href="{{ asset('/css/trix.css') }}" rel="stylesheet" />
    <script src="{{ asset('/js/trix.js') }}"></script>
    <style>
      trix-toolbar[data-trix-button-group="file-tools"]{
        display: none;
      }
    </style>

    

    {{-- Data Table --}}
    <link rel="stylesheet" type="text/css" href="{{asset('DataTables-1.11.3/css/dataTables.dataTables.min.css') }}"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    @yield('style')

</head> 
<body class="app">   

            @yield('body')
        


   <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/lay/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/lay/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

      <!-- Core plugin JavaScript-->
    <script src="{{ asset('/lay/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

     <!-- Common -->
    <script src="{{ asset('/js/jquery/jquery.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
    <!-- MULAI DATEPICKER JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
      
    
    <!-- Javascript -->          
    {{-- <script src="{{ asset('/assets/plugins/popper.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>   --}}

    {{-- <!-- Charts JS -->
    <script src="assets/plugins/chart.js/chart.min.js"></script> 
    <script src="assets/js/index-charts.js"></script>  --}}
    
    <!-- Page Specific JS -->
    <script src="{{ asset('/assets/js/app.js') }}"></script> 

    {{-- Lama --}}
      {{-- <script src="{{ asset('/assets/js/lib/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('/assets/lama/js/lib/jquery.nanoscroller.min.js') }}"></script>
    <script src="{{ asset('/assets/lama/js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/lama/js/scripts.js') }}"></script>
    

    @stack('prepend-script')
    
      {{-- Data Table --}}
      <script type="text/javascript" src="{{ asset('DataTables-1.11.3/js/dataTables.dataTables.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('DataTables-1.11.3/js/jquery.dataTables.min.js') }}"></script>
      <script>
        $("#datatable").DataTable();
      </script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
      <script>
        AOS.init();
      </script>
      <script>
        $("#menu-toggle").click(function (e) {
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
        });
      </script>
      @stack('addon-script')
      <script src="{{ asset('js/app.js') }}"></script>
      @stack('script')
</body>
</html>
