@extends('layouts.dashboard')
<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
@section('title', 'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
    <x-alert type="success" />
    <x-alert type="info" />
    <form action="{{ URL::current() }}"method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @if (request('status') == 'active') selected @endif>Active </option>
            <option value="archived"@if (request('status') == 'archived') selected @endif>Archived</option>
        </select>
        <button class="btn btn-dark mx-2">Search</button>
    </form>
    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">New</a>
    <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-outline-primary ml-2s">Trash</a>
    <br>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Product_count</th>
                <th>Created_at</th>
                <th colspan="2"></th>
            </tr>
        </thead>

        <body class="body">
            @forelse ($categories as $category)
                <tr>
                    <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="100"> </td>
                    <td>{{ $category->id }}</td>
                    <td><a href="{{ route('dashboard.categories.show', $category) }}">{{ $category->name }}</a></td>
                    <td>{{ $category->parent->name }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->products_number }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <a href="{{ route('dashboard.categories.edit', ['category' => $category->id]) }}"
                            class="btn btn-sm btn-outline-success">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.destroy', ['category' => $category->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8"> No Category </td>
                </tr>
            @endforelse

        </body>
    </table>
    {{ $categories->withQueryString()->links() }}
@endsection

{{-- ->withQueryString() <====> ->appends(request()->all()) --}}
