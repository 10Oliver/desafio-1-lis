<?php

namespace App\Http\Controllers;

use App\Models\IncomeType;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $incomeTypes = IncomeType::all();
        $expenseTypes = ExpenseType::all();
        return view('categories.index', compact('incomeTypes', 'expenseTypes'));
    }

    public function storeIncomeType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        IncomeType::create(['income_type_uuid' => Str::uuid(), 'name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'Categoría de ingreso creada.');
    }

    public function storeExpenseType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        ExpenseType::create(['expense_type_uuid' => Str::uuid(), 'name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'Categoría de salida creada.');
    }

    public function updateIncomeType(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:100']);
        $type = IncomeType::findOrFail($id);
        $type->update(['name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'Categoría de ingreso actualizada.');
    }

    public function updateExpenseType(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:100']);
        $type = ExpenseType::findOrFail($id);
        $type->update(['name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'Categoría de salida actualizada.');
    }

    public function destroyIncomeType($id)
    {
        $type = IncomeType::findOrFail($id);
        $type->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría de ingreso eliminada.');
    }

    public function destroyExpenseType($id)
    {
        $type = ExpenseType::findOrFail($id);
        $type->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría de salida eliminada.');
    }
    }