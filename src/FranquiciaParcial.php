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
        $this->dia_anterior = 0;
        $this->boletos_disponibles = 4;
    }

    public function tarifaAPagar(float $tarifa): int {
        $hora_actual = time() / 60;
        $dia_actual = (int)date("d");
        
        if ($this->dia_anterior == $dia_actual) {
            if (abs($hora_actual - $this->minuto_anterior) >= 5) {
                if ($this->boletos_disponibles > 0) { 
                    $this->boletos_disponibles -= 1;
                    return $tarifa/2;
                }
            } 
        } else {
            $this->boletos_disponibles = 3;
            return $tarifa/2;
        }
        
        return $tarifa;
    }

    public function guardarDia($dia) {
        $this->dia_anterior = $dia;
    }

    public function guardarHora($mins) {
        $this->minuto_anterior = $mins;
    }
}