<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    public function test() {
        $colectivo = new Colectivo(132);

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
        $fecha_falsa = new \DateTime('2023-10-09 06:00:00');
        $medioboleto->guardarDiaYHora(date('N', $fecha_falsa->getTimestamp()), date('H', $fecha_falsa->getTimestamp()));
        
        $medioboleto->cargarSaldo(150);
        $boleto = $colectivo->pagarCon($medioboleto);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $nuevo_saldo = $medioboleto->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 90); //NO ANDA
     
        $boletogratuito = new FranquiciaCompleta();
        $fecha_falsa = new \DateTime('2023-10-09 06:00:00');
        $boletogratuito->guardarDiaYHora(date('N', $fecha_falsa->getTimestamp()), date('H', $fecha_falsa->getTimestamp()));

        $boletogratuito->cargarSaldo(150);
        $boleto = $colectivo->pagarCon($boletogratuito);
        $this->assertInstanceOf(Boleto::class, $boleto);
        $nuevo_saldo = $boletogratuito->obtenerSaldo();
        $this->assertEquals($nuevo_saldo, 150);

        // Prueba para Colectivo Interurbano
        $colectivoInterurbano = new ColectivoInterurbano(300);
        $tarjetaInterurbana = new Tarjeta();
        $tarjetaInterurbana->cargarSaldo(200);
        $boletoInteurbano = $colectivoInterurbano->pagarCon($tarjetaInterurbana);
        // Verificar tarifa de colectivo interurbano
        $this->assertInstanceOf(Boleto::class, $boletoInteurbano);
        $this->assertEquals($colectivoInterurbano->obtenerTarifa(), 184);  
    }
}