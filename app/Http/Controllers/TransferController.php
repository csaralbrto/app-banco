<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Account;
use App\Models\Transaction;
use Exception;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createTransferencias(String $cedula)
    {
        $accounts = Account::all();
        $transferir = true;
        $cuenta_origen = Account::where('cedula', $cedula)->first();
        $cuentas_destino = Account::where('cedula', '!=', $cedula)->pluck('cedula', 'id');


        return view('cuentas.cuentas', compact('accounts', 'transferir', 'cuenta_origen', 'cuentas_destino'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cedula_origen' => 'required',
            'id_destino' => 'required',
            'valor' => 'required|numeric',
        ]);

        try {
            $cuenta_origen = Account::where('cedula', $request->input('cedula_origen'))->first();
            $cuenta_destino = Account::findOrFail($request->input('id_destino'));
            $valor = $request->input('valor');

            if ($cuenta_origen->saldo < $valor) {
                throw new \Exception('La cuenta de origen no posee el saldo a transferir');
            }


            $transfer = Transfer::create([
                'origin_account_id' => $cuenta_origen->id,
                'destination_account_id' => $request->input('id_destino'),
                'valor' => $valor,
            ]);
            if ($transfer) {
                $cuenta_origen->saldo -= $valor;
                $cuenta_origen->save();
                $cuenta_destino->saldo += $valor;
                $cuenta_destino->save();
                $this->createReport('Abono', $cuenta_destino, $valor);
                $this->createReport('Debito', $cuenta_origen, $valor);
            }


            return redirect('/cuentas')->with('success', 'Transferencia exitosa.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al transferir: ' . $e->getMessage());
        }
    }


    // Método para crear un informe
    private function createReport($tipo, $cuenta, $valor)
    {
        Transaction::create([
            'tipo' => $tipo,
            'monto' => $valor,
            'id_account' => $cuenta->id,
            'saldo' => $cuenta->saldo,
        ]);
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
