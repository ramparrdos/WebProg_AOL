@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categories</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create Category</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ ucfirst($category->type) }}</td>
                    <td>
                        @if($category->user_id === null || $category->user_id === auth()->id())
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        @else
                            <em>Protected</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection