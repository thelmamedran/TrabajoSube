<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo();
        $tarjeta = new Tarjeta();

        $tarjeta->cargarSaldo(150);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
        
        $tarjeta->cargarSaldo(120);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        $tarjeta->cargarSaldo(6500);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals(30, $boleto->saldo_restante);
        $this->assertTrue($boleto->puede_viajar);
    }
}