@extends('admin.layouts.app_admin')
@section('content')
    <system-category-create-component
        url-index="{{ route('system-category.index') }}">
    </system-category-create-component>
@endsection