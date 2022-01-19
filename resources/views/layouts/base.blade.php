<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   

 <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
       <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff" />
    <!-- Retina iPad Touch Icon-->
    <link
      rel="apple-touch-icon"
      sizes="144x144"
      href="http://placehold.it/144.png/000/fff"
    />
    <!-- Retina iPhone Touch Icon-->
    <link
      rel="apple-touch-icon"
      sizes="114x114"
      href="http://placehold.it/114.png/000/fff"
    />
    <!-- Standard iPad Touch Icon-->
    <link
      rel="apple-touch-icon"
      sizes="72x72"
      href="http://placehold.it/72.png/000/fff"
    />
    <!-- Standard iPhone Touch Icon-->
    <link
      rel="apple-touch-icon"
      sizes="57x57"
      href="http://placehold.it/57.png/000/fff"
    />

    <!-- Toastr -->
    <link href="assets/css/lib/toastr/toastr.min.css" rel="stylesheet" />
    <!-- Sweet Alert -->
    <link href="assets/css/lib/sweetalert/sweetalert.css" rel="stylesheet" />
    <!-- Range Slider -->
    <link
      href="assets/css/lib/rangSlider/ion.rangeSlider.css"
      rel="stylesheet"
    />
    <link
      href="assets/css/lib/rangSlider/ion.rangeSlider.skinFlat.css"
      rel="stylesheet"
    />

    <!-- Common -->
    <link href="{{ asset('/assets/css/lib/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/lib/themify-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/lib/menubar/sidebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/lib/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/lib/helper.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet" />

    {{-- trix editor --}}
    <link href="{{ asset('css/trix.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/trix.js') }}"></script>
    <style>
      trix-toolbar[data-trix-button-group="file-tools"]{
        display: none;
      }
    </style>



    {{-- Data Table --}}
    <link rel="stylesheet" type="text/css" href="{{asset('DataTables-1.11.3/css/dataTables.dataTables.min.css') }}"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />


 
    @yield('style')
  </head>

<body>
    <div id="app">

            @yield('body')
        
    </div>

     <!-- Common -->
    
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
    <!-- MULAI DATEPICKER JS -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    @stack('prepend-script')
    
      
    {{-- <!-- Toastr -->
    <script src="{{ asset('assets/js/lib/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/toastr/toastr.init.js') }}"></script> --}}

    {{-- common --}}
     {{-- <script src="{{ asset('/assets/js/lib/jquery.min.js') }}"></script> --}}
       <script src="{{ asset('/assets/js/lib/jquery.nanoscroller.min.js') }}"></script>
    <script src="{{ asset('/assets/js/lib/menubar/sidebar.js') }}"></script>
    <script src="{{ asset('/assets/js/lib/preloader/pace.min.js') }}"></script>
    <script src="{{ asset('/assets/js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/scripts.js') }}"></script>
    

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
