@extends('layouts.app')

@include('partials.navbar')

<style>
    .section-about {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding-top: 120px;
        padding-bottom: 80px;
    }

    .about-title {
        font-size: 2.4rem;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 1rem;
    }

    .about-description {
        font-size: 1.2rem;
        line-height: 1.6;
        color: #444;
        margin-top: .5rem;
    }

    .about-image {
        max-width: 100%;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        transition: .3s ease-in-out;
    }

    .about-image:hover {
        transform: translateY(-6px);
    }

    @media (max-width: 768px) {
        .about-title {
            font-size: 2rem;
        }

        .about-description {
            font-size: 1.1rem;
        }
    }
</style>


<div class="container section-about">
    <div class="row justify-content-center align-items-center text-center text-md-start">

        {{-- IMAGEM --}}
        @if (!empty($about?->image))
            <div class="col-md-4 mb-4">
                <img src="{{ '/storage/' . $about->image }}" class="about-image" alt="Sobre">
            </div>
        @endif

        {{-- TEXTOS --}}
        <div class="col-md-5">
            @if (!empty($about?->title))
                <h1 class="about-title">
                    {{ $about->title }}
                </h1>
            @endif

            @if (!empty($about?->description))
                <p class="about-description">
                    {{ $about->description }}
                </p>
            @endif
        </div>

    </div>
</div>

@include('partials.footer')