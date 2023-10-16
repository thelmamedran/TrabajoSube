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
        $this->hora_actual = date('H');
        $this->dia_de_semana_actual = date('N');
        $this->minuto_anterior = 0;
        $this->dia_anterior = 0;
        $this->boletos_disponibles = 4;
    }

    public function tarifaAPagar(float $tarifa): float {
        $hora_actual = (int)date('i');
        $dia_actual = (int)date("d");

        if ($this->esHoraValida($this->dia_de_semana_actual, $this->hora_actual)) {
            if ($this->dia_anterior == $dia_actual) {
                if (abs($hora_actual - $this->minuto_anterior) >= 5) {
                    if ($this->boletos_disponibles > 0) { 
                        $this->boletos_disponibles -= 1;
                        return $tarifa / 2;
                    }
                }
                return $tarifa;
            } else {
                $this->guardarDia($dia_actual);
                $this->guardarMin($hora_actual);
                $this->boletos_disponibles = 3;
                return $tarifa / 2;
            }
        }
        
        return $tarifa;
    }


    public function guardarDia($dia) {
        $this->dia_anterior = $dia;
    }

    public function guardarMin($mins) {
        $this->minuto_anterior = $mins;
    }
}