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

use Ixnode\PhpException\Class\ClassInvalidException;
use Ixnode\PhpException\Type\TypeInvalidException;
use stdClass;

/**
 * Class Checker
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.1 (2023-01-12)
 * @since 0.1.1 (2023-01-12) Refactoring and tidy up.
 * @since 0.1.0 (2022-12-30) First version.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Checker extends CheckerAbstract
{
    /**
     * Checks the given value for an array.
     *
     * @return array<int|string, mixed>
     * @throws TypeInvalidException
     */
    public function checkArray(): array
    {
        return (new CheckerArray($this->getValue()))->check();
    }

    /**
     * Checks the given value for boolean.
     *
     * @return bool
     * @throws TypeInvalidException
     */
    public function checkBoolean(): bool
    {
        if (!is_bool($this->getValue())) {
            throw new TypeInvalidException('boolean', gettype($this->getValue()));
        }

        return $this->getValue();
    }

    /**
     * Checks the given value for the given class.
     *
     * @template T
     * @param class-string<T> $className
     * @return T
     * @throws TypeInvalidException
     * @throws ClassInvalidException
     */
    public function checkClass(string $className)
    {
        return (new CheckerClass($this->getValue()))->checkClass($className);
    }

    /**
     * Checks the given value for float.
     *
     * @return float
     * @throws TypeInvalidException
     */
    public function checkFloat(): float
    {
        if (!is_float($this->getValue())) {
            throw new TypeInvalidException('float', gettype($this->getValue()));
        }

        return $this->getValue();
    }

    /**
     * Checks the given value for iterable.
     *
     * @return array<int|string, mixed>
     * @throws TypeInvalidException
     */
    public function checkIterable(): iterable
    {
        if (!is_iterable($this->getValue())) {
            throw new TypeInvalidException('iterable', gettype($this->getValue()));
        }

        return $this->getValue();
    }

    /**
     * Checks the given value for integer.
     *
     * @return int
     * @throws TypeInvalidException
     */
    public function checkInteger(): int
    {
        if (!is_int($this->getValue())) {
            throw new TypeInvalidException('int', gettype($this->getValue()));
        }

        return $this->getValue();
    }

    /**
     * Checks the given value for json.
     *
     * @return string
     * @throws TypeInvalidException
     */
    public function checkJson(): string
    {
        return (new CheckerJson($this->getValue()))->check();
    }

    /**
     * Checks the given value for object.
     *
     * @return object
     * @throws TypeInvalidException
     */
    public function checkObject(): object
    {
        if (!is_object($this->getValue())) {
            throw new TypeInvalidException('object', gettype($this->getValue()));
        }

        return $this->getValue();
    }

    /**
     * Checks the given value for stdClass.
     *
     * @return stdClass
     * @throws TypeInvalidException
     */
    public function checkStdClass(): stdClass
    {
        return (new CheckerClass($this->getValue()))->checkStdClass();
    }

    /**
     * Checks the given value for string.
     *
     * @return string
     * @throws TypeInvalidException
     */
    public function checkString(): string
    {
        if (!is_string($this->getValue())) {
            throw new TypeInvalidException('string', gettype($this->getValue()));
        }

        return $this->getValue();
    }

    /**
     * Checks the given value for string or null.
     *
     * @return string|null
     * @throws TypeInvalidException
     */
    public function checkStringOrNull(): ?string
    {
        if (!is_string($this->getValue()) && !is_null($this->getValue())) {
            throw new TypeInvalidException('string', gettype($this->getValue()));
        }

        return $this->getValue();
    }
}
