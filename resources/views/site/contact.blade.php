@extends('layouts.app')
@include('partials.navbar')

@if (isset($contact) && $contact)

    <style>
        .contact-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
            padding-top: 140px;
            padding-bottom: 80px;
        }

        .contact-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
            transition: .3s ease-in-out;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .contact-card p {
            font-size: 1.05rem;
            color: #555;
            margin-bottom: 14px;
        }

        .contact-icon {
            font-size: 1.3rem;
            color: #0d6efd;
            margin-right: 8px;
        }

        .contact-title {
            font-size: 2rem;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .contact-card {
                padding: 30px 20px;
            }

            .contact-title {
                font-size: 1.7rem;
            }
        }
    </style>

    <div class="container contact-section">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="contact-card text-center">

                    <h2 class="contact-title">Contato</h2>

                    @if(!empty($contact->phone))
                        <p>
                            <i class="bi bi-telephone contact-icon"></i>
                            <a href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}"
                                class="text-decoration-none text-secondary">
                                {{ $contact->phone }}
                            </a>
                        </p>
                    @endif

                    @if(!empty($contact->email))
                        <p>
                            <i class="bi bi-envelope contact-icon"></i>
                            <a href="mailto:{{ $contact->email }}" class="text-decoration-none text-secondary">
                                {{ $contact->email }}
                            </a>
                        </p>
                    @endif

                    @if(!empty($contact->city) || !empty($contact->state))
                        <p>
                            <i class="bi bi-building contact-icon"></i>
                            {{ $contact->city }}/{{ $contact->state }}
                        </p>
                    @endif

                    @if(!empty($contact->address))
                        <p>
                            <i class="bi bi-geo-alt-fill contact-icon"></i>
                            {{ $contact->address }}
                        </p>
                    @endif

                    @if(!empty($contact->zipcode))
                        <p>
                            <i class="bi bi-mailbox contact-icon"></i>
                            CEP {{ $contact->zipcode }}
                        </p>
                    @endif

                </div>

            </div>
        </div>
    </div>

@endif

@include('partials.footer')