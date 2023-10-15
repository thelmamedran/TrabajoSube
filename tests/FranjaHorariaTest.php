<?php

use PHPUnit\Framework\TestCase;

class FranjaHorariaTest extends TestCase {
    public function testFranquiciasValidas() {
        $colectivo = new Colectivo(132);

        // Verificamos que las franquicias sean válidas de lunes a viernes de 6 a 22
        $this->assertTrue($colectivo->esHoraValida(new \DateTime('2023-10-09 06:00:00'))); // Lunes a las 6:00 AM
        $this->assertTrue($colectivo->esHoraValida(new \DateTime('2023-10-09 21:59:00'))); // Lunes a las 9:59 PM

        // Verificamos que las franquicias no sean válidas fuera de la franja horaria
        $this->assertFalse($colectivo->esHoraValida(new \DateTime('2023-10-09 05:59:00'))); // Lunes a las 5:59 AM
        $this->assertFalse($colectivo->esHoraValida(new \DateTime('2023-10-09 22:01:00'))); // Lunes a las 10:01 PM

        // Verificar que después de la franja horaria a los gratuitos y parciales se les cobra la tarifa normal
        $colectivoInterurbano = new ColectivoInterurbano(132);
        $tarjetaParcial = new FranquiciaParcial();
        $tarjetaGratuita = new FranquiciaCompleta();

        $this->assertEquals($colectivoInterurbano->obtenerTarifa(), $tarjetaParcial->tarifaAPagar($colectivoInterurbano->obtenerTarifa()));
        $this->assertEquals($colectivoInterurbano->obtenerTarifa(), $tarjetaGratuita->tarifaAPagar($colectivoInterurbano->obtenerTarifa()));
    }
}
