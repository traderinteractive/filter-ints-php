<?php

namespace TraderInteractive\Filter;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \TraderInteractive\Filter\UnsignedInt
 * @covers ::<private>
 */
final class UnsignedIntTest extends TestCase
{
    /**
     * @test
     * @covers ::filter
     */
    public function filterMinValueNegative()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('-1 was not greater or equal to zero');
        UnsignedInt::filter('1', false, -1);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterMinValueDefaultSuccess()
    {
        $this->assertSame(1, UnsignedInt::filter('1', false));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterMinValueDefaultFail()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('-1 is less than 0');
        UnsignedInt::filter('-1', false);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterBasicUse()
    {
        $this->assertSame(123, UnsignedInt::filter('123'));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterAllowNullSuccess()
    {
        $this->assertSame(null, UnsignedInt::filter(null, true));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterAllowNullFail()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('Value failed filtering, $allowNull is set to false');
        UnsignedInt::filter(null, false);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterMinValueFail()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('0 is less than 1');
        $this->assertSame(1, UnsignedInt::filter('0', false, 1));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterMaxValueFail()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('2 is greater than 1');
        UnsignedInt::filter('2', false, 0, 1);
    }
}
