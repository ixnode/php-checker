# PHP Size Byte

This library provides check routines to validate data types from given variables.

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