<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\UserExpense;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::paginate(10);
        $expenseTypes = ExpenseType::all();

        $userAccounts=UserAccount::where('user_uuid', Auth::id())
        ->with('account.accountType')
        ->get();
        return view('expenses.index', compact('expenses', 'expenseTypes', 'userAccounts'));
    }

    public function create()
    {
        $expenseTypes = ExpenseType::all();
        return view('expenses.create', compact('expenseTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'expense_type' => 'required|uuid',
            'user_account_uuid' => 'required|uuid|exists:user_account,user_account_uuid',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'ticket' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $ticketPath = null;
        if ($request->hasFile('ticket')) {
            $ticketPath = $request->file('ticket')->store('tickets', 'public');
        }

        $expense = Expense::create([
            'expense_uuid'      => Str::uuid(),
            'name'              => $request->name,
            'expense_type_uuid' => $request->expense_type,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'ticket_path'       => $ticketPath,
            'description'       => $request->description,
        ]);

        UserExpense::create([
            'user_expense_uuid' => Str::uuid(),
            'user_account_uuid'=> $request->user_account_uuid,
            'expense_uuid' => $expense->expense_uuid,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Salida registrada correctamente.');
    }
}
