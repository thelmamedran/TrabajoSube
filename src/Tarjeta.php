<?php
namespace TrabajoSube;

class Tarjeta {
    private float $saldo;
    private int $limite_saldo = 6600;
    private array $montos_validos = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);

    public function __construct() {
        $this->saldo = 0;
    }

    public function obtenerSaldo(): float {
        return $this->saldo;
    }

    public function cargarSaldo(float $monto): bool {
        if (in_array($monto, $this->montos_validos)) {
            if ($this->saldo + $monto <= $this->limite_saldo) {
                $this->actualizarSaldo($monto);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function actualizarSaldo(float $monto) {
        $this->saldo += $monto;
    }
}