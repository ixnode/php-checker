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

use Ixnode\PhpChecker\CheckerArray;
use Ixnode\PhpException\ArrayType\ArrayKeyNotFoundException;
use Ixnode\PhpException\Type\TypeInvalidException;
use PHPUnit\Framework\TestCase;

/**
 * Class CheckerArrayTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @link CheckerArray
 */
final class CheckerArrayTest extends TestCase
{
    /**
     * Test wrapper (CheckerClass::checkX).
     *
     * @dataProvider dataProviderCheck
     *
     * @test
     * @testdox $number) Test CheckerClass::checkX
     * @param int $number
     * @param string $method
     * @param mixed $data
     * @param mixed $parameter1
     * @param mixed $parameter2
     * @param mixed $expected
     * @param class-string<TypeInvalidException>|null $exceptionClass
     * @throws TypeInvalidException
     * @link CheckerClass
     */
    public function wrapperCheck(int $number, string $method, mixed $data, mixed $parameter1, mixed $parameter2, mixed $expected, ?string $exceptionClass): void
    {
        /* Arrange */
        if ($exceptionClass !== null) {
            $this->expectException($exceptionClass);
        }

        /* Act */
        $checker = new CheckerArray($data);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertTrue(
            method_exists($checker, $method),
            sprintf('Class does not have method "%s".', $method)
        );

        $value = match (true) {
            !is_null($parameter2) => $checker->{$method}($parameter1, $parameter2),
            !is_null($parameter1) => $checker->{$method}($parameter1),
            default => $checker->{$method}(),
        };

        $this->assertEquals($expected, $value);
    }

    /**
     * Data provider (CheckerClass::checkX).
     *
     * @return array<int, array{int, string, mixed, mixed, mixed, mixed, null|string}>
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function dataProviderCheck(): array
    {
        $number = 0;

        return [
            /* checkIndex */
            [++$number, 'checkIndex', [1, 2, 3, ], '0', null, 1, null, ],
            [++$number, 'checkIndex', [1, 2, 3, ], '10', null, 1, ArrayKeyNotFoundException::class, ],

            /* checkIndexString */
            [++$number, 'checkIndexString', ['1', '2', '3', ], '0', null, '1', null, ],
            [++$number, 'checkIndexString', [1, 2, 3, ], '0', null, 1, TypeInvalidException::class, ],

            /* checkIndexStringOrNull */
            [++$number, 'checkIndexStringOrNull', ['1', '2', '3', ], '0', null, '1', null, ],
            [++$number, 'checkIndexStringOrNull', [null, null, null, ], '0', null, null, null, ],
            [++$number, 'checkIndexStringOrNull', [1, 2, 3, ], '0', null, 1, TypeInvalidException::class, ],

            /* checkIndexArray */
            [++$number, 'checkIndexArray', [[1, ], [2, ], [3, ], ], '0', null, [1, ], null, ],
            [++$number, 'checkIndexArray', [1, 2, 3, ], '0', null, 1, TypeInvalidException::class, ],

            /* checkIndexArray */
            [++$number, 'checkIndexStringArray', [['1', '2', '3', ], ['2', ], ['3', ], ], '0', null, ['1', '2', '3', ], null, ],
            [++$number, 'checkIndexStringArray', [['1', 2, 3, ], ['2', ], ['3', ], ], '0', null, ['1', 2, 3, ], TypeInvalidException::class, ],
            [++$number, 'checkIndexStringArray', [1, 2, 3, ], '0', null, 1, TypeInvalidException::class, ],

            /* checkIndexArrayArray */
            [
                ++$number,
                'checkIndexArrayArray',
                [
                    [
                        ['title' => 'Title 1', 'text' => 'Text 1', 'description' => 'Description 1', ],
                        ['title' => 'Title 2', 'text' => 'Text 2', 'description' => 'Description 2', ],
                    ],
                ],
                '0',
                null,
                [
                    ['title' => 'Title 1', 'text' => 'Text 1', 'description' => 'Description 1', ],
                    ['title' => 'Title 2', 'text' => 'Text 2', 'description' => 'Description 2', ],
                ],
                null,
            ],
            [
                ++$number,
                'checkIndexArrayArray',
                [
                    [
                        ['title' => 'Title 1', 'text' => 'Text 1', 'description' => 'Description 1', ],
                        ['title' => 'Title 2', 'text' => 'Text 2', 'description' => 'Description 2', ],
                    ],
                ],
                '0',
                ['title', 'text', ],
                [
                    ['title' => 'Title 1', 'text' => 'Text 1', ],
                    ['title' => 'Title 2', 'text' => 'Text 2', ],
                ],
                null,
            ],
            [
                ++$number,
                'checkIndexArrayArray',
                [
                    [
                        ['title' => 'Title 1', 'text' => 'Text 1', 'description' => 'Description 1', ],
                        ['title' => 'Title 2', 'text' => 'Text 2', 'description' => 'Description 2', ],
                    ],
                ],
                '0',
                ['title', ],
                [
                    ['title' => 'Title 1', ],
                    ['title' => 'Title 2', ],
                ],
                null,
            ],
            [
                ++$number,
                'checkIndexArrayArray',
                [
                    [
                        1,
                        2,
                    ],
                ],
                '0',
                ['test', ],
                [
                    1,
                    2,
                ],
                TypeInvalidException::class,
            ],

            /* checkIndexInteger */
            [++$number, 'checkIndexInteger', [1, 2, 3, ], '0', null, 1, null, ],
            [++$number, 'checkIndexInteger', ['1', '2', '3', ], '0', null, '1', TypeInvalidException::class, ],
            [++$number, 'checkIndexInteger', ['1', '2', '3', ], '3', null, '3', ArrayKeyNotFoundException::class, ],

        ];
    }
}
