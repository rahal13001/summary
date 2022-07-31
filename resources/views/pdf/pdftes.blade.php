<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ekspor PDF 5W1H</title>

    
    {{-- <link rel="stylesheet" href="css\pdftes.css"> --}}
</head>
<body>

    <style>
        .a4 {
            position: absolute;
            width: 620px;
            height: 110.75px;
            margin: auto;
            background: #ffffff;
            /* border: 1px solid #eee; */
            padding: 30px;
        }
        table {
            width: 100%;
        }
        table,
        th,
        td {
            /* border: 1px solid black; */
            text-align: justify;
            height: 20px;
            font-size: 15px;
            vertical-align: top;
        
        }

        .field {
            width: 20%;
        }

        .titik {
            width: 5%;
        }

        .no_st {
            text-align: center;
            height: 30px;
        }

        .point {
            font-weight: bold;
            vertical-align: top;
        }

        .judul {
            font-weight: bold;
            font-size: 18px;
            text-align: center;
        }
        .gbr {
            width: 100%;
            text-align: center;
            vertical-align:middle;
        }

        .page-break {
            page-break-after: always;
            page-break-before: auto;
        }
        .page-break-how {
            /* page-break-after: auto; */
            page-break-inside: auto;
        }

        .bold {
            font-weight: bold;
        }

        .no_table{
            margin-top: 10px;
            margin-left: 2px;
            text-align: justify;
        }


        /* .page-break {
            page-break-after: always;
        } */
    </style>

    <div>
        <table>
            <tr>
                <td colspan="3" class="no_st">
                    <img src="{{ asset('img/KOP.jpg') }}" alt="KOP Surat" class="gbr">
                </td>
            </tr>
            <tr>
                <td colspan="3" class="judul">
                    5W1H
                </td>
            </tr>
            @if ($report->no_st !== null)
                <tr>
                <td colspan="3" class="no_st">Nomor Surat Tugas : {{ $report->no_st }}<br></td> 
                </tr>    
            @endif
        </table>

        <table>
            <tr class="point">
                <td  class="field">What</td>
                <td class="titik">:</td>
                <td>
                    {{ $report->what }}
                </td>
            </tr>

            <tr>
                <td class="point field" >Nama</td>
                <td  class="point titik">:</td>
                <td>
                    {{ $report->user->name }} @foreach ($follower as $fol )
                    @if (!$loop->last)
                        ,
                    @endif
                    @if ($loop->last)
                        dan
                    @endif
                    {{ $fol->userfoll->name }}

                    @endforeach
                </td>
            </tr>


            <tr>
                <td class="point field" >When</td>
                <td  class="point titik">:</td>
                <td class="bold">
                   {{ $report->when }} s.d {{ $report->tanggal_selesai }}, Jumlah Jam : {{ $report->total_jam }} Jam
                </td>
            </tr>

             <tr>
                <td class="point field" >Tanggal Upload</td>
                <td  class="point titik">:</td>
                <td>
                   {{ $report->created_at }}
                </td>
            </tr>

             <tr>
                <td class="point field" >Total Peserta</td>
                <td  class="point titik">:</td>
                <td>
                   {{ $report->total_peserta }} Orang, Persentase Wanita : {{ $report->gender_wanita }} %
                </td>
            </tr>

             <tr>
                <td class="point field" >Where</td>
                <td  class="point titik">:</td>
                <td>
                    {{ $report->where }}
                </td>
            </tr>

              <tr>
                <td class="point field" >Why</td>
                <td  class="point titik">:</td>
                <td>
                    {{ $report->why }}
                </td>
            </tr>           
        </table>
        
             <div class="container no_table">
                  <span style="font-weight: bold"> IKU : </span> <br>
                     @foreach ($report->indicators as $iku)
                        
                        @if (!$loop->first && !$loop->last)
                            ,
                        @endif
                        @if (!$loop->first && $loop->last)
                            dan 
                        @endif

                        (IKU : {{ $iku->nomor }}) {{ $iku->nama }}

                      
                    @endforeach
            </div>
   
             <div class="container no_table">
                  <span style="font-weight: bold"> Who : </span> <br> {{  $report->who }}
            </div>
        
        <div class="page-break-how"></div>
            <div class="container no_table">
                  <span style="font-weight: bold"> How : </span> {!! $report->how !!}
            </div>

              {{-- <div class="container mt-5">
                <div class="row">
                    <div class="col">
                        <h6 style="font-family: 'Roboto', sans-serif;">Scan untuk melihat dokumen</h6>
                        <img src="data:image/png;base64, {!! $q_report !!}">
                    </div>
                </div>
            </div> --}}

    </div>
    <div class="page-break"></div>

    <div>
   
    <table>
        <tr>
                <td class="judul">
                    Dokumentasi
                </td>
        </tr>
        <tr>
        <td class="gbr">
            <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi1)}}" class="media-object" width="60%" alt="ga keluar">
        </td>
        </tr>
        @if ($report->documentation->dokumentasi2 !== null)       
            <tr>
                <td class="gbr">
                    <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi2)}}" class="media-object" width="60%" alt="ga keluar">
                </td>
            </tr>
        @endif
        @if ($report->documentation->dokumentasi3 !== null)  
        <tr>
            <td class="gbr">
            <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi3)}}" class="media-object" width="60%" alt="ga keluar">
            </td>
        </tr>
        @endif
    </table>
    
    <div class="container" style="margin-top: 20px">
     <table class="table borderless">
            <thead>
                <tr class="">
                    @if ($report->documentation->st !== null)
                        <th>Surat Tugas</th>
                    @endif

                    @if ($report->documentation->lainnya !== null )  
                        <th>Dokumentasi Lainnya</th>
                    @endif
                    <th>Cek 5W1H Online</th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    @if ($report->documentation->st !== null)      
                        <td scope="row" class="text-center">
                            <img src="data:image/png;base64, {!! $q_st !!}">
                        </td>
                    @endif

                    @if ($report->documentation->lainnya !== null )  
                        <td class="text-center">
                        <img src="data:image/png;base64, {!! $q_lainnya !!}">
                        </td>
                    @endif

                    <td class="text-center">
                        <img src="data:image/png;base64, {!! $q_report !!}">
                    </td>
                   
                </tr>
            </tbody>
           </table>
   </div>
    </div>
    
</body>
</html>