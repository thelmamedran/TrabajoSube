<?php
namespace TrabajoSube;

class FranquiciaCompleta extends Tarjeta {
    private int $boletos_disponibles;
    private int $dia_anterior;

    public function __construct() {
        $this->id = rand(1, 10000);
        $this->saldo = 0;
        $this->tipo = "Gratuito";
        $this->saldo_a_favor = 0;
        $this->deuda_plus = 0;
        $this->dia_anterior = 0;
        $this->boletos_disponibles = 2;
    }

    public function tarifaAPagar(float $tarifa): int {
        $dia_actual = (int)date("d");
        
        if ($this->dia_anterior == $dia_actual) {
            if ($this->boletos_disponibles > 0) { 
                $this->boletos_disponibles -= 1;
                return 0;
            }
        } else {
            $this->boletos_disponibles = 1;
            return 0;
        }
        
        return $tarifa;
    }
    
    public function guardarDia($dia) {
        $this->dia_anterior = $dia;
    }
}