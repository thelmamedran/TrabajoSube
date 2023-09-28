<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ParcialTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);
        $medioboleto = new FranquiciaParcial();
        
        // Cargar monto válido y verificar que se cargue
        $this->assertTrue($medioboleto->cargarSaldo(150));
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Cargar monto inválido y verificar que no se cargue
        $this->assertFalse($medioboleto->cargarSaldo(120));
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Verificar que se cobre la mitad
        $colectivo->pagarCon($medioboleto);
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 90);

        // Verificar que se puede pagar sin tener saldo suficiente y funciona el negativo
        $boleto = $colectivo->pagarCon($medioboleto);
        $boleto = $colectivo->pagarCon($medioboleto);
        $boleto = $colectivo->pagarCon($medioboleto);
        $boleto = $colectivo->pagarCon($medioboleto);
        $this->assertEquals(-180, $medioboleto->obtenerSaldo());
        $this->assertEquals(180, $medioboleto->obtenerDeuda());

        // Verificar que se actualice la deuda al viajar de nuevo
        $medioboleto->cargarSaldo(150);
        $boleto = $colectivo->pagarCon($medioboleto);
        $this->assertEquals($medioboleto->obtenerDeuda(), 150);
        $this->assertEquals(-150, $medioboleto->obtenerSaldo());

        // Verificar que se pague la deuda al viajar de nuevo
        $medioboleto->cargarSaldo(300);
        $boleto = $colectivo->pagarCon($medioboleto);
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 30);

        // Exceder el límite de la tarjeta y verificar que se guarde para acreditar
        $medioboleto->cargarSaldo(4000);
        $this->assertTrue($medioboleto->cargarSaldo(4000));
        $nuevo_saldo = $medioboleto->obtenerSaldoAFavor();
        $this->assertEquals($nuevo_saldo, 1430);
        $colectivo->pagarCon($medioboleto);
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 6600);

        // Verificar que en menos de 5 minutos no se cobren 2 medios
        $medioboleto2 = new FranquiciaParcial();
        $medioboleto2->cargarSaldo(300);
        $colectivo->pagarCon($medioboleto2);
        $nuevo_saldo = $medioboleto2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 240);
        $colectivo->pagarCon($medioboleto2);
        $nuevo_saldo = $medioboleto2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 120);
        
        // Verificar que con mas de 5 minutos de diferencia se vuelva a cobrar el medio
        $min_adelantado = (int)date('i') + 6;
        $medioboleto2->guardarMin($min_adelantado);
        $colectivo->pagarCon($medioboleto2);
        $nuevo_saldo = $medioboleto2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 60);
    }
}