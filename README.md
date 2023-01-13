# PHP Checker

[![Release](https://img.shields.io/github/v/release/ixnode/php-checker)](https://github.com/ixnode/php-checker/releases)
[![PHP](https://img.shields.io/badge/PHP-^8.0-777bb3.svg?logo=php&logoColor=white&labelColor=555555&style=flat)](https://www.php.net/supported-versions.php)
[![PHPStan](https://img.shields.io/badge/PHPStan-Level%20Max-brightgreen.svg?style=flat)](https://phpstan.org/user-guide/rule-levels)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-brightgreen.svg?style=flat)](https://www.php-fig.org/psr/psr-12/)
[![LICENSE](https://img.shields.io/github/license/ixnode/php-checker)](https://github.com/ixnode/php-checker/blob/master/LICENSE)

> A collection of various PHP types check classes.

## Introduction

This package is helpful to validate complex data types like complex arrays and to comply with DocBlock declarations
(static code analysis tools like PHPStan or Psalm). Uses and throws exceptions from
[ixnode/php-exception](https://github.com/ixnode/php-exception) as a "one-liner". Instead of using the following code:

```php
if (!is_array($value)) {
    throw new TypeInvalidException('array', gettype($this->value));
}
```

just use this one:

```php
$checkedArray = (new Checker($value))->checkArray();
```

## Installation

```bash
composer require ixnode/php-checker
```

```bash
vendor/bin/php-checker -V
```

```bash
php-checker 0.1.0 (12-30-2022 18:08:35) - Björn Hempel <bjoern@hempel.li>
```

## Usage

### Example 1

```php
use Ixnode\PhpChecker\Checker;
```

```php
$array = (new Checker(.0))->checkFloat();
```

### Example 2

```php
use Ixnode\PhpChecker\CheckerArray;
```

```php
$array = (new CheckerArray([new Checker(123), new Checker(456), new Checker(678)])->checkClass(Checker::class);
```

### Example 3

```php
use Ixnode\PhpChecker\CheckerClass;
```

```php
$array = (new CheckerClass(new Checker(123)))->check(Checker::class);
```

### Example 4

```php
use Ixnode\PhpChecker\CheckerJson;
```

```php
$array = (new CheckerJson('{"1": 1, "2": 2, "3": 3}'))->check();
```

## Available checkers

### Class `Ixnode\PhpChecker\Checker`

Checks general data type specific properties.

| Method                                                     | Expected input                  | Method Parameters | Output value (if passed) | Exception                                       |
|------------------------------------------------------------|---------------------------------|-------------------|--------------------------|-------------------------------------------------|
| `checkArray` (_Alias of_ `CheckerArray::check`)            | `array<int&#124;string, mixed>` | `null`            | _Same as input_          | `TypeInvalidException`                          || `checkBoolean`                                  | `bool`                                                                   | `null`                         | _Same as input_                    | `TypeInvalidException`                          |
| `checkClass` (_Alias of_ `CheckerClass::checkClass`)       | `ClassName`                     | `class-string`    | _Same as input_          | `TypeInvalidException`, `ClassInvalidException` |
| `checkFloat`                                               | `float`                         | `null`            | _Same as input_          | `TypeInvalidException`                          |
| `checkInteger`                                             | `int`                           | `null`            | _Same as input_          | `TypeInvalidException`                          |
| `checkIterable`                                            | `iterable`                      | `null`            | _Same as input_          | `TypeInvalidException`                          |
| `checkJson` (_Alias of_ `CheckerJson::check`)              | `json-string`                   | `null`            | _Same as input_          | `TypeInvalidException`                          |
| `checkObject`                                              | `object`                        | `null`            | _Same as input_          | `TypeInvalidException`                          |
| `checkStdClass` (_Alias of_ `CheckerClass::checkStdClass`) | `stdClass`                      | `null`            | _Same as input_          | `TypeInvalidException`                          |
| `checkString`                                              | `string`                        | `null`            | _Same as input_          | `TypeInvalidException`                          |
| `checkStringOrNull`                                        | `string&#124;null`              | `null`            | _Same as input_          | `TypeInvalidException`                          |

### Class `Ixnode\PhpChecker\CheckerArray`

Checks array specific properties. 

| Method                        | Expected input                                                                                   | Method Parameters                        | Output value (if passed)                                                                    | Exception                                           |
|-------------------------------|--------------------------------------------------------------------------------------------------|------------------------------------------|---------------------------------------------------------------------------------------------|-----------------------------------------------------|
| `check`                       | `array<int&#124;string, mixed>`                                                                  | `null`                                   | _Same as input_                                                                             | `TypeInvalidException`                              |
| `checkArray`                  | `array<int&#124;string, array<string, mixed>>`                                                   | `null` or `array<int, string>`           | `array<int, array<string, mixed>>`                                                          | `TypeInvalidException`                              |
| `checkAssoziative`            | `array<string, mixed>`                                                                           | `null`                                   | _Same as input_                                                                             | `TypeInvalidException`                              |
| `checkClass`                  | `array<int&#124;string, ClassName>`                                                              | `class-string`                           | _Same as input_                                                                             | `TypeInvalidException`                              |
| `checkFlat`                   | `array<int&#124;string, bool&#124;float&#124;int&#124;string&#124;null>`                         | `null`                                   | _Same as input_                                                                             | `TypeInvalidException`                              |
| `checkSimple`                 | `array<int, mixed>`                                                                              | `null`                                   | _Same as input_                                                                             | `TypeInvalidException`                              |
| `checkString`                 | `array<int&#124;string, string>`                                                                 | `null`                                   | _Same as input_                                                                             | `TypeInvalidException`                              |
| `checkStringOrNull`           | `array<int&#124;string, string&#124;null>`                                                       | `null`                                   | _Same as input_                                                                             | `TypeInvalidException`                              |
| `checkIndex`                  | `array<int&#124;string, mixed>`                                                                  | `string`                                 | `mixed` (_index of given_)                                                                  | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexArray`             | `array<int&#124;string, array<int&#124;string, mixed>>`                                          | `string`                                 | `array<int&#124;string, mixed>` (_index of given_)                                          | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexArrayArray`        | `array<int&#124;string, array<int&#124;string, array<string, mixed>>>`                           | `string`, `null` or `array<int, string>` | `array<int, array<string, mixed>>` (_index of given_)                                       | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexArrayAssoziative`  | `array<int&#124;string, array<string, mixed>>`                                                   | `string`                                 | `array<string, mixed>` (_index of given_)                                                   | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexArrayClass`        | `array<int&#124;string, array<int&#124;string, ClassName>>`                                      | `string`                                 | `array<int&#124;string, ClassName>` (_index of given_)                                      | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexArrayFlat`         | `array<int&#124;string, array<int&#124;string, bool&#124;float&#124;int&#124;string&#124;null>>` | `string`                                 | `array<int&#124;string, bool&#124;float&#124;int&#124;string&#124;null>` (_index of given_) | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexArraySimple`       | `array<int&#124;string, array<int, mixed>>`                                                      | `string`                                 | `array<int, string>` (_index of given_)                                                     | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexArrayString`       | `array<int&#124;string, array<int&#124;string, string>>`                                         | `string`                                 | `array<int&#124;string, string>` (_index of given_)                                         | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexArrayStringOrNull` | `array<int&#124;string, array<int&#124;string, string&#124;null>>`                               | `string`                                 | `array<int&#124;string, string&#124;null>` (_index of given_)                               | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexInteger`           | `array<int&#124;string, int>`                                                                    | `string`                                 | `int` (_index of given_)                                                                    | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexString`            | `array<int&#124;string, string>`                                                                 | `string`                                 | `string` (_index of given_)                                                                 | `TypeInvalidException`, `ArrayKeyNotFoundException` |
| `checkIndexStringOrNull`      | `array<int&#124;string, string&#124;null>`                                                       | `string`                                 | `string&#124;null` (_index of given_)                                                       | `TypeInvalidException`, `ArrayKeyNotFoundException` |

### Class `Ixnode\PhpChecker\CheckerClass`

Checks class specific properties.

| Method          | Expected input | Method Parameters | Output value (if passed) | Exception                                       |
|-----------------|----------------|-------------------|--------------------------|-------------------------------------------------|
| `checkClass`    | `ClassName`    | `class-string`    | _Same as input_          | `TypeInvalidException`, `ClassInvalidException` |
| `checkStdClass` | `stdClass`     | `null`            | _Same as input_          | `TypeInvalidException`                          |

### Class `Ixnode\PhpChecker\CheckerJson`

Checks JSON specific properties.

| Method   | Expected input | Method Parameters | Output value (if passed) | Exception              |
|----------|----------------|-------------------|--------------------------|------------------------|
| `check`  | `json-string`  | `null`            | _Same as input_          | `TypeInvalidException` |
| `isJson` | `json-string`  | `null`            | `bool`                   | `null`                 |

## Development

```bash
git clone git@github.com:ixnode/php-checker.git && cd php-checker
```

```bash
composer install
```

```bash
composer test
```

## License

This tool is licensed under the MIT License - see the [LICENSE](/LICENSE) file for details