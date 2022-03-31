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
  var limit = 5000;

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
                    Tambah Data Gagal !!! <i class="bi bi-emoji-frown"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif

    <form action="{{ route('myreport_post') }}" method="post" enctype="multipart/form-data">
       @csrf
       <div class="form-group">
         <label for="user_id">Nama Penyusun</label>
         <select name="user_id" id="user_id" class="form-control input-rounded select2">
            <option disabled selected>Isikan Nama Pembuat</option>
            @foreach ($user as $pengguna )
               <option value="{{ $pengguna->id }}">{{ $pengguna->name }}</option>
            @endforeach
            
            </select>                   
         @error('user_id')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
         @enderror                                  
       </div>

        <div class="form-group mt-3">
         <label for="pengikut">Pilih Pengikut</label>
         <select name="pengikut[]" id="pengikut" class="form-control input-rounded select2" multiple>
            @foreach ($user as $pemakai )
               <option value="{{ $pemakai->id }}">{{ $pemakai->name }}</option>
            @endforeach
            
            </select>                   
         @error('pengikut')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
         @enderror                                  
       </div>

       <div class="form-group mt-3">
            <label for="no_st">Nomor Surat Tugas</label>
            <input type="text" name="no_st" id="no_st" class="form-control input-rounded" placeholder="Masukan Nomor Surat Tugas" value="{{ old('no_st') }}">                  
            @error('no_st')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="what">What</label>
            <input type="text" name="what" id="what" class="form-control input-rounded" placeholder="Masukan Judul Kegiatan" value="{{ old('what') }}">                  
            <small id="jumlah_what">0</small>
            <small> / 250 (Termasuk Spasi)</small>
            @error('what')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

    <div class="form-group mt-3">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control input-rounded" placeholder="Slug Otomatis Sesuai What" value="{{ old('slug') }}" readonly>                  
        @error('slug')
        <div class="text-danger mt-2 d-block">{{ $message }}</div>
        @enderror                                  
      </div>

       <div class="form-group mt-3">
         <label for="indicator">Pilih IKU</label>
         <select name="indicator[]" id="indicator" class="form-control input-rounded select2" multiple>
            @foreach ($indicator as $iku )
               <option value="{{ $iku->id }}">{{ $iku->nama }}</option>
            @endforeach
            
            </select>                   
         @error('indicator')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
         @enderror                                  
       </div>

       <div class="form-group mt-3">
            <label for="where">Where</label>
            <input type="text" name="where" id="where" class="form-control input-rounded" placeholder="Masukan Lokasi/Tempat" value="{{ old('where') }}">                  
            <small id="jumlah_where">0</small>
            <small> / 250 (Termasuk Spasi)</small>
            @error('where')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>
        <div class="row mt-3">
        <div class="form-group col-md-6">
            <label for="when">When</label>
            <input type="date" name="when" id="when" class="form-control input-rounded" placeholder="Masukan Tanggal Mulai" value="{{ old('when') }}">                  
            @error('when')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group col-md-6">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control input-rounded" placeholder="Masukan Tanggal Selesai" value="{{ old('tanggal_selesai') }}">                  
            @error('tanggal_selesai')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>
        </div>

        <div class="form-group mt-3">
            <label for="total_jam">Jumlah Jam</label>
            <input type="text" name="total_jam" id="total_jam" class="form-control input-rounded" placeholder="Masukan Jumlah Jam" value="{{ old('total_jam') }}" step="0.01">                  
            @error('total_jam')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="total_peserta">Total Peserta</label>
            <input type="number" name="total_peserta" id="total_peserta" class="form-control input-rounded" placeholder="Masukan Total Peserta" value="{{ old('total_peserta') }}" step="0.01">                  
            @error('total_peserta')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

    <div class="form-group mt-3">
        Persentase Jumlah Wanita <br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio0" value="0">
            <label class="form-check-label" for="inlineRadio0">0%</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio1" value="10">
            <label class="form-check-label" for="inlineRadio1">10%</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio2" value="20">
            <label class="form-check-label" for="inlineRadio2">20%</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio3" value="30">
            <label class="form-check-label" for="inlineRadio3">30%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio4" value="40">
            <label class="form-check-label" for="inlineRadio4">40%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio5" value="50">
            <label class="form-check-label" for="inlineRadio5">50%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio6" value="60">
            <label class="form-check-label" for="inlineRadio6">60%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio7" value="70">
            <label class="form-check-label" for="inlineRadio7">70%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio8" value="80">
            <label class="form-check-label" for="inlineRadio8">80%</label>
        </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio9" value="90">
            <label class="form-check-label" for="inlineRadio9">90%</label>
        </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender_wanita" id="inlineRadio10" value="100">
            <label class="form-check-label" for="inlineRadio10">100%</label>
        </div>
    </div>

        <div class="form-group mt-3">
            <label for="why">Why</label>
            <input type="text" name="why" id="why" class="form-control input-rounded" placeholder="Masukan Alasan/Dasar Kegiatan" value="{{ old('why') }}">                  
            <small id="jumlah_why">0</small>
            <small> / 250 (Termasuk Spasi)</small>
            @error('why')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="who">Who</label>
            <div class="form-floating">
            <textarea class="form-control" placeholder="Masukan Pihak Yang Terlibat" id="textwho" name="who" value="{{ old('who') }}" ></textarea>
              <label for="who">Masukan Pihak Yang Terlibat</label>
            </div>
            <div id="countwho">
                <small id="jumlah_who">0</small>
                <small id="max_who">/ 1500 Karakter (Termasuk Spasi)</small>
            </div>      
            @error('who')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="how">How</label>
              <input id="how" type="hidden" name="how" value="{{ old('how') }}" placeholder="Masukan Inti Kegiatan, Bukan jadwal atau rangkaian acara" maxlength=1000>
                <trix-editor input="how"></trix-editor> 
                 <div id="progress"></div>
                 <div id="counter"></div>         
                <small>Maksimal 5000 Karakter (Termasuk Spasi)</small>
            @error('how')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <div class="row">
            <div class="col-md-6 mt-4">
            <label for="dokumentasi1">Dokumentasi 1</label>
            <input type="file" class="form-control input-rounded" name="dokumentasi1" value="{{ old('documentation1') }}">
            <small>Ukuran Gambar Maksimal 1 MB</small> 
            </div>

            <div class="col-md-6 mt-4">
            <label for="dokumentasi2">Dokumentasi 2 (Jika Ada)</label>
            <input type="file" class="form-control input-rounded" name="dokumentasi2" value="{{ old('documentation2') }}">
            <small>Ukuran Gambar Maksimal 1 MB</small>
            </div>

            <div class="col-md-6 mt-4">
            <label for="dokumentasi3">Dokumentasi 3 (Jika Ada)</label>
            <input type="file" class="form-control input-rounded" name="dokumentasi3" value="{{ old('documentation3') }}">
            <small>Ukuran Gambar Maksimal 1 MB</small>
            </div>

            <div class="col-md-6 mt-4">
            <label for="lainnya">Dokumentasi Lainnya (Jika Ada)</label>
            <input type="file" class="form-control input-rounded" name="lainnya" value="{{ old('lainnya') }}">
            <small>Ukuran File Maksimal 10 MB, Dianjurkan Dalam Bentuk PDF</small>
            </div>

            <div class="col-md-6 mt-4">
            <label for="st">Masukan Surat Tugas (Jika Ada)</label>
            <input type="file" class="form-control input-rounded" name="st" value="{{ old('st') }}">
            <small>Ukuran File Maksimal 3 MB, Dianjurkan Dalam Bentuk PDF</small>
            </div>
            </div>
        </div>

        <div class="mt-4 text-center">
         <button type="submit" class="btn btn-info float-left">Submit</button>

        @can('show user')
         <a href="{{ route('report_index') }}" class="btn btn-outline-danger mx-2 my-2 float-right">Kembali Ke 5w1H Semua</a>
         @endcan
         <a href="{{ route('myreport') }}" class="btn btn-outline-danger float-right">Kembali Ke 5w1H-Ku</a>
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
    //hitung what
    var myWhat = document.getElementById('what');
    var wordWhat = document.getElementById('jumlah_what');

    myWhat.addEventListener("keyup", function(){
        var char_what = myWhat.value.split('');
        wordWhat.innerText = char_what.length;
    });
</script>
@endsection