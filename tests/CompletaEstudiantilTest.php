<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CompletaEstudiantilTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);
        $boletogratuito = new FranquiciaCompletaEstudiantil();

        // Cargar monto válido y verificar que se cargue
        $this->assertTrue($boletogratuito->cargarSaldo(150));
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
    
        // Cargar monto inválido y verificar que no se cargue
        $this->assertFalse($boletogratuito->cargarSaldo(120));
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Verificar que se no se cobre
        $colectivo->pagarCon($boletogratuito);
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Verificar que se puede pagar sin tener saldo suficiente y funciona el negativo
        $boleto = $colectivo->pagarCon($boletogratuito);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $this->assertEquals(-210, $boletogratuito->obtenerSaldo());
        $this->assertEquals(210, $boletogratuito->obtenerDeuda());

        // Verificar que se actualice la deuda al viajar de nuevo
        $boletogratuito->cargarSaldo(300);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $this->assertEquals($boletogratuito->obtenerDeuda(), 30);
        $this->assertEquals(-30, $boletogratuito->obtenerSaldo());

        // Verificar que se pague la deuda al viajar de nuevo
        $boletogratuito->cargarSaldo(300);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Exceder el límite de la tarjeta y verificar que se guarde para acreditar
        $boletogratuito->cargarSaldo(4000);
        $this->assertTrue($boletogratuito->cargarSaldo(4000));
        $nuevo_saldo = $boletogratuito->obtenerSaldoAFavor();
        $this->assertEquals($nuevo_saldo, 1550);
        $colectivo->pagarCon($boletogratuito);
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 6600);

        // Verificar en el mismo dia solo hay 2 gratuitos
        $boletogratuito2 = new FranquiciaCompletaEstudiantil();
        $boletogratuito2->cargarSaldo(300);
        $colectivo->pagarCon($boletogratuito2);
        $colectivo->pagarCon($boletogratuito2);
        $colectivo->pagarCon($boletogratuito2);
        $nuevo_saldo = $boletogratuito2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 180);

        // Verificar cuando se cambia de dia se reinicia el gratuito
        $dia_adelantado = (int)date('d')+1;
        $boletogratuito2->guardarDia($dia_adelantado);
        $colectivo->pagarCon($boletogratuito2);
        $nuevo_saldo = $boletogratuito2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 180);
    }
}