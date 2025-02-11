@extends('layouts.app_admin')
@section('content')
<companies-edit-component
    :id="{{ $id }}"
    url-index-companies="{{ route('company.index') }}">
</companies-edit-component>
@endsection