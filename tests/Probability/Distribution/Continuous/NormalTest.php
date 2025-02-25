<?php

    namespace MathPHP\Tests\Probability\Distribution\Continuous;

    use MathPHP\Probability\Distribution\Continuous\Normal;
    use PHPUnit\Framework\TestCase;

    use function is_numeric;
    use function range;

    use const INF;

    class NormalTest extends TestCase {
        /**
         * @return array [μ, σ, x, pdf]
         */
        public static function dataProviderForPdf(): array
        {
            return [
                [0, 1, 10, 0],
                [0, 1, 6, 1e-8],
                [0, 1, 5, 0.00000149],
                [0, 1, 4, 0.00013383],
                [0, 1, 3, 0.00443185],
                [0, 1, 2, 0.05399097],
                [0, 1, 1.96, 0.05844094],
                [0, 1, 1.5, 0.1295176],
                [0, 1, 1.1, 0.21785218],
                [0, 1, 1, 0.24197072],
                [0, 1, 0.9, 0.26608525],
                [0, 1, 0.8, 0.28969155],
                [0, 1, 0.7, 0.31225393],
                [0, 1, 0.6, 0.3332246],
                [0, 1, 0.5, 0.35206533],
                [0, 1, 0.4, 0.36827014],
                [0, 1, 0.3, 0.38138782],
                [0, 1, 0.2, 0.39104269],
                [0, 1, 0.1, 0.39695255],
                [0, 1, 0, 0.39894228],
                [0, 1, -0.1, 0.39695255],
                [0, 1, -0.5, 0.35206533],
                [0, 1, -1, 0.24197072],
                [0, 1, -1.96, 0.05844094],
                [0, 1, -2, 0.05399097],
                [0, 1, -3, 0.00443185],
                [0, 1, -4, 0.00013383],
                [0, 1, -5, 0.00000149],
                [0, 1, -6, 1e-8],
                [0, 1, -10, 0],

                [1, 1, 10, 0],
                [1, 1, 6, 0.00000149],
                [1, 1, 5, 0.00013383],
                [1, 1, 4, 0.00443185],
                [1, 1, 3, 0.05399097],
                [1, 1, 2, 0.24197072],
                [1, 1, 1.96, 0.25164434],
                [1, 1, 1.5, 0.35206533],
                [1, 1, 1.1, 0.39695255],
                [1, 1, 1, 0.39894228],
                [1, 1, 0.9, 0.39695255],
                [1, 1, 0.8, 0.39104269],
                [1, 1, 0.7, 0.38138782],
                [1, 1, 0.6, 0.36827014],
                [1, 1, 0.5, 0.35206533],
                [1, 1, 0.4, 0.3332246],
                [1, 1, 0.3, 0.31225393],
                [1, 1, 0.2, 0.28969155],
                [1, 1, 0.1, 0.26608525],
                [1, 1, 0, 0.24197072],
                [1, 1, -0.1, 0.21785218],
                [1, 1, -0.5, 0.1295176],
                [1, 1, -1, 0.05399097],
                [1, 1, -1.96, 0.0049929],
                [1, 1, -2, 0.00443185],
                [1, 1, -3, 0.00013383],
                [1, 1, -4, 0.00000149],
                [1, 1, -5, 1e-8],
                [1, 1, -6, 0],
                [1, 1, -10, 0],

                [3.2, 2.8, 10, 0.00746494],
                [3.2, 2.8, 6, 0.08641812],
                [3.2, 2.8, 5, 0.1158811],
                [3.2, 2.8, 4, 0.13678099],
                [3.2, 2.8, 3, 0.14211638],
                [3.2, 2.8, 2, 0.1299774],
                [3.2, 2.8, 1, 0.10463979],
                [3.2, 2.8, 0, 0.07415341],
                [3.2, 2.8, -1, 0.04625628],
                [3.2, 2.8, -2, 0.02539894],
                [3.2, 2.8, -3, 0.01227625],
                [3.2, 2.8, -4, 0.00522302],
                [3.2, 2.8, -5, 0.00195606],
                [3.2, 2.8, -6, 0.00064483],
                [3.2, 2.8, -10, 0.00000213],

                [72, 15.2, 84, 0.01921876],
                [25, 2, 26, 0.17603266338],
            ];
        }

        /**
         * @return array [μ, σ, x, cdf]
         */
        public static function dataProviderForCdf(): array
        {
            return [
                [0, 1, 10, 1],
                [0, 1, 6, 1],
                [0, 1, 5, 0.99999971],
                [0, 1, 4, 0.99996833],
                [0, 1, 3, 0.9986501],
                [0, 1, 2, 0.97724987],
                [0, 1, 1.96, 0.9750021],
                [0, 1, 1.5, 0.9331928],
                [0, 1, 1.1, 0.86433394],
                [0, 1, 1, 0.84134475],
                [0, 1, 0.9, 0.81593987],
                [0, 1, 0.8, 0.7881446],
                [0, 1, 0.7, 0.75803635],
                [0, 1, 0.6, 0.72574688],
                [0, 1, 0.5, 0.69146246],
                [0, 1, 0.4, 0.65542174],
                [0, 1, 0.31, 0.62171952],
                [0, 1, 0.3, 0.61791142],
                [0, 1, 0.2, 0.57925971],
                [0, 1, 0.1, 0.53982784],
                [0, 1, 0.01, 0.50398936],
                [0, 1, 0.02, 0.50797831],
                [0, 1, 0, 0.5],
                [0, 1, -0.1, 0.46017216],
                [0, 1, -0.31, 0.37828048],
                [0, 1, -0.39, 0.34826827],
                [0, 1, -0.5, 0.30853754],
                [0, 1, -1, 0.15865525],
                [0, 1, -1.96, 0.0249979],
                [0, 1, -2, 0.02275013],
                [0, 1, -2.90, 0.00186581],
                [0, 1, -2.96, 0.0015382],
                [0, 1, -3, 0.0013499],
                [0, 1, -3.09, 0.00100078],
                [0, 1, -4, 0.00003167],
                [0, 1, -5, 2.9e-7],
                [0, 1, -6, 0],
                [0, 1, -10, 0],

                [1, 1, 10, 1],
                [1, 1, 6, 0.99999971],
                [1, 1, 5, 0.99996833],
                [1, 1, 4, 0.9986501],
                [1, 1, 3, 0.97724987],
                [1, 1, 2, 0.84134475],
                [1, 1, 1.96, 0.83147239],
                [1, 1, 1.5, 0.69146246],
                [1, 1, 1.1, 0.53982784],
                [1, 1, 1, 0.5],
                [1, 1, 0.9, 0.46017216],
                [1, 1, 0.8, 0.42074029],
                [1, 1, 0.7, 0.38208858],
                [1, 1, 0.6, 0.34457826],
                [1, 1, 0.5, 0.30853754],
                [1, 1, 0.4, 0.27425312],
                [1, 1, 0.3, 0.24196365],
                [1, 1, 0.2, 0.2118554],
                [1, 1, 0.1, 0.18406013],
                [1, 1, 0, 0.15865525],
                [1, 1, -0.1, 0.13566606],
                [1, 1, -0.5, 0.0668072],
                [1, 1, -1, 0.02275013],
                [1, 1, -1.96, 0.0015382],
                [1, 1, -2, 0.0013499],
                [1, 1, -3, 0.00003167],
                [1, 1, -4, 2.9e-7],
                [1, 1, -5, 0],
                [1, 1, -6, 0],
                [1, 1, -10, 0],

                [3.2, 2.8, 10, 0.99242078],
                [3.2, 2.8, 6, 0.84134475],
                [3.2, 2.8, 5, 0.7398416],
                [3.2, 2.8, 4, 0.61245152],
                [3.2, 2.8, 3, 0.47152834],
                [3.2, 2.8, 2, 0.33411757],
                [3.2, 2.8, 1, 0.21601745],
                [3.2, 2.8, 0, 0.12654895],
                [3.2, 2.8, -1, 0.0668072],
                [3.2, 2.8, -2, 0.03164542],
                [3.2, 2.8, -3, 0.01340457],
                [3.2, 2.8, -4, 0.005064],
                [3.2, 2.8, -5, 0.00170262],
                [3.2, 2.8, -6, 0.00050862],
                [3.2, 2.8, -10, 0.00000121],

                [72, 15.2, 84, 0.7850824],
                [25, 2, 26, 0.69146246],
                [5, 1, 6, 0.84134475],
                [25, 14, 39, 0.84134475],
                [4, 0.3, 3.5, 0.04779035],
                [1, 1.1, 1.3, 0.60746857],
            ];
        }

        /**
         * @return array [lower, upper, μ, σ, probability]
         */
        public static function dataProviderForBetween(): array
        {
            return [
                [5, 7, 6, 1, 0.682689492],
                [-1.95996398454005, 1.95996398454005, 0, 1, .95],
            ];
        }

        /**
         * @return array [lower, upper, μ, σ, probability]
         */
        public static function dataProviderForOutside(): array
        {
            return [
                [5, 7, 6, 2, 0.6170750774519740000000000],
                [-1.64485362695147, 1.64485362695147, 0, 1, 0.1],
            ];
        }

        /**
         * @return array [x, μ, σ, probability]
         */
        public static function dataProviderForAbove(): array
        {
            return [
                [1.64485362695147, 0, 1, 0.05],
                [1.95996398454005, 6, 2, 0.97830924],
            ];
        }

        /**
         * @return array [μ]
         */
        public static function dataProviderForMean(): array
        {
            return [
                [-2],
                [-1],
                [0],
                [1],
                [1.3],
                [2],
                [5],
            ];
        }

        /**
         * @return array [μ, σ, var]
         */
        public static function dataProviderForVariance(): array
        {
            return [
                [-2, 1, 1],
                [-1, 2, 4],
                [0, 3, 9],
                [1, 4, 16],
                [1.3, 5, 25],
                [2, 6, 36],
            ];
        }

        /**
         * @return array [μ, σ, x, inverse]
         */
        public static function dataProviderForInverse(): array
        {
            return [
                [0, 1, 1, INF],
                [0, 1, 0.99, 2.32634787],
                [0, 1, 0.9, 1.28155157],
                [0, 1, 0.8, 0.84162123],
                [0, 1, 0.7, 0.52440051],
                [0, 1, 0.6, 0.2533471],
                [0, 1, 0.51, 0.02506891],
                [0, 1, 0.501, 0.00250663],
                [0, 1, 0.500000005, 1e-8],
                [0, 1, 0.50000000005, 0],
                [0, 1, 0.5, 0],
                [0, 1, 0.49999999995, 0],
                [0, 1, 0.499999995, -1e-8],
                [0, 1, 0.499, -0.00250663],
                [0, 1, 0.49, -0.02506891],
                [0, 1, 0.4, -0.2533471],
                [0, 1, 0.3, -0.52440051],
                [0, 1, 0.2, -0.84162123],
                [0, 1, 0.1, -1.28155157],
                [0, 1, 0.01, -2.32634787],
                [0, 1, 0, -INF],

                [1, 1, 1, INF],
                [1, 1, 0.99, 3.32634787],
                [1, 1, 0.9, 2.28155157],
                [1, 1, 0.8, 1.84162123],
                [1, 1, 0.7, 1.52440051],
                [1, 1, 0.6, 1.2533471],
                [1, 1, 0.5, 1],
                [1, 1, 0.4, 0.7466529],
                [1, 1, 0.3, 0.47559949],
                [1, 1, 0.2, 0.15837877],
                [1, 1, 0.1, -0.28155157],
                [1, 1, 0.01, -1.32634787],
                [1, 1, 0, -INF],

                [3.2, 2.8, 1, INF],
                [3.2, 2.8, 0.99, 9.71377405],
                [3.2, 2.8, 0.9, 6.78834438],
                [3.2, 2.8, 0.8, 5.55653945],
                [3.2, 2.8, 0.7, 4.66832144],
                [3.2, 2.8, 0.6, 3.90937189],
                [3.2, 2.8, 0.5, 3.2],
                [3.2, 2.8, 0.4, 2.49062811],
                [3.2, 2.8, 0.3, 1.73167856],
                [3.2, 2.8, 0.2, 0.84346055],
                [3.2, 2.8, 0.1, -0.38834438],
                [3.2, 2.8, 0.01, -3.31377405],
                [3.2, 2.8, 0, -INF],

                [-1, 1, 0, -INF],
                [-1, 1, 0.1, -2.281552],
                [-1, 1, 0.2, -1.841621],
                [-1, 1, 0.3, -1.524401],
                [-1, 1, 0.4, -1.253347],
                [-1, 1, 0.5, -1],
                [-1, 1, 0.6, -0.7466529],
                [-1, 1, 0.7, -0.4755995],
                [-1, 1, 0.8, -0.1583788],
                [-1, 1, 0.9, 0.2815516],
                [-1, 1, 1, INF],

                [5, 7, 0, -INF],
                [5, 7, 0.1, -3.970861],
                [5, 7, 0.2, -0.8913486],
                [5, 7, 0.3, 1.329196],
                [5, 7, 0.4, 3.22657],
                [5, 7, 0.5, 5],
                [5, 7, 0.6, 6.77343],
                [5, 7, 0.7, 8.670804],
                [5, 7, 0.8, 10.89135],
                [5, 7, 0.9, 13.97086],
                [5, 7, 1, INF],
            ];
        }

        /**
         * @return array [μ, σ, x, cdf]
         */
        public static function dataProviderForInverseOfCdf(): array
        {
            return [
                [0, 1, 5, 0.99999971],
                [0, 1, 4, 0.99996833],
                [0, 1, 3, 0.9986501],
                [0, 1, 2, 0.97724987],
                [0, 1, 1.96, 0.9750021],
                [0, 1, 1.5, 0.9331928],
                [0, 1, 1.1, 0.86433394],
                [0, 1, 1, 0.84134475],
                [0, 1, 0.9, 0.81593987],
                [0, 1, 0.8, 0.7881446],
                [0, 1, 0.7, 0.75803635],
                [0, 1, 0.6, 0.72574688],
                [0, 1, 0.5, 0.69146246],
                [0, 1, 0.4, 0.65542174],
                [0, 1, 0.31, 0.62171952],
                [0, 1, 0.3, 0.61791142],
                [0, 1, 0.2, 0.57925971],
                [0, 1, 0.1, 0.53982784],
                [0, 1, 0.01, 0.50398936],
                [0, 1, 0.02, 0.50797831],
                [0, 1, 0, 0.5],
                [0, 1, -0.1, 0.46017216],
                [0, 1, -0.31, 0.37828048],
                [0, 1, -0.39, 0.34826827],
                [0, 1, -0.5, 0.30853754],
                [0, 1, -1, 0.15865525],
                [0, 1, -1.96, 0.0249979],
                [0, 1, -2, 0.02275013],
                [0, 1, -2.90, 0.00186581],
                [0, 1, -2.96, 0.0015382],
                [0, 1, -3, 0.0013499],
                [0, 1, -3.09, 0.00100078],
                [0, 1, -4, 0.00003167],
                [0, 1, -5, 2.9e-7],

                [1, 1, 6, 0.99999971],
                [1, 1, 5, 0.99996833],
                [1, 1, 4, 0.9986501],
                [1, 1, 3, 0.97724987],
                [1, 1, 2, 0.84134475],
                [1, 1, 1.96, 0.83147239],
                [1, 1, 1.5, 0.69146246],
                [1, 1, 1.1, 0.53982784],
                [1, 1, 1, 0.5],
                [1, 1, 0.9, 0.46017216],
                [1, 1, 0.8, 0.42074029],
                [1, 1, 0.7, 0.38208858],
                [1, 1, 0.6, 0.34457826],
                [1, 1, 0.5, 0.30853754],
                [1, 1, 0.4, 0.27425312],
                [1, 1, 0.3, 0.24196365],
                [1, 1, 0.2, 0.2118554],
                [1, 1, 0.1, 0.18406013],
                [1, 1, 0, 0.15865525],
                [1, 1, -0.1, 0.13566606],
                [1, 1, -0.5, 0.0668072],
                [1, 1, -1, 0.02275013],
                [1, 1, -1.96, 0.0015382],
                [1, 1, -2, 0.0013499],
                [1, 1, -3, 0.00003167],
                [1, 1, -4, 2.9e-7],

                [3.2, 2.8, 10, 0.99242078],
                [3.2, 2.8, 6, 0.84134475],
                [3.2, 2.8, 5, 0.7398416],
                [3.2, 2.8, 4, 0.61245152],
                [3.2, 2.8, 3, 0.47152834],
                [3.2, 2.8, 2, 0.33411757],
                [3.2, 2.8, 1, 0.21601745],
                [3.2, 2.8, 0, 0.12654895],
                [3.2, 2.8, -1, 0.0668072],
                [3.2, 2.8, -2, 0.03164542],
                [3.2, 2.8, -3, 0.01340457],
                [3.2, 2.8, -4, 0.005064],
                [3.2, 2.8, -5, 0.00170262],
                [3.2, 2.8, -6, 0.00050862],
                [3.2, 2.8, -10, 0.00000121],

                [72, 15.2, 84, 0.7850824],
                [25, 2, 26, 0.69146246],
                [5, 1, 6, 0.84134475],
                [25, 14, 39, 0.84134475],
                [4, 0.3, 3.5, 0.04779035],
                [1, 1.1, 1.3, 0.60746857],
            ];
        }

        /**
         * @test         pdf
         * @dataProvider dataProviderForPdf
         *
         * @param float $x
         * @param float $μ
         * @param float $σ
         * @param float $expected_pdf
         */
        public function testPdf(
            float $μ,
            float $σ,
            float $x,
            float $expected_pdf
        ) {
            // Given
            $normal = new Normal($μ, $σ);

            // When
            $pdf = $normal->pdf($x);

            // Then
            $this->assertEqualsWithDelta($expected_pdf, $pdf, 0.0000001);
        }

        /**
         * @test         cdf
         * @dataProvider dataProviderForCdf
         *
         * @param float $x
         * @param float $μ
         * @param float $σ
         * @param float $expected_cdf
         */
        public function testCdf(
            float $μ,
            float $σ,
            float $x,
            float $expected_cdf
        ) {
            // Given
            $normal = new Normal($μ, $σ);

            // When
            $cdf = $normal->cdf($x);

            // Then
            $this->assertEqualsWithDelta($expected_cdf, $cdf, 0.0000001);
        }

        /**
         * @test         between
         * @dataProvider dataProviderForBetween
         *
         * @param float $lower
         * @param float $upper
         * @param float $μ
         * @param float $σ
         * @param float $probability
         */
        public function testBetween(
            float $lower,
            float $upper,
            float $μ,
            float $σ,
            float $probability
        ) {
            // Given
            $normal = new Normal($μ, $σ);

            // When
            $between = $normal->between($lower, $upper);

            // Then
            $this->assertEqualsWithDelta($probability, $between, 0.00001);
        }

        /**
         * @test         outside
         * @dataProvider dataProviderForOutside
         *
         * @param float $lower
         * @param float $upper
         * @param float $μ
         * @param float $σ
         * @param float $probability
         */
        public function testOutside(
            float $lower,
            float $upper,
            float $μ,
            float $σ,
            float $probability
        ) {
            // Given
            $normal = new Normal($μ, $σ);

            // When
            $outside = $normal->outside($lower, $upper);

            // Then
            $this->assertEqualsWithDelta($probability, $outside, 0.00001);
        }

        /**
         * @test         above
         * @dataProvider dataProviderForAbove
         *
         * @param float $x
         * @param float $μ
         * @param float $σ
         * @param float $probability
         */
        public function testAbove(
            float $x,
            float $μ,
            float $σ,
            float $probability
        ) {
            // Given
            $normal = new Normal($μ, $σ);

            // When
            $above = $normal->above($x);

            // Then
            $this->assertEqualsWithDelta($probability, $above, 0.00001);
        }

        /**
         * @test         mean
         * @dataProvider dataProviderForMean
         *
         * @param float $μ μ
         */
        public function testMean(float $μ)
        {
            // Given
            $σ = 1.5;
            $normal = new Normal($μ, $σ);

            // When
            $mean = $normal->mean();

            // Then
            $this->assertEquals($μ, $mean);
        }

        /**
         * @test         median
         * @dataProvider dataProviderForMean
         *
         * @param float $μ μ
         */
        public function testMedian(float $μ)
        {
            // Given
            $σ = 1.5;
            $normal = new Normal($μ, $σ);

            // When
            $median = $normal->median();

            // Then
            $this->assertEquals($μ, $median);
        }

        /**
         * @test         mode
         * @dataProvider dataProviderForMean
         *
         * @param float $μ μ
         */
        public function testMode(float $μ)
        {
            // Given
            $σ = 1.5;
            $normal = new Normal($μ, $σ);

            // When
            $mode = $normal->mode();

            // Then
            $this->assertEquals($μ, $mode);
        }

        /**
         * @test         variance
         * @dataProvider dataProviderForVariance
         *
         * @param float $μ
         * @param float $σ
         * @param float $expected
         */
        public function testVariance(float $μ, float $σ, float $expected)
        {
            // Given
            $normal = new Normal($μ, $σ);

            // When
            $variance = $normal->variance();

            // Then
            $this->assertEquals($expected, $variance);
        }

        /**
         * @test         inverse
         * @dataProvider dataProviderForInverse
         *
         * @param float $x
         * @param float $μ
         * @param float $σ
         * @param float $inverse
         */
        public function testInverse(
            float $μ,
            float $σ,
            float $x,
            float $inverse
        ) {
            $normal = new Normal($μ, $σ);
            $this->assertEqualsWithDelta($inverse, $normal->inverse($x),
                0.00001);
        }

        /**
         * @test         Inverse of CDF is x
         * @dataProvider dataProviderForInverseOfCdf
         *
         * @param float $x
         * @param float $μ
         * @param float $σ
         */
        public function testInverseOfCdf(float $μ, float $σ, float $x)
        {
            // Given
            $normal = new Normal($μ, $σ);
            $cdf = $normal->cdf($x);

            // When
            $inverse_of_cdf = $normal->inverse($cdf);

            // Then
            $this->assertEqualsWithDelta($x, $inverse_of_cdf, 0.00001);
        }

        /**
         * @test rand
         */
        public function testRand()
        {
            foreach (range(-3, 3) as $μ)
            {
                {
                    foreach (range(1, 3) as $σ)
                    {
                        // Given
                        $normal = new Normal($μ, $σ);

                        // When
                        $random = $normal->rand();

                        // Then
                        $this->assertTrue(is_numeric($random));
                    }
                }
            }
        }
    }
