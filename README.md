# PHP Checker

[![Release](https://img.shields.io/github/v/release/ixnode/php-checker)](https://github.com/ixnode/php-checker/releases)
[![PHP](https://img.shields.io/badge/PHP-^8.0-777bb3.svg?logo=php&logoColor=white&labelColor=555555&style=flat)](https://www.php.net/supported-versions.php)
[![PHPStan](https://img.shields.io/badge/PHPStan-Level%20Max-brightgreen.svg?style=flat)](https://phpstan.org/user-guide/rule-levels)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-brightgreen.svg?style=flat)](https://www.php-fig.org/psr/psr-12/)
[![LICENSE](https://img.shields.io/github/license/ixnode/php-checker)](https://github.com/ixnode/php-checker/blob/master/LICENSE)

> A collection of various PHP types check classes.

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

```php
use Ixnode\PhpChecker\Checker;
```

```php
$array = (new Checker([]))->checkArray();
```

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