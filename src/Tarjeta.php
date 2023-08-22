<?php
namespace TrabajoSube;
class Tarjeta{
    private $saldo;

    public function __construct($saldo) {
        $this->saldo = $saldo;
    }

    public function get_saldo() {
        return $this->saldo;
    }
    
    public function cargar($monto) {
        $montos_validos = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);
        
        if (in_array($monto, $montos_validos)) {
            if ($this->saldo + $monto <= 6600) {
            $this->actualizar_saldo($monto);
            return true;
            } else {
                return false;
            } 
        } else {
            return false;
        }
    }

    public function actualizar_saldo($monto) {
        $this->saldo += $monto;
    }
}