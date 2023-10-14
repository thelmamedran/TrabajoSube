<?php

class ColectivoInterurbano extends Colectivo {
    private int $tarifa_interurbana = 184;
    private bool $es_interurbano;

    public function __construct($linea, $es_interurbano = true){
    parent::__construct($linea);
    $this->es_interurbano = $es_interurbano;
    }

    protected function obtenerTarifa(Tarjeta $tarjeta) {
        if ($this->es_interurbano) {
            return $this->tarifa_interurbana;
        } else {
            return parent::obtenerTarifa($tarjeta);
        }
    }
}


