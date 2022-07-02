@extends('layouts.back')

@section('menu', 'Ubah Password')

@section('content')

        @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session ('error') }}
                    </div>
        @endif

            @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session ('status') }}
                    </div>
        @endif
    <form action="{{ route('password_update', $password) }}" method="post">
       @csrf
       @method('patch')
      
       <div class="form-group mt-3">
            <label for="old_password">Password Baru</label>
            <input type="password" name="old_password" id="old_password" class="form-control input-rounded" placeholder="Masukan Password Lama Anda">                  
            @error('old_password')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="password">Password Baru</label>
            <input type="password" name="password" id="password" class="form-control input-rounded" placeholder="Masukan Password Baru" value="{{ old('password') }}">                  
            @error('password')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="form-group mt-3">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-rounded" placeholder="Masukan Password Baru" value="{{ old('password_confirmation') }}">                  
            @error('password_confirmation')
            <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror                                  
        </div>

        <div class="mt-4">
         <button type="submit" class="btn btn-info">Submit</button>
           @can('show user')
         <a href="{{ route('report_index') }}" class="btn btn-outline-danger mr-2 float-right">Kembali Ke 5w1H Semua</a>
         @endcan
         <a href="{{ route('myreport') }}" class="btn btn-outline-danger mr-2 float-right">Kembali Ke 5w1H-Ku</a>
         </div>
    </form>

@endsection