<?php
namespace TrabajoSube;

class Colectivo {
      
    public function __construct() {
    }
      
    public function pagarCon($tarjeta): Boleto {
        $saldo = $tarjeta->get_saldo();
        if ($saldo >= 120) {
            $tarjeta->actualizar_saldo(-120);
            $saldo = $tarjeta->get_saldo();
            $boleto = new Boleto($saldo, true);
            return $boleto;
        } 
        else {
            $boleto = new Boleto($saldo, false);
            return $boleto;
        }
    }
}
