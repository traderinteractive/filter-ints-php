# filter-ints-php

[![Build Status](https://travis-ci.org/traderinteractive/filter-ints-php.svg?branch=master)](https://travis-ci.org/traderinteractive/filter-ints-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/traderinteractive/filter-ints-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/traderinteractive/filter-ints-php/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/traderinteractive/filter-ints-php/badge.svg?branch=master)](https://coveralls.io/github/traderinteractive/filter-ints-php?branch=master)

[![Latest Stable Version](https://poser.pugx.org/traderinteractive/filter-ints/v/stable)](https://packagist.org/packages/traderinteractive/filter-ints)
[![Latest Unstable Version](https://poser.pugx.org/traderinteractive/filter-ints/v/unstable)](https://packagist.org/packages/traderinteractive/filter-ints)
[![License](https://poser.pugx.org/traderinteractive/filter-ints/license)](https://packagist.org/packages/traderinteractive/filter-ints)

[![Total Downloads](https://poser.pugx.org/traderinteractive/filter-ints/downloads)](https://packagist.org/packages/traderinteractive/filter-ints)
[![Daily Downloads](https://poser.pugx.org/traderinteractive/filter-ints/d/daily)](https://packagist.org/packages/traderinteractive/filter-ints)
[![Monthly Downloads](https://poser.pugx.org/traderinteractive/filter-ints/d/monthly)](https://packagist.org/packages/traderinteractive/filter-ints)

A filtering implementation for verifying correct data and performing typical modifications to data.

## Requirements

Requires PHP 7.0 or newer and uses composer to install further PHP dependencies.  See the [composer specification](composer.json) for more details.

## Composer

To add the library as a local, per-project dependency use [Composer](http://getcomposer.org)! Simply add a dependency on
`traderinteractive/filter-ints` to your project's `composer.json` file such as:

```sh
composer require traderinteractive/filter-ints
```

### Functionality

#### Ints/UnsignedInt::filter

These filters verify that the arguments are of the proper numeric type and
allow for bounds checking.  The second parameter to each of them can be set to `true` to allow null values through without an error (they will
stay null and not get converted to false).  The next two parameters are the min and max bounds and can be used to limit the domain of allowed
numbers.

Non-numeric strings will fail validation, and numeric strings will be cast.

The following checks that `$value` is an integer between 1 and 100 inclusive, and returns the integer (after casting it if it was a string).

```php
$value = \TraderInteractive\Filter\UnsignedInt::filter($value, false, 1, 100);
```

## Contact

Developers may be contacted at:

 * [Pull Requests](https://github.com/traderinteractive/filter-ints-php/pulls)
 * [Issues](https://github.com/traderinteractive/filter-ints-php/issues)

## Project Build

With a checkout of the code get [Composer](http://getcomposer.org) in your PATH and run:

```bash
composer install
./vendor/bin/phpcs
./vendor/bin/phpunit
```

For more information on our build process, read through out our [Contribution Guidelines](CONTRIBUTING.md).
