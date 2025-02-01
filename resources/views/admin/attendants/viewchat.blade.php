@extends('layouts.app_admin')
@section('content')
    <view-chat-component
        url-my-chats="{{ route('attendants.my.chats') }}"
        :id="{{ $id }}"
        :user-id="{{ Auth::id() }}">
    </view-chat-component>
@endsection
