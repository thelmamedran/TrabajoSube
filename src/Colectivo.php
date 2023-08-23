<?php
namespace TrabajoSube;

class Colectivo {
    private int $tarifa = 120;
    
    public function __construct() {
    }

    public function pagarCon(Tarjeta $tarjeta): Boleto {
        $saldo = $tarjeta->obtenerSaldo();
        
        if ($saldo >= $this->tarifa) {
            $tarjeta->actualizarSaldo(-$this->tarifa);
            $saldo = $tarjeta->obtenerSaldo();
            $boleto = new Boleto($saldo, true);
        } else {
            $boleto = new Boleto($saldo, false);
        }
    
        return $boleto;
    }    
}