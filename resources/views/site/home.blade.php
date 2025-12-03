@extends('site.layouts.app')

@section('content')

    {{-- HERO SECTION --}}
    @if(isset($mainText))
        <section id="home" class="hero-section">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h1 class="fw-bold">{{ $mainText->title }}</h1>
                        <p class="mt-3">{{ $mainText->text }}</p>
                    </div>

                    <div class="col-lg-6">
                        <img src="{{ asset('img/tela-widescreen.jpg') }}" alt="Hero Image" class="img-fluid">
                    </div>

                </div>
            </div>
        </section>
    @endif


    {{-- ABOUT SECTION --}}
    @if(isset($about))
        <section id="about" class="section-padding about-section bg-white">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img src="{{ 'storage/' . $about->image }}" alt="Sobre" class="img-fluid">
                    </div>

                    <div class="col-lg-6">
                        <h2 class="text-primary mb-4">{{ $about->title }}</h2>
                        <p class="mb-4">{{ $about->description }}</p>

                        <div class="row about-stats">
                            <div class="col-6 text-center">
                                <h3 class="text-primary">100+</h3>
                                <p>Clientes Satisfeitos</p>
                            </div>
                            <div class="col-6 text-center">
                                <h3 class="text-primary">5+</h3>
                                <p>Anos de Experiência</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif


    {{-- CAROUSEL --}}
    @if(!empty($carousels) && count($carousels))
        <section id="carousel" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">

                        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">

                            <div class="carousel-indicators">
                                @foreach ($carousels as $i => $carousel)
                                    <button style="background-color: #0d6efd;" type="button" data-bs-target="#mainCarousel"
                                        data-bs-slide-to="{{ $i }}" @class(['active' => $i === 0]) aria-label="Slide {{ $i + 1 }}">
                                    </button>
                                @endforeach
                            </div>

                            <div class="carousel-inner rounded">
                                @foreach ($carousels as $carousel)
                                    <div class="carousel-item @if($loop->first) active @endif">
                                        <img src="{{ 'storage/' . $carousel->image }}" class="d-block w-100"
                                            style="object-fit: cover; aspect-ratio: 16/9;" loading="lazy">
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-primary rounded-circle" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-primary rounded-circle" aria-hidden="true"></span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    {{-- CONTACT FORM + BOXES --}}
    <section id="contact" class="section-padding bg-light">
        <div class="container">

            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="text-primary fw-bold">Entre em Contato</h2>
                    <p class="lead">Estamos aqui para ajudar você</p>
                </div>
            </div>

            <div class="row">
                {{-- FORM --}}
                <div class="col-lg-8 mx-auto mb-5">
                    <div class="contact-form">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Assunto</label>
                                <input type="text" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mensagem</label>
                                <textarea class="form-control" rows="5" required></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection