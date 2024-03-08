@extends('layouts.dashboard')

<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.categories.store') }}" class="form" method="POST" enctype="multipart/form-data">
        @csrf

        @include('dashboard.categories._form')
    </form>

@endsection
