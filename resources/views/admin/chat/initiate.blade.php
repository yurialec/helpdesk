@extends('layouts.app_admin')
@section('content')
<chat-initiate-component
    chat-by-id="{{$chatById}}">
</chat-initiate-component>
@endsection