@extends('admin.layouts.app_admin')
@section('content')
    <tickets-edit-component
        :id="'{{ $id }}'"
        url-index="{{ route('tickets.index') }}">
    </tickets-edit-component>
@endsection