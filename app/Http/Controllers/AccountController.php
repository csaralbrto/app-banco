<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Exception;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all();
        $transferir = false;
        $cedula_origen = null;

        return view('cuentas.cuentas', compact('accounts', 'transferir', 'cedula_origen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cuentas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'cedula' => 'required|numeric|unique:accounts',
                'nombre' => 'required',
                'saldo' => 'nullable|numeric',
            ]);

            $account = Account::create([
                'cedula' => $validatedData['cedula'],
                'nombre' => $validatedData['nombre'],
                'saldo' => $request->input('saldo', 0),
                'profile_id' => $request->input('profile_id', 1),
            ]);

            return redirect('/cuentas')->with('success', 'Cuenta creada exitosamente.');
        } catch (\Exception $e) {
            return redirect('/cuentas/create')->with('error', 'Ocurrió un error al crear la cuenta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
