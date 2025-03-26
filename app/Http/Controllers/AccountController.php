<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\CreateAccountResource;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accountType = AccountType::all();

        $userId = Auth::id();

        $accounts = UserAccount::where('user_uuid', $userId)
            ->with('account.accountType')
            ->get();
        return view("account.index", compact("accountType", 'accounts'));
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
        try {
            DB::beginTransaction();
            $data = $request->validated();
            // Default value
            $data['amount'] = $data['amount'] ?? 0;
            $account = Account::create($data);

            // Relation with user
            UserAccount::create([
                'user_uuid' => Auth::id(),
                'account_uuid' => $account->account_uuid
            ]);

            DB::commit();
            return redirect()->route("accounts.index")->with("success", "Cuenta creada éxitosamente");
        } catch (\Throwable $th) {
            DB::rollBack(); // Revertir la transacción en caso de error
            return response()->json(['error' => 'No se pudo crear la cuenta', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = Account::where('account_uuid', $id)
            ->with('accountType')->first();

        return response()->json([
            'data' => $account
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, string $id)
    {
        $account = Account::where('account_uuid', $id)->first();
        if (!$account) {
            return response()->json(['error' => 'Cuenta no encontrada'], 404);
        }

        $data = $request->except('account_uuid');
        $account->update($data);

        return redirect()->route('accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $account = Account::where('account_uuid', $id)->first();

            if (!$account) {
                return response()->json(['error' => 'Cuenta no encontrada'], 404);
            }

            UserAccount::where('account_uuid', $id)->delete();


            $account->delete();

            DB::commit();

            return redirect()->route('accounts.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar la cuenta: ' . $th->getMessage()], 500);
        }
    }
}
