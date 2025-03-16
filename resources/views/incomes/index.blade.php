@extends('layouts.app')

@section('content')
<h1>Listado de Ingresos</h1>
<a href="{{ route('incomes.create') }}">Registrar nuevo ingreso</a>

@if(session('success'))
<div style="color: green;">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Factura</th>
        </tr>
    </thead>
    <tbody>
        @foreach($incomes as $income)
        <tr>
            <td>{{ $income->name }}</td>
            <td>{{ $income->amount }}</td>
            <td>{{ $income->date }}</td>
            <td>
                @if($income->ticket_path)
                <img src="{{ asset('storage/' . $income->ticket_path) }}" alt="Factura" width="100" onclick="mostrarImagen('{{ asset('storage/' . $income->ticket_path) }}')">
                @else
                Sin factura
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div id="modal" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.8); align-items: center; justify-content: center;">
    <img id="modal-img" src="" style="max-width: 90%; max-height: 90%;">
</div>
@endsection

@section('scripts')
<script>
    function mostrarImagen(src) {
        document.getElementById('modal-img').src = src;
        document.getElementById('modal').style.display = 'flex';
    }

    document.getElementById('modal').addEventListener('click', function() {
        this.style.display = 'none';
    });
</script>
@endsection