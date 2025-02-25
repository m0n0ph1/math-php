<?php

    namespace MathPHP\Tests\LinearAlgebra\Vector;

    use MathPHP\Exception;
    use MathPHP\LinearAlgebra\NumericMatrix;
    use MathPHP\LinearAlgebra\Vector;
    use PHPUnit\Framework\TestCase;

    class VectorOperationsTest extends TestCase {
        public static function dataProviderForDotProduct(): array
        {
            return [
                [[1, 2, 3], [4, -5, 6], 12],
                [[-4, -9], [-1, 2], -14],
                [[6, -1, 3], [4, 18, -2], 0],
            ];
        }

        public static function dataProviderForCrossProduct(): array
        {
            return [
                [
                    [1, 2, 3],
                    [4, -5, 6],
                    [27, 6, -13],
                ],
                [
                    [-1, 2, -3],
                    [4, -5, 6],
                    [-3, -6, -3],
                ],
                [
                    [0, 0, 0],
                    [0, 0, 0],
                    [0, 0, 0],
                ],
                [
                    [4, 5, 6],
                    [7, 8, 9],
                    [-3, 6, -3],
                ],
                [
                    [4, 9, 3],
                    [12, 11, 4],
                    [3, 20, -64],
                ],
                [
                    [-4, 9, 3],
                    [12, 11, 4],
                    [3, 52, -152],
                ],
                [
                    [4, -9, 3],
                    [12, 11, 4],
                    [-69, 20, 152],
                ],
                [
                    [4, 9, -3],
                    [12, 11, 4],
                    [69, -52, -64],
                ],
                [
                    [4, 9, 3],
                    [-12, 11, 4],
                    [3, -52, 152],
                ],
                [
                    [4, 9, 3],
                    [12, -11, 4],
                    [69, 20, -152],
                ],
                [
                    [4, 9, 3],
                    [12, 11, -4],
                    [-69, 52, -64],
                ],
            ];
        }

        public static function dataProviderForCrossProductExceptionWrongSize(
        ): array
        {
            return [
                [
                    [1, 2],
                    [1, 2, 3],
                ],
                [
                    [1, 2, 3],
                    [1],
                ],
            ];
        }

        public static function dataProviderForOuterProduct(): array
        {
            return [
                [
                    [1, 2],
                    [3, 4, 5],
                    [
                        [3, 4, 5],
                        [6, 8, 10],
                    ],
                ],
                [
                    [3, 4, 5],
                    [1, 2],
                    [
                        [3, 6],
                        [4, 8],
                        [5, 10],
                    ],
                ],
                [
                    [1],
                    [2],
                    [
                        [2],
                    ],
                ],
                [
                    [1, 2],
                    [2, 3],
                    [
                        [2, 3],
                        [4, 6],
                    ],
                ],
                [
                    [1, 2, 3],
                    [2, 3, 4],
                    [
                        [2, 3, 4],
                        [4, 6, 8],
                        [6, 9, 12],
                    ],
                ],
                [
                    [1, 2, 3, 4],
                    [2, 3, 4, 5],
                    [
                        [2, 3, 4, 5],
                        [4, 6, 8, 10],
                        [6, 9, 12, 15],
                        [8, 12, 16, 20],
                    ],
                ],
                [
                    [3, 2, 6, 4],
                    [4, 5, 1, 7],
                    [
                        [12, 15, 3, 21],
                        [8, 10, 2, 14],
                        [24, 30, 6, 42],
                        [16, 20, 4, 28],
                    ],
                ],
            ];
        }

        public static function dataProviderForSum(): array
        {
            return [
                [[1, 2, 3], 6],
                [[2, 3, 4, 8, 8, 9], 34],
            ];
        }

        public static function dataProviderForScalarMultiply(): array
        {
            return [
                [
                    [1],
                    2,
                    [2],
                ],
                [
                    [2, 3],
                    2,
                    [4, 6],
                ],
                [
                    [1, 2, 3],
                    2,
                    [2, 4, 6],
                ],
                [
                    [1, 2, 3, 4, 5],
                    5,
                    [5, 10, 15, 20, 25],
                ],
                [
                    [1, 2, 3, 4, 5],
                    0,
                    [0, 0, 0, 0, 0],
                ],
                [
                    [1, 2, 3, 4, 5],
                    -2,
                    [-2, -4, -6, -8, -10],
                ],
                [
                    [1, 2, 3, 4, 5],
                    0.2,
                    [0.2, 0.4, 0.6, 0.8, 1],
                ],
            ];
        }

        public static function dataProviderForScalarDivide(): array
        {
            return [
                [
                    [1],
                    2,
                    [1 / 2],
                ],
                [
                    [2, 4],
                    2,
                    [1, 2],
                ],
                [
                    [1, 2, 3],
                    2,
                    [1 / 2, 1, 3 / 2],
                ],
                [
                    [5, 10, 15, 20, 25],
                    5,
                    [1, 2, 3, 4, 5],
                ],
                [
                    [0, 0, 0, 0, 0],
                    47,
                    [0, 0, 0, 0, 0],
                ],
                [
                    [-2, -4, -6, -8, -10],
                    -2,
                    [1, 2, 3, 4, 5],
                ],
                [
                    [1, 2, 3, 4, 5],
                    0.2,
                    [5, 10, 15, 20, 25],
                ],
            ];
        }

        public static function dataProviderForAdd(): array
        {
            return [
                [
                    [1],
                    [2],
                    [3],
                ],
                [
                    [1, 2, 3],
                    [1, 2, 3],
                    [2, 4, 6],
                ],
                [
                    [1, 2, 3],
                    [-2, -2, -4],
                    [-1, 0, -1],
                ],
            ];
        }

        public static function dataProviderForSubtract(): array
        {
            return [
                [
                    [3],
                    [2],
                    [1],
                ],
                [
                    [2, 2, 2],
                    [1, 2, 3],
                    [1, 0, -1],
                ],
                [
                    [2, 2, 2],
                    [-1, -2, -3],
                    [3, 4, 5],
                ],
            ];
        }

        public static function dataProviderForMultiply(): array
        {
            return [
                [
                    [1],
                    [2],
                    [2],
                ],
                [
                    [1, 2, 3],
                    [1, 2, 3],
                    [1, 4, 9],
                ],
                [
                    [1, 2, 3],
                    [-2, -2, -4],
                    [-2, -4, -12],
                ],
            ];
        }

        public static function dataProviderForDivide(): array
        {
            return [
                [
                    [1],
                    [2],
                    [1 / 2],
                ],
                [
                    [1, 2, 3],
                    [1, 2, 3],
                    [1, 1, 1],
                ],
                [
                    [1, 2, 3],
                    [-2, -2, -4],
                    [-1 / 2, -1, -3 / 4],
                ],
            ];
        }

        public static function dataProviderForLength(): array
        {
            return [
                [[1, 2, 3], 3.7416573867739413],
                [[7, 5, 5], 9.9498743710662],
                [[3, 3, 3], 5.196152422706632],
                [[2, 2, 2], 3.4641016151377544],
                [[1, 1, 1], 1.7320508075688772],
                [[0, 0, 0], 0],
                [[1, 0, 0], 1],
                [[1, 1, 0], 1.4142135623730951],
                [[-1, 1, 0], 1.4142135623730951],
            ];
        }

        public static function dataProviderForNormalize(): array
        {
            return [
                [
                    [3, 5],
                    [0.51449575542753, 0.85749292571254],
                ],
                [
                    [3, 1, 2],
                    [0.80178372573727, 0.26726124191242, 0.53452248382485],
                ],
            ];
        }

        public static function dataProviderForPerpendicular(): array
        {
            return [
                [
                    [3, 5],
                    [-5, 3],
                ],
                [
                    [2, 3],
                    [-3, 2],
                ],
            ];
        }

        public static function dataProviderForPerpDotProduct(): array
        {
            return [
                [
                    [3, -2],
                    [1, 2],
                    8,
                ],
                [
                    [2, 0],
                    [-1, 3],
                    6,
                ],
            ];
        }

        public static function dataProviderForProjection(): array
        {
            return [
                [
                    [2, 4],
                    [5, 3],
                    [3.2352941176468, 1.94117647058808],
                ],
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [128 / 77, 160 / 77, 192 / 77],
                ],
                [
                    [4, 5, 6],
                    [1, 2, 3],
                    [16 / 7, 32 / 7, 48 / 7],
                ],
                [
                    [2, 9, -4],
                    [-1, 5, 5],
                    [-23 / 51, 115 / 51, 115 / 51],
                ],
                [
                    [1, 1, 1],
                    [1, 1, 1],
                    [1, 1, 1],
                ],
                [
                    [1, 1, 1],
                    [2, 2, 2],
                    [1, 1, 1],
                ],
                [
                    [2, 2, 2],
                    [1, 1, 1],
                    [2, 2, 2],
                ],
                [
                    [1, 2, 1],
                    [2, 1, 2],
                    [4 / 3, 2 / 3, 4 / 3],
                ],
            ];
        }

        public static function dataProviderForPerp(): array
        {
            return [
                [
                    [2, 4],
                    [5, 3],
                    [-1.23529411764, 2.0588235294],
                ],
            ];
        }

        public static function dataProviderForDirectProduct(): array
        {
            return [
                [
                    [1],
                    [2],
                    [
                        [2],
                    ],
                ],
                [
                    [1, 2],
                    [2, 3],
                    [
                        [2, 3],
                        [4, 6],
                    ],
                ],
                [
                    [1, 2, 3],
                    [2, 3, 4],
                    [
                        [2, 3, 4],
                        [4, 6, 8],
                        [6, 9, 12],
                    ],
                ],
                [
                    [1, 2, 3, 4],
                    [2, 3, 4, 5],
                    [
                        [2, 3, 4, 5],
                        [4, 6, 8, 10],
                        [6, 9, 12, 15],
                        [8, 12, 16, 20],
                    ],
                ],
                [
                    [3, 2, 6, 4],
                    [4, 5, 1, 7],
                    [
                        [12, 15, 3, 21],
                        [8, 10, 2, 14],
                        [24, 30, 6, 42],
                        [16, 20, 4, 28],
                    ],
                ],
                [
                    [1, 2],
                    [3, 4, 5],
                    [
                        [3, 4, 5],
                        [6, 8, 10],
                    ],
                ],
                [
                    [3, 4, 5],
                    [1, 2],
                    [
                        [3, 6],
                        [4, 8],
                        [5, 10],
                    ],
                ],
            ];
        }

        public static function dataProviderForKroneckerProduct(): array
        {
            return [
                [
                    [1],
                    [1],
                    [1],
                ],
                [
                    [2],
                    [3],
                    [6],
                ],
                [
                    [1, 2],
                    [3, 4],
                    [3, 4, 6, 8],
                ],
                [
                    [4, 6],
                    [3, 9],
                    [12, 36, 18, 54],
                ],
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [4, 5, 6, 8, 10, 12, 12, 15, 18],
                ],
                [
                    [5, 3, 9, 8],
                    [1, 6, 5, 12],
                    [
                        5,
                        30,
                        25,
                        60,
                        3,
                        18,
                        15,
                        36,
                        9,
                        54,
                        45,
                        108,
                        8,
                        48,
                        40,
                        96,
                    ],
                ],
            ];
        }

        public static function dataProviderForMax(): array
        {
            return [
                [
                    [0],
                    0,
                ],
                [
                    [1],
                    1,
                ],
                [
                    [-1],
                    -1,
                ],
                [
                    [0, 1, 2, 3],
                    3,
                ],
                [
                    [3, 2, 1, 0],
                    3,
                ],
                [
                    [0, 1, 2, 3, -4, 55, -66],
                    55,
                ],
                [
                    [0.0, 1.1, 2.2, 3.3],
                    3.3,
                ],
            ];
        }

        public static function dataProviderForMin(): array
        {
            return [
                [
                    [0],
                    0,
                ],
                [
                    [1],
                    1,
                ],
                [
                    [-1],
                    -1,
                ],
                [
                    [0, 1, 2, 3],
                    0,
                ],
                [
                    [3, 2, 1, 0],
                    0,
                ],
                [
                    [0, 1, 2, 3, -4, 55, -66],
                    -66,
                ],
                [
                    [1.1, 2.2, 3.3],
                    1.1,
                ],
            ];
        }

        /**
         * @test         dot product
         * @dataProvider dataProviderForDotProduct
         */
        public function testDotProduct(array $A, array $B, $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $dotProduct = $A->dotProduct(B: $B);
            } catch (Exception\VectorException $e)
            {
            }

            // Then
            $this->assertEquals($expected, $dotProduct);
        }

        /**
         * @test         inner product
         * @dataProvider dataProviderForDotProduct
         */
        public function testInnerProduct(array $A, array $B, $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $innerProduct = $A->innerProduct($B);

            // Then
            $this->assertEquals($expected, $innerProduct);
        }

        /**
         * @test   dot product exception
         * @throws \Exception
         */
        public function testDotProductExceptionSizeDifference()
        {
            // Given
            $A = new Vector([1, 2]);
            $B = new Vector([1, 2, 3]);

            // Then
            $this->expectException(Exception\VectorException::class);

            // When
            $A->dotProduct($B);
        }

        /**
         * @test         cross product
         * @dataProvider dataProviderForCrossProduct
         */
        public function testCrossProduct(array $A, array $B, array $R)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $R = new Vector(A: $R);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $crossProduct = $A->crossProduct(B: $B);
            } catch (Exception\VectorException $e)
            {
            }

            // Then
            $this->assertEquals($R, $crossProduct);
        }

        /**
         * @test         cross product exception - wrong size
         * @dataProvider dataProviderForCrossProductExceptionWrongSize
         */
        public function testCrossProductExceptionWrongSize(array $A, array $B)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->expectException(Exception\VectorException::class);

            // When
            try
            {
                $A->crossProduct(B: $B);
            } catch (Exception\VectorException $e)
            {
            }
        }

        /**
         * @test         outer product
         * @dataProvider dataProviderForOuterProduct
         */
        public function testOuterProduct(array $A, array $B, array $R)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $R = new NumericMatrix(A: $R);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $outerProduct = $A->outerProduct($B)->getMatrix();

            // Then
            $this->assertEquals($R->getMatrix(), $outerProduct);
        }

        /**
         * @test         sum
         * @dataProvider dataProviderForSum
         */
        public function testSum(array $A, $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $sum = $A->sum();

            // Then
            $this->assertEqualsWithDelta($expected, $sum, 0.00001);
        }

        /**
         * @test         scalar multiply
         * @dataProvider dataProviderForScalarMultiply
         */
        public function testScalarMultiply(array $A, $k, array $R)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $R = new Vector(A: $R);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $kA = $A->scalarMultiply($k);

            // Then
            $this->assertEqualsWithDelta($R, $kA, 0.00001);
            $this->assertEqualsWithDelta($R->getVector(), $kA->getVector(),
                0.00001);
        }

        /**
         * @test         scalar divide
         * @dataProvider dataProviderForScalarDivide
         */
        public function testScalarDivide(array $A, $k, array $R)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $R = new Vector(A: $R);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $A／k = $A->scalarDivide($k);

            // Then
            $this->assertEquals($R, $A／k);
            $this->assertEquals($R->getVector(), $A／k->getVector());
        }

        /**
         * @test         add
         * @dataProvider dataProviderForAdd
         */
        public function testAdd(array $A, array $B, array $R)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $R = new Vector(A: $R);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $A＋B = $A->add(B: $B);
            } catch (Exception\BadDataException|Exception\VectorException $e)
            {
            }

            // Then
            $this->assertEquals($R, $A＋B);
            $this->assertEquals($R->getVector(), $A＋B->getVector());
        }

        /**
         * @test   add exception - size mismatch
         * @throws \Exception
         */
        public function testAddExceptionSizeMismatch()
        {
            // Given
            $A = new Vector([1, 2, 3]);
            $B = new Vector([1, 2]);

            // Then
            $this->expectException(Exception\VectorException::class);

            // When
            $A->add($B);
        }

        /**
         * @test         subtract
         * @dataProvider dataProviderForSubtract
         */
        public function testSubtract(array $A, array $B, array $R)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $R = new Vector(A: $R);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $A−B = $A->subtract(B: $B);
            } catch (Exception\VectorException $e)
            {
            }

            // Then
            $this->assertEquals($R, $A−B);
            $this->assertEquals($R->getVector(), $A−B->getVector());
        }

        /**
         * @test   subtract exception - size mismatch
         * @throws \Exception
         */
        public function testSubtractExceptionSizeMismatch()
        {
            // Given
            $A = new Vector([1, 2, 3]);
            $B = new Vector([1, 2]);

            // Then
            $this->expectException(Exception\VectorException::class);

            // When
            $A->subtract($B);
        }

        /**
         * @test         multiply
         * @dataProvider dataProviderForMultiply
         *
         * @param array $A
         * @param array $B
         * @param array $R
         *
         * @throws       \Exception
         */
        public function testMultiply(array $A, array $B, array $R)
        {
            // Given
            $A = new Vector($A);
            $B = new Vector($B);
            $R = new Vector($R);

            // When
            $A×B = $A->multiply($B);

            // Then
            $this->assertEquals($R, $A×B);
            $this->assertEquals($R->getVector(), $A×B->getVector());
        }

        /**
         * @test   Multiply size mismatch
         * @throws \Exception
         */
        public function testMultiplyExceptionSizeMismatch()
        {
            // Given
            $A = new Vector([1, 2, 3]);
            $B = new Vector([1, 2]);

            // Then
            $this->expectException(Exception\VectorException::class);

            // Then
            $A->multiply($B);
        }

        /**
         * @test         divide
         * @dataProvider dataProviderForDivide
         *
         * @param array $A
         * @param array $B
         * @param array $R
         *
         * @throws       \Exception
         */
        public function testDivide(array $A, array $B, array $R)
        {
            // Given
            $A = new Vector($A);
            $B = new Vector($B);
            $R = new Vector($R);

            // When
            $A／B = $A->divide($B);

            // Then
            $this->assertEquals($R, $A／B);
            $this->assertEquals($R->getVector(), $A／B->getVector());
        }

        /**
         * @test   Divide size mismatch
         * @throws \Exception
         */
        public function testDivideExceptionSizeMismatch()
        {
            // Given
            $A = new Vector([1, 2, 3]);
            $B = new Vector([1, 2]);

            // Then
            $this->expectException(Exception\VectorException::class);

            // When
            $A->divide($B);
        }

        /**
         * @test         length
         * @dataProvider dataProviderForLength
         */
        public function testLength(array $A, $l²norm)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $length = $A->length();

            // Then
            $this->assertEqualsWithDelta($l²norm, $length, 0.0001);
        }

        /**
         * @test         normalize
         * @dataProvider dataProviderForNormalize
         */
        public function testNormalize(array $A, array $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $expected = new Vector(A: $expected);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $Â = $A->normalize();

            // Then
            $this->assertEqualsWithDelta($expected, $Â, 0.00000001);
            $this->assertEqualsWithDelta($expected->getVector(),
                $Â->getVector(), 0.00000001);
        }

        /**
         * @test         perpendicular
         * @dataProvider dataProviderForPerpendicular
         */
        public function testPerpendicular(array $A, array $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $expected = new Vector(A: $expected);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $A⊥ = $A->perpendicular();
            } catch (Exception\VectorException $e)
            {
            }

            // Then
            $this->assertEquals($expected, $A⊥);
            $this->assertEquals($expected->getVector(), $A⊥->getVector());
        }

        /**
         * @test   perpendicular exception - n greater than two
         * @throws \Exception
         */
        public function testPerpendicularExceptionNGreaterThanTwo()
        {
            // Given
            $A = new Vector([1, 2, 3]);

            // Then
            $this->expectException(Exception\VectorException::class);

            // When
            $A->perpendicular();
        }

        /**
         * @test         perp dot product
         * @dataProvider dataProviderForPerpDotProduct
         */
        public function testPerpDotProduct(array $A, array $B, $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $A⊥⋅B = $A->perpDotProduct(B: $B);
            } catch (Exception\VectorException $e)
            {
            }

            // Then
            $this->assertEquals($expected, $A⊥⋅B);
        }

        /**
         * @test   perp dot product exception - n not both two
         * @throws \Exception
         */
        public function testPerpDotProductExceptionNNotBothTwo()
        {
            // Given
            $A = new Vector([1, 2, 3]);
            $B = new Vector([1, 2, 3]);

            // Then
            $this->expectException(Exception\VectorException::class);

            // When
            $A->perpDotProduct($B);
        }

        /**
         * @test         projection
         * @dataProvider dataProviderForProjection
         */
        public function testProjection(array $A, array $B, array $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $expected = new Vector(A: $expected);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $projₐb = $A->projection($B);

            // Then
            $this->assertEqualsWithDelta($expected, $projₐb, 0.00001);
            $this->assertEqualsWithDelta($expected->getVector(),
                $projₐb->getVector(), 0.00001);
        }

        /**
         * @test         perp
         * @dataProvider dataProviderForPerp
         */
        public function testPerp(array $A, array $B, array $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $expected = new Vector(A: $expected);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $perpₐb = $A->perp($B);

            // Then
            $this->assertEqualsWithDelta($expected, $perpₐb, 0.00001);
            $this->assertEqualsWithDelta($expected->getVector(),
                $perpₐb->getVector(), 0.00001);
        }

        /**
         * @test         direct product
         * @dataProvider dataProviderForDirectProduct
         */
        public function testDirectProduct(array $A, array $B, array $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $expected = new NumericMatrix(A: $expected);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $AB = $A->directProduct($B);
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            }

            // Then
            $this->assertEquals($expected->getMatrix(), $AB->getMatrix());
        }

        /**
         * @test         kroneckerProduct returns the expected Vector
         * @dataProvider dataProviderForKroneckerProduct
         *
         * @param array $A
         * @param array $B
         * @param array $expected
         *
         * @throws \MathPHP\Exception\IncorrectTypeException
         * @throws \MathPHP\Exception\MatrixException
         */
        public function testKroneckerProduct(
            array $A,
            array $B,
            array $expected
        ) {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $B = new Vector(A: $B);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $R = new Vector(A: $expected);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $A⨂B = $A->kroneckerProduct($B);
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            }

            // Then
            $this->assertEquals($R, $A⨂B);
        }

        /**
         * @test         max
         * @dataProvider dataProviderForMax
         *
         * @param array  $A
         * @param number $expected
         */
        public function testMax(array $A, $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $max = $A->max();

            // Then
            $this->assertEquals($expected, $max);
        }

        /**
         * @test         min
         * @dataProvider dataProviderForMin
         *
         * @param array  $A
         * @param number $expected
         */
        public function testMin(array $A, $expected)
        {
            // Given
            try
            {
                $A = new Vector(A: $A);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $min = $A->min();

            // Then
            $this->assertEquals($expected, $min);
        }
    }
