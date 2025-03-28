<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\IncomeType;
use App\Models\UserIncomes;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::paginate(10);
        $incomeTypes = IncomeType::all();
        $userAccounts = UserAccount::where('user_uuid', Auth::id())->with('account')->get();
        return view('incomes.index', compact('incomes', 'incomeTypes', 'userAccounts'));
    }

    public function create()
    {
        $incomeTypes = IncomeType::all();
        return view('incomes.create', compact('incomeTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'income_type' => 'required|uuid',
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

        $income = Income::create([
            'income_uuid' => Str::uuid(),
            'name' => $request->name,
            'income_type_uuid' => $request->income_type,
            'amount' => $request->amount,
            'date' => $request->date,
            'ticket_path' => $ticketPath,
            'description' => $request->description,
        ]);

        UserIncomes::create([
            'user_income_uuid' => Str::uuid(),
            'user_account_uuid' => $request->user_account_uuid,
            'income_uuid' => $income->income_uuid,
        ]);

        $userAccount = UserAccount::where('user_account_uuid', $request->user_account_uuid)->with('account')->first();
        $account = $userAccount->account;
        $account->amount += $request->amount;
        $account->save();

        return redirect()->route('incomes.index')->with('success', 'Ingreso registrado correctamente.');
    }
}
