@extends('layouts.app')

@section('content')
<h1>Registrar Ingreso</h1>

<form action="{{ route('incomes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required>
    </div>

    <div>
        <label for="income_type">Tipo de ingreso:</label>
        <select name="income_type" id="income_type" required>
            <option value="">Seleccione un tipo</option>
            @foreach($incomeTypes as $type)
            <option value="{{ $type->income_type_uuid }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="amount">Monto:</label>
        <input type="number" step="0.01" name="amount" id="amount" required>
    </div>

    <div>
        <label for="date">Fecha:</label>
        <input type="date" name="date" id="date" required>
    </div>

    <div>
        <label for="ticket">Factura (imagen):</label>
        <input type="file" name="ticket" id="ticket" accept="image/*">
    </div>

    <div>
        <label for="description">Descripción (opcional):</label>
        <textarea name="description" id="description"></textarea>
    </div>

    <button type="submit">Registrar Ingreso</button>
</form>

@if ($errors->any())
<div style="color: red;">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@endsection