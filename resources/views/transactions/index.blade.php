@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Transactions</h1>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  <form method="GET" class="row g-2 mb-3">
    <div class="col-auto"><input type="date" name="from" class="form-control" value="{{ request('from') }}"></div>
    <div class="col-auto"><input type="date" name="to" class="form-control" value="{{ request('to') }}"></div>
    <div class="col-auto">
      <select name="category_id" class="form-select">
        <option value="">All categories</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-auto">
      <select name="type" class="form-select">
        <option value="">All types</option>
        <option value="income" @selected(request('type')=='income')>Income</option>
        <option value="expense" @selected(request('type')=='expense')>Expense</option>
      </select>
    </div>
    <div class="col-auto">
      <button class="btn btn-primary">Filter</button>
      <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
  </form>

  <div class="mb-3">
    <strong>Total Income:</strong>
    Rp {{ number_format($totalIncome, 0, ',', '.') }}

    <strong class="ms-3">Total Expense:</strong>
    Rp {{ number_format($totalExpense, 0, ',', '.') }}
  </div>

  <a href="{{ route('transactions.create') }}" class="btn btn-success mb-2">+ New Transaction</a>

  <div class="table-responsive">
  <table class="table table-striped">
    <thead><tr><th>Date</th><th>Category</th><th>Type</th><th>Amount</th><th>Description</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($transactions as $t)
        <tr>
          <td>{{ $t->date->format('Y-m-d') }}</td>
          <td>{{ $t->category?->name }}</td>
          <td><span class="badge {{ $t->type=='income' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($t->type) }}</span></td>
          <td>
            Rp {{ number_format($t->amount, 0, ',', '.') }}
          </td>
          <td>{{ \Illuminate\Support\Str::limit($t->description,80) }}</td>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('transactions.edit', $t) }}">Edit</a>
            <form action="{{ route('transactions.destroy', $t) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">No transactions found.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>

  {{ $transactions->links() }}
</div>
@endsection
