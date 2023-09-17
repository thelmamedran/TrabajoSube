<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
    public function test() {
        
        $tarjeta = new Tarjeta();

        $this->assertTrue($tarjeta->cargarSaldo(150));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
        
        $this->assertFalse($tarjeta->cargarSaldo(120));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        $tarjeta->cargarSaldo(4000);
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 4150);

        $this->assertFalse($tarjeta->cargarSaldo(4000));
        $nuevo_saldo = $tarjeta->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 4150);

        $medioboleto = new FranquiciaParcial();
        
        $this->assertTrue($medioboleto->cargarSaldo(150));
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        $this->assertFalse($medioboleto->cargarSaldo(120));
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        $medioboleto->cargarSaldo(4000);
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 4150);

        $this->assertFalse($medioboleto->cargarSaldo(4000));
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 4150);

        $boletogratuito = new FranquiciaCompleta();

        $this->assertTrue($boletogratuito->cargarSaldo(150));
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);
    
        $this->assertFalse($boletogratuito->cargarSaldo(120));
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        $boletogratuito->cargarSaldo(4000);
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 4150);

        $this->assertFalse($boletogratuito->cargarSaldo(4000));
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 4150);
    }
}