@extends('layouts.app_admin')
@section('content')
    <viewchat-component
        url-my-chats="{{route('attendants.my.chats')}}"
        :chat-by-id="{{json_encode($chatById)}}">
    </viewchat-component>
@endsection
