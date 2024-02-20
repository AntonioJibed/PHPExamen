<?php

require_once '../Controlador/Conexion.php';

class ProfesorCurso {

    private $dni_p;
    private $id_curso;

    public function __construct($dni_p, $id_curso) {
        $this->dni_p = $dni_p;
        $this->id_curso = $id_curso;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }
}
