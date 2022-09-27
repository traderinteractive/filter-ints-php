<?php

namespace TraderInteractive\Filter;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \TraderInteractive\Filter\Ints
 * @covers ::<private>
 */
final class IntsTest extends TestCase
{
    /**
     * @test
     * @covers ::filter
     */
    public function filterAllowNullIsTrueAndNullValue()
    {
        $result = Ints::filter(null, true);
        $this->assertSame(null, $result);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterPositiveInt()
    {
        $this->assertSame(123, Ints::filter(123));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterNegativeInt()
    {
        $this->assertSame(-123, Ints::filter(-123));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterZeroInt()
    {
        $positiveZero = + 0;
        $this->assertSame(0, Ints::filter($positiveZero));
        $this->assertSame(0, Ints::filter(-0));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterPositiveString()
    {
        $this->assertSame(123, Ints::filter('   123 '));
        $this->assertSame(123, Ints::filter('   +123 '));
        $this->assertSame(0, Ints::filter('   +0 '));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterNegativeString()
    {
        $this->assertSame(-123, Ints::filter('   -123 '));
        $this->assertSame(0, Ints::filter('   -0 '));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterNonStringOrInt()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('"true" $value is not a string');
        Ints::filter(true);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterEmptyString()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('$value string length is zero');
        Ints::filter('');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterWhitespaceString()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('$value string length is zero');
        Ints::filter('   ');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function nonDigitString()
    {
        try {
            Ints::filter('123.4');
            $this->fail("No exception thrown");
        } catch (\Throwable $e) {
            $this->assertSame(
                "123.4 does not contain all digits, optionally prepended by a '+' or '-' and optionally surrounded by "
                . "whitespace",
                $e->getMessage()
            );
        }
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterGreaterThanPhpIntMax()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        //32, 64 and 128 bit and their +1 's
        $maxes = [
            '2147483647' => '2147483648',
            '9223372036854775807' => '9223372036854775808',
            '170141183460469231731687303715884105727' => '170141183460469231731687303715884105728',
        ];
        $oneOverMax = $maxes[(string)PHP_INT_MAX];
        Ints::filter($oneOverMax);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterLessThanPhpIntMin()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        //32, 64 and 128 bit and their -1 's
        $mins = [
            '-2147483648' => '-2147483649',
            '-9223372036854775808' => '-9223372036854775809',
            '-170141183460469231731687303715884105728' => '-170141183460469231731687303715884105729',
        ];
        $oneUnderMin = $mins[(string)~PHP_INT_MAX];
        Ints::filter($oneUnderMin);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterLessThanMin()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('-1 is less than 0');
        Ints::filter(-1, false, 0);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterEqualToMin()
    {
        $this->assertSame(0, Ints::filter(0, false, 0));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterGreaterThanMax()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('1 is greater than 0');
        Ints::filter(1, false, null, 0);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterEqualToMax()
    {
        $this->assertSame(0, Ints::filter(0, false, null, 0));
    }
}
