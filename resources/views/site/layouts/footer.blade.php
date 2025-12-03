<style>
    footer.footer-modern {
        background: #0f0f0f;
        padding: 60px 0 30px;
        position: relative;
    }

    footer .footer-title {
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #fff;
        margin-bottom: 1.2rem;
        text-transform: uppercase;
    }

    footer .footer-link,
    footer .footer-link i {
        color: rgba(255, 255, 255, 0.6) !important;
        transition: .2s ease-in-out;
        font-size: 0.95rem;
    }

    footer .footer-link:hover,
    footer .footer-link:hover i {
        color: #0d6efd !important;
        transform: translateX(3px);
    }

    footer .social-links a {
        width: 38px;
        height: 38px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
    }

    footer .social-links a:hover {
        background: #0d6efd;
        transform: translateY(-3px);
    }

    footer .social-links i {
        color: #fff;
        font-size: 1.1rem;
    }

    footer hr {
        border-color: rgba(255, 255, 255, 0.1);
    }

    footer .legal-text {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
    }
</style>

<footer class="footer-modern">
    <div class="container">
        <div class="row">

            {{-- Redes sociais --}}
            <div class="col-lg-4 mb-4">
                @if(!empty($socialmedias) && count($socialmedias) > 0)
                    <h6 class="footer-title">Redes Sociais</h6>

                    <nav class="social-links d-flex gap-3">
                        @foreach($socialmedias as $social)
                            @php
                                $url = $social->url ?? '#';
                                $name = $social->name ?? 'Social';
                                $icon = $social->icon ?? 'bi bi-globe';
                            @endphp
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" title="{{ $name }}">
                                <i class="{{ $icon }}"></i>
                            </a>
                        @endforeach
                    </nav>
                @endif
            </div>

            {{-- Links rápidos --}}
            <div class="col-lg-2 mb-4">
                <h6 class="footer-title">Links Rápidos</h6>
                <ul class="list-unstyled">
                    <li><a href="#home" class="footer-link d-block mb-2">Início</a></li>
                    <li><a href="#carousel" class="footer-link d-block mb-2">Galeria</a></li>
                    <li><a href="#contact" class="footer-link d-block mb-2">Contato</a></li>
                    <li><a href="{{ route('login') }}" class="footer-link d-block">Área Restrita</a></li>
                </ul>
            </div>

            {{-- Contato --}}
            <div class="col-lg-4 mb-4">
                <h6 class="footer-title">Contato</h6>

                <ul class="list-unstyled">

                    @if(!empty($contact?->phone))
                        <li class="mb-2">
                            <a class="footer-link text-decoration-none d-flex align-items-center"
                                href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}">
                                <i class="fas fa-phone-alt me-2"></i>{{ $contact->phone }}
                            </a>
                        </li>
                    @endif

                    @if(!empty($contact?->email))
                        <li class="mb-2">
                            <a class="footer-link text-decoration-none d-flex align-items-center"
                                href="mailto:{{ $contact->email }}">
                                <i class="fas fa-envelope me-2"></i>{{ $contact->email }}
                            </a>
                        </li>
                    @endif

                    @if(!empty($contact?->city))
                        <li class="footer-link mb-2 d-flex align-items-center">
                            <i class="fas fa-city me-2"></i>{{ $contact->city }}
                        </li>
                    @endif

                    @if(!empty($contact?->state))
                        <li class="footer-link mb-2 d-flex align-items-center">
                            <i class="fas fa-map me-2"></i>{{ $contact->state }}
                        </li>
                    @endif

                    @php
                        $hasAddress = !empty($contact?->address) || !empty($contact?->zipcode);
                        $mapsQuery = trim(($contact->address ?? '') . ' ' . ($contact->city ?? '') . ' ' . ($contact->state ?? '') . ' ' . ($contact->zipcode ?? ''));
                    @endphp

                    @if($hasAddress)
                        <li class="mb-2 d-flex align-items-center">
                            <i class="fas fa-map-marker-alt me-2 text-white-50"></i>
                            @if(!empty($mapsQuery))
                                <a class="footer-link text-decoration-none"
                                    href="https://www.google.com/maps/search/{{ urlencode($mapsQuery) }}" target="_blank"
                                    rel="noopener noreferrer">
                                    {{ $contact->address ?? '' }}
                                    {{ !empty($contact?->address) && !empty($contact?->zipcode) ? ' - ' : '' }}
                                    {{ $contact->zipcode ?? '' }}
                                </a>
                            @else
                                <span class="footer-link">
                                    {{ $contact->address ?? '' }}
                                    {{ !empty($contact?->address) && !empty($contact?->zipcode) ? ' - ' : '' }}
                                    {{ $contact->zipcode ?? '' }}
                                </span>
                            @endif
                        </li>
                    @endif
                </ul>
            </div>

        </div>

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="legal-text mb-0">
                    &copy; {{ now()->year }} {{ $config->company_name ?? 'Sua Empresa' }} — Todos os direitos
                    reservados.
                </p>
            </div>

            <div class="col-md-6 text-md-end">

                <a href="{{ $config->privacy_url ?? '#' }}"
                    class="footer-link me-3 {{ empty($config?->privacy_url) ? 'disabled' : '' }}" target="_blank"
                    rel="noopener noreferrer">
                    Política de Privacidade
                </a>

                <a href="{{ $config->terms_url ?? '#' }}"
                    class="footer-link {{ empty($config?->terms_url) ? 'disabled' : '' }}" target="_blank"
                    rel="noopener noreferrer">
                    Termos de Uso
                </a>

            </div>
        </div>
    </div>
</footer>