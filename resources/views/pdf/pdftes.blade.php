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
            width: 10%;
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
        }

        .page-break {
            page-break-after: always;
        }

        .bold {
            font-weight: bold;
        }


        .page-break {
            page-break-after: always;
        }
    </style>

    <div class="a4">
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

             <tr>
                <td class="point field" >Who</td>
                <td  class="point titik">:</td>
                <td>
                    {{ $report->who }}
                </td>
            </tr>
            <tr>
                <td class="point field" >No Iku</td>
                <td  class="point titik">:</td>
                <td>
                    @foreach ($report->indicators as $iku)
                        
                        @if (!$loop->first && !$loop->last)
                            ,
                        @endif
                        @if (!$loop->first && $loop->last)
                            dan 
                        @endif

                        {{ $iku->nomor }}

                      
                    @endforeach
                </td>
            </tr>

            <tr>
                <td colspan="3" class="point">How</td>
            </tr>
             <tr>
                <td colspan="3">
                    {!! $report->how !!}
                </td>
            </tr>


        </table>
    </div>
    <div class="page-break"></div>

    <div class="a4">
    <table>
        <tr class="gbr">
        <td>
            <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi1)}}" class="media-object" width="100%" alt="ga keluar">
        </td>
        </tr>
        @if ($report->documentation->dokumentasi2 !== null)       
            <tr class="gbr">
                <td>
                    <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi2)}}" class="media-object" width="100%" alt="ga keluar">
                </td>
            </tr>
        @endif
        @if ($report->documentation->dokumentasi3 !== null)  
        <tr>
            <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi3)}}" class="media-object" width="100%" alt="ga keluar">
        </tr>
        @endif
    </table>
    </div>
    
</body>
</html>