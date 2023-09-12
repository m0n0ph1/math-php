<?php

    namespace MathPHP\LinearAlgebra\Decomposition;

    use MathPHP\Exception;
    use MathPHP\LinearAlgebra\Householder;
    use MathPHP\LinearAlgebra\MatrixFactory;
    use MathPHP\LinearAlgebra\NumericMatrix;
    use MathPHP\LinearAlgebra\Vector;

    use function is_array;
    use function min;

    /**
     * QR Decomposition using Householder reflections
     *
     * A = QR
     *
     * Q is an orthogonal matrix
     * R is an upper triangular matrix
     *
     * @property-read NumericMatrix $Q orthogonal matrix
     * @property-read NumericMatrix $R upper triangular matrix
     */
    class QR extends Decomposition {
        /** @var NumericMatrix orthogonal matrix */
        private NumericMatrix $Q;

        /** @var NumericMatrix upper triangular matrix */
        private NumericMatrix $R;

        /**
         * QR constructor
         *
         * @param NumericMatrix $Q Orthogonal matrix
         * @param NumericMatrix $R Upper triangular matrix
         */
        private function __construct(NumericMatrix $Q, NumericMatrix $R)
        {
            $this->Q = $Q;
            $this->R = $R;
        }

        /**
         * Decompose a matrix into a QR Decomposition using Householder reflections
         * Factory method to create QR objects.
         *
         * A = QR
         *
         * Q is an orthogonal matrix
         * R is an upper triangular matrix
         *
         * Algorithm notes:
         *  If the source matrix is square or wider than it is tall, the final
         *  householder matrix will be the identity matrix with a -1 in the bottom
         *  corner. The effect of this final transformation would only change signs
         *  on existing matrices. Both R and Q will already be in appropriate forms
         *  in the next to the last step. We can skip the last transformation without
         *  affecting the validity of the results. Results indicate other software
         *  behaves similarly.
         *
         *  This is because on a 1x1 matrix uuᵀ = uᵀu, so I - [[2]] = [[-1]]
         *
         * @param NumericMatrix $A source Matrix
         *
         * @return QR
         *
         * @throws Exception\BadDataException
         * @throws Exception\IncorrectTypeException
         * @throws Exception\MathException
         * @throws Exception\MatrixException
         * @throws Exception\OutOfBoundsException
         * @throws Exception\VectorException
         */
        public static function decompose(NumericMatrix $A): QR
        {
            $n = $A->getN();  // columns
            $m = $A->getM();  // rows
            $HA = $A;

            $numReflections = min($m - 1, $n);
            $FullI = MatrixFactory::identity($m);
            $Q = $FullI;

            for ($i = 0; $i < $numReflections; $i++)
            {
                // Remove the leftmost $i columns and upper $i rows
                $A = $HA->submatrix($i, $i, $m - 1, $n - 1);

                // Create the householder matrix
                $innerH = Householder::transform($A);

                // Embed the smaller matrix within a full rank Identity matrix
                $H = $FullI->insert($innerH, $i, $i);
                $Q = $Q->multiply($H);
                $HA = $H->multiply($HA);
            }

            $R = $HA;

            return new QR(
                $Q->submatrix(0, 0, $m - 1, min($m, $n) - 1),
                $R->submatrix(0, 0, min($m, $n) - 1, $n - 1)
            );
        }

        /**
         * Solve linear system of equations
         * Ax = b
         *  where:
         *   A: Matrix
         *   x: unknown to solve for
         *   b: solution to linear system of equations (input to function)
         *
         * Use QR Decomposition and solve Ax = b.
         *
         * QR Decomposition:
         *  - Equation to solve: Ax = b
         *  - QR Decomposition produces: A = QR
         *  - Substitute to get QRx = b
         *  - Multiply both sides by Qᵀ to get QᵀQRx = Qᵀb
         *  - QᵀQ = I, so we get Rx = Qᵀb
         *  - Multiply both sides by R⁻¹ to get R⁻¹Rx = R⁻¹Qᵀb
         *  - R⁻¹R = I, so we get x = R⁻¹Qᵀb
         * Solve x = R⁻¹Qᵀb
         *
         * @param array<int|float>|Vector $b solution to Ax = b
         *
         * @return Vector x
         *
         * @throws \MathPHP\Exception\BadDataException
         * @throws \MathPHP\Exception\IncorrectTypeException if b is not a Vector or array
         */
        public function solve(array|Vector $b): Vector
        {
            // Input must be a Vector or array.
            if ( ! ($b instanceof Vector || is_array($b)))
                throw new Exception\IncorrectTypeException('b in Ax = b must be a Vector or array');
            if (is_array($b))
                $b = new Vector($b);

            try
            {
                $Qᵀ = $this->Q->transpose();
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            }
            try
            {
                $Qᵀb = $Qᵀ->multiply($b);
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            try
            {
                $R⁻¹ = $this->R->inverse();
            } catch (Exception\BadParameterException $e)
            {
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\OutOfBoundsException $e)
            {
            }
            try
            {
                $x = $R⁻¹->multiply($Qᵀb);
            } catch (Exception\IncorrectTypeException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            } catch (Exception\MathException $e)
            {
            }

            try
            {
                return new Vector($x->getColumn(0));
            } catch (Exception\BadDataException $e)
            {
            } catch (Exception\MatrixException $e)
            {
            }
        }

        /**
         * Get Q or R matrix
         *
         * @param string $name
         *
         * @return NumericMatrix
         *
         * @throws Exception\MatrixException
         */
        public function __get(string $name): NumericMatrix
        {
            return match ($name)
            {
                'Q', 'R' => $this->$name,
                default => throw new Exception\MatrixException("QR class does not have a gettable property: $name"),
            };
        }

        public function QRDecompositionSolveIncorrectTypeException()
        {
        }

        public function QRDecompositionInvalidProperty()
        {
        }

        public function qrDecompositionPropertyQTransposeEqualsQInverse()
        {
        }

        public function qrDecompositionPropertyREqualsQTransposeA()
        {
        }

        public function qrDecompositionOrthonormalMatrixQPropertyQTransposeQIsIdentity(
        )
        {
        }

        public function qrDecompositionResultMatrices()
        {
        }

        public function qrDecompositionPropertiesOfQR()
        {
        }

        public function qrDecompositionPropertyAEqualsQR()
        {
        }
    }
