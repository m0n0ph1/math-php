<?php

    namespace MathPHP\Probability\Distribution\Discrete;

    use MathPHP\Exception\BadDataException;
    use MathPHP\Exception\BadParameterException;
    use MathPHP\Exception\OutOfBoundsException;
    use MathPHP\Functions\Special;
    use MathPHP\Functions\Support;
    use MathPHP\Probability\Combinatorics;

    use function ceil;
    use function floor;
    use function max;
    use function min;

    /**
     * Hypergeometric distribution
     *
     * https://en.wikipedia.org/wiki/Hypergeometric_distribution
     */
    class Hypergeometric extends Discrete {
        /**
         * Distribution parameter bounds limits
         * N ∈ [0,∞)
         * K ∈ [0,N]
         * n ∈ [0,N]
         * k ∈ [\max(0, n + K - N),min(n, K)]
         *
         * @var array{"N": string, "K": string, "n": string}
         */
        public const PARAMETER_LIMITS
            = [
                'N' => '[0,∞)',
                'K' => '[0,∞]', // Dynamically checked in constructor
                'n' => '[0,∞]', // Dynamically checked in constructor
            ];

        /** @var array<string, string> */
        protected array $support_limit;

        protected int $N;

        protected int $K;

        protected int $n;

        /**
         * Constructor
         *
         * N ∈ {0, 1, 2, ...}
         * K ∈ {0, 1, 2, ..., N}
         * n ∈ {0, 1, 2, ..., N}
         *
         * @param int $N population size
         * @param int $K number of success states in the population
         * @param int $n number of draws
         */
        public function __construct(int $N, int $K, int $n)
        {
            parent::__construct($N, $K, $n);

            $dynamic_parameter_limits = [
                'K' => "[0, $N]",
                'n' => "[0, $N]",
            ];
            try
            {
                Support::checkLimits($dynamic_parameter_limits,
                    ['K' => $K, 'n' => $n]);
            } catch (BadDataException|OutOfBoundsException|BadParameterException $e)
            {
            }

            $this->support_limit = [
                'k' => '['.max(0, ($n + $K) - $N).','.min($n, $K).']',
            ];
        }

        /**
         * Probability mass function
         *
         * The probability of k successes in n draws, without replacement, from a finite population of size N
         * that contains exactly K successes, wherein each draw is either a success or a failure.
         *
         *       (K)(N - K)
         *       (k)(n - k)
         * pmf = ----------
         *          (N)
         *          (n)
         *
         * N is the population size,
         * K is the number of success states in the population,
         * n is the number of draws,
         * k is the number of observed successes,
         * (a)
         * (b) is a binomial coefficient.
         *
         * N ∈ {0, 1, 2, ...}
         * K ∈ {0, 1, 2, ..., N}
         * n ∈ {0, 1, 2, ..., N}
         * k ∈ {max(0, n + K - N), ..., min(n, K)}
         *
         * @param int $k number of observed successes
         *
         * @return float
         */
        public function pmf(int $k): float
        {
            try
            {
                Support::checkLimits($this->support_limit, ['k' => $k]);
            } catch (BadDataException|OutOfBoundsException|BadParameterException $e)
            {
            }

            $N = $this->N;
            $K = $this->K;
            $n = $this->n;

            try
            {
                $KCk = Combinatorics::combinations($K, $k);
            } catch (OutOfBoundsException $e)
            {
            }
            try
            {
                $⟮N − K⟯C⟮n − k⟯ = Combinatorics::combinations($N - $K,
                    $n - $k);
            } catch (OutOfBoundsException $e)
            {
            }
            try
            {
                $NCn = Combinatorics::combinations($N, $n);
            } catch (OutOfBoundsException $e)
            {
            }

            return ($KCk * $⟮N − K⟯C⟮n − k⟯) / $NCn;
        }

        /**
         * Cumulative distribution function
         *
         *           (  n  )(  N - n  )      _                           _
         *           (k + 1)(K - k - 1)     | 1, k + 1 - K, k + 1 - n      |
         * cdf = 1 - ------------------ ₃F₂ |                          ; 1 |
         *                  (N)             | k + 2, N + k + 2 - K - n     |
         *                  (K)             |_                            _|
         *
         * N is the population size,
         * K is the number of success states in the population,
         * n is the number of draws,
         * k is the number of observed successes,
         * (a)
         * (b) is a binomial coefficient.
         * ₃F₂ is the generalized hypergeometric function
         *
         * N ∈ {0, 1, 2, ...}
         * K ∈ {0, 1, 2, ..., N}
         * n ∈ {0, 1, 2, ..., N}
         * k ∈ {max(0, n + K - N), ..., min(n, K)}
         *
         * @param int $k number of observed successes
         *
         * @return float
         */
        public function cdf(int $k): float
        {
            try
            {
                Support::checkLimits($this->support_limit, ['k' => $k]);
            } catch (BadDataException|OutOfBoundsException|BadParameterException $e)
            {
            }

            $N = $this->N;
            $K = $this->K;
            $n = $this->n;

            try
            {
                $nC⟮k ＋ 1⟯ = Combinatorics::combinations($n, $k + 1);
            } catch (OutOfBoundsException $e)
            {
            }
            try
            {
                $⟮N − n⟯C⟮K − k − 1⟯ = Combinatorics::combinations($N - $n,
                    $K - $k - 1);
            } catch (OutOfBoundsException $e)
            {
            }
            try
            {
                $NCK = Combinatorics::combinations($N, $K);
            } catch (OutOfBoundsException $e)
            {
            }

            try
            {
                $₃F₂ = Special::generalizedHypergeometric(3, 2, 1,
                    ($k + 1) - $K,
                    ($k + 1) - $n, $k + 2, ($N + $k + 2) - $K - $n, 1);
            } catch (BadParameterException $e)
            {
            }

            return ($nC⟮k ＋ 1⟯ * $⟮N − n⟯C⟮K − k − 1⟯ / $NCK) * $₃F₂;
        }

        /**
         * Distribution mean
         *
         *       K
         * μ = n -
         *       N
         *
         * N is the population size,
         * K is the number of success states in the population,
         * n is the number of draws,
         *
         * N ∈ {0, 1, 2, ...}
         * K ∈ {0, 1, 2, ..., N}
         * n ∈ {0, 1, 2, ..., N}
         * k ∈ {max(0, n + K - N), ..., min(n, K)}
         *
         * @return float
         */
        public function mean(): float
        {
            return $this->n * ($this->K / $this->N);
        }

        /**
         * Mode of the distribution
         *
         *         _              _
         *        | (n + 1)(K + 1) |       | (n + 1)(K + 1) |
         * mode = | -------------- | - 1,  | -------------- |
         *        |    (N + 2)     |       |_    (N + 2)   _|
         *
         * @return float[]
         */
        public function mode(): array
        {
            $N = $this->N;
            $K = $this->K;
            $n = $this->n;

            return [
                ceil((($n + 1) * ($K + 1)) / ($N + 2)) - 1,
                floor((($n + 1) * ($K + 1)) / ($N + 2)),
            ];
        }

        /**
         * Variance of the distribution
         *
         *        K (N - K) N - n
         * σ² = n - ------- -----
         *        N    N    N - 1
         *
         * @return float
         */
        public function variance(): float
        {
            $N = $this->N;
            $K = $this->K;
            $n = $this->n;

            return $n * ($K / $N) * (($N - $K) / $N) * (($N - $n) / ($N - 1));
        }
    }
