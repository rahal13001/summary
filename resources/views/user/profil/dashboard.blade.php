@extends('layouts.back')


@section('menu', 'Dashboard')

@section('content')

                    

    <div class="container-fluid">
        <div class="col-md-12 ml-4">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Rekapitulasi Kegiatan</h4>

                       <div class="app-card-header border-0">

                                <div class="row input-daterange" id="date1">
                                    <div class="col-md-2 mt-2">
                                        <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Dari Tanggal"
                                            readonly />
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Ke Tanggal"
                                            readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" name="filter" id="filter" class="btn btn-primary mt-2">Filter</button>
                                        <button type="button" name="refresh" id="refresh" class="btn btn-secondary mt-2">Refresh</button>
                                    </div>
                                </div>
                            
                            </div>

                </div>
                <!--//app-card-header-->

      
                    <div class="container col-md-12">
                        
                        <div class="app-card app-card-chart h-100 shadow-sm">
                        
                            <div class="app-card-body p-4">     
                                <div class="chart-container">
                        
                                        <div class="container" id="keg-tahun" style="height:100%; width:100%"></div>
                                </div>
                            </div>
                            <!--//app-card-body-->
                        </div>
                    <!--//app-card-->
                    </div>
                    <!--//col-->


                    <div class="container col-md-12">
                        
                        <div class="app-card app-card-chart h-100 shadow-sm">
                        
                            <div class="app-card-body p-4">     
                                <div class="chart-container">
                        
                                        <div class="container" id="iku-tahun" style="height:100%; width:100%"></div>
                                </div>
                            </div>
                            <!--//app-card-body-->
                        </div>
                    <!--//app-card-->
                    </div>
                    <!--//col-->

            </div>
        </div>
    </div>

<script src="https://code.highcharts.com/highcharts.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script> --}}

@push('addon-script')
    <script>
      //Ajax Data Table Mulai
       $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

    load_data();

        //Iniliasi datepicker pada class input
        $('#date1').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true
            });


            $('#filter').click(function () {
                var from_date = $('#from_date').val(); 
                var to_date = $('#to_date').val(); 
                if (from_date != '' && to_date != '') {
                    $('#crudTable').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    alert('Rentang Tanggal Harus Diisi');
                }
            });
            $('#refresh').click(function () {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#crudTable').DataTable().destroy();
                load_data();
            });


        // AJAX DataTable
        function load_data(from_date = '', to_date = '') {

            //     const ctx = document.getElementById('myChart').getContext('2d');
            // const myChart = new Chart(ctx, {
            //     type: 'bar',
            //     data: {
            //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            //         datasets: [{
            //             label: '# Gabungan',
            //             data: [12, 19, 3, 5, 2, 3],
            //             backgroundColor: [
            //                 'rgba(54, 162, 235, 0.2)',
            //                 'rgba(54, 162, 235, 0.2)',
            //                 'rgba(54, 162, 235, 0.2)',
            //                 'rgba(54, 162, 235, 0.2)',
            //                 'rgba(54, 162, 235, 0.2)',
            //                 'rgba(54, 162, 235, 0.2)',
            //             ],
            //             borderColor: [
            //                 'rgba(54, 162, 235, 1)',
            //                 'rgba(54, 162, 235, 1)',
            //                 'rgba(54, 162, 235, 1)',
            //                 'rgba(54, 162, 235, 1)',
            //                 'rgba(54, 162, 235, 1)',
            //                 'rgba(54, 162, 235, 1)',
            //             ],
            //             borderWidth: 1
            //         },
                
            //         {
            //             label: '# Penyusun',
            //             data: [12, 19, 3, 5, 2, 3],
            //             backgroundColor: [
            //                 'rgba(255, 206, 85, 0.2)',
            //                 'rgba(255, 206, 85, 0.2)',
            //                 'rgba(255, 206, 85, 0.2)',
            //                 'rgba(255, 206, 85, 0.2)',
            //                 'rgba(255, 206, 85, 0.2)',
            //                 'rgba(255, 206, 85, 0.2)',
            //             ],
            //             borderColor: [
            //                 'rgba(255, 206, 86, 1)',
            //                 'rgba(255, 206, 86, 1)',
            //                 'rgba(255, 206, 86, 1)',
            //                 'rgba(255, 206, 86, 1)',
            //                 'rgba(255, 206, 86, 1)',
            //                'rgba(255, 206, 86, 1)',
            //             ],
            //             borderWidth: 1
            //         },
                    
            //         {
            //             label: '# Pengikut',
            //             data: [12, 19, 3, 5, 2, 3],
            //             backgroundColor: [
            //                 'rgba(255, 99, 131, 0.2)',
            //                 'rgba(255, 99, 131, 0.2)',
            //                 'rgba(255, 99, 131, 0.2)',
            //                 'rgba(255, 99, 131, 0.2)',
            //                 'rgba(255, 99, 131, 0.2)',
            //                 'rgba(255, 99, 131, 0.2)',
            //             ],
            //             borderColor: [

            //                 'rgba(255, 99, 132, 1)',
            //                  'rgba(255, 99, 132, 1)',
            //                  'rgba(255, 99, 132, 1)',
            //                  'rgba(255, 99, 132, 1)',
            //                  'rgba(255, 99, 132, 1)',
            //                  'rgba(255, 99, 132, 1)',
            //             ],
            //             borderWidth: 1
            //         }
                
            //     ]
            //     },
            //             options: {
            //                 scales: {
            //                     y: {
            //                         beginAtZero: true
            //                     }
            //                 },
                            
            //             }
            //         });
                
                Highcharts.chart('keg-tahun', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Jumlah Kegiatan Perbulan'
                    },
                    // subtitle: {
                    //     text: '1 Orang Pegawai Selama 1 Tahun'
                    // },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            formatter : function(){
                                return Highcharts.dateFormat('%b-Y%', this.value);
                            }
                        },
                        categories: [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Kegiatan (Kali)'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} kali</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                        }
                    },
                    series: [ {
                        name: 'Kegiatan',
                        color: '#2980b9',
                        data: [
                                42.4,
                                33.2,
                                34.5,
                                39.7,
                                52.6,
                                75.5,
                                57.4,
                                60.4,
                                47.6,
                                39.1,
                                46.8,
                                51.1
                            ]

                    },
                    {
                        name: 'Penyusun',
                        color: '#55BF3B',
                        data: [
                                42.4,
                                33.2,
                                34.5,
                                39.7,
                                52.6,
                                75.5,
                                57.4,
                                60.4,
                                47.6,
                                39.1,
                                46.8,
                                51.1
                            ]

                    },
                    {
                        name: 'Pengikut',
                        color: '#f1c40f',
                        data: [
                                42.4,
                                33.2,
                                34.5,
                                39.7,
                                52.6,
                                75.5,
                                57.4,
                                60.4,
                                47.6,
                                39.1,
                                46.8,
                                51.1
                            ]

                    }
                    
                    
                    
                    ]
                });

                //jumlah kegiatan periku
                 Highcharts.chart('iku-tahun', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Jumlah Kegiatan Per-IKU'
                    },
                    // subtitle: {
                    //     text: '1 Orang Pegawai Selama 1 Tahun'
                    // },
                    xAxis: {
                        categories: [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Kegiatan (Kali)'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} kali</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                        }
                    },
                    series: [ {
                        name: 'Kegiatan',
                        color: '#2980b9',
                        data: [
                                42.4,
                                33.2,
                                34.5,
                                39.7,
                                52.6,
                                75.5,
                                57.4,
                                60.4,
                                47.6,
                                39.1,
                                46.8,
                                51.1
                            ]

                    },
                    {
                        name: 'Penyusun',
                        color: '#55BF3B',
                        data: [
                                42.4,
                                33.2,
                                34.5,
                                39.7,
                                52.6,
                                75.5,
                                57.4,
                                60.4,
                                47.6,
                                39.1,
                                46.8,
                                51.1
                            ]

                    },
                    {
                        name: 'Pengikut',
                        color: '#f1c40f',
                        data: [
                                42.4,
                                33.2,
                                34.5,
                                39.7,
                                52.6,
                                75.5,
                                57.4,
                                60.4,
                                47.6,
                                39.1,
                                46.8,
                                51.1
                            ]

                    }
                    
                    
                    
                    ]
                });

        }
    });
    </script>
@endpush

@endsection

