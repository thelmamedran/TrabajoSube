<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);
        $tarjeta = new Tarjeta();
        
        $boletogratuito = new FranquiciaCompleta();
        $tarjeta->cargarSaldo(150);

        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals(-210, $tarjeta->obtenerSaldo());
        $this->assertEquals(210, $tarjeta->obtenerDeuda());
        
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertNull($boleto);

        $tarjeta->cargarSaldo(400);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 400);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(70, $boleto->saldo_restante);
        
        $medioboleto = new FranquiciaParcial();
        $medioboleto->cargarSaldo(150);
        $boleto = $colectivo->pagarCon($medioboleto);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 90);

        $boletogratuito = new FranquiciaCompleta();
        $boletogratuito->cargarSaldo(150);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
    }
}