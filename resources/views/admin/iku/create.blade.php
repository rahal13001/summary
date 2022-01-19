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

@section('menu', 'Indikator Kinerja Utama')

@section('content')
    
     @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session ('status') }}
            </div>
     @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             Penambahan Data Gagal !!!
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    

    <div class="card-body p-b-0">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs customtab" role="tablist">
                
                @if ($errors->any() == null)
				<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-eye"></i></span> <span class="hidden-xs-down">Lihat IKU</span></a> </li>

                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-pencil-alt"></i></span> <span class="hidden-xs-down">Tambah IKU</span></a> </li>

			    @elseif ($errors->any() !== null)
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-eye"></i></span> <span class="hidden-xs-down">Lihat IKU</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-pencil-alt"></i></span> <span class="hidden-xs-down">Tambah IKU</span></a> </li>
                @endif
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
                @if ($errors->any() == null)
                <div class="tab-pane" id="home2" role="tabpanel">   
                @elseif ($errors->any() !== null)
                    <div class="tab-pane active" id="home2" role="tabpanel">      
                @endif
        
                   <div class="p-20">
                        <form action="{{ route('indicator_post') }}" method="post">
                        @csrf
                            <div class="form-group">
                                <label for="nama">Nama IKU</label>
                                <input type="text" name="nama" id="nama" class="form-control input-rounded" placeholder="Masukan Nama IKU" value="{{ old('nama') }}">                  
                                @error('nama')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control input-rounded" placeholder="Masukan Slug" value="{{ old('slug') }}">                  
                                @error('slug')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>

                            <div class="form-group">
                                <label for="nomor">Nomor IKU</label>
                                <input type="number" name="nomor" id="nomor" class="form-control input-rounded" placeholder="Masukan Nomor IKU" value="{{ old('nomor') }}">
                                @error('nomor')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control input-rounded" placeholder="Masukan Tahun" value="{{ old('tahun') }}">                  
                                @error('tahun')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control input-rounded select2">
                                    <option disabled selected>Pilih Status</option>
                                    <option>Aktif</option>
                                    <option>Tidak Aktif</option>
                                </select>        
                                @error('status')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>

                            <button type="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>
                </div>


                @if ($errors->any() == null)
                <div class="tab-pane active p-20" id="profile2" role="tabpanel">
                 @elseif ($errors->any() !== null)  
                    <div class="tab-pane p-20" id="profile2" role="tabpanel">
                @endif
                    <div class="table table-responsive">
                        <table class="table table-hover w-100" id="crudTable" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Nomor IKU</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                                    
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="tab-pane p-20" id="messages2" role="tabpanel">

                </div> --}}
			</div>
	</div>


        
@endsection
@push('addon-script')
    <script>
        // AJAX DataTable
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                    {data: 'id', 
                    sortable: false, 
                       render: function (data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                      }},
                    {data: 'nama', name : 'nama'},
                    {data: 'nomor', name : 'nomor'},
                    {data: 'tahun', name : 'tahun'},
                    {data: 'status', name : 'status'},
                    {
                        data: 'aksi',
                        name : 'aksi',
                        orderable : false,
                        searchable : false,
                        width : '15%'
                    }
            ]
        });


    const nama = document.querySelector('#nama');
    const slug = document.querySelector('#slug');

    nama.addEventListener('change', function(){
        fetch('/5w1h/post/checkSlug?nama='+nama.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    });
    </script>
@endpush