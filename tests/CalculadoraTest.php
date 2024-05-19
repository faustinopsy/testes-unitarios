<?php
use PHPUnit\Framework\TestCase;
use App\Testes\Calculadora;
class CalculadoraTest extends TestCase {
    public function testSoma() {
        $calcular = new Calculadora();
        $result = $calcular->somar(2, 3);
        $this->assertEquals(5, $result);
    }
}