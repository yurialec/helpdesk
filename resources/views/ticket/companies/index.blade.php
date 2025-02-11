@extends('layouts.app_admin')
@section('content')
<companies-index-component
    url-create-companies="{{ route('company.create') }}">
</companies-index-component>
@endsection