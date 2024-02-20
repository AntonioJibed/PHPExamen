<?php

require_once '../Controlador/Conexion.php';

class Profesor {

    private $dni_p;
    private $nombre;
    private $apellidos;
    private $pass;
    private $bloqueado;
    private $hora_bloqueo;
    private $intentos;

    public function __construct($dni_p, $nombre, $apellidos, $pass, $bloqueado, $hora_bloqueo, $intentos) {
        $this->dni_p = $dni_p;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->pass = $pass;
        $this->bloqueado = $bloqueado;
        $this->hora_bloqueo = $hora_bloqueo;
        $this->intentos = $intentos;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }
}
