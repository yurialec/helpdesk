@php
    $logo = App\Models\Site\SiteLogo::first();
@endphp

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