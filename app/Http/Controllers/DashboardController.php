<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentMonth = now();

        // Calculate income for current month
        $income = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('amount');

        // Calculate expenses for current month
        $expenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('amount');

        // ALL-TIME balance 
        $totalIncome = Transaction::where('user_id', $user->id)
        ->where('type', 'income')
        ->sum('amount');

        $totalExpenses = Transaction::where('user_id', $user->id)
        ->where('type', 'expense')
        ->sum('amount');

        // Calculate balance
        $balance = $totalIncome - $totalExpenses;

        // Get recent transactions (last 10)
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Get daily data for chart (last 30 days)
        $dailyData = Transaction::where('user_id', $user->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->selectRaw('DATE(date) as date, SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income, SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard', compact('income', 'expenses', 'balance', 'recentTransactions', 'dailyData'));
    }
}
