@extends('layouts.back')

@section('menu', 'Edit Permission')

@section('content')
     <div class="basic-form ">
        <form method="POST" action="{{ route('permission_update', $permission->id) }}">
            @csrf
            @method('PUT')
           <div class="form-group">
              <label for="name">Nama Permission</label>
               <input type="text" class="form-control input-rounded input-focus" placeholder="Masukan Nama Permission" name = "name" id="name"
               value="{{ $permission->name }}"
               @error('name') is-invalid @enderror>
               @error('name') <div class="invalid-feedback"> {{ $message }} </div> @enderror
            </div>
            <div class="form-group">
               <label for="guard_name">Guard Name</label>
               <input type="text" class="form-control input-rounded" placeholder="Default web" name="guard_name" id="guard_name"
               value="{{$permission->guard_name }}"
               @error('guard_name') is-invalid @enderror>
               @error('guard_name') <div class="invalid-feedback"> {{ $message }} </div> @enderror
               <small>Kosongkan jika pilihan anda adalah web</small>
            </div>
            <button type="submit" class="btn btn-info">Edit</button>
            <a href="{{ route('permission_index') }}" class="btn btn-danger ml-3">Batal</a>
        
        </form>
     </div>
        
@endsection