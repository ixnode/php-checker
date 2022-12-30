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
 * Class CheckerClass
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 */
class CheckerClass extends CheckerAbstract
{
    /**
     * Checks the given value for the given class.
     *
     * @template T
     * @param class-string<T> $className
     * @return T
     * @throws TypeInvalidException
     * @throws ClassInvalidException
     */
    public function checkGiven(string $className)
    {
        if (!is_object($this->value)) {
            throw new TypeInvalidException($className, gettype($this->value));
        }

        if (!$this->value instanceof $className) {
            throw new ClassInvalidException($className, $this->value::class);
        }

        return $this->value;
    }

    /**
     * Checks the given value for stdClass.
     *
     * @return stdClass
     * @throws TypeInvalidException
     */
    public function checkStdClass(): stdClass
    {
        if (!$this->value instanceof stdClass) {
            throw new TypeInvalidException('stdClass', gettype($this->value));
        }

        return $this->value;
    }
}
