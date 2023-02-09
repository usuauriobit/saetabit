<?php

namespace App\Http\Livewire\Intranet;

use App\Models\Pasaje;
use Livewire\Component;

class Index extends Component
{
    public $modulos;
    public function mount(){
        $this->modulos = [
            [
                'title' => 'Comercial',
                'route' => route('intranet.comercial.index'),
                'image_path' => asset('img/asset/payment2.jpg'),
                'permission' => 'intranet.comercial.index.index'
            ],
            [
                'title' => 'Tracking de carga',
                'route' => route('intranet.tracking-carga.index'),
                'image_path' => asset('img/asset/paquete.jpg'),
                'permission' => 'intranet.tracking-carga.index'
            ],
            [
                'title' => 'Venta de pasajes',
                'route' => '#',
                'image_path' => asset('img/asset/cart.jpg'),
                'permission' => 'intranet.venta-pasaje.index.index'
            ],
            [
                'title' => 'Facturación electrónica',
                'route' => '#',
                'image_path' => asset('img/asset/payment.jpg'),
                'permission' => 'intranet.facturacion-electronica.index.index'
            ],
            [
                'title' => 'Caja',
                'route' => route('intranet.caja.caja.index'),
                'image_path' => asset('img/asset/payment3.jpg'),
                'permission' => 'intranet.caja.caja.index'
            ],
            [
                'title' => 'Program. de vuelos',
                'route' => route('intranet.programacion-vuelo.vuelo.index'),
                'image_path' => asset('img/asset/message.jpg'),
                'permission' => 'intranet.programacion-vuelo.index'
            ],
            [
                'title' => 'Configuración y Seguridad',
                'route' => route('intranet.configuracion.index'),
                'image_path' => asset('img/asset/security.jpg'),
                'permission' => 'intranet.configuracion.index.index'
            ],
            [
                'title' => 'Mantenimiento',
                'route' => route('intranet.mantenimiento.index'),
                'image_path' => asset('img/asset/list.jpg'),
                'permission' => 'intranet.mantenimiento.index.index'
            ],
        ];
    }
    public function render()
    {
        return view('livewire.intranet.index');
    }


}
