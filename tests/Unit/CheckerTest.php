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
use Ixnode\PhpException\Class\ClassInvalidException;
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
     * @param mixed $parameter
     * @param class-string<TypeInvalidException>|null $exceptionClass
     * @throws TypeInvalidException
     */
    public function wrapperCheck(int $number, string $method, mixed $data, mixed $parameter, ?string $exceptionClass): void
    {
        /* Arrange */
        if (!is_null($exceptionClass)) {
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

        $value = match (true) {
            !is_null($parameter) => $checker->{$method}($parameter),
            default => $checker->{$method}(),
        };

        $this->assertEquals($data, $value);
    }

    /**
     * Data provider (Checker::checkX).
     *
     * @return array<int, array{int, string, mixed, mixed, null|string}>
     * @link Checker::checkArray()
     * @link Checker::checkString()
     */
    public function dataProviderCheck(): array
    {
        $number = 0;

        return [
            /* array checks */
            [++$number, 'checkArray', [], null, null, ],
            [++$number, 'checkArray', [1, 2, 3, ], null, null, ],
            [++$number, 'checkArray', null, null, TypeInvalidException::class, ],

            /* array class */
            [++$number, 'checkClass', new Checker(123), Checker::class, null, ],
            [++$number, 'checkClass', 'checker', Checker::class, TypeInvalidException::class, ],
            [++$number, 'checkClass', new Checker(123), CheckerClassTest::class, ClassInvalidException::class, ],

            /* float checks */
            [++$number, 'checkFloat', .0, null, null, ],
            [++$number, 'checkFloat', '.0', null, TypeInvalidException::class, ],

            /* integer checks */
            [++$number, 'checkInteger', 0, null, null, ],
            [++$number, 'checkInteger', '0', null, TypeInvalidException::class, ],

            /* iterable checks */
            [++$number, 'checkIterable', [], null, null, ],
            [++$number, 'checkIterable', '0', null, TypeInvalidException::class, ],

            /* json checks */
            [++$number, 'checkJson', '{}', null, null, ],
            [++$number, 'checkJson', 'some text', null, TypeInvalidException::class, ],

            /* object checks */
            [++$number, 'checkObject', new Checker(123), null, null, ],
            [++$number, 'checkObject', (object) [], null, null, ],
            [++$number, 'checkObject', 'some text', null, TypeInvalidException::class, ],

            /* stdClass checks */
            [++$number, 'checkStdClass', (object) [], null, null, ],
            [++$number, 'checkStdClass', 'some text', null, TypeInvalidException::class, ],

            /* string checks */
            [++$number, 'checkString', '', null, null, ],
            [++$number, 'checkString', null, null, TypeInvalidException::class, ],

            /* string checks */
            [++$number, 'checkStringOrNull', '', null, null, ],
            [++$number, 'checkStringOrNull', null, null, null, ],
            [++$number, 'checkStringOrNull', .0, null, TypeInvalidException::class, ],
        ];
    }
}
