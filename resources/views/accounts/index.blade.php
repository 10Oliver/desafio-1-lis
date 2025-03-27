@extends('layouts.app')

@section('content')
<div class="container-fluid m-5 text-white">
<!-- resources/views/dashboard.blade.php -->
   <!-- Encabezado -->
   <div class="mb-5 ">
    <h1 class="text-white">Cuentas</h1>
    <!-- Botón para abrir el modal -->
    <button class="btn btn-primary mt-2 justify-content-md-end" data-bs-toggle="modal" data-bs-target="#createAccountModal">
        Crear Cuenta
    </button>
</div>

 <!-- Primer Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dark">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="createAccountModalLabel">Nueva Cuenta (Paso 1)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body bg-dark">
                <!-- Un solo form para ambos pasos -->
                <form action="{{ route('accounts.store') }}" method="POST" enctype="multipart/form-data" id="accountForm">
                    @csrf

                    <div class="mb-3">
                        <label for="account_type" class="form-label">Tipo de cuenta:</label>
                        <select name="account_type" id="account_type" class="form-select bg-dark text-white" required>
                            <option value="" disabled selected>Seleccione tipo de cuenta</option>
                            <option value="" selected>Ahorro</option>
                            <option value="" selected>Credito</option>
                            @foreach($accountTypes as $type)
                                @if(!empty($type->account_type))
                            <option value="{{ $type->account_type }}">{{ $type->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>



                    <div class="modal-footer bg-dark border-dark">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        <!-- Botón para abrir el segundo modal -->
                        <button type="button" class="btn btn-primary" id="nextButton">Siguiente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Segundo Modal -->
<div class="modal fade" id="secondStepModal" tabindex="-1" aria-labelledby="secondStepModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dark">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="secondStepModalLabel">Nueva Cuenta (Paso 2)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body bg-dark">
                <!-- Reutilizamos el mismo form -->
                <div class="mb-3">
                    <label for="name" class="form-label bg-dark text-white">Nombre de la cuenta:</label>
                    <input type="text" name="name" id="name" class="form-control bg-dark text-white border border-dark-subtle" required>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label bg-dark text-white">Monto de la cuenta:</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control bg-dark text-white border border-dark-subtle" required>
                </div>
                <input type="hidden" name="uuid" id="uuid">
                <div class="modal-footer bg-dark border-dark">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar los modales -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nextButton = document.getElementById('nextButton');
        const form = document.getElementById('accountForm');

        nextButton.addEventListener('click', function () {
            const accountType = document.getElementById('account_type').value.trim();

            if (account_type !== '') {
                const firstModalElement = document.getElementById('createAccountModal');
                const firstModalInstance = bootstrap.Modal.getInstance(firstModalElement);
                if (firstModalInstance) {
                    firstModalInstance.hide();
                } else {
                    new bootstrap.Modal(firstModalElement).hide();
                }

                const secondModalElement = document.getElementById('secondStepModal');
                const secondModal = new bootstrap.Modal(secondModalElement);
                secondModal.show();
            } else {
                alert('Por favor, seleccione un tipo de cuenta antes de continuar.');
            }
        });

        // Validación al guardar
        const saveButton = document.querySelector('#secondStepModal .btn-success');
        saveButton.addEventListener('click', function (e) {
            const name = document.getElementById('name').value.trim();
            const amount = document.getElementById('amount').value.trim();

            if (name === '' || amount === '') {
                e.preventDefault(); // Evita el envío del formulario
                alert('Por favor, complete todos los campos antes de guardar.');
            } else {
                alert('Guardado Correctamente   ');
                document.getElementById('account_type_uuid').value = account_type_uuid.v4();
                form.submit(); // Enviar si todo está completo
            }
        });
    });
</script>
@endsection
