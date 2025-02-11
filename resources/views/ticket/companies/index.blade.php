@extends('layouts.app_admin')
@section('content')
<companies-index-component
    url-create-companies="{{ route('company.create') }}"
    url-edit-companies="{{ route('company.edit', ['id' => ':id']) }}">
</companies-index-component>
@endsection