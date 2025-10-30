@extends('admin.layouts.app_admin')
@section('content')
    <tickets-create-component
        url-index="{{ route('tickets.index') }}">
    </tickets-create-component>
@endsection