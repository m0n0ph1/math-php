<?php

    namespace MathPHP\Tests\LinearAlgebra\Matrix\Other;

    use MathPHP\LinearAlgebra\MatrixFactory;
    use PHPUnit\Framework\TestCase;

    class VandermondeMatrixTest extends TestCase {
        public static function dataProviderForTestConstructor(): array
        {
            return [
                [
                    [1, 2, 3, 4],
                    4,
                    [
                        [1, 1, 1, 1],
                        [1, 2, 4, 8],
                        [1, 3, 9, 27],
                        [1, 4, 16, 64],
                    ],
                ],
                [
                    [10, 5, 4],
                    3,
                    [
                        [1, 10, 100],
                        [1, 5, 25],
                        [1, 4, 16],
                    ],
                ],
            ];
        }

        /**
         * @test         Vandermonde matrix is constructed correctly
         * @dataProvider dataProviderForTestConstructor
         *
         * @param array $M
         * @param int   $n
         * @param array $V
         *
         * @throws       \Exception
         */
        public function testConstructor(array $M, int $n, array $V)
        {
            // Given
            $V = MatrixFactory::create(A: $V);

            // When
            $M = MatrixFactory::vandermonde(M: $M, n: $n);

            // Then
            $this->assertTrue($V->isEqual($M));
            $this->assertTrue($M->isEqual(B: $V));
        }
    }
