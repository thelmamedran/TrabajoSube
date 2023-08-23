<?php
namespace TrabajoSube;

class Boleto {
    public float $saldo_restante;
    public bool $puede_viajar;

    public function __construct(float $saldo_restante, bool $puede_viajar) {
        $this->saldo_restante = $saldo_restante;
        $this->puede_viajar = $puede_viajar;
    }
}