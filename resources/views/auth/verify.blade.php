@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                    {{ __('Silahkan Verifikasi Alamat Email Anda Terlebih Dahulu') }}
                    </div>
                    <div>
                            {{ Auth::user()->email }}
                        </div>
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Link verifikasi baru telah dikirimkan ke email anda.') }}
                        </div>
                      
                    @endif
                    

                    <div class="mt-3 mb-2">
                    {{ __('Sebelum melanjutkan aktivitas, mohon cek email anda.') }}
                    {{ __('Jika Tidak Menemukan Link Verifikasi') }},
                    </div>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik Disini Untuk Mendapatkan Link') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
