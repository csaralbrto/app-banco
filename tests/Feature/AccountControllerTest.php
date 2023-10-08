<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountControllerTest extends TestCase
{
    /**
     * Prueba para el método index.
     *
     * @return void
     */
    public function testIndex()
    {
        $controller = new AccountController();
        $accounts = Account::all();
        // Realiza una solicitud GET al método index.

        $response = $this->get(route('cuentas.index'));

        // Verifica que la solicitud tenga el estado 200 (OK).
        $response->assertStatus(200);

        // Verifica que la vista correcta se cargue.
        $response->assertViewIs('cuentas.cuentas');

        // Verifica que las cuentas se pasen a la vista.
        $response->assertViewHas('accounts', $accounts);

        // Verifica que las variables adicionales se pasen a la vista.
        $response->assertViewHas('transferir', false);
        $response->assertViewHas('cedula_origen', null);
    }

    /**
     * Prueba para el método store con datos válidos.
     *
     * DESCOMENTAR Y COMENTAR EL MÉTODO SIGUIENTE
     * @return void
     */
    // public function testStoreWithValidData()
    // {
    //     $requestData = [
    //         'cedula' => '123456789',
    //         'nombre' => 'John Doe',
    //         'saldo' => 1000,
    //     ];
    //     $controller = new AccountController();

    //     $request = new Request($requestData);
    //     $response = $controller->store($request);

    //     $this->assertEquals(302, $response->getStatusCode());

    //     $this->assertDatabaseHas('accounts', [
    //         'cedula' => $requestData['cedula'],
    //         'nombre' => $requestData['nombre'],
    //         'saldo' => $requestData['saldo'],
    //     ]);

    //     $this->assertStringContainsString('/cuentas', $response->headers->get('Location')); 

    //     $this->assertEquals('Cuenta creada exitosamente.', session('success'));
    // }

    /**
     * Prueba para el método store con datos inválidos (error de validación).
     *
     * @return void
     */
    public function testStoreWithInvalidData()
    {
        $requestData = [
            'nombre' => 'John Doe invalid',
        ];
        $controller = new AccountController();

        $request = new Request($requestData);
        $response = $controller->store($request);

        $this->assertEquals(302, $response->getStatusCode());

        // $this->assertFalse(session()->has('errors'));

        $this->assertDatabaseMissing('accounts', [
            'nombre' => $requestData['nombre'],
        ]);

        $this->assertStringContainsString('/cuentas/create', $response->headers->get('Location')); 

        $this->assertStringContainsString('Ocurrió un error al crear la cuenta:', session('error'));
    }
}
