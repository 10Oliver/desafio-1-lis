@extends('layouts.app')

@section('content')
<div class="container text-white py-5">
    <h2 class="text-center">Reporte Mensual</h2>

    <!-- Formulario para filtrar por mes -->
    <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
        <div class="row justify-content-center align-items-end">
            <div class="col-auto">
                <label for="month" class="form-label">Selecciona el mes</label>
                <select name="month" id="month" class="form-select">
                    <option value="">-- Selecciona --</option>
                    <option value="1" {{ request('month') == 1 ? 'selected' : '' }}>Enero</option>
                    <option value="2" {{ request('month') == 2 ? 'selected' : '' }}>Febrero</option>
                    <option value="3" {{ request('month') == 3 ? 'selected' : '' }}>Marzo</option>
                    <option value="4" {{ request('month') == 4 ? 'selected' : '' }}>Abril</option>
                    <option value="5" {{ request('month') == 5 ? 'selected' : '' }}>Mayo</option>
                    <option value="6" {{ request('month') == 6 ? 'selected' : '' }}>Junio</option>
                    <option value="7" {{ request('month') == 7 ? 'selected' : '' }}>Julio</option>
                    <option value="8" {{ request('month') == 8 ? 'selected' : '' }}>Agosto</option>
                    <option value="9" {{ request('month') == 9 ? 'selected' : '' }}>Septiembre</option>
                    <option value="10" {{ request('month') == 10 ? 'selected' : '' }}>Octubre</option>
                    <option value="11" {{ request('month') == 11 ? 'selected' : '' }}>Noviembre</option>
                    <option value="12" {{ request('month') == 12 ? 'selected' : '' }}>Diciembre</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Sección de Tablas de Entradas y Salidas -->
    <div class="d-flex justify-content-center gap-5 my-4 flex-wrap">
        {{-- Tabla de Entradas --}}
        <div class="flex-fill" style="max-width: 500px;">
            <table class="table table-dark table-hover text-center">
                <thead class="table-dark text-light">
                    <tr>
                        <th colspan="2" class="text-center">ENTRADAS</th>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomes as $income)
                    <tr>
                        <td>{{ $income->name }}</td>
                        <td>${{ number_format($income->amount, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="fw-bold border-top border-3">
                        <td>TOTAL</td>
                        <td>${{ number_format($totalIncome, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Tabla de Salidas --}}
        <div class="flex-fill" style="max-width: 500px;">
            <table class="table table-dark table-hover text-center">
                <thead class="table-dark text-light">
                    <tr>
                        <th colspan="2" class="text-center">SALIDAS</th>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $expense->name }}</td>
                        <td>${{ number_format($expense->amount, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="fw-bold border-top border-3">
                        <td>TOTAL</td>
                        <td>${{ number_format($totalExpense, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Balance Mensual y Gráfico -->
    <div class="mt-5">
        <h4 class="text-center">Balance Mensual: ${{ number_format($balance, 2) }}</h4>
        <div class="my-5 text-center">
            <h5>Gráfico de balance mensual Entradas vs Salidas</h5>
            <div style="max-width: 400px; margin: 0 auto;">
                <canvas id="balanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Formulario para Reporte General en PDF -->
    <form action="{{ route('report.index') }}" method="GET" target="_blank" class="d-flex flex-column align-items-center px-3 py-5">
        <h4 class="mb-3 pb-5">Reporte general</h4>
        <div class="row w-50">
            <div class="col">
                <label for="start_date" class="form-label">Fecha inicial</label>
                <input type="date" name="start_date" id="start_date" class="form-control border border-secondary bg-dark text-white">
            </div>
            <div class="col">
                <label for="end_date" class="form-label">Fecha final</label>
                <input type="date" name="end_date" id="end_date" class="form-control border border-secondary bg-dark text-white">
            </div>
        </div>
        <div class="row d-flex justify-content-center align-items-center w-100 mt-4">
            <button type="submit" class="btn btn-secondary" style="max-width: max-content;">Generar PDF</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('balanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Entradas', 'Salidas'],
            datasets: [{
                label: 'Balance Mensual',
                data: [{{ $totalIncome }}, {{ $totalExpense }}],
                backgroundColor: ['#2176ff', '#a4243b'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>
@endsection
