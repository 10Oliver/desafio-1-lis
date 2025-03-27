<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $userUuid = Auth::user()->user_uuid;

        $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfMonth   = Carbon::now()->endOfMonth()->toDateTimeString();

        $accountsFinancials = Account::select(
            'account.name',
            DB::raw('COALESCE((
                SELECT SUM(expense.amount)
                FROM user_account
                    INNER JOIN user_expense ON user_account.user_account_uuid = user_expense.user_account_uuid
                    INNER JOIN expense ON expense.expense_uuid = user_expense.expense_uuid
                WHERE user_account.account_uuid = account.account_uuid
                  AND user_account.user_uuid = "' . $userUuid . '"
                  AND expense.created_at BETWEEN "' . $startOfMonth . '" AND "' . $endOfMonth . '"
            ), 0) as total_expense'),
            DB::raw('COALESCE((
                SELECT SUM(income.amount)
                FROM user_account
                    INNER JOIN user_income ON user_account.user_account_uuid = user_income.user_account_uuid
                    INNER JOIN income ON income.income_uuid = user_income.income_uuid
                WHERE user_account.account_uuid = account.account_uuid
                  AND user_account.user_uuid = "' . $userUuid . '"
                  AND income.created_at BETWEEN "' . $startOfMonth . '" AND "' . $endOfMonth . '"
            ), 0) as total_income'),
            DB::raw('
                COALESCE((
                    SELECT SUM(income.amount)
                    FROM user_account
                        INNER JOIN user_income ON user_account.user_account_uuid = user_income.user_account_uuid
                        INNER JOIN income ON income.income_uuid = user_income.income_uuid
                    WHERE user_account.account_uuid = account.account_uuid
                      AND user_account.user_uuid = "' . $userUuid . '"
                      AND income.created_at BETWEEN "' . $startOfMonth . '" AND "' . $endOfMonth . '"
                ), 0)
                -
                COALESCE((
                    SELECT SUM(expense.amount)
                    FROM user_account
                        INNER JOIN user_expense ON user_account.user_account_uuid = user_expense.user_account_uuid
                        INNER JOIN expense ON expense.expense_uuid = user_expense.expense_uuid
                    WHERE user_account.account_uuid = account.account_uuid
                      AND user_account.user_uuid = "' . $userUuid . '"
                      AND expense.created_at BETWEEN "' . $startOfMonth . '" AND "' . $endOfMonth . '"
                ), 0) as balance
            ')
        )->get();

        $groupedExpenses = DB::table('expense_type')
            ->leftJoin('expense', function ($join) use ($startOfMonth, $endOfMonth) {
                $join->on('expense_type.expense_type_uuid', '=', 'expense.expense_type_uuid')
                    ->whereBetween('expense.created_at', [$startOfMonth, $endOfMonth]);
            })
            ->leftJoin('user_expense', 'expense.expense_uuid', '=', 'user_expense.expense_uuid')
            ->leftJoin('user_account', function ($join) use ($userUuid) {
                $join->on('user_expense.user_account_uuid', '=', 'user_account.user_account_uuid')
                    ->where('user_account.user_uuid', $userUuid);
            })
            ->select('expense_type.name as expense_type', DB::raw('COALESCE(SUM(expense.amount), 0) as total_amount'))
            ->groupBy('expense_type.expense_type_uuid', 'expense_type.name')
            ->get();

        $groupedIncomes = DB::table('income_type')
            ->leftJoin('income', function ($join) use ($startOfMonth, $endOfMonth) {
                $join->on('income_type.income_type_uuid', '=', 'income.income_type_uuid')
                    ->whereBetween('income.created_at', [$startOfMonth, $endOfMonth]);
            })
            ->leftJoin('user_income', 'income.income_uuid', '=', 'user_income.income_uuid')
            ->leftJoin('user_account', function ($join) use ($userUuid) {
                $join->on('user_income.user_account_uuid', '=', 'user_account.user_account_uuid')
                    ->where('user_account.user_uuid', $userUuid);
            })
            ->select('income_type.name as income_type', DB::raw('COALESCE(SUM(income.amount), 0) as total_amount'))
            ->groupBy('income_type.income_type_uuid', 'income_type.name')
            ->get();


        $accounts = Account

        $query = "
            (SELECT i.amount, i.`date`, a.name, ua.account_uuid, 'ingreso' as tipo
            FROM income i
            INNER JOIN user_income ui ON ui.income_uuid = i.income_uuid
            INNER JOIN user_account ua ON ua.user_account_uuid = ui.user_account_uuid
            INNER JOIN account a ON a.account_uuid = ua.account_uuid
            WHERE ua.user_uuid = ?
            AND i.created_at BETWEEN ? AND ?)
            UNION
            (SELECT e.amount, e.`date`, a.name, ua.account_uuid, 'gasto' as tipo
            FROM expense e
            INNER JOIN user_expense ue ON ue.expense_uuid = e.expense_uuid
            INNER JOIN user_account ua ON ua.user_account_uuid = ue.user_account_uuid
            INNER JOIN account a ON a.account_uuid = ua.account_uuid
            WHERE ua.user_uuid = ?
            AND e.created_at BETWEEN ? AND ?)
        ";

        $transactions = DB::select($query, [
            $userUuid,
            $startOfMonth,
            $endOfMonth,
            $userUuid,
            $startOfMonth,
            $endOfMonth
        ]);

        $transactionsCollection = collect($transactions);
        $dates = collect(range(0, Carbon::now()->daysInMonth - 1))
            ->map(fn($i) => Carbon::now()->startOfMonth()->addDays($i)->format('Y-m-d'))
            ->all();

        $datasets = [];

        foreach($accounts as $account) {
            $currentBalance = $account->amount;
            $dailyBalances = [];
            $accountTransactions = $transactionsCollection->filter(function ($transaction) use ($account) {
                return $transaction->account_uuid === $account->account_uuid;
            });
            $datasets = $accountTransactions;
        }



        $data = [
            'accounts_balance' => $accountsFinancials,
            'grouped_incomes' => $groupedIncomes,
            'grouped_expenses' => $groupedExpenses,
            'chart' => json_encode($transactions),
            'data' => $accounts
        ];
        $pdf = PDF::loadView('report.main', $data);
        return $pdf->stream('report.pdf');
    }
}
