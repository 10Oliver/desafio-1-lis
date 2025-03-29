@extends('layouts.app')

@section('content')
<div class="container-fluid text-white px-5 py-5">
    <h1 class="mb-4">Categorías</h1>

    <div class="row">
        {{-- Categorías de Ingresos --}}
        <div class="col-md-6">
            <h3>Categorías de Ingresos</h3>
            <form action="{{ route('categories.income.store') }}" method="POST" class="d-flex mb-3">
                @csrf
                <input type="text" name="name" class="form-control me-2" placeholder="Nueva categoría" required>
                <button class="btn btn-primary">Agregar</button>
            </form>

            <ul class="list-group bg-dark text-white">
                @foreach($incomeTypes as $incomeType)
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white border-secondary">
                        {{ $incomeType->name }}
                        <div>
                            {{-- Editar --}}
                            <button class="btn btn-sm btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#editIncomeModal{{ $incomeType->income_type_uuid }}">
                                Editar
                            </button>

                            {{-- Eliminar --}}
                            <form method="POST" action="{{ route('categories.income.destroy', $incomeType->income_type_uuid) }}" class="d-inline delete-income-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete-income">Eliminar</button>
                            </form>

                            {{-- Modal editar --}}
                            <div class="modal fade" id="editIncomeModal{{ $incomeType->income_type_uuid }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('categories.income.update', $incomeType->income_type_uuid) }}" method="POST" class="modal-content bg-dark text-white">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar categoría</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" name="name" value="{{ $incomeType->name }}" class="form-control bg-dark text-white border-secondary" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button class="btn btn-primary" type="submit">Guardar cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Categorías de Egresos --}}
        <div class="col-md-6">
            <h3>Categorías de Egresos</h3>
            <form action="{{ route('categories.expense.store') }}" method="POST" class="d-flex mb-3">
                @csrf
                <input type="text" name="name" class="form-control me-2" placeholder="Nueva categoría" required>
                <button class="btn btn-primary">Agregar</button>
            </form>

            <ul class="list-group bg-dark text-white">
                @foreach($expenseTypes as $expenseType)
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white border-secondary">
                        {{ $expenseType->name }}
                        <div>
                            {{-- Editar --}}
                            <button class="btn btn-sm btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#editExpenseModal{{ $expenseType->expense_type_uuid }}">
                                Editar
                            </button>

                            {{-- Eliminar --}}
                            <form method="POST" action="{{ route('categories.expense.destroy', $expenseType->expense_type_uuid) }}" class="d-inline delete-expense-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete-expense">Eliminar</button>
                            </form>

                            {{-- Modal editar --}}
                            <div class="modal fade" id="editExpenseModal{{ $expenseType->expense_type_uuid }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('categories.expense.update', $expenseType->expense_type_uuid) }}" method="POST" class="modal-content bg-dark text-white">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar categoría</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" name="name" value="{{ $expenseType->name }}" class="form-control bg-dark text-white border-secondary" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type=button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button class="btn btn-primary" type="submit">Guardar cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- Mensajes SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Eliminar ingreso
    document.querySelectorAll('.btn-delete-income').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });

    // Eliminar egreso
    document.querySelectorAll('.btn-delete-expense').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>

@if(session('success'))
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: "Se ha editado correctamente",
                    confirmButtonColor: '#3085d6'
                });
            });
        </script>
    @endpush
@endif


@endsection
