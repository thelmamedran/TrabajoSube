<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CompletaTest extends TestCase {

    public function test() {
        $colectivo = new Colectivo(132);
        $boletogratuito = new FranquiciaCompleta();

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