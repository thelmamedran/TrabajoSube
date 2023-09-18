<?php
namespace TrabajoSube;

class FranquiciaParcial extends Tarjeta {
    private $boletos_disponibles;

    public function __construct() {
        $this->id = rand(1, 10000);
        $this->saldo = 0;
        $this->tipo = "Medio";
        $this->deuda_plus = 0;
        $this->boletos_disponibles = 4;
    }

    public function tarifaAPagar(float $tarifa): int {
        if ($this->boletos_disponibles == 0) { 
        return $tarifa;
        } else {
            $this->boletos_disponibles -= 1;
            return $tarifa/2;
        }
    }
}