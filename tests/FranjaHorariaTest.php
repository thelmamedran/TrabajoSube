<?php

use PHPUnit\Framework\TestCase;

class FranjaHorariaTest extends TestCase {
    public function testFranquiciasValidas() {
        $colectivo = new Colectivo(132);

        // Verificar que las franquicias sean válidas en la franja horaria
        $tarjeta = new Tarjeta();
        $this->assertTrue($tarjeta->esHoraValida(new \DateTime('2023-10-09 06:00:00'))); 
        $this->assertTrue($tarjeta->esHoraValida(new \DateTime('2023-10-09 21:59:00'))); 

        // Verificar que las franquicias no sean válidas fuera de la franja horaria
        $this->assertFalse($tarjeta->esHoraValida(new \DateTime('2023-10-09 05:59:00')));  
        $this->assertFalse($tarjeta->esHoraValida(new \DateTime('2023-10-09 22:01:00'))); 

        // Verificar que después de la franja horaria a las franquicias se les cobra la tarifa normal
        $tarjetaParcial = new FranquiciaParcial();
        $tarjetaGratuita = new FranquiciaCompleta();

        // Configurando un tiempo falso para simular el tiempo actual
        $tiempoFalso = strtotime('2023-10-09 23:00:00');  
        $tiempoOriginal = time();
        $this->setTime($tiempoFalso);

        $this->assertEquals($colectivo->obtenerTarifa(), $tarjetaParcial->tarifaAPagar($colectivo->obtenerTarifa()));
        $this->assertEquals($colectivo->obtenerTarifa(), $tarjetaGratuita->tarifaAPagar($colectivo->obtenerTarifa()));
 
        $this->setTime($tiempoOriginal);
    }
}
