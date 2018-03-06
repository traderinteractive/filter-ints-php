<?php

namespace TraderInteractive\Filter;

use TraderInteractive\Exceptions\FilterException;

/**
 * A collection of filters for integers.
 */
final class Ints
{
    /**
     * Filters $value to an integer strictly.
     *
     * $value must be an int or contain all digits, optionally prepended by a '+' or '-' and optionally surrounded by
     * whitespace to pass the filter.
     *
     * The return value is the int, as expected by the \TraderInteractive\Filterer class.
     *
     * @param string|int $value     the value to make an integer
     * @param bool       $allowNull Set to true if NULL values are allowed. The filtered result of a NULL value is NULL
     * @param int        $minValue  The minimum acceptable value
     * @param int        $maxValue  The maximum acceptable value
     *
     * @return int|null The filtered value
     *
     * @throws FilterException if $value string length is zero
     * @throws FilterException if $value does not contain all digits, optionally prepended by a '+' or '-' and
     *                         optionally surrounded by whitespace
     * @throws FilterException if $value was greater than a max int of PHP_INT_MAX
     * @throws FilterException if $value was less than a min int of ~PHP_INT_MAX
     * @throws FilterException if $value is not a string
     * @throws FilterException if $value is less than $minValue
     * @throws FilterException if $value is greater than $maxValue
     */
    public static function filter($value, bool $allowNull = false, int $minValue = null, int $maxValue = PHP_INT_MAX)
    {
        if (self::valueIsNullAndValid($allowNull, $value)) {
            return null;
        }

        $valueInt = self::getValueInt($value);

        self::enforceMinimumValue($minValue, $valueInt);
        self::enforceMaximumValue($maxValue, $valueInt);

        return $valueInt;
    }

    private static function valueIsNullAndValid(bool $allowNull, $value = null) : bool
    {
        if ($allowNull === false && $value === null) {
            throw new FilterException('Value failed filtering, $allowNull is set to false');
        }
        return $allowNull === true && $value === null;
    }

    private static function getValueInt($value) : int
    {
        $valueInt = null;
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value)) {
            return self::handleStringValues($value);
        }

        throw new FilterException('"' . var_export($value, true) . '" $value is not a string');
    }

    private static function handleStringValues(string $value) : int
    {
        $value = trim($value);

        self::enforceStringLength($value);
        self::checkDigits($value);
        $casted = self::castAndEnforceValidIntegerSize($value);

        return $casted;
    }

    private static function enforceStringLength(string $value)
    {
        if (strlen($value) === 0) {
            throw new FilterException('$value string length is zero');
        }
    }

    private static function checkDigits(string $value)
    {
        $stringToCheckDigits = $value;

        if ($value[0] === '-' || $value[0] === '+') {
            $stringToCheckDigits = substr($value, 1);
        }

        if (!ctype_digit($stringToCheckDigits)) {
            throw new FilterException(
                "{$value} does not contain all digits, optionally prepended by a '+' or '-' and optionally "
                . "surrounded by whitespace"
            );
        }
    }

    private static function castAndEnforceValidIntegerSize(string $value) : int
    {
        $phpIntMin = ~PHP_INT_MAX;
        $casted = (int)$value;

        self::enforcePhpIntMax($value, $casted);
        self::enforcePhpIntMin($value, $casted, $phpIntMin);

        return $casted;
    }

    private static function enforceMinimumValue(int $minValue, $valueInt)
    {
        if ($minValue !== null && $valueInt < $minValue) {
            throw new FilterException("{$valueInt} is less than {$minValue}");
        }
    }

    private static function enforceMaximumValue(int $maxValue, $valueInt)
    {
        if ($valueInt > $maxValue) {
            throw new FilterException("{$valueInt} is greater than {$maxValue}");
        }
    }

    private static function enforcePhpIntMax(string $value, $casted)
    {
        if ($casted === PHP_INT_MAX && $value !== (string)PHP_INT_MAX) {
            throw new FilterException("{$value} was greater than a max int of " . PHP_INT_MAX);
        }
    }

    private static function enforcePhpIntMin(string $value, $casted, $phpIntMin)
    {
        if ($casted === $phpIntMin && $value !== (string)$phpIntMin) {
            throw new FilterException("{$value} was less than a min int of {$phpIntMin}");
        }
    }
}
