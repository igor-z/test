<?php
use Codeception\Test\Unit;

class ImmutableCurrencyTest extends Unit
{
    public function testExpressions()
    {
        $a = RUB(10)->mul(5) ;
        $b = ($a ->add(USD(5))->sub(RUB(3)))->mul(2);
        $this->assertEquals('((10RUB) * 5 + 5USD - 3RUB) * 2', $b->describe());
        $this->assertEquals(['RUB' => 94, 'USD' => 10], $b->collapse());
        $this->assertEquals(726.3, $b->asFloat(['RUB' => 1, 'USD' => 63.23]));
        $this->assertEquals('(10RUB) * 5', $a->describe());

        $this->expectException(ImmutableCurrencyNoRateException::class);

		RUB(10)->asFloat([]);
    }
}