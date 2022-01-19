@extends('layouts.back')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

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
@endpush

@section('menu', 'Input 5W1H')

@section('content')


    <form action="{{ route('report_post') }}" method="post" enctype="multipart/form-data">
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

        <div class="form-group">
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

       <div class="form-group">
            <label for="no_st">Nomor Surat Tugas</label>
            <input type="text" name="no_st" id="no_st" class="form-control input-rounded" placeholder="Masukan Nomor Surat Tugas" value="{{ old('no_st') }}">                  
            @error('no_st')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group">
            <label for="what">What</label>
            <input type="text" name="what" id="what" class="form-control input-rounded" placeholder="Masukan Judul Kegiatan" value="{{ old('what') }}">                  
            @error('what')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control input-rounded" placeholder="Slug Otomatis Sesuai What" value="{{ old('slug') }}" readonly>                  
        @error('slug')
        <div class="text-danger mt-2 d-block">{{ $message }}</div>
        @enderror                                  
      </div>

       <div class="form-group">
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

       <div class="form-group">
            <label for="where">Where</label>
            <input type="text" name="where" id="where" class="form-control input-rounded" placeholder="Masukan Lokasi/Tempat" value="{{ old('where') }}">                  
            @error('where')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>
        <div class="row">
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

        <div class="form-group">
            <label for="total_jam">Jumlah Jam</label>
            <input type="text" name="total_jam" id="total_jam" class="form-control input-rounded" placeholder="Masukan Jumlah Jam" value="{{ old('total_jam') }}" step="0.01">                  
            @error('total_jam')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group">
            <label for="why">Why</label>
            <input type="text" name="why" id="why" class="form-control input-rounded" placeholder="Masukan Alasan/Dasar Kegiatan" value="{{ old('why') }}">                  
            @error('why')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group">
            <label for="who">Who</label>
            <input type="text" name="who" id="who" class="form-control input-rounded" placeholder="Masukan Pihak Yang Terlibat" value="{{ old('who') }}">                  
            @error('who')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group">
            <label for="how">How</label>
            
              <input id="how" type="hidden" name="how" value="{{ old('how') }}" placeholder="Masukan Inti Kegiatan, Bukan jadwal atau rangkaian acara">
                <trix-editor input="how"></trix-editor>
                <small>Maksimal 700 Karakter (Termasuk Spasi)</small>              
            @error('how')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group">
            <div class="row">
            <div class="col-md-6">
            <label for="dokumentasi1">Dokumentasi 1</label>
            <input type="file" class="form-control input-rounded" name="dokumentasi1" value="{{ old('documentation1') }}">
            <small>Ukuran Gambar Maksimal 1 MB</small>
            </div>

            <div class="col-md-6">
            <label for="dokumentasi2">Dokumentasi 2 (Jika Ada)</label>
            <input type="file" class="form-control input-rounded" name="dokumentasi2" value="{{ old('documentation2') }}">
            <small>Ukuran Gambar Maksimal 1 MB</small>
            </div>

            <div class="col-md-6">
            <label for="dokumentasi3">Dokumentasi 3 (Jika Ada)</label>
            <input type="file" class="form-control input-rounded" name="dokumentasi3" value="{{ old('documentation3') }}">
            <small>Ukuran Gambar Maksimal 1 MB</small>
            </div>

            <div class="col-md-6">
            <label for="lainnya">Dokumentasi Lainnya (Jika Ada)</label>
            <input type="file" class="form-control input-rounded" name="lainnya" value="{{ old('lainnya') }}">
            <small>Ukuran File Maksimal 10 MB, Dianjurkan Dalam Bentuk PDF</small>
            </div>

            <div class="col-md-6">
            <label for="st">Masukan Surat Tugas (Jika Ada)</label>
            <input type="file" class="form-control input-rounded" name="st" value="{{ old('st') }}">
            <small>Ukuran File Maksimal 3 MB, Dianjurkan Dalam Bentuk PDF</small>
            </div>
            </div>
        </div>

         <button type="submit" class="btn btn-info">Submit</button>
           @can('show user')
         <a href="{{ route('report_index') }}" class="btn btn-outline-danger mr-2 float-right">Kembali Ke 5w1H Semua</a>
         @endcan
         <a href="{{ route('myreport') }}" class="btn btn-outline-danger mr-2 float-right">Kembali Ke 5w1H-Ku</a>
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
@endsection