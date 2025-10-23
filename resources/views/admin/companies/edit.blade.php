@extends('admin.layouts.app_admin')
@section('content')
    <companies-edit-component
        :id="'{{ $id }}'"
        url-index="{{ route('companies.index') }}">
    </companies-edit-component>
@endsection