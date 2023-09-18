<?php

namespace TrabajoSube;

class Colectivo {
    private int $tarifa = 120;
    private int $linea;
    private float $limite_inf = -211.84;
    
    public function __construct($linea){
        $this->linea = $linea;
    }

    public function pagarCon(Tarjeta $tarjeta) {
        $tarifa = $tarjeta->tarifaAPagar($this->tarifa);
        $saldo_inicial = $tarjeta->obtenerSaldo();
        $deuda_inicial = $tarjeta->obtenerDeuda();
        $id = $tarjeta->obtenerId();
        $tipo = $tarjeta->obtenerTipo();

        $saldo_suficiente = $saldo_inicial - $tarifa >= $this->limite_inf;
        $saldo_con_deuda_suficiente = $saldo_inicial - $tarifa - $deuda_inicial >= $this->limite_inf;

        if ($deuda_inicial == 0) {
            $tarjeta->pagarViaje($tarifa);
            $saldo_restante = $tarjeta->obtenerSaldo();
            if ($saldo_restante < 0) {
                $tarjeta->actualizarDeuda(abs($saldo_restante));
            }
            $abono_deuda = "No abona saldo";
            $boleto = new Boleto($saldo_restante, $saldo_inicial, $id, $tipo, $tarifa, $this->linea, $abono_deuda);
        }  elseif ($saldo_con_deuda_suficiente) {
                $tarifa_total = $tarifa + $deuda_inicial;
                $tarjeta->pagarViaje($tarifa_total);
                $tarjeta->reiniciarDeuda();
                $saldo_restante = $tarjeta->obtenerSaldo();
                if ($deuda_inicial != 0) {
                    $abono_deuda = "Abona saldo $deuda_inicial";
                } else {
                    $abono_deuda = "No abona saldo";
                }
            }
            elseif ($saldo_suficiente) {
                $tarjeta->pagarViaje($tarifa);
                $tarjeta->actualizarDeuda($tarifa);
                $saldo_restante = $tarjeta->obtenerSaldo();
                $abono_deuda = "No abona saldo";
            } else {
                return null;
            }
            $boleto = new Boleto($saldo_restante, $saldo_inicial, $id, $tipo, $tarifa_total ?? $tarifa, $this->linea, $abono_deuda);
            return $boleto;
        }         
}