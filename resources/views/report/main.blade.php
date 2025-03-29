<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <style>
        * {

            font-family: "DejaVu Sans", sans-serif;

        }

        table {

            width: 100%;

            color: white;

            border: none;

            border-collapse: collapse;

        }

        thead {

            background-color: #333333;

            font-size: 12px;

            font-weight: 800;

        }

        td {

            padding: 5px 10px;

            border: 1px solid #555555;

        }

        tbody>tr>td {

            color: #555555;

            font-size: 10px;

            font-weight: 500
        }

        .title {

            background-color: #0094ba;

            text-align: center;

            padding: 10px 0px 20px 0px;

            color: white;

        }

        h1 {

            margin-bottom: 10px;

        }

        h3 {

            padding: 5px 0px;

            text-align: center;

            color: white;

            font-weight: 500;

            font-size: 15px;

        }

        .balance-account {

            background-color: #00c37d;

        }

        .balance-entries {

            background-color: #698538;

        }

        .balance-ends {

            background-color: #ffb15c;

        }

        .balance-bar {

            background-color: #818181;

        }
    </style>
</head>

<body>
    <div class="title">
        <h1>Reporte general</h1>
        <span>

            {{ $startDate }} - {{ $endDate }}
        </span>
    </div>


    <h3 class="balance-account">Balance por cuentas</h3>
    <table>
        <thead>
            <tr>
                <td>Nombre de cuenta</td>
                <td>Entradas totales</td>
                <td>Salidas totales</td>
                <td>Balance</td>
            </tr>
        </thead>
        <tbody>

            @foreach ($accounts_balance as $account)
                <tr>
                    <td>

                        {{ $account->name }}
                    </td>
                    <td>

                        $ {{ $account->total_income }}
                    </td>
                    <td>

                        $ {{ $account->total_expense }}
                    </td>
                    <td>

                        $ {{ $account->balance }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="balance-entries">Balance de entradas</h3>
    <table>
        <thead>
            <tr>
                <td>Categoría</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>

            @foreach ($grouped_incomes as $income)
                <tr>
                    <td>

                        {{ $income->income_type }}
                    </td>
                    <td>

                        $ {{ $income->total_amount }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3 class="balance-ends">Balance de salidas</h3>
    <table>
        <thead>
            <tr>
                <td>Categoría</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>

            @foreach ($grouped_expenses as $expense)
                <tr>
                    <td>

                        {{ $expense->expense_type }}
                    </td>
                    <td>

                        $ {{ $expense->total_amount }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="page-break-before: always">
        <h3 class="balance-bar">Gráfico con balance por cuentas</h3>
        <img src="{{ $chart }}" style="height: 410px" alt="Gráfico de Balance Histórico">
    </div>


</body>

</html>
