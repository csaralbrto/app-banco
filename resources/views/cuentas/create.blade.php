@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl">Crear Cuenta bancaria</h1>

    @if ($errors->any())
    <div  class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
    <span class="sr-only">Close</span>
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
    </svg>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('error'))
    <div  class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
        {{ session('error') }}
    </div>
    @endif
<div class="py-5">
    <a href="{{ route('cuentas.index') }}" class="text-blue-900 hover:text-white border border-blue-900 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Atrás</a>
</div>

    <form method="POST" action="{{ route('cuentas.store') }}" class="py-8">
        @csrf
        <div class="sm:grid grid-col-1 gap-4 md:grid grid-col-1 gap-4 lg:grid grid-cols-2 gap-4 xl:grid grid-cols-2 gap-4">
            <div>
                <label for="cedula" class="block mb-2 text-lg font-medium text-gray-900">Cédula</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="cedula" name="cedula" required>
            </div>
            <div>
                <label for="nombre" class="block mb-2 text-lg font-medium text-gray-900">Nombre</label>
                <input type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="saldo" class="block mb-2 text-lg font-medium text-gray-900">Saldo</label>
                <input type="number"  class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="saldo" name="saldo" step="0.01" min="0" value="0">
            </div>
        </div>
        <div class="text-right py-8">
            <button type="submit" class="bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800  rounded-lg text-lg text-white font-bold px-5 py-2.5 text-center mr-2 mb-2">Agregar</button>
        </div>
    </form>
</div>
@endsection