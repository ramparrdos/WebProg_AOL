@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Budget Tracker - {{ now()->format('F Y') }}</h1>
        <a href="{{ route('budgets.create') }}" class="btn btn-primary">Create Budget</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($budgets as $budget)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">{{ $budget->category->name }}</h5>
                    <div>
                        <a href="{{ route('budgets.edit', $budget) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('budgets.destroy', $budget) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this budget?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Budget:</strong> 
                        <span class="text-primary">Rp {{ number_format($budget->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>Spent:</strong> 
                        <span class="{{ $budget->spent > $budget->amount ? 'text-danger' : 'text-success' }}">
                            Rp {{ number_format($budget->spent, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <strong>Remaining:</strong> 
                        <span class="text-muted">Rp {{ number_format(max($budget->amount - $budget->spent, 0), 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="progress" style="height: 30px;">
                    <div class="progress-bar {{ $budget->progress_percentage >= 100 ? 'bg-danger' : ($budget->progress_percentage >= 80 ? 'bg-warning' : 'bg-success') }}" 
                         role="progressbar" 
                         style="width: {{ min($budget->progress_percentage, 100) }}%">
                        <strong>{{ number_format($budget->progress_percentage, 1) }}%</strong>
                    </div>
                </div>

                @if($budget->spent > $budget->amount)
                    <div class="alert alert-danger mt-2 mb-0">
                        Over budget by Rp {{ number_format($budget->spent - $budget->amount, 0, ',', '.') }}!
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            No budgets set for this month. 
            <a href="{{ route('budgets.create') }}">Create one now!</a>
        </div>
    @endforelse
</div>
@endsection