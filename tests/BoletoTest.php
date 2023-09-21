<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);

        $tarjeta = new Tarjeta();
        $id = $tarjeta->obtenerId();
        $tarjeta->cargarSaldo(150);

        // Verificar boleto con tarjeta común sin saldo negativo
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals($boleto->saldo_inicial, 150);
        $this->assertEquals($boleto->saldo_restante, 30);
        $this->assertEquals($boleto->linea, 132);
        $this->assertEquals($boleto->id, $id);
        $this->assertEquals($boleto->tipo, 'Normal');
        $this->assertEquals($boleto->monto, 120);
        $this->assertEquals($boleto->abono_deuda, 'No abona saldo');

        // Verificar boleto con tarjeta común con saldo negativo
        $colectivo->pagarCon($tarjeta);
        $tarjeta->cargarSaldo(400);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->monto, 210);
        $this->assertEquals($boleto->abono_deuda, 'Abona saldo 90');

        $medioboleto = new FranquiciaParcial();
        $id = $medioboleto->obtenerId();
        $medioboleto->cargarSaldo(150);

        // Verificar boleto con tarjeta con medio boleto sin saldo negativo
        $boleto = $colectivo->pagarCon($medioboleto);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals($boleto->saldo_inicial, 150);
        $this->assertEquals($boleto->saldo_restante, 90);
        $this->assertEquals($boleto->linea, 132);
        $this->assertEquals($boleto->id, $id);
        $this->assertEquals($boleto->tipo, 'Medio');
        $this->assertEquals($boleto->monto, 60);
        $this->assertEquals($boleto->abono_deuda, 'No abona saldo');

        $boletogratuito = new FranquiciaCompleta();
        $id = $boletogratuito->obtenerId();
        $boletogratuito->cargarSaldo(150);

        // Verificar boleto con tarjeta con boleto gratuito sin saldo negativo
        $boleto = $colectivo->pagarCon($boletogratuito);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $this->assertEquals($boleto->saldo_inicial, 150);
        $this->assertEquals($boleto->saldo_restante, 150);
        $this->assertEquals($boleto->linea, 132);
        $this->assertEquals($boleto->id, $id);
        $this->assertEquals($boleto->tipo, 'Gratuito');
        $this->assertEquals($boleto->monto, 0);
        $this->assertEquals($boleto->abono_deuda, 'No abona saldo');
    }
}