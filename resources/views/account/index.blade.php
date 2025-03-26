@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5 py-5 text-white">
        <div class="mb-5 ">
            <h1 class="text-white">Cuentas</h1>
            <button class="btn btn-primary mt-2 justify-content-md-end" data-bs-toggle="modal" data-bs-target="#createAccount">
                Crear cuenta
            </button>
        </div>
    </div>

    <!-- #region Modal's section -->
    <div class="modal fade text-white" id="createAccount" tabindex="-1" aria-labelledby="createAccountLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dark">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header bg-dark input-group">
                    <h5 class="modal-title" id="createIncomeModalLabel">Nueva cuenta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body bg-dark">
                    <form action="{{ route('accounts.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre de la cuenta</label>
                            <input type="text" name="name" id="name"
                                class="form-control border border-secondary bg-dark text-white" required>
                            @if ($errors->has('name'))
                                <ul class="mt-3">
                                    @foreach ($errors->get('name') as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="account_type_uuid" class="form-label">Tipo de cuenta:</label>
                            <select name="account_type_uuid" id="account_type_uuid"
                                class="form-select bg-dark text-white border border-secondary" required>
                                <option value="">Seleccione un tipo</option>
                                @foreach ($accountType as $type)
                                    <option value="{{ $type->account_type_uuid }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('account_type_uuid'))
                                <ul class="mt-3">
                                    @foreach ($errors->get('account_type_uuid') as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="show-amount-field">
                                <label class="form-check-label" for="show-amount-field">
                                    ¿La cuenta tiene un monto inicial?
                                </label>
                            </div>
                        </div>
                        <div class="mb-3" style="display: none" id="initial-amount">
                            <label for="amount" class="form-label">Monto inicial</label>
                            <input type="number" name="amount" id="amount"
                                class="form-control border border-secondary bg-dark text-white" value="0" required>
                            @if ($errors->has('amount'))
                                <ul class="mt-3">
                                    @foreach ($errors->get('amount') as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="modal-footer bg-dark border-top border-secondary">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('show-amount-field').addEventListener('change', () => {
            if (document.getElementById('show-amount-field').checked) {
                document.getElementById('initial-amount').style.display = 'block';
            } else {
                document.getElementById('initial-amount').style.display = 'none';
            }
        })
    </script>
    <!-- #endregion -->
@endsection
