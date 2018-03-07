<?php

namespace TraderInteractive\Filter;

use TraderInteractive\Exceptions\FilterException;

/**
 * A collection of filters for unsigned integers.
 */
final class UnsignedInt
{
    /**
     * Filters $value to an unsigned integer strictly.
     *
     * @see \TraderInteractive\Filter\Ints::filter()
     *
     * @param mixed $value     The value to be checked.
     * @param bool  $allowNull Indicates if the value can be null.
     * @param int   $minValue  Indicates the minimum acceptable value.
     * @param int   $maxValue  Indicates the maximum acceptable value.
     *
     * @return int|null
     *
     * @throws \InvalidArgumentException if minvalue is not greater or equal to zero.
     * @throws FilterException on failure to filter.
     */
    public static function filter($value, bool $allowNull = false, int $minValue = 0, int $maxValue = PHP_INT_MAX)
    {
        if ($minValue < 0) {
            throw new \InvalidArgumentException("{$minValue} was not greater or equal to zero");
        }

        return Ints::filter($value, $allowNull, $minValue, $maxValue);
    }
}
