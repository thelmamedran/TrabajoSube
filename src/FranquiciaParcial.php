<?php
namespace TrabajoSube;

class FranquiciaParcial extends Tarjeta {
    public function __construct() {
        $this->id = rand(1, 10000);
        $this->saldo = 0;
        $this->tipo = "Medio";
        $this->deuda_plus = 0;
    }

    public function tarifaAPagar(float $tarifa): int {
        return $tarifa/2;
    }
}