@extends('layouts.back')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<style>
        #counter {
        text-align: right;
        font-size: .9em;
        color: #666666;
    }
    #progress {
        line-height: 0;
        height: 1px;
        background-color: darkgreen;
        margin-top: -1px;
        transition: width 1s ease;
        width: 0;
    }
    #progress.full {
        background-color: darkred;
    }

     trix-editor em {
    font-style: normal;
    background-color: #f38080;
    }
</style>


@push('script')
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {

         $('.select2').select2({
             placeholder:"Isikan Data",
             width : "100%"
         });
});
    </script>

    <script>
        $(function(){
  var limit = 10000;

    var counter = $('#counter').text(limit);
    var progress = $('#progress').hide();

    function setCount (length) {
        var adjustedLength = length - 1;
        if (adjustedLength > 0) {
            counter.text(adjustedLength + ' of ' + limit);
            progress.show().width((adjustedLength / limit * 100) + '%')
                .removeClass('full');
            if (adjustedLength > limit) {
                progress.width('100%').addClass('full');
            }
        }
        else {
            progress.hide();
            counter.text(limit)
        }
    }


    var elementEditor = document.querySelector("trix-editor");

    var processedDocumentText;
    document.addEventListener("trix-change", function (event) {
        //debugger

        var newDocumentText = elementEditor.editor.getDocument().toString();
        if (!processedDocumentText) {
            processedDocumentText = newDocumentText;
        }
        var length = newDocumentText.length;
        setCount(length);

        if (processedDocumentText && processedDocumentText !== newDocumentText) {
            processedDocumentText = newDocumentText;

            if (length > limit) {
                var currentSelectedRange = elementEditor.editor.getSelectedRange();

                //deselect previous
                elementEditor.editor.setSelectedRange([0, length + 1]);
                elementEditor.editor.deactivateAttribute('italic');

                elementEditor.editor.setSelectedRange([limit, length]);
                elementEditor.editor.activateAttribute("italic");

                //restore state
                elementEditor.editor.setSelectedRange(currentSelectedRange);
            }
        }

        //typography, use replaceHtml.
        // how to get current html? innerHTML?

    });
})

    </script>
@endpush

@section('menu', 'Input 5W1H')

@section('content')

   @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             Edit Data Gagal !!! <i class="bi bi-emoji-frown"></i>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('myreport_update', $report) }}" method="post" enctype="multipart/form-data">
       @csrf
       @method('put')
      <div class="form-group">
         <label for="user_id">Nama Penyusun</label>
         <select name="user_id" id="user_id" class="form-control input-rounded select2">
            <option disabled selected>Isikan Nama Pembuat</option>
            @foreach ($user as $pengguna )
               <option {{ $report->user_id == $pengguna->id ? 'selected' : '' }} value="{{ $pengguna->id }}"> {{ $pengguna->name }}</option>
            @endforeach
            
            </select>                   
         @error('user_id')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
         @enderror                                  
       </div>

        <div class="form-group mt-3">
         <label for="pengikut">Pilih Pengikut</label>
         <select name="pengikut[]" id="pengikut" class="form-control input-rounded select2" multiple>
                @foreach ($users as $fol )
                    <option {{ $report->follower->find($fol) ? 'selected' : ''}} value="{{ $fol->id }}"> {{ $fol->name }}</option>
                @endforeach            
            </select>                   
         @error('pengikut')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
         @enderror                                  
       </div>

        <div class="form-group mt-3">
            <label for="no_st">Nomor Surat Tugas</label>
            <input type="text" name="no_st" id="no_st" class="form-control input-rounded" placeholder="Masukan Judul Kegiatan" value="{{$report->no_st}}">                  
            @error('no_st')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="what">What</label>
            <input type="text" name="what" id="what" class="form-control input-rounded" placeholder="Masukan Judul Kegiatan" value="{{$report->what}}">                  
               <small id="jumlah_what">0</small>
                <small> / 250 (Termasuk Spasi)</small>
            @error('what')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

    <div class="form-group mt-3">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control input-rounded" placeholder="Slug Otomatis Sesuai What" value="{{ $report->slug }}" readonly>                  
        @error('slug')
        <div class="text-danger mt-2 d-block">{{ $message }}</div>
        @enderror                                  
      </div>

       <div class="form-group mt-3">
         <label for="indicator">Pilih IKU</label>
         <select name="indicator[]" id="indicator" class="form-control input-rounded select2" multiple>
                @foreach ($indicator as $iku)
                    <option {{ $report->indicators->find($iku) ? 'selected' : ' ' }} value= "{{ $iku->id}}">{{ $iku->nama }}</option>
                @endforeach       
            </select>                   
         @error('indicator')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
         @enderror                                  
       </div>

       <div class="form-group mt-3">
            <label for="where">Where</label>
            <input type="text" name="where" id="where" class="form-control input-rounded" placeholder="Masukan Lokasi/Tempat" value="{{ $report->where }}">                  
             <small id="jumlah_where">0</small>
            <small> / 250 (Termasuk Spasi)</small>
            @error('where')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="when">When</label>
            <input type="date" name="when" id="when" class="form-control input-rounded" placeholder="Masukan Tanggal Mulai" value="{{ $report->when }}">                  
            @error('when')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group col-md-6">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control input-rounded" placeholder="Masukan Tanggal Selesai" value="{{ $report->tanggal_selesai }}">                  
            @error('tanggal_selesai')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>
    </div>

     <div class="form-group mt-3">
            <label for="total_peserta">Total Peserta</label>
            <input type="number" name="total_peserta" id="total_peserta" class="form-control input-rounded" placeholder="Masukan Total Peserta" value="{{ $report->total_peserta }}" step="0.01">                  
            @error('total_peserta')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="total_jam">Jumlah Jam</label>
            <input type="text" name="total_jam" id="total_jam" class="form-control input-rounded" placeholder="Masukan Jumlah Jam" value="{{ $report->total_jam }}" step="0.01">                  
            @error('total_jam')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
        Persentase Jumlah Wanita <br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio0" value="0" {{ ($report->gender_wanita=="0")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio0">0%</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio1" value="10" {{ ($report->gender_wanita=="10")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio1">10%</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio2" value="20" {{ ($report->gender_wanita=="20")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio2">20%</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio3" value="30" {{ ($report->gender_wanita=="30")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio3">30%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio4" value="40" {{ ($report->gender_wanita=="40")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio4">40%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio5" value="50" {{ ($report->gender_wanita=="50")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio5">50%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio6" value="60" {{ ($report->gender_wanita=="60")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio6">60%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio7" value="70" {{ ($report->gender_wanita=="70")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio7">70%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio8" value="80" {{ ($report->gender_wanita=="80")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio8">80%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio9" value="90" {{ ($report->gender_wanita=="90")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio9">90%</label>
        </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio10" value="100" {{ ($report->gender_wanita=="100")? "checked" : "" }}>
            <label class="form-check-label" for="inlineRadio10">100%</label>
        </div>
    </div>

        <div class="form-group mt-3">
            <label for="why">Why</label>
            <input type="text" name="why" id="why" class="form-control input-rounded" placeholder="Masukan Alasan/Dasar Kegiatan" value="{{ $report->why}}">                  
               <small id="jumlah_why">0</small>
            <small> / 250 (Termasuk Spasi)</small>
            @error('why')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

          <div class="form-group mt-3">
            <label for="penyelenggara">Penyelenggara</label>
            <input type="text" name="penyelenggara" id="penyelenggara" class="form-control input-rounded" placeholder="Masukan Penyelenggara" value="{{ $report->penyelenggara }}">                  
            <small id="jumlah_penyelenggara">0</small>
            <small> / 250 (Termasuk Spasi)</small>
            @error('penyelenggara')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

       <div class="form-group mt-3">
            <label for="who">Who</label>
            <div class="form-floating">
            <textarea class="form-control" placeholder="Masukan Pihak Yang Terlibat" id="textwho" name="who" >{{ $report->who }}</textarea>
              <label for="floatingTextarea">Masukan Pihak Yang Terlibat</label>
            </div>
                <small id="jumlah_who">0</small>
                <small id="max_who">/ 3000 Karakter (Termasuk Spasi)</small>         
            @error('who')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="how">How</label>
              <input id="how" type="hidden" name="how" value="{{ $report->how }}" placeholder="Masukan Inti Kegiatan, Bukan jadwal atau rangkaian acara">
                <trix-editor input="how"></trix-editor>
                 <div id="progress"></div>
                 <div id="counter"></div>   
               <small>Maksimal 10.000 Karakter (Termasuk Spasi)</small>                 
            @error('how')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="dokumentasi1">Dokumentasi 1</label><br>
                     @if ($report->documentation->dokumentasi1 !== null)
                    <img src="{{ asset('dokumentasi/'.$report->documentation->dokumentasi1) }}" width="50%" alt="ga ada" class="mb-2 img-preview1">
                    @else
                    <img width="50%" class="mb-2 img-preview1">
                    @endif
                    <input type="file" class="form-control input-rounded" name="dokumentasi1" value="{{ $report->documentation->dokumentasi1 }}" id="dok1" onchange="previewImage1()">
                    <small>Ukuran Gambar Maksimal 1 MB</small>
                </div>

                <div class="col-md-6">
                    <label for="dokumentasi2">Dokumentasi 2 (Jika Ada)</label>
                    @if ($report->documentation->dokumentasi2 !== null)
                        <img src="{{ asset('dokumentasi/'.$report->documentation->dokumentasi2) }}" width="50%" alt="ga ada" class="mb-2 img-preview2">
                    @else
                        <img width="50%" class="mb-2 img-preview2">
                    @endif
                    <input type="file" class="form-control input-rounded" name="dokumentasi2" value="{{ $report->documentation->dokumentasi2 }}" id="dok2" onchange="previewImage2()">
                    <small>Ukuran Gambar Maksimal 1 MB</small>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="dokumentasi3">Dokumentasi 3 (Jika Ada)</label><br>
                    
                    @if ($report->documentation->dokumentasi3 !== null)
                        <img src="{{ asset('dokumentasi/'.$report->documentation->dokumentasi3) }}" width="50%" alt="ga ada" class="mb-2 img-preview3">
                    @else
                        <img width="50%" class="mb-2 img-preview3">
                    @endif

                    <input type="file" class="form-control input-rounded" name="dokumentasi3" value="{{ $report->documentation->dokumentasi3 }}" id="dok3" onchange="previewImage3()">
                        <small>Ukuran Gambar Maksimal 1 MB</small>
                </div>

                <div class="col-md-6">
                    <label for="lainnya">Dokumentasi Lainnya (Jika Ada)</label><br>
                    @if ($report->documentation->lainnya !== null)
                        @if (pathinfo($report->documentation->lainnya, PATHINFO_EXTENSION) == 'png' || 
                                pathinfo($report->documentation->lainnya, PATHINFO_EXTENSION) == 'jpg' ||
                                pathinfo($report->documentation->lainnya, PATHINFO_EXTENSION) == 'jpeg'
                                )
                            <img src="{{ asset('lainnya/'.$report->documentation->lainnya) }}" width="50%" alt="ga ada" class="mb-2 img-previewlainnya">
                        @else
                            <img width="50%" class="mb-2 img-previewlainnya">
                            <a class="btn btn-info mt-3" href="{{ route('view_pdf',$report) }}" target="_blank"> Cek Dokumentasi Lainnya</a>
                        @endif
                    @else
                        <img width="50%" class="mb-2 img-previewlainnya">
                    @endif
                        
                    <input type="file" class="form-control input-rounded" name="lainnya" value="{{ $report->documentation->lainnya }}" id="lainnya" onchange="previewImageLainnya()">
                    <small>Ukuran File Maksimal 10 MB</small>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="st">Surat Tugas (Jika Ada)</label><br>
                     @if ($report->documentation->st !== null)
                                <a class="btn btn-info mt-3" href="{{ route('view_st',$report) }}" target="_blank"> Cek Surat Tugas</a>
                        @endif
                    <input type="file" class="form-control input-rounded" name="st" value="{{ $report->documentation->st }}">
                    <small>Ukuran File Maksimal 3 MB, Dianjurkan Dalam Bentuk PDF</small>
                </div>
            </div>

        </div>

        <div class="mt-4">
         <button type="submit" class="btn btn-info mr-2">Submit</button>
         @can('show user')
         <a href="{{ route('report_index') }}" class="btn btn-outline-danger mx-3 my-3 float-right">Kembali Ke 5w1H Semua</a>
         @endcan
         <a href="{{ route('myreport') }}" class="btn btn-outline-danger mr-2 float-right">Kembali Ke 5w1H-Ku</a>
        </div>
    </form>




<script>
        document.addEventListener('trix-file-accept', function(e){
        e.preventDefault();
        alert('Tidak bisa sisipkan file disini, Unggah File di Form Dokumentasi !');
    });


                                const what = document.querySelector('#what');
                                const slug = document.querySelector('#slug');

                                what.addEventListener('change', function(){
                                    fetch('/5w1h/posts/checkSlug?what='+what.value)
                                    .then(response => response.json())
                                    .then(data => slug.value = data.slug)
                                });
</script>

<script>
    //hitung who
    var myWho = document.getElementById('textwho');
    var wordWho = document.getElementById('jumlah_who');

    myWho.addEventListener("keyup", function(){
        var characterswho = myWho.value.split('');
        wordWho.innerText = characterswho.length;
    });

    //hitung why
    var myWhy = document.getElementById('why');
    var wordWhy = document.getElementById('jumlah_why');

    myWhy.addEventListener("keyup", function(){
        var charwhy = myWhy.value.split('');
        wordWhy.innerText = charwhy.length;
    });

    //hitung where
    var myWhere = document.getElementById('where');
    var wordWhere = document.getElementById('jumlah_where');

    myWhere.addEventListener("keyup", function(){
        var char_where = myWhere.value.split('');
        wordWhere.innerText = char_where.length;
    });

   //hitung what
    var myWhat = document.getElementById('what');
    var wordWhat = document.getElementById('jumlah_what');

    myWhat.addEventListener("keyup", function(){
        var char_what = myWhat.value.split('');
        wordWhat.innerText = char_what.length;
    });

     //hitung penyelenggara
    var myPenyelenggara = document.getElementById('penyelenggara');
    var wordPenyelenggara = document.getElementById('jumlah_penyelenggara');

    myPenyelenggara.addEventListener("keyup", function(){
        var char_penyelenggara = myPenyelenggara.value.split('');
        wordPenyelenggara.innerText = char_penyelenggara.length;
    });

     function previewImage1(){
        const image = document.getElementById('dok1');
        const imgPreview = document.querySelector('.img-preview1');

        imgPreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

    }

    function previewImage2(){
        const image = document.getElementById('dok2');
        const imgPreview = document.querySelector('.img-preview2');

        imgPreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

    }

    function previewImage3(){
        const image = document.getElementById('dok3');
        const imgPreview = document.querySelector('.img-preview3');

        imgPreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

    }

       function previewImageLainnya(){
        const image = document.getElementById('lainnya');
        const imgPreview = document.querySelector('.img-previewlainnya');

        imgPreview.style.display = 'block';
        imgPreview.setAttribute("alt", "File Terpasang")
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

    }

</script>
@endsection