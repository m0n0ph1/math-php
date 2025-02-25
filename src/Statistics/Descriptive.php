<?php

    namespace MathPHP\Statistics;

    use JetBrains\PhpStorm\ArrayShape;
    use MathPHP\Exception;

    use function abs;
    use function array_map;
    use function array_pop;
    use function array_shift;
    use function array_slice;
    use function array_sum;
    use function array_unshift;
    use function count;
    use function intdiv;
    use function intval;
    use function max;
    use function min;
    use function sort;
    use function sqrt;

    use const NAN;

    /**
     * Descriptive statistics
     * Summary statistics that quantitatively describe or summarize features of a collection of information.
     * https://en.wikipedia.org/wiki/Descriptive_statistics
     */
    class Descriptive {
        public final const POPULATION = TRUE;
        public final const SAMPLE = FALSE;

        /**
         * Weighted sample variance
         *
         * Biased case
         *
         *       ∑wᵢ⟮xᵢ - μw⟯²
         * σ²w = ----------
         *           ∑wᵢ
         *
         * Unbiased estimator for frequency weights
         *
         *       ∑wᵢ⟮xᵢ - μw⟯²
         * σ²w = ----------
         *         ∑wᵢ - 1
         *
         * μw is the weighted mean
         *
         * https://en.wikipedia.org/wiki/Weighted_arithmetic_mean#Weighted_sample_variance
         *
         * @param float[] $numbers
         * @param float[] $weights
         * @param bool    $biased
         *
         * @return float
         *
         * @throws Exception\BadDataException if the number of numbers and weights are not equal
         */
        public static function weightedSampleVariance(
            array $numbers,
            array $weights,
            bool $biased = FALSE
        ): float {
            if (count($numbers) === 1)
            {
                return 0;
            }
            if (count($numbers) !== count($weights))
            {
                throw new Exception\BadDataException('Numbers and weights must have the same number of elements.');
            }

            $μw = Average::weightedMean($numbers, $weights);
            $∑wᵢ⟮xᵢ − μw⟯² = array_sum(array_map(
                fn($xᵢ, $wᵢ) => $wᵢ * (($xᵢ - $μw) ** 2),
                $numbers,
                $weights
            ));

            $∑wᵢ = $biased
                ? array_sum($weights)
                : (array_sum($weights) - 1);

            return $∑wᵢ⟮xᵢ − μw⟯² / $∑wᵢ;
        }

        /**
         * sd - Standard deviation - convenience method
         *
         * @param float[] $numbers
         * @param bool    $SD＋ : true returns SD+ (uses population variance);
         *                     false returns SD (uses sample variance);
         *                     Default is false (SD (sample variance))
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         * @throws Exception\OutOfBoundsException if degrees of freedom is ≤ 0
         */
        public static function sd(array $numbers, bool $SD＋ = FALSE): float
        {
            return self::standardDeviation($numbers, $SD＋);
        }

        /**
         * Standard deviation
         * A measure that is used to quantify the amount of variation or dispersion of a set of data values.
         * A low standard deviation indicates that the data points tend to be close to the mean
         * (also called the expected value) of the set.
         * A high standard deviation indicates that the data points are spread out over a wider range of values.
         * (https://en.wikipedia.org/wiki/Standard_deviation)
         *
         * σ   = √⟮σ²⟯ = √⟮variance⟯
         * SD+ = √⟮σ²⟯ = √⟮sample variance⟯
         *
         * @param float[] $numbers
         * @param bool    $SD＋ : true returns SD+ (uses population variance);
         *                     false returns SD (uses sample variance);
         *                     Default is false (SD (sample variance))
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         * @throws Exception\OutOfBoundsException if degrees of freedom is ≤ 0
         */
        public static function standardDeviation(
            array $numbers,
            bool $SD＋ = FALSE
        ): float {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the standard deviation of an empty list of numbers');
            }

            return $SD＋
                ? sqrt(self::populationVariance($numbers))
                : sqrt(self::sampleVariance($numbers));
        }

        /**
         * Population variance - Use when all possible observations of the system are present.
         * If used with a subset of data (sample variance), it will be a biased variance.
         *
         *      ∑⟮xᵢ - μ⟯²
         * σ² = ----------
         *          N
         *
         * μ is the population mean
         * N is the number of numbers in the population set
         *
         * @param float[] $numbers
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         * @throws Exception\OutOfBoundsException if degrees of freedom is ≤ 0
         */
        public static function populationVariance(array $numbers): float
        {
            $N = count($numbers);

            return self::variance($numbers, $N);
        }

        /**
         * Variance
         *
         * Variance measures how far a set of numbers are spread out.
         * A variance of zero indicates that all the values are identical.
         * Variance is always non-negative: a small variance indicates that the data points
         * tend to be very close to the mean (expected value) and hence to each other.
         * A high variance indicates that the data points are very spread out around the mean
         * and from each other.
         * (https://en.wikipedia.org/wiki/Variance)
         *
         *      ∑⟮xᵢ - μ⟯²
         * σ² = ----------
         *          ν
         *
         * Generalized method that allows setting the degrees of freedom.
         * For population variance, set d.f. (ν) to n
         * For sample variance, set d.f (ν) to n - 1
         * Or use populationVariance or sampleVariance convenience methods.
         *
         * μ is the population mean
         * ν is the degrees of freedom, which usually is
         *   the number of numbers in the population set or n - 1 for sample set.
         *
         * @param float[] $numbers
         * @param int     $ν degrees of freedom
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         * @throws Exception\OutOfBoundsException if degrees of freedom is ≤ 0
         */
        public static function variance(array $numbers, int $ν): float
        {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the variance of an empty list of numbers');
            }
            if ($ν <= 0)
            {
                throw new Exception\OutOfBoundsException('Degrees of freedom must be > 0');
            }

            $∑⟮xᵢ − μ⟯² = RandomVariable::sumOfSquaresDeviations($numbers);

            return $∑⟮xᵢ − μ⟯² / $ν;
        }

        /**
         * Unbiased sample variance
         * Use when only a subset of all possible observations of the system are present.
         *
         *      ∑⟮xᵢ - x̄⟯²
         * S² = ----------
         *        n - 1
         *
         * x̄ is the sample mean
         * n is the number of numbers in the sample set
         *
         * @param float[] $numbers
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         * @throws Exception\OutOfBoundsException if degrees of freedom is ≤ 0
         */
        public static function sampleVariance(array $numbers): float
        {
            if (count($numbers) == 1)
            {
                return 0;
            }

            $n = count($numbers);

            return self::variance($numbers, $n - 1);
        }

        /**
         * IQR - Interquartile range (midspread, middle fifty)
         * A measure of statistical dispersion.
         * Difference between the upper and lower quartiles.
         * https://en.wikipedia.org/wiki/Interquartile_range
         *
         * IQR = Q₃ - Q₁
         *
         * @param float[] $numbers
         * @param string  $method What quartile method to use (optional - default: exclusive)
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         */
        public static function interquartileRange(
            array $numbers,
            string $method = 'exclusive'
        ): float {
            return self::quartiles($numbers, $method)['IQR'];
        }

        /**
         * Quartiles
         * Three points that divide the data set into four equal groups, each group comprising a quarter of the data.
         * https://en.wikipedia.org/wiki/Quartile
         *
         * There are multiple methods for computing quartiles:
         *  - Inclusive
         *  - Exclusive
         *
         * @param float[] $numbers
         * @param string  $method What quartile method to use (optional - default: exclusive)
         *
         * @return float[] (0%, Q1, Q2, Q3, 100%, IQR)
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         */
        public static function quartiles(
            array $numbers,
            string $method = 'exclusive'
        ): array {
            switch (strtolower($method))
            {
                case 'inclusive':
                    return self::quartilesInclusive($numbers);
                case 'exclusive':
                    return self::quartilesExclusive($numbers);
                default:
                    return self::quartilesExclusive($numbers);
            }
        }

        /**
         * Quartiles - Inclusive method (R method)
         * Three points that divide the data set into four equal groups, each group comprising a quarter of the data.
         * https://en.wikipedia.org/wiki/Quartile
         *
         * 0% is smallest number
         * Q1 (25%) is first quartile (lower quartile, 25th percentile)
         * Q2 (50%) is second quartile (median, 50th percentile)
         * Q3 (75%) is third quartile (upper quartile, 75th percentile)
         * 100% is largest number
         * interquartile_range is the difference between the upper and lower quartiles. (IQR = Q₃ - Q₁)
         *
         * Method used
         *  - Use the median to divide the ordered data set into two halves.
         *   - If there are an odd number of data points in the original ordered data set,
         *     include the median (the central value in the ordered list) in both halves.
         *   - If there are an even number of data points in the original ordered data set,
         *     split this data set exactly in half.
         *  - The lower quartile value is the median of the lower half of the data.
         *    The upper quartile value is the median of the upper half of the data.
         *
         * The values found by this method are also known as "Tukey's hinges".
         * This is the "method 2" from Wikipedia.
         *
         * @param float[] $numbers
         *
         * @return array{
         *     "0%":    float,
         *     "Q1":    float,
         *     "Q2":    float,
         *     "Q3":    float,
         *     "100%":  float,
         *     "IQR":   float,
         * }
         *
         * @throws \MathPHP\Exception\BadDataException if the input array of numbers is empty
         */
        #[ArrayShape([
            '0%'   => "mixed",
            'Q1'   => "float",
            'Q2'   => "float",
            'Q3'   => "float",
            '100%' => "mixed",
            'IQR'  => "float",
        ])] public static function quartilesInclusive(array $numbers): array
        {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the quartiles of an empty list of numbers');
            }

            sort($numbers);
            $length = count($numbers);

            if ($length % 2 == 0)
            {
                $lower_half = array_slice($numbers, 0, (int)($length / 2));
                $upper_half = array_slice($numbers, (int)($length / 2));
            } else
            {
                $lower_half = array_slice($numbers, 0, intdiv($length, 2));
                $upper_half = array_slice($numbers, intdiv($length, 2) + 1);

                // Add median to both halves
                try
                {
                    $median = Average::median($numbers);
                } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
                {
                }
                $lower_half[] = $median;
                array_unshift($upper_half, $median);
            }

            try
            {
                $lower_quartile = Average::median($lower_half);
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }
            try
            {
                $upper_quartile = Average::median($upper_half);
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }

            try
            {
                return [
                    '0%'   => min($numbers),
                    'Q1'   => $lower_quartile,
                    'Q2'   => Average::median($numbers),
                    'Q3'   => $upper_quartile,
                    '100%' => max($numbers),
                    'IQR'  => $upper_quartile - $lower_quartile,
                ];
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }
        }

        /**
         * Quartiles - Exclusive method
         * Three points that divide the data set into four equal groups, each group comprising a quarter of the data.
         * https://en.wikipedia.org/wiki/Quartile
         *
         * 0% is smallest number
         * Q1 (25%) is first quartile (lower quartile, 25th percentile)
         * Q2 (50%) is second quartile (median, 50th percentile)
         * Q3 (75%) is third quartile (upper quartile, 75th percentile)
         * 100% is largest number
         * interquartile_range is the difference between the upper and lower quartiles. (IQR = Q₃ - Q₁)
         *
         * Method used
         *  - Use the median to divide the ordered data set into two halves.
         *   - If there are an odd number of data points in the original ordered data set, do not include the median
         *     (the central value in the ordered list) in either half.
         *   - If there are an even number of data points in the original ordered data set,
         *     split this data set exactly in half.
         *  - The lower quartile value is the median of the lower half of the data.
         *    The upper quartile value is the median of the upper half of the data.
         *
         * This rule is employed by the TI-83 calculator boxplot and "1-Var Stats" functions.
         * This is the most basic method that is commonly taught in math textbooks.
         * It is "method 1" from Wikipedia.
         *
         * @param float[] $numbers
         *
         * @return array{
         *     "0%":    float,
         *     "Q1":    float,
         *     "Q2":    float,
         *     "Q3":    float,
         *     "100%":  float,
         *     "IQR":   float,
         * }
         *
         * @throws \MathPHP\Exception\BadDataException if the input array of numbers is empty
         */
        public static function quartilesExclusive(array $numbers): array
        {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the quartiles of an empty list of numbers');
            }
            if (count($numbers) === 1)
            {
                $number = array_pop($numbers);

                return [
                    '0%'   => $number,
                    'Q1'   => $number,
                    'Q2'   => $number,
                    'Q3'   => $number,
                    '100%' => $number,
                    'IQR'  => 0,
                ];
            }

            sort($numbers);
            $length = count($numbers);

            if ($length % 2 == 0)
            {
                $lower_half = array_slice($numbers, 0, (int)($length / 2));
                $upper_half = array_slice($numbers, (int)($length / 2));
            } else
            {
                $lower_half = array_slice($numbers, 0, intdiv($length, 2));
                $upper_half = array_slice($numbers, intdiv($length, 2) + 1);
            }

            try
            {
                $lower_quartile = Average::median($lower_half);
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }
            try
            {
                $upper_quartile = Average::median($upper_half);
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }

            try
            {
                return [
                    '0%'   => min($numbers),
                    'Q1'   => $lower_quartile,
                    'Q2'   => Average::median($numbers),
                    'Q3'   => $upper_quartile,
                    '100%' => max($numbers),
                    'IQR'  => $upper_quartile - $lower_quartile,
                ];
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }
        }

        /**
         * IQR - Interquartile range (midspread, middle fifty)
         * Convenience wrapper function for interquartileRange.
         *
         * @param float[] $numbers
         * @param string  $method What quartile method to use (optional - default: exclusive)
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         */
        public static function iqr(
            array $numbers,
            string $method = 'exclusive'
        ): float {
            return self::quartiles($numbers, $method)['IQR'];
        }

        /**
         * Compute the P-th percentile of a list of numbers
         *
         * Linear interpolation between closest ranks method - Second variant, C = 1
         * P-th percentile (0 <= P <= 100) of a list of N ordered values (sorted from least to greatest)
         * Similar method used in NumPy and Excel
         * https://en.wikipedia.org/wiki/Percentile#Second_variant.2C_.7F.27.22.60UNIQ--postMath-00000043-QINU.60.22.27.7F
         *
         *      P
         * x - --- (N - 1) + 1
         *     100
         *
         * P = percentile
         * N = number of elements in list
         *
         * ν(x) = νₓ + x％1(νₓ₊₁ - νₓ)
         *
         * ⌊x⌋  = integer part of x
         * x％1 = fraction part of x
         * νₓ   = number in position x in sorted list of numbers
         * νₓ₊₁ = number in position x + 1 in sorted list of number
         *
         * @param float[] $numbers
         * @param float   $P percentile to calculate
         *
         * @return float in list corresponding to P percentile
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         * @throws Exception\OutOfBoundsException if $P percentile is not between 0 and 100
         */
        public static function percentile(array $numbers, float $P): float
        {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the P-th percentile of an empty list of numbers');
            }
            if (($P < 0) || ($P > 100))
            {
                throw new Exception\OutOfBoundsException('Percentile P must be between 0 and 100.');
            }

            $N = count($numbers);
            if ($N === 1)
            {
                return array_shift($numbers);
            }

            sort($numbers);

            if ($P == 100)
            {
                return $numbers[$N - 1];
            }

            $x = ($P / 100 * ($N - 1)) + 1;
            $⌊x⌋ = intval($x);
            $x％1 = $x - $⌊x⌋;
            $νₓ = $numbers[$⌊x⌋ - 1];
            $νₓ₊₁ = $numbers[$⌊x⌋];

            return $νₓ + ($x％1 * ($νₓ₊₁ - $νₓ));
        }

        /**
         * Coefficient of variation (cᵥ)
         * Also known as relative standard deviation (RSD)
         *
         * A standardized measure of dispersion of a probability distribution or
         * frequency distribution. It is often expressed as a percentage.
         * The ratio of the standard deviation to the mean.
         * https://en.wikipedia.org/wiki/Coefficient_of_variation
         *
         *      σ
         * cᵥ = -
         *      μ
         *
         * @param float[] $numbers
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         * @throws Exception\OutOfBoundsException if degrees of freedom is ≤ 0
         */
        public static function coefficientOfVariation(array $numbers): float
        {
            $σ = self::standardDeviation($numbers);
            $μ = Average::mean($numbers);

            return $σ / $μ;
        }

        /**
         * Get a report of all the descriptive statistics over a list of numbers
         * Includes mean, median, mode, range, midrange, variance, standard deviation, quartiles, etc.
         *
         * @param float[] $numbers
         * @param bool    $population : true means all possible observations of the system are present;
         *                            false means a sample is used.
         *
         * @return array{
         *     n:           int<0, max>,
         *     min:         float|false,
         *     max:         float|false,
         *     mean:        float,
         *     median:      float,
         *     mode:        float[],
         *     range:       float,
         *     midrange:    float,
         *     variance:    float,
         *     sd:          float,
         *     cv:          float,
         *     mean_mad:    float,
         *     median_mad:  float,
         *     quartiles:   float[],
         *     midhinge:    float,
         *     skewness:    float|null,
         *     ses:         float|null,
         *     kurtosis:    float|null,
         *     sek:         float|null,
         *     sem:         float,
         *     ci_95:       array{ci: float|null, lower_bound: float|null, upper_bound: float|null},
         *     ci_99:       array{ci: float|null, lower_bound: float|null, upper_bound: float|null},
         * }
         *
         * @throws \MathPHP\Exception\BadDataException
         * @throws \MathPHP\Exception\OutOfBoundsException
         */
        public static function describe(
            array $numbers,
            bool $population = FALSE
        ): array {
            $n = count($numbers);
            $μ = Average::mean($numbers);
            $σ = self::standardDeviation($numbers, $population);

            try
            {
                return [
                    'n'          => $n,
                    'min'        => min($numbers),
                    'max'        => max($numbers),
                    'mean'       => $μ,
                    'median'     => Average::median($numbers),
                    'mode'       => Average::mode($numbers),
                    'range'      => self::range($numbers),
                    'midrange'   => self::midrange($numbers),
                    'variance'   => $population
                        ? self::populationVariance($numbers)
                        : self::sampleVariance($numbers),
                    'sd'         => $σ,
                    'cv'         => $μ ? ($σ / $μ) : NAN,
                    'mean_mad'   => self::meanAbsoluteDeviation($numbers),
                    'median_mad' => self::medianAbsoluteDeviation($numbers),
                    'quartiles'  => self::quartiles($numbers),
                    'midhinge'   => self::midhinge($numbers),
                    'skewness'   => $population
                        ? (($n > 0)
                            ? RandomVariable::populationSkewness($numbers)
                            : NULL)
                        : (($n >= 3)
                            ? RandomVariable::skewness($numbers) : NULL),
                    'ses'        => ($n > 2) ? RandomVariable::ses($n) : NULL,
                    'kurtosis'   => $population
                        ? (($n > 3)
                            ? RandomVariable::populationKurtosis($numbers)
                            : NULL)
                        : (($n > 0) ? RandomVariable::sampleKurtosis($numbers)
                            : NULL),
                    'sek'        => ($n > 3) ? RandomVariable::sek($n) : NULL,
                    'sem'        => RandomVariable::standardErrorOfTheMean($numbers),
                    'ci_95'      => RandomVariable::confidenceInterval($μ, $n,
                        $σ,
                        '95'),
                    'ci_99'      => RandomVariable::confidenceInterval($μ, $n,
                        $σ,
                        '99'),
                ];
            } catch (Exception\BadDataException|Exception\OutOfBoundsException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * Range - the difference between the largest and smallest values
         * It is the size of the smallest interval which contains all the data.
         * It provides an indication of statistical dispersion.
         * (https://en.wikipedia.org/wiki/Range_(statistics))
         *
         * R = max x - min x
         *
         * @param float[] $numbers
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         */
        public static function range(array $numbers): float
        {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the range of an empty list of numbers');
            }

            return max($numbers) - min($numbers);
        }

        /**
         * Midrange - the mean of the largest and smallest values
         * It is the midpoint of the range; as such, it is a measure of central tendency.
         * (https://en.wikipedia.org/wiki/Mid-range)
         *
         *     max x + min x
         * M = -------------
         *           2
         *
         * @param float[] $numbers
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         */
        public static function midrange(array $numbers): float
        {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the midrange of an empty list of numbers');
            }

            return Average::mean([min($numbers), max($numbers)]);
        }

        /**
         * MAD - mean absolute deviation
         *
         * The average of the absolute deviations from a central point.
         * It is a summary statistic of statistical dispersion or variability.
         * (https://en.wikipedia.org/wiki/Average_absolute_deviation)
         *
         *       ∑|xᵢ - x̄|
         * MAD = ---------
         *           N
         *
         * x̄ is the mean
         * N is the number of numbers in the population set
         *
         * @param float[] $numbers
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         */
        public static function meanAbsoluteDeviation(array $numbers): float
        {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the mean absolute deviation of an empty list of numbers');
            }

            $x = Average::mean($numbers);
            $array_map1 = [];
            foreach ($numbers as $key => $xᵢ)
            {
                $array_map1[$key] = abs($xᵢ - $x);
            }
            $array_map = $array_map1;
            $∑│xᵢ − x│ = array_sum($array_map);
            $N = count($numbers);

            return $∑│xᵢ − x│ / $N;
        }

        /**
         * MAD - median absolute deviation
         *
         * The average of the absolute deviations from a central point.
         * It is a summary statistic of statistical dispersion or variability.
         * It is a robust measure of the variability of a univariate sample of quantitative data.
         * (https://en.wikipedia.org/wiki/Median_absolute_deviation)
         *
         * MAD = median(|xᵢ - x̄|)
         *
         * x̄ is the median
         *
         * @param float[] $numbers
         *
         * @return float
         *
         * @throws \MathPHP\Exception\BadDataException if the input array of numbers is empty
         */
        public static function medianAbsoluteDeviation(array $numbers): float
        {
            if (empty($numbers))
            {
                throw new Exception\BadDataException('Cannot find the median absolute deviation of an empty list of numbers');
            }

            try
            {
                $x = Average::median($numbers);
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }

            $array_map1 = [];
            foreach ($numbers as $key => $xᵢ)
            {
                $array_map1[$key] = abs($xᵢ - $x);
            }
            $array_map = $array_map1;

            try
            {
                return Average::median($array_map);
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }
        }

        /**
         * Midhinge
         * The average of the first and third quartiles and is thus a measure of location.
         * Equivalently, it is the 25% trimmed mid-range or 25% midsummary; it is an L-estimator.
         * https://en.wikipedia.org/wiki/Midhinge
         *
         * Midhinge = (first quartile, third quartile) / 2
         *
         * @param float[] $numbers
         *
         * @return float
         *
         * @throws Exception\BadDataException if the input array of numbers is empty
         */
        public static function midhinge(array $numbers): float
        {
            $quartiles = self::quartiles($numbers);
            $Q1 = $quartiles['Q1'];
            $Q2 = $quartiles['Q3'];

            return Average::mean([$Q1, $Q2]);
        }

        /**
         * Five number summary
         * A descriptive statistic that provides information about a set of observations.
         * It consists of the five most important sample percentiles:
         *  1) the sample minimum (smallest observation)
         *  2) the lower quartile or first quartile
         *  3) the median (middle value)
         *  4) the upper quartile or third quartile
         *  5) the sample maximum (largest observation)
         *
         * https://en.wikipedia.org/wiki/Five-number_summary
         *
         * @param array<int|float> $numbers
         *
         * @return array{
         *     min:     float|int|false,
         *     Q1:      float,
         *     median:  float,
         *     Q3:      float,
         *     max:     float|int|false,
         * }
         *
         * @throws \MathPHP\Exception\BadDataException
         */
        #[ArrayShape([
            'min'    => "mixed",
            'Q1'     => "float",
            'median' => "float",
            'Q3'     => "float",
            'max'    => "mixed",
        ])] public static function fiveNumberSummary(array $numbers): array
        {
            $quartiles = self::quartiles($numbers);

            try
            {
                return [
                    'min'    => min($numbers),
                    'Q1'     => $quartiles['Q1'],
                    'median' => Average::median($numbers),
                    'Q3'     => $quartiles['Q3'],
                    'max'    => max($numbers),
                ];
            } catch (Exception\BadDataException|Exception\OutOfBoundsException $e)
            {
            }
        }

        public static function describeSekNullForSmallN()
        {
        }

        public static function describeSesNullForSmallN()
        {
        }

        public static function describeSample()
        {
        }

        public static function describePopulation()
        {
        }

        public static function sCoefficientOfVariation()
        {
        }

        public static function midhingeEmptyList()
        {
        }

        public static function percentileOutOfUpperBoundsP()
        {
        }

        public static function percentileOutOfLowerBoundsP()
        {
        }

        public static function percentileEmptyList()
        {
        }

        public static function quartilesInclusiveExceptionWhenEmptyArray()
        {
        }

        public static function quartilesExclusiveExceptionWhenEmptyArray()
        {
        }

        public static function medianAbsoluteDeviationExceptionWhenEmptyArray()
        {
        }

        public static function meanAbsoluteDeviationExceptionWhenEmptyArray()
        {
        }

        public static function SDExceptionWhenEmptyArray()
        {
        }

        public static function standardDeviationExceptionWhenEmptyArray()
        {
        }

        public static function SDeviationUsingSampleVariance()
        {
        }

        public static function standardDeviationUsingSampleVariance()
        {
        }

        public static function sdUsingPopulationVariance()
        {
        }

        public static function standardDeviationUsingPopulationVariance()
        {
        }

        public static function weightedSampleVarianceException()
        {
        }

        public static function weightedSampleVarianceSetOfOne()
        {
        }

        public static function weightedSampleVarianceBiased()
        {
        }

        public static function weightedSampleVarianceUnbiased()
        {
        }

        public static function varianceExceptionDFLessThanZero()
        {
        }

        public static function sampleVarianceZeroWhenListContainsOnlyOneItem()
        {
        }

        public static function sampleVarianceExceptionWhenEmptyArray()
        {
        }

        public static function populationVarianceExceptionWhenEmptyArray()
        {
        }

        public static function midrangeExceptionWhenEmptyArray()
        {
        }

        public static function rangeExceptionWhenEmptyArray()
        {
        }
    }
