@extends('layouts.app_admin')
@section('content')
    <viewchat-component
        url-my-chats="{{ route('attendants.my.chats') }}"
        :id="{{ $id }}">
    </viewchat-component>
@endsection
