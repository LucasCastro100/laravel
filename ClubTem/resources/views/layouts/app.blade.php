@extends('layouts._base')

@section('bodyContent')
    @yield('header')

    <main class="position-img">
        @yield('main')
    </main>

    @yield('footer')

    @push('scripts')
        @vite(['resources/js/web.js'])        
    @endpush
@endsection
