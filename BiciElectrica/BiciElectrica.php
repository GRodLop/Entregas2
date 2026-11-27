<?php
/**
 * Fichero: BiciElectrica.php
 * Implementa la clase para la gestión de bicicletas eléctricas.
 */
class BiciElectrica {

    // Atributos privados
    private int $id;        
    private int $coordx;    
    private int $coordy;    
    private int $bateria;   
    private bool $operativa; 

    public function __construct($id, $coordx, $coordy, $bateria, $operativa) {
        $this->id = (int)$id;
        $this->coordx = (int)$coordx;
        $this->coordy = (int)$coordy;
        $this->bateria = (int)$bateria;
        $this->operativa = (bool)$operativa;
    }

    // Getter y setter 
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    // Devuelve el id de la bicicleta y el estado de la batería
    public function __toString() {
        return "Identificador: $this->id Bateria $this->bateria %";
    }

    
    public function distancia($x, $y) {
        $dx = $x - $this->coordx;
        $dy = $y - $this->coordy;
        return sqrt($dx * $dx + $dy * $dy);
    }
}