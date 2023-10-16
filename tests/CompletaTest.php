<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class CompletaTest extends TestCase {

    public function test() {
        $colectivo = new Colectivo(132);
        $boletogratuito = new FranquiciaCompleta();
        $fecha_falsa = new \DateTime('2023-10-09 06:00:00');
        $boletogratuito->guardarDiaYHora(date('N', $fecha_falsa->getTimestamp()), date('H', $fecha_falsa->getTimestamp()));
        // Cargar monto válido y verificar que se cargue
        $this->assertTrue($boletogratuito->cargarSaldo(150));
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
    
        // Cargar monto inválido y verificar que no se cargue
        $this->assertFalse($boletogratuito->cargarSaldo(120));
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Verificar que se no se cobre nunca
        for ($i = 0; $i < 100; $i++) 
            $colectivo->pagarCon($boletogratuito);

        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);  
    }
}