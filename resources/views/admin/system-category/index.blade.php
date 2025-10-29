@extends('admin.layouts.app_admin')
@section('content')
    <system-category-index-component
        url-create="{{ route('system-category.create') }}"
        url-edit="{{ route('system-category.edit', ['id' => '_id']) }}">
    </system-category-index-component>
@endsection