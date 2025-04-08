@extends('layouts._base')

@section('bodyContent')
    <aside>
        @include('includes.auth.aside')
    </aside>

    <main>
        @yield('header')

        @yield('main')
    </main>

    @push('scripts')
        @vite(['resources/js/app.js', 'resources/js/dashboard.js'])
    @endpush
@endsection
