@extends('layouts.app_admin')
@section('content')
<chat-initiate-component
    :chat-by-id="{{json_encode($chatById)}}">
</chat-initiate-component>
@endsection