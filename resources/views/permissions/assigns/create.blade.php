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
             placeholder:"Pilih Hak Akses",
             width : "100%"
         });
});
    </script>
@endpush

@section('menu', 'Assign Role')

@section('content')
    
     @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session ('status') }}
            </div>
     @endif

    

    <div class="card-body p-b-0">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs customtab" role="tablist">
				<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Lihat Hak Akses</span></a> </li>
			    <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Pemberian Akses</span></a> </li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
                <div class="tab-pane " id="home2" role="tabpanel">
                    <div class="p-20">
                        <form action="{{ route('assign_post') }}" method="post">
                        @csrf
                            <div class="form-group">
                                <label for="name">Nama Role</label>
                                <select name="name" id="name" class="form-control input-rounded select2">
                                <option disabled selected>Pilih Role</option>
                                    @foreach ($role as $peran)
                                    <option value="{{ $peran->id }}"> {{ $peran->name }}</option>
                                    @endforeach
                                </select> 
                                                                
                                @error('name')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>
                            <div class="form-group">
                            <label for="permission">Permission</label>
                            <select name="permission[]" id="permission" class="form-control input-rounded select2" multiple>
                                @foreach ($permission as $hak)
                                <option value="{{ $hak->id }}"> {{ $hak->name }}</option>
                                @endforeach
                            </select> 
                            @error('permission')
                                <div class="text-danger mt-2 d-block">{{ $message }}</div>
                            @enderror
                            </div>
                            <button type="submit" class="btn btn-info">Assign</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane active p-20" id="profile2" role="tabpanel">
                    <div class="table table-responsive">
                        <table class="table table-hover w-100" id="crudTable" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Guard Name</th>
                                    <th>Hak Akses</th>
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
                    {data: 'name', name : 'name'},
                    {data: 'guard_name', name : 'guard_name'},
                    {
                        data: 'aksi',
                        name : 'aksi',
                        orderable : false,
                        searchable : false,
                        width : '15%'
                    },
                    {
                        data: 'sync',
                        name : 'sync',
                        orderable : false,
                        searchable : false,
                        width : '15%'
                    },
            ]
        });
    </script>
@endpush