@extends('layouts.back')

@section('menu', 'Role')

@section('content')
    
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session ('status') }}
            </div>
            @endif
                
               <a href="{{ route('role_tambah') }}" class="btn btn-primary mb-3 float-right" role="button">
                + Tambah Role
               </a>
                <div class="table table-responsive">
                    <table class="table table-hover" id="crudTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                 <th>Name</th>
                                 <th>Guard Name</th>
                                 <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                                
                        </tbody>
                   </table>
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
            ]
        });
    </script>
@endpush