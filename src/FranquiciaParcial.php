<?php
namespace TrabajoSube;

class FranquiciaParcial extends Tarjeta {
    private $boletos_disponibles;
    private $minuto_anterior;

    public function __construct() {
        $this->id = rand(1, 10000);
        $this->saldo = 0;
        $this->tipo = "Medio";
        $this->saldo_a_favor = 0;
        $this->deuda_plus = 0;
        $this->minuto_anterior = 0;
        $this->boletos_disponibles = 4;
    }

    public function tarifaAPagar(float $tarifa): int {
        $hora_actual = time()/60;
        if ($hora_actual - $minuto_anterior >= 5) {
            if ($this->boletos_disponibles > 0) { 
                $this->boletos_disponibles -= 1;
                return $tarifa/2;
        } else {
            return $tarifa;
        }
        }else {
            return $tarifa;
        }
    }
}