<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ekspor PDF 5W1H</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('../assets/images/logoweb.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    
                
</head>

<style>
   p{
    font-family: 'Roboto', sans-serif;
    text-align: justify;
   }
   h2{
    font-family: 'Roboto', sans-serif;
    text-align: center;
   }
   h5{
    font-family: 'Roboto', sans-serif;
    text-align: center;
   }

    div.page
    {
        page-break-after: always;
        page-break-inside: avoid;
    }

    .borderless td, .borderless th {
    border: none;
}
</style>

<body>
    <div class="page">
       <div class="container">
            <div class="row">
                <img src="{{ asset('img/KOP.jpg') }}" alt="KOP Surat" class="img-fluid">
            </div> 
            <div class="row text-center mt-3">
                <h2 class="fw-bolder">5W1H</h2>
                <h6>Nomor Surat Tugas : {{ $report->no_st }}</h6>
            </div>
        </div>



    <div class="container">
       
        <div class="container">
            <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">What :</p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6"> {{ $report->what }}</div>
            </div>

          <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">Nama : </p>
                   <p>
                    {{ $report->user->name }} @foreach ($follower as $fol )
                    @if (!$loop->last)
                        ,
                    @endif
                    @if ($loop->last)
                        dan
                    @endif
                    {{ $fol->userfoll->name }}
                     @endforeach
                    </p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6">
                    
                   </p>
                </div>
            </div>

         <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">When :</p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6">{{ $report->when }} s.d {{ $report->tanggal_selesai }}, Jumlah Jam Pelaksanaan : {{ $report->total_jam }} Jam</p>
                </div>
                <div class="col col-sm">
                   <p class="fs-6">Tanggal Laporan Dibuat : {{ $report->created_at }} </p>
                </div>
            </div>

               
            <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6">Total Peserta : {{ $report->total_peserta }} Orang, Persentase Wanita : {{ $report->gender_wanita }} %</p>  
                </div>
            </div>

              <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">Where :</p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6"> {{ $report->where }}</div>
            </div>

            <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">Why :</p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6"> {{ $report->why}}</div>
            </div>
            
              <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">Penyelenggara :</p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6"> {{ $report->penyelenggara }}</div>
            </div>

            <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">Who :</p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6"> {{ $report->who }}</div>
            </div>

            <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">IKU :</p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6">
                     @foreach ($report->indicators as $iku)
                        
                        @if (!$loop->first && !$loop->last)
                            ,
                        @endif
                        @if (!$loop->first && $loop->last)
                            dan 
                        @endif

                        (IKU : {{ $iku->nomor }}) {{ $iku->nama }}

                      
                    @endforeach
                   </p>
                   </div>
            </div>

              <div class="row mt-3">
                <div class="col col-sm">
                   <p class="fs-6 fw-bold">How :</p> 
                </div>
                <div class="col col-sm">
                   <p class="fs-6">{!! $report->how !!}</p></div>
            </div>

            <div class="container mt-5">
                <div class="row">
                    <div class="col">
                        <h6 style="font-family: 'Roboto', sans-serif;">Scan untuk melihat dokumen</h6>
                        {!! QrCode::size(100)->generate('http://summary.timurbersinar.com/pdf/'.$report->slug); !!}
                    </div>
                </div>
            </div>
            
            
            {{-- {!! QrCode::size(100)->generate('http://summary.timurbersinar.com/pdf/'.$query->slug,); !!} --}}
            
            

        </div>
    </div>
</div>

    {{-- halaman dokumentasi --}}

    
        <div class="container">
            <h2 class="fw-bold">Dokumentasi</h2>
        </div>

        <div class="container">
            <div class="row mt-3">  
                @if ( file_exists('dokumentasi/'.$report->documentation->dokumentasi1))
                     <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi1)}}" class="media-object" width="100%" alt="ga keluar">
                @else
                     <p>Dokumentasi tidak dapat ditemukan</p>
                @endif

            </div> 

             @if ($report->documentation->dokumentasi2 !== null)  
                <div class="row mt-3">  
                    @if ( file_exists('dokumentasi/'.$report->documentation->dokumentasi2))
                        <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi2)}}" class="media-object" width="100%" alt="ga keluar">
                    @else
                        <p>Dokumentasi tidak dapat ditemukan</p>
                    @endif
                </div> 
            @endif

            @if ($report->documentation->dokumentasi3 !== null)  
                <div class="row mt-3">  
                    @if ( file_exists('dokumentasi/'.$report->documentation->dokumentasi3))
                        <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi3)}}" class="media-object" width="100%" alt="ga keluar">
                    @else
                        <p>Dokumentasi tidak dapat ditemukan</p>
                    @endif
                </div> 
            @endif

        </div>

        <div class="container mt-5">
           <table class="table borderless">
            <thead>
                <tr class="">
                    @if ($report->documentation->st !== null)
                        <th>Surat Tugas</th>
                    @endif

                    @if ($report->documentation->lainnya !== null )  
                        <th>Dokumentasi Lainnya</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    @if ($report->documentation->st !== null)      
                        <td scope="row" class="text-center">
                            {!! QrCode::size(100)->generate('http://summary.timurbersinar.com/pdf/'.$report->slug); !!}
                        </td>
                    @endif

                    @if ($report->documentation->lainnya !== null )  
                        <td class="text-center">
                        {!! QrCode::size(100)->generate('http://summary.timurbersinar.com/pdf/'.$report->slug); !!}
                        </td>
                    @endif
                   
                </tr>
            </tbody>
           </table>

        </div>
 
    
</body>
</html>