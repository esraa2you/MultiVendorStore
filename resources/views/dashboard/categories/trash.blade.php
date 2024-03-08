@extends('layouts.dashboard')

<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Trash</li>
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
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Deleted_at</th>
                <th colspan="2"></th>
            </tr>
        </thead>

        <body class="body">
            @forelse ($categories as $category)
                <tr>
                    <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="100"> </td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->deleted_at }}</td>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.restore', ['category' => $category->id]) }}"
                            method="post">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Restore</button>
                        </form>
                    <td>
                        <form action="{{ route('dashboard.categories.force-delete', ['category' => $category->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Force Delete</button>
                        </form>
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
