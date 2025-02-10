<?php

namespace dwes\app\utils;

class Utils
{
    public static function esOpcionMenuActiva($opcion): bool
    {
        $actual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return $actual === $opcion;
    }

    public static function existeOpcionMenuActivaEnArray($opciones): bool
    {
        foreach ($opciones as $opcionMenu)
            if (self::esOpcionMenuActiva($opcionMenu) === true)
                return true;
        return false;
    }

    public static function extraeElementosAleatorios($lista, $cantidad): array
    {
        if ($cantidad < 1) return [];
        else {
            shuffle($lista);
            $listaNueva = array_chunk($lista, $cantidad);
            return $listaNueva[0];
        }
    }
}
