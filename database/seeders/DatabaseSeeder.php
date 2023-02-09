<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(TipoPasajeSeeder::class);
        $this->call(NacionalidadSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(UbigeoTableSeeder::class);
        $this->call(OficinasSeeder::class);
        $this->call(TipoPistaSeeder::class);
        $this->call(CategoriaVueloSeeder::class);
        $this->call(TipoVueloSeeder::class);
        $this->call(EstadoAvionSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(FabricanteSeeder::class);
        $this->call(TipoMotorSeeder::class);
        $this->call(AvionSeeder::class);
        $this->call(UbicacionSeeder::class);
        $this->call(TramoSeeder::class);
        $this->call(RutaSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(MotivoAnulacionSeeder::class);
        $this->call(TipoTripulacionSeeder::class);
        $this->call(TripulacionSeeder::class);
        $this->call(TarifaSeeder::class);
        $this->call(TipoMovimientoSeeder::class);
        $this->call(TipoDescuentoSeeder::class);
        $this->call(CategoriaDescuentoSeeder::class);
        $this->call(DescuentoClasificacionSeeder::class);
        $this->call(DescuentoSeeder::class);
        $this->call(TipoCajaSeeder::class);
        $this->call(CajaSeeder::class);
        $this->call(TipoBultoSeeder::class);
        $this->call(TarifaBultoSeeder::class);
        $this->call(TipoPasajeCambioSeeder::class);
        $this->call(TipoPagoSeeder::class);
        $this->call(BancoSeeder::class);
        $this->call(OficinaCuentaBancariaSeeder::class);
        $this->call(TarjetaSeeder::class);
        $this->call(DenominacionBilleteSeeder::class);
        $this->call(PasajeCambioTarifaSeeder::class);
        $this->call(MonedaSeeder::class);
        $this->call(TipoComprobanteSeeder::class);
        $this->call(UnidadMedidaSeeder::class);
        $this->call(TipoNotaCreditoSeeder::class);
        $this->call(CuentaBancariaReferenciaSeeder::class);
        $this->call(DevoluicionMotivoSeeder::class);
        $this->call(TiempoAvionTramoSeeder::class);
    }
}
