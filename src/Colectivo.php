<?php

namespace TrabajoSube;

class Colectivo {
    private int $tarifa = 120;
    private float $limite_inf = -211.84;
    
    public function __construct() {
    }

    public function pagarCon(Tarjeta $tarjeta): Boleto {
        $saldo = $tarjeta->obtenerSaldo();
        
        if ($saldo - $this->tarifa <= $this->limite_inf) {
            $tarjeta->pagarViaje($this->tarifa);
            $saldo = $tarjeta->obtenerSaldo();
            $boleto = new Boleto($saldo, true);
        } else {
            $boleto = new Boleto($saldo, false);
        }
    
        return $boleto;
    }    
}