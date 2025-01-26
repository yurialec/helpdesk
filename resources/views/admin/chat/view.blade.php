
@extends('layouts.app_admin')
@section('content')
<view-chat-component
    :chat-id="{{$id}}">
</view-chat-component>
@endsection