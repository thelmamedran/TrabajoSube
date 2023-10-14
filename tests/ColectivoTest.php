<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132, false);

        $tarjeta = new Tarjeta();
        $tarjeta->cargarSaldo(150);

        // Pagar viaje y verificar que devuelva un boleto
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);

        // Verificar que sin boletos disponibles no se puede viajar
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertNull($boleto);

        // Verificar que sin boletos disponibles no se puede viajar
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