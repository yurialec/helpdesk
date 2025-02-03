<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ session('domain') }}
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a
                        href="{{ route('about', ['tenancy' => session('domain') ?? request()->route('tenancy')]) }}">Sobre</a>
                </li>
                <li><a
                        href="{{ route('contact', ['tenancy' => session('domain') ?? request()->route('tenancy')]) }}">Contato</a>
                </li>
                <li><a href="{{ route('login', ['tenancy' => session('domain') ?? request()->route('tenancy')]) }}">Área
                        Restrita</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
        const body = document.querySelector('body');

        mobileNavToggle.addEventListener('click', function() {
            body.classList.toggle('mobile-nav-active');
        });
    });
</script>
