<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ParcialTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);
        $medioboleto = new FranquiciaParcial();

        $tarifa = 120;
        $tarifa_medio = $tarifa/2;

        // Seteo tiempo falso para que la franquicia sea válida
        $fecha_falsa = new \DateTime('2023-10-09 06:00:00');
        $medioboleto->guardarDiaYHora(date('N', $fecha_falsa->getTimestamp()), date('H', $fecha_falsa->getTimestamp()));

        // Cargar monto válido y verificar que se cargue
        $this->assertTrue($medioboleto->cargarSaldo(150));
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Cargar monto inválido y verificar que no se cargue
        $this->assertFalse($medioboleto->cargarSaldo(120));
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Verificar que se cobre la mitad
        $saldo_anterior = $medioboleto->obtenerSaldo();
        $colectivo->pagarCon($medioboleto);
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $tarifa_medio); // NO ANDA

        // Verificar que se puede pagar sin tener saldo suficiente y funciona el negativo
        $saldo_anterior = $medioboleto->obtenerSaldo();
        $boleto = $colectivo->pagarCon($medioboleto);
        $boleto = $colectivo->pagarCon($medioboleto);
        $this->assertEquals($saldo_anterior - ($tarifa * 2), $medioboleto->obtenerSaldo());
        $this->assertEquals(-($saldo_anterior - ($tarifa * 2)), $medioboleto->obtenerDeuda());

        // Verificar que se actualice la deuda al viajar de nuevo
        $medioboleto->cargarSaldo(300);
        $saldo_anterior = $medioboleto->obtenerSaldo();
        $deuda_anterior = $medioboleto->obtenerDeuda();
        $boleto = $colectivo->pagarCon($medioboleto);
        $deuda = $medioboleto->obtenerDeuda();
        $this->assertEquals($deuda, 0);
        $this->assertEquals($saldo_anterior - $deuda_anterior - $tarifa, $medioboleto->obtenerSaldo());

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
        $fecha_falsa = new \DateTime('2023-10-09 06:00:00');
        $medioboleto2->guardarDiaYHora(date('N', $fecha_falsa->getTimestamp()), date('H', $fecha_falsa->getTimestamp()));
        $medioboleto2->cargarSaldo(300);
        $saldo_anterior = $medioboleto2->obtenerSaldo();
        $colectivo->pagarCon($medioboleto2);
        $nuevo_saldo = $medioboleto2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $tarifa_medio);
        $saldo_anterior = $medioboleto2->obtenerSaldo();
        $colectivo->pagarCon($medioboleto2);
        $nuevo_saldo = $medioboleto2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $tarifa);
        
        // Verificar que con mas de 5 minutos de diferencia se vuelva a cobrar el medio
        $min_adelantado = (int)date('i') + 6;
        $medioboleto2->guardarMin($min_adelantado);
        $saldo_anterior = $medioboleto2->obtenerSaldo();
        $colectivo->pagarCon($medioboleto2);
        $nuevo_saldo = $medioboleto2->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, $saldo_anterior - $tarifa_medio);
    }
}