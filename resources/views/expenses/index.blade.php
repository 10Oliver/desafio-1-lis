@extends('layouts.app')

@section('content')
<div class="container-fluid px-5 py-5 text-white">
    <div class="mb-5">
        <h1 class="text-white">Listado de Salidas</h1>
        <!-- Botón para Registrar Salida -->
        <button class="btn btn-primary mt-2 justify-content-md-end" data-bs-toggle="modal" data-bs-target="#createExpenseModal">
            Registrar Salida
        </button>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
    <div class="alert alert-success mx-3">
        {{ session('success') }}
    </div>
    @endif

    <!-- Tabla de salidas -->
    <div class="table-responsive">
        <table class="table table-dark table-hover rounded-lg">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Factura</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->name }}</td>
                    <td>${{ number_format($expense->amount, 2, ".", ",") }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                    <td>{{ $expense->expenseType->name }}</td>
                    <td>
                        @if($expense->ticket_path)
                        <img src="{{ asset('storage/' . $expense->ticket_path) }}"
                             alt="Factura"
                             width="100"
                             height="100"
                             style="cursor:pointer;"
                             onclick="mostrarImagen('{{ asset('storage/' . $expense->ticket_path) }}')">
                        @else
                        <span class="text-muted">Sin factura</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginador -->
    @if($expenses->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                {{-- Botón anterior --}}
                @if($expenses->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link bg-dark text-secondary border-secondary">&laquo;</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link bg-dark text-white border-secondary" href="{{ $expenses->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
                @endif

                {{-- Números de página --}}
                @for($i = 1; $i <= $expenses->lastPage(); $i++)
                    @if($i == $expenses->currentPage())
                    <li class="page-item active">
                        <span class="page-link bg-primary text-white border-secondary">{{ $i }}</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link bg-dark text-white border-secondary" href="{{ $expenses->url($i) }}">{{ $i }}</a>
                    </li>
                    @endif
                @endfor

                {{-- Botón siguiente --}}
                @if($expenses->hasMorePages())
                <li class="page-item">
                    <a class="page-link bg-dark text-white border-secondary" href="{{ $expenses->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
                @else
                <li class="page-item disabled">
                    <span class="page-link bg-dark text-secondary border-secondary">&raquo;</span>
                </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif

    <!-- Modal Registrar Salida -->
    <div class="modal fade" id="createExpenseModal" tabindex="-1" aria-labelledby="createExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dark">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header bg-dark input-group">
                    <h5 class="modal-title" id="createExpenseModalLabel">Registrar Salida</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body bg-dark">
                    <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data" id="expenseForm">
                        @csrf
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre de salida:</label>
                            <input type="text" name="name" id="name" class="form-control bg-dark text-white border border-secondary" required>
                        </div>
                        <!-- Tipo de salida -->
                        <div class="mb-3">
                            <label for="expense_type" class="form-label">Tipo de salida:</label>
                            <select name="expense_type" id="expense_type" class="form-select bg-dark text-white border border-secondary" required>
                                <option value="">Seleccione un tipo</option>
                                @foreach($expenseTypes as $type)
                                <option value="{{ $type->expense_type_uuid }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Monto de salida -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Monto de salida:</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control bg-dark text-white border border-secondary" required>
                        </div>
                        <!-- Fecha de salida -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha de salida:</label>
                            <input type="date" name="date" id="date" class="form-control bg-dark text-white border border-secondary" required>
                        </div>
                        <!-- Factura de salida (imagen) -->
                        <div class="mb-3">
                            <label for="ticket" class="form-label">Factura de salida (imagen):</label>
                            <input type="file" name="ticket" id="ticket" class="form-control bg-dark text-white border border-secondary" accept="image/*">
                        </div>
                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción (opcional):</label>
                            <textarea name="description" id="description" class="form-control bg-dark text-white border border-secondary" rows="3"></textarea>
                        </div>
                        <div class="modal-footer bg-dark border-top border-secondary">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
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

    <!-- Modal Factura-->
    <div class="modal fade" id="modalImagen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0">
                    <img id="imagenAmpliada" src="" class="img-fluid" alt="Factura">
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarImagen(src) {
            const modalImagen = new bootstrap.Modal(document.getElementById('modalImagen'));
            document.getElementById('imagenAmpliada').src = src;
            modalImagen.show();
        }
    </script>
</div>
@endsection
