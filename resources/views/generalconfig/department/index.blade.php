@extends('layouts.app_admin')
@section('content')
<department-index-component
    url-create-department="{{ route('department.create') }}"
    url-edit-department="{{ route('department.edit', ['id' => ':id']) }}">
</department-index-component>
@endsection