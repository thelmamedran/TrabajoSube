<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CompletaEstudiantilTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);
        $boletogratuito = new FranquiciaCompletaEstudiantil();
        $tarifa = 120;
        $tarifa_estudiantil = 0;

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
        $saldo_anterior = $boletogratuito->obtenerSaldo();
        $boleto = $colectivo->pagarCon($boletogratuito);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $this->assertEquals($saldo_anterior - ($tarifa * 3), $boletogratuito->obtenerSaldo());
        $this->assertEquals(-($saldo_anterior - ($tarifa * 3)), $boletogratuito->obtenerDeuda());

        // Verificar que se actualice la deuda al viajar de nuevo
        $boletogratuito->cargarSaldo(300);
        $deuda_anterior = $boletogratuito->obtenerDeuda();
        $saldo_anterior = $boletogratuito->obtenerSaldo();
        $boleto = $colectivo->pagarCon($boletogratuito);
        $deuda = $boletogratuito->obtenerDeuda();
        $this->assertEquals($deuda, 30);
        $this->assertEquals($saldo_anterior - $deuda_anterior - $tarifa, $boletogratuito->obtenerSaldo());

        // Verificar que se pague la deuda al viajar de nuevo
        $boletogratuito->cargarSaldo(300);
        $saldo_anterior = $boletogratuito->obtenerSaldo();
        $boleto = $colectivo->pagarCon($boletogratuito);
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $deuda - $tarifa);

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
        $saldo_anterior = $boletogratuito2->obtenerSaldo();
        $colectivo->pagarCon($boletogratuito2);
        $colectivo->pagarCon($boletogratuito2);
        $colectivo->pagarCon($boletogratuito2);
        $nuevo_saldo = $boletogratuito2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - ($tarifa_estudiantil * 2) - $tarifa);

        // Verificar cuando se cambia de dia se reinicia el gratuito
        $dia_adelantado = (int)date('d')+1;
        $boletogratuito2->guardarDia($dia_adelantado);
        $saldo_anterior = $boletogratuito2->obtenerSaldo();
        $colectivo->pagarCon($boletogratuito2);
        $nuevo_saldo = $boletogratuito2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $tarifa_estudiantil);
    }
}