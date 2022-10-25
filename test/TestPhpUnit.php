<?php


use PHPUnit\Framework\TestCase;

class TestPhpUnit extends TestCase
{
    public function testCalculation()
    {
         $a = 5;
         $b = 10;

         $this->assertEquals(15, $a + $b);
         $this->assertEquals(50, $a * $b);
         $this->assertEquals(-5, $a - $b);
         $this->assertEquals(0.5, $a / $b);
    }
}
