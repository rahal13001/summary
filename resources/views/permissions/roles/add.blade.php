@extends('layouts.back')

@section('menu', 'Tambah Role')

@section('content')
     <div class="basic-form ">
        <form method="POST" action="{{ route('role_simpan') }}">
            @csrf
           <div class="form-group">
              <label for="name">Nama Role</label>             
              <input type="text" class="form-control input-rounded input-focus" placeholder="Masukan Nama Role" name = "name" id="name"
               value="{{ old('name') }}"
               @error('name') is-invalid @enderror>
               @error('name') <div class="invalid-feedback"> {{ $message }} </div> @enderror
            </div>
            <div class="form-group">
               <label for="guard_name">Guard Name</label>
               <input type="text" class="form-control input-rounded" placeholder="Default web" name="guard_name" id="guard_name"
               value="{{ old('guard_name') ?? 'web'}}"
               @error('guard_name') is-invalid @enderror>
               @error('guard_name') <div class="invalid-feedback"> {{ $message }} </div> @enderror
               <small>Kosongkan jika pilihan anda adalah web</small>
            </div>
            <button type="submit" class="btn btn-info">Simpan</button>
            <a href="{{ route('role_index') }}" class="btn btn-danger ml-3">Batal</a>
        
        </form>
     </div>
        
@endsection