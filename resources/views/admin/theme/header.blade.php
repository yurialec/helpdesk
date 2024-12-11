@php
    $tecnico = Auth::user()->role_id === 5 ? true : false;
@endphp

<header-component
    url-profile="{{ route('profile.view') }}"
    url-my-chats="{{ route('attendants.my.chats') }}"
    url-sair="{{ route('logout') }}" logo="{{ App\Models\Site\SiteLogo::first()->image ?? '' }}"
    url-home="{{ route('home') }}"
    :is-tecnico="{{ json_encode($tecnico) }}">
</header-component>
