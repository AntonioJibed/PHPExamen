<?php
require_once '../Controlador/Conexion.php';

class Alumnos {

    private $dni_a;
    private $nombre;
    private $apellidos;
    private $direccion;
    private $telf;
    private $id_curso;

    public function __construct($dni_a, $nombre, $apellidos, $direccion, $telf, $id_curso) {
        $this->dni_a = $dni_a;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->direccion = $direccion;
        $this->telf = $telf;
        $this->id_curso = $id_curso;
    }

        public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }
}
