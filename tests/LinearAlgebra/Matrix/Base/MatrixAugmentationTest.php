<?php

    namespace MathPHP\Tests\LinearAlgebra\Matrix;

    use MathPHP\Exception;
    use MathPHP\Expression\Polynomial;
    use MathPHP\LinearAlgebra\ComplexMatrix;
    use MathPHP\LinearAlgebra\Matrix;
    use MathPHP\LinearAlgebra\MatrixFactory;
    use MathPHP\LinearAlgebra\NumericMatrix;
    use MathPHP\LinearAlgebra\ObjectMatrix;
    use MathPHP\LinearAlgebra\ObjectSquareMatrix;
    use PHPUnit\Framework\TestCase;

    class MatrixAugmentationTest extends TestCase {

        private ComplexMatrix|NumericMatrix|ObjectSquareMatrix|ObjectMatrix|Matrix $matrix;

        public static function dataProviderForAugment(): array
        {
            return [
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    [
                        [4],
                        [5],
                        [6],
                    ],
                    [
                        [1, 2, 3, 4],
                        [2, 3, 4, 5],
                        [3, 4, 5, 6],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    [
                        [4, 7, 8],
                        [5, 7, 8],
                        [6, 7, 8],
                    ],
                    [
                        [1, 2, 3, 4, 7, 8],
                        [2, 3, 4, 5, 7, 8],
                        [3, 4, 5, 6, 7, 8],
                    ],
                ],
                [
                    [
                        [1, 2, 3],

                    ],
                    [
                        [4],

                    ],
                    [
                        [1, 2, 3, 4],
                    ],
                ],
                [
                    [
                        [1],

                    ],
                    [
                        [4],
                    ],
                    [
                        [1, 4],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    [
                        [4, 7, 8, 9],
                        [5, 7, 8, 9],
                        [6, 7, 8, 9],
                    ],
                    [
                        [1, 2, 3, 4, 7, 8, 9],
                        [2, 3, 4, 5, 7, 8, 9],
                        [3, 4, 5, 6, 7, 8, 9],
                    ],
                ],
            ];
        }

        public static function dataProviderForAugmentIdentity(): array
        {
            return [
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    [
                        [1, 2, 3, 1, 0, 0],
                        [2, 3, 4, 0, 1, 0],
                        [3, 4, 5, 0, 0, 1],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [2, 3],
                    ],
                    [
                        [1, 2, 1, 0],
                        [2, 3, 0, 1],
                    ],
                ],
                [
                    [
                        [1],
                    ],
                    [
                        [1, 1],
                    ],
                ],
            ];
        }

        public static function dataProviderForAugmentBelow(): array
        {
            return [
                [
                    [
                        [1],
                    ],
                    [
                        [2],
                    ],
                    [
                        [1],
                        [2],
                    ],
                ],
                [
                    [
                        [1],
                        [2],
                    ],
                    [
                        [3],
                    ],
                    [
                        [1],
                        [2],
                        [3],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [2, 3],
                    ],
                    [
                        [3, 4],
                    ],
                    [
                        [1, 2],
                        [2, 3],
                        [3, 4],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                    ],
                    [
                        [3, 4, 5],
                    ],
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                    ],
                    [
                        [3, 4, 5],
                        [4, 5, 6],
                    ],
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                        [4, 5, 6],
                    ],
                ],
            ];
        }

        public static function dataProviderForAugmentAbove(): array
        {
            return [
                [
                    [
                        [1],
                    ],
                    [
                        [2],
                    ],
                    [
                        [2],
                        [1],
                    ],
                ],
                [
                    [
                        [1],
                        [2],
                    ],
                    [
                        [3],
                    ],
                    [
                        [3],
                        [1],
                        [2],
                    ],
                ],
                [
                    [
                        [1, 2],
                        [2, 3],
                    ],
                    [
                        [3, 4],
                    ],
                    [
                        [3, 4],
                        [1, 2],
                        [2, 3],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                    ],
                    [
                        [3, 4, 5],
                    ],
                    [
                        [3, 4, 5],
                        [1, 2, 3],
                        [2, 3, 4],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                    ],
                    [
                        [3, 4, 5],
                        [4, 5, 6],
                    ],
                    [
                        [3, 4, 5],
                        [4, 5, 6],
                        [1, 2, 3],
                        [2, 3, 4],
                    ],
                ],
            ];
        }

        public static function dataProviderForAugmentLeft(): array
        {
            return [
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    [
                        [4],
                        [5],
                        [6],
                    ],
                    [
                        [4, 1, 2, 3],
                        [5, 2, 3, 4],
                        [6, 3, 4, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    [
                        [4, 7, 8],
                        [5, 7, 8],
                        [6, 7, 8],
                    ],
                    [
                        [4, 7, 8, 1, 2, 3],
                        [5, 7, 8, 2, 3, 4],
                        [6, 7, 8, 3, 4, 5],
                    ],
                ],
                [
                    [
                        [1, 2, 3],

                    ],
                    [
                        [4],

                    ],
                    [
                        [4, 1, 2, 3],
                    ],
                ],
                [
                    [
                        [1],

                    ],
                    [
                        [4],
                    ],
                    [
                        [4, 1],
                    ],
                ],
                [
                    [
                        [1, 2, 3],
                        [2, 3, 4],
                        [3, 4, 5],
                    ],
                    [
                        [4, 7, 8, 9],
                        [5, 7, 8, 9],
                        [6, 7, 8, 9],
                    ],
                    [
                        [4, 7, 8, 9, 1, 2, 3],
                        [5, 7, 8, 9, 2, 3, 4],
                        [6, 7, 8, 9, 3, 4, 5],
                    ],
                ],
            ];
        }

        /**
         * @throws \Exception
         */
        public function setUp(): void
        {
            $A = [
                [1, 2, 3],
                [2, 3, 4],
                [4, 5, 6],
            ];
            $this->matrix = MatrixFactory::create(A: $A);
        }

        /**
         * @test         augment
         * @dataProvider dataProviderForAugment
         *
         * @param array $A
         * @param array $B
         * @param array $⟮A∣B⟯
         *
         * @throws       \Exception
         */
        public function testAugment(array $A, array $B, array $⟮A∣B⟯)
        {
            // Given
            $A = MatrixFactory::create(A: $A);
            $B = MatrixFactory::create(A: $B);
            $⟮A∣B⟯ = MatrixFactory::create(A: $⟮A∣B⟯);

            // When
            $augmented = $A->augment($B);

            // Then
            $this->assertEquals($⟮A∣B⟯, $augmented);
        }

        /**
         * @test     augment matrix with matrix that does not match dimensions
         * @throws   \Exception
         */
        public function testAugmentExceptionRowsDoNotMatch()
        {
            // Given
            $A = MatrixFactory::create(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);
            $B = MatrixFactory::create(A: [
                [4, 5],
                [5, 6],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $A->augment($B);
        }

        /**
         * @test         Augment with identity
         * @dataProvider dataProviderForAugmentIdentity
         * @throws       \Exception
         */
        public function testAugmentIdentity(array $C, array $⟮C∣I⟯)
        {
            // Given
            $C = MatrixFactory::create(A: $C);
            $⟮C∣I⟯ = MatrixFactory::create(A: $⟮C∣I⟯);

            // Then
            $this->assertEquals($⟮C∣I⟯, $C->augmentIdentity());
        }

        /**
         * @test   Augment with identity exception when not square
         * @throws \Exception
         */
        public function testAugmentIdentityExceptionNotSquare()
        {
            // Given
            $A = MatrixFactory::create(A: [
                [1, 2],
                [2, 3],
                [3, 4],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $A->augmentIdentity();
        }

        /**
         * @test         augmentBelow
         * @dataProvider dataProviderForAugmentBelow
         *
         * @param array $A
         * @param array $B
         * @param array $⟮A∣B⟯
         *
         * @throws       \Exception
         */
        public function testAugmentBelow(array $A, array $B, array $⟮A∣B⟯)
        {
            // Given
            $A = MatrixFactory::create(A: $A);
            $B = MatrixFactory::create(A: $B);
            $⟮A∣B⟯ = MatrixFactory::create(A: $⟮A∣B⟯);

            // When
            $augmented = $A->augmentBelow($B);

            // Then
            $this->assertEquals($⟮A∣B⟯, $augmented);
        }

        /**
         * @test   It is an error to augment a matrix from below if the column count does not match
         * @throws \Exception
         */
        public function testAugmentBelowExceptionColumnsDoNotMatch()
        {
            // Given
            $A = MatrixFactory::create(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);
            $B = MatrixFactory::create(A: [
                [4, 5],
                [5, 6],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $A->augmentBelow($B);
        }

        /**
         * @test         augmentAbove
         * @dataProvider dataProviderForAugmentAbove
         *
         * @param array $A
         * @param array $B
         * @param array $⟮A∣B⟯
         *
         * @throws       \Exception
         */
        public function testAugmentAbove(array $A, array $B, array $⟮A∣B⟯)
        {
            // Given
            $A = MatrixFactory::create(A: $A);
            $B = MatrixFactory::create(A: $B);
            $⟮A∣B⟯ = MatrixFactory::create(A: $⟮A∣B⟯);

            // When
            $augmented = $A->augmentAbove($B);

            // Then
            $this->assertEquals($⟮A∣B⟯, $augmented);
        }

        /**
         * @test   It is an error to augment a matrix from above if the column count does not match
         * @throws \Exception
         */
        public function testAugmentAboveExceptionColumnsDoNotMatch()
        {
            // Given
            $A = MatrixFactory::create(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);
            $B = MatrixFactory::create(A: [
                [4, 5],
                [5, 6],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $A->augmentAbove($B);
        }

        /**
         * @test         augmentLeft
         * @dataProvider dataProviderForAugmentLeft
         *
         * @param array $A
         * @param array $B
         * @param array $⟮B∣A⟯
         *
         * @throws       \Exception
         */
        public function testAugmentLeft(array $A, array $B, array $⟮B∣A⟯)
        {
            // Given
            $A = MatrixFactory::create(A: $A);
            $B = MatrixFactory::create(A: $B);
            $⟮B∣A⟯ = MatrixFactory::create(A: $⟮B∣A⟯);

            // When
            $augmented = $A->augmentLeft($B);

            // Then
            $this->assertEquals($⟮B∣A⟯, $augmented);
        }

        /**
         * @test   augmentLeft matrix with matrix that does not match dimensions
         * @throws \Exception
         */
        public function testAugmentLeftExceptionRowsDoNotMatch()
        {
            $A = MatrixFactory::create(A: [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ]);
            $B = MatrixFactory::create(A: [
                [4, 5],
                [5, 6],
            ]);

            $this->expectException(Exception\MatrixException::class);
            $A->augmentLeft($B);
        }

        /**
         * @test         augment
         * @throws       \Exception
         */
        public function testAugmentExceptionTypeMismatch()
        {
            // Given
            $A = MatrixFactory::create(A: [[1]]);
            $B = MatrixFactory::create(A: [
                [
                    new Polynomial(coefficients: [
                        1,
                        1,
                    ]),
                ],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $augmented = $A->augment($B);
        }

        /**
         * @test         augmentLeft
         * @throws       \Exception
         */
        public function testAugmentLeftExceptionTypeMismatch()
        {
            // Given
            $A = MatrixFactory::create(A: [[1]]);
            $B = MatrixFactory::create(A: [
                [
                    new Polynomial(coefficients: [
                        1,
                        1,
                    ]),
                ],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $augmented = $A->augmentLeft($B);
        }

        /**
         * @test         augmentAbove
         * @throws       \Exception
         */
        public function testAugmentAboveExceptionTypeMismatch()
        {
            // Given
            $A = MatrixFactory::create(A: [[1]]);
            $B = MatrixFactory::create(A: [
                [
                    new Polynomial(coefficients: [
                        1,
                        1,
                    ]),
                ],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $augmented = $A->augmentAbove($B);
        }

        /**
         * @test         augmentBelow
         * @throws       \Exception
         */
        public function testAugmentBelowExceptionTypeMismatch()
        {
            // Given
            $A = MatrixFactory::create(A: [[1]]);
            $B = MatrixFactory::create(A: [
                [
                    new Polynomial(coefficients: [
                        1,
                        1,
                    ]),
                ],
            ]);

            // Then
            $this->expectException(Exception\MatrixException::class);

            // When
            $augmented = $A->augmentBelow($B);
        }
    }
