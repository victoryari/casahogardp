<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use App\Models\ConfiguracionEmpresa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Roles del sistema ───────────────────────────────
        $roles = [
            ['nombre_rol' => 'Administrador',  'descripcion' => 'Acceso total al sistema'],
            ['nombre_rol' => 'Médico',          'descripcion' => 'Gestión clínica de pacientes'],
            ['nombre_rol' => 'Enfermería',      'descripcion' => 'Atención y registro de pacientes'],
            ['nombre_rol' => 'RRHH',            'descripcion' => 'Gestión de personal y turnos'],
            ['nombre_rol' => 'Facturación',     'descripcion' => 'Emisión y gestión de facturas'],
            ['nombre_rol' => 'Finanzas',        'descripcion' => 'Control de ingresos y egresos'],
            ['nombre_rol' => 'Marketing',       'descripcion' => 'Gestión de prospectos y campañas'],
            ['nombre_rol' => 'Supervisor',      'descripcion' => 'Supervisión operativa'],
        ];

        foreach ($roles as $rol) {
            Rol::firstOrCreate(['nombre_rol' => $rol['nombre_rol']], $rol);
        }

        $rolAdmin = Rol::where('nombre_rol', 'Administrador')->first();

        // ── Usuario Administrador por defecto ───────────────
        Usuario::firstOrCreate(
            ['nombre_usuario' => 'admin'],
            [
                'id_rol'        => $rolAdmin->id_rol,
                'id_personal'   => null,
                'password_hash' => Hash::make('Admin1234!'),
                'estado'        => 1,
            ]
        );

        // ── Configuración de empresa ────────────────────────
        ConfiguracionEmpresa::firstOrCreate(
            ['id_config' => 1],
            [
                'ruc'              => '20000000001',
                'razon_social'     => 'CasaHogar S.A.C.',
                'nombre_comercial' => 'CasaHogar',
                'direccion'        => 'Av. Principal 123, Lima',
                'telefono'         => '01-1234567',
                'correo'           => 'info@casahogar.pe',
                'moneda'           => 'PEN',
            ]
        );

        $this->command->info('✓ Roles creados: ' . Rol::count());
        $this->command->info('✓ Admin: admin / Admin1234!');
        $this->command->info('✓ Configuración inicial cargada');
    }
}
