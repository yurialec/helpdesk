@extends('layouts.app_admin')
@section('content')
    <my-chats-component
        url-view-chat="{{ route('chat.view', ['id' => ':id']) }}">>
    </my-chats-component>
@endsection
