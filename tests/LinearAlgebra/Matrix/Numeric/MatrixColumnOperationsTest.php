<?php

    namespace MathPHP\Tests\LinearAlgebra\Matrix\Numeric;

    use MathPHP\Exception;
    use MathPHP\LinearAlgebra\MatrixFactory;
    use MathPHP\LinearAlgebra\Vector;
    use PHPUnit\Framework\TestCase;

    class MatrixColumnOperationsTest extends TestCase {
        public static function dataProviderForColumnMultiply(): array
        {
            return [
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    5,
                    [
                        [5, 2, 3],
                        [10, 3, 4],
                        [15, 4, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    1,
                    4,
                    [
                        [1, 8, 3],
                        [2, 12, 4],
                        [3, 16, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    2,
                    8,
                    [
                        [1, 2, 24],
                        [2, 3, 32],
                        [3, 4, 40],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    5.1,
                    [
                        [5.1, 2, 3],
                        [10.2, 3, 4],
                        [15.3, 4, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    0,
                    [
                        [0, 2, 3],
                        [0, 3, 4],
                        [0, 4, 5],
                    ],
                ],
            ];
        }

        public static function dataProviderForColumnAdd(): array
        {
            return [
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    1,
                    2,
                    [
                        [1, 4, 3],
                        [2, 7, 4],
                        [3, 10, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    1,
                    2,
                    3,
                    [
                        [1, 2, 9],
                        [2, 3, 13],
                        [3, 4, 17],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    2,
                    4,
                    [
                        [1, 2, 7],
                        [2, 3, 12],
                        [3, 4, 17],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    1,
                    2.2,
                    [
                        [1, 4.2, 3],
                        [2, 7.4, 4],
                        [3, 10.6, 5],
                    ],
                ],
            ];
        }

        public static function dataProviderForColumnAddVector(): array
        {
            return [
                [
                    [
                        [1],
                    ],
                    0,
                    [2],
                    [
                        [3],
                    ],
                ],
                [
                    [
                        [1],
                        [2],
                    ],
                    0,
                    [2, 5],
                    [
                        [3],
                        [7],
                    ],
                ],
                [
                    [
                        [1, 2],
                    ],
                    0,
                    [2],
                    [
                        [3, 2],
                    ],
                ],
                [
                    [
                        [1, 2],
                    ],
                    1,
                    [2],
                    [
                        [1, 4],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [3, 4],
                    ],
                    0,
                    [2, 5],
                    [
                        [3, 2],
                        [8, 4],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [3, 4],
                    ],
                    1,
                    [2, 5],
                    [
                        [1, 4],
                        [3, 9],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    [1, 2, 3],
                    [
                        [2, 2, 3],
                        [4, 3, 4],
                        [6, 4, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    2,
                    [6, 9, 12],
                    [
                        [1, 2, 9],
                        [2, 3, 13],
                        [3, 4, 17],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    2,
                    [4, 8, 12],
                    [
                        [1, 2, 7],
                        [2, 3, 12],
                        [3, 4, 17],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    1,
                    [2.2, 3.3, 4.4],
                    [
                        [1, 4.2, 3],
                        [2, 6.3, 4],
                        [3, 8.4, 5],
                    ],
                ],
            ];
        }

        /**
         * @test         columnMultiply
         * @dataProvider dataProviderForColumnMultiply
         *
         * @param array $A
         * @param int   $nᵢ
         * @param float $k
         * @param array $expectedMatrix
         *
         * @throws       \Exception
         */
        public function testColumnMultiply(
            array $A,
            int $nᵢ,
            float $k,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::create(A: $A);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->columnMultiply(nᵢ: $nᵢ, k: $k);

            // Then
            $this->assertEqualsWithDelta($expectedMatrix, $R, 0.00001);
        }

        /**
         * @test  columnMultiply column greater than n
         * @throws \Exception
         */
        public function testColumnMultiplyExceptionColumnGreaterThanN()
        {
            // Given
            $A = MatrixFactory::create(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $A->columnMultiply(nᵢ: 4, k: 5);
        }

        /**
         * @test         columnAdd
         * @dataProvider dataProviderForColumnAdd
         *
         * @param array $A
         * @param int   $nᵢ
         * @param int   $nⱼ
         * @param float $k
         * @param array $expectedMatrix
         *
         * @throws      \Exception
         */
        public function testColumnAdd(
            array $A,
            int $nᵢ,
            int $nⱼ,
            float $k,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::create(A: $A);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->columnAdd(nᵢ: $nᵢ, nⱼ: $nⱼ, k: $k);

            // Then
            $this->assertEqualsWithDelta($expectedMatrix, $R, 0.00001);
        }

        /**
         * @test   columnAdd row greater than n
         * @throws \Exception
         */
        public function testColumnAddExceptionRowGreaterThanN()
        {
            // Given
            $A = MatrixFactory::create(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $A->columnAdd(nᵢ: 4, nⱼ: 5, k: 2);
        }

        /**
         * @test   columnAdd k is zero
         * @throws \Exception
         */
        public function testColumnAddExceptionKIsZero()
        {
            // Given
            $A = MatrixFactory::create(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);

            // Then
            $this->expectException(Exception\BadParameterException::class);

            // When
            $A->columnAdd(nᵢ: 1, nⱼ: 2, k: 0);
        }

        /**
         * @test         columnAddVector
         * @dataProvider dataProviderForColumnAddVector
         *
         * @param array $A
         * @param int   $nᵢ
         * @param array $vector
         * @param array $expectedMatrix
         *
         * @throws      \Exception
         */
        public function testColumnAddVector(
            array $A,
            int $nᵢ,
            array $vector,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::createNumeric(A: $A);
            $V = new Vector(A: $vector);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->columnAddVector(nᵢ: $nᵢ, V: $V);

            // Then
            $this->assertEquals($expectedMatrix, $R);
        }

        /**
         * @test   columnAddVector test column n exists
         * @throws \Exception
         */
        public function testColumnAddVectorExceptionColumnExists()
        {
            // Given
            $A = MatrixFactory::createNumeric(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);

            $b = new Vector(A: [1, 2, 3]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $A->columnAddVector(nᵢ: 4, V: $b);
        }

        /**
         * @test   columnAddVector test Vector->count() === matrix->m
         * @throws \Exception
         */
        public function testColumnAddVectorExceptionElementMismatch()
        {
            // Given
            $A = MatrixFactory::createNumeric(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);

            $b = new Vector(A: [1, 2, 3, 4]);

            // Then
            $this->expectException(Exception\BadParameterException::class);

            // When
            $A->columnAddVector(nᵢ: 1, V: $b);
        }
    }
