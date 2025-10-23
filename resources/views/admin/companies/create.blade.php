@extends('admin.layouts.app_admin')
@section('content')
    <companies-create-component
        url-index="{{ route('companies.index') }}">
    </companies-create-component>
@endsection