<?php
namespace TrabajoSube;

class FranquiciaParcial extends Tarjeta {
    public function __construct() {
        $this->id = 0;
        $this->saldo = 0;
        $this->tipo = "Medio";
    }

    public function pagarViaje(float $tarifa){
        $this->actualizarSaldo(-($tarifa/2));
    }
}