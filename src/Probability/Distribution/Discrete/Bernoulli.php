<?php

    namespace MathPHP\Probability\Distribution\Discrete;

    use MathPHP\Exception\BadDataException;
    use MathPHP\Exception\BadParameterException;
    use MathPHP\Exception\OutOfBoundsException;
    use MathPHP\Functions\Support;

    /**
     * Bernoulli distribution
     *
     * https://en.wikipedia.org/wiki/Bernoulli_distribution
     */
    class Bernoulli extends Discrete {
        /**
         * Distribution parameter bounds limits
         * p ∈ (0,1)
         *
         * @var array{"p": string, "q": string}
         */
        public const PARAMETER_LIMITS
            = [
                'p' => '(0,1)',
                'q' => '[0,1)',
            ];

        /**
         * Distribution support bounds limits
         * k ∈ [0,1]
         * p ∈ (0,1)
         *
         * @var array{"k": string}
         */
        public final const SUPPORT_LIMITS
            = [
                'k' => '[0,1]',
            ];

        /** @var float probability of success */
        protected float $p;

        protected float $q;

        /**
         * Constructor
         *
         * @param float $p success probability  0 < p < 1
         */
        public function __construct(float $p)
        {
            $q = 1 - $p;
            parent::__construct($p, $q);
        }

        public static function pmfIsBinomialWithNEqualsOne()
        {
        }

        /**
         * Probability mass function
         *
         * q = (1 - p)  for k = 0
         * p            for k = 1
         *
         * @param int $k number of successes  k ∈ {0, 1}
         *
         * @return float
         */
        public function pmf(int $k): float
        {
            try
            {
                Support::checkLimits(self::SUPPORT_LIMITS, ['k' => $k]);
            } catch (BadDataException|OutOfBoundsException|BadParameterException $e)
            {
            }

            if ($k === 0)
            {
                return $this->q;
            }

            return $this->p;
        }

        /**
         * Cumulative distribution function
         *
         * 0      for k < 0
         * 1 - p  for 0 ≤ k < 1
         * 1      for k ≥ 1
         *
         * @param int $k number of successes  k ∈ {0, 1}
         *
         * @return float
         */
        public function cdf(int $k): float
        {
            if ($k < 0)
            {
                return 0;
            }
            if ($k < 1)
            {
                return 1 - $this->p;
            }

            return 1;
        }

        /**
         * Mean of the distribution
         *
         * μ = p
         *
         * @return float
         */
        public function mean(): float
        {
            return $this->p;
        }

        /**
         * Median of the distribution
         *
         * 0    for p < ½
         * ½    for p = ½
         * 1    for p > ½
         *
         * @return float
         */
        public function median(): float
        {
            $p = $this->p;
            $½ = 0.5;

            if ($p < $½)
            {
                return 0;
            }
            if ($p == $½)
            {
                return $½;
            }

            return 1;
        }

        /**
         * Mode of the distribution
         *
         * 0    for p < ½
         * 0,1  for p = ½
         * 1    for p > ½
         *
         * @return float[]
         */
        public function mode(): array
        {
            $p = $this->p;
            $½ = 0.5;

            if ($p < $½)
            {
                return [0];
            }
            if ($p == $½)
            {
                return [0, 1];
            }

            return [1];
        }

        /**
         * Variance of the distribution
         *
         * σ² = p(1 - p) = pq
         *
         * @return float
         */
        public function variance(): float
        {
            return $this->p * $this->q;
        }
    }
