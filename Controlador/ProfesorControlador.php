<?php

require_once '../Modelo/Profesor.php';

class ProfesorControlador {

    const FALLO_USUARIO = 1;
    const FALLO_CONTRASENA = 2;
    const USUARIO_BLOQUEADO = 3;

    public static function comprobarProfesor($dni, $clave) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("select * from profesores where dni_p = ?");
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $stmt->bind_result($resultDni, $resultNombre, $resultApellidos, $resultPass, $resultBloqueado, $resultHoraBloqueo, $resultIntentos);

            if ($stmt->fetch()) {
                if (md5($clave) == $resultPass) {
                    $profesorCorrecto = new Profesor($resultDni, $resultNombre, $resultApellidos, $resultPass, $resultBloqueado, $resultHoraBloqueo, $resultIntentos);
                    return $profesorCorrecto;
                } else {
                    $intentosRestantes = $resultIntentos + 1;
                    if ($intentosRestantes > 3) {
                        $_SESSION['intentos'] = 0;
                        self::restarIntentos($dni);
                        self::bloquearProfesor($dni);

                        return self::USUARIO_BLOQUEADO;
                    } else {
                        $_SESSION['intentos'] = $intentosRestantes;
                        self::restarIntentos($dni);
                        $profesorCorrecto = null;
                        return self::FALLO_CONTRASENA;
                    }
                }
            } else {
                $profesorCorrecto = null;
                return self::FALLO_USUARIO;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            $profesorCorrecto = null;
        }
    }

    public static function restarIntentos($dni) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("UPDATE profesores SET intentos = intentos + 1 WHERE dni_p = ?");
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $stmt->close();
            $conex->close();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function bloquearProfesor($dni) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("UPDATE profesores SET bloqueado = 1 WHERE dni_p = ?");
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $stmt->close();
            $conex->close();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function restaurarIntentos($dni) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("update profesores set intentos = 0 where dni_p = ?");
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $stmt->close();
            $conex->close();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function desbloquearProfesor($dni) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("update profesores set bloqueado = 0 where dni_p = ?");
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $stmt->close();
            $conex->close();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
