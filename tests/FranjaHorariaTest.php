<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class FranjaHorariaTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);

        // Verificar que las franquicias sean válidas en la franja horaria
        $tarjeta = new Tarjeta();
        $fecha = new \DateTime('2023-10-09 06:00:00');
        $this->assertTrue($tarjeta->esHoraValida(date('N', $fecha->getTimestamp()), date('H', $fecha->getTimestamp()))); 
        $fecha = new \DateTime('2023-10-09 21:59:00');
        $this->assertTrue($tarjeta->esHoraValida(date('N', $fecha->getTimestamp()), date('H', $fecha->getTimestamp()))); 

        // Verificar que las franquicias no sean válidas fuera de la franja horaria
        $fecha = new \DateTime('2023-10-09 05:59:00');
        $this->assertFalse($tarjeta->esHoraValida(date('N', $fecha->getTimestamp()), date('H', $fecha->getTimestamp())));  
        $fecha = new \DateTime('2023-10-09 22:01:00');
        $this->assertFalse($tarjeta->esHoraValida(date('N', $fecha->getTimestamp()), date('H', $fecha->getTimestamp())));  

        // Verificar que después de la franja horaria a las franquicias se les cobra la tarifa normal
        $tarjetaParcial = new FranquiciaParcial();
        $tarjetaGratuita = new FranquiciaCompleta();

        // Configurando un tiempo falso para simular el tiempo actual
        $fecha_falsa = new \DateTime('2023-10-09 23:00:00');
        $tarjetaParcial->guardarDiaYHora(date('N', $fecha_falsa->getTimestamp()), date('H', $fecha_falsa->getTimestamp()));
        $tarjetaGratuita->guardarDiaYHora(date('N', $fecha_falsa->getTimestamp()), date('H', $fecha_falsa->getTimestamp()));
        $this->assertEquals($colectivo->obtenerTarifa(), $tarjetaParcial->tarifaAPagar($colectivo->obtenerTarifa()));
        $this->assertEquals($colectivo->obtenerTarifa(), $tarjetaGratuita->tarifaAPagar($colectivo->obtenerTarifa()));
    }
}
