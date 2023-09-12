<?php
namespace TrabajoSube;

class Boleto {
    public float $saldo_restante;
    private $fecha;
    private $tipo;
    private $saldo_inicial;
    private $linea;
    private $monto;
    private $id;

    public function __construct(float $saldo_restante, float $saldo_inicial, int $id, string $tipo, int $monto, int $linea) {
        $this->fecha = time();
        $this->saldo_inicial = $saldo_inicial;
        $this->saldo_restante = $saldo_restante;
        $this->tipo = $tipo;
        $this->linea = $linea;
        $this->monto = $monto;
        $this->id = $id;
    }
}