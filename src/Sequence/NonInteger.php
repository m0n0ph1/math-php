<?php

    namespace MathPHP\Sequence;

    use Error;
    use JetBrains\PhpStorm\Pure;
    use MathPHP\Exception;
    use MathPHP\Number\Rational;
    use TypeError;

    /**
     * Non-integer sequences
     *  - Harmonic
     *  - Generalized Harmonic
     *  - Hyperharmonic
     *
     * All sequences return an array of numbers in the sequence.
     * The array index starting point depends on the sequence type.
     */
    class NonInteger {
        /**
         * Harmonic Numbers
         *
         *      n  1
         * Hᵢ = ∑  -
         *     ⁱ⁼¹ i
         *
         * https://en.wikipedia.org/wiki/Harmonic_number
         *
         * @param int $n the length of the sequence to calculate
         *
         * @return float[]
         */
        #[Pure] public static function harmonic(int $n): array
        {
            return self::generalizedHarmonic($n, 1);
        }

        /**
         * Generalized Harmonic Numbers
         *
         *       ₙ  1
         * Hₙₘ = ∑  --
         *      ⁱ⁼¹ iᵐ
         *
         * https://en.wikipedia.org/wiki/Harmonic_number#Generalized_harmonic_numbers
         *
         * @param int   $n the length of the sequence to calculate
         * @param float $m the exponent
         *
         * @return float[]
         */
        public static function generalizedHarmonic(int $n, float $m): array
        {
            if ($n <= 0)
            {
                return [];
            }

            $sequence = [];
            $∑ = 0;

            for ($i = 1; $i <= $n; $i++)
            {
                $∑ += 1 / $i ** $m;
                $sequence[$i] = $∑;
            }

            return $sequence;
        }

        /**
         * Hyperharmonic Numbers
         *
         *         ₙ
         * Hₙ⁽ʳ⁾ = ∑  Hₖ⁽ʳ⁻¹⁾
         *        ᵏ⁼¹
         *
         * https://en.wikipedia.org/wiki/Hyperharmonic_number
         *
         * @param int  $n        the length of the sequence to calculate
         * @param int  $r        the depth of recursion
         * @param bool $rational return results as a Rational object
         *
         * @return float[]|Rational[]
         *
         * @throws \MathPHP\Exception\OutOfBoundsException
         */
        public static function hyperharmonic(
            int $n,
            int $r,
            bool $rational = FALSE
        ): array {
            if ($r < 0)
            {
                throw new Exception\OutOfBoundsException('Recursion depth cannot be less than 0');
            }
            if ($n <= 0)
            {
                return [];
            }
            $sequence = [];

            try
            {
                if ($r == 0)
                {
                    {
                        for ($k = 1; $k <= $n; $k++)
                        {
                            $sequence[$k] = new Rational(0, 1, $k);
                        }
                    }
                } else
                {
                    /** @var Rational[] $array */
                    $array = self::hyperharmonic($n, $r - 1, TRUE);
                    $∑ = Rational::createZeroValue();
                    for ($k = 1; $k <= $n; $k++)
                    {
                        try
                        {
                            $∑ = $∑->add($array[$k]);
                        } catch (Exception\IncorrectTypeException $e)
                        {
                        }
                        $sequence[$k] = $∑;
                    }
                }
            } catch (TypeError|Error $e)
            {
                throw new Exception\OutOfBoundsException("Numbers too large to maintain integer precision for hyperharmonic, or recursion depth level exceeded (n:$n, r:$r): "
                    .$e->getMessage(), -1, $e);
            }

            if ($rational)
            {
                return $sequence;
            }

            $array_map = [];
            foreach ($sequence as $ignored => Rationalreturn
        }

        public static function hyperharmonicSequenceTypeError()
        {
        }

        public static function hyperharmonicSeriesException()
        {
        }

        public static function hyperharmonicNumbers()
        {
        }

        public static function generalizedHarmonicNumbers()
        {
        }

        public static function harmonicNumbers()
        {
        }
    }
