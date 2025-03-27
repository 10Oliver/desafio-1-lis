@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5 py-5 text-white">
        <div class="mb-5 ">
            <h1 class="text-white">Cuentas</h1>
            <button class="btn btn-primary mt-2 justify-content-md-end" data-bs-toggle="modal" data-bs-target="#createAccount">
                Crear cuenta
            </button>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- #region DataTable -->
        <div class="table-responsive">
            <table class="table table-dark table-hover rounded-lg">
                <thead class="">
                    <tr>
                        <th>Nombre</th>
                        <th>Monto</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>

                </thead>

                <tbody class="table-group-divider">
                    @foreach ($accounts as $account)
                        <tr>
                            <td>
                                {{ $account->account->name }}
                            </td>
                            <td>
                                {{ $account->account->amount }}
                            </td>
                            <td>
                                {{ $account->account->accountType->name ?? 'Sin tipo de cuenta' }}
                            </td>
                            <td class="d-flex">
                                <button type="button"
                                    class="btn btn-primary d-flex justify-content-center align-items-center me-2 px-2"
                                    data-bs-toggle="modal" data-bs-target="#editAccount"
                                    onclick="openEdit('{{ route('accounts.show', ['account' => $account->account->account_uuid]) }}')">
                                    <span class="material-symbols-outlined text-white">
                                        edit
                                    </span>
                                </button>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteAccount"
                                    onclick="openDelete('{{ route('accounts.destroy', ['account' => $account->account->account_uuid]) }}')"
                                    class="btn btn-danger d-flex justify-content-center align-items-center px-2">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- #endregion -->
    </div>


    <!-- #region Modal's section -->

    <!-- Create modal -->
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit modal -->
    <div class="modal fade text-white" id="editAccount" tabindex="-1" aria-labelledby="editAccountLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dark">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header bg-dark input-group">
                    <h5 class="modal-title" id="createIncomeModalLabel">Editar cuenta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body bg-dark">
                    <form id="edit-form" action="{{ route('accounts.update', ['account' => '1']) }}" method="POST"
                        autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="account_uuid" id="account_uuid">
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
                        <div class="modal-footer bg-dark border-top border-secondary">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete confirmation -->
    <div class="modal fade text-white" id="deleteAccount" tabindex="-1" aria-labelledby="deleteAccountLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dark">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header bg-dark input-group">
                    <h5 class="modal-title" id="createIncomeModalLabel">Eliminar cuenta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body bg-dark">
                    <form id="delete-form" action="" method="POST" autocomplete="off">
                        @csrf
                        @method('DELETE')
                        <p>Estás a punto de eliminar la cuenta, esta acción no es reversible.</p>
                        <h6>¿Deseas continuar?</h6>
                        <div class="modal-footer bg-dark border-top border-secondary">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- endpoints -->

    <script>
        function openEdit(path) {
            fetch(path, {
                    method: 'GET',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'input[name="_token"]'
                        ).value,
                    },
                })
                .then((response) => response.json())
                .then(({
                    data
                }) => {
                    const form = document.getElementById('edit-form');

                    form.querySelector('[name="name"]').value = data.name;
                    form.querySelector('[name="account_type_uuid"]').value = data.account_type_uuid;

                    form.action = form.action.replace(/\/\d+$/, '/' + data.account_uuid);
                });
        }

        function openDelete(path) {
            const form = document.getElementById('delete-form');

            form.action = path;
        }

        document.getElementById('show-amount-field').addEventListener('change', () => {
            if (document.getElementById('show-amount-field').checked) {
                document.getElementById('initial-amount').style.display = 'block';
            } else {
                document.getElementById('initial-amount').style.display = 'none';
            }
        });
    </script>
    <!-- #endregion -->
@endsection
