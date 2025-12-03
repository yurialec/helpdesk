@extends('site.layouts.app')

@section('content')

    <style>
        /* HERO */
        .hero-section {
            padding: 140px 0 80px;
            background: linear-gradient(135deg, #eef3ff 0%, #ffffff 100%);
        }

        .hero-section h1 {
            font-size: 3rem;
            line-height: 1.2;
            color: #0d6efd;
        }

        .hero-section p {
            font-size: 1.2rem;
            color: #444;
        }

        .hero-section img {
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: .3s;
        }

        .hero-section img:hover {
            transform: translateY(-6px);
        }

        /* ABOUT */
        .section-padding {
            padding: 90px 0;
        }

        .about-section img {
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .about-section h2 {
            font-weight: 700;
            font-size: 2.2rem;
        }

        .about-stats h3 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: .2rem;
        }

        .about-stats p {
            margin: 0;
            color: #555;
        }

        /* CAROUSEL */
        #mainCarousel img {
            border-radius: 16px;
        }

        .carousel-indicators [data-bs-target] {
            height: 12px;
            width: 12px;
            border-radius: 50%;
        }

        /* CONTACT FORM */
        .contact-form {
            background: #fff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .contact-form button {
            padding: 12px 35px;
            font-size: 1.1rem;
            border-radius: 50px;
        }

        .contact-info-box i {
            color: #0d6efd;
        }

        .contact-info-box {
            background: #fff;
            border-radius: 16px;
            padding: 25px 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
            transition: .25s;
        }

        .contact-info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }
    </style>


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

            {{-- 3 BOXES --}}
            <div class="row mt-5">
                <div class="col-lg-4 text-center mb-4">
                    <div class="contact-info-box">
                        <i class="fas fa-map-marker-alt fa-2x mb-3"></i>
                        <h5>Endereço</h5>
                        <p>Rua Exemplo, 123<br>Cidade - Estado<br>CEP: 12345-678</p>
                    </div>
                </div>

                <div class="col-lg-4 text-center mb-4">
                    <div class="contact-info-box">
                        <i class="fas fa-phone fa-2x mb-3"></i>
                        <h5>Telefone</h5>
                        <p>(11) 99999-9999<br>(11) 3333-3333</p>
                    </div>
                </div>

                <div class="col-lg-4 text-center mb-4">
                    <div class="contact-info-box">
                        <i class="fas fa-envelope fa-2x mb-3"></i>
                        <h5>E-mail</h5>
                        <p>contato@exemplo.com<br>vendas@exemplo.com</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection