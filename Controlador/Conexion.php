<?php
class Conexion extends mysqli{
    private $host="localhost";
    private $usu="dwes";
    private $pass="abc123.";
    private $data_base="partes";
    
    public function __construct() {
        parent::__construct($this->host, $this->usu, $this->pass, $this->data_base);
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name=$value;
    }
}