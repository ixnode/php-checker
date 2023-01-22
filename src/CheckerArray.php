<?php

declare(strict_types=1);

/*
 * This file is part of the ixno/php-checker project.
 *
 * (c) Björn Hempel <https://www.hempel.li/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Ixnode\PhpChecker;

use Ixnode\PhpException\ArrayType\ArrayKeyNotFoundException;
use Ixnode\PhpException\Class\ClassInvalidException;
use Ixnode\PhpException\Type\TypeInvalidException;

/**
 * Class CheckerArray
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.1 (2023-01-12)
 * @since 0.1.1 (2023-01-12) Refactoring and tidy up.
 * @since 0.1.0 (2022-12-30) First version.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CheckerArray extends CheckerAbstract
{
    /**
     * Checks the given value for an array.
     *
     * @return array<int|string, mixed>
     * @throws TypeInvalidException
     */
    public function check(): array
    {
        return $this->getValue();
    }

    /**
     * Checks the given and return as an array of array{key: value, key: value}.
     *
     * @param array<int, string> $filterKeys
     * @return array<int, array<string, mixed>>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkArray(array $filterKeys = []): array
    {
        $return = [];

        foreach ($this->getValue() as $array) {
            if (!is_array($array)) {
                throw new TypeInvalidException('array');
            }

            if (count($filterKeys) <= 0) {
                $return[] = $array;
                continue;
            }

            $newValue = [];

            foreach ($filterKeys as $filterKey) {
                if (!array_key_exists($filterKey, $array)) {
                    throw new ArrayKeyNotFoundException($filterKey);
                }

                $newValue[$filterKey] = $array[$filterKey];
            }

            $return[] = $newValue;
        }

        return $return;
    }

    /**
     * Checks the given value for an associative array.
     *
     * @return array<string, mixed>
     * @throws TypeInvalidException
     */
    public function checkAssoziative(): array
    {
        $value = $this->getValue();

        if (array_keys($value) === range(0, count($value) - 1)) {
            throw new TypeInvalidException('array-associative', 'array-sequential');
        }

        /** @phpstan-ignore-next-line */
        return $value;
    }

    /**
     * Checks the given value for an associative array.
     * @template T
     * @param class-string<T> $className
     * @return array<int|string, T>
     * @throws TypeInvalidException
     * @throws ClassInvalidException
     */
    public function checkClass(string $className): array
    {
        $values = $this->getValue();

        foreach ($values as $value) {
            (new Checker($value))->checkClass($className);
        }

        return $values;
    }

    /**
     * Checks the given value for a flat array.
     *
     * @return array<int|string, bool|float|int|string|null>
     * @throws TypeInvalidException
     */
    public function checkFlat(): array
    {
        $values = $this->getValue();

        foreach ($values as $value) {
            if (is_bool($value) || is_float($value) || is_int($value) || is_string($value) || is_null($value)) {
                continue;
            }

            throw new TypeInvalidException('flat', gettype($value));
        }

        /** @phpstan-ignore-next-line */
        return $values;
    }

    /**
     * Checks the given value for a non-associative (sequential) array.
     *
     * @return array<int, mixed>
     * @throws TypeInvalidException
     */
    public function checkSequential(): array
    {
        $value = $this->getValue();

        if (array_keys($value) !== range(0, count($value) - 1)) {
            throw new TypeInvalidException('array-sequential', 'array-associative');
        }

        /** @phpstan-ignore-next-line */
        return $value;
    }

    /**
     * Checks the given value for array string.
     *
     * @return array<int|string, string>
     * @throws TypeInvalidException
     */
    public function checkString(): array
    {
        $values = $this->getValue();

        foreach ($values as $value) {
            if (!is_string($value)) {
                throw new TypeInvalidException('string', gettype($value));
            }
        }

        /** @phpstan-ignore-next-line */
        return $values;
    }

    /**
     * Checks the given value for array string or null.
     *
     * @return array<int|string, string|null>
     * @throws TypeInvalidException
     */
    public function checkStringOrNull(): array
    {
        $values = $this->getValue();

        foreach ($values as $value) {
            if (!is_string($value) && !is_null($value)) {
                throw new TypeInvalidException('string', gettype($value));
            }
        }

        /** @phpstan-ignore-next-line */
        return $values;
    }

    /**
     * Checks the given index and return as string.
     *
     * @param string $index
     * @return mixed
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function checkIndex(string $index): mixed
    {
        $value = $this->getValue();

        if (!array_key_exists($index, $value)) {
            throw new ArrayKeyNotFoundException($index);
        }

        return $value[$index];
    }

    /**
     * Checks the given index and return as array.
     *
     * @param string $index
     * @return array<int|string, mixed>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexArray(string $index): array
    {
        return (new CheckerArray($this->checkIndex($index)))->check();
    }

    /**
     * Checks the given index and return as assoziative array.
     *
     * @param string $index
     * @return array<string, mixed>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexArrayAssoziative(string $index): array
    {
        return (new CheckerArray($this->checkIndex($index)))->checkAssoziative();
    }

    /**
     * Checks the given index and return as class array.
     *
     * @param string $index
     * @template T
     * @param class-string<T> $className
     * @return array<int|string, T>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     * @throws ClassInvalidException
     */
    public function checkIndexArrayClass(string $index, string $className): array
    {
        return (new CheckerArray($this->checkIndex($index)))->checkClass($className);
    }

    /**
     * Checks the given index and return as simple array.
     *
     * @param string $index
     * @return array<int|string, bool|float|int|string|null>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexArrayFlat(string $index): array
    {
        return (new CheckerArray($this->checkIndex($index)))->checkFlat();
    }

    /**
     * Checks the given index and return as simple array.
     *
     * @param string $index
     * @return array<int, mixed>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexArraySequential(string $index): array
    {
        return (new CheckerArray($this->checkIndex($index)))->checkSequential();
    }

    /**
     * Checks the given index and return as string array.
     *
     * @param string $index
     * @return array<int|string, string>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexArrayString(string $index): array
    {
        return (new CheckerArray($this->checkIndex($index)))->checkString();
    }

    /**
     * Checks the given index and return as string array.
     *
     * @param string $index
     * @return array<int|string, string|null>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexArrayStringOrNull(string $index): array
    {
        return (new CheckerArray($this->checkIndex($index)))->checkStringOrNull();
    }

    /**
     * Checks the given index and return as an array of array{title: string, text: string}.
     *
     * @param string $index
     * @param array<int, string> $filterKeys
     * @return array<int, array<string, mixed>>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexArrayArray(string $index, array $filterKeys = []): array
    {
        return (new CheckerArray($this->checkIndex($index)))->checkArray($filterKeys);
    }

    /**
     * Checks the given index and return as integer.
     *
     * @param string $index
     * @return int
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexInteger(string $index): int
    {
        return (new Checker($this->checkIndex($index)))->checkInteger();
    }

    /**
     * Checks the given index and return as string.
     *
     * @param string $index
     * @return string
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexString(string $index): string
    {
        return (new Checker($this->checkIndex($index)))->checkString();
    }

    /**
     * Checks the given index and return as string or null.
     *
     * @param string $index
     * @return string|null
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function checkIndexStringOrNull(string $index): string|null
    {
        return (new Checker($this->checkIndex($index)))->checkStringOrNull();
    }

    /**
     * Returns the array value of this class.
     *
     * @return array<int|string, mixed>
     * @throws TypeInvalidException
     */
    protected function getValue(): array
    {
        if (!is_array($this->value)) {
            throw new TypeInvalidException('array', gettype($this->value));
        }

        return $this->value;
    }
}
