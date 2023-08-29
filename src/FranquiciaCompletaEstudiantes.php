<?php
namespace TrabajoSube;

class FranquiciaCompletaEstudiantes extends FranquiciaCompleta {
    private int $cantBoletos = 2;

    public function pagarViaje(float $tarifa){
        if ($this->$cantBoletos <= 0){
            $this->actualizarSaldo(-$tarifa);
        }
        else{
            $this->actualizarSaldo(0);
            $this->$cantBoletos -= 1;
        }
    }

    public function reiniciarBoleto (){
        //validar la franquicia solo según días de semana y hora
    }
}