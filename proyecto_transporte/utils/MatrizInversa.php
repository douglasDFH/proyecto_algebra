<?php
class MatrizInversa {
    
    /**
     * Calcula el determinante de una matriz 3x3
     */
    public static function calcularDeterminante($matriz) {
        if (count($matriz) !== 3 || count($matriz[0]) !== 3) {
            throw new Exception("La matriz debe ser de 3x3 para calcular el determinante");
        }
        
        $det = 
            $matriz[0][0] * ($matriz[1][1] * $matriz[2][2] - $matriz[1][2] * $matriz[2][1]) -
            $matriz[0][1] * ($matriz[1][0] * $matriz[2][2] - $matriz[1][2] * $matriz[2][0]) +
            $matriz[0][2] * ($matriz[1][0] * $matriz[2][1] - $matriz[1][1] * $matriz[2][0]);
            
        return $det;
    }
    
    /**
     * Calcula la matriz de cofactores
     */
    public static function calcularCofactores($matriz) {
        if (count($matriz) !== 3 || count($matriz[0]) !== 3) {
            throw new Exception("La matriz debe ser de 3x3 para calcular los cofactores");
        }
        
        $cofactores = [];
        
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                // Extraemos la submatriz 2x2 eliminando la fila i y columna j
                $submatriz = [];
                for ($r = 0; $r < 3; $r++) {
                    if ($r === $i) continue;
                    $fila = [];
                    for ($c = 0; $c < 3; $c++) {
                        if ($c === $j) continue;
                        $fila[] = $matriz[$r][$c];
                    }
                    $submatriz[] = $fila;
                }
                
                // Calculamos el determinante de la submatriz 2x2
                $det_submatriz = $submatriz[0][0] * $submatriz[1][1] - $submatriz[0][1] * $submatriz[1][0];
                
                // Aplicamos el signo correspondiente
                $cofactores[$i][$j] = pow(-1, $i + $j) * $det_submatriz;
            }
        }
        
        return $cofactores;
    }
    
    /**
     * Calcula la matriz adjunta (transpuesta de la matriz de cofactores)
     */
    public static function calcularAdjunta($matriz) {
        $cofactores = self::calcularCofactores($matriz);
        $adjunta = [];
        
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $adjunta[$j][$i] = $cofactores[$i][$j];
            }
        }
        
        return $adjunta;
    }
    
    /**
     * Calcula la matriz inversa de una matriz 3x3
     */
    public static function calcularInversa($matriz) {
        $det = self::calcularDeterminante($matriz);
        
        if ($det == 0) {
            throw new Exception("La matriz no tiene inversa (determinante = 0)");
        }
        
        $adjunta = self::calcularAdjunta($matriz);
        $inversa = [];
        
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $inversa[$i][$j] = $adjunta[$i][$j] / $det;
            }
        }
        
        return $inversa;
    }
    
    /**
     * Multiplica una matriz por un vector
     */
    public static function multiplicarMatrizVector($matriz, $vector) {
        $resultado = [];
        $filas = count($matriz);
        $columnas = count($matriz[0]);
        
        if (count($vector) != $columnas) {
            throw new Exception("Dimensiones incompatibles para multiplicación matriz-vector");
        }
        
        for ($i = 0; $i < $filas; $i++) {
            $suma = 0;
            for ($j = 0; $j < $columnas; $j++) {
                $suma += $matriz[$i][$j] * $vector[$j];
            }
            $resultado[] = $suma;
        }
        
        return $resultado;
    }
    
    /**
     * Resuelve un sistema de ecuaciones lineales usando la inversa de la matriz de coeficientes
     * Ax = b, donde x = A^-1 * b
     */
    public static function resolverSistema($coeficientes, $terminos_independientes) {
        $inversa = self::calcularInversa($coeficientes);
        $solucion = self::multiplicarMatrizVector($inversa, $terminos_independientes);
        
        return $solucion;
    }
}
?>