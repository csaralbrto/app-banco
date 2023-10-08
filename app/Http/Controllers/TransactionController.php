<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response as ResponseFacade;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Transaction::paginate(10);
        $clientes = Account::all()->pluck('cedula', 'id');

        return view('reportes.reportes', compact('reports', 'clientes'));
    }

    /**
     * Filter and/or download reports according to the provided parameters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function filters(Request $request)
    {
        try {
            $query = Transaction::query();

            if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
                $fechaDesde = $request->input('fecha_desde');
                $fechaHasta = $request->input('fecha_hasta');

                if ($fechaHasta <= $fechaDesde) {
                    throw new \Exception('La fecha final debe ser mayor que la fecha incial.');
                }
                $query->byDateRange($fechaDesde, $fechaHasta);
            }

            if ($request->filled('nombre_cliente')) {
                $query->byClientName($request->input('nombre_cliente'));
            }

            if ($request->filled('cedula_cliente')) {
                $query->byAccountId($request->input('cedula_cliente'));
            }

            $reports = $query->get();

            if ($request->has('csv') && $request->input('csv') === '1') {
                if ($reports->isEmpty()) {
                    throw new \Exception('No existen registros para generar el CSV');
                }

                $csvData = $this->prepareCsvData($reports);
                $dataCSV = $this->downloadCSV($csvData);

                $csvFileName = 'reporte_transacciones' . time() . '.csv';
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
                ];

                return Response::stream(
                    function () use ($dataCSV) {
                        echo $dataCSV;
                    },
                    200,
                    $headers
                );
            }

            $clientes = Account::all()->pluck('cedula', 'id');

            return view('reportes.reportes', compact('reports', 'clientes'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al filtrar los informes: ' . $e->getMessage(), 200);
        }
    }

    /**
     * Prepara los datos para generar un archivo CSV a partir de una colección de informes.
     *
     * @param \Illuminate\Support\Collection $reports Colección de informes de transacciones.
     * @return array Datos formateados para el archivo CSV.
     */
    public function prepareCsvData(Collection $reports)
    {
        $csvData = [];
        $csvData[] = ['Tipo de Transacción', 'Monto', 'Cuenta', 'Saldo', 'Fecha de Transacción'];

        foreach ($reports as $report) {
            $csvData[] = [
                $report->tipo,
                $report->monto,
                $report->account->nombre,
                $report->saldo,
                $report->created_at,
            ];
        }

        return $csvData;
    }

    /**
     * Descarga un archivo CSV con los datos proporcionados.
     *
     * @param array $data Datos a ser escritos en el archivo CSV.
     * @return \Symfony\Component\HttpFoundation\StreamedResponse Respuesta HTTP que genera la descarga del CSV.
     */
    public function downloadCSV(array $data)
    {

        $output = fopen("php://output", "w");
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);

        return response()
            ->stream(
                function () use ($data) {
                    $file = fopen('php://output', 'w');
                    foreach ($data as $row) {
                        fputcsv($file, $row);
                    }
                    fclose($file);
                },
                200,
            );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Method for downloading csv file.
     */
    public function downloadCSVOLD()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
