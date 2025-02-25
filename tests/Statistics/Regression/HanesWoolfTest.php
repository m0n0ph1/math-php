<?php

    namespace MathPHP\Tests\Statistics\Regression;

    use MathPHP\Statistics\Regression\HanesWoolf;
    use PHPUnit\Framework\TestCase;

    class HanesWoolfTest extends TestCase {
        /**
         * @return array [points, V, K]
         */
        public static function dataProviderForParameters(): array
        {
            return [
                [
                    [
                        [.038, .05],
                        [.194, .127],
                        [.425, .094],
                        [.626, .2122],
                        [1.253, .2729],
                        [2.5, .2665],
                        [3.740, .3317],
                    ],
                    0.361512337,
                    0.554178955,
                ],
            ];
        }

        /**
         * @return array [points, x, expected y]
         */
        public static function dataProviderForEvaluate(): array
        {
            return [
                [
                    [
                        [.038, .05],
                        [.194, .127],
                        [.425, .094],
                        [.626, .2122],
                        [1.253, .2729],
                        [2.5, .2665],
                        [3.740, .3317],
                    ],
                    5,
                    0.3254417,
                ],
            ];
        }

        /**
         * @test         getParameters
         * @dataProvider dataProviderForParameters
         *
         * @param array $points
         * @param float $V
         * @param float $K
         */
        public function testGetParameters(array $points, float $V, float $K)
        {
            // Given
            $regression = new HanesWoolf($points);

            // When
            $parameters = $regression->getParameters();

            // Then
            $this->assertEqualsWithDelta($V, $parameters['V'], 0.0001);
            $this->assertEqualsWithDelta($K, $parameters['K'], 0.0001);
        }

        /**
         * @test         evaluate
         * @dataProvider dataProviderForEvaluate
         *
         * @param array $points
         * @param float $x
         * @param float $expected_y
         */
        public function testEvaluate(array $points, float $x, float $expected_y)
        {
            // Given
            $regression = new HanesWoolf($points);

            // When
            $y = $regression->evaluate($x);

            // Then
            $this->assertEqualsWithDelta($expected_y, $y, 0.0001);
        }
    }
