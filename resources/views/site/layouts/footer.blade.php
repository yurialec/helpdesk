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