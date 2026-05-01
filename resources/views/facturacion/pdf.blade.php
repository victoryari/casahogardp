<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $factura->serie }}-{{ $factura->correlativo }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header { margin-bottom: 40px; }
        .header table { width: 100%; }
        .logo { font-size: 28px; font-weight: bold; color: #0d9488; }
        .invoice-info { text-align: right; }
        .invoice-info h2 { margin: 0; color: #0f172a; font-size: 20px; }
        .details { margin-bottom: 30px; }
        .details table { width: 100%; border-collapse: collapse; }
        .details th { background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        .details td { padding: 10px; border-bottom: 1px solid #f1f5f9; }
        .totals { margin-top: 20px; float: right; width: 30%; }
        .totals table { width: 100%; }
        .totals td { padding: 5px 0; }
        .total-row { font-weight: bold; font-size: 14px; color: #0d9488; border-top: 2px solid #0d9488; }
        .footer { position: fixed; bottom: 30px; left: 0; right: 0; text-align: center; font-size: 10px; color: #94a3b8; }
        .status-stamp {
            position: absolute; top: 150px; right: 50px; border: 4px solid #ef4444; color: #ef4444;
            padding: 10px 20px; font-weight: bold; font-size: 24px; transform: rotate(-15deg);
            opacity: 0.3; border-radius: 10px; text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        @if(!$factura->estado)
            <div class="status-stamp">ANULADA</div>
        @endif

        <div class="header">
            <table>
                <tr>
                    <td>
                        <div class="logo">CasaHogar</div>
                        <p style="margin-top: 5px;">Sistema de Gestión Administrativa<br>Lima, Perú</p>
                    </td>
                    <td class="invoice-info">
                        <h2>COMPROBANTE ELECTRÓNICO</h2>
                        <p><strong>RUC:</strong> 20123456789</p>
                        <p><strong>{{ $factura->serie }}-{{ $factura->correlativo }}</strong></p>
                        <p>Fecha: {{ $factura->fecha_emision->format('d/m/Y') }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="details" style="margin-bottom: 40px;">
            <p><strong>DATOS DEL CLIENTE / PACIENTE</strong></p>
            <p>Nombre: {{ $factura->paciente->nombre_completo }}</p>
            <p>Documento: {{ $factura->paciente->tipo_documento }} {{ $factura->paciente->numero_documento }}</p>
        </div>

        <div class="details">
            <table>
                <thead>
                    <tr>
                        <th>Descripción del Servicio</th>
                        <th style="text-align: center; width: 80px;">Cant.</th>
                        <th style="text-align: right; width: 100px;">Precio Unit.</th>
                        <th style="text-align: right; width: 100px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->servicio->nombre_servicio }}</td>
                        <td style="text-align: center;">{{ number_format($detalle->cantidad, 2) }}</td>
                        <td style="text-align: right;">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td style="text-align: right;">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td style="text-align: right;">S/ {{ number_format($factura->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>IGV (18%):</td>
                    <td style="text-align: right;">S/ {{ number_format($factura->impuestos, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>TOTAL:</td>
                    <td style="text-align: right;">S/ {{ number_format($factura->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Este documento es una representación impresa de un comprobante de control interno.</p>
            <p>CasaHogar Management System &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
