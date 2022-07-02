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
             placeholder:"Pilih Role",
             width : "100%"
         });
});
    </script>
@endpush

@section('menu', 'Assign User')
@section('content')
                    <form action="{{ route('user_update', $user->id) }}" method="post">
                        @method('put')
                        @csrf
                            <div class="form-group mt-3">
                                <label for="user">User</label>
                                <select name="user" id="user" class="form-control input-rounded select2">
                                <option disabled selected>Pilih User</option>
                                    @foreach ($users as $pengguna)
                                    <option {{ $user->id == $pengguna->id ? 'selected' : '' }} value="{{ $pengguna->id }}"> {{ $pengguna->name }}</option>
                                    @endforeach
                                </select> 
                                                                
                                @error('user')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>
                            <div class="form-group mt-3">
                            <label for="roles">Pilih Role</label>
                            <select name="roles[]" id="roles" class="form-control input-rounded select2" multiple>
                                @foreach ($roles as $peran)
                                <option {{ $user->roles()->find($peran->id) ? 'selected' : '' }} value="{{ $peran->id }}"> {{ $peran->name }}</option>
                                @endforeach
                            </select> 
                            @error('roles')
                                <div class="text-danger mt-2 d-block">{{ $message }}</div>
                            @enderror
                            </div>
                            <button type="submit" class="btn btn-info mt-4">Assign</button>
                            <a href="{{ route('user_create') }}" class="btn btn-danger mt-4 mx-2">Batal</a>
                        </form>
@endsection