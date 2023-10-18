@extends('layouts.back')

@section('content')
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
@livewireStyles
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                        @livewire('iku.dashboardperiku', [
                            'indicator_kiriman' => $indicator
                        ])
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
@endsection