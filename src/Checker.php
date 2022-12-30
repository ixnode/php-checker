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

use Ixnode\PhpException\Type\TypeInvalidException;

/**
 * Class Checker
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 */
class Checker extends CheckerAbstract
{
    /**
     * Checks the given value for array.
     *
     * @return array<int|string, mixed>
     * @throws TypeInvalidException
     */
    public function checkArray(): array
    {
        if (!is_array($this->value)) {
            throw new TypeInvalidException('array', gettype($this->value));
        }

        return $this->value;
    }

    /**
     * Checks the given value for a non-associative array.
     *
     * @return array<int, mixed>
     * @throws TypeInvalidException
     */
    public function checkArraySimple(): array
    {
        if (!is_array($this->value)) {
            throw new TypeInvalidException('array', gettype($this->value));
        }

        return $this->value;
    }

    /**
     * Checks the given value for string.
     *
     * @return string
     * @throws TypeInvalidException
     */
    public function checkString(): string
    {
        if (!is_string($this->value)) {
            throw new TypeInvalidException('string', gettype($this->value));
        }

        return $this->value;
    }

    /**
     * Checks the given value for float.
     *
     * @return float
     * @throws TypeInvalidException
     */
    public function checkFloat(): float
    {
        if (!is_float($this->value)) {
            throw new TypeInvalidException('float', gettype($this->value));
        }

        return $this->value;
    }

    /**
     * Checks the given value for boolean.
     *
     * @return bool
     * @throws TypeInvalidException
     */
    public function checkBoolean(): bool
    {
        if (!is_bool($this->value)) {
            throw new TypeInvalidException('boolean', gettype($this->value));
        }

        return $this->value;
    }

    /**
     * Checks the given value for object.
     *
     * @return object
     * @throws TypeInvalidException
     */
    public function checkObject(): object
    {
        if (!is_object($this->value)) {
            throw new TypeInvalidException('object', gettype($this->value));
        }

        return $this->value;
    }

    /**
     * Checks the given value for iterable.
     *
     * @return array<int|string, mixed>
     * @throws TypeInvalidException
     */
    public function checkIterable(): iterable
    {
        if (!is_iterable($this->value)) {
            throw new TypeInvalidException('iterable', gettype($this->value));
        }

        return $this->value;
    }
}
