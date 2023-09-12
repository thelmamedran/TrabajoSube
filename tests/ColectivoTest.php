<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo();
        $tarjeta = new Tarjeta();

        $tarjeta->cargarSaldo(150);

        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals(-210, $boleto->saldo_restante);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertNull($boleto);
        
        $this->assertEquals(3670, $boleto->saldo_restante);

    }
}