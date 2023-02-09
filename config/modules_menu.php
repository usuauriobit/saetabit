<?php
return [
    'intranet.mantenimiento*' => [
        'modulo' => 'Mantenimiento',
        'type_header'   => 'vertical',
        'menu'   => [
            [
                'icon' => '<i class="la la-plane" ></i>',
                'label' => 'Fabricante',
                'route_name' => 'intranet.mantenimiento.fabricante.index',
                'route_is' => 'intranet.mantenimiento.fabricante*',
                'permission' => 'intranet.mantenimiento.fabricante.index',
            ],
            [
                'icon' => '<i class="la la-plane" ></i>',
                'label' => 'Avión',
                'route_name' => 'intranet.mantenimiento.avion.index',
                'route_is' => 'intranet.mantenimiento.avion*',
                'permission' => 'intranet.mantenimiento.fabricante.index',
            ],
            [
                'icon' => '<i class="la la-plane" ></i>',
                'label' => 'Tipo de pista',
                'route_name' => 'intranet.mantenimiento.tipo_pista.index',
                'route_is' => 'intranet.mantenimiento.tipo_pista*',
                'permission' => 'intranet.mantenimiento.fabricante.index',
            ],
            [
                'icon' => '<i class="la la-plane" ></i>',
                'label' => 'Ubicación',
                'route_name' => 'intranet.mantenimiento.ubicacion.index',
                'route_is' => 'intranet.mantenimiento.ubicacion*',
                'permission' => 'intranet.mantenimiento.fabricante.index',
            ],
            [
                'navhead' => 'Landing page'
            ],
            [
                'icon' => '<i class="la la-plane" ></i>',
                'label' => 'Sección hero',
                'route_name' => 'intranet.mantenimiento.landing-page.seccion-hero.index',
                'route_is' => 'intranet.mantenimiento.landing-page.seccion-hero*',
                'permission' => 'intranet.mantenimiento.fabricante.index',
            ],
        ]
    ],
    'intranet.caja*' => [
        'modulo' => 'Caja',
        'type_header'   => 'vertical',
        'menu'   => [
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Caja',
                'route_name'    => 'intranet.caja.caja.index',
                'route_is'     => 'intranet.caja.caja.*',
                'permission'    => 'intranet.caja.caja.index'
            ],
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Aperturas',
                'route_name'    => 'intranet.caja.caja-apertura-cierre.index',
                'route_is'     => 'intranet.caja.caja-apertura-cierre.*',
                'permission'    => 'intranet.caja.caja-apertura-cierre.index'
            ],
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Extornos',
                'route_name'    => 'intranet.caja.extorno.index',
                'route_is'     => 'intranet.caja.extorno*',
                'permission'    => 'intranet.caja.extorno.index'
            ],
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Ventas',
                'route_name'    => 'intranet.caja.venta.index',
                'route_is'     => 'intranet.caja.venta*',
                'permission'    => 'intranet.caja.venta.index'
            ],
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Comprobantes',
                'route_name'    => 'intranet.caja.comprobante.index',
                'route_is'     => 'intranet.caja.comprobante*',
                'permission'    => 'intranet.caja.comprobante.index'
            ],
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Cuentas por Cobrar',
                'route_name'    => 'intranet.caja.cuenta-cobrar.index',
                'route_is'     => 'intranet.caja.cuenta-cobrar*',
                'permission'    => 'intranet.caja.cuenta-cobrar.index'
            ],
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Devoluciones',
                'route_name'    => 'intranet.caja.devolucion.index',
                'route_is'     => 'intranet.caja.devolucion*',
                'permission'    => 'intranet.caja.devolucion.index'
            ],
            [
                'navhead' => 'Mantenimiento'
            ],
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Caja',
                'route_name'    => 'intranet.caja.mantenimiento.caja.index',
                'route_is'     => 'intranet.caja.nantenimiento.caja*',
                'permission'    => 'intranet.caja.mantenimiento.caja.index'
            ],
        ]
    ],
    'intranet.comercial*' => [
        'modulo' => 'Comercial',
        'type_header'   => 'vertical',
        'menu'   => [
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Tarifas',
                'route_name'    => 'intranet.comercial.tarifa.index',
                'route_is'      => 'intranet.comercial.tarifa*',
                'permission'    => 'intranet.comercial.tarifa.index'
            ],
            [
                'icon'          => '<i class="las la-percent"></i>',
                'label'         => 'Descuentos',
                'route_name'    => 'intranet.comercial.descuento.index',
                'route_is'     => 'intranet.comercial.descuento*',
                'permission'    => 'intranet.comercial.descuento.index'
            ],
            [
                'navhead' => 'Operaciones'
            ],

            [
                'icon'          => '<i class="las la-search"></i>',
                'label'         => 'Búsqueda de pasajes',
                'route_name'    => 'intranet.comercial.pasaje.search',
                'route_is'      => 'intranet.comercial.pasaje.search*',
                'permission'    => 'intranet.comercial.pasaje.index'
            ],
            [
                'icon'          => '<i class="las la-credit-card"></i>',
                'label'         => 'Adquisición de pasajes',
                'route_name'    => 'intranet.comercial.adquisicion-pasaje.index',
                'route_is'     => 'intranet.comercial.adquisicion-pasaje.index*',
                'permission'    => 'intranet.comercial.pasaje.index'
            ],
            // [
            //     'icon'          => '<i class="las la-paste"></i>',
            //     'label'         => 'Créditos de vuelos',
            //     'route_name'    => 'intranet.comercial.vuelo-credito.index',
            //     'route_is'     => 'intranet.comercial.vuelo-credito.index*',
            //     'permission'    => 'intranet.comercial.vuelo-credito.index'
            // ],
            [
                'navhead' => 'Otros'
            ],
            [
                'icon'          => '<i class="las la-users"></i>',
                'label'         => 'Relación de clientes',
                'route_name'    => 'intranet.comercial.cliente.index',
                'route_is'     => 'intranet.comercial.cliente.index*',
                'permission'    => 'intranet.comercial.cliente.index'
            ],
            [
                'icon'          => '<i class="las la-credit-card"></i>',
                'label'         => 'Cambios de pasaje',
                'route_name'    => 'intranet.comercial.pasaje-cambio.index',
                'route_is'     => 'intranet.comercial.pasaje-cambio.index*',
                'permission'    => 'intranet.comercial.pasaje-cambio.index'
            ],
            [
                'icon'          => '<i class="las la-credit-card"></i>',
                'label'         => 'Pasajes abiertos',
                'route_name'    => 'intranet.comercial.pasaje-abierto.index',
                'route_is'     => 'intranet.comercial.pasaje-abierto.index*',
                'permission'    => 'intranet.comercial.pasaje-abierto.index'
            ],
        ]
    ],
    'intranet.programacion-vuelo*' => [
        'modulo' => 'Programación de vuelos',
        'type_header'   => 'vertical',
        'menu'   => [
            [
                'icon'          => '<i class="las la-plane"></i>',
                'label'         => 'Registro de vuelos',
                'route_name'    => 'intranet.programacion-vuelo.vuelo.create',
                'route_is'     => 'intranet.programacion-vuelo.vuelo.create.*',
                'permission'    => 'intranet.programacion-vuelo.vuelo.create'
            ],
            [
                'navhead' => 'Comercial'
            ],
            [
                'icon'          => '<i class="las la-list"></i>',
                'label'         => 'Resumen',
                'route_name'    => 'intranet.programacion-vuelo.vuelo.resumen-comercial',
                'route_is'     => 'intranet.programacion-vuelo.vuelo.resumen-comercial.*',
                'permission'    => 'intranet.programacion-vuelo.vuelo.resumen-comercial'
            ],
            [
                'navhead' => 'Consulta'
            ],
            [
                'icon'          => '<i class="las la-search"></i>',
                'label'         => 'Consultar vuelo por cod',
                'route_name'    => 'intranet.programacion-vuelo.vuelo.search',
                'route_is'     => 'intranet.programacion-vuelo.vuelo.search.*',
                'permission'    => 'intranet.programacion-vuelo.vuelo.index'
            ],
            [
                'icon'          => '<i class="las la-plane"></i>',
                'label'         => 'Agenda de vuelos',
                'route_name'    => 'intranet.programacion-vuelo.vuelo.index',
                'route_is'     => 'intranet.programacion-vuelo.vuelo.index.*',
                'permission'    => 'intranet.programacion-vuelo.vuelo.index'
            ],
            [
                'icon'          => '<i class="las la-route"></i>',
                'label'         => 'Vuelos por ruta',
                'route_name'    => 'intranet.programacion-vuelo.vuelo-ruta.index',
                'route_is'     => 'intranet.programacion-vuelo.vuelo-ruta.index*',
                'permission'    => 'intranet.programacion-vuelo.vuelo.index'
            ],
            [
                'icon'          => '<i class="las la-plane-departure"></i>',
                'label'         => 'Historial de registros masivos',
                'route_name'    => 'intranet.programacion-vuelo.vuelo-massive.index',
                'route_is'     => 'intranet.programacion-vuelo.vuelo-massive.index*',
                'permission'    => 'intranet.programacion-vuelo.vuelo.masivo.index'
            ],
        ]
    ],
    'intranet.configuracion*' => [
        'modulo' => 'Configuración y seguridad',
        'type_header'   => 'vertical',
        'menu'   => [
            [
                'navhead' => 'General'
            ],
            [
                'icon'          => '<i class="las la-building"></i>',
                'label'         => 'Oficinas',
                'route_name'    => 'intranet.configuracion.oficina.index',
                'route_is'      => 'intranet.configuracion.oficina*',
                'permission'    => 'intranet.configuracion.oficina.index'
            ],
            [
                'icon'          => '<i class="las la-credit-card"></i>',
                'label'         => 'Cuentas bancarias referenciales',
                'route_name'    => 'intranet.configuracion.cuenta-bancaria-referencial.index',
                'route_is'      => 'intranet.configuracion.cuenta-bancaria-referencial*',
                'permission'    => 'intranet.configuracion.cuenta-bancaria-referencial.index'
            ],
            [
                'icon'          => '<i class="las la-dollar-sign"></i>',
                'label'         => 'Tasa de cambio',
                'route_name'    => 'intranet.configuracion.tasa-cambio-valor.index',
                'route_is'      => 'intranet.configuracion.tasa-cambio-valor*',
                'permission'    => 'intranet.configuracion.tasa-cambio-valor.index'
            ],
            [
                'navhead' => 'Tarifas'
            ],
            [
                'icon'          => '<i class="las la-building"></i>',
                'label'         => 'Pasaje - Cambios y liberaciones',
                'route_name'    => 'intranet.configuracion.pasaje_cambio_tarifa.index',
                'route_is'      => 'intranet.configuracion.pasaje_cambio_tarifa*',
                'permission'    => 'intranet.configuracion.pasaje-cambio-tarifa.index'
            ],
            [
                'icon'          => '<i class="las la-building"></i>',
                'label'         => 'Equipajes y mascotas',
                'route_name'    => 'intranet.configuracion.tarifa_bulto.index',
                'route_is'      => 'intranet.configuracion.tarifa_bulto*',
                'permission'    => 'intranet.configuracion.tarifa-bulto.index'
            ],
            [
                'navhead' => 'Persona'
            ],
            [
                'icon'          => '<i class="las la-users"></i>',
                'label'         => 'Persona',
                'route_name'    => 'intranet.configuracion.persona.index',
                'route_is'      => 'intranet.configuracion.persona.*',
                'permission'    => 'intranet.configuracion.persona.index'
            ],
            [
                'icon'          => '<i class="las la-users"></i>',
                'label'         => 'Personal',
                'route_name'    => 'intranet.configuracion.personal.index',
                'route_is'      => 'intranet.configuracion.personal.*',
                'permission'    => 'intranet.configuracion.personal.index'
            ],
            [
                'icon'          => '<i class="las la-users"></i>',
                'label'         => 'Tripulación',
                'route_name'    => 'intranet.configuracion.tripulacion.index',
                'route_is'      => 'intranet.configuracion.tripulacion.*',
                'permission'    => 'intranet.configuracion.tripulacion.index'
            ],
            [
                'icon'          => '<i class="las la-users"></i>',
                'label'         => 'Usuarios',
                'route_name'    => 'intranet.configuracion.user.index',
                'route_is'      => 'intranet.configuracion.user*',
                'permission'    => 'intranet.configuracion.user.index'
            ],
            [
                'navhead' => 'Sobre vuelo'
            ],
            [
                'icon'          => '<i class="las la-images"></i>',
                'label'         => 'Categoría de vuelo',
                'route_name'    => 'intranet.configuracion.categoria_vuelo.index',
                'route_is'      => 'intranet.configuracion.categoria_vuelo*',
                'permission'    => 'intranet.configuracion.categoria-vuelo.index'
            ],
            [
                'icon'          => '<i class="las la-images"></i>',
                'label'         => 'Tipo de vuelo',
                'route_name'    => 'intranet.configuracion.tipo_vuelo.index',
                'route_is'      => 'intranet.configuracion.tipo_vuelo*',
                'permission'    => 'intranet.configuracion.tipo-vuelo.index'
            ],
            [
                'icon'          => '<i class="las la-road"></i>',
                'label'         => 'Tramos',
                'route_name'    => 'intranet.configuracion.tramo.index',
                'route_is'      => 'intranet.configuracion.tramo*',
                'permission'    => 'intranet.configuracion.tramo.index'
            ],
            [
                'icon'          => '<i class="las la-layer-group"></i>',
                'label'         => 'Ruta',
                'route_name'    => 'intranet.configuracion.ruta.index',
                'route_is'      => 'intranet.configuracion.ruta*',
                'permission'    => 'intranet.configuracion.ruta.index'
            ],
            [
                'icon'          => '<i class="las la-history"></i>',
                'label'         => 'Tiempo tramo - Avión',
                'route_name'    => 'intranet.configuracion.tiempo_tramo.index',
                'route_is'      => 'intranet.configuracion.tiempo_tramo*',
                'permission'    => 'intranet.configuracion.tiempo-tramo.index'
            ],

        ]
    ],
    'intranet.tracking-carga*' => [
        'modulo' => 'Tracking de carga',
        'type_header'   => 'vertical',
        'menu'   => [
            [
                'navhead' => 'General'
            ],
            [
                'icon'          => '<i class="las la-box"></i>',
                'label'         => 'Home',
                'route_name'    => 'intranet.tracking-carga.index',
                'route_is'      => 'intranet.tracking-carga.index*',
                'permission'    => 'intranet.tracking-carga.guia-despacho.search'
            ],
            [
                'icon'          => '<i class="las la-box"></i>',
                'label'         => 'Historial',
                'route_name'    => 'intranet.tracking-carga.guia-despacho.index',
                'route_is'      => 'intranet.tracking-carga.guia-despacho*',
                'permission'    => 'intranet.tracking-carga.guia-despacho.index'
            ]
        ]
    ]
];

?>
