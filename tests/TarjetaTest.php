<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);
        $tarjeta = new Tarjeta();

        // Cargar monto válido y verificar que se cargue
        $this->assertTrue($tarjeta->cargarSaldo(150));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
        
        // Cargar monto inválido y verificar que no se cargue
        $this->assertFalse($tarjeta->cargarSaldo(120));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Verificar que se puede pagar sin tener saldo suficiente y funciona el negativo
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(-210, $tarjeta->obtenerSaldo());
        $this->assertEquals(210, $tarjeta->obtenerDeuda());

        // Verificar que se actualice la deuda al viajar de nuevo
        $tarjeta->cargarSaldo(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->obtenerDeuda(), 30);
        $this->assertEquals(-30, $tarjeta->obtenerSaldo());

        // Verificar que se pague la deuda al viajar de nuevo
        $tarjeta->cargarSaldo(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Exceder el límite de la tarjeta y verificar que se guarde para acreditar
        $tarjeta->cargarSaldo(4000);
        $this->assertTrue($tarjeta->cargarSaldo(4000));
        $nuevo_saldo = $tarjeta->obtenerSaldoAFavor();
        $this->assertEquals($nuevo_saldo, 1550);
        $colectivo->pagarCon($tarjeta);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 6600);
    }
}