@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Create Transaction</h2>

  @if($errors->any())
    <div class="alert alert-danger"><ul>@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul></div>
  @endif

  <form method="POST" action="{{ route('transactions.store') }}">
    @csrf
    <div class="mb-3"><label>Date</label><input type="date" name="date" class="form-control" value="{{ old('date', now()->toDateString()) }}"></div>
    <div class="mb-3"><label>Category</label>
      <select name="category_id" id="category" class="form-select" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $c)
            <option value="{{ $c->id }}"
                    data-type="{{ $c->type }}"
                    @selected(old('category_id') == $c->id)>
            {{ $c->name }}
            </option>
        @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Type</label>
        <input type="text" id="type_display" class="form-control" readonly>
        <input type="hidden" name="type" id="type">
    </div>
    <div class="mb-3">
        <label>Amount</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="amount" class="form-control"
                value="{{ old('amount') }}" required>
        </div>
    </div>

    <div class="mb-3"><label>Description</label><textarea name="description" class="form-control">{{ old('description') }}</textarea></div>
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-secondary" href="{{ route('transactions.index') }}">Back</a>
  </form>

  <script>
    document.getElementById('category')?.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex].dataset.type;

        document.getElementById('type').value = selected;
        document.getElementById('type_display').value =
            selected ? selected.charAt(0).toUpperCase() + selected.slice(1) : '';
    });
  </script>
</div>
@endsection
