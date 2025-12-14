@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Budget</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('budgets.update', $budget) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-select" disabled>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $budget->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Category cannot be changed</small>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Budget Amount</label>
            <input id="amount" name="amount" type="number" step="0.01" class="form-control" value="{{ old('amount', $budget->amount) }}" required>
        </div>

        <div class="mb-3">
            <label for="month" class="form-label">Month</label>
            <select id="month" name="month" class="form-select" disabled>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $budget->month == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
            <small class="text-muted">Month cannot be changed</small>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <select id="year" name="year" class="form-select" disabled>
                @for($i = now()->year - 1; $i <= now()->year + 2; $i++)
                    <option value="{{ $i }}" {{ $budget->year == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            <small class="text-muted">Year cannot be changed</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('budgets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection