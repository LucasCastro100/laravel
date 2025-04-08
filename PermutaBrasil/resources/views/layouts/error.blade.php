@extends('layouts._base')

@section('bodyContent')
    @yield('header')

    @yield('main')

    @push('scripts')
        @vite(['resources/js/dashboard.js'])
    @endpush
@endsection
