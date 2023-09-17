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
        $this->assertEquals(-210, $boleto->saldo_restante);
        
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertNull($boleto);

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