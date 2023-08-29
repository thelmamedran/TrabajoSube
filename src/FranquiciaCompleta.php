<?php
namespace TrabajoSube;

class FranquiciaCompleta extends Tarjeta {
    public function pagarViaje(float $tarifa){
        $this->actualizarSaldo(0);
    }
}