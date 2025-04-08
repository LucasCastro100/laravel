@extends('layouts.app')

@section('titlePage', $titlePage)
@section('bodyId', $bodyId)
@section('bodyClass', $bodyClass)

@section('header')
    {{-- @include('includes.web.header') --}}
    <header class="col-12">
        <h5 class="bold text-center m-0">Plataforma em desenvolvimento - somente para grupo de validação</h5>
    </header>
@endsection

@section('main')
    <section class="h-100">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-6 col-12">
                    <div class="info-title-img text-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img/web/logo_cabecalho.png') }}" alt="Logo Permuta Brasil"
                                title="Logo Permuta Brasil" class="w-50" />

                                <img src="{{ asset('img/web/slogan.png') }}" alt="Slogan Permuta Brasil"
                                title="Slogan Permuta Brasil" class="w-50" />
                        </a>
                    </div>

                    <div class="info-title-btn mb-1 d-flex justify-center">
                        <ul class="d-flex justify-center flex-direction-column gap">
                            <li class="login"><a href="{{ route('login') }}" class="bold">ACESSO EXCLUSIVO</a></li>
                            <li class="convity"><a href="{{ route('convity.index') }}" class="bold">TENHO INTERESSE</a></li>
                        </ul>
                        
                    </div>

                    <div class="info-title-icon">
                        <ul class="menu-itens d-flex align-center justify-center flex-direction-row gap">
                            <li><a href="https://www.youtube.com/@permuta.brasil" alt="Youtube" title="Youtube"
                                    target="_blank"><i class="social-midia fa-brands fa-youtube"></i></a></li>

                            <li><a href="https://www.facebook.com/share/Jan3ZVzKWojdHs6y/?mibextid=LQQJ4d" alt="Facebook"
                                    title="Facebook" target="_blank"><i
                                        class="social-midia fa-brands fa-facebook-f"></i></a></li>

                            <li><a href="https://www.linkedin.com/in/permutabrasil" alt="Linkedin" title="Linkedin"
                                    target="_blank"><i class="social-midia fa-brands fa-linkedin-in"></i></a></li>

                            <li><a href="https://www.instagram.com/permuta.brasil" alt="Instagram" title="Instagram"
                                    target="_blank"><i class="social-midia fa-brands fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 d-flex justify-center">
                    <div class="col-lg-9 col-12 text-center">
                        <img src="{{ asset('img/web/texto_home_desenvolvimento.png') }}"
                            alt="Plataforma de permutas para Pequenos negócios, o acesso que faltava para o seu sucesso!"
                            title="Plataforma de permutas para Pequenos negócios, o acesso que faltava para o seu sucesso!"
                            class="w-75" />
                    </div>
                </div>

                <div class="col-12 d-flex justify-center">
                    <div class="col-lg-9 col-12 text-right">
                        <img src="{{ asset('img/web/lancamento_em_breve.png') }}" alt="Lançamento em breve"
                            title="Lançamento em breve" class="w-50" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    {{-- @include('includes.web.footer') --}}
    <footer class="col-12">
        <h5 class="bold text-center m-0">© 2024 - PERMUTA BRASIL</h5>
    </footer>
@endsection
