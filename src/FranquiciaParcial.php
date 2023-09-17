<?php
namespace TrabajoSube;

class FranquiciaParcial extends Tarjeta {
    public function __construct() {
        $this->id = 0;
        $this->saldo = 0;
        $this->tipo = "Medio";
        $this->deuda_plus = 0;
    }

    public function pagarViaje(float $tarifa){
        $this->actualizarSaldo(-($tarifa/2));
    }
}