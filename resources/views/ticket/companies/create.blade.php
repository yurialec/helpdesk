@extends('layouts.app_admin')
@section('content')
<companies-create-component
    url-index-companies="{{ route('company.index') }}">
</companies-create-component>
@endsection