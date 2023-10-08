<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransferController;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Account;

class TransferControllerTest extends TestCase
{

    /**
     * Prueba para el método createTransferencias.
     *
     * @return void
     */
    public function testCreateTransferencias()
    {
        // Crea una cuenta de prueba en la base de datos.
        $controller = new AccountController();
        $account = Account::inRandomOrder()->first();
        // Realiza una solicitud GET al método createTransferencias con la cédula de la cuenta creada.
        $response = $this->get('/transferencias/crearTransferencia/' . $account->cedula); // Ajusta la ruta según tu aplicación.

        // Verifica que la solicitud tenga el estado 200 (OK).
        $response->assertStatus(200);

        // Verifica que la vista correcta se cargue.
        $response->assertViewIs('cuentas.cuentas');

        // Verifica que las variables se pasen correctamente a la vista.
        $response->assertViewHas('accounts');
        $response->assertViewHas('transferir', true);
        $response->assertViewHas('cuenta_origen', $account);
        $response->assertViewHas('cuentas_destino');
    }

    /**
     * Prueba para el método store con datos válidos.
     *
     * @return void
     */
    public function testStoreWithValidData()
    {
        // Crea dos cuentas de prueba en la base de datos.
        $cuentaOrigen = Account::where('saldo', '>', 0)->inRandomOrder()->first();
        $cuentaDestino = Account::where('id', '!=', $cuentaOrigen->id)->inRandomOrder()->first();

        $montoATransferir = $cuentaOrigen->saldo * 0.5;


        // Datos de prueba para la transferencia.
        $requestData = [
            'cedula_origen' => $cuentaOrigen->cedula,
            'id_destino' => $cuentaDestino->id,
            'valor' => $montoATransferir,
        ];

        $request = new Request($requestData);
        $controller = new TransferController();
        $response = $controller->store($request);


        $this->assertEquals(302, $response->getStatusCode());

        $this->assertDatabaseHas('transfers', [
            'origin_account_id' => $cuentaOrigen->id,
            'destination_account_id' => $cuentaDestino->id,
            'valor' => number_format($montoATransferir, 2),
        ]);

        $cuentaOrigen->saldo -= $montoATransferir;
        $saldoCuentaOrigen = $cuentaOrigen->saldo;
        $cuentaOrigen->save();
        $cuentaDestino->saldo += $montoATransferir;
        $saldoCuentaDestino = $cuentaDestino->saldo;
        $cuentaDestino->save();

        $cuentaOrigen->refresh();
        $cuentaDestino->refresh();


        // Verifica que se haya creado un registro de reporte para la transferencia.
        $this->assertDatabaseHas('transactions', [
            'tipo' => 'Abono',
            'id_account' => $cuentaDestino->id,
            'monto' => number_format($montoATransferir, 2),
        ]);

        $this->assertDatabaseHas('transactions', [
            'tipo' => 'Debito',
            'id_account' => $cuentaOrigen->id,
            'monto' => number_format($montoATransferir, 2),
        ]);

        $locationHeader = $response->headers->get('Location'); 
        $parts = parse_url($locationHeader); 
        
        if (isset($parts['path'])) {
            $path = $parts['path']; 
        }

        $this->assertEquals('/cuentas', $path);

        $this->assertEquals('Transferencia exitosa.', session('success'));
    }

    /**
     * Prueba para el método store con datos inválidos (error de validación).
     *
     * DESCOMENTAR Y COMENTAR EL MÉTODO ANTERIOR
     * 
     * @return void
     */
    // public function testStoreWithInvalidData()
    // {
    //     // Datos de prueba para una transferencia inválida (sin saldo suficiente).
    //     $requestData = [
    //         'cedula_origen' => '123456789',
    //         'id_destino' => 1,
    //         'valor' => 2000,
    //     ];

    //     $request = new Request($requestData);
    //     $controller = new AccountController();
    //     $response = $controller->store($request);

    //     $this->assertEquals(302, $response->getStatusCode());

    //     $this->assertNotNull(session('errors'));

    //     $this->assertDatabaseMissing('transfers', [
    //         'valor' => 2000,
    //     ]);

    //     $cuentaOrigen = Account::where('cedula', '123456789')->first();
    //     $this->assertEquals(0, $cuentaOrigen->saldo);

    //     $this->assertDatabaseMissing('reports', [
    //         'monto' => 2000,
    //     ]);


    //     $locationHeader = $response->headers->get('Location'); 
    //     $parts = parse_url($locationHeader); 
        
    //     if (isset($parts['path'])) {
    //         $path = $parts['path']; 
    //     }

    //     $this->assertEquals('/cuentas', $path);

    //     // Verifica que se muestre el mensaje de error en la sesión.
    //     $this->assertStringContainsString('Ocurrió un error al transferir:', session('error'));
    // }
}
