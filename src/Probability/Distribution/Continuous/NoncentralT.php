<?php

    namespace MathPHP\Probability\Distribution\Continuous;

    use MathPHP\Exception\BadDataException;
    use MathPHP\Exception\BadParameterException;
    use MathPHP\Exception\FunctionFailedToConvergeException;
    use MathPHP\Exception\NanException;
    use MathPHP\Exception\OutOfBoundsException;
    use MathPHP\Functions\Special;
    use MathPHP\Functions\Support;
    use MathPHP\Probability\Combinatorics;

    use function exp;
    use function sqrt;

    use const NAN;

    /**
     * Noncentral t-distribution
     * https://en.wikipedia.org/wiki/Noncentral_t-distribution
     */
    class NoncentralT extends Continuous {
        /**
         * Distribution parameter bounds limits
         * ν ∈ (0,∞)
         * μ ∈ (-∞,∞)
         *
         * @var array{"ν": string, "μ": string}
         */
        public const PARAMETER_LIMITS
            = [
                'ν' => '(0,∞)',
                'μ' => '(-∞,∞)',
            ];

        /**
         * Distribution support bounds limits
         * x ∈ (-∞,∞)
         *
         * @var array{x: string}
         */
        public final const SUPPORT_LIMITS
            = [
                'x' => '(-∞,∞)',
            ];

        /** @var int degrees of freedom > 0 */
        protected int $ν;

        /** @var float Noncentrality parameter */
        protected float $μ;

        /**
         * Constructor
         *
         * @param int   $ν degrees of freedom > 0
         * @param float $μ Noncentrality parameter
         */
        public function __construct(int $ν, float $μ)
        {
            parent::__construct($ν, $μ);
        }

        public static function medianTemporaryValue()
        {
        }

        public static function meanNAN()
        {
        }

        /**
         * Probability density function
         *
         *   /v\                /   μ²\
         *  | - |              |-1*--- |                        / ν    3     μ²x²   \            / ν + 1    1     μ²x²   \   \
         *   \2/                \   2 /           /         ₁F₁|  - ;  - ; --------- |       ₁F₁|  ----- ;  - ; --------- |   |
         *  ν    * Γ(ν + 1) * e                  |              \ 2    2   2(ν + x²)/            \   2      2   2(ν + x²)/    |
         * ---------------------------------  *  | √2*μ*x * ---------------------------  +  --------------------------------  |
         *  ν           (ν / 2)                  |                        / ν + 1 \                         / ν    \          |
         * 2  * (ν + x²)         * Γ(ν / 2)      |           (ν + x²) * Γ|  ------ |          √(ν + x²) * Γ|  - + 1 |         |
         *                                        \                       \   2   /                         \ 2    /         /
         *
         * @param float $x percentile
         *
         * @return float
         */
        public function pdf(float $x): float
        {
            try
            {
                Support::checkLimits(self::SUPPORT_LIMITS, ['x' => $x]);
            } catch (BadDataException|OutOfBoundsException|BadParameterException $e)
            {
            }

            $ν = $this->ν;
            $μ = $this->μ;

            try
            {
                $part1 = ((($ν ** ($ν / 2)) * Special::gamma($ν + 1) * exp((-1
                                    * $μ
                                    ** 2)
                                / 2) / 2 ** $ν) / ($ν + ($x ** 2)) ** ($ν / 2))
                    / Special::gamma($ν / 2);
            } catch (NanException|OutOfBoundsException $e)
            {
            }

            $F1 = ($ν / 2) + 1;
            $F2 = 3 / 2;
            $F3 = (($μ ** 2) * $x ** 2) / 2 / ($ν + ($x ** 2));
            try
            {
                $inner_part1 = (sqrt(2) * $μ * $x
                        * Special::confluentHypergeometric($F1, $F2, $F3))
                    / ($ν + ($x
                            ** 2)) / Special::gamma(($ν + 1) / 2);
            } catch (BadParameterException|OutOfBoundsException|NanException $e)
            {
            }

            $F1 = ($ν + 1) / 2;
            $F2 = 1 / 2;
            try
            {
                $inner_part2 = Special::confluentHypergeometric($F1, $F2, $F3)
                    / sqrt($ν + ($x ** 2)) / Special::gamma(($ν / 2) + 1);
            } catch (BadParameterException|OutOfBoundsException|NanException $e)
            {
            }

            return $part1 * ($inner_part1 + $inner_part2);
        }

        /**
         * Cumulative distribution function
         *
         * Fᵥ,ᵤ(x) = Fᵥ,ᵤ(x),      if x ≥ 0
         *         = 1 - Fᵥ,₋ᵤ(x)  if x < 0
         *
         * @param float $x
         *
         * @return float
         * @throws \MathPHP\Exception\NanException
         * @throws \MathPHP\Exception\OutOfBoundsException
         */
        public function cdf(float $x): float
        {
            try
            {
                Support::checkLimits(self::SUPPORT_LIMITS, ['x' => $x]);
            } catch (BadDataException|OutOfBoundsException|BadParameterException $e)
            {
            }

            $ν = $this->ν;
            $μ = $this->μ;

            if ($μ == 0)
            {
                $studentT = new StudentT($ν);

                return $studentT->cdf($x);
            }
            if ($x >= 0)
            {
                return $this->f($x, $ν, $μ);
            }

            return 1 - $this->f($x, $ν, -$μ);
        }

        /**
         * F used within CDF
         *                          _                                        _
         *                   1  ∞  |        /    1  ν \          /       ν \  |
         * Fᵥ,ᵤ(x) = Φ(-μ) + -  ∑  |  pⱼIy | j + -, -  | + qⱼIy | j + 1, -  | |
         *                   2 ʲ⁼⁰ |_       \    2  2 /          \       2 / _|
         *
         *  where
         *   Φ       = cumulative distribution function of the standard normal distribution
         *   Iy(a,b) = regularized incomplete beta function
         *
         *          x²
         *   y = ------
         *       x² + ν
         *
         *        1      /  μ² \   / μ² \ʲ
         *   pⱼ = -- exp| - -   | |  -   |
         *        j!     \  2  /   \ 2  /
         *
         *              μ          /  μ² \   / μ² \ʲ
         *   qⱼ = ------------ exp| - -   | |  -   |
         *        √2Γ(j + 3/2)     \  2  /   \ 2  /
         *
         * @param float $x
         * @param int   $ν
         * @param float $μ
         *
         * @return float
         * @throws \MathPHP\Exception\NanException
         * @throws \MathPHP\Exception\OutOfBoundsException
         */
        private function f(float $x, int $ν, float $μ): float
        {
            $standardNormal = new StandardNormal();
            $Φ = $standardNormal->cdf(-$μ);
            $y = ($x ** 2) / (($x ** 2) + $ν);

            $sum = $Φ;
            $tol = .00000001;
            $j = 0;

            do
            {
                $exp = exp((-1 * $μ ** 2) / 2) * (($μ ** 2) / 2) ** $j;
                $pⱼ = (1 / Combinatorics::factorial($j)) * $exp;
                $qⱼ = ($μ / sqrt(2) / Special::gamma($j + (3 / 2))) * $exp;
                try
                {
                    $I1 = Special::regularizedIncompleteBeta($y, $j + (1 / 2),
                        $ν / 2);
                } catch (BadDataException|OutOfBoundsException|NanException|FunctionFailedToConvergeException|BadParameterException $e)
                {
                }
                try
                {
                    $I2 = Special::regularizedIncompleteBeta($y, $j + 1,
                        $ν / 2);
                } catch (BadDataException|OutOfBoundsException|NanException|FunctionFailedToConvergeException|BadParameterException $e)
                {
                }

                $delta = ($pⱼ * $I1) + ($qⱼ * $I2);
                $sum += $delta / 2;
                ++$j;
            } while (($delta / $sum > $tol) || ($j < 10));

            return $sum;
        }

        /**
         * Median of the distribution
         *
         * @note: This is probably not correct and should be updated.
         * @return float
         * @todo: Replace with actual median calculation.
         *
         */
        public function median(): float
        {
            return $this->mean();
        }

        /**
         * Mean of the distribution
         *            _
         *           /ν Γ((ν - 1)/2)
         * E[T] = μ / - ------------    if ν > 1
         *         √  2    Γ(ν/2)
         *
         *      = Does not exist        if ν ≤ 1
         *
         * @return float
         */
        public function mean(): float
        {
            $ν = $this->ν;
            $μ = $this->μ;

            if ($ν == 1)
            {
                return NAN;
            }

            try
            {
                return ($μ * sqrt($ν / 2) * Special::gamma(($ν - 1) / 2))
                    / Special::gamma($ν / 2);
            } catch (NanException|OutOfBoundsException $e)
            {
            }
        }
    }
