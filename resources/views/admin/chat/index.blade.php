@extends('layouts.app_admin')
@section('content')
<chat-index-component
    url-initiate-chat="{{ route('chat.initiate', ['id' => ':id']) }}">
</chat-index-component>
@endsection