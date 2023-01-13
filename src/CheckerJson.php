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
 * Class CheckerJson
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.1 (2023-01-12)
 * @since 0.1.1 (2023-01-12) Refactoring and tidy up.
 * @since 0.1.0 (2022-12-30) First version.
 */
class CheckerJson extends CheckerAbstract
{
    /**
     * Checks the given value for json.
     *
     * @return string
     * @throws TypeInvalidException
     */
    public function check(): string
    {
        $this->value = (new Checker($this->value))->checkString();

        json_decode($this->value);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new TypeInvalidException('json-string');
        }

        return $this->value;
    }

    /**
     * Checks the given value for json.
     *
     * @return bool
     */
    public function isJson(): bool
    {
        if (!is_string($this->value)) {
            return false;
        }

        json_decode($this->value);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
