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

/**
 * Abstract class CheckerAbstract
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 */
abstract class CheckerAbstract
{
    /**
     * Checker constructor.
     *
     * @param mixed $value
     */
    public function __construct(protected mixed $value)
    {
    }

    /**
     * Returns the raw value of this class.
     *
     * @return mixed
     */
    protected function getValue(): mixed
    {
        return $this->value;
    }
}
