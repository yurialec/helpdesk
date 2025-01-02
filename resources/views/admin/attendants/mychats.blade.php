@extends('layouts.app_admin')
@section('content')
    <my-chats-component
        url-my-chats="{{route('attendants.my.chats')}}"
        url-initiate-chat="{{ route('get.chat.by.id', ['id' => ':id']) }}">>
    </my-chats-component>
@endsection
