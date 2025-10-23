@extends('admin.layouts.app_admin')
@section('content')
    <companies-index-component
        url-create="{{ route('companies.create') }}"
        url-edit="{{ route('companies.edit', ['id' => '_id']) }}">
    </companies-index-component>
@endsection