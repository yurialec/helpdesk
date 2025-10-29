@extends('admin.layouts.app_admin')
@section('content')
    <system-category-edit-component
        :id="'{{ $id }}'"
        url-index="{{ route('system-category.index') }}">
    </system-category-edit-component>
@endsection