<?php
namespace TrabajoSube;

class Tarjeta {
    protected float $saldo;
    protected int $limite_saldo = 6600;
    protected int $saldo_a_favor;
    protected int $id;
    protected string $tipo;
    protected float $deuda_plus;
    protected array $montos_validos = array(150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000);

    public function __construct() {
        $this->saldo_a_favor = 0;
        $this->id = rand(1, 10000);
        $this->saldo = 0;
        $this->tipo = "Normal";
        $this->deuda_plus = 0;
    }

    public function obtenerSaldo(): float {
        return $this->saldo;
    }

    public function obtenerId(): float {
        return $this->id;
    }

    public function actualizarDeuda($deuda) {
        $this->deuda_plus += $deuda;
    }

    public function reiniciarDeuda() {
        $this->deuda_plus = 0;
    }

    public function obtenerDeuda(): float {
        return $this->deuda_plus;
    }

    public function obtenerTipo(): string {
        return $this->tipo;
    }

    public function obtenerSaldoAFavor(): int {
        return $this->saldo_a_favor;
    }

    public function actualizarSaldoAFavor($monto) {
        $this->saldo_a_favor += $monto;
    }

    public function cargarSaldo(float $monto): bool {
        $saldo_anterior = $this->saldo;

        if (in_array($monto, $this->montos_validos)) {
            if ($saldo_anterior + $monto <= $this->limite_saldo) {
                $this->actualizarSaldo($monto + $this->deuda_plus);
            } else {
                $saldo_a_favor = $saldo_anterior + $monto - $limite_saldo;
                $this->actualizarSaldo($monto - $saldo_a_favor);
            }
        } 

        return $saldo_anterior != $this->saldo;
    }

    public function actualizarSaldo(float $monto) {
        $this->saldo += $monto;
    }

    public function pagarViaje(float $tarifa): int {
        $this->actualizarSaldo(-$tarifa);
        return $tarifa;
    }

    public function tarifaAPagar(float $tarifa): int {
        return $tarifa;
    }

    public function guardarHora($mins) {

    }

    public function guardarDia($dia) {

    }
}