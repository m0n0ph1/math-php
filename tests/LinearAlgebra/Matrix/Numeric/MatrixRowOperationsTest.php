<?php

    namespace MathPHP\Tests\LinearAlgebra\Matrix\Numeric;

    use MathPHP\Exception;
    use MathPHP\LinearAlgebra\MatrixFactory;
    use MathPHP\LinearAlgebra\Vector;
    use PHPUnit\Framework\TestCase;

    class MatrixRowOperationsTest extends TestCase {
        public static function dataProviderForRowMultiply(): array
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
                        [5, 10, 15],
                        [2, 3, 4],
                        [3, 4, 5],
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
                        [1, 2, 3],
                        [8, 12, 16],
                        [3, 4, 5],
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
                        [1, 2, 3],
                        [2, 3, 4],
                        [24, 32, 40],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    2.3,
                    [
                        [2.3, 4.6, 6.9],
                        [2, 3, 4],
                        [3, 4, 5],
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
                        [0, 0, 0],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                ],
            ];
        }

        public static function dataProviderForRowDivide(): array
        {
            return [
                [
                    [
                        [2, 4, 8],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    2,
                    [
                        [1, 2, 4],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                ],
                [
                    [
                        [2, 4, 8],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    2.1,
                    [
                        [
                            0.952380952380952,
                            1.904761904761905,
                            3.80952380952381,
                        ],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                ],
            ];
        }

        public static function dataProviderForRowAdd(): array
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
                        [1, 2, 3],
                        [4, 7, 10],
                        [3, 4, 5],
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
                        [1, 2, 3],
                        [2, 3, 4],
                        [9, 13, 17],
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
                        [1, 2, 3],
                        [2, 3, 4],
                        [7, 12, 17],
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
                    2.1,
                    [
                        [1, 2, 3],
                        [4.1, 7.2, 10.3],
                        [3, 4, 5],
                    ],
                ],
            ];
        }

        public static function dataProviderForRowAddScalar(): array
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
                        [6, 7, 8],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    5.3,
                    [
                        [6.3, 7.3, 8.3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                ],
            ];
        }

        public static function dataProviderForRowAddVector(): array
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
                        [1, 2],
                    ],
                    0,
                    [2, 5],
                    [
                        [3, 7],
                    ],
                ],
                [
                    [
                        [1],
                        [2],
                    ],
                    0,
                    [2],
                    [
                        [3],
                        [2],
                    ],
                ],
                [
                    [
                        [1],
                        [2],
                    ],
                    1,
                    [2],
                    [
                        [1],
                        [4],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [4, 5],
                    ],
                    0,
                    [2, 4],
                    [
                        [3, 6],
                        [4, 5],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [4, 5],
                    ],
                    1,
                    [2, 4],
                    [
                        [1, 2],
                        [6, 9],
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
                        [2, 4, 6],
                        [2, 3, 4],
                        [3, 4, 5],
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
                        [1, 2, 3],
                        [2, 3, 4],
                        [9, 13, 17],
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
                        [1, 2, 3],
                        [2, 3, 4],
                        [7, 12, 17],
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
                        [1, 2, 3],
                        [4.2, 6.3, 8.4],
                        [3, 4, 5],
                    ],
                ],
            ];
        }

        public static function dataProviderForRowSubtract(): array
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
                        [1, 2, 3],
                        [0, -1, -2],
                        [3, 4, 5],
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
                        [1, 2, 3],
                        [2, 3, 4],
                        [-3, -5, -7],
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
                        [1, 2, 3],
                        [2, 3, 4],
                        [-1, -4, -7],
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
                    2.6,
                    [
                        [1, 2, 3],
                        [-0.6, -2.2, -3.8],
                        [3, 4, 5],
                    ],
                ],
            ];
        }

        public static function dataProviderForRowSubtractScalar(): array
        {
            return [
                [
                    [
                        [6, 7, 8],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    5,
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                ],
                [
                    [
                        [6, 7, 8],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    0,
                    5.2,
                    [
                        [0.8, 1.8, 2.8],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                ],
            ];
        }

        /**
         * @test         rowMultiply
         * @dataProvider dataProviderForRowMultiply
         *
         * @param array $A
         * @param int   $mᵢ
         * @param float $k
         * @param array $expectedMatrix
         *
         * @throws       \Exception
         */
        public function testRowMultiply(
            array $A,
            int $mᵢ,
            float $k,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::create(A: $A);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->rowMultiply(mᵢ: $mᵢ, k: $k);

            // Then
            $this->assertEqualsWithDelta($expectedMatrix, $R, 0.00001);
        }

        /**
         * @test  rowMultiply on a row greater than m
         * @throws \Exception
         */
        public function testRowMultiplyExceptionRowGreaterThanM()
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
            $A->rowMultiply(mᵢ: 4, k: 5);
        }

        /**
         * @test         rowDivide
         * @dataProvider dataProviderForRowDivide
         *
         * @param array $A
         * @param int   $mᵢ
         * @param float $k
         * @param array $expectedMatrix
         *
         * @throws       \Exception
         */
        public function testRowDivide(
            array $A,
            int $mᵢ,
            float $k,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::create(A: $A);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->rowDivide(mᵢ: $mᵢ, k: $k);

            // Then
            $this->assertEqualsWithDelta($expectedMatrix, $R, 0.00001);
        }

        /**
         * @test   rowDivide row greater than M
         * @throws \Exception
         */
        public function testRowDivideExceptionRowGreaterThanM()
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
            $A->rowDivide(mᵢ: 4, k: 5);
        }

        /**
         * @test   rowDivide K is zero
         * @throws \Exception
         */
        public function testRowDivideExceptionKIsZero()
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
            $A->rowDivide(mᵢ: 2, k: 0);
        }

        /**
         * @test         rowAdd
         * @dataProvider dataProviderForRowAdd
         *
         * @param array $A
         * @param int   $mᵢ
         * @param int   $mⱼ
         * @param float $k
         * @param array $expectedMatrix
         *
         * @throws      \Exception
         */
        public function testRowAdd(
            array $A,
            int $mᵢ,
            int $mⱼ,
            float $k,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::create(A: $A);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->rowAdd(mᵢ: $mᵢ, mⱼ: $mⱼ, k: $k);

            // Then
            $this->assertEquals($expectedMatrix, $R);
        }

        /**
         * @test   rowAdd row greater than m
         * @throws \Exception
         */
        public function testRowAddExceptionRowGreaterThanM()
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
            $A->rowAdd(mᵢ: 4, mⱼ: 5, k: 2);
        }

        /**
         * @test   rowAdd k is zero
         * @throws \Exception
         */
        public function testRowAddExceptionKIsZero()
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
            $A->rowAdd(mᵢ: 1, mⱼ: 2, k: 0);
        }

        /**
         * @test         rowAddScalar
         * @dataProvider dataProviderForRowAddScalar
         *
         * @param array $A
         * @param int   $mᵢ
         * @param float $k
         * @param array $expectedMatrix
         *
         * @throws      \Exception
         */
        public function testRowAddScalar(
            array $A,
            int $mᵢ,
            float $k,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::create(A: $A);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->rowAddScalar(mᵢ: $mᵢ, k: $k);

            // Then
            $this->assertEquals($expectedMatrix, $R);
        }

        /**
         * @test  rowAddScalar row greater than m
         * @throws \Exception
         */
        public function testRowAddScalarExceptionRowGreaterThanM()
        {
            // Given
            $A = MatrixFactory::create(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // Then
            $A->rowAddScalar(mᵢ: 4, k: 5);
        }

        /**
         * @test         rowAddVector
         * @dataProvider dataProviderForRowAddVector
         *
         * @param array $A
         * @param int   $mᵢ
         * @param array $vector
         * @param array $expectedMatrix
         *
         * @throws      \Exception
         */
        public function testRowAddVector(
            array $A,
            int $mᵢ,
            array $vector,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::createNumeric(A: $A);
            $V = new Vector(A: $vector);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->rowAddVector(mᵢ: $mᵢ, V: $V);

            // Then
            $this->assertEquals($expectedMatrix, $R);
        }

        /**
         * @test   rowAddVector test row m exists
         * @throws \Exception
         */
        public function testRowAddVectorExceptionRowExists()
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
            $A->rowAddVector(mᵢ: 4, V: $b);
        }

        /**
         * @test   rowAddVector test vector->count() === matrix m
         * @throws \Exception
         */
        public function testRowAddVectorExceptionElementMismatch()
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
            $A->rowAddVector(mᵢ: 1, V: $b);
        }

        /**
         * @test         rowSubtract
         * @dataProvider dataProviderForRowSubtract
         *
         * @param array $A
         * @param int   $mᵢ
         * @param int   $mⱼ
         * @param float $k
         * @param array $expectedMatrix
         *
         * @throws       \Exception
         */
        public function testRowSubtract(
            array $A,
            int $mᵢ,
            int $mⱼ,
            float $k,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::create(A: $A);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->rowSubtract(mᵢ: $mᵢ, mⱼ: $mⱼ, k: $k);

            // Then
            $this->assertEqualsWithDelta($expectedMatrix, $R, 0.00001);
        }

        /**
         * @test   rowSubtract row greater than m
         * @throws \Exception
         */
        public function testRowSubtractExceptionRowGreaterThanM()
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
            $A->rowSubtract(mᵢ: 4, mⱼ: 5, k: 2);
        }

        /**
         * @test         rowSubtractScalar
         * @dataProvider dataProviderForRowSubtractScalar
         *
         * @param array $A
         * @param int   $mᵢ
         * @param float $k
         * @param array $expectedMatrix
         *
         * @throws      \Exception
         */
        public function testRowSubtractScalar(
            array $A,
            int $mᵢ,
            float $k,
            array $expectedMatrix
        ) {
            // Given
            $A = MatrixFactory::create(A: $A);
            $expectedMatrix = MatrixFactory::create(A: $expectedMatrix);

            // When
            $R = $A->rowSubtractScalar(mᵢ: $mᵢ, k: $k);

            // Then
            $this->assertEqualsWithDelta($expectedMatrix, $R, 0.00001);
        }

        /**
         * @test   rowSubtractScalar row greater than m
         * @throws \Exception
         */
        public function testRowSubtractScalarExceptionRowGreaterThanM()
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
            $A->rowSubtractScalar(mᵢ: 4, k: 5);
        }
    }
