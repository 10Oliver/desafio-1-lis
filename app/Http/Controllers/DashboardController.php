<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function showReport(Request $request)
    {
        $selectedMonth = $request->get('month');

        if ($selectedMonth) {
            $incomes = Income::with('incomeType')
                ->whereMonth('created_at', $selectedMonth)
                ->get();
            $expenses = Expense::with('expenseType')
                ->whereMonth('created_at', $selectedMonth)
                ->get();
        } else {
            $incomes = Income::with('incomeType')->get();
            $expenses = Expense::with('expenseType')->get();
        }

        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('dashboard', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'balance'));
    }
}
