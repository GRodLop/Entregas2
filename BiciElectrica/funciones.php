<?php
require_once("BiciElectrica.php");

function cargarbicis(): array
{
    $fich = @fopen("Bicis.csv", "r");
    if ($fich == false) {
        die("Error al abrir el fichero");
    }
    $tabla = [];

    while ($valor = fgetcsv($fich)) {
        list($id, $cx, $cy, $bat, $op) = $valor;
        $bici = new BiciElectrica($id, $cx, $cy, $bat, $op);
        $tabla[] = $bici;
    }
    fclose($fich);

    return $tabla;
}

function mostrartablabicis($tabla): string
{
    $cadena = "<table><tr><th>Id</th><th>Coord X</th><th>Cood Y</th><th>Bateria</th></tr>";

    foreach ($tabla as $bici) {
        if ($bici->operativa) {
            $cadena .= "<tr>";
            $cadena .= "<td>$bici->id</td>";
            $cadena .= "<td>$bici->coordx</td>";
            $cadena .= "<td>$bici->coordy</td>";
            $cadena .= "<td>$bici->bateria %</td>";
            $cadena .= "</tr>";
        }
    }

    $cadena .= "</table>";

    return $cadena;
}


function bicimascercana($x, $y, $tabla)
{
    $bicicerca = null;
    $mindist = null;

    foreach ($tabla as $bici) {
        if ($bici->operativa) {
            $d = $bici->distancia($x, $y);
            if ($mindist === null || $d < $mindist) {
                $mindist = $d;
                $bicicerca = $bici;
            }
        }
    }

    return $bicicerca;
}