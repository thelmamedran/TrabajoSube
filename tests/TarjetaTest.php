<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
    public function test() {
        $tarjeta = new Tarjeta();

        $this->assertTrue($tarjeta->cargarSaldo(150));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
        
        $this->assertFalse($tarjeta->cargarSaldo(120));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        $this->assertTrue($tarjeta->cargarSaldo(4000));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 3790);
    }
}