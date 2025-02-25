<?php

    namespace MathPHP\Tests\LinearAlgebra\Matrix\Numeric;

    use MathPHP\Exception;
    use MathPHP\LinearAlgebra\NumericMatrix;
    use MathPHP\LinearAlgebra\NumericSquareMatrix;
    use MathPHP\Tests\LinearAlgebra\Fixture\MatrixDataProvider;
    use PHPUnit\Framework\TestCase;

    class SquareMatrixTest extends TestCase {
        use MatrixDataProvider;

        /**
         * @test         Constructor constructs a proper SquareMatrix
         * @dataProvider dataProviderForSquareMatrix
         *
         * @param array $A
         *
         * @throws       \Exception
         */
        public function testConstructor(array $A)
        {
            $S = new NumericSquareMatrix(A: $A);
            $M = new NumericMatrix(A: $A);

            $this->assertInstanceOf(NumericSquareMatrix::class, $S);
            $this->assertInstanceOf(NumericMatrix::class, $S);

            $m = $S->getM();
            for ($i = 0; $i < $m; $i++)
            {
                {
                    $this->assertEquals($M[$i], $S[$i]);
                }
            }
            $m = $M->getM();
            for ($i = 0; $i < $m; $i++)
            {
                {
                    $this->assertEquals($M[$i], $S[$i]);
                }
            }
        }

        /**
         * @test SquareMatrix throws a MatrixException if the input is not a square array.
         */
        public function testConstructorExceptionNotSquareMatrix()
        {
            $A = [
                [1, 2, 3],
                [2, 3, 4],
            ];

            $this->expectException(Exception\MatrixException::class);
            try
            {
                $M = new NumericSquareMatrix(A: $A);
            } catch (Exception\MathException $e)
            {
            }
        }

        /**
         * @test         getMatrix returns the expected matrix.
         * @dataProvider dataProviderForSquareMatrix
         *
         * @param array $A
         *
         * @throws       \Exception
         */
        public function testGetMatrix(array $A)
        {
            $S = new NumericSquareMatrix(A: $A);
            $M = new NumericMatrix(A: $A);

            $this->assertEquals($M->getMatrix(), $S->getMatrix());
        }

        /**
         * @test         isSquare always returns true for a SquareMatrix
         * @dataProvider dataProviderForSquareMatrix
         *
         * @param array $A
         *
         * @throws       \Exception
         */
        public function testIsSquare(array $A)
        {
            $S = new NumericSquareMatrix(A: $A);
            $M = new NumericMatrix(A: $A);

            $this->assertTrue($S->isSquare());
        }
    }
