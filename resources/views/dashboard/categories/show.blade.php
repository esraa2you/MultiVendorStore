@extends('layouts.dashboard')
<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
@section('title', $category->name)
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection
@section('content')

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created_at</th>
            </tr>
        </thead>
        @php
            $products = $category
                ->products()
                ->with('store')
                ->latest()
                ->paginate(5);
        @endphp

        <body class="body">
            @forelse ($products as $product)
                <tr>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="100"> </td>
                    <td>{{ $product->name }}</td>
                    {{-- <td>{{ $product->store->name }}</td> --}}
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5"> No product </td>
                </tr>
            @endforelse

        </body>
    </table>
    {{ $products->links() }}
@endsection
