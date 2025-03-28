<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        * {
            font-family: "Poppins", sans-serif !important;
        }

        table {
            width: 100%;
            color: white;
            border: none;
            border-collapse: collapse;
        }

        thead {
            background-color: #333333;
            font-size: 16px;
            font-weight: 800;
        }

        td {
            padding: 5px 10px;
            border: 1px solid #555555;
        }

        tbody>tr>td {
            color: #555555;
            font-size: 14px;
            font-weight: 500
        }
    </style>
</head>

<body>
    <h1>Reporte general</h1>

    <h3>Balance por cuentas</h3>
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

    <h3>Balance de entradas</h3>
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
    <h3>Balance de salidas</h3>
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
        <h3>Gráfico con balance por cuentas</h3>
        <img src="{{ $chart }}" style="height: 410px" alt="Gráfico de Balance Histórico">
    </div>


</body>

</html>
