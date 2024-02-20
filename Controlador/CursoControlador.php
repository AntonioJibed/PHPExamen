<?php

require_once '../Modelo/Curso.php';

class CursoControlador {

    public static function encontrarCursoPorIdCurso($idCurso) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * FROM curso WHERE id_curso = ?");
            $stmt->bind_param("s", $idCurso);
            $stmt->execute();
            $stmt->bind_result($resultIdCurso, $resultDescripcion, $resultTotalPartes);

            $cursos = array();

            while ($stmt->fetch()) {
                $curso = new Curso($resultIdCurso, $resultDescripcion, $resultTotalPartes);
                $cursos[] = $curso;
            }

            $stmt->close();
            $conex->close();

            return $cursos;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    public static function contarPartes($descripcion) {

        try {
            $conex = new Conexion();

            $stmt = $conex->prepare("SELECT * FROM curso WHERE descripcion = ?");
            $stmt->bind_param("s", $descripcion);
            $stmt->execute();
            $stmt->bind_result($resultId, $resultDescripcion, $resultTotalPartes);

            if ($stmt->fetch()) {
                $partes = new Curso($resultId, $resultDescripcion, $resultTotalPartes);
            } else {
                $partes = null;
            }
            $stmt->close();
            $conex->close();
        } catch (Exception $ex) {
            echo $ex->getMessage();
            $partes = null;
        }
        return $partes;
    }
}
