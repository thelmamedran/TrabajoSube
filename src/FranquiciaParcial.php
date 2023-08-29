<?php
namespace TrabajoSube;

class FranquiciaParcial extends Tarjeta {
    public function pagarViaje(float $tarifa){
        $this->actualizarSaldo(-($tarifa/2));
    }
}