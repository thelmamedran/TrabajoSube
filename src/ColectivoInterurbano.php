<?php

class ColectivoInterurbano extends Colectivo {
    private int $tarifa_interurbana = 184;

    public function __construct($linea){
        parent::__construct($linea);
    }

    public function pagarCon(Tarjeta $tarjeta) {
        $saldo_a_favor = $tarjeta->obtenerSaldoAFavor();
        $tarifa = $this->tarifa_interurbana;
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
}