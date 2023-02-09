<?php
namespace App\Services\Interface;

interface IDescuentoService {
    public static function getDescuentosRestantes();
    public static function getDescuentosRestantesIdaVuelta();
    public static function getDescuentosRestantesEdad();
    public static function getDescuentosRestantesDiasAnticipacion();
    public static function getDescuentosRestantesNormales();
    public static function getDescuentosRestantesUltimosCupones();
}

?>
