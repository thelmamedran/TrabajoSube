<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);

        $tarjeta = new Tarjeta();
        $id = $tarjeta->obtenerId();
        $tarjeta->cargarSaldo(150);
        $tarifa = 120;

        // Verificar boleto con tarjeta común sin saldo negativo
        $saldo_inicial = $tarjeta->obtenerSaldo();
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals($boleto->saldo_inicial, $saldo_inicial);
        $this->assertEquals($boleto->saldo_restante, $saldo_inicial - $tarifa);
        $this->assertEquals($boleto->linea, 132);
        $this->assertEquals($boleto->id, $id);
        $this->assertEquals($boleto->tipo, 'Normal');
        $this->assertEquals($boleto->monto, $tarifa);
        $this->assertEquals($boleto->abono_deuda, 'No abona saldo');

        // Verificar boleto con tarjeta común con saldo negativo
        $colectivo->pagarCon($tarjeta);
        $tarjeta->cargarSaldo(400);
        $saldo_inicial = $tarjeta->obtenerSaldo();
        $deuda_inicial = $tarjeta->obtenerDeuda();
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->monto, $tarifa + $deuda_inicial);
        $this->assertEquals($boleto->abono_deuda, 'Abona saldo ' . $deuda_inicial);

        // Verificar boleto con tarjeta con medio boleto sin saldo negativo
        $tiempoFalso = strtotime('2023-16-10 16:00:00');   
        $this->setTime($tiempoFalso);

        $medioboleto = new FranquiciaParcial();
        $tarifa_medio_boleto = $tarifa / 2;
        $id = $medioboleto->obtenerId();
        $medioboleto->cargarSaldo(150);
        $saldo_inicial = $medioboleto->obtenerSaldo();
        $boleto = $colectivo->pagarCon($medioboleto);
        
        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals($boleto->saldo_inicial, $saldo_inicial);
        $this->assertEquals($boleto->saldo_restante, $medioboleto->obtenerSaldo());
        $this->assertEquals($boleto->linea, 132);
        $this->assertEquals($boleto->id, $id);
        $this->assertEquals($boleto->tipo, 'Medio');
        $this->assertEquals($boleto->monto, $tarifa_medio_boleto);
        $this->assertEquals($boleto->abono_deuda, 'No abona saldo');

        $boletogratuito = new FranquiciaCompleta();
        $id = $boletogratuito->obtenerId();
        $boletogratuito->cargarSaldo(150);

        // Verificar boleto con tarjeta con boleto gratuito sin saldo negativo
        $saldo_inicial = $boletogratuito->obtenerSaldo();
        $boleto = $colectivo->pagarCon($boletogratuito);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals($boleto->saldo_inicial, $saldo_inicial);
        $this->assertEquals($boleto->saldo_restante, $saldo_inicial - 0);
        $this->assertEquals($boleto->linea, 132);
        $this->assertEquals($boleto->id, $id);
        $this->assertEquals($boleto->tipo, 'Gratuito');
        $this->assertEquals($boleto->monto, 0);
        $this->assertEquals($boleto->abono_deuda, 'No abona saldo');
    }
}
