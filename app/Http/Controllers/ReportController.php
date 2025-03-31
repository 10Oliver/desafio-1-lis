<?php

namespace App\Http\Controllers;
 
use Illuminate\Support\Facades\Log;
use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userUuid = Auth::user()->user_uuid;
        $defaultStart = Carbon::now()->startOfMonth()->toDateString();
        $defaultEnd = Carbon::now()->endOfMonth()->toDateString();
 
        $startDate = $request->input('start_date');
        Log::info($startDate);
        if (empty($startDate)) {
            $startDate = $defaultStart;
        }
 
        $endDate = $request->input('end_date');
        
        if (empty($endDate)) {
            $endDate = $defaultEnd;
        }
        Log::info($startDate);
        Log::info($endDate);
        $accountsFinancials = $this->getAccountsFinancials($userUuid, $startDate, $endDate);
        $groupedExpenses = $this->getGroupedExpenses($startDate, $endDate, $userUuid);
        $groupedIncomes = $this->getGroupedIncomes($startDate, $endDate, $userUuid);
        $accounts = $this->getUserAccounts($userUuid);
 
        // Map accounts
        $accountsMapping = $accounts->pluck('name', 'account_uuid')->toArray();
 
        $transactions = $this->getTransactions($userUuid, $startDate, $endDate);
        $historicalBalances = $this->calculateHistoricalBalances($transactions, $accounts, $accountsMapping);
 
        $chartImageSrc = $this->generateChartImage($historicalBalances);
 
        $data = [
            'accounts_balance' => $accountsFinancials,
            'grouped_incomes' => $groupedIncomes,
            'grouped_expenses' => $groupedExpenses,
            'chart' => $chartImageSrc,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
 
        $pdf = PDF::loadView('report.main', $data)->setOption('defaultFont', 'DejaVu Sans');
        return $pdf->stream('report.pdf');
    }
 
    /**
     * Get balance by account
     */
    private function getAccountsFinancials($userUuid, $startDate, $endDate)
    {
        return Account::select(
            'account.name',
            DB::raw('COALESCE((
                SELECT SUM(expense.amount)
                FROM user_account
                    INNER JOIN user_expense ON user_account.user_account_uuid = user_expense.user_account_uuid
                    INNER JOIN expense ON expense.expense_uuid = user_expense.expense_uuid
                WHERE user_account.account_uuid = account.account_uuid
                  AND user_account.user_uuid = "' . $userUuid . '"
                  AND expense.date BETWEEN "' . $startDate . '" AND "' . $endDate . '"
            ), 0) as total_expense'),
            DB::raw('COALESCE((
                SELECT SUM(income.amount)
                FROM user_account
                    INNER JOIN user_income ON user_account.user_account_uuid = user_income.user_account_uuid
                    INNER JOIN income ON income.income_uuid = user_income.income_uuid
                WHERE user_account.account_uuid = account.account_uuid
                  AND user_account.user_uuid = "' . $userUuid . '"
                  AND income.date BETWEEN "' . $startDate . '" AND "' . $endDate . '"
            ), 0) as total_income'),
            DB::raw('
                COALESCE((
                    SELECT SUM(income.amount)
                    FROM user_account
                        INNER JOIN user_income ON user_account.user_account_uuid = user_income.user_account_uuid
                        INNER JOIN income ON income.income_uuid = user_income.income_uuid
                    WHERE user_account.account_uuid = account.account_uuid
                      AND user_account.user_uuid = "' . $userUuid . '"
                      AND income.date BETWEEN "' . $startDate . '" AND "' . $endDate . '"
                ), 0)
                -
                COALESCE((
                    SELECT SUM(expense.amount)
                    FROM user_account
                        INNER JOIN user_expense ON user_account.user_account_uuid = user_expense.user_account_uuid
                        INNER JOIN expense ON expense.expense_uuid = user_expense.expense_uuid
                    WHERE user_account.account_uuid = account.account_uuid
                      AND user_account.user_uuid = "' . $userUuid . '"
                      AND expense.date BETWEEN "' . $startDate . '" AND "' . $endDate . '"
                ), 0) as balance
            ')
        )->get();
    }
 
    /**

     * Group expenses by type
     */
    private function getGroupedExpenses($startDate, $endDate, $userUuid)
    {
        return DB::table('expense_type')
            ->leftJoin('expense', function ($join) use ($startDate, $endDate) {
                $join->on('expense_type.expense_type_uuid', '=', 'expense.expense_type_uuid')
                    ->whereBetween('expense.date', [$startDate, $endDate]);
            })
            ->leftJoin('user_expense', 'expense.expense_uuid', '=', 'user_expense.expense_uuid')
            ->leftJoin('user_account', function ($join) use ($userUuid) {
                $join->on('user_expense.user_account_uuid', '=', 'user_account.user_account_uuid')
                    ->where('user_account.user_uuid', $userUuid);
            })
            ->select('expense_type.name as expense_type', DB::raw('COALESCE(SUM(expense.amount), 0) as total_amount'))
            ->groupBy('expense_type.expense_type_uuid', 'expense_type.name')
            ->get();
    }
 
    /**
     * Group incomes but type
     */
    private function getGroupedIncomes($startDate, $endDate, $userUuid)
    {
        return DB::table('income_type')
            ->leftJoin('income', function ($join) use ($startDate, $endDate) {
                $join->on('income_type.income_type_uuid', '=', 'income.income_type_uuid')
                    ->whereBetween('income.date', [$startDate, $endDate]);
            })
            ->leftJoin('user_income', 'income.income_uuid', '=', 'user_income.income_uuid')
            ->leftJoin('user_account', function ($join) use ($userUuid) {
                $join->on('user_income.user_account_uuid', '=', 'user_account.user_account_uuid')
                    ->where('user_account.user_uuid', $userUuid);
            })
            ->select('income_type.name as income_type', DB::raw('COALESCE(SUM(income.amount), 0) as total_amount'))
            ->groupBy('income_type.income_type_uuid', 'income_type.name')
            ->get();
    }
 
    /**
     * Get user Account
     */
    private function getUserAccounts($userUuid)
    {
        return Account::whereHas('userAccounts', function ($query) use ($userUuid) {
            $query->where('user_uuid', $userUuid);
        })->get();
    }
 
    /**
     * Get transaction and info
     */
    private function getTransactions($userUuid, $startDate, $endDate)
    {
        $query = "
            (SELECT i.amount, i.`date`, a.name, ua.account_uuid, 'ingreso' as tipo
             FROM income i
             INNER JOIN user_income ui ON ui.income_uuid = i.income_uuid
             INNER JOIN user_account ua ON ua.user_account_uuid = ui.user_account_uuid
             INNER JOIN account a ON a.account_uuid = ua.account_uuid
             WHERE ua.user_uuid = ?
             AND i.date BETWEEN ? AND ?)
            UNION
            (SELECT e.amount, e.`date`, a.name, ua.account_uuid, 'gasto' as tipo
             FROM expense e
             INNER JOIN user_expense ue ON ue.expense_uuid = e.expense_uuid
             INNER JOIN user_account ua ON ua.user_account_uuid = ue.user_account_uuid
             INNER JOIN account a ON a.account_uuid = ua.account_uuid
             WHERE ua.user_uuid = ?
             AND e.date BETWEEN ? AND ?)
        ";
 
        return DB::select($query, [
            $userUuid,
            $startDate,
            $endDate,
            $userUuid,
            $startDate,
            $endDate
        ]);
    }
 
    /**
     * Calculate balance
     */
    private function calculateHistoricalBalances($transactions, $accounts, $accountsMapping)
    {
        $dates = [];
        foreach ($transactions as $tx) {
            if (!in_array($tx->date, $dates)) {
                $dates[] = $tx->date;
            }
        }
        sort($dates);
 
        $movementsByAccount = [];
        foreach ($transactions as $tx) {
            $accountId = $tx->account_uuid;
            $amount    = (float)$tx->amount;
            if ($tx->tipo === 'gasto') {
                $amount = -$amount;
            }
            if (!isset($movementsByAccount[$accountId])) {
                $movementsByAccount[$accountId] = [];
            }
            if (isset($movementsByAccount[$accountId][$tx->date])) {
                $movementsByAccount[$accountId][$tx->date] += $amount;
            } else {
                $movementsByAccount[$accountId][$tx->date] = $amount;
            }
        }
 
        $historicalBalances = [];
        foreach ($accounts as $account) {
            $accountId = $account->account_uuid;
            $accountName = $accountsMapping[$accountId] ?? 'Unknown';
            $dailyMovements = [];
            $lastValue = 0; // Initial value for account
            foreach ($dates as $date) {
                if (isset($movementsByAccount[$accountId][$date])) {
                    // Add last day amount to calculate historical
                    $lastValue += $movementsByAccount[$accountId][$date];
                }
                // Set first value
                $dailyMovements[$date] = $lastValue;
            }
            $historicalBalances[$accountName] = $dailyMovements;
        }
 
        return $historicalBalances;
    }
 
    /**
     * Graphic and get image
     */
    private function generateChartImage($historicalBalances)
    {
        $labels = array_keys(reset($historicalBalances));
        $datasets = [];
 
        foreach ($historicalBalances as $accountName => $data) {
            $datasets[] = [
                'label' => $accountName,
                'data' => array_values($data),
                'borderColor' => $this->generateColorFromAccountName($accountName),
                'backgroundColor' => $this->generateColorFromAccountName($accountName),
                'fill' => false,
            ];
        }
 
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => $datasets,
            ],
            'options' => [
                'plugins' => [
                    'datalabels' => [
                        'display' => true,
                        'color' => '#000',
                        'align' => 'top',
                        'anchor' => 'end',
                    ],
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'title' => [
                            'display' => true,
                            'text' => 'Movimiento'
                        ],
                    ],
                    'x' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Fecha'
                        ],
                    ],
                ],
            ],
            'plugins' => ['chartjs-plugin-datalabels'],
        ];
 
        $jsonConfig = json_encode($chartConfig);
        $chartUrl = 'https://quickchart.io/chart?c=' . urlencode($jsonConfig);
        $imageData = base64_encode(file_get_contents($chartUrl));
 
        return 'data:image/png;base64,' . $imageData;
    }
 
    private function generateColorFromAccountName($accountName)
    {
        $hash = crc32($accountName);
        $r = ($hash & 0xFF0000) >> 16;
        $g = ($hash & 0x00FF00) >> 8;
        $b = $hash & 0x0000FF;
 
        list($h, $s, $l) = $this->rgbToHsl($r, $g, $b);
 
        $s = max(0.5, min(0.7, $s));
        $l = max(0.4, min(0.6, $l));
 
        list($r, $g, $b) = $this->hslToRgb($h, $s, $l);
 
        return sprintf('#%02X%02X%02X', $r, $g, $b);
    }
 
    private function rgbToHsl($r, $g, $b)
    {
        $r /= 255;
        $g /= 255;
        $b /= 255;
 
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $h = $s = $l = ($max + $min) / 2;
 
        if ($max == $min) {
            $h = $s = 0;
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
            if ($max == $r) {
                $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
            } elseif ($max == $g) {
                $h = ($b - $r) / $d + 2;
            } else {
                $h = ($r - $g) / $d + 4;
            }
            $h /= 6;
        }
        return [$h, $s, $l];
    }
 
    private function hslToRgb($h, $s, $l)
    {
        if ($s == 0) {
            $r = $g = $b = $l;
        } else {
            $hue2rgb = function ($p, $q, $t) {
                if ($t < 0) $t += 1;
                if ($t > 1) $t -= 1;
                if ($t < 1 / 6) return $p + ($q - $p) * 6 * $t;
                if ($t < 1 / 2) return $q;
                if ($t < 2 / 3) return $p + ($q - $p) * (2 / 3 - $t) * 6;
                return $p;
            };
 
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;
            $r = $hue2rgb($p, $q, $h + 1 / 3);
            $g = $hue2rgb($p, $q, $h);
            $b = $hue2rgb($p, $q, $h - 1 / 3);
        }
        return [round($r * 255), round($g * 255), round($b * 255)];
    }
}
 