<?php

    namespace MathPHP\Tests\LinearAlgebra\Matrix;

    use MathPHP\Exception;
    use MathPHP\LinearAlgebra\ComplexMatrix;
    use MathPHP\LinearAlgebra\FunctionMatrix;
    use MathPHP\LinearAlgebra\Matrix;
    use MathPHP\LinearAlgebra\MatrixFactory;
    use MathPHP\LinearAlgebra\NumericDiagonalMatrix;
    use MathPHP\LinearAlgebra\NumericMatrix;
    use MathPHP\LinearAlgebra\NumericSquareMatrix;
    use MathPHP\LinearAlgebra\ObjectMatrix;
    use MathPHP\LinearAlgebra\ObjectSquareMatrix;
    use MathPHP\LinearAlgebra\Vector;
    use MathPHP\Tests\LinearAlgebra\Fixture\MatrixDataProvider;
    use PHPUnit\Framework\TestCase;

    use function is_int;

    class MatrixFactoryTest extends TestCase {
        use MatrixDataProvider;

        public static function dataProviderForDiagonalMatrix(): array
        {
            return [
                [[1]],
                [[1, 2]],
                [[1, 2, 3]],
                [[1, 2, 3, 4]],
            ];
        }

        public static function dataProviderFromArrayOfVectors(): array
        {
            return [
                [
                    [
                        [1, 2],
                    ],
                    [
                        [1],
                        [2],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [3, 4],
                    ],
                    [
                        [1, 3],
                        [2, 4],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [3, 4],
                        [5, 6],
                    ],
                    [
                        [1, 3, 5],
                        [2, 4, 6],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [3, 4, 5],
                        [5, 6, 6],
                    ],
                    [
                        [1, 3, 5],
                        [2, 4, 6],
                        [3, 5, 6],
                    ],
                ],
            ];
        }

        public static function dataProviderForFunctionSquareMatrix(): array
        {
            $function = fn($x) => $x * 2;

            return [
                [
                    [
                        [$function],
                    ],
                ],
                [
                    [
                        [$function, $function],
                        [$function, $function],
                    ],
                ],
                [
                    [
                        [$function, $function, $function],
                        [$function, $function, $function],
                        [$function, $function, $function],
                    ],
                ],
            ];
        }

        public static function dataProviderForFunctionMatrix(): array
        {
            $function = fn($x) => $x * 2;

            return [
                [
                    [
                        [$function, $function],
                    ],
                ],
                [
                    [
                        [$function, $function],
                        [$function, $function],
                        [$function, $function],
                    ],
                ],
                [
                    [
                        [$function, $function, $function],
                        [$function, $function, $function],
                        [$function, $function, $function],
                        [$function, $function, $function],
                    ],
                ],
            ];
        }

        public static function dataProviderForMatrix(): array
        {
            return [
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                        [4, 5, 6],
                    ],
                ],
            ];
        }

        public static function dataProviderForIdentity(): array
        {
            return [
                [
                    1,
                    [[1]],
                ],
                [
                    2,
                    [
                        [1, 0],
                        [0, 1],
                    ],
                ],
                [
                    3,
                    [
                        [1, 0, 0],
                        [0, 1, 0],
                        [0, 0, 1],
                    ],
                ],
                [
                    4,
                    [
                        [1, 0, 0, 0],
                        [0, 1, 0, 0],
                        [0, 0, 1, 0],
                        [0, 0, 0, 1],
                    ],
                ],
            ];
        }

        /**
         * @return array [n, R]
         */
        public static function dataProviderForDownshiftPermutation(): array
        {
            return [
                [
                    1,
                    [
                        [1],
                    ],
                ],
                [
                    2,
                    [
                        [0, 1],
                        [1, 0],
                    ],
                ],
                [
                    3,
                    [
                        [0, 0, 1],
                        [1, 0, 0],
                        [0, 1, 0],
                    ],
                ],
                [
                    4,
                    [
                        [0, 0, 0, 1],
                        [1, 0, 0, 0],
                        [0, 1, 0, 0],
                        [0, 0, 1, 0],
                    ],
                ],
            ];
        }

        /**
         * @return array [n, R]
         */
        public static function dataProviderForUpshiftPermutation(): array
        {
            return [
                [
                    1,
                    [
                        [1],
                    ],
                ],
                [
                    2,
                    [
                        [0, 1],
                        [1, 0],
                    ],
                ],
                [
                    3,
                    [
                        [0, 1, 0],
                        [0, 0, 1],
                        [1, 0, 0],
                    ],
                ],
                [
                    4,
                    [
                        [0, 1, 0, 0],
                        [0, 0, 1, 0],
                        [0, 0, 0, 1],
                        [1, 0, 0, 0],
                    ],
                ],
            ];
        }

        public static function dataProviderForExchange(): array
        {
            return [
                [
                    1,
                    [[1]],
                ],
                [
                    2,
                    [
                        [0, 1],
                        [1, 0],
                    ],
                ],
                [
                    3,
                    [
                        [0, 0, 1],
                        [0, 1, 0],
                        [1, 0, 0],
                    ],
                ],
                [
                    4,
                    [
                        [0, 0, 0, 1],
                        [0, 0, 1, 0],
                        [0, 1, 0, 0],
                        [1, 0, 0, 0],
                    ],
                ],
            ];
        }

        public static function dataProviderForZero(): array
        {
            return [
                [
                    1,
                    1,
                    [[0]],
                ],
                [
                    2,
                    2,
                    [
                        [0, 0],
                        [0, 0],
                    ],
                ],
                [
                    3,
                    3,
                    [
                        [0, 0, 0],
                        [0, 0, 0],
                        [0, 0, 0],
                    ],
                ],
                [
                    2,
                    3,
                    [
                        [0, 0, 0],
                        [0, 0, 0],
                    ],
                ],
                [
                    3,
                    2,
                    [
                        [0, 0],
                        [0, 0],
                        [0, 0],
                    ],
                ],
            ];
        }

        public static function dataProviderForOne(): array
        {
            return [
                [
                    1,
                    1,
                    [[1]],
                ],
                [
                    2,
                    2,
                    [
                        [1, 1],
                        [1, 1],
                    ],
                ],
                [
                    3,
                    3,
                    [
                        [1, 1, 1],
                        [1, 1, 1],
                        [1, 1, 1],
                    ],
                ],
                [
                    2,
                    3,
                    [
                        [1, 1, 1],
                        [1, 1, 1],
                    ],
                ],
                [
                    3,
                    2,
                    [
                        [1, 1],
                        [1, 1],
                        [1, 1],
                    ],
                ],
            ];
        }

        public static function dataProviderForEye(): array
        {
            return [
                [
                    1,
                    1,
                    0,
                    1,
                    [
                        [1],
                    ],
                ],
                [
                    1,
                    1,
                    0,
                    9,
                    [
                        [9],
                    ],
                ],
                [
                    2,
                    2,
                    0,
                    1,
                    [
                        [1, 0],
                        [0, 1],
                    ],
                ],
                [
                    2,
                    2,
                    1,
                    1,
                    [
                        [0, 1],
                        [0, 0],
                    ],
                ],
                [
                    3,
                    3,
                    0,
                    1,
                    [
                        [1, 0, 0],
                        [0, 1, 0],
                        [0, 0, 1],
                    ],
                ],
                [
                    3,
                    3,
                    1,
                    1,
                    [
                        [0, 1, 0],
                        [0, 0, 1],
                        [0, 0, 0],
                    ],
                ],
                [
                    3,
                    3,
                    2,
                    1,
                    [
                        [0, 0, 1],
                        [0, 0, 0],
                        [0, 0, 0],
                    ],
                ],
                [
                    3,
                    3,
                    0,
                    9,
                    [
                        [9, 0, 0],
                        [0, 9, 0],
                        [0, 0, 9],
                    ],
                ],
                [
                    3,
                    3,
                    1,
                    9,
                    [
                        [0, 9, 0],
                        [0, 0, 9],
                        [0, 0, 0],
                    ],
                ],
                [
                    3,
                    3,
                    0,
                    -9,
                    [
                        [-9, 0, 0],
                        [0, -9, 0],
                        [0, 0, -9],
                    ],
                ],
                [
                    3,
                    4,
                    0,
                    1,
                    [
                        [1, 0, 0, 0],
                        [0, 1, 0, 0],
                        [0, 0, 1, 0],
                    ],
                ],
                [
                    3,
                    4,
                    1,
                    1,
                    [
                        [0, 1, 0, 0],
                        [0, 0, 1, 0],
                        [0, 0, 0, 1],
                    ],
                ],
                [
                    3,
                    4,
                    2,
                    1,
                    [
                        [0, 0, 1, 0],
                        [0, 0, 0, 1],
                        [0, 0, 0, 0],
                    ],
                ],
                [
                    3,
                    4,
                    3,
                    1,
                    [
                        [0, 0, 0, 1],
                        [0, 0, 0, 0],
                        [0, 0, 0, 0],
                    ],
                ],
                [
                    3,
                    4,
                    1,
                    9,
                    [
                        [0, 9, 0, 0],
                        [0, 0, 9, 0],
                        [0, 0, 0, 9],
                    ],
                ],
                [
                    4,
                    3,
                    0,
                    1,
                    [
                        [1, 0, 0],
                        [0, 1, 0],
                        [0, 0, 1],
                        [0, 0, 0],
                    ],
                ],
                [
                    4,
                    3,
                    1,
                    1,
                    [
                        [0, 1, 0],
                        [0, 0, 1],
                        [0, 0, 0],
                        [0, 0, 0],
                    ],
                ],
                [
                    4,
                    3,
                    2,
                    1,
                    [
                        [0, 0, 1],
                        [0, 0, 0],
                        [0, 0, 0],
                        [0, 0, 0],
                    ],
                ],
            ];
        }

        public static function dataProviderForEyeExceptions(): array
        {
            return [
                [-1, 2, 1, 1],
                [2, -1, 1, 1],
                [2, 2, -1, 1],
                [2, 2, 2, 1],
                [2, 2, 3, 1],
            ];
        }

        public static function dataProviderForCreateFromColumnVector(): array
        {
            return [
                [
                    [1, 2, 3, 4],
                    [
                        [1],
                        [2],
                        [3],
                        [4],
                    ],
                ],
                [
                    [1],
                    [
                        [1],
                    ],
                ],
            ];
        }

        public static function dataProviderForConstructor(): array
        {
            return [
                [
                    [1, 2, 3, 4],
                    [[1, 2, 3, 4]],
                ],
                [
                    [1],
                    [[1]],
                ],
            ];
        }

        /**
         * @test         create numeric matrix
         * @dataProvider dataProviderForSquareMatrix
         * @dataProvider dataProviderForNotSquareMatrix
         * @dataProvider dataProviderForSingularMatrix
         * @dataProvider dataProviderForNonsingularMatrix
         * @dataProvider dataProviderForMatrixWithWeirdNumbers
         */
        public function testCreateNumericMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::create($A);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertInstanceOf(NumericMatrix::class, $A);
            $this->assertInstanceOf(Matrix::class, $A);
        }

        /**
         * @test         createNumeric
         * @dataProvider dataProviderForSquareMatrix
         * @dataProvider dataProviderForNotSquareMatrix
         * @dataProvider dataProviderForSingularMatrix
         * @dataProvider dataProviderForNonsingularMatrix
         * @dataProvider dataProviderForMatrixWithWeirdNumbers
         */
        public function testSpecificallyCreateNumericMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::createNumeric($A);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertInstanceOf(NumericMatrix::class, $A);
            $this->assertInstanceOf(Matrix::class, $A);
        }

        /**
         * @test         create diagonal matrix
         * @dataProvider dataProviderForDiagonalMatrix
         */
        public function testCreateDiagonalMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::diagonal($A);
            } catch (Exception\MatrixException $e)
            {
            }

            // Then
            $this->assertInstanceOf(NumericDiagonalMatrix::class, $A);
            $this->assertInstanceOf(NumericMatrix::class, $A);
            $this->assertInstanceOf(Matrix::class, $A);
        }

        /**
         * @test         create square matrix
         * @dataProvider dataProviderForSquareMatrix
         */
        public function testCreateSquareMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::create($A);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertInstanceOf(NumericSquareMatrix::class, $A);
            $this->assertInstanceOf(NumericMatrix::class, $A);
            $this->assertInstanceOf(Matrix::class, $A);
        }

        /**
         * @test         create from array of vectors
         * @dataProvider dataProviderFromArrayOfVectors
         */
        public function testCreateArrayOfVectors(
            array $vectors,
            array $expected
        ) {
            // Given
            $array_map = array_map(function ($vector) {
                return new Vector($vector);
            }, $vectors);
            $vectors = $array_map;

            // When
            try
            {
                $A = MatrixFactory::createFromVectors($vectors);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            }

            // Then
            $this->assertInstanceOf(NumericMatrix::class, $A);
            $this->assertEquals($expected, $A->getMatrix());
        }

        /**
         * @test   create from array of vectors exception - different lengths
         * @throws \Exception
         */
        public function testCreateFromArrayOfVectorsExceptionVectorsDifferentLengths(
        )
        {
            // Given
            $A = [
                new Vector([1, 2]),
                new Vector([4, 5, 6]),
            ];

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $A = MatrixFactory::createFromVectors($A);
        }

        /**
         * @test         createFunctionMatrix
         * @dataProvider dataProviderForFunctionSquareMatrix
         */
        public function testCreateFunctionSquareMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::createFunctionMatrix($A);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->assertInstanceOf(FunctionMatrix::class,
                $A);
        }

        /**
         * @test         createFunctionMatrix
         * @dataProvider dataProviderForFunctionMatrix
         */
        public function testCreateFunctionMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::createFunctionMatrix($A);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->assertInstanceOf(FunctionMatrix::class,
                $A);
        }

        /**
         * @test createFunctionMatrix error when matrix not made of functions
         */
        public function testCreateFunctionMatrixErrorNotMadeOfFunctions()
        {
            // Given
            $A = [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ];

            // Then
            $this->expectException(Exception\BadDataException::class);

            // When
            try
            {
                $A = MatrixFactory::createFunctionMatrix($A);
            } catch (Exception\BadDataException $e)
            {
            }
        }

        /**
         * @test         create matrix
         * @dataProvider dataProviderForMatrix
         */
        public function testCreateMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::create($A);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertInstanceOf(NumericMatrix::class,
                $A);

            // And
            $this->assertNotInstanceOf(NumericSquareMatrix::class,
                $A);
            $this->assertNotInstanceOf(FunctionMatrix::class,
                $A);
            $this->assertNotInstanceOf(NumericDiagonalMatrix::class,
                $A);
        }

        /**
         * @test   check params exception for empty array
         * @throws \Exception
         */
        public function testCheckParamsExceptionEmptyArray()
        {
            // Given
            $A = [];

            // Then
            $this->expectException(Exception\BadDataException::class);

            // When
            $M = MatrixFactory::create($A);
        }

        /**
         * @test   check params exception for single dimensional array
         * @throws \Exception
         */
        public function testCheckParamsExceptionSingleDimensionalArray()
        {
            // Given
            $A = [1, 2, 3];

            // Then
            $this->expectException(Exception\BadDataException::class);

            // When
            $M = MatrixFactory::create($A);
        }

        /**
         * @test   matrix unknown type exception
         * @throws \Exception
         */
        public function testMatrixUnknownTypeException()
        {
            // Given
            $A = [
                [[1], [2], [3]],
                [[2], [3], [4]],
            ];

            // Then
            $this->expectException(Exception\IncorrectTypeException::class);

            // When
            MatrixFactory::create($A);
        }

        /**
         * @test         identity
         * @dataProvider dataProviderForIdentity
         *
         * @param int   $n
         * @param array $R
         *
         * @throws       \Exception
         */
        public function testIdentity(int $n, array $R)
        {
            // Given
            $R = new NumericSquareMatrix($R);

            // When
            $I = MatrixFactory::identity($n);

            // Then
            $this->assertEquals($R, $I);
        }

        /**
         * @test         downshiftPermutation
         * @dataProvider dataProviderForDownshiftPermutation
         *
         * @param int   $n
         * @param array $R
         *
         * @throws       \Exception
         */
        public function testDownshiftPermutation(int $n, array $R)
        {
            $R = new NumericSquareMatrix($R);
            $this->assertEquals($R, MatrixFactory::downshiftPermutation($n));
        }

        /**
         * @test         upshiftPermutation
         * @dataProvider dataProviderForUpshiftPermutation
         *
         * @param int   $n
         * @param array $R
         *
         * @throws       \Exception
         */
        public function testUpshiftPermutation(int $n, array $R)
        {
            $R = new NumericSquareMatrix($R);
            $this->assertEquals($R, MatrixFactory::upshiftPermutation($n));
        }

        /**
         * @test   identity with n less than zero
         * @throws \Exception
         */
        public function testIdentityExceptionNLessThanZero()
        {
            // Given
            $n = -1;

            // Then
            $this->expectException(Exception\OutOfBoundsException::class);

            // When
            MatrixFactory::identity($n);
        }

        /**
         * @test         exchange
         * @dataProvider dataProviderForExchange
         *
         * @param int   $n
         * @param array $R
         *
         * @throws       \Exception
         */
        public function testExchange(int $n, array $R)
        {
            // Given
            $R = new NumericSquareMatrix($R);

            // When
            $E = MatrixFactory::exchange($n);

            // Then
            $this->assertEquals($R, $E);
        }

        /**
         * @test   exchange exception - n less than zero
         * @throws \Exception
         */
        public function testExchangeExceptionNLessThanZero()
        {
            // When
            $n = -1;

            // Then
            $this->expectException(Exception\OutOfBoundsException::class);

            // When
            MatrixFactory::exchange($n);
        }

        /**
         * @test         zero
         * @dataProvider dataProviderForZero
         *
         * @param int   $m
         * @param int   $n
         * @param array $R
         *
         * @throws       \Exception
         */
        public function testZero(int $m, int $n, array $R)
        {
            // Given
            $R = MatrixFactory::create($R);

            // When
            $Z = MatrixFactory::zero($m, $n);

            // Then
            $this->assertEquals($R, $Z);
        }

        /**
         * @test   zero with row less than one
         * @throws \Exception
         */
        public function testZeroExceptionRowsLessThanOne()
        {
            // Given
            $m = 0;
            $n = 2;

            // Then
            $this->expectException(Exception\OutOfBoundsException::class);

            // When
            MatrixFactory::zero($m, $n);
        }

        /**
         * @test         one
         * @dataProvider dataProviderForOne
         */
        public function testOne($m, $n, array $R)
        {
            // Given
            try
            {
                $R = MatrixFactory::create($R);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // When
            try
            {
                $M = MatrixFactory::one($m, $n);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\OutOfBoundsException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertEquals($R, $M);
        }

        /**
         * @test   one exception - rows less than one
         * @throws \Exception
         */
        public function testOneExceptionRowsLessThanOne()
        {
            $this->expectException(Exception\OutOfBoundsException::class);
            MatrixFactory::one(0, 2);
        }

        /**
         * @test         eye
         * @dataProvider dataProviderForEye
         */
        public function testEye(int $m, int $n, int $k, int $x, array $R)
        {
            // Given
            try
            {
                $R = MatrixFactory::create($R);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // When
            try
            {
                $A = MatrixFactory::eye($m, $n, $k, $x);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\OutOfBoundsException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertEquals($R, $A);
            $this->assertEquals($R->getMatrix(), $A->getMatrix());

            // And
            $this->assertEquals($m, $R->getM());
            $this->assertEquals($n, $R->getN());
        }

        /**
         * @test         eye exceptions
         * @dataProvider dataProviderForEyeExceptions
         */
        public function testEyeExceptions(int $m, int $n, int $k, int $x)
        {
            $this->expectException(Exception\OutOfBoundsException::class);
            try
            {
                $A = MatrixFactory::eye($m, $n, $k, $x);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\OutOfBoundsException $e)
            {
            } catch (Exception\MathException $e)
            {
            }
        }

        /**
         * @test         hilbert creates the expected Hilbert matrix
         * @dataProvider dataProviderForHilbertMatrix
         *
         * @param int   $n
         * @param array $H
         *
         * @throws       \Exception
         */
        public function testHilbertMatrix(int $n, array $H)
        {
            // Given
            $H = MatrixFactory::create($H);

            // When
            $sut = MatrixFactory::hilbert($n);

            // Then
            $this->assertEquals($H, $sut);
        }

        /**
         * @test   Hilbert exception when n is less than zero
         * @throws \Exception
         */
        public function testHilbertExceptionNLessThanZero()
        {
            // Given
            $n = -1;

            // Then
            $this->expectException(Exception\OutOfBoundsException::class);

            // When
            MatrixFactory::hilbert(-1);
        }

        /**
         * @test   Creating a random matrix of a specific size
         * @throws \Exception
         */
        public function testRandomMatrix()
        {
            // Given
            for ($m = 1; $m < 5; $m++)
                for ($n = 1; $n < 5; $n++)
                {
                    // When
                    $A = MatrixFactory::random($m, $n);

                    // Then
                    $this->assertEquals($m, $A->getM());
                    $this->assertEquals($n, $A->getN());

                    // And
                    $A->walk(function ($element) {
                        $this->assertTrue(is_int($element));
                    });
                }
        }

        /**
         * @test         create ObjectMatrix
         * @dataProvider dataProviderForObjectMatrix
         *
         * @param array $A
         */
        public function testCreateObjectMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::create($A);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertInstanceOf(ObjectMatrix::class, $A);
            $this->assertInstanceOf(Matrix::class, $A);
        }

        /**
         * @test         create ObjectSquareMatrix
         * @dataProvider dataProviderForObjectSquareMatrix
         *
         * @param array $A
         */
        public function testCreateObjectSquareMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::create($A);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertInstanceOf(ObjectSquareMatrix::class, $A);
            $this->assertInstanceOf(ObjectMatrix::class, $A);
            $this->assertInstanceOf(Matrix::class, $A);
        }

        /**
         * @test         createFromColumnVector
         * @dataProvider dataProviderForCreateFromColumnVector
         *
         * @param array $V
         * @param array $expected
         */
        public function testConstructor(array $V, array $expected)
        {
            // Given
            try
            {
                $expected = new NumericMatrix($expected);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $A = MatrixFactory::createFromColumnVector($V);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->assertInstanceOf(NumericMatrix::class, $A);

            // And
            $this->assertEquals($expected->getMatrix(), $A->getMatrix());
        }

        /**
         * @test createFromColumnVector failure due to not being a column vector
         */
        public function testConstructionFailure()
        {
            // Given
            $A = [
                [1, 2, 3],
                [2, 3, 4],
            ];

            // Then
            $this->expectException(Exception\BadDataException::class);

            // When
            try
            {
                $R = MatrixFactory::createFromColumnVector($A);
            } catch (Exception\BadDataException $e)
            {
            }
        }

        /**
         * @test         createFromRowVector
         * @dataProvider dataProviderForConstructor
         *
         * @param array $V
         * @param array $expected
         *
         * @throws       \Exception
         */
        public function testCreateFromRowVector(array $V, array $expected)
        {
            // Given
            $expected = new NumericMatrix($expected);

            $A = MatrixFactory::createFromRowVector($V);

            // Then
            $this->assertInstanceOf(NumericMatrix::class, $A);

            // And
            $this->assertEquals($expected->getMatrix(), $A->getMatrix());
        }

        /**
         * @test createFromRowVector failure due to not being a row vector
         */
        public function testCreateFromRowVectorFailure()
        {
            // Given
            $A = [
                [1, 2, 3],
                [2, 3, 4],
            ];

            // Then
            $this->expectException(Exception\BadDataException::class);

            // When
            try
            {
                $R = MatrixFactory::createFromRowVector($A);
            } catch (Exception\BadDataException $e)
            {
            }
        }

        /**
         * @test         create ComplexMatrix
         * @dataProvider dataProviderForComplexObjectMatrix
         *
         * @param array $A
         */
        public function testCreateComplexObjectMatrix(array $A)
        {
            // When
            try
            {
                $A = MatrixFactory::create($A);
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            // Then
            $this->assertInstanceOf(ComplexMatrix::class, $A);
            $this->assertInstanceOf(ObjectMatrix::class, $A);
            $this->assertInstanceOf(Matrix::class, $A);
        }
    }
