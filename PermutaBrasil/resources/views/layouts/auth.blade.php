@extends('layouts._base')

@section('bodyContent')
    <main>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('home') }}" class="text-center">
                            <img src="{{ asset('img/web/logo_cabecalho.png') }}" alt="Logo Permuta Brasil"
                                title="Logo Permuta Brasil" class="col-lg-4 col-6">
                        </a>
                    </div>

                    @yield('main')
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        @vite(['resources/js/dashboard.js'])
    @endpush
@endsection
