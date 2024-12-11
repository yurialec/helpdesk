@extends('layouts.app_admin')
@section('content')
    <my-chats-component
        url-initiate-chat="{{ route('attendants.view.chat', ['id' => ':id']) }}">>
    </my-chats-component>
@endsection
