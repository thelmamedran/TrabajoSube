<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);
        $tarjeta = new Tarjeta();
        $tarifa = 120;

        // Cargar monto válido y verificar que se cargue
        $this->assertTrue($tarjeta->cargarSaldo(150));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
        
        // Cargar monto inválido y verificar que no se cargue
        $this->assertFalse($tarjeta->cargarSaldo(120));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Verificar que se puede pagar sin tener saldo suficiente y funciona el negativo
        $saldo_anterior = $tarjeta->obtenerSaldo();
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($saldo_anterior - ($tarifa * 3), $tarjeta->obtenerSaldo());
        $this->assertEquals(-($saldo_anterior - ($tarifa * 3)), $tarjeta->obtenerDeuda());

        // Verificar que se actualice la deuda al viajar de nuevo
        $tarjeta->cargarSaldo(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->obtenerDeuda(), 30);
        $this->assertEquals(-30, $tarjeta->obtenerSaldo());

        // Verificar que se pague la deuda al viajar de nuevo
        $tarjeta->cargarSaldo(300);
        $saldo_anterior = $tarjeta->obtenerSaldo();
        $deuda_anterior = $tarjeta->obtenerDeuda();
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->obtenerSaldo(), $saldo_anterior - $deuda_anterior - $tarifa);

        // Exceder el límite de la tarjeta y verificar que se guarde para acreditar
        $tarjeta->cargarSaldo(4000);
        $this->assertTrue($tarjeta->cargarSaldo(4000));
        $nuevo_saldo = $tarjeta->obtenerSaldoAFavor();
        $this->assertEquals($nuevo_saldo, 1550);
        $colectivo->pagarCon($tarjeta);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 6600);
        
        // Verificar que a los 30 boletos se hace un 20%
        $tarifa_20 = $tarifa * 0.8;
        for ($i = 0; $i < 23; $i++) 
            $colectivo->pagarCon($tarjeta);
        $saldo_anterior = $tarjeta->obtenerSaldo();
        $colectivo->pagarCon($tarjeta);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $tarifa_20);
        
        // Verificar que a los 80 boletos se hace un 25%
        $tarifa_25 = $tarifa * 0.75;
        for ($i = 0; $i < 26; $i++) 
            $colectivo->pagarCon($tarjeta);
        $tarjeta->cargarSaldo(4000);
        for ($i = 0; $i < 23; $i++) 
            $colectivo->pagarCon($tarjeta);
        $saldo_anterior = $tarjeta->obtenerSaldo();
        $colectivo->pagarCon($tarjeta);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $tarifa_25);

        // Verificar que cuando cambia el mes el descuento se reinicia
        $mes = date('m') + 1;
        $tarjeta->guardarMes($mes);
        $saldo_anterior = $tarjeta->obtenerSaldo();
        $colectivo->pagarCon($tarjeta);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $tarifa);

    }
}