<?php

    namespace MathPHP\Tests\Number;

    use JetBrains\PhpStorm\Pure;
    use MathPHP\Exception;
    use MathPHP\Number\ObjectArithmetic;
    use MathPHP\Number\Quaternion;
    use PHPUnit\Framework\TestCase;
    use stdClass;

    use function sqrt;

    class QuaternionTest extends TestCase {
        public static function dataProviderForToString(): array
        {
            return [
                [0, 0, 0, 0, '0'],
                [1, 0, 0, 0, '1'],
                [-1, 0, 0, 0, '-1'],
                [0, 1, 0, 0, '1i'],
                [0, -1, 0, 0, '-1i'],
                [1, 0, 1, 0, '1 + 1j'],
                [1, 0, 0, 2, '1 + 2k'],
                [2, 0, -1, 0, '2 - 1j'],
                [2, 0, 0, -2, '2 - 2k'],
                [1, 0, -1, -1, '1 - 1j - 1k'],
                [1, 1, -2, 4, '1 + 1i - 2j + 4k'],
            ];
        }

        public static function dataProviderForComplexConjugate(): array
        {
            return [
                [0, 0, 0, 0],
                [1, 0, 0, 0],
                [0, 1, 0, 0],
                [0, 1, 1, 1],
                [1, 1, -1, -1],
                [1, 2, 3, 4],
                [3, 7, 11, -13],
            ];
        }

        public static function dataProviderForAbs(): array
        {
            return [
                [0, 0, 0, 0, 0],
                [1, 0, 0, 0, 1],
                [0, 1, 0, 0, 1],
                [0, 0, 1, 0, 1],
                [0, 0, 0, 1, 1],
                [1, 2, 3, 4, sqrt(30)],
                [-1, 0, 0, 0, 1],
                [0, -1, 0, 0, 1],
                [-1, 2, -3, 4, sqrt(30)],
            ];
        }

        public static function dataProviderForNegate(): array
        {
            return [
                [0, 0, 0, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, -1, 0, 0, 0],
                [0, 1, 1, 1, 0, -1, -1, -1],
                [1, 2, -1, -2, -1, -2, 1, 2],
                [3, 4, 3, 4, -3, -4, -3, -4],
            ];
        }

        #[Pure] public static function dataProviderForConstructorException(
        ): array
        {
            return [
                ['a', 1, 1, 1],
                [1, TRUE, 1, 1],
                [1, 1, new stdClass(), 1],
                [1, 1, 1, [1]],
            ];
        }

        public static function dataProviderForInverse(): array
        {
            return [
                [1, 0, 0, 0, 1, 0, 0, 0],
                [0, 1, 0, 0, 0, -1, 0, 0],
                [0, 0, 1, 0, 0, 0, -1, 0],
                [0, 0, 0, 1, 0, 0, 0, -1],
                [1, -1, -1, -1, .25, .25, .25, .25],
            ];
        }

        public static function dataProviderForAdd(): array
        {
            return [
                [
                    ['r' => 3, 'i' => 2, 'j' => 1, 'k' => -1],
                    ['r' => 4, 'i' => -3, 'j' => -2, 'k' => -5],
                    ['r' => 7, 'i' => -1, 'j' => -1, 'k' => -6],
                ],
            ];
        }

        public static function dataProviderForSubtract(): array
        {
            return [
                [
                    ['r' => 3, 'i' => 2, 'j' => 1, 'k' => -1],
                    ['r' => -4, 'i' => 3, 'j' => 2, 'k' => 5],
                    ['r' => 7, 'i' => -1, 'j' => -1, 'k' => -6],
                ],
            ];
        }

        public static function dataProviderForAddReal(): array
        {
            return [
                [
                    ['r' => 3, 'i' => 2, 'j' => 1, 'k' => -1],
                    5,
                    ['r' => 8, 'i' => 2, 'j' => 1, 'k' => -1],
                ],
                [
                    ['r' => 0, 'i' => 0, 'j' => 0, 'k' => 0],
                    5,
                    ['r' => 5, 'i' => 0, 'j' => 0, 'k' => 0],
                ],
                [
                    ['r' => 3, 'i' => 2, 'j' => 1, 'k' => -1],
                    -2,
                    ['r' => 1, 'i' => 2, 'j' => 1, 'k' => -1],
                ],
            ];
        }

        public static function dataProviderForSubtractReal(): array
        {
            return [
                [
                    ['r' => 3, 'i' => 2, 'j' => 1, 'k' => -1],
                    -5,
                    ['r' => 8, 'i' => 2, 'j' => 1, 'k' => -1],
                ],
                [
                    ['r' => 0, 'i' => 0, 'j' => 0, 'k' => 0],
                    -5,
                    ['r' => 5, 'i' => 0, 'j' => 0, 'k' => 0],
                ],
                [
                    ['r' => 3, 'i' => 2, 'j' => 1, 'k' => -1],
                    2,
                    ['r' => 1, 'i' => 2, 'j' => 1, 'k' => -1],
                ],
            ];
        }

        public static function dataProviderForMultiply(): array
        {
            return [
                [
                    ['r' => 3, 'i' => 2, 'j' => 1, 'k' => -1],
                    ['r' => 1, 'i' => 4, 'j' => 3, 'k' => 2],
                    ['r' => -6, 'i' => 19, 'j' => 2, 'k' => 7],
                ],
                [
                    ['r' => 3, 'i' => 13, 'j' => 5, 'k' => 7],
                    ['r' => 19, 'i' => 17, 'j' => -11, 'k' => 2],
                    ['r' => -123, 'i' => 385, 'j' => 155, 'k' => -89],
                ],
                [
                    ['r' => 2, 'i' => 3, 'j' => 4, 'k' => 5],
                    ['r' => 6, 'i' => 7, 'j' => 8, 'k' => 9],
                    ['r' => -86, 'i' => 28, 'j' => 48, 'k' => 44],
                ],
            ];
        }

        public static function dataProviderForDivide(): array
        {
            return [
                [
                    ['r' => 3, 'i' => 2, 'j' => 1, 'k' => -1],
                    ['r' => 1, 'i' => 4, 'j' => 3, 'k' => 2],
                    ['r' => 2 / 5, 'i' => -1 / 2, 'j' => 0, 'k' => -3 / 10],
                ],
            ];
        }

        /**
         * @test Interfaces
         */
        public function testObjectArithmeticInterface()
        {
            // Given
            try
            {
                $c = new Quaternion(1, 2, 3, 4);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->assertInstanceOf(ObjectArithmetic::class, $c);
        }

        public function testZeroValue()
        {
            // Given
            $c = Quaternion::createZeroValue();

            // Then
            $this->assertEquals(0, $c->r);
            $this->assertEquals(0, $c->i);
            $this->assertEquals(0, $c->j);
            $this->assertEquals(0, $c->k);
        }

        /**
         * @test         __toString returns the proper string representation of a quaternion
         * @dataProvider dataProviderForToString
         *
         * @param number $r
         * @param number $i
         * @param number $j
         * @param number $k
         * @param string $expected
         */
        public function testToString($r, $i, $j, $k, string $expected)
        {
            // Given
            try
            {
                $c = new Quaternion($r, $i, $j, $k);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $string = $c->__toString();

            // Then
            $this->assertEquals($expected, $string);
            $this->assertEquals($expected, (string)$c);
        }

        /**
         * @test __get returns r, i, j, and k
         */
        public function testGet()
        {
            // Given
            $r = 1;
            $i = 2;
            $j = 3;
            $k = 4;
            try
            {
                $c = new Quaternion($r, $i, $j, $k);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->assertEquals($r, $c->r);
            $this->assertEquals($i, $c->i);
            $this->assertEquals($j, $c->j);
            $this->assertEquals($k, $c->k);
        }

        /**
         * @test __get throws an Exception\BadParameterException if a property other than r or i is attempted
         */
        public function testGetException()
        {
            // Given
            $r = 1;
            $i = 2;
            $j = 3;
            $k = 4;
            try
            {
                $c = new Quaternion($r, $i, $j, $k);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->expectException(Exception\BadParameterException::class);

            // When
            $z = $c->z;
        }

        /**
         * @test         complexConjugate returns the expected Quaternion
         * @dataProvider dataProviderForComplexConjugate
         *
         * @param number $r
         * @param number $i
         * @param number $j
         * @param number $k
         */
        public function testComplexConjugate($r, $i, $j, $k)
        {
            // Given
            try
            {
                $c = new Quaternion($r, $i, $j, $k);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $cc = $c->complexConjugate();

            // Then
            $this->assertEquals($c->r, $cc->r);
            $this->assertEquals($c->i, -1 * $cc->i);
            $this->assertEquals($c->j, -1 * $cc->j);
            $this->assertEquals($c->k, -1 * $cc->k);
        }

        /**
         * @test         abs returns the expected value
         * @dataProvider dataProviderForAbs
         *
         * @param number $r
         * @param number $i
         * @param number $j
         * @param number $k
         * @param number $expected
         */
        public function testAbs($r, $i, $j, $k, $expected)
        {
            // Given
            try
            {
                $c = new Quaternion($r, $i, $j, $k);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $abs = $c->abs();

            // Then
            $this->assertEquals($expected, $abs);
        }

        /**
         * @test         negate returns the expected quaternion with signs negated
         * @dataProvider dataProviderForNegate
         *
         * @param number $r₁
         * @param number $i₁
         * @param        $j₁
         * @param        $k₁
         * @param number $r₂
         * @param number $i₂
         * @param        $j₂
         * @param        $k₂
         */
        public function testNegate($r₁, $i₁, $j₁, $k₁, $r₂, $i₂, $j₂, $k₂)
        {
            // Given
            try
            {
                $c = new Quaternion($r₁, $i₁, $j₁, $k₁);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $expected = new Quaternion($r₂, $i₂, $j₂, $k₂);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            $negated = $c->negate();

            // Then
            $this->assertTrue($negated->equals($expected));
            $this->assertEquals($expected->r, $negated->r);
            $this->assertEquals($expected->i, $negated->i);
            $this->assertEquals($expected->j, $negated->j);
            $this->assertEquals($expected->k, $negated->k);
        }

        /**
         * @test         Constructor throws an exception when given non-numeric
         * @dataProvider dataProviderForConstructorException
         * @throws \Exception
         */
        public function testConstructorException($r, $i, $j, $k)
        {
            // Then
            $this->expectException(Exception\BadDataException::class);

            // When
            $c = new Quaternion($r, $i, $j, $k);
        }

        /**
         * @testCase     inverse returns the expected quaternion
         * @dataProvider dataProviderForInverse
         *
         * @param number $r
         * @param number $i
         * @param number $j
         * @param number $k
         * @param number $expected_r
         * @param number $expected_i
         * @param number $expected_j
         * @param number $expected_k
         */
        public function testInverse(
            $r,
            $i,
            $j,
            $k,
            $expected_r,
            $expected_i,
            $expected_j,
            $expected_k
        ) {
            try
            {
                $q = new Quaternion($r, $i, $j, $k);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $inverse = $q->inverse();
            } catch (Exception\BadDataException $e)
            {
            }

            $this->assertEquals($expected_r, $inverse->r);
            $this->assertEquals($expected_i, $inverse->i);
            $this->assertEquals($expected_j, $inverse->j);
            $this->assertEquals($expected_k, $inverse->k);
        }

        /**
         * @testCase inverse throws an Exception\BadDataException when value is 0 + 0i + 0j + 0k
         */
        public function testInverseException()
        {
            try
            {
                $q = new Quaternion(0, 0, 0, 0);
            } catch (Exception\BadDataException $e)
            {
            }
            $this->expectException(Exception\BadDataException::class);
            try
            {
                $q->inverse();
            } catch (Exception\BadDataException $e)
            {
            }
        }

        /**
         * @test         add of two complex numbers returns the expected complex number
         * @dataProvider dataProviderForAdd
         *
         * @param array $complex1
         * @param array $complex2
         * @param array $expected
         */
        public function testAdd(
            array $complex1,
            array $complex2,
            array $expected
        ) {
            // Given
            try
            {
                $q1 = new Quaternion($complex1['r'], $complex1['i'],
                    $complex1['j'],
                    $complex1['k']);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $q2 = new Quaternion($complex2['r'], $complex2['i'],
                    $complex2['j'],
                    $complex2['k']);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $result = $q1->add($q2);
            } catch (Exception\IncorrectTypeException $e)
            {
            }

            // Then
            $this->assertEquals($expected['r'], $result->r);
            $this->assertEquals($expected['i'], $result->i);
            $this->assertEquals($expected['j'], $result->j);
            $this->assertEquals($expected['k'], $result->k);
        }

        /**
         * @test         subtract of two quaternions returns the expected quaternion
         * @dataProvider dataProviderForSubtract
         *
         * @param array $complex1
         * @param array $complex2
         * @param array $expected
         */
        public function testSubtract(
            array $complex1,
            array $complex2,
            array $expected
        ) {
            // Given
            try
            {
                $q1 = new Quaternion($complex1['r'], $complex1['i'],
                    $complex1['j'],
                    $complex1['k']);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $q2 = new Quaternion($complex2['r'], $complex2['i'],
                    $complex2['j'],
                    $complex2['k']);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $result = $q1->subtract($q2);
            } catch (Exception\IncorrectTypeException $e)
            {
            }

            // Then
            $this->assertEquals($expected['r'], $result->r);
            $this->assertEquals($expected['i'], $result->i);
            $this->assertEquals($expected['j'], $result->j);
            $this->assertEquals($expected['k'], $result->k);
        }

        /**
         * @test         add of real numbers returns the expected quaternion
         * @dataProvider dataProviderForAddReal
         */
        public function testAddReal($complex, $real, $expected)
        {
            // Given
            try
            {
                $q = new Quaternion($complex['r'], $complex['i'], $complex['j'],
                    $complex['k']);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $result = $q->add($real);
            } catch (Exception\IncorrectTypeException $e)
            {
            }

            // Then
            $this->assertEquals($expected['r'], $result->r);
            $this->assertEquals($expected['i'], $result->i);
            $this->assertEquals($expected['j'], $result->j);
            $this->assertEquals($expected['k'], $result->k);
        }

        /**
         * @test         subtract of real numbers returns the expected quaternion
         * @dataProvider dataProviderForSubtractReal
         */
        public function testSubtractReal($complex, $real, $expected)
        {
            // Given
            try
            {
                $q = new Quaternion($complex['r'], $complex['i'], $complex['j'],
                    $complex['k']);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $result = $q->subtract($real);
            } catch (Exception\IncorrectTypeException $e)
            {
            }

            // Then
            $this->assertEquals($expected['r'], $result->r);
            $this->assertEquals($expected['i'], $result->i);
            $this->assertEquals($expected['j'], $result->j);
            $this->assertEquals($expected['k'], $result->k);
        }

        /**
         * @test         multiply of two quaternions returns the expected quaternion
         * @dataProvider dataProviderForMultiply
         *
         * @param array $complex1
         * @param array $complex2
         * @param array $expected
         *
         * @throws \MathPHP\Exception\BadDataException
         */
        public function testMultiply(
            array $complex1,
            array $complex2,
            array $expected
        ) {
            // Given
            try
            {
                $q1 = new Quaternion($complex1['r'], $complex1['i'],
                    $complex1['j'],
                    $complex1['k']);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $q2 = new Quaternion($complex2['r'], $complex2['i'],
                    $complex2['j'],
                    $complex2['k']);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $result = $q1->multiply($q2);
            } catch (Exception\IncorrectTypeException $e)
            {
            }

            // Then
            $this->assertEquals($expected['r'], $result->r);
            $this->assertEquals($expected['i'], $result->i);
            $this->assertEquals($expected['j'], $result->j);
            $this->assertEquals($expected['k'], $result->k);
        }

        /**
         * @test         divide of two cquaternions returns the expected quaternion
         * @dataProvider dataProviderForDivide
         *
         * @param array $complex1
         * @param array $complex2
         * @param array $expected
         */
        public function testDivide(
            array $complex1,
            array $complex2,
            array $expected
        ) {
            // Given
            try
            {
                $q1 = new Quaternion($complex1['r'], $complex1['i'],
                    $complex1['j'],
                    $complex1['k']);
            } catch (Exception\BadDataException $e)
            {
            }
            try
            {
                $q2 = new Quaternion($complex2['r'], $complex2['i'],
                    $complex2['j'],
                    $complex2['k']);
            } catch (Exception\BadDataException $e)
            {
            }

            // When
            try
            {
                $result = $q1->divide($q2);
            } catch (Exception\IncorrectTypeException $e)
            {
            }

            // Then
            $this->assertEqualsWithDelta($expected['r'], $result->r, 0.00001);
            $this->assertEqualsWithDelta($expected['i'], $result->i, 0.00001);
            $this->assertEqualsWithDelta($expected['j'], $result->j, 0.00001);
            $this->assertEqualsWithDelta($expected['k'], $result->k, 0.00001);
        }

        /**
         * @test add throws an Exception\IncorrectTypeException when the argument is not a number or quaternion
         */
        public function testQuaternionAddException()
        {
            // Given
            try
            {
                $q = new Quaternion(1, 1, 1, 1);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->expectException(Exception\IncorrectTypeException::class);

            // When
            try
            {
                $q->add("string");
            } catch (Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * @test subtract throws an Exception\IncorrectTypeException when the argument is not a number or quaternion
         */
        public function testQuaternionSubtractException()
        {
            // Given
            try
            {
                $q = new Quaternion(1, 1, 1, 1);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->expectException(Exception\IncorrectTypeException::class);

            // When
            try
            {
                $q->subtract("string");
            } catch (Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * @test multiply throws an Exception\IncorrectTypeException when the argument is not a number or quaternion
         */
        public function tesQuaternionMultiplyException()
        {
            // Given
            try
            {
                $q = new Quaternion(1, 1, 1, 1);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->expectException(Exception\IncorrectTypeException::class);

            // When
            try
            {
                try
                {
                    $q->multiply("string");
                } catch (Exception\BadDataException $e)
                {
                } catch (Exception\IncorrectTypeException $e)
                {
                }
            } catch (Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * @test divide throws an Exception\IncorrectTypeException when the argument is not a number or quaternion
         */
        public function testQuaternionDivideException()
        {
            // Given
            try
            {
                $q = new Quaternion(1, 1, 1, 1);
            } catch (Exception\BadDataException $e)
            {
            }

            // Then
            $this->expectException(Exception\IncorrectTypeException::class);

            // When
            try
            {
                $q->divide("string");
            } catch (Exception\IncorrectTypeException $e)
            {
            }
        }
    }
