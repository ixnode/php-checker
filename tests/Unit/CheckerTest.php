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

namespace Ixnode\PhpChecker\Tests\Unit;

use Ixnode\PhpChecker\Checker;
use Ixnode\PhpException\Type\TypeInvalidException;
use PHPUnit\Framework\TestCase;

/**
 * Class CheckerTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @link Checker
 */
final class CheckerTest extends TestCase
{
    /**
     * Test wrapper (Checker::checkX).
     *
     * @dataProvider dataProviderCheck
     *
     * @test
     * @testdox $number) Test Checker::checkX
     * @param int $number
     * @param string $method
     * @param mixed $data
     * @param class-string<TypeInvalidException>|null $exceptionClass
     * @throws TypeInvalidException
     */
    public function wrapperCheck(int $number, string $method, mixed $data, ?string $exceptionClass): void
    {
        /* Arrange */
        if ($exceptionClass !== null) {
            $this->expectException($exceptionClass);
        }

        /* Act */
        $checker = new Checker($data);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertTrue(
            method_exists($checker, $method),
            sprintf('Class does not have method "%s".', $method)
        );
        $this->assertEquals($data, $checker->{$method}());
    }

    /**
     * Data provider (Checker::checkX).
     *
     * @return array<int, array{int, string, mixed, null|string}>
     * @link Checker::checkArray()
     * @link Checker::checkString()
     */
    public function dataProviderCheck(): array
    {
        $number = 0;

        return [
            /* array checks */
            [++$number, 'checkArray', [], null, ],
            [++$number, 'checkArray', [1, 2, 3, ], null, ],
            [++$number, 'checkArray', null, TypeInvalidException::class, ],

            /* string checks */
            [++$number, 'checkString', '', null, ],
            [++$number, 'checkString', null, TypeInvalidException::class, ],
        ];
    }
}
