<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Http\Resources\CreateAccountResource;
use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accountType = AccountType::all();
        return view("account.index", compact("accountType"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAccountRequest $request)
    {
        $data = $request->validated();
        $data['amount'] = $data['amount'] ?? 0;
        Account::create($data);

        return redirect()->route("accounts.index")->with("success", "Cuenta creada éxitosamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
