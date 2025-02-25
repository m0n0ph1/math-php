<?php

    namespace MathPHP\Tests\Probability\Distribution\Continuous;

    use MathPHP\Exception;
    use MathPHP\Probability\Distribution\Continuous\Beta;
    use PHPUnit\Framework\TestCase;

    use function abs;
    use function is_numeric;
    use function range;

    class BetaTest extends TestCase {
        /**
         * @return array [x, α, β, pdf]
         * Generated with http://keisan.casio.com/exec/system/1180573226
         */
        public static function dataProviderForPdf(): array
        {
            return [
                [0, 1, 1, 1],
                [0.01, 1, 1, 1],
                [0.15, 1, 1, 1],
                [0.81, 1, 1, 1],
                [0.99, 1, 1, 1],
                [1, 1, 1, 1],

                [0, 2, 3, 0],
                [0.01, 2, 3, 0.117612],
                [0.02, 2, 3, 0.230496],
                [0.03, 2, 3, 0.338724],
                [0.04, 2, 3, 0.442368],
                [0.05, 2, 3, 0.5415],
                [0.06, 2, 3, 0.636192],
                [0.07, 2, 3, 0.726516],
                [0.08, 2, 3, 0.812544],
                [0.09, 2, 3, 0.894348],
                [0.1, 2, 3, 0.972],
                [0.11, 2, 3, 1.045572],
                [0.12, 2, 3, 1.115136],
                [0.13, 2, 3, 1.180764],
                [0.14, 2, 3, 1.242528],
                [0.15, 2, 3, 1.3005],
                [0.16, 2, 3, 1.354752],
                [0.17, 2, 3, 1.405356],
                [0.18, 2, 3, 1.452384],
                [0.19, 2, 3, 1.495908],
                [0.2, 2, 3, 1.536],
                [0.21, 2, 3, 1.572732],
                [0.22, 2, 3, 1.606176],
                [0.23, 2, 3, 1.636404],
                [0.24, 2, 3, 1.663488],
                [0.25, 2, 3, 1.6875],
                [0.26, 2, 3, 1.708512],
                [0.27, 2, 3, 1.726596],
                [0.28, 2, 3, 1.741824],
                [0.29, 2, 3, 1.754268],
                [0.3, 2, 3, 1.764],
                [0.31, 2, 3, 1.771092],
                [0.32, 2, 3, 1.775616],
                [0.33, 2, 3, 1.777644],
                [0.34, 2, 3, 1.777248],
                [0.35, 2, 3, 1.7745],
                [0.36, 2, 3, 1.769472],
                [0.37, 2, 3, 1.762236],
                [0.38, 2, 3, 1.752864],
                [0.39, 2, 3, 1.741428],
                [0.4, 2, 3, 1.728],
                [0.41, 2, 3, 1.712652],
                [0.42, 2, 3, 1.695456],
                [0.43, 2, 3, 1.676484],
                [0.44, 2, 3, 1.655808],
                [0.45, 2, 3, 1.6335],
                [0.46, 2, 3, 1.609632],
                [0.47, 2, 3, 1.584276],
                [0.48, 2, 3, 1.557504],
                [0.49, 2, 3, 1.529388],
                [0.5, 2, 3, 1.5],
                [0.51, 2, 3, 1.469412],
                [0.52, 2, 3, 1.437696],
                [0.53, 2, 3, 1.404924],
                [0.54, 2, 3, 1.371168],
                [0.55, 2, 3, 1.3365],
                [0.56, 2, 3, 1.300992],
                [0.57, 2, 3, 1.264716],
                [0.58, 2, 3, 1.227744],
                [0.59, 2, 3, 1.190148],
                [0.6, 2, 3, 1.152],
                [0.61, 2, 3, 1.113372],
                [0.62, 2, 3, 1.074336],
                [0.63, 2, 3, 1.034964],
                [0.64, 2, 3, 0.995328],
                [0.65, 2, 3, 0.9555],
                [0.66, 2, 3, 0.915552],
                [0.67, 2, 3, 0.875556],
                [0.68, 2, 3, 0.835584],
                [0.69, 2, 3, 0.795708],
                [0.7, 2, 3, 0.756],
                [0.71, 2, 3, 0.716532],
                [0.72, 2, 3, 0.677376],
                [0.73, 2, 3, 0.638604],
                [0.74, 2, 3, 0.600288],
                [0.75, 2, 3, 0.5625],
                [0.76, 2, 3, 0.525312],
                [0.77, 2, 3, 0.488796],
                [0.78, 2, 3, 0.453024],
                [0.79, 2, 3, 0.418068],
                [0.8, 2, 3, 0.384],
                [0.81, 2, 3, 0.350892],
                [0.82, 2, 3, 0.318816],
                [0.83, 2, 3, 0.287844],
                [0.84, 2, 3, 0.258048],
                [0.85, 2, 3, 0.2295],
                [0.86, 2, 3, 0.202272],
                [0.87, 2, 3, 0.176436],
                [0.88, 2, 3, 0.152064],
                [0.89, 2, 3, 0.129228],
                [0.9, 2, 3, 0.108],
                [0.91, 2, 3, 0.088452],
                [0.92, 2, 3, 0.070656],
                [0.93, 2, 3, 0.054684],
                [0.94, 2, 3, 0.040608],
                [0.95, 2, 3, 0.0285],
                [0.96, 2, 3, 0.018432],
                [0.97, 2, 3, 0.010476],
                [0.98, 2, 3, 0.004704],
                [0.99, 2, 3, 0.001188],
                [1, 2, 3, 0],

                [0, 5.3, 4.1, 0],
                [0.01, 5.3, 4.1, 8.992682837E-7],
                [0.02, 5.3, 4.1, 1.716524432E-5],
                [0.03, 5.3, 4.1, 9.506790967E-5],
                [0.04, 5.3, 4.1, 3.17189614E-4],
                [0.05, 5.3, 4.1, 8.01556921E-4],
                [0.06, 5.3, 4.1, 0.0016988964],
                [0.07, 5.3, 4.1, 0.003188885207],
                [0.08, 5.3, 4.1, 0.005475822755],
                [0.09, 5.3, 4.1, 0.008783978823],
                [0.1, 5.3, 4.1, 0.01335278796],
                [0.11, 5.3, 4.1, 0.01943201066],
                [0.12, 5.3, 4.1, 0.02727695046],
                [0.13, 5.3, 4.1, 0.03714379479],
                [0.14, 5.3, 4.1, 0.04928513217],
                [0.15, 5.3, 4.1, 0.06394568691],
                [0.16, 5.3, 4.1, 0.08135830378],
                [0.17, 5.3, 4.1, 0.1017402081],
                [0.18, 5.3, 4.1, 0.125289561],
                [0.19, 5.3, 4.1, 0.1521823254],
                [0.2, 5.3, 4.1, 0.182569453],
                [0.21, 5.3, 4.1, 0.2165744019],
                [0.22, 5.3, 4.1, 0.254290988],
                [0.23, 5.3, 4.1, 0.2957815744],
                [0.24, 5.3, 4.1, 0.3410755976],
                [0.25, 5.3, 4.1, 0.3901684309],
                [0.26, 5.3, 4.1, 0.4430205794],
                [0.27, 5.3, 4.1, 0.4995572033],
                [0.28, 5.3, 4.1, 0.5596679626],
                [0.29, 5.3, 4.1, 0.6232071758],
                [0.3, 5.3, 4.1, 0.6899942834],
                [0.31, 5.3, 4.1, 0.7598146065],
                [0.32, 5.3, 4.1, 0.8324203897],
                [0.33, 5.3, 4.1, 0.9075321165],
                [0.34, 5.3, 4.1, 0.9848400846],
                [0.35, 5.3, 4.1, 1.064006227],
                [0.36, 5.3, 4.1, 1.144666166],
                [0.37, 5.3, 4.1, 1.226431482],
                [0.38, 5.3, 4.1, 1.30889219],
                [0.39, 5.3, 4.1, 1.391619392],
                [0.4, 5.3, 4.1, 1.474168111],
                [0.41, 5.3, 4.1, 1.55608026],
                [0.42, 5.3, 4.1, 1.636887763],
                [0.43, 5.3, 4.1, 1.716115781],
                [0.44, 5.3, 4.1, 1.793286033],
                [0.45, 5.3, 4.1, 1.867920206],
                [0.46, 5.3, 4.1, 1.939543413],
                [0.47, 5.3, 4.1, 2.007687699],
                [0.48, 5.3, 4.1, 2.071895558],
                [0.49, 5.3, 4.1, 2.131723453],
                [0.5, 5.3, 4.1, 2.186745318],
                [0.51, 5.3, 4.1, 2.23655601],
                [0.52, 5.3, 4.1, 2.2807747],
                [0.53, 5.3, 4.1, 2.319048184],
                [0.54, 5.3, 4.1, 2.351054078],
                [0.55, 5.3, 4.1, 2.376503897],
                [0.56, 5.3, 4.1, 2.395145972],
                [0.57, 5.3, 4.1, 2.406768202],
                [0.58, 5.3, 4.1, 2.411200616],
                [0.59, 5.3, 4.1, 2.408317709],
                [0.6, 5.3, 4.1, 2.398040553],
                [0.61, 5.3, 4.1, 2.380338635],
                [0.62, 5.3, 4.1, 2.355231427],
                [0.63, 5.3, 4.1, 2.322789641],
                [0.64, 5.3, 4.1, 2.283136168],
                [0.65, 5.3, 4.1, 2.236446659],
                [0.66, 5.3, 4.1, 2.182949752],
                [0.67, 5.3, 4.1, 2.122926892],
                [0.68, 5.3, 4.1, 2.056711757],
                [0.69, 5.3, 4.1, 1.984689236],
                [0.7, 5.3, 4.1, 1.907293967],
                [0.71, 5.3, 4.1, 1.825008394],
                [0.72, 5.3, 4.1, 1.73836034],
                [0.73, 5.3, 4.1, 1.647920061],
                [0.74, 5.3, 4.1, 1.554296779],
                [0.75, 5.3, 4.1, 1.458134658],
                [0.76, 5.3, 4.1, 1.360108233],
                [0.77, 5.3, 4.1, 1.260917242],
                [0.78, 5.3, 4.1, 1.16128088],
                [0.79, 5.3, 4.1, 1.061931442],
                [0.8, 5.3, 4.1, 0.96360735],
                [0.81, 5.3, 4.1, 0.8670455576],
                [0.82, 5.3, 4.1, 0.7729733206],
                [0.83, 5.3, 4.1, 0.6820993361],
                [0.84, 5.3, 4.1, 0.5951042469],
                [0.85, 5.3, 4.1, 0.5126305178],
                [0.86, 5.3, 4.1, 0.4352716926],
                [0.87, 5.3, 4.1, 0.3635610522],
                [0.88, 5.3, 4.1, 0.2979596986],
                [0.89, 5.3, 4.1, 0.2388441045],
                [0.9, 5.3, 4.1, 0.1864931841],
                [0.91, 5.3, 4.1, 0.1410749612],
                [0.92, 5.3, 4.1, 0.1026329449],
                [0.93, 5.3, 4.1, 0.07107236645],
                [0.94, 5.3, 4.1, 0.04614650559],
                [0.95, 5.3, 4.1, 0.0274434489],
                [0.96, 5.3, 4.1, 0.01437382816],
                [0.97, 5.3, 4.1, 0.006160479551],
                [0.98, 5.3, 4.1, 0.001831830498],
                [0.99, 5.3, 4.1, 2.231780662E-4],
                [1, 5.3, 4.1, 0],

                [0, 3, 2, 0],
                [0.01, 3, 2, 0.001188],
                [0.15, 3, 2, 0.2295],
                [0.81, 3, 2, 1.495908],
                [0.99, 3, 2, 0.117612],
                [1, 3, 2, 0],

                [0, 10, 50, 0],
                [0.01, 10, 50, 3.8395492E-7],
                [0.15, 10, 50, 8.404355],
                [0.81, 10, 50, 3.3949479E-26],
                [0.99, 10, 50, 5.739479E-87],
                [1, 10, 50, 0],
            ];
        }

        /**
         * @return array [α, β]
         */
        public static function dataProviderForPdfAlphaBetaOutOfBoundsException(
        ): array
        {
            return [
                [1, -3],
                [1, -2],
                [1, -1],
                [1, 0],
                [-3, 1],
                [-2, 1],
                [-1, 1],
                [0, 1],
            ];
        }

        public static function dataProviderForPdfSupportOutOfBoundsException(
        ): array
        {
            return [
                [-3],
                [-2],
                [-1],
                [-0.01],
                [1.01],
                [2],
                [3],
            ];
        }

        /**
         * @return array [x, α, β, cdf]
         * Generated with http://keisan.casio.com/exec/system/1180573226
         */
        public static function dataProviderForCdf(): array
        {
            return [
                [0, 1, 1, 0],
                [0.01, 1, 1, 0.01],
                [0.02, 1, 1, 0.02],
                [0.03, 1, 1, 0.03],
                [0.04, 1, 1, 0.04],
                [0.05, 1, 1, 0.05],
                [0.06, 1, 1, 0.06],
                [0.07, 1, 1, 0.07],
                [0.08, 1, 1, 0.08],
                [0.09, 1, 1, 0.09],
                [0.1, 1, 1, 0.1],
                [0.11, 1, 1, 0.11],
                [0.12, 1, 1, 0.12],
                [0.13, 1, 1, 0.13],
                [0.14, 1, 1, 0.14],
                [0.15, 1, 1, 0.15],
                [0.16, 1, 1, 0.16],
                [0.17, 1, 1, 0.17],
                [0.18, 1, 1, 0.18],
                [0.19, 1, 1, 0.19],
                [0.2, 1, 1, 0.2],
                [0.21, 1, 1, 0.21],
                [0.22, 1, 1, 0.22],
                [0.23, 1, 1, 0.23],
                [0.24, 1, 1, 0.24],
                [0.25, 1, 1, 0.25],
                [0.26, 1, 1, 0.26],
                [0.27, 1, 1, 0.27],
                [0.28, 1, 1, 0.28],
                [0.29, 1, 1, 0.29],
                [0.3, 1, 1, 0.3],
                [0.31, 1, 1, 0.31],
                [0.32, 1, 1, 0.32],
                [0.33, 1, 1, 0.33],
                [0.34, 1, 1, 0.34],
                [0.35, 1, 1, 0.35],
                [0.36, 1, 1, 0.36],
                [0.37, 1, 1, 0.37],
                [0.38, 1, 1, 0.38],
                [0.39, 1, 1, 0.39],
                [0.4, 1, 1, 0.4],
                [0.41, 1, 1, 0.41],
                [0.42, 1, 1, 0.42],
                [0.43, 1, 1, 0.43],
                [0.44, 1, 1, 0.44],
                [0.45, 1, 1, 0.45],
                [0.46, 1, 1, 0.46],
                [0.47, 1, 1, 0.47],
                [0.48, 1, 1, 0.48],
                [0.49, 1, 1, 0.49],
                [0.5, 1, 1, 0.5],
                [0.51, 1, 1, 0.51],
                [0.52, 1, 1, 0.52],
                [0.53, 1, 1, 0.53],
                [0.54, 1, 1, 0.54],
                [0.55, 1, 1, 0.55],
                [0.56, 1, 1, 0.56],
                [0.57, 1, 1, 0.57],
                [0.58, 1, 1, 0.58],
                [0.59, 1, 1, 0.59],
                [0.6, 1, 1, 0.6],
                [0.61, 1, 1, 0.61],
                [0.62, 1, 1, 0.62],
                [0.63, 1, 1, 0.63],
                [0.64, 1, 1, 0.64],
                [0.65, 1, 1, 0.65],
                [0.66, 1, 1, 0.66],
                [0.67, 1, 1, 0.67],
                [0.68, 1, 1, 0.68],
                [0.69, 1, 1, 0.69],
                [0.7, 1, 1, 0.7],
                [0.71, 1, 1, 0.71],
                [0.72, 1, 1, 0.72],
                [0.73, 1, 1, 0.73],
                [0.74, 1, 1, 0.74],
                [0.75, 1, 1, 0.75],
                [0.76, 1, 1, 0.76],
                [0.77, 1, 1, 0.77],
                [0.78, 1, 1, 0.78],
                [0.79, 1, 1, 0.79],
                [0.8, 1, 1, 0.8],
                [0.81, 1, 1, 0.81],
                [0.82, 1, 1, 0.82],
                [0.83, 1, 1, 0.83],
                [0.84, 1, 1, 0.84],
                [0.85, 1, 1, 0.85],
                [0.86, 1, 1, 0.86],
                [0.87, 1, 1, 0.87],
                [0.88, 1, 1, 0.88],
                [0.89, 1, 1, 0.89],
                [0.9, 1, 1, 0.9],
                [0.91, 1, 1, 0.91],
                [0.92, 1, 1, 0.92],
                [0.93, 1, 1, 0.93],
                [0.94, 1, 1, 0.94],
                [0.95, 1, 1, 0.95],
                [0.96, 1, 1, 0.96],
                [0.97, 1, 1, 0.97],
                [0.98, 1, 1, 0.98],
                [0.99, 1, 1, 0.99],
                [1, 1, 1, 1],

                [0, 2, 3, 0],
                [0.01, 2, 3, 5.9203E-4],
                [0.02, 2, 3, 0.00233648],
                [0.03, 2, 3, 0.00518643],
                [0.04, 2, 3, 0.00909568],
                [0.05, 2, 3, 0.01401875],
                [0.06, 2, 3, 0.01991088],
                [0.07, 2, 3, 0.02672803],
                [0.08, 2, 3, 0.03442688],
                [0.09, 2, 3, 0.04296483],
                [0.1, 2, 3, 0.0523],
                [0.11, 2, 3, 0.06239123],
                [0.12, 2, 3, 0.07319808],
                [0.13, 2, 3, 0.08468083],
                [0.14, 2, 3, 0.09680048],
                [0.15, 2, 3, 0.10951875],
                [0.16, 2, 3, 0.12279808],
                [0.17, 2, 3, 0.13660163],
                [0.18, 2, 3, 0.15089328],
                [0.19, 2, 3, 0.16563763],
                [0.2, 2, 3, 0.1808],
                [0.21, 2, 3, 0.19634643],
                [0.22, 2, 3, 0.21224368],
                [0.23, 2, 3, 0.22845923],
                [0.24, 2, 3, 0.24496128],
                [0.25, 2, 3, 0.26171875],
                [0.26, 2, 3, 0.27870128],
                [0.27, 2, 3, 0.29587923],
                [0.28, 2, 3, 0.31322368],
                [0.29, 2, 3, 0.33070643],
                [0.3, 2, 3, 0.3483],
                [0.31, 2, 3, 0.36597763],
                [0.32, 2, 3, 0.38371328],
                [0.33, 2, 3, 0.40148163],
                [0.34, 2, 3, 0.41925808],
                [0.35, 2, 3, 0.43701875],
                [0.36, 2, 3, 0.45474048],
                [0.37, 2, 3, 0.47240083],
                [0.38, 2, 3, 0.48997808],
                [0.39, 2, 3, 0.50745123],
                [0.4, 2, 3, 0.5248],
                [0.41, 2, 3, 0.54200483],
                [0.42, 2, 3, 0.55904688],
                [0.43, 2, 3, 0.57590803],
                [0.44, 2, 3, 0.59257088],
                [0.45, 2, 3, 0.60901875],
                [0.46, 2, 3, 0.62523568],
                [0.47, 2, 3, 0.64120643],
                [0.48, 2, 3, 0.65691648],
                [0.49, 2, 3, 0.67235203],
                [0.5, 2, 3, 0.6875],
                [0.51, 2, 3, 0.70234803],
                [0.52, 2, 3, 0.71688448],
                [0.53, 2, 3, 0.73109843],
                [0.54, 2, 3, 0.74497968],
                [0.55, 2, 3, 0.75851875],
                [0.56, 2, 3, 0.77170688],
                [0.57, 2, 3, 0.78453603],
                [0.58, 2, 3, 0.79699888],
                [0.59, 2, 3, 0.80908883],
                [0.6, 2, 3, 0.8208],
                [0.61, 2, 3, 0.83212723],
                [0.62, 2, 3, 0.84306608],
                [0.63, 2, 3, 0.85361283],
                [0.64, 2, 3, 0.86376448],
                [0.65, 2, 3, 0.87351875],
                [0.66, 2, 3, 0.88287408],
                [0.67, 2, 3, 0.89182963],
                [0.68, 2, 3, 0.90038528],
                [0.69, 2, 3, 0.90854163],
                [0.7, 2, 3, 0.9163],
                [0.71, 2, 3, 0.92366243],
                [0.72, 2, 3, 0.93063168],
                [0.73, 2, 3, 0.93721123],
                [0.74, 2, 3, 0.94340528],
                [0.75, 2, 3, 0.94921875],
                [0.76, 2, 3, 0.95465728],
                [0.77, 2, 3, 0.95972723],
                [0.78, 2, 3, 0.96443568],
                [0.79, 2, 3, 0.96879043],
                [0.8, 2, 3, 0.9728],
                [0.81, 2, 3, 0.97647363],
                [0.82, 2, 3, 0.97982128],
                [0.83, 2, 3, 0.98285363],
                [0.84, 2, 3, 0.98558208],
                [0.85, 2, 3, 0.98801875],
                [0.86, 2, 3, 0.99017648],
                [0.87, 2, 3, 0.99206883],
                [0.88, 2, 3, 0.99371008],
                [0.89, 2, 3, 0.99511523],
                [0.9, 2, 3, 0.9963],
                [0.91, 2, 3, 0.99728083],
                [0.92, 2, 3, 0.99807488],
                [0.93, 2, 3, 0.99870003],
                [0.94, 2, 3, 0.99917488],
                [0.95, 2, 3, 0.99951875],
                [0.96, 2, 3, 0.99975168],
                [0.97, 2, 3, 0.99989443],
                [0.98, 2, 3, 0.99996848],
                [0.99, 2, 3, 0.99999603],
                [1, 2, 3, 1],

                [0, 3, 2, 0],
                [0.01, 3, 2, 3.97E-6],
                [0.02, 3, 2, 3.152E-5],
                [0.03, 3, 2, 1.0557E-4],
                [0.04, 3, 2, 2.4832E-4],
                [0.05, 3, 2, 4.8125E-4],
                [0.06, 3, 2, 8.2512E-4],
                [0.07, 3, 2, 0.00129997],
                [0.08, 3, 2, 0.00192512],
                [0.09, 3, 2, 0.00271917],
                [0.1, 3, 2, 0.0037],
                [0.11, 3, 2, 0.00488477],
                [0.12, 3, 2, 0.00628992],
                [0.13, 3, 2, 0.00793117],
                [0.14, 3, 2, 0.00982352],
                [0.15, 3, 2, 0.01198125],
                [0.16, 3, 2, 0.01441792],
                [0.17, 3, 2, 0.01714637],
                [0.18, 3, 2, 0.02017872],
                [0.19, 3, 2, 0.02352637],
                [0.2, 3, 2, 0.0272],
                [0.21, 3, 2, 0.03120957],
                [0.22, 3, 2, 0.03556432],
                [0.23, 3, 2, 0.04027277],
                [0.24, 3, 2, 0.04534272],
                [0.25, 3, 2, 0.05078125],
                [0.26, 3, 2, 0.05659472],
                [0.27, 3, 2, 0.06278877],
                [0.28, 3, 2, 0.06936832],
                [0.29, 3, 2, 0.07633757],
                [0.3, 3, 2, 0.0837],
                [0.31, 3, 2, 0.09145837],
                [0.32, 3, 2, 0.09961472],
                [0.33, 3, 2, 0.10817037],
                [0.34, 3, 2, 0.11712592],
                [0.35, 3, 2, 0.12648125],
                [0.36, 3, 2, 0.13623552],
                [0.37, 3, 2, 0.14638717],
                [0.38, 3, 2, 0.15693392],
                [0.39, 3, 2, 0.16787277],
                [0.4, 3, 2, 0.1792],
                [0.41, 3, 2, 0.19091117],
                [0.42, 3, 2, 0.20300112],
                [0.43, 3, 2, 0.21546397],
                [0.44, 3, 2, 0.22829312],
                [0.45, 3, 2, 0.24148125],
                [0.46, 3, 2, 0.25502032],
                [0.47, 3, 2, 0.26890157],
                [0.48, 3, 2, 0.28311552],
                [0.49, 3, 2, 0.29765197],
                [0.5, 3, 2, 0.3125],
                [0.51, 3, 2, 0.32764797],
                [0.52, 3, 2, 0.34308352],
                [0.53, 3, 2, 0.35879357],
                [0.54, 3, 2, 0.37476432],
                [0.55, 3, 2, 0.39098125],
                [0.56, 3, 2, 0.40742912],
                [0.57, 3, 2, 0.42409197],
                [0.58, 3, 2, 0.44095312],
                [0.59, 3, 2, 0.45799517],
                [0.6, 3, 2, 0.4752],
                [0.61, 3, 2, 0.49254877],
                [0.62, 3, 2, 0.51002192],
                [0.63, 3, 2, 0.52759917],
                [0.64, 3, 2, 0.54525952],
                [0.65, 3, 2, 0.56298125],
                [0.66, 3, 2, 0.58074192],
                [0.67, 3, 2, 0.59851837],
                [0.68, 3, 2, 0.61628672],
                [0.69, 3, 2, 0.63402237],
                [0.7, 3, 2, 0.6517],
                [0.71, 3, 2, 0.66929357],
                [0.72, 3, 2, 0.68677632],
                [0.73, 3, 2, 0.70412077],
                [0.74, 3, 2, 0.72129872],
                [0.75, 3, 2, 0.73828125],
                [0.76, 3, 2, 0.75503872],
                [0.77, 3, 2, 0.77154077],
                [0.78, 3, 2, 0.78775632],
                [0.79, 3, 2, 0.80365357],
                [0.8, 3, 2, 0.8192],
                [0.81, 3, 2, 0.83436237],
                [0.82, 3, 2, 0.84910672],
                [0.83, 3, 2, 0.86339837],
                [0.84, 3, 2, 0.87720192],
                [0.85, 3, 2, 0.89048125],
                [0.86, 3, 2, 0.90319952],
                [0.87, 3, 2, 0.91531917],
                [0.88, 3, 2, 0.92680192],
                [0.89, 3, 2, 0.93760877],
                [0.9, 3, 2, 0.9477],
                [0.91, 3, 2, 0.95703517],
                [0.92, 3, 2, 0.96557312],
                [0.93, 3, 2, 0.97327197],
                [0.94, 3, 2, 0.98008912],
                [0.95, 3, 2, 0.98598125],
                [0.96, 3, 2, 0.99090432],
                [0.97, 3, 2, 0.99481357],
                [0.98, 3, 2, 0.99766352],
                [0.99, 3, 2, 0.99940797],
                [1, 3, 2, 1],

                [0, 10, 50, 0],
                [0.01, 10, 50, 4.019555174E-10],
                [0.02, 10, 50, 2.627230725E-7],
                [0.03, 10, 50, 9.649195527E-6],
                [0.04, 10, 50, 1.089160184E-4],
                [0.05, 10, 50, 6.436109147E-4],
                [0.06, 10, 50, 0.002524554335],
                [0.07, 10, 50, 0.007461626373],
                [0.08, 10, 50, 0.01792659751],
                [0.09, 10, 50, 0.03676911366],
                [0.1, 10, 50, 0.06658944558],
                [0.11, 10, 50, 0.109084124],
                [0.12, 10, 50, 0.1645800247],
                [0.13, 10, 50, 0.2318848964],
                [0.14, 10, 50, 0.3084655888],
                [0.15, 10, 50, 0.3908704946],
                [0.16, 10, 50, 0.4752657543],
                [0.17, 10, 50, 0.5579559892],
                [0.18, 10, 50, 0.6357944535],
                [0.19, 10, 50, 0.7064347707],
                [0.2, 10, 50, 0.7684204704],
                [0.21, 10, 50, 0.8211398301],
                [0.22, 10, 50, 0.8646892754],
                [0.23, 10, 50, 0.8996908182],
                [0.24, 10, 50, 0.9271020689],
                [0.25, 10, 50, 0.9480459701],
                [0.26, 10, 50, 0.9636753835],
                [0.27, 10, 50, 0.9750774712],
                [0.28, 10, 50, 0.9832155754],
                [0.29, 10, 50, 0.9889021129],
                [0.3, 10, 50, 0.9927943681],
                [0.31, 10, 50, 0.9954052423],
                [0.32, 10, 50, 0.9971222339],
                [0.33, 10, 50, 0.9982295758],
                [0.34, 10, 50, 0.9989301123],
                [0.35, 10, 50, 0.9993649151],
                [0.36, 10, 50, 0.9996297151],
                [0.37, 10, 50, 0.9997879625],
                [0.38, 10, 50, 0.9998807638],
                [0.39, 10, 50, 0.9999341655],
                [0.4, 10, 50, 0.9999643168],
                [0.41, 10, 50, 0.9999810182],
                [0.42, 10, 50, 0.9999900926],
                [0.43, 10, 50, 0.9999949278],
                [0.44, 10, 50, 0.9999974537],
                [0.45, 10, 50, 0.9999987471],
                [0.46, 10, 50, 0.999999396],
                [0.47, 10, 50, 0.9999997149],
                [0.48, 10, 50, 0.9999998682],
                [0.49, 10, 50, 0.9999999404],
                [0.5, 10, 50, 0.9999999737],
                [0.51, 10, 50, 0.9999999886],
                [0.52, 10, 50, 0.9999999952],
                [0.53, 10, 50, 0.999999998],
                [0.54, 10, 50, 0.9999999992],
                [0.55, 10, 50, 0.9999999997],
                [0.56, 10, 50, 0.9999999999],
                [0.57, 10, 50, 1],
                [0.58, 10, 50, 1],
                [0.59, 10, 50, 1],
                [0.6, 10, 50, 1],
                [0.61, 10, 50, 1],
                [0.62, 10, 50, 1],
                [0.63, 10, 50, 1],
                [0.64, 10, 50, 1],
                [0.65, 10, 50, 1],
                [0.66, 10, 50, 1],
                [0.67, 10, 50, 1],
                [0.68, 10, 50, 1],
                [0.69, 10, 50, 1],
                [0.7, 10, 50, 1],
                [0.71, 10, 50, 1],
                [0.72, 10, 50, 1],
                [0.73, 10, 50, 1],
                [0.74, 10, 50, 1],
                [0.75, 10, 50, 1],
                [0.76, 10, 50, 1],
                [0.77, 10, 50, 1],
                [0.78, 10, 50, 1],
                [0.79, 10, 50, 1],
                [0.8, 10, 50, 1],
                [0.81, 10, 50, 1],
                [0.82, 10, 50, 1],
                [0.83, 10, 50, 1],
                [0.84, 10, 50, 1],
                [0.85, 10, 50, 1],
                [0.86, 10, 50, 1],
                [0.87, 10, 50, 1],
                [0.88, 10, 50, 1],
                [0.89, 10, 50, 1],
                [0.9, 10, 50, 1],
                [0.91, 10, 50, 1],
                [0.92, 10, 50, 1],
                [0.93, 10, 50, 1],
                [0.94, 10, 50, 1],
                [0.95, 10, 50, 1],
                [0.96, 10, 50, 1],
                [0.97, 10, 50, 1],
                [0.98, 10, 50, 1],
                [0.99, 10, 50, 1],
                [1, 10, 50, 1],
            ];
        }

        /**
         * @return array [α, β, μ]
         */
        public static function dataProviderForMean(): array
        {
            return [
                [1, 1, 0.5],
                [1, 2, 0.33333333],
                [2, 1, 0.66666666],
            ];
        }

        /**
         * Data generated with calculator: https://captaincalculator.com/math/statistics/beta-distribution-calculator/
         *
         * @return array [α, β, μ]
         */
        public static function dataProviderForMedian(): array
        {
            return [
                // α == β
                [1, 1, 0.5],
                [2, 2, 0.5],
                [3, 3, 0.5],

                // α == 1, β > 0
                [1, 0.1, 0.99902344],
                [1, 0.5, 0.75],
                [1, 2, 0.29289322],
                [1, 3, 0.20629947],
                [1, 4, 0.15910358],
                [1, 5, 0.12944944],

                // β == 1, α > 0
                [0.1, 1, 0.00097656],
                [0.5, 1, 0.25],
                [2, 1, 0.70710678],
                [3, 1, 0.79370053],
                [4, 1, 0.84089642],
                [5, 1, 0.87055056],

                // α == 3, β == 2
                [3, 2, 0.61427243],

                // α == 2, β == 3
                [2, 3, 0.38572757],
            ];
        }

        /**
         * Data generated with calculator: https://captaincalculator.com/math/statistics/beta-distribution-calculator/
         *
         * @return array [α, β, μ]
         */
        public static function dataProviderForMedianApproximation(): array
        {
            return [
                // α ≥ 2 and β ≥ 2 the error it is less than 1%
                [2, 4, 0.31381017, 0.01],
                [4, 2, 0.68618983, 0.01],
                [4, 5, 0.4401552, 0.01],
                [7, 4, 0.64490003, 0.01],

                // α, β ≥ 1 the error is less than 4%
                [1.8, 1.1, 0.6513904, 0.04],
                [1.4, 1.3, 0.52366548, 0.04],
            ];
        }

        /**
         * Data generated with calculator: https://captaincalculator.com/math/statistics/beta-distribution-calculator/
         *
         * @return array [α, β, μ]
         */
        public static function dataProviderForMode(): array
        {
            return [
                [1, 2, 0],
                [1, 3, 0],
                [2, 1, 1],
                [3, 1, 1],
                [2, 2, 0.5],
                [4, 5, 0.42857143],
                [7, 4, 0.66666667],
            ];
        }

        /**
         * Data generated with calculator: https://captaincalculator.com/math/statistics/beta-distribution-calculator/
         *
         * @return array [α, β, var]
         */
        public static function dataProviderForVariance(): array
        {
            return [
                [1, 2, 0.05555556],
                [1, 3, 0.0375],
                [2, 1, 0.05555556],
                [3, 1, 0.0375],
                [2, 2, 0.05],
                [4, 5, 0.02469136],
                [7, 4, 0.01928375],
            ];
        }

        /**
         * @return array [α, β, x, inverse]
         * Generated with R (stats) qbeta(x, α, β)
         */
        public static function dataProviderForInverse(): array
        {
            return [
                [1, 1, 0, 0],
                [1, 1, 0.01, 0.01],
                [1, 1, 0.1, 0.1],
                [1, 1, 0.2, 0.2],
                [1, 1, 0.3, 0.3],
                [1, 1, 0.4, 0.4],
                [1, 1, 0.5, 0.5],
                [1, 1, 0.6, 0.6],
                [1, 1, 0.7, 0.7],
                [1, 1, 0.8, 0.8],
                [1, 1, 0.9, 0.9],
                [1, 1, 0.99, 0.99],
                [1, 1, 1, 1],

                [2, 1, 0, 0],
                [2, 1, 0.01, 0.1],
                [2, 1, 0.1, 0.3162278],
                [2, 1, 0.2, 0.4472136],
                [2, 1, 0.3, 0.5477226],
                [2, 1, 0.4, 0.6324555],
                [2, 1, 0.5, 0.7071068],
                [2, 1, 0.6, 0.7745967],
                [2, 1, 0.7, 0.83666],
                [2, 1, 0.8, 0.8944272],
                [2, 1, 0.9, 0.9486833],
                [2, 1, 0.99, 0.9949874],
                [2, 1, 1, 1],

                [1, 2, 0, 0],
                [1, 2, 0.01, 0.005012563],
                [1, 2, 0.1, 0.0513167],
                [1, 2, 0.2, 0.1055728],
                [1, 2, 0.3, 0.16334],
                [1, 2, 0.4, 0.2254033],
                [1, 2, 0.5, 0.2928932],
                [1, 2, 0.6, 0.3675445],
                [1, 2, 0.7, 0.4522774],
                [1, 2, 0.8, 0.5527864],
                [1, 2, 0.9, 0.6837722],
                [1, 2, 0.99, 0.9],
                [1, 2, 1, 1],

                [2, 3, 0, 0],
                [2, 3, 0.01, 0.04199864],
                [2, 3, 0.1, 0.1425593],
                [2, 3, 0.2, 0.2123171],
                [2, 3, 0.3, 0.2723839],
                [2, 3, 0.4, 0.3291665],
                [2, 3, 0.5, 0.3857276],
                [2, 3, 0.6, 0.4445],
                [2, 3, 0.7, 0.5084048],
                [2, 3, 0.8, 0.5824536],
                [2, 3, 0.9, 0.6795394],
                [2, 3, 0.99, 0.8591325],
                [2, 3, 1, 1],

                [4, 5, 0.2, 0.3032258],
                [10, 5, 0.01, 0.3725653],
                [10, 5, 0.5, 0.6742488],
                [10, 5, 0.99, 0.8980714],
            ];
        }

        /**
         * @test         pdf
         * @dataProvider dataProviderForPdf
         *
         * @param float $x
         * @param float $α
         * @param float $β
         * @param float $expected_pdf
         */
        public function testPdf(
            float $x,
            float $α,
            float $β,
            float $expected_pdf
        ) {
            // Given
            $beta = new Beta($α, $β);

            // When
            $pdf = $beta->pdf($x);

            // Then
            $this->assertEqualsWithDelta($expected_pdf, $pdf, 0.0000001);
        }

        /**
         * @test         Constructor throws an Exception\OutOfBoundsException if alpha or beta is less than or equal to zero
         * @dataProvider dataProviderForPdfAlphaBetaOutOfBoundsException
         *
         * @param float $α
         * @param float $β
         */
        public function testConstructorExceptionAlphaBetaLessThanEqualZero(
            float $α,
            float $β
        ) {
            // Then
            $this->expectException(Exception\OutOfBoundsException::class);

            // When
            new Beta($α, $β);
        }

        /**
         * @test         pdf throws an Exception\OutOfBoundsException if the support x is less than 0 or greater than 1
         * @dataProvider dataProviderForPdfSupportOutOfBoundsException
         *
         * @param float $x
         */
        public function testPdfExceptionXOutOfBounds(float $x)
        {
            // Given
            [$α, $β] = [1, 1];
            $beta = new Beta($α, $β);

            // Then
            $this->expectException(Exception\OutOfBoundsException::class);

            // When
            $beta->pdf($x);
        }

        /**
         * @test         cdf
         * @dataProvider dataProviderForCdf
         *
         * @param float $x
         * @param float $α
         * @param float $β
         * @param float $expected_cdf
         */
        public function testCdf(
            float $x,
            float $α,
            float $β,
            float $expected_cdf
        ) {
            // Given
            $beta = new Beta($α, $β);

            // When
            $cdf = $beta->cdf($x);

            // Then
            $this->assertEqualsWithDelta($expected_cdf, $cdf, 0.000001);
        }

        /**
         * @test         mean
         * @dataProvider dataProviderForMean
         *
         * @param float $α
         * @param float $β
         * @param float $μ
         */
        public function testMean(float $α, float $β, float $μ)
        {
            // Given
            $beta = new Beta($α, $β);

            // When
            $mean = $beta->mean();

            // Then
            $this->assertEqualsWithDelta($μ, $mean, 0.000001);
        }

        /**
         * @test         median
         * @dataProvider dataProviderForMedian
         *
         * @param float $α
         * @param float $β
         * @param float $expected
         */
        public function testMedian(float $α, float $β, float $expected)
        {
            // Given
            $beta = new Beta($α, $β);

            // When
            $median = $beta->median();

            // Then
            $this->assertEqualsWithDelta($expected, $median, 0.000001);
        }

        /**
         * @test         median when it is approximated
         * @dataProvider dataProviderForMedianApproximation
         *
         * @param float $α
         * @param float $β
         * @param float $expected
         * @param float $expectedError
         */
        public function testMedianApproximation(
            float $α,
            float $β,
            float $expected,
            float $expectedError
        ) {
            // Given
            $beta = new Beta($α, $β);

            // When
            $median = $beta->median();

            // Then
            $ε = abs($expected - $median);
            $η = $ε / $expected;
            $this->assertLessThan($expectedError, $η);
        }

        /**
         * @test         mode
         * @dataProvider dataProviderForMode
         *
         * @param float $α
         * @param float $β
         * @param float $expected
         */
        public function testMode(float $α, float $β, float $expected)
        {
            // Given
            $beta = new Beta($α, $β);

            // When
            $mode = $beta->mode();

            // Then
            $this->assertEqualsWithDelta($expected, $mode, 0.000001);
        }

        /**
         * @test         variance
         * @dataProvider dataProviderForVariance
         *
         * @param float $α
         * @param float $β
         * @param float $expected
         */
        public function testVariance(float $α, float $β, float $expected)
        {
            // Given
            $beta = new Beta($α, $β);

            // When
            $variance = $beta->variance();

            // Then
            $this->assertEqualsWithDelta($expected, $variance, 0.000001);
        }

        /**
         * @test         inverse
         * @dataProvider dataProviderForInverse
         *
         * @param float $α
         * @param float $β
         * @param float $x
         * @param float $expected_inverse
         *
         * @throws       \Exception
         */
        public function testInverse(
            float $α,
            float $β,
            float $x,
            float $expected_inverse
        ) {
            // Given
            $beta = new Beta($α, $β);

            // When
            $inverse = $beta->inverse($x);

            // Then
            $this->assertEqualsWithDelta($expected_inverse, $inverse,
                0.0000001);
        }

        /**
         * @test   inverse throws an exception if it fails to converge on a guess within the tolerance
         * @throws Exception\MathException
         */
        public function testInverseFailToConvergeException()
        {
            // Given
            [$α, $β, $x] = [2, 5, 0.6];
            $tolerance = 1.0e-15;
            $max_iterations = 2;
            $beta = new Beta($α, $β);

            // Then
            $this->expectException(Exception\MathException::class);

            // When
            $inverse = $beta->inverse($x, $tolerance, $max_iterations);
        }

        /**
         * @test rand
         */
        public function testRand()
        {
            foreach (range(1, 10) as $α)
            {
                {
                    foreach (range(1, 10) as $β)
                    {
                        // Given
                        $beta = new Beta($α, $β);
                        foreach (range(1, 3) as $ignored)
                        {
                            // When
                            $random = $beta->rand();

                            // Then
                            $this->assertTrue(is_numeric($random));
                        }
                    }
                }
            }
        }
    }
