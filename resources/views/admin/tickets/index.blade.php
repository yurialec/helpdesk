@extends('admin.layouts.app_admin')
@section('content')
    <tickets-index-component
        url-create="{{ route('tickets.create') }}"
        url-edit="{{ route('tickets.edit', ['id' => '_id']) }}">
    </tickets-index-component>
@endsection