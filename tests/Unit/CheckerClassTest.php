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
use Ixnode\PhpChecker\CheckerClass;
use Ixnode\PhpException\Class\ClassInvalidException;
use Ixnode\PhpException\Type\TypeInvalidException;
use PHPUnit\Framework\TestCase;

/**
 * Class CheckerClassTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @link CheckerClass
 */
final class CheckerClassTest extends TestCase
{
    /**
     * @dataProvider dataProviderCheck
     *
     * @test
     * @testdox $number) Test CheckerClass::checkX
     * @param int $number
     * @param string $method
     * @param mixed $data
     * @param class-string|null $className
     * @param class-string<TypeInvalidException>|null $exceptionClass
     * @throws TypeInvalidException
     * @link CheckerClass
     */
    public function wrapperCheck(int $number, string $method, mixed $data, string|null $className, string|null $exceptionClass): void
    {
        /* Arrange */
        if ($exceptionClass !== null) {
            $this->expectException($exceptionClass);
        }

        /* Act */
        $checker = new CheckerClass($data);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertTrue(
            method_exists($checker, $method),
            sprintf('Class does not have method "%s".', $method)
        );
        match (true) {
            $className !== null => $this->assertEquals($data, $checker->{$method}($className)),
            default => $this->assertEquals($data, $checker->{$method}())
        };
    }

    /**
     * Data provider (CheckerClass::checkX).
     *
     * @return array<int, array{int, string, mixed, class-string|null, null|string}>
     * @link CheckerClass::checkGiven()
     * @link CheckerClass::checkStdClass()
     */
    public function dataProviderCheck(): array
    {
        $number = 0;

        return [
            /* class given checks */
            [++$number, 'checkGiven', new Checker(123), Checker::class, null, ],
            [++$number, 'checkGiven', 'checker', Checker::class, TypeInvalidException::class, ],
            [++$number, 'checkGiven', new Checker(123), CheckerClassTest::class, ClassInvalidException::class, ],

            /* stdClass checks */
            [++$number, 'checkStdClass', (object)[], null, null, ],
            [++$number, 'checkStdClass', null, null, TypeInvalidException::class, ],
        ];
    }
}
