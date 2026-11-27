<?php

/**
 *  FUNCIONES AUXILIARES
 */
function procesarApuesta(int $valorapuesta, int &$saldodisponible, string $apuesta): string {
    $numero = rand(1, 100);
    $resultado = ($numero % 2 == 0) ? "PAR" : "IMPAR";

    if ($resultado == $apuesta) {
        $saldodisponible += $valorapuesta;
        $msgresultado = "Ha salido el $numero ($resultado). ¡HA GANADO $valorapuesta Euros!";
    } else {
        $saldodisponible -= $valorapuesta;
        $msgresultado = "Ha salido el $numero ($resultado). Ha perdido $valorapuesta Euros.";
    }
    return $msgresultado;
}

session_start();

$msg = "";

// 1. ENTRADA AL CASINO ------------------------------------------
if (!isset($_SESSION['disponible'])) {

    if (isset($_POST['cantidadini']) && $_POST['cantidadini'] > 0) {
        $_SESSION['disponible'] = (int) $_POST['cantidadini'];
    } else {
        $visitas = isset($_COOKIE['visitas']) ? $_COOKIE['visitas'] + 1 : 1;
        setcookie('visitas', $visitas, time() + 30 * 24 * 60 * 60);

        require_once "form_bienvenida.php";
        exit();
    }
}

// 2. SI REALIZA UNA APUESTA -------------------------------------
if (isset($_POST['apostar'])) {
    $cantidad = (int) $_POST['cantidad'];

    if ($cantidad <= 0 || $cantidad > $_SESSION['disponible']) {
        $msg = "No puede hacer la apuesta de $cantidad Euros";
    } else {
        $msg = procesarApuesta($cantidad, $_SESSION['disponible'], $_POST['apuesta']);
    }
}

$disponible = $_SESSION['disponible'];

// 3. SI ABANDONA O YA NO LE QUEDA DINERO ------------------------
if (isset($_POST['dejar']) || $disponible <= 0) {
    session_destroy();
    require_once "despedida.php";
    exit();
}

// 4. SI PUEDE SEGUIR APOSTANDO ----------------------------------
require_once "form_apuesta.php";