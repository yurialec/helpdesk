@php
    $logo = App\Models\Site\SiteLogo::first();
@endphp

<style>
    .navbar-custom {
        height: 80px;
        transition: all .3s ease;
    }

    .navbar-custom.scrolled {
        background: #ffffff !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important;
    }

    .nav-link {
        font-weight: 500;
        font-size: 0.96rem;
        padding: 12px 18px !important;
        transition: 0.2s ease-in-out;
        color: #444 !important;
    }

    .nav-link:hover {
        color: #0d6efd !important;
        transform: translateY(-1px);
    }

    .nav-link.active {
        color: #0d6efd !important;
        font-weight: 600;
    }

    .navbar-brand img {
        max-height: 55px;
        object-fit: contain;
    }

    .navbar-toggler {
        border: none !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top navbar-custom">
    <div class="container">

        {{-- LOGO --}}
        <a class="navbar-brand" href="/">
            @if ($logo)
                <img src="{{ asset('/storage/' . $logo->image) }}" alt="Logo" class="rounded">
            @else
                <span class="fw-bold text-primary">Home</span>
            @endif
        </a>

        {{-- TOGGLER --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- LINKS --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="/">Início</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">Sobre</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#carousel">Galeria</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contato</a>
                </li>

                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-primary px-3 py-1 rounded-pill" href="{{ route('login') }}">
                        Área Restrita
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<script>
    // efeito navbar ao rolar
    document.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar-custom");
        if (window.scrollY > 20) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
</script>