<?php
require_once '../Controlador/Conexion.php';

class Curso {

    private $id_curso;
    private $descripcion;
    private $totalPartes;

    public function __construct($id_curso, $descripcion, $totalPartes) {
        $this->id_curso = $id_curso;
        $this->descripcion = $descripcion;
        $this->totalPartes = $totalPartes;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }
}
