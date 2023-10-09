@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl">Reportes</h1>
        </div>
        <div class="col-md-6 text-right">

        </div>
    </div>

    @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
        {{ session('error') }}
    </div>
    @endif


    <form action="{{ route('reportes.filters') }}" method="GET" class="mt-4">
        <input type="hidden" id="csv" name="csv" value="0">
        <div class="flex flex-wrap -mx-2">
            <div class="w-full md:w-1/6 px-2">
                <div class="mb-4">
                    <label for="fecha_desde" class="block mb-2 text-lg font-medium text-gray-900">Fecha Desde</label>
                    <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}">
                </div>
            </div>
            <div class="w-full md:w-1/6 px-2">
                <div class="mb-4">
                    <label for="fecha_hasta" class="block mb-2 text-lg font-medium text-gray-900">Fecha Hasta</label>
                    <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                </div>
            </div>
            <div class="w-full md:w-1/6 px-2">
                <div class="mb-4">
                    <label for="nombre_cliente" class="block mb-2 text-lg font-medium text-gray-900">Nombre Cliente</label>
                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="nombre_cliente" name="nombre_cliente" value="{{ request('nombre_cliente') }}">
                </div>
            </div>
            <div class="w-full md:w-1/4 px-2">
                <div class="mb-4">
                    <label for="cedula_cliente" class="block mb-2 text-lg font-medium text-gray-900">Cédula Cliente</label>
                    <select id="cedula_cliente" name="cedula_cliente" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="nombre_cliente" name="nombre_cliente">
                        <option value="{{ request('cedula_cliente') }}" disabled selected>Selecciona una cédula del cliente</option>
                        @foreach ($clientes as $key => $cliente)
                        <option value="{{ $key }}">{{ $cliente }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="w-full md:w-1/4 text-right px-2 pt-8">
                <button type="submit" id="filterForm" class="bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-lg text-white font-bold px-5 py-2.5 text-center mr-2 mb-2" onclick="setCSVValue()">Filtrar</button>
                <button type="submit" class="bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-lg text-white font-bold px-5 py-2.5 text-center mr-2 mb-2" onclick="downloadCSV()">Descargar CSV</button>
            </div>
        </div>
    </form>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-6">
        @if ($reports->isEmpty())
        <p class="text-center text-gray-700">No se encontraron resultados.</p>
        @else
        <table class="w-full text-lg text-left text-gray-900">
            <thead class="text-lg text-white uppercase bg-blue-900">
                <tr>
                    <th class="px-6 py-3">Tipo de Transacción</th>
                    <th class="px-6 py-3">Monto</th>
                    <th class="px-6 py-3">Cuenta</th>
                    <th class="px-6 py-3">Saldo</th>
                    <th class="px-6 py-3">Fecha de Transacción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                <tr class="border-b hover:bg-gray-200">
                    <td class="px-6 py-4">{{ $report->tipo }}</td>
                    <td class="px-6 py-4">{{ $report->monto }}</td>
                    <td class="px-6 py-4">{{ $report->account->nombre }}</td>
                    <td class="px-6 py-4">{{ $report->saldo }}</td>
                    <td class="px-6 py-4">{{ $report->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-4">
            <!-- {{ $reports->links() }} -->
        </div>
        @endif
    </div>
</div>
@endsection
<script>
    function setCSVValue() {
        document.getElementById('csv').value = '0';
    }

    function downloadCSV() {
        console.log('click')
        document.getElementById('csv').value = '1';
    }
</script>