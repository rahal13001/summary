@extends('layouts.base')
    @section('body')

         <x-layouts.sidebar></x-layouts.sidebar>
         <x-layouts.navigation></x-layouts.navigation>
          
     <div class="content-wrap">
         <div class="main">
             <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 p-r-0 title-margin-right">
                         <div class="page-header">
                            <div class="page-title">
                                <div class="content-wrap">
                                    <div class="main">
                                        <div class="container-fluid">
                                            <div class="page-header">
                                                <div class="page-title">
                                                    <h1>Hello {{ Auth::user()->name }},
                                                    <span>Selamat Datang di Menu @yield('menu')</span>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>

                                        <section id="main-content">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="user-profile">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        @yield('content')
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </section>



                                    </div>
                                </div>

                                
                        
                            </div>
                        </div>
                    </div>
             </div>
         </div>
     </div>
    </div>



    @endsection