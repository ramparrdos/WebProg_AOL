@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Edit Transaction</h2>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('transactions.update', $transaction) }}">
    @csrf
    @method('PUT')

    {{-- Date --}}
    <div class="mb-3">
      <label class="form-label">Date</label>
      <input type="date"
             name="date"
             class="form-control"
             value="{{ old('date', $transaction->date->toDateString()) }}"
             required>
    </div>

    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category_id" id="category" class="form-select" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}"
                  data-type="{{ $c->type }}"
                  @selected(old('category_id', $transaction->category_id) == $c->id)>
            {{ $c->name }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Type (auto from category) --}}
    <div class="mb-3">
      <label class="form-label">Type</label>
      <input type="text"
             id="type_display"
             class="form-control"
             value="{{ ucfirst(old('type', $transaction->type)) }}"
             readonly>

      <input type="hidden"
             name="type"
             id="type"
             value="{{ old('type', $transaction->type) }}">
    </div>

    <div class="mb-3">
      <label class="form-label">Amount</label>
      <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number"
               name="amount"
               class="form-control"
               value="{{ old('amount', $transaction->amount) }}"
               required>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description"
                class="form-control"
                rows="3">{{ old('description', $transaction->description) }}</textarea>
    </div>

    <button class="btn btn-primary">Update</button>
    <a class="btn btn-secondary" href="{{ route('transactions.index') }}">Back</a>
  </form>

  <script>
    function syncType() {
      const category = document.getElementById('category');
      if (!category) return;

      const selected =
        category.options[category.selectedIndex]?.dataset.type || '';

      document.getElementById('type').value = selected;
      document.getElementById('type_display').value =
        selected ? selected.charAt(0).toUpperCase() + selected.slice(1) : '';
    }

    document.getElementById('category')?.addEventListener('change', syncType);

    syncType();
  </script>
</div>
@endsection
