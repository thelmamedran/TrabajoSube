<?php
namespace TrabajoSube;

class FranquiciaCompleta extends Tarjeta {
    private int $boletos_disponibles;

    public function __construct() {
        $this->id = rand(1, 10000);
        $this->saldo = 0;
        $this->tipo = "Gratuito";
        $this->saldo_a_favor = 0;
        $this->deuda_plus = 0;
        $this->boletos_disponibles = 2;

    }

    public function tarifaAPagar(float $tarifa): int {
        if ($this->boletos_disponibles == 0) { 
        return $tarifa;
        } else {
            $this->boletos_disponibles -= 1;
            return 0;
        }
    }

    public function reiniciarBoleto (){
        //validar la franquicia solo según días de semana y hora
    }
}