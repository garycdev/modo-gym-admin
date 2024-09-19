<?php

if (!function_exists('segundosTiempo')) {
    function segundosTiempo($tiempo)
    {
        $mins = 0;
        $segs = 0;
        while ($tiempo > 0) {
            if ($tiempo > 60) {
                $mins++;
                $tiempo -= 60;
            } else {
                $segs += $tiempo;
                $tiempo = 0;
            }
        }

        if ($mins > 0) {
            return $mins . ' min y ' . $segs . 'seg';
        } else {
            return $segs . ' seg';
        }
    }
}

if (!function_exists('dias')) {
    function dias($dia)
    {
        $dias = [
            '1' => 'Lunes',
            '2' => 'Martes',
            '3' => 'Miércoles',
            '4' => 'Jueves',
            '5' => 'Viernes',
            '6' => 'Sabado',
            '7' => 'Domingo',
        ];

        return $dias[$dia];
    }
}
