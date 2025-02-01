@extends('layouts.app_admin')
@section('content')
<chat-index-component
    url-view-chat="{{ route('chat.view', ['id' => ':id']) }}">
</chat-index-component>
@endsection