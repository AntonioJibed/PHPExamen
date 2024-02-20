<?php

require_once '../Modelo/Alumnos.php';

class AlumnosControlador {

    public static function buscarporIdCurso($id) {

        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("select * from alumnos where id_curso = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $alumnos = array();
            while ($row = $result->fetch_assoc()) {
                $dni_a = $row['dni_a'];
                $nombre = $row['nombre'];
                $apellidos = $row['apellidos'];
                $direccion = $row['direccion'];
                $telf = $row['telf'];
                $id_curso = $row['id_curso'];

                $alumno = new Alumnos($dni_a, $nombre, $apellidos, $direccion, $telf, $id_curso);
                $alumnos[] = $alumno;
            }

            $stmt->close();
            $conex->close();
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return null;
        }
        return $alumnos;
    }

    public static function buscarAlumnoPorDni($dni) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * from alumnos where dni_a = ?");
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $stmt->bind_result($resultDni, $resultNombre, $resultApellidos, $resultDireccion, $resultTelf, $resultId);

            if ($stmt->fetch()) {
                $alumnoEncontrado = new Alumnos($resultDni, $resultNombre, $resultApellidos, $resultDireccion, $resultTelf, $resultId);
            }

            $stmt->close();
            $conex->close();
        } catch (Exception $ex) {
            echo $ex->getMessage();
            $alumnoEncontrado = null;
        }
        return $alumnoEncontrado;
    }
}
