@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{isset($category) ? 'Edit Category' : 'Create Category'}}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($category))
        <form method="POST" action="{{ route('categories.update', $category) }}">
        @method('PUT')
    @else
        <form method="POST" action="{{ route('categories.store') }}">
    @endif
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select id="type" name="type" class="form-select" required>
                <option value="income" {{(old('type', $category->type ?? '') == 'income') ? 'selected' : ''}}>Income</option>
                <option value="expense" {{(old('type', $category->type ?? '') == 'expense') ? 'selected' : ''}}>Expense</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{isset($category) ? 'Update' : 'Create'}}</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection