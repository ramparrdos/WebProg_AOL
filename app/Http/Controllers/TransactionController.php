<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $query = Transaction::with('category')
            ->where('user_id', auth()->id());

        // date range
        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->input('to'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('date','desc')->paginate(10)->withQueryString();
        $categories = Category::forUser(auth()->id())->get(); 

        $totalIncome = (float) $query->clone()->where('type','income')->sum('amount');
        $totalExpense = (float) $query->clone()->where('type','expense')->sum('amount');

        return view('transactions.index', compact('transactions','categories','totalIncome','totalExpense'));
    }

    public function create()
    {
        $categories = Category::forUser(auth()->id())->get();
        return view('transactions.create', compact('categories'));
    } 
    
    public function store(StoreTransactionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Transaction::create($data);

        return redirect()->route('transactions.index')->with('success','Transaction created.');
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeOwner($transaction);
        $categories = Category::forUser(auth()->id())->get();
        return view('transactions.edit', compact('transaction','categories'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $this->authorizeOwner($transaction);
        $transaction->update($request->validated());
        return redirect()->route('transactions.index')->with('success','Transaction updated.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeOwner($transaction);
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success','Transaction deleted.');
    }

    protected function authorizeOwner(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
