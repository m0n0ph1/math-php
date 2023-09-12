<?php

    namespace MathPHP\Probability\Distribution\Discrete;

    use MathPHP\Exception;

    use function array_sum;
    use function count;
    use function round;

    /**
     * Categorical distribution
     *
     * https://en.wikipedia.org/wiki/Categorical_distribution
     *
     * @property-read int   $k             number of categories
     * @property-read array $probabilities probabilities of each category
     */
    class Categorical extends Discrete {
        public const PARAMETER_LIMITS = [];

        /** @var int number of categories */
        private int $k;

        /**
         * @var array<int|string, int|float>
         * Probability of each category
         * If associative array, category names are keys.
         * Otherwise, category names are array indexes.
         */
        private array $probabilities;

        /**
         * Distribution constructor
         *
         * @param int                          $k             number of categories
         * @param array<int|string, int|float> $probabilities of each category - If associative array, category names are keys.
         *                                                    Otherwise, category names are array indexes.
         *
         * @throws Exception\BadParameterException if k does not indicate at least one category
         * @throws Exception\BadDataException      if there are not k probabilities
         * @throws Exception\BadDataException      if the probabilities do not add up to 1
         */
        public function __construct(int $k, array $probabilities)
        {
            // Must have at least one category
            if ($k <= 0)
                throw new Exception\BadParameterException("k (number of categories) must be > 0. Given $k");

            // Must have k number of probabilities
            if (count($probabilities) != $k)
                throw new Exception\BadDataException("Must have $k probabilities. Given "
                    .count($probabilities));

            // Probabilities must add up to 1
            if (round(array_sum($probabilities), 1) != 1)
                throw new Exception\BadDataException('Probabilities do not add up to 1.');

            $this->k = $k;
            $this->probabilities = $probabilities;

            parent::__construct();
        }

        /**
         * Probability mass function
         *
         * pmf = p(x = i) = pᵢ
         *
         * @param float|int $x category name/number
         *
         * @return float
         *
         * @throws Exception\BadDataException if x is not a valid category
         */
        public function pmf(float|int $x): float
        {
            if ( ! isset($this->probabilities[$x]))
                throw new Exception\BadDataException("$x is not a valid category");

            return $this->probabilities[$x];
        }

        /**
         * Mode of the distribution
         *
         * i such that pᵢ = \max(p₁, ... pk)
         *
         * @return int|string|null Category name/number. Only returns one category in case on multimodal scenario.
         */
        public function mode(): mixed
        {
            $category = NULL;
            $pmax = 0;

            foreach ($this->probabilities as $i => $pᵢ)
                if ($pᵢ > $pmax)
                {
                    $pmax = $pᵢ;
                    $category = $i;
                }

            return $category;
        }

        /**
         * Magic getter for k and probabilities
         *
         * @param string $name
         *
         * @return int|array
         *
         * @throws Exception\BadDataException if $name is not a valid parameter
         */
        public function __get(string $name)
        {
            return match ($name)
            {
                'k', 'probabilities' => $this->{$name},
                default => throw new Exception\BadDataException("$name is not a valid gettable parameter"),
            };
        }

        public function getException()
        {
        }

        public function get()
        {
        }

        public function pmfException()
        {
        }

        public function badProbabilities()
        {
        }

        public function badCount()
        {
        }

        public function badK()
        {
        }
    }
