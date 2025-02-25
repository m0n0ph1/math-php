<?php

    namespace MathPHP\Statistics;

    use JetBrains\PhpStorm\ArrayShape;
    use JetBrains\PhpStorm\Pure;

    use function array_sum;
    use function atan2;
    use function cos;
    use function count;
    use function log;
    use function sin;
    use function sqrt;

    /**
     * Circular statistics (directional statistics)
     * https://en.wikipedia.org/wiki/Directional_statistics
     * https://ncss-wpengine.netdna-ssl.com/wp-content/themes/ncss/pdf/Procedures/NCSS/Circular_Data_Analysis.pdf
     */
    class Circular {
        /**
         * Get a report of all the descriptive circular statistics over a list of angles
         * Includes mean, resultant length, mean resultant length, variance, standard deviation.
         *
         * @param array<float> $angles
         *
         * @return array{
         *     n:                       int,
         *     mean:                    float,
         *     resultant_length:        float,
         *     mean_resultant_length:   float,
         *     variance:                float,
         *     sd:                      float,
         * }
         */
        #[ArrayShape([
            'n'                     => "int",
            'mean'                  => "float",
            'resultant_length'      => "float",
            'mean_resultant_length' => "float",
            'variance'              => "float",
            'sd'                    => "float",
        ])] public static function describe(array $angles): array
        {
            return [
                'n'                     => count($angles),
                'mean'                  => self::mean($angles),
                'resultant_length'      => self::resultantLength($angles),
                'mean_resultant_length' => self::meanResultantLength($angles),
                'variance'              => self::variance($angles),
                'sd'                    => self::standardDeviation($angles),
            ];
        }

        /**
         * Mean of circular quantities (circular mean)
         * Mean direction of circular data.
         * A mean which is sometimes better-suited for quantities like angles, daytimes, and fractional parts of real numbers.
         * https://en.wikipedia.org/wiki/Mean_of_circular_quantities
         * _
         * α = atan2(∑sin αⱼ, ∑cos αⱼ)
         *
         * @param array<float> $angles
         *
         * @return float mean direction of circular data
         */
        public static function mean(array $angles): float
        {
            $array_map3 = [];
            foreach ($angles as $key => $αⱼ)
            {
                $array_map3[$key] = sin($αⱼ);
            }
            $array_map1 = $array_map3;
            $∑sinαⱼ = array_sum($array_map1);
            $array_map2 = [];
            foreach ($angles as $key => $αⱼ)
            {
                $array_map2[$key] = cos($αⱼ);
            }
            $array_map = $array_map2;
            $∑cosαⱼ = array_sum($array_map);

            return atan2($∑sinαⱼ, $∑cosαⱼ);
        }

        /**
         * Resultant length (R)
         * https://en.wikipedia.org/wiki/Directional_statistics#Moments
         * https://ncss-wpengine.netdna-ssl.com/wp-content/themes/ncss/pdf/Procedures/NCSS/Circular_Data_Analysis.pdf
         *
         * S  = ∑sin θᵢ
         * C  = ∑cos θᵢ
         * R² = S² + C²
         * R  = √(S² + C²)
         *
         * @param array<float> $angles
         *
         * @return float
         */
        public static function resultantLength(array $angles): float
        {
            $array_map3 = [];
            foreach ($angles as $key => $θᵢ)
            {
                $array_map3[$key] = sin($θᵢ);
            }
            $array_map1 = $array_map3;
            $S = array_sum($array_map1);
            $array_map2 = [];
            foreach ($angles as $key => $θᵢ)
            {
                $array_map2[$key] = cos($θᵢ);
            }
            $array_map = $array_map2;
            $C = array_sum($array_map);

            $S² = $S ** 2;
            $C² = $C ** 2;
            $R² = $S² + $C²;

            return sqrt($R²);
        }

        /**
         * Mean resultant length - MRL (ρ)
         * https://en.wikipedia.org/wiki/Directional_statistics#Moments
         * https://ncss-wpengine.netdna-ssl.com/wp-content/themes/ncss/pdf/Procedures/NCSS/Circular_Data_Analysis.pdf
         *
         * S  = ∑sin θᵢ
         * C  = ∑cos θᵢ
         * R² = S² + C²
         * R  = √(S² + C²)
         *
         * _    R
         * R  = -
         *      n
         *
         *      _
         * ρ  = R
         *
         * @param array<float> $angles
         *
         * @return float
         */
        public static function meanResultantLength(array $angles): float
        {
            $n = count($angles);
            $R = self::resultantLength($angles);

            return $R / $n;
        }

        /**
         * Circular variance
         * https://en.wikipedia.org/wiki/Directional_statistics#Measures_of_location_and_spread
         * https://www.ebi.ac.uk/thornton-srv/software/PROCHECK/nmr_manual/man_cv.html
         * https://ncss-wpengine.netdna-ssl.com/wp-content/themes/ncss/pdf/Procedures/NCSS/Circular_Data_Analysis.pdf
         *              _
         * Var(θ) = 1 - R
         * Var(θ) = 1 - ρ
         *
         * @param array<float> $angles
         *
         * @return float
         */
        #[Pure] public static function variance(array $angles): float
        {
            $ρ = self::meanResultantLength($angles);

            return 1 - $ρ;
        }

        /**
         * Circular standard deviation
         * https://en.wikipedia.org/wiki/Directional_statistics#Measures_of_location_and_spread
         * https://ncss-wpengine.netdna-ssl.com/wp-content/themes/ncss/pdf/Procedures/NCSS/Circular_Data_Analysis.pdf
         *
         *       _______
         *      /     _
         * ν = √ -2ln(R)
         *
         *       _
         * Where R = ρ = mean resultant length
         *
         * @param array<float> $angles
         *
         * @return float
         */
        #[Pure] public static function standardDeviation(array $angles): float
        {
            $ρ = self::meanResultantLength($angles);

            return sqrt(-2 * log($ρ));
        }
    }
