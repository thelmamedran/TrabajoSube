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
        $saldo_a_favor = $tarjeta->obtenerSaldoAFavor();
        $tarifa = $tarjeta->tarifaAPagar($this->tarifa);
        $saldo_inicial = $tarjeta->obtenerSaldo();
        $deuda_inicial = $tarjeta->obtenerDeuda();

        if ($deuda_inicial == 0 && $saldo_inicial - $tarifa >= $this->limite_inf) {
            $boleto = $this->pagarSinDeuda($tarjeta, $saldo_a_favor, $tarifa, $saldo_inicial);
        } elseif ($saldo_inicial > 0 && $saldo_inicial - $tarifa - $deuda_inicial >= $this->limite_inf) {
            $boleto = $this->pagarConDeudaSuficiente($tarjeta, $tarifa, $deuda_inicial, $saldo_inicial);        
        } elseif ($saldo_inicial - $tarifa >= $this->limite_inf) {
            $boleto = $this->pagarConSaldoSuficiente($tarjeta, $tarifa, $deuda_inicial, $saldo_inicial);
        } else {
            return null;
        }
        
        return $boleto;
    }

    private function pagarSinDeuda($tarjeta, $saldo_a_favor, $tarifa, $saldo_inicial) {
        if ($saldo_a_favor < $tarifa) {
            $tarjeta->actualizarSaldoAFavor(-$saldo_a_favor);
            $tarjeta->pagarViaje($tarifa - $saldo_a_favor);
        } else {
            $tarjeta->actualizarSaldoAFavor(-$tarifa);
        }

        $saldo_restante = $tarjeta->obtenerSaldo();
        if ($saldo_restante < 0) {
            $tarjeta->actualizarDeuda(abs($saldo_restante));
        }
        
        $abono_deuda = "No abona saldo";
        return $this->crearBoleto($tarjeta, $tarifa, $saldo_inicial, $abono_deuda);
    }

    private function pagarConDeudaSuficiente($tarjeta, $tarifa, $deuda_inicial, $saldo_inicial) {
        $tarifa_total = $tarifa + $deuda_inicial;
        $tarjeta->pagarViaje($tarifa_total);
        $tarjeta->reiniciarDeuda();
        $saldo_restante = $tarjeta->obtenerSaldo();
        $abono_deuda = "Abona saldo $deuda_inicial";
        
        $saldo_restante = $tarjeta->obtenerSaldo();
        if ($saldo_restante < 0) {
            $tarjeta->actualizarDeuda(abs($saldo_restante));
        }
        
        return $this->crearBoleto($tarjeta, $tarifa_total, $saldo_inicial, $abono_deuda);
    }
    
    private function pagarConSaldoSuficiente($tarjeta, $tarifa, $deuda_inicial, $saldo_inicial) {
        $tarjeta->pagarViaje($tarifa);
        if ($tarifa > 0) {
            $tarjeta->actualizarDeuda($tarifa);
        }
        $saldo_restante = $tarjeta->obtenerSaldo();
        $abono_deuda = $tarifa === 0 ? 'No abona saldo' : 'Abona saldo ' . $deuda_inicial;
    
        return $this->crearBoleto($tarjeta, $tarifa, $saldo_inicial, $abono_deuda);
    }
 
    private function crearBoleto($tarjeta, $tarifa, $saldo_inicial, $abono_deuda) {
        $id = $tarjeta->obtenerId();
        $tipo = $tarjeta->obtenerTipo();
        $linea = $this->linea;
        $saldo_restante = $tarjeta->obtenerSaldo();

        return new Boleto($saldo_restante, $saldo_inicial, $id, $tipo, $tarifa, $linea, $abono_deuda);
    }
}