<?php

    namespace MathPHP\Probability\Distribution\Continuous;

    use JetBrains\PhpStorm\Pure;
    use MathPHP\Exception\BadDataException;
    use MathPHP\Exception\BadParameterException;
    use MathPHP\Exception\FunctionFailedToConvergeException;
    use MathPHP\Exception\NanException;
    use MathPHP\Exception\OutOfBoundsException;
    use MathPHP\Functions\Special;
    use MathPHP\Functions\Support;

    use function sqrt;

    use const NAN;

    /**
     * F-distribution
     * https://en.wikipedia.org/wiki/F-distribution
     */
    class F extends Continuous {
        /**
         * Distribution parameter bounds limits
         * d₁ ∈ (0,∞)
         * d₂ ∈ (0,∞)
         *
         * @var array{"d₁": string, "d₂": string}
         */
        public const PARAMETER_LIMITS
            = [
                'd₁' => '(0,∞)',
                'd₂' => '(0,∞)',
            ];

        /**
         * Distribution Support bounds limits
         * x  ∈ [0,∞)
         *
         * @var array{x: string}
         */
        public final const SUPPORT_LIMITS
            = [
                'x' => '[0,∞)',
            ];

        /** @var float Degree of Freedom Parameter */
        protected float $d₁;

        /** @var float Degree of Freedom Parameter */
        protected float $d₂;

        /**
         * Constructor
         *
         * @param float $d₁ degree of freedom parameter d₁ > 0
         * @param float $d₂ degree of freedom parameter d₂ > 0
         */
        public function __construct(float $d₁, float $d₂)
        {
            parent::__construct($d₁, $d₂);
        }

        public static function medianTemporaryVersion()
        {
        }

        public static function varianceNan()
        {
        }

        public static function modeNan()
        {
        }

        public static function meanNAN()
        {
        }

        /**
         * Probability density function
         *
         *      __________________
         *     / (d₁ x)ᵈ¹ d₂ᵈ²
         *    /  ----------------
         *   √   (d₁ x + d₂)ᵈ¹⁺ᵈ²
         *   ---------------------
         *           / d₁  d₂ \
         *      x B |  --, --  |
         *           \ 2   2  /
         *
         * @param float $x percentile ≥ 0
         *
         * @return float probability
         * @todo how to handle x = 0
         */
        public function pdf(float $x): float
        {
            try
            {
                Support::checkLimits(self::SUPPORT_LIMITS, ['x' => $x]);
            } catch (BadDataException|OutOfBoundsException|BadParameterException $e)
            {
            }

            $d₁ = $this->d₁;
            $d₂ = $this->d₂;

            // Numerator
            $⟮d₁x⟯ᵈ¹d₂ᵈ² = (($d₁ * $x) ** $d₁) * $d₂ ** $d₂;
            $⟮d₁x＋d₂⟯ᵈ¹⁺ᵈ² = (($d₁ * $x) + $d₂) ** ($d₁ + $d₂);
            $√⟮d₁x⟯ᵈ¹d₂ᵈ²／⟮d₁x＋d₂⟯ᵈ¹⁺ᵈ² = sqrt($⟮d₁x⟯ᵈ¹d₂ᵈ² / $⟮d₁x＋d₂⟯ᵈ¹⁺ᵈ²);

            // Denominator
            try
            {
                $xB⟮d₁／2、d₂／2⟯ = $x * Special::beta($d₁ / 2, $d₂ / 2);
            } catch (NanException|OutOfBoundsException $e)
            {
            }

            return $√⟮d₁x⟯ᵈ¹d₂ᵈ²／⟮d₁x＋d₂⟯ᵈ¹⁺ᵈ² / $xB⟮d₁／2、d₂／2⟯;
        }

        /**
         * Cumulative distribution function
         *
         *          / d₁  d₂ \
         *  I      |  --, --  |
         *   ᵈ¹ˣ    \ 2   2  /
         *   ------
         *   ᵈ¹ˣ⁺ᵈ²
         *
         * Where I is the regularized incomplete beta function.
         *
         * @param float $x percentile ≥ 0
         *
         * @return float
         */
        public function cdf(float $x): float
        {
            try
            {
                Support::checkLimits(self::SUPPORT_LIMITS, ['x' => $x]);
            } catch (BadDataException|OutOfBoundsException|BadParameterException $e)
            {
            }

            $d₁ = $this->d₁;
            $d₂ = $this->d₂;

            $ᵈ¹ˣ／d₁x＋d₂ = ($d₁ * $x) / (($d₁ * $x) + $d₂);

            try
            {
                return Special::regularizedIncompleteBeta($ᵈ¹ˣ／d₁x＋d₂, $d₁ / 2,
                    $d₂ / 2);
            } catch (BadDataException|OutOfBoundsException|NanException|FunctionFailedToConvergeException|BadParameterException $e)
            {
            }
        }

        /**
         * Mode of the distribution
         *
         *        d₁ - 2   d₂
         * mode = ------ ------     d₁ > 2
         *          d₁   d₂ + 2
         *
         * @return float
         */
        public function mode(): float
        {
            $d₁ = $this->d₁;
            $d₂ = $this->d₂;

            if ($d₁ <= 2)
            {
                return NAN;
            }

            return (($d₁ - 2) / $d₁) * ($d₂ / ($d₂ + 2));
        }

        /**
         * Variance of the distribution
         *
         *          2d₂²(d₁ + d₂ - 2)
         * var[X] = -------------------   d₂ > 4
         *          d₁(d₂ - 2)²(d₂ - 4)
         *
         * @return float
         */
        public function variance(): float
        {
            $d₁ = $this->d₁;
            $d₂ = $this->d₂;

            if ($d₂ <= 4)
            {
                return NAN;
            }

            $２d₂²⟮d₁ ＋ d₂ − 2⟯ = (2 * $d₂ ** 2) * (($d₁ + $d₂) - 2);
            $d₁⟮d₂ − 2⟯²⟮d₂ − 4⟯ = ($d₁ * ($d₂ - 2) ** 2) * ($d₂ - 4);

            return $２d₂²⟮d₁ ＋ d₂ − 2⟯ / $d₁⟮d₂ − 2⟯²⟮d₂ − 4⟯;
        }

        /**
         * Median of the distribution
         *
         * @note: This is probably not correct and should be updated.
         * @return float
         * @todo: Replace with actual median calculation.
         *
         */
        #[Pure] public function median(): float
        {
            return $this->mean();
        }

        /**
         * Mean of the distribution
         *
         *       d₂
         * μ = ------  for d₂ > 2
         *     d₂ - 2
         *
         * @return float
         */
        public function mean(): float
        {
            $d₂ = $this->d₂;

            if ($d₂ > 2)
            {
                return $d₂ / ($d₂ - 2);
            }

            return NAN;
        }
    }
