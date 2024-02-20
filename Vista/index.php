<?php
require_once '../Controlador/ProfesorControlador.php';

session_start();
if (isset($_SESSION['datosProfesor'])) {
    header("location:partes.php");
    exit;
}
?>
<h1>LOGIN</h1>
<form action="" method="POST">
    Usuario: <input type="text" name="usuario"><br>
    Clave: <input type="text" name="clave"><br>
    <input type="submit" name="acceder" value="Acceder"><br>
</form>

<?php
if (isset($_POST['acceder'])) {
    if (empty($_POST['usuario']) && empty($_POST['clave'])) {
        $error = "Los campos no pueden estar vacios";
    } else {
        $login = ProfesorControlador::comprobarProfesor($_POST['usuario'], $_POST['clave']);
        if ($login !== null && is_object($login)) {
            $datosProfesor = array(
                'dni_p' => $login->dni_p,
                'nombre' => $login->nombre,
                'apellidos' => $login->apellidos,
                'pass' => $login->pass,
                'bloqueado' => $login->bloqueado,
                'hora_bloqueo' => $login->hora_bloqueo,
                'intentos' => $login->intentos
            );
            $_SESSION['datosProfesor'] = $datosProfesor;

            if ($_SESSION['datosProfesor']['bloqueado'] == 0) {
                $resetear = ProfesorControlador::restaurarIntentos($_POST['usuario']);
                header("location:partes.php");
                exit;
            } else {
                session_unset();
                session_destroy();
                $error = "Profesor bloqueado";
            }
        } else {
            if ($login === ProfesorControlador::FALLO_USUARIO) {
                $error = "DNI Incorrecto";
            } elseif ($login === ProfesorControlador::FALLO_CONTRASENA) {
                $error = "Contraseña incorrecta. Tiens un total de 3 intentos; Intentos utilizados: " . $_SESSION['intentos'];
            } elseif ($login === ProfesorControlador::USUARIO_BLOQUEADO) {
                $error = "Usuario bloqueado";
            }
        }
    }
}
if (isset($error)) {
    echo $error;
}