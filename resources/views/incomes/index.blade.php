@extends('layouts.app')

@section('content')
<div class="container mt-4 bg-ligth">
    <!-- Encabezado y botón para abrir el modal -->
    <div class="d-flex justify-content-between align-items-center mb-3 ">
        <h1 class="text-primary">Listado de Ingresos</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createIncomeModal">
            Crear Ingreso
        </button>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Tabla de ingresos -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Factura</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomes as $income)
                    <tr>
                        <td>{{ $income->name }}</td>
                        <td>${{ number_format($income->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($income->date)->format('d/m/Y') }}</td>
                        <td>{{ $income->incomeType->name }}</td>
                        <td>
                            @if($income->ticket_path)
                            <img src="{{ asset('storage/' . $income->ticket_path) }}" alt="Factura" width="100" style="cursor:pointer;" onclick="mostrarImagen('{{ asset('storage/' . $income->ticket_path) }}')">
                            @else
                            <span class="text-muted">Sin factura</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Nuevo ingreso -->
<div class="modal fade" id="createIncomeModal" tabindex="-1" aria-labelledby="createIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createIncomeModalLabel">Nuevo Ingreso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('incomes.store') }}" method="POST" enctype="multipart/form-data" id="incomeForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="income_type" class="form-label">Tipo de ingreso:</label>
                        <select name="income_type" id="income_type" class="form-select" required>
                            <option value="">Seleccione un tipo</option>
                            @foreach($incomeTypes as $type)
                            <option value="{{ $type->income_type_uuid }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Monto:</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Fecha:</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="ticket" class="form-label">Factura (imagen):</label>
                        <input type="file" name="ticket" id="ticket" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción (opcional):</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>

                @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Factura en grande -->
<div class="modal fade" id="modalImagen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <img id="imagenAmpliada" src="" class="img-fluid" alt="Factura">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function mostrarImagen(src) {
        var modalImagen = new bootstrap.Modal(document.getElementById('modalImagen'));
        document.getElementById('imagenAmpliada').src = src;
        modalImagen.show();
    }
</script>
@endsection