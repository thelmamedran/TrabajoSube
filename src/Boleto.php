<?php
namespace TrabajoSube;

class Boleto {
    public float $saldo_restante;
    public $fecha;
    public $tipo;
    public $saldo_inicial;
    public $linea;
    public $monto;
    public $id;
    public $abono_deuda;

    public function __construct(float $saldo_restante, float $saldo_inicial, int $id, string $tipo, int $monto, int $linea, string $abono_deuda) {
        $this->fecha = time();
        $this->saldo_inicial = $saldo_inicial;
        $this->saldo_restante = $saldo_restante;
        $this->tipo = $tipo;
        $this->linea = $linea;
        $this->monto = $monto;
        $this->id = $id;
        $this->abono_deuda = $abono_deuda;
    }
}