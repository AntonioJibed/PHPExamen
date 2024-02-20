<?php
require_once '../Controlador/ProfesorControlador.php';
require_once '../Controlador/ProfesorCursoControlador.php';
require_once '../Controlador/CursoControlador.php';
require_once '../Controlador/AlumnosControlador.php';
require_once '../Controlador/PartesControlador.php';

session_start();

if (isset($_GET['cerrar_sesion'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

if (isset($_GET['volver_menu'])) {
    header("location:partes.php");
    exit;
}
$alumno = AlumnosControlador::buscarAlumnoPorDni($_SESSION['dni']);
if ($alumno !== null) {
    $datosAlumno = array(
        'dni_a' => $alumno->dni_a,
        'nombre' => $alumno->nombre,
        'apellidos' => $alumno->apellidos,
        'direccion' => $alumno->direccion,
        'telf' => $alumno->telf,
        'id_curso' => $alumno->id_curso
    );
    $_SESSION['datosAlumno'] = $datosAlumno;
}
?>


<a href="partes.php?cerrar_sesion=true">Cerrar Sesión</a><br>
<a href="partes.php?volver_menu=true">Volver al menu</a><br>
Profesor: <?php echo $_SESSION['datosProfesor']['nombre'] . " " . $_SESSION['datosProfesor']['apellidos'] ?><br>
PARTE DE INDIDENCIAS;<br>
DON/DOÑA <?php echo $_SESSION['datosProfesor']['nombre'] . " " . $_SESSION['datosProfesor']['apellidos'] ?> como
profesor de este centro, comunico que el alumno/a <?php echo $_SESSION['datosAlumno']['nombre'] . " " . $_SESSION['datosAlumno']['apellidos'] ?> del grupo <?php echo $_SESSION['descrip'] ?> ha cometido la siguiente falta:<br>
<form action="" method="POST">
    <textarea name="parte2"></textarea><br>
    <input type="submit" name="grabar" value="Grabar Parte">
</form>
<?php
if (isset($_POST['grabar'])) {
    $registrarParte = PartesControlador::registrarParte($_SESSION['datosProfesor']['dni_p'], $_SESSION['datosAlumno']['dni_a'], $_POST['parte2']);
    $_SESSION['parteingresado'] = "El profesor " . $_SESSION['datosProfesor']['nombre'] . " " . $_SESSION['datosProfesor']['apellidos'] . " ha grabado una nueva incidencia para el alumno " . $_SESSION['datosAlumno']['nombre'] . " " . $_SESSION['datosAlumno']['apellidos'];
    header("location:partes.php");
    exit;
}
?>