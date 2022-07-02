@extends('layouts.back')

@section('menu', 'Detail')
@section('content')

        
        <div class="row">
        <div class="col-md-6">
        <h4> Judul Kegiatan : {{ $report->what }}</h4>
        <table class="table table-borderless table-responsive text-align-top">
                   <thead>
               <tr>
                  <th scope="row"> Penyusun </th>
                  <td scope="col"> {{ $report->user->name }}</td>
               </tr>
               <tr>
                  <th scope="row"> Pengikut </th>
                  <td scope="col">
                     
                       @foreach ($follower as $fol )
                         <li style="list-style-type:none;">{{ $fol->userfoll->name }}</li>
                        @endforeach
               
               </td>
               </tr>
               <tr>
                  <th scope="row"> No ST </th>
                  <td scope="col"> {{ $report->no_st }}</td>
               </tr>
               <tr>
                  <th scope="row"> What </th>
                  <td scope="col"> {{ $report->what }}</td>
               </tr>
               <tr>
                  <th scope="row"> When </th>
                  <td scope="col"> {{ $report->when }}</td>
               </tr>
               <tr>
                  <th scope="row"> Tanggal Selesai </th>
                  <td scope="col"> {{ $report->tanggal_selesai }}</td>
               </tr>
               <tr>
                  <th scope="row"> Jumlah Jam </th>
                  <td scope="col"> {{ $report->total_jam }}</td>
               </tr>
               <tr>
                  <th scope="row"> Jumlah Peserta </th>
                  <td scope="col"> {{ $report->total_peserta }}</td>
               </tr>
                 <tr>
                  <th scope="row"> Persentase Jumlah Wanita </th>
                  <td scope="col"> {{ $report->gender_wanita }} %</td>
               </tr>
                  <tr>
                   <th scope="row"> Penyelenggara </th>
                   <td scope="col"> {{ $report->penyelenggara }}</td>
                </tr>
               <tr>
                   <th scope="row"> Who </th>
                   <td scope="col"> {!! $report->who !!}</td>
                </tr>
               <tr>
                   <th scope="row"> Why </th>
                   <td scope="col"> {{ $report->why }}</td>
                </tr>
                <tr>
                    <th scope="row"> IKU </th>
                    <td scope="col"> @foreach ($report->indicators as $iku )
                         <li style="list-style-type:none;">{{ $iku->nama }}</li>
                                @endforeach
                        </td>
                 </tr>
                   </thead>
               </table>
               </div>   

               <div class="col-md-6 mt-n3">
                       <div class="container-fluid overflow-auto">
                        <div class="card">
                                <div class="card-head">
                                        <h1>Dokumentasi</h1>
                                </div>
                                <div class="card-body scrollable">
                                
                                <p class="card-title">Dokumentasi 1</p>
                                <a href="{{asset('dokumentasi/'.$report->documentation->dokumentasi1)}}" target="_blank">
                                        <img src="{{asset('dokumentasi/'.$report->documentation->dokumentasi1)}}" class="media-object" width="100%" alt="ga keluar">
                                </a>  
                                @if ($report->documentation->dokumentasi2 !== null)
                                <p class="mt-2 card-title">Dokumentasi 2</p>
                                <a href="{{asset('dokumentasi/'.$report->documentation->dokumentasi2)}}" target="_blank">
                                <img src="{{ asset('dokumentasi/'.$report->documentation->dokumentasi2) }}" class="media-object" width="100%" alt="ga keluar">
                                </a>
                                @endif  
                                
                                @if ($report->documentation->dokumentasi3 !== null)
                                <p class="mt-2 card-title">Dokumentasi 3</p>
                                <a href="{{asset('dokumentasi/'.$report->documentation->dokumentasi3)}}" target="_blank">
                                <img src="{{ asset('dokumentasi/'.$report->documentation->dokumentasi3) }}" class="media-object" width="100%" alt="ga keluar">
                                </a>
                                @endif
                                
                                @if ($report->documentation->lainnya !== null)
                                <a class="btn btn-info mt-3" href="{{ route('view_pdf',$report) }}" target="_blank"> Cek Dokumentasi Lainnya</a>
                                @endif

                                 @if ($report->documentation->st !== null)
                                <a class="btn btn-info mt-3" href="{{ route('view_st',$report) }}" target="_blank"> Cek Surat Tugas</a>
                                @endif

                                </div>

                                
                        </div>
                        </div>
               </div>

               </div>

                 <div class="card">
                    <div class="card-title">
                        <h5>How</h5>          
                     </div>
                 <div class="card-body">
                         <p class="card-text">
                                 {!! $report->how !!}
                         </p>
                 </div>
                </div>
                <div class="row">
                  <div class="mt-3">

                        @can('show user')
                        <a href="{{ route('report_index') }}" class="btn btn-outline-info ml-3 float-right">Kembali Ke 5w1H Semua</a>
                        @endcan
                        <a href="{{ route('myreport') }}" class="btn btn-outline-info ml-3 float-right">Kembali Ke 5w1H-Ku</a>

                     <a href="{{ route('pdf', $report->slug) }}" class="btn btn-danger ml-3" target="_blank">5W1H Kegiatan</a>


                     <a class="btn btn-warning ml-3" href="{{ route('myreport_edit', $report->slug)}}">Edit</a>

                     <button type="button" class="btn btn-outline-danger ml-3" data-toggle="modal" data-target="#deleteModal">
                        Hapus
                     </button>

                  </div>
                </div>


                <!-- Modal Delete-->
               <div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                     <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                     </div>
                     <div class="modal-body">
                     Yakin mau menghapus data ?
                     </div>
                     <div class="modal-footer">
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                     <form action="{{ route('myreport_delete', $report->slug) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger d-inline">Hapus</button>
                     </form> 
                     </form>
                     </div>
                  </div>
               </div>
               </div>
                         
<style>
.scrollable{
  overflow-y: auto;
  max-height: 500px;
}
</style>

@endsection