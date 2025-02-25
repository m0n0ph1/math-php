<?php

    namespace MathPHP\LinearAlgebra;

    use MathPHP\Exception;

    use function array_column;
    use function array_merge;
    use function array_values;
    use function min;

    /**
     * m x n Matrix
     *
     * @template T
     * @implements \ArrayAccess<int, array<int, T>>
     */
    abstract class Matrix extends \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix,
                                  \MathPHP\LinearAlgebra\NumericMatrix
        implements ArrayAccess, JsonSerializable {
        /** @var int Number of rows */
        protected
        int $m;

        /** @var int Number of columns */
        protected int $n;

        /** @var array<array<T>> Matrix array of arrays */
        protected array $A;

        /** @var MatrixCatalog<T> */
        protected MatrixCatalog $catalog;

        /** @var float|null Error/zero tolerance */
        protected ?float $ε;

        /**************************************************************************
         * ABSTRACT METHODS
         *  - getObjectType
         **************************************************************************/

        /**
         * Get single row from the matrix
         *
         * @param int $i row index (from 0 to m - 1)
         *
         * @return array<T>
         *
         * @throws Exception\MatrixException if row i does not exist
         */
        public function getRow(int $i): array
        {
            if ($i >= $this->m)
            {
                throw new Exception\MatrixException("Row $i does not exist");
            }

            return $this->A[$i];
        }

        /**************************************************************************
         * BASIC MATRIX GETTERS
         *  - getMatrix
         *  - getM
         *  - getN
         *  - getRow
         *  - getColumn
         *  - get
         *  - getDiagonalElements
         *  - getSuperdiagonalElements
         *  - getSubdiagonalElements
         *  - asVectors
         **************************************************************************/

        /**
         * Get a specific value at row i, column j
         *
         * @param int $i row index
         * @param int $j column index
         *
         * @return T
         *
         * @throws Exception\MatrixException if row i or column j does not exist
         */
        public function get(int $i, int $j)
        {
            if ($i >= $this->m)
            {
                throw new Exception\MatrixException("Row $i does not exist");
            }
            if ($j >= $this->n)
            {
                throw new Exception\MatrixException("Column $j does not exist");
            }

            return $this->A[$i][$j];
        }

        /**
         * Returns the elements on the diagonal of a square matrix as an array
         *     [1 2 3]
         * A = [4 5 6]
         *     [7 8 9]
         *
         * getDiagonalElements($A) = [1, 5, 9]
         *
         * @return array<T>
         */
        public function getDiagonalElements(): array
        {
            $diagonal = [];
            for ($i = 0; $i < min($this->m, $this->n); $i++)
            {
                $diagonal[] = $this->A[$i][$i];
            }

            return $diagonal;
        }

        /**
         * Returns the elements on the superdiagonal of a square matrix as an array
         *     [1 2 3]
         * A = [4 5 6]
         *     [7 8 9]
         *
         * getSuperdiagonalElements($A) = [2, 6]
         *
         * http://mathworld.wolfram.com/Superdiagonal.html
         *
         * @return array<T>
         */
        #[Pure] public function getSuperdiagonalElements(): array
        {
            $superdiagonal = [];
            if ($this->isSquare())
            {
                for ($i = 0; $i < $this->m - 1; $i++)
                {
                    $superdiagonal[] = $this->A[$i][$i + 1];
                }
            }

            return $superdiagonal;
        }

        /**
         * Is the matrix a square matrix?
         * Do rows m = columns n?
         *
         * @return bool true if square; false otherwise.
         */
        public function isSquare(): bool
        {
            return $this->m === $this->n;
        }

        /**
         * Returns the elements on the subdiagonal of a square matrix as an array
         *     [1 2 3]
         * A = [4 5 6]
         *     [7 8 9]
         *
         * getSubdiagonalElements($A) = [4, 8]
         *
         * http://mathworld.wolfram.com/Subdiagonal.html
         *
         * @return array<T>
         */
        #[Pure] public function getSubdiagonalElements(): array
        {
            $subdiagonal = [];
            if ($this->isSquare())
            {
                for ($i = 1; $i < $this->m; $i++)
                {
                    $subdiagonal[] = $this->A[$i][$i - 1];
                }
            }

            return $subdiagonal;
        }

        /**
         * Returns an array of vectors from the columns of the matrix.
         * Each column of the matrix becomes a vector.
         *
         *     [1 2 3]
         * A = [4 5 6]
         *     [7 8 9]
         *
         *           [1] [2] [3]
         * Vectors = [4] [5] [6]
         *           [7] [8] [9]
         *
         * @return Vector[]
         * @throws \MathPHP\Exception\BadDataException
         */
        public function asVectors(): array
        {
            $n = $this->n;
            $vectors = [];

            for ($j = 0; $j < $n; $j++)
            {
                $vectors[] = new Vector(array_column($this->A, $j));
            }

            return $vectors;
        }

        /**
         * Returns an array of vectors from the columns of the matrix.
         * Each column of the matrix becomes a vector.
         *
         *     [1 2 3]
         * A = [4 5 6]
         *     [7 8 9]
         *
         *           [1] [4] [7]
         * Vectors = [2] [5] [8]
         *           [3] [6] [9]
         *
         * @return Vector[]
         */
        public function asRowVectors(): array
        {
            // @phpstan-ignore-next-line (Vector expects numbers, Matrix may be generic T)
            $array_map = [];
            foreach ($this->A as $ignored => array $row)

            return $array_map;
        }

        /**
         * Augment a matrix
         * An augmented matrix is a matrix obtained by appending the columns of two given matrices
         *
         *     [1, 2, 3]
         * A = [2, 3, 4]
         *     [3, 4, 5]
         *
         *     [4]
         * B = [5]
         *     [6]
         *
         *         [1, 2, 3 | 4]
         * (A|B) = [2, 3, 4 | 5]
         *         [3, 4, 5 | 6]
         *
         * @param Matrix<T> $B Matrix columns to add to matrix A
         *
         * @return static
         *
         * @throws \MathPHP\Exception\MatrixException if matrices do not have the same number of rows
         */
        public function augment(Matrix $B): Matrix
        {
            if ($this->getObjectType() !== $B->getObjectType())
            {
                throw new Exception\MatrixException('Matrices must be the same type.');
            }
            if ($B->getM() !== $this->m)
            {
                throw new Exception\MatrixException('Matrices to augment do not have the same number of rows');
            }

            $m = $this->m;
            $A = $this->A;
            $B = $B->getMatrix();
            $⟮A∣B⟯ = [];

            for ($i = 0; $i < $m; $i++)
            {
                $⟮A∣B⟯[$i] = array_merge($A[$i], $B[$i]);
            }

            /** @var array<array<float|int|object>> $⟮A∣B⟯ */
            /** @var static $this */
            try
            {
                return MatrixFactory::create($⟮A∣B⟯, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * What type of data does the matrix contain
         *
         * @return string the type of data in the Matrix
         */
        abstract public function getObjectType(): string;

        /**
         * Get row count (m)
         *
         * @return int number of rows
         */
        public function getM(): int
        {
            return $this->m;
        }

        /**
         * Get matrix
         *
         * @return array<array<T>> of arrays
         */
        public function getMatrix(): array
        {
            return $this->A;
        }

        /***************************************************************************
         * MATRIX COMPARISONS
         *  - isEqualSizeAndType
         ***************************************************************************/

        /**
         * Augment a matrix on the left
         * An augmented matrix is a matrix obtained by preprending the columns of two given matrices
         *
         *     [1, 2, 3]
         * A = [2, 3, 4]
         *     [3, 4, 5]
         *
         *     [4]
         * B = [5]
         *     [6]
         *
         *         [4 | 1, 2, 3]
         * (A|B) = [5 | 2, 3, 4]
         *         [6 | 3, 4, 5]
         *
         * @param Matrix<T> $B Matrix columns to add to matrix A
         *
         * @return static
         *
         * @throws \MathPHP\Exception\MatrixException if matrices do not have the same number of rows
         */
        public function augmentLeft(Matrix $B): Matrix
        {
            if ($this->getObjectType() !== $B->getObjectType())
            {
                throw new Exception\MatrixException('Matrices must be the same type.');
            }
            if ($B->getM() !== $this->m)
            {
                throw new Exception\MatrixException('Matrices to augment do not have the same number of rows');
            }

            $m = $this->m;
            $A = $this->A;
            $B = $B->getMatrix();
            $⟮B∣A⟯ = [];

            for ($i = 0; $i < $m; $i++)
            {
                $⟮B∣A⟯[$i] = array_merge($B[$i], $A[$i]);
            }

            /** @var array<array<float|int|object>> $⟮B∣A⟯ */
            /** @var static $this */
            try
            {
                return MatrixFactory::create($⟮B∣A⟯, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**************************************************************************
         * MATRIX PROPERTIES
         *  - isSquare
         **************************************************************************/

        /**
         * Augment a matrix from below
         * An augmented matrix is a matrix obtained by appending the rows of two given matrices
         *
         *     [1, 2, 3]
         * A = [2, 3, 4]
         *     [3, 4, 5]
         *
         * B = [4, 5, 6]
         *
         *         [1, 2, 3]
         * (A_B) = [2, 3, 4]
         *         [3, 4, 5]
         *         [4, 5, 6]
         *
         * @param Matrix<T> $B Matrix rows to add to matrix A
         *
         * @return static
         *
         * @throws \MathPHP\Exception\MatrixException if matrices do not have the same number of columns
         */
        public function augmentBelow(Matrix $B): Matrix
        {
            if ($this->getObjectType() !== $B->getObjectType())
            {
                throw new Exception\MatrixException('Matrices must be the same type.');
            }
            if ($B->getN() !== $this->n)
            {
                throw new Exception\MatrixException('Matrices to augment do not have the same number of columns');
            }

            /** @var array<array<float|int|object>> $⟮A∣B⟯ */
            $⟮A∣B⟯ = array_merge($this->A, $B->getMatrix());

            /** @var static $this */
            try
            {
                return MatrixFactory::create($⟮A∣B⟯, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**************************************************************************
         * MATRIX AUGMENTATION - Return a Matrix
         *  - augment
         *  - augmentBelow
         *  - augmentAbove
         *  - augmentLeft
         **************************************************************************/

        /**
         * Get column count (n)
         *
         * @return int number of columns
         */
        public function getN(): int
        {
            return $this->n;
        }

        /**
         * Augment a matrix from above
         * An augmented matrix is a matrix obtained by prepending the rows of two given matrices
         *
         *     [1, 2, 3]
         * A = [2, 3, 4]
         *     [3, 4, 5]
         *
         * B = [4, 5, 6]
         *
         *         [4, 5, 6]
         *         [1, 2, 3]
         * (A_B) = [2, 3, 4]
         *         [3, 4, 5]
         *
         * @param Matrix<T> $B Matrix rows to add to matrix A
         *
         * @return static
         *
         * @throws Exception\BadDataException
         * @throws Exception\IncorrectTypeException
         * @throws Exception\MathException
         * @throws Exception\MatrixException
         */
        public function augmentAbove(Matrix $B): Matrix
        {
            if ($this->getObjectType() !== $B->getObjectType())
            {
                throw new Exception\MatrixException('Matrices must be the same type.');
            }
            if ($B->getN() !== $this->n)
            {
                throw new Exception\MatrixException('Matrices to augment do not have the same number of columns');
            }

            /** @var array<array<float|int|object>> $⟮A∣B⟯ */
            $⟮A∣B⟯ = array_merge($B->getMatrix(), $this->A);

            /** @var static */
            return MatrixFactory::create($⟮A∣B⟯, $this->ε);
        }

        /**
         * Submatrix
         *
         * Return an arbitrary subset of a Matrix as a new Matrix.
         *
         * @param int $m₁ Starting row
         * @param int $n₁ Starting column
         * @param int $m₂ Ending row
         * @param int $n₂ Ending column
         *
         * @return static
         *
         * @throws \MathPHP\Exception\MatrixException
         */
        public function submatrix(int $m₁, int $n₁, int $m₂, int $n₂): Matrix
        {
            if (($m₁ >= $this->m) || ($m₁ < 0) || ($m₂ >= $this->m)
                || ($m₂ < 0)
            )
            {
                throw new Exception\MatrixException('Specified Matrix row does not exist');
            }
            if (($n₁ >= $this->n) || ($n₁ < 0) || ($n₂ >= $this->n)
                || ($n₂ < 0)
            )
            {
                throw new Exception\MatrixException('Specified Matrix column does not exist');
            }
            if ($m₂ < $m₁)
            {
                throw new Exception\MatrixException('Ending row must be greater than beginning row');
            }
            if ($n₂ < $n₁)
            {
                throw new Exception\MatrixException('Ending column must be greater than the beginning column');
            }

            $A = [];
            for ($i = 0; $i <= $m₂ - $m₁; $i++)
            {
                for ($j = 0; $j <= $n₂ - $n₁; $j++)
                {
                    $A[$i][$j] = $this->A[$i + $m₁][$j + $n₁];
                }
            }

            /** @var static $this */
            try
            {
                return MatrixFactory::create($A, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * Insert
         * Insert a smaller matrix within a larger matrix starting at a specified position
         *
         * @param Matrix<T> $small the smaller matrix to embed
         * @param int       $m     Starting row
         * @param int       $n     Starting column
         *
         * @return static
         *
         * @throws \MathPHP\Exception\MatrixException
         */
        public function insert(Matrix $small, int $m, int $n): Matrix
        {
            if ($this->getObjectType() !== $small->getObjectType())
            {
                throw new Exception\MatrixException('Matrices must be the same type.');
            }
            if (($small->getM() + $m > $this->m)
                || ($small->getN() + $n > $this->n)
            )
            {
                throw new Exception\MatrixException('Inner matrix exceeds the bounds of the outer matrix');
            }

            $new_array = $this->A;
            for ($i = 0; $i < $small->getM(); $i++)
            {
                for ($j = 0; $j < $small->getN(); $j++)
                {
                    $new_array[$i + $m][$j + $n] = $small[$i][$j];
                }
            }

            /** @var static $this */
            try
            {
                return MatrixFactory::create($new_array, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**************************************************************************
         * MATRIX OPERATIONS - Return a Matrix
         *  - transpose
         *  - submatrix
         *  - insert
         **************************************************************************/

        /**
         * Map a function over all elements of the matrix
         *
         * @param callable $func takes a matrix item as input
         *
         * @return static
         *
         */
        public function map(callable $func): Matrix
        {
            $m = $this->m;
            $n = $this->n;
            $R = [];

            for ($i = 0; $i < $m; $i++)
            {
                for ($j = 0; $j < $n; $j++)
                {
                    $R[$i][$j] = $func($this->A[$i][$j]);
                }
            }

            /** @var static $this */
            try
            {
                return MatrixFactory::create($R, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * Map a function over the rows of the matrix
         *
         * @param callable $func
         *
         * @return array<T>|array<array<T>> Depends on the function
         */
        public function mapRows(callable $func): array
        {
            $array_map = [];
            foreach ($this->A as $key => $value)
            {
                $array_map[$key] = $func($this->A[$key]);
            }

            return $array_map;
        }

        /**
         * Walk a function over all elements of the matrix
         *
         * @param callable $func
         */
        public function walk(callable $func): void
        {
            $m = $this->m;
            $n = $this->n;

            for ($i = 0; $i < $m; $i++)
            {
                for ($j = 0; $j < $n; $j++)
                {
                    $func($this->A[$i][$j]);
                }
            }
        }

        /**************************************************************************
         * MATRIX MAPPING
         *  - map
         *  - mapRows
         **************************************************************************/

        /**
         * Interchange two rows
         *
         * Row mᵢ changes to position mⱼ
         * Row mⱼ changes to position mᵢ
         *
         * @param int $mᵢ Row to swap into row position mⱼ
         * @param int $mⱼ Row to swap into row position mᵢ
         *
         * @return static with rows mᵢ and mⱼ interchanged
         *
         * @throws \MathPHP\Exception\MatrixException if row to interchange does not exist
         */
        public function rowInterchange(int $mᵢ, int $mⱼ): Matrix
        {
            if (($mᵢ >= $this->m) || ($mⱼ >= $this->m))
            {
                throw new Exception\MatrixException('Row to interchange does not exist');
            }

            $m = $this->m;
            $R = [];

            for ($i = 0; $i < $m; $i++)
                switch ($i)
                {
                    case $mᵢ:
                        $R[$i] = $this->A[$mⱼ];
                        break;
                    case $mⱼ:
                        $R[$i] = $this->A[$mᵢ];
                        break;
                    default:
                        $R[$i] = $this->A[$i];
                }

            /** @var static $this */
            try
            {
                return MatrixFactory::create($R, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * Interchange two columns
         *
         * Column nᵢ changes to position nⱼ
         * Column nⱼ changes to position nᵢ
         *
         * @param int $nᵢ Column to swap into column position nⱼ
         * @param int $nⱼ Column to swap into column position nᵢ
         *
         * @return static with columns nᵢ and nⱼ interchanged
         *
         * @throws \MathPHP\Exception\MatrixException if column to interchange does not exist
         */
        public function columnInterchange(int $nᵢ, int $nⱼ): Matrix
        {
            if (($nᵢ >= $this->n) || ($nⱼ >= $this->n))
            {
                throw new Exception\MatrixException('Column to interchange does not exist');
            }

            $m = $this->m;
            $n = $this->n;
            $R = [];

            for ($i = 0; $i < $m; $i++)
                for ($j = 0; $j < $n; $j++)
                    switch ($j)
                    {
                        case $nᵢ:
                            $R[$i][$j] = $this->A[$i][$nⱼ];
                            break;
                        case $nⱼ:
                            $R[$i][$j] = $this->A[$i][$nᵢ];
                            break;
                        default:
                            $R[$i][$j] = $this->A[$i][$j];
                    }

            /** @var static $this */
            try
            {
                return MatrixFactory::create($R, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * Conjugate Transpose - Aᴴ, also denoted as A*
         *
         * Returns the complex conjugate of the transpose. For a real matrix, this is the same as the transpose.
         *
         * https://en.wikipedia.org/wiki/Conjugate_transpose
         *
         * @return static
         */
        public function conjugateTranspose(): Matrix
        {
            return $this->transpose();
        }

        /**************************************************************************
         * ROW OPERATIONS - Return a Matrix
         *  - rowInterchange
         *  - rowExclude
         **************************************************************************/

        /**
         * Transpose matrix
         *
         * The transpose of a matrix A is another matrix Aᵀ:
         *  - reflect A over its main diagonal (which runs from top-left to bottom-right) to obtain AT
         *  - write the rows of A as the columns of AT
         *  - write the columns of A as the rows of AT
         * Formally, the i th row, j th column element of Aᵀ is the j th row, i th column element of A.
         * If A is an m × n matrix then Aᵀ is an n × m matrix.
         * https://en.wikipedia.org/wiki/Transpose
         *
         * @return static
         *
         * @throws \MathPHP\Exception\MatrixException
         */
        public function transpose(): Matrix
        {
            if ($this->catalog->hasTranspose())
            {
                /** @var static */
                return $this->catalog->getTranspose();
            }

            $Aᵀ = [];
            for ($i = 0; $i < $this->n; $i++)
            {
                $Aᵀ[$i] = $this->getColumn($i);
            }

            // @phpstan-ignore-next-line
            try
            {
                $this->catalog->addTranspose(MatrixFactory::create($Aᵀ,
                    $this->ε));
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }

            /** @var static */
            return $this->catalog->getTranspose();
        }

        /**
         * Get single column from the matrix
         *
         * @param int $j column index (from 0 to n - 1)
         *
         * @return array<T>
         *
         * @throws Exception\MatrixException if column j does not exist
         */
        public function getColumn(int $j): array
        {
            if ($j >= $this->n)
            {
                throw new Exception\MatrixException("Column $j does not exist");
            }

            return array_column($this->A, $j);
        }

        /**************************************************************************
         * COLUMN OPERATIONS - Return a Matrix
         *  - columnInterchange
         *  - columnExclude
         **************************************************************************/

        /**
         * Leading principal minor
         * The leading principal minor of A of order k is the minor of order k
         * obtained by deleting the last n − k rows and columns.
         *
         * Example:
         *
         *     [1 2 3]
         * A = [4 5 6]
         *     [7 8 9]
         *
         * 1st order (k = 1): [1]
         *
         *                    [1 2]
         * 2nd order (k = 2): [4 5]
         *
         *                    [1 2 3]
         * 3rd order (k = 3): [4 5 6]
         *                    [7 8 9]
         *
         * @param int $k Order of the leading principal minor
         *
         * @return static
         *
         * @throws \MathPHP\Exception\MatrixException if matrix is not square
         * @throws \MathPHP\Exception\OutOfBoundsException if k > n
         */
        public function leadingPrincipalMinor(int $k): Matrix
        {
            if ($k <= 0)
            {
                throw new Exception\OutOfBoundsException("k is ≤ 0: $k");
            }
            if ($k > $this->n)
            {
                throw new Exception\OutOfBoundsException("k ($k) leading principal minor is larger than size of Matrix: "
                    .$this->n);
            }
            if ( ! $this->isSquare())
            {
                throw new Exception\MatrixException('Matrix is not square; cannot get leading principal minor Matrix of a non-square matrix');
            }

            $R = [];
            for ($i = 0; $i < $k; $i++)
            {
                for ($j = 0; $j < $k; $j++)
                {
                    $R[$i][$j] = $this->A[$i][$j];
                }
            }

            /** @var static $this */
            try
            {
                return MatrixFactory::create($R, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * Minor (first minor)
         * The determinant of some smaller square matrix, cut down from A by removing one of its rows and columns.
         *
         *        [1 4  7]
         * If A = [3 0  5]
         *        [1 9 11]
         *
         *                [1 4 -]       [1 4]
         * Then M₁₂ = det [- - -] = det [1 9] = 13
         *                [1 9 -]
         *
         * https://en.wikipedia.org/wiki/Minor_(linear_algebra)
         *
         * @param int $mᵢ Row to exclude
         * @param int $nⱼ Column to exclude
         *
         * @return T
         *
         * @throws Exception\MatrixException if matrix is not square
         * @throws Exception\MatrixException if row to exclude for minor does not exist
         * @throws Exception\MatrixException if column to exclude for minor does not exist
         * @throws Exception\IncorrectTypeException
         * @throws Exception\BadParameterException
         */
        public function minor(int $mᵢ, int $nⱼ)
        {
            if ( ! $this->isSquare())
            {
                throw new Exception\MatrixException('Matrix is not square; cannot get minor of a non-square matrix');
            }
            if (($mᵢ >= $this->m) || ($mᵢ < 0))
            {
                throw new Exception\MatrixException('Row to exclude for minor does not exist');
            }
            if (($nⱼ >= $this->n) || ($nⱼ < 0))
            {
                throw new Exception\MatrixException('Column to exclude for minor does not exist');
            }

            /** @var ObjectMatrix|NumericMatrix $minorMatrix */
            $minorMatrix = $this->minorMatrix($mᵢ, $nⱼ);

            /** @var T */
            return $minorMatrix->det();
        }

        /**************************************************************************
         * MATRIX OPERATIONS - Return a Matrix
         *  - conjugateTranspose
         *  - minorMatrix
         *  - leadingPrincipalMinor
         **************************************************************************/

        /**
         * Minor matrix
         * Submatrix formed by deleting the iᵗʰ row and jᵗʰ column.
         * Used in computing the minor Mᵢⱼ.
         *
         * @param int $mᵢ Row to exclude
         * @param int $nⱼ Column to exclude
         *
         * @return static with row mᵢ and column nⱼ removed
         *
         * @throws Exception\MatrixException if matrix is not square
         * @throws Exception\MatrixException if row to exclude for minor matrix does not exist
         * @throws Exception\MatrixException if column to exclude for minor matrix does not exist
         */
        public function minorMatrix(int $mᵢ, int $nⱼ): Matrix
        {
            if ( ! $this->isSquare())
            {
                throw new Exception\MatrixException('Matrix is not square; cannot get minor Matrix of a non-square matrix');
            }
            if (($mᵢ >= $this->m) || ($mᵢ < 0))
            {
                throw new Exception\MatrixException('Row to exclude for minor Matrix does not exist');
            }
            if (($nⱼ >= $this->n) || ($nⱼ < 0))
            {
                throw new Exception\MatrixException('Column to exclude for minor Matrix does not exist');
            }

            return $this->rowExclude($mᵢ)->columnExclude($nⱼ);
        }

        /**
         * Exclude a column from the result matrix
         *
         * @param int $nᵢ Column to exclude
         *
         * @return static with column nᵢ excluded
         *
         * @throws \MathPHP\Exception\MatrixException if column to exclude does not exist
         */
        public function columnExclude(int $nᵢ): Matrix
        {
            if (($nᵢ >= $this->n) || ($nᵢ < 0))
            {
                throw new Exception\MatrixException('Column to exclude does not exist');
            }

            $m = $this->m;
            $n = $this->n;
            $R = [];

            for ($i = 0; $i < $m; $i++)
            {
                for ($j = 0; $j < $n; $j++)
                {
                    if ($j === $nᵢ)
                    {
                        continue;
                    }
                    $R[$i][$j] = $this->A[$i][$j];
                }
            }

            // Reset column indexes
            for ($i = 0; $i < $m; $i++)
            {
                $R[$i] = array_values($R[$i]);
            }

            /** @var static $this */
            try
            {
                return MatrixFactory::create($R, $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**
         * Exclude a row from the result matrix
         *
         * @param int $mᵢ Row to exclude
         *
         * @return static with row mᵢ excluded
         *
         * @throws \MathPHP\Exception\MatrixException if row to exclude does not exist
         */
        public function rowExclude(int $mᵢ): Matrix
        {
            if (($mᵢ >= $this->m) || ($mᵢ < 0))
            {
                throw new Exception\MatrixException('Row to exclude does not exist');
            }

            $m = $this->m;
            $R = [];

            for ($i = 0; $i < $m; $i++)
            {
                if ($i === $mᵢ)
                {
                    continue;
                }
                $R[$i] = $this->A[$i];
            }

            /** @var static $this */
            try
            {
                return MatrixFactory::create(array_values($R), $this->ε);
            } catch (Exception\BadDataException|Exception\MathException|Exception\MatrixException|Exception\IncorrectTypeException $e)
            {
            }
        }

        /**************************************************************************
         * MATRIX OPERATIONS - Return a value
         *  - minor
         **************************************************************************/

        /**
         * @param int $i
         *
         * @return bool
         */
        public function offsetExists($i): bool
        {
            return isset($this->A[$i]);
        }

        /**************************************************************************
         * ArrayAccess INTERFACE
         **************************************************************************/

        /**
         * @param int $i
         *
         * @return array<T>
         */
        #[ReturnTypeWillChange]
        public function offsetGet($i): array
        {
            return $this->A[$i];
        }

        /**
         * @param int      $i
         * @param array<T> $value
         *
         * @throws Exception\MatrixException
         */
        public function offsetSet($i, $value): void
        {
            throw new Exception\MatrixException('Matrix class does not allow setting values');
        }

        /**
         * @param int $i
         *
         * @throws Exception\MatrixException
         */
        public function offsetUnset($i): void
        {
            throw new Exception\MatrixException('Matrix class does not allow unsetting values');
        }

        /**
         * @return array<array<T>>
         */
        public function jsonSerialize(): array
        {
            return $this->A;
        }

        public static function toString()
        {
        }

        public static function arrayAccessOffsetUnsetException()
        {
        }

        public static function arrayAccessInterfaceOffExists()
        {
        }

        public static function arrayAccessInterfaceOffsetSet()
        {
        }

        public static function arrayAccessInterfaceOffsetGet()
        {
        }

        public static function rawConstructorExceptionNCountDiffers()
        {
        }

        public static function constructorExceptionNCountDiffers()
        {
        }

        public static function interfaces()
        {
        }

        /**************************************************************************
         * JsonSerializable INTERFACE
         **************************************************************************/

        /**
         * Is this matrix the same size and type as some other matrix?
         *
         * @param Matrix<T> $B
         *
         * @return bool
         */
        protected function isEqualSizeAndType(Matrix $B): bool
        {
            if ($this->getObjectType() !== $B->getObjectType())
            {
                return FALSE;
            }

            $m = $this->m;
            $n = $this->n;

            // Same dimensions
            if (($m != $B->m) || ($n != $B->n))
            {
                return FALSE;
            }

            return TRUE;
        }
    }
