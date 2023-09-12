<?php
namespace TrabajoSube;

class FranquiciaCompleta extends Tarjeta {
    public function __construct() {
        $this->id = 0;
        $this->saldo = 0;
        $this->tipo = "Gratuito";
    }
    public function pagarViaje(float $tarifa){
        $this->actualizarSaldo(0);
    }
}