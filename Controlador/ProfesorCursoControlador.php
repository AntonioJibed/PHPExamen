<?php
require_once '../Modelo/ProfesorCurso.php';


class ProfesorCursoControlador {

    public static function buscarCursoPorProfesor($dni) {

        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT cu.descripcion, cu.totalpartes from curso cu, prof_curso prof where cu.id_curso=prof.id_curso and prof.dni_p = ?");
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $stmt->bind_result($resultDescripcion, $resultTotalPartes);

            $cursos = array();

            while ($stmt->fetch()) {
                $curso = array('descripcion' => $resultDescripcion, 'partes'=>$resultTotalPartes);
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
}
