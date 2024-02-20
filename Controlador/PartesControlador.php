<?php

require_once '../Modelo/Partes.php';

class PartesControlador {

    public static function registrarParte($dni_p, $dni_a, $motivo) {
        try {
            $conex = new Conexion();
            $tiempo=time();
            $stmt = $conex->prepare("insert into partes (dni_p, dni_a, motivo, time) values (?, ?, ?, $tiempo");
            $stmt->bind_param('sss', $dni_p, $dni_a, $motivo);
            $stmt->execute();
            $stmt->close();
            $conex->close();

        } catch (Exception $ex) {
            echo $ex->getMessage();

        }
    }
    
    public static function buscarPartes($dniAlumno){
         try {
            $conex = new Conexion();
            $stmt = $conex->prepare("select * from partes where dni_a = ?");
            $stmt->bind_param("s", $dniAlumno);
            $stmt->execute();
            $stmt->bind_result($resultId, $resultDniP, $resultDniA, $resultMotivo, $resultTime);

            $partes = array();

            while ($stmt->fetch()) {
                $parte = new Partes($resultId, $resultDniP, $resultDniA, $resultMotivo, $resultTime);
                $partes[] = $parte;
            }
            $stmt->close();
            $conex->close();

            return $partes;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return null;
        }
    }
}
