<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            'comercial' => [
                'index.' => [
                    'index'     => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                ],
                'tarifa.' => [
                    'index'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'show'   => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'create' => ['Administrador', 'Jefe de oficina'],
                    'edit'   => ['Administrador', 'Jefe de oficina'],
                    'delete' => ['Administrador'],
                ],
                'descuento.' => [
                    'index'  => ['Administrador', 'Vendedor'],
                    'show'   => ['Administrador', 'Vendedor'],
                    'create' => ['Administrador'],
                    'edit'   => ['Administrador'],
                    'delete' => ['Administrador'],
                    'resumen-mensual' => ['Administrador'],
                ],
                'pasaje.' => [
                    'index'  => ['Administrador', 'Vendedor'],
                    'create' => ['Administrador', 'Vendedor'],
                    'create-free' => ['Administrador'],
                    'show'   => ['Administrador', 'Vendedor'],
                    'edit'   => ['Administrador', 'Vendedor'],
                    'anular' => ['Administrador', 'Vendedor'],
                    'cambio.titular.index'      => ['Administrador', 'Vendedor'],
                    'cambio.titular.create'     => ['Administrador', 'Jefe de oficina'],
                    'cambio.titular.create.super'     => ['Administrador', 'Jefe de oficina'],
                    'cambio.fecha.index'        => ['Administrador', 'Vendedor'],
                    'cambio.fecha.create'       => ['Administrador', 'Vendedor'],
                    'cambio.fecha.create.super'       => ['Administrador', 'Jefe de oficina'],
                    'cambio.fecha-abierta.index'    => ['Administrador', 'Vendedor'],
                    'cambio.fecha-abierta.create'   => ['Administrador', 'Vendedor'],
                    'cambio.fecha-abierta.create.super'   => ['Administrador', 'Jefe de oficina'],
                    'cambio.ruta.index'         => ['Administrador', 'Vendedor'],
                    'cambio.ruta.create'        => ['Administrador', 'Vendedor'],
                    'cambio.ruta.create.super'        => ['Administrador', 'Jefe de oficina'],
                    'bulto.create'          => ['Administrador', 'Vendedor'],
                    'checkin.create'        => ['Administrador', 'Vendedor'],
                    'boarding-pass.export'  => ['Administrador', 'Vendedor'],
                    'comprobantes.index'     => ['Administrador', 'Vendedor'],
                    'comprobantes.download' => ['Administrador', 'Vendedor'],
                ],
                'cliente.' => [
                    'index'     => ['Administrador', 'Vendedor'],
                    'show'      => ['Administrador', 'Vendedor'],
                    'create'    => ['Administrador', 'Vendedor'],
                    'edit'      => ['Administrador', 'Vendedor'],
                    'delete'    => ['Administrador', 'Vendedor'],
                    // REGISTROS QUE APARECEN DESDE EL PERFIL EL CLIENTE
                    'guia-despacho.index'  => ['Administrador', 'Vendedor'],
                    'pasaje.index'      => ['Administrador', 'Vendedor'],
                    'pago.index'        => ['Administrador', 'Vendedor'],
                ],
                'vuelo-credito.' => [
                    'index'     => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'show'      => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'create'    => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'edit'      => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'delete'    => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                ],
                'vuelo-credito-amortizacion.' => [
                    'index'     => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'show'      => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'create'    => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'edit'      => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'delete'    => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                ],
                'pasaje-cambio.' => [
                    'index' => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'confirmar' => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'denegar' => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                ],
                'pasaje-abierto.' => [
                    'index'         => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'asignar-vuelo' => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'delete'        => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                ],
            ],
            'caja' => [
                'caja.' => [
                    'index'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'show'   => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                ],
                'venta.' => [
                    'index'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'show'   => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                ],
                'caja-apertura-cierre.' => [
                    'index'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'create'   => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'edit'   => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'show'   => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'export'   => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                ],
                'extorno.' => [
                    'index'  => ['Administrador', 'Jefe de oficina'],
                    'create'  => ['Administrador', 'Jefe de oficina', 'Cajero'],
                    'aprobar'  => ['Administrador', 'Jefe de oficina'],
                    'rechazar'  => ['Administrador', 'Jefe de oficina'],
                ],
                'caja-movimiento.' => [
                    'create'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                ],
                'facturacion.' => [
                    'create'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                ],
                'comprobante.' => [
                    'index'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'show'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'delete'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                    'facturar'  => ['Administrador', 'Jefe de oficina', 'Cajero', 'Vendedor'],
                ],
                'cuenta-cobrar.' => [
                    'index'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'create'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'show'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'facturar'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'detalle.create'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'detalle.delete'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'amortizacion.create'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'amortizacion.delete'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                ],
                'devolucion.' => [
                    'index'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'create'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'show'  => ['Administrador', 'Jefe de oficina', 'Vendedor'],
                    'reviewed'  => ['Administrador', 'Tesoreria'],
                ],
                'mantenimiento.caja.' => [
                    'index'  => ['Administrador', 'Jefe de oficina'],
                    'create'  => ['Administrador', 'Jefe de oficina'],
                    'edit'  => ['Administrador', 'Jefe de oficina'],
                    'show'  => ['Administrador', 'Jefe de oficina'],
                    'delete'  => ['Administrador', 'Jefe de oficina'],
                    'cajero.create'  => ['Administrador', 'Jefe de oficina'],
                    'comprobante.create'  => ['Administrador', 'Jefe de oficina'],
                    'comprobante.edit'  => ['Administrador', 'Jefe de oficina'],
                ],
            ],
            'programacion-vuelo' => [
                'index.' => [
                    'index'     => ['Administrador', 'Vendedor'],
                ],
                'vuelo.' => [
                    'index'         => ['Administrador', 'Vendedor'],
                    'show'          => ['Administrador', 'Vendedor'],
                    'create'        => ['Administrador', 'Vendedor'],
                    'edit'          => ['Administrador', 'Vendedor'],
                    'delete'        => ['Administrador', 'Vendedor'],
                    'masivo.index'              => ['Administrador', 'Vendedor'],
                    'masivo.show'               => ['Administrador', 'Vendedor'],
                    'masivo.delete'             => ['Administrador', 'Vendedor'],
                    'programacion.create'       => ['Administrador', 'Vendedor'],
                    'proforma.generate'         => ['Administrador', 'Vendedor'],
                    'monitoreo.create'          => ['Administrador', 'Vendedor'],
                    'pasaje.index'              => ['Administrador', 'Vendedor'],
                    'encomienda.index'          => ['Administrador', 'Vendedor'],
                    'avion.create'              => ['Administrador', 'Vendedor'],
                    'tripulacion.show'          => ['Administrador', 'Vendedor'],
                    'tripulacion.create'        => ['Administrador', 'Vendedor'],
                    'incidencia.avion.create'   => ['Administrador', 'Vendedor'],
                    'incidencia.avion.show'     => ['Administrador', 'Vendedor'],
                    'incidencia.tripulacion.create'=> ['Administrador', 'Vendedor'],
                    'incidencia.tripulacion.show'=> ['Administrador', 'Vendedor'],
                    'incidencia.fecha.create'    => ['Administrador', 'Vendedor'],
                    'incidencia.fecha.show'      => ['Administrador', 'Vendedor'],
                    'incidencia.ruta.create'     => ['Administrador', 'Vendedor'],
                    'incidencia.ruta.show'       => ['Administrador', 'Vendedor'],
                    'preliminar.export'          => ['Administrador', 'Vendedor'],
                    'manifiesto.export'          => ['Administrador', 'Vendedor'],

                    'ruta.index'  => ['Administrador'],
                    'ruta.show'  => ['Administrador'],

                    'comprobantes.index'     => ['Administrador', 'Vendedor'],
                    'comprobantes.download' => ['Administrador', 'Vendedor'],

                    'resumen-comercial' => ['Administrador', 'Vendedor'],
                    'cerrar-vuelo' => ['Administrador', 'Vendedor'],
                    'reabrir-vuelo' => ['Administrador', 'Vendedor'],
                ],
                'vuelo-massive.' => [
                    'index' => ['Administrador', 'Vendedor'],
                    'show'  => ['Administrador', 'Vendedor'],
                    'create'=> ['Administrador', 'Vendedor'],
                    'edit'  => ['Administrador', 'Vendedor'],
                    'delete'=> ['Administrador', 'Vendedor'],
                ],
            ],
            'tracking-carga' => [
                'index.' => [
                    'index'     => ['Administrador', 'Vendedor'],
                ],
                'guia-despacho.' => [
                    'search'        => ['Administrador', 'Vendedor'],
                    'index'         => ['Administrador', 'Vendedor'],
                    'show'          => ['Administrador', 'Vendedor'],
                    'show-importe'  => ['Administrador', 'Vendedor'],
                    'create'        => ['Administrador', 'Vendedor'],
                    'create-free'   => ['Administrador'],
                    'edit'          => ['Administrador', 'Vendedor'],
                    'delete'        => ['Administrador', 'Vendedor'],
                    'print'         => ['Administrador', 'Vendedor'],
                    'save'          => ['Administrador', 'Vendedor'],
                    'tracking.show'      => ['Administrador', 'Vendedor'],
                    'tracking.create'    => ['Administrador', 'Vendedor'],
                    'tracking.delete'    => ['Administrador', 'Vendedor'],
                ]
            ],
            'configuracion' => [
                'index.' => [
                    'index'     => ['Administrador'],
                ],
                'oficina.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'persona.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'tasa-cambio-valor.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'personal.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'tripulacion.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'usuario.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'categoria-vuelo.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'tipo-vuelo.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'tramo.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'ruta.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'tiempo-tramo.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'pasaje-cambio-tarifa.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'tarifa-bulto.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'cuenta-bancaria-referencial.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
            ],
            'mantenimiento' => [
                'index.' => [
                    'index'     => ['Administrador'],
                ],
                'fabricante.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'avion.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'tipo-pista.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'ubicacion.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ],
                'seccion-hero.' => [
                    'index'     => ['Administrador'],
                    'show'      => ['Administrador'],
                    'create'    => ['Administrador'],
                    'edit'      => ['Administrador'],
                    'delete'    => ['Administrador'],
                ]
            ],
        ];
        foreach ($permisos as $modulo => $submodulos) {
            foreach ($submodulos as $permiso => $items) {
                $prefix= "intranet.$modulo.";
                foreach ($items as $item => $roles) {
                    $permiso_name = $prefix.$permiso.$item;
                    $permiso_db = Permission::updateOrCreate(['name' => $permiso_name], ['name' => $permiso_name]);

                    foreach ($roles as $rol) {
                        $role = Role::updateOrCreate(['name' => $rol], ['name' => $rol]);
                        $role->givePermissionTo($permiso_db->id);
                    }
                }
            }
        }
    }
}
