<?php

namespace TrabajoSube;

class Colectivo {
    private int $tarifa = 120;
    private int $linea;
    private float $limite_inf = -211.84;
    
    public function __construct($linea){
        $this->linea = $linea;
    }

    public function pagarCon(Tarjeta $tarjeta): Boleto {

        $saldo_inicial = $tarjeta->obtenerSaldo();
        $deuda_inicial = $tarjeta->obtenerDeuda();
        $id = $tarjeta->obtenerId();
        $tipo = $tarjeta->obtenerTipo();

        $saldo_suficiente = $saldo_inicial - this->tarifa >= $this->limite_inf;
        $saldo_con_deuda_suficiente = $saldo_inicial - $this->tarifa - $deuda_inicial >= $this->limite_inf;


        if ($saldo_con_deuda_suficiente) {
            $tarifa_total = $this->tarifa + $deuda_inicial;
            $tarjeta->pagarViaje($tarifa_total);
            $tarjeta->reiniciarDeuda();
            $saldo_restante = $tarjeta->obtenerSaldo();
        }
        elseif ($saldo_suficiente) {
            $tarjeta->pagarViaje($this->tarifa);
            $tarjeta->actualizarDeuda($this->tarifa);
            $saldo_restante = $tarjeta->obtenerSaldo();
        } else {
            return null;
        }
        $boleto = new Boleto($saldo_restante, $saldo_inicial, $id, $tipo, $tarifa_total ?? $this->tarifa, $this->linea);
        return $boleto;
    }         

    public function obtenerLinea(): int {
        return $this->linea;
    }
}