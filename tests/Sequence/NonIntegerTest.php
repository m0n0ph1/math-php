<?php

    namespace MathPHP\Tests\Sequence;

    use MathPHP\Exception;
    use MathPHP\Sequence\NonInteger;
    use PHPUnit\Framework\TestCase;

    class NonIntegerTest extends TestCase {
        public static function dataProviderForHarmonicNumbers(): array
        {
            return [
                [-1, []],
                [0, []],
                [1, [1 => 1]],
                [
                    10,
                    [
                        1 => 1,
                        3 / 2,
                        11 / 6,
                        25 / 12,
                        137 / 60,
                        49 / 20,
                        363 / 140,
                        761 / 280,
                        7129 / 2520,
                        7381 / 2520,
                    ],
                ],
            ];
        }

        public static function dataProviderForGeneralizedHarmonicNumbers(
        ): array
        {
            return [
                [-1, 2, []],
                [0, 2, []],
                [1, 2, [1 => 1]],
                [4, 2, [1 => 1, 5 / 4, 49 / 36, 205 / 144]],
                [3, 1.01, [1 => 1, 1.4965462477, 1.8262375824425]],
            ];
        }

        public static function dataProviderForHyperharmonicNumbers(): array
        {
            return [
                [-1, 5, []],
                [0, 2, []],
                [
                    10,
                    0,
                    [
                        1 => 1,
                        1 / 2,
                        1 / 3,
                        1 / 4,
                        1 / 5,
                        1 / 6,
                        1 / 7,
                        1 / 8,
                        1 / 9,
                        1 / 10,
                    ],
                ],
                [
                    10,
                    1,
                    [
                        1 => 1,
                        3 / 2,
                        11 / 6,
                        25 / 12,
                        137 / 60,
                        49 / 20,
                        363 / 140,
                        761 / 280,
                        7129 / 2520,
                        7381 / 2520,
                    ],
                ],
                [
                    10,
                    2,
                    [
                        1 => 1,
                        5 / 2,
                        26 / 6,
                        77 / 12,
                        87 / 10,
                        223 / 20,
                        481 / 35,
                        4609 / 280,
                        4861 / 252,
                        55991 / 2520,
                    ],
                ],
            ];
        }

        /**
         * @test         HarmonicNumber produces the expected sequence
         * @dataProvider dataProviderForHarmonicNumbers
         *
         * @param int   $n
         * @param array $expectedSequence
         */
        public function testHarmonicNumbers(int $n, array $expectedSequence)
        {
            // When
            $harmonicSequence = NonInteger::harmonic($n);

            // Then
            $this->assertEqualsWithDelta($expectedSequence, $harmonicSequence,
                0.00001);
        }

        /**
         * @test         generalizedHarmonic produces the expected sequence
         * @dataProvider dataProviderForGeneralizedHarmonicNumbers
         *
         * @param int   $n
         * @param float $p
         * @param array $expectedSequence
         */
        public function testGeneralizedHarmonicNumbers(
            int $n,
            float $p,
            array $expectedSequence
        ) {
            // When
            $harmonicSequence = NonInteger::generalizedHarmonic($n, $p);

            // Then
            $this->assertEqualsWithDelta($expectedSequence, $harmonicSequence,
                0.00001);
        }

        /**
         * @test         HyperharmonicNumber produces the expected sequence
         * @dataProvider dataProviderForHyperharmonicNumbers
         *
         * @param int   $n
         * @param int   $r
         * @param array $expectedSequence
         */
        public function testHyperharmonicNumbers(
            int $n,
            int $r,
            array $expectedSequence
        ) {
            // When
            try
            {
                $hyperharmonicSequence = NonInteger::hyperharmonic($n, $r);
            } catch (Exception\OutOfBoundsException $e)
            {
            }

            // Then
            $this->assertEqualsWithDelta($expectedSequence,
                $hyperharmonicSequence, .0001);
        }

        /**
         * @test hyperharmonic throws a OutOfBoundsException when r is less than zero
         */
        public function testHyperharmonicSeriesException()
        {
            // Given
            $r = -1;

            // Then
            $this->expectException(Exception\OutOfBoundsException::class);

            // When
            try
            {
                NonInteger::hyperharmonic(10, $r);
            } catch (Exception\OutOfBoundsException $e)
            {
            }
        }

        /**
         * @test hyperharmonic arithmetic operations exceed the bounds of the max integer precision
         *       and produce a controlled MathException rather than a TypeError.
         */
        public function testHyperharmonicSequenceTypeError()
        {
            // Given
            $n = 10000;
            $r = 10000;

            // Then
            $this->expectException(Exception\OutOfBoundsException::class);

            // When
            try
            {
                NonInteger::hyperharmonic($n, $r);
            } catch (Exception\OutOfBoundsException $e)
            {
            }
        }
    }
