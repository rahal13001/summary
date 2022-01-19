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
             placeholder:"Pilih Status",
             width : "100%"
         });
});
    </script>
@endpush

@section('menu', 'Edit IKU')

@section('content')

<form action="{{ route('indicator_update', $indicator) }}" method="post">
                        @csrf
                        @method('put')
                            <div class="form-group">
                                <label for="nama">Nama IKU</label>
                                <input type="text" name="nama" id="nama" class="form-control input-rounded" placeholder="Masukan Nama IKU" value="{{ $indicator->nama }}">                  
                                @error('nama')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control input-rounded" placeholder="Masukan Slug" value="{{ $indicator->slug }}">                  
                                @error('slug')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>

                            <div class="form-group">
                                <label for="nomor">Nomor IKU</label>
                                <input type="number" name="nomor" id="nomor" class="form-control input-rounded" placeholder="Masukan Nomor IKU" value="{{ $indicator->nomor }}">
                                @error('nomor')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control input-rounded" placeholder="Masukan Tahun" value="{{ $indicator->tahun }}">                  
                                @error('tahun')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>
                          
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control input-rounded select2">
                                     <option disabled selected>Pilih Status</option>
                                   
                                    <option selected value="{{ $indicator->status }}"> {{ $indicator->status }}</option>
                                 
                                    @if ($indicator->status == "Aktif")
                                        <option>Tidak Aktif</option>
                                    @else
                                        <option>Aktif</option>
                                    @endif                        
                                </select>        
                                @error('status')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>

                            <button type="submit" class="btn btn-info">Submit</button>
                            <a href="{{ route('indicator_create') }}" class="btn btn-danger">Batal</a>
                        </form>

                        <script>
                                const nama = document.querySelector('#nama');
                                const slug = document.querySelector('#slug');

                                nama.addEventListener('change', function(){
                                    fetch('/5w1h/post/checkSlug?nama='+nama.value)
                                    .then(response => response.json())
                                    .then(data => slug.value = data.slug)
                                });
                        </script>

@endsection