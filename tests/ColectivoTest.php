<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo();
        $tarjeta = new Tarjeta();

        $this->assertTrue($tarjeta->cargarSaldo(150));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
        
        $this->assertFalse($tarjeta->cargarSaldo(120));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        $this->assertTrue($tarjeta->cargarSaldo(4000));
        $this->assertFalse($tarjeta->cargarSaldo(4000));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 4150);

        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertInstanceOf(Boleto::class, $boleto);
        //$this->assertEquals(4030, $boleto->saldo_restante);
        //$this->assertTrue($boleto->puede_viajar);
    }
}