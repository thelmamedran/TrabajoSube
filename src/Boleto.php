<?php
namespace TrabajoSube;
class Boleto {
    public $saldo_restante;
    public $pudo_viajar; 

    public function __construct($saldo_restante, $pudo_viajar) {
        $this->saldo_restante = $saldo_restante;
        $this->pudo_viajar = $pudo_viajar;
    }
}

