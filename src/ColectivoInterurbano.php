<?php

namespace TrabajoSube;

class ColectivoInterurbano extends Colectivo {
    private int $tarifa_interurbana = 184;

    public function obtenerTarifa(): int {
        return $this->tarifa_interurbana;
    }
}
