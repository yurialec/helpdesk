<header-component
    url-profile="{{route('profile.view')}}"
    url-my-chats="{{route('attendants.my.chats')}}"
    url-sair="{{ route('logout') }}"
    logo="{{App\Models\Site\SiteLogo::first()->image ?? ''}}"
    url-home="{{ route('home') }}">
</header-component>
