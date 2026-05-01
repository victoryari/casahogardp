<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Factura::with('paciente');
        if ($request->filled('buscar')) {
            $query->whereHas('paciente', fn($q) => $q->where('nombres', 'like', "%{$request->buscar}%")
                ->orWhere('apellidos', 'like', "%{$request->buscar}%"));
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        $facturas = $query->latest('fecha_emision')->paginate(15)->withQueryString();
        return view('facturacion.index', compact('facturas'));
    }

    public function create()
    {
        $pacientes = Paciente::where('estado', 1)->orderBy('apellidos')->get();
        $servicios = Servicio::where('estado', 1)->orderBy('nombre_servicio')->get();
        $serie     = 'F001';
        $correlativo = str_pad(Factura::count() + 1, 6, '0', STR_PAD_LEFT);
        return view('facturacion.create', compact('pacientes', 'servicios', 'serie', 'correlativo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_paciente'          => 'required|exists:pacientes,id_paciente',
            'fecha_emision'        => 'required|date',
            'servicios'            => 'required|array|min:1',
            'servicios.*.id'       => 'required|exists:servicios,id_servicio',
            'servicios.*.cantidad' => 'required|numeric|min:1',
            'servicios.*.precio'   => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            foreach ($request->servicios as $item) {
                $subtotal += $item['cantidad'] * $item['precio'];
            }
            $igv   = round($subtotal * 0.18, 2);
            $total = $subtotal + $igv;

            $factura = Factura::create([
                'id_paciente'        => $request->id_paciente,
                'id_usuario_registro'=> auth()->id(),
                'serie'              => 'F001',
                'correlativo'        => str_pad(Factura::count() + 1, 6, '0', STR_PAD_LEFT),
                'fecha_emision'      => $request->fecha_emision,
                'subtotal'           => $subtotal,
                'impuestos'          => $igv,
                'total'              => $total,
                'estado'             => 1,
            ]);

            foreach ($request->servicios as $item) {
                DetalleFactura::create([
                    'id_factura'    => $factura->id_factura,
                    'id_servicio'   => $item['id'],
                    'cantidad'      => $item['cantidad'],
                    'precio_unitario'=> $item['precio'],
                    'subtotal'      => $item['cantidad'] * $item['precio'],
                ]);
            }

            BitacoraSistema::registrar('CREAR', 'facturas', $factura->id_factura, "Factura {$factura->serie}-{$factura->correlativo} creada");
        });

        return redirect()->route('facturacion.index')->with('success', 'Factura emitida correctamente.');
    }

    public function show(Factura $factura)
    {
        $factura->load(['paciente', 'detalles.servicio', 'usuarioRegistro']);
        return view('facturacion.show', compact('factura'));
    }

    public function destroy(Factura $factura)
    {
        $factura->update(['estado' => 0]);
        BitacoraSistema::registrar('ANULAR', 'facturas', $factura->id_factura, "Factura anulada");
        return redirect()->route('facturacion.index')->with('success', 'Factura anulada.');
    }

    public function generarPdf(Factura $factura)
    {
        $factura->load(['paciente', 'detalles.servicio']);
        $pdf = Pdf::loadView('facturacion.pdf', compact('factura'));
        return $pdf->download("factura_{$factura->serie}_{$factura->correlativo}.pdf");
    }
}
