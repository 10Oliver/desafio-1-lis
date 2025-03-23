<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::paginate(10);
        $expenseTypes = ExpenseType::all();
        return view('expenses.index', compact('expenses', 'expenseTypes'));
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
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'ticket' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $ticketPath = null;
        if ($request->hasFile('ticket')) {
            $ticketPath = $request->file('ticket')->store('tickets', 'public');
        }

        Expense::create([
            'expense_uuid'      => Str::uuid(),
            'name'              => $request->name,
            'expense_type_uuid' => $request->expense_type,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'ticket_path'       => $ticketPath,
            'description'       => $request->description,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Salida registrada correctamente.');
    }
}
