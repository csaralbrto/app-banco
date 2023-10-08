<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;


class TransactionControllerTest extends TestCase
{
    /** @test */
    public function it_displays_a_listing_of_reports()
    {
        $response = $this->get(route('reportes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('reportes.reportes');

        $response->assertViewHas('reports');
        $response->assertViewHas('clientes');
    }
    public function testFiltersMethod()
    {
        $controller = new TransactionController();

        $request = new Request([
            'fecha_desde' => '2023-01-01',
            'fecha_hasta' => '2023-12-31',
            'nombre_cliente' => 'John Doe',
            'cedula_cliente' => '123456789',
            'csv' => '1',
        ]);
        // Llama al método filters y obtén la respuesta
        $response = $controller->filters($request);

        // $actualReports = $response->original->getData()['reports'];

        // Verifica que la respuesta sea exitosa (código HTTP 200)
        // $this->assertEquals(200, $response->getStatusCode());        
        // Verifica que la respuesta sea exitosa (código HTTP 302) o puede cambiarlo dependiendo de lo que necesite mostrar
        $this->assertEquals(302, $response->getStatusCode());

        // // Puedes verificar el mensaje de error específico si lo deseas.
        $this->assertEquals(
            'Ocurrió un error al filtrar los informes: No existen registros para generar el CSV',
            session('error')
        );


        // Verifica que la respuesta sea un archivo CSV
        // $this->assertEquals('text/csv', $response->headers->get('Content-Type'));
        // $this->assertEquals('attachment; filename="reporte_transacciones' . time() . '.csv"', $response->headers->get('Content-Disposition'));
        // $this->assertTrue(str_contains($response->getContent(), 'Tipo de Transacción'));
        // $this->assertTrue(str_contains($response->getContent(), 'Monto'));
        // $this->assertTrue(str_contains($response->getContent(), 'Cuenta'));
        // $this->assertTrue(str_contains($response->getContent(), 'Saldo'));
        // $this->assertTrue(str_contains($response->getContent(), 'Fecha de Transacción'));
        // $this->assertStringStartsWith("Tipo de Transacción,Monto,Cuenta,Saldo,Fecha de Transacción\n", $response->getContent());

    }

    /**
     * Prueba para prepareCsvData.
     *
     * @return void
     */
    public function testPrepareCsvData()
    {
        $controller = new TransactionController();

        // Crea una colección de informes de prueba.
        $reports = new Collection([
            (object) [
                'tipo' => 'Depósito',
                'monto' => 1000,
                'account' => (object) ['nombre' => 'Cuenta 1'],
                'saldo' => 2000,
                'created_at' => '2023-01-02 10:00:00',
            ],
            (object) [
                'tipo' => 'Retiro',
                'monto' => 500,
                'account' => (object) ['nombre' => 'Cuenta 2'],
                'saldo' => 1500,
                'created_at' => '2023-01-03 14:30:00',
            ],
        ]);

        $csvData = $controller->prepareCsvData($reports);

        $this->assertEquals([
            ['Tipo de Transacción', 'Monto', 'Cuenta', 'Saldo', 'Fecha de Transacción'],
            ['Depósito', 1000, 'Cuenta 1', 2000, '2023-01-02 10:00:00'],
            ['Retiro', 500, 'Cuenta 2', 1500, '2023-01-03 14:30:00'],
        ], $csvData);
    }

}
