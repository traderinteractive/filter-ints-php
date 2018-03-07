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
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage -1 was not greater or equal to zero
     */
    public function filterMinValueNegative()
    {
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
     * @expectedException \TraderInteractive\Exceptions\FilterException
     * @expectedExceptionMessage -1 is less than 0
     */
    public function filterMinValueDefaultFail()
    {
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
     * @expectedException \TraderInteractive\Exceptions\FilterException
     * @expectedExceptionMessage Value failed filtering, $allowNull is set to false
     */
    public function filterAllowNullFail()
    {
        UnsignedInt::filter(null, false);
    }

    /**
     * @test
     * @covers ::filter
     * @expectedException \TraderInteractive\Exceptions\FilterException
     * @expectedExceptionMessage 0 is less than 1
     */
    public function filterMinValueFail()
    {
        $this->assertSame(1, UnsignedInt::filter('0', false, 1));
    }

    /**
     * @test
     * @covers ::filter
     * @expectedException \TraderInteractive\Exceptions\FilterException
     * @expectedExceptionMessage 2 is greater than 1
     */
    public function filterMaxValueFail()
    {
        UnsignedInt::filter('2', false, 0, 1);
    }
}
