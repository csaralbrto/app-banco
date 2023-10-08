@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl">Lista de Cuentas</h1>
        </div>
        <div class="col-md-6 text-right py-8">
            <a href="{{ route('cuentas.create') }}" class="bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800  rounded-lg text-lg text-white font-bold px-5 py-2.5 text-center mr-2 mb-2">Crear Nueva Cuenta</a>
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
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-lg text-left text-gray-900">
        <thead  class="text-lg text-white uppercase bg-blue-900">
            <tr>
                <th class="px-6 py-3">Cédula</th>
                <th class="px-6 py-3">Nombre</th>
                <th class="px-6 py-3">Saldo</th>
                <th class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
            <tr class="border-b hover:bg-gray-200"> 
                <td class="px-6 py-4">{{ $account->cedula }}</td>
                <td class="px-6 py-4">{{ $account->nombre }}</td>
                <td class="px-6 py-4">{{ $account->saldo }}</td>
                <td class="px-6 py-4">
                    <a class="bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800  rounded-lg text-lg text-white font-bold px-5 py-2.5 text-center mr-2 mb-2" href="{{ route('transferencias.crearTransferencia', $account->cedula) }}">
                        Transferir
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <!-- Formulario de transferencias -->

    @if ($transferir)
    <div class="pt-10">
        <div class="bg-white border border-gray-200 rounded-lg shadow p-8 ">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-3xl font-bold">Comenzar Transferecia</h2>
                <form method="POST" action="{{ route('transferencias.store') }}" class="pt-6">
                    @csrf
                    <div class="sm:grid grid-col-1 gap-4 md:grid grid-col-1 gap-4 lg:grid grid-cols-2 gap-4 xl:grid grid-cols-2 gap-4 ">
                    <div class="mb-4">
                        <label for="cedula_origen" class="block mb-2 text-lg font-medium text-gray-900">Cédula de Origen</label>
                        <input type="text" id="cedula_origen" name="cedula_origen" value="{{ $cuenta_origen->cedula }}" readonly  class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"/>
                    </div>
                    <div class="mb-4">
                        <label for="id_destino" class="block mb-2 text-lg font-medium text-gray-900">Cédula de Destino</label>
                        <select id="id_destino" name="id_destino" required class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="" disabled selected>Selecciona una cédula de destino</option>
                            @foreach ($cuentas_destino as $key => $cuenta)
                            <option value="{{ $key }}">{{ $cuenta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="valor" class="block mb-2 text-lg font-medium text-gray-900">Valor</label>
                        <input type="number" id="valor" name="valor" step="0.01" min="0" placeholder="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    </div>
                    </div>
                    <div class="text-right">
                        <button type="submit"class="t bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800  rounded-lg text-lg text-white font-bold px-5 py-2.5 text-center mr-2 mb-2">Aceptar</button>
                    </div>
                </form>
            </div>
    </div>
    </div>
    @endif
</div>
@endsection