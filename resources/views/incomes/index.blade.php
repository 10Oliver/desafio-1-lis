@extends('layouts.app')

@section('content')
<div class="container-fluid px-5 py-5 text-white">
    <!-- Encabezado -->
    <div class="mb-5 ">
        <h1 class="text-white">Listado de Ingresos</h1>
        <button class="btn btn-primary mt-2 justify-content-md-end" data-bs-toggle="modal" data-bs-target="#createIncomeModal">
            Crear Ingreso
        </button>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <script>
            Swal.fire({
             icon: 'success',
             title: 'Ingreso registrado',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6'
         });
        </script>
    @endif


    <!-- Tabla de ingresos -->
    <div class="table-responsive">
        <table class="table table-dark table-hover rounded-lg">
            <thead class="">
                <tr>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Factura</th>
                </tr>

            </thead>

            <tbody class="table-group-divider">
                @foreach($incomes as $income)
                <tr>

                    <td>{{ $income->name }}</td>
                    <td>${{ number_format($income->amount, 2, ".", ",") }}</td>
                    <td>{{ \Carbon\Carbon::parse($income->date)->format('d/m/Y') }}</td>
                    <td>{{ $income->incomeType->name ?? 'Sin tipo'}}</td>
                    <td>
                        @if($income->ticket_path)
                       <img src="{{ asset('storage/' . $income->ticket_path) }}" class="thumbnail-img" style="max-height: 50px; cursor: pointer;" alt="Factura de ingreso">
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
    @if($incomes->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                {{-- Botón anterior --}}
                @if($incomes->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link bg-dark text-secondary border-secondary">&laquo;</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link bg-dark text-white border-secondary" href="{{ $incomes->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
                @endif

                {{-- Números de página --}}
                @for($i = 1; $i <= $incomes->lastPage(); $i++)
                    @if($i == $incomes->currentPage())
                    <li class="page-item active">
                        <span class="page-link bg-primary text-white border-secondary">{{ $i }}</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link bg-dark text-white border-secondary" href="{{ $incomes->url($i) }}">{{ $i }}</a>
                    </li>
                    @endif
                    @endfor

                    {{-- Botón siguiente --}}
                    @if($incomes->hasMorePages())
                    <li class="page-item">
                        <a class="page-link bg-dark text-white border-secondary" href="{{ $incomes->nextPageUrl() }}" rel="next">&raquo;</a>
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

    <!-- Modal Nuevo ingreso -->
    <div class="modal fade" id="createIncomeModal" tabindex="-1" aria-labelledby="createIncomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dark">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header bg-dark input-group">
                    <h5 class="modal-title" id="createIncomeModalLabel">Nuevo Ingreso</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body bg-dark">
                    <form action="{{ route('incomes.store') }}" method="POST" enctype="multipart/form-data" id="incomeForm">
                        @csrf

                         <!-- Nombre -->
                        <div class="mb-3">
                            <label for="name" class="form-label bg-dark text-white">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control bg-dark text-white border border-secondary" required>

                            <!-- Tipo de ingreso -->
                            <div class="mb-3 mt-3">
                                <label for="income_type" class="form-label">Tipo de ingreso:</label>
                                <select name="income_type" id="income_type" class="form-select bg-dark text-white border border-secondary" required>
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($incomeTypes as $type)
                                    <option value="{{ $type->income_type_uuid }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cuenta -->
                            <div class="mb-3">
                                <label for="user_account_uuid" class="form-label">Cuenta:</label>
                                <select name="user_account_uuid" id="user_account_uuid" class="form-select bg-dark text-white border border-secondary" required>
                                    <option value="">Seleccione una cuenta</option>
                                @foreach($userAccounts as $account)
                                    <option value="{{ $account->user_account_uuid }}">
                                 {{ $account->account->name }} - {{ $account->account->accountType->name ?? 'Sin tipo' }}
                                    </option>
                                @endforeach
                                </select>
                            </div>

                            <!-- Monto de ingreso -->
                            <div class="mb-3">
                                <label for="amount" class="form-label">Monto:</label>
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control bg-dark text-white border border-secondary" required>
                            </div>

                            <!-- Fecha de ingreso -->
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha:</label>
                                <input type="date" name="date" id="date" class="form-control bg-dark text-white border border-secondary" required>
                            </div>

                            <!-- Factura de ingreso (imagen) -->
                            <div class="mb-3">
                                <label for="ticket" class="form-label">Factura (imagen):</label>
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

    <!-- Modal para mostrar imagen en grande -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid" alt="Factura en grande">
      </div>
    </div>
  </div>
</div>

<script>
    document.querySelectorAll('.thumbnail-img').forEach(img => {
        img.addEventListener('click', function () {
            document.getElementById('modalImage').src = this.src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        });
    });
</script>

    @endsection