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
use Ixnode\PhpException\Type\TypeInvalidException;

/**
 * Class CheckerArray
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 */
class CheckerArray extends CheckerAbstract
{
    /**
     * Checks the given index and return as string.
     *
     * @param string $index
     * @return mixed
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndex(string $index): mixed
    {
        if (!is_array($this->value)) {
            throw new TypeInvalidException('iterable', gettype($this->value));
        }

        if (!array_key_exists($index, $this->value)) {
            throw new ArrayKeyNotFoundException($index);
        }

        return $this->value[$index];
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
        $value = $this->checkIndex($index);

        if (!is_string($value)) {
            throw new TypeInvalidException('string');
        }

        return $value;
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
        $value = $this->checkIndex($index);

        if (!is_string($value) && !is_null($value)) {
            throw new TypeInvalidException('string');
        }

        if (is_null($value)) {
            return null;
        }

        return $value;
    }

    /**
     * Checks the given index and return as array.
     *
     * @param string $index
     * @return array<int, mixed>
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexArray(string $index): array
    {
        $value = $this->checkIndex($index);

        if (!is_array($value)) {
            throw new TypeInvalidException('array');
        }

        return $value;
    }

    /**
     * Checks the given index and return as string array.
     *
     * @param string $index
     * @return string[]
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexStringArray(string $index): array
    {
        $value = $this->checkIndex($index);

        if (!is_array($value)) {
            throw new TypeInvalidException('array');
        }

        foreach ($value as $string) {
            if (!is_string($string)) {
                throw new TypeInvalidException('string');
            }
        }

        return $value;
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
        $value = $this->checkIndex($index);

        if (!is_array($value)) {
            throw new TypeInvalidException('array');
        }

        $return = [];

        foreach ($value as $array) {
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
     * Checks the given index and return as integer.
     *
     * @param string $index
     * @return int
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     */
    public function checkIndexInteger(string $index): int
    {
        $value = $this->checkIndex($index);

        if (!is_int($value)) {
            throw new TypeInvalidException('int');
        }

        return $value;
    }
}
