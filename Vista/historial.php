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
Historial de alumno <?php echo $_SESSION['datosAlumno']['nombre'] . " " . $_SESSION['datosAlumno']['apellidos'] ?><br>

<?php
$buscarPartes = PartesControlador::buscarPartes($_SESSION['datosAlumno']['dni_a']);
if (is_array($buscarPartes) && count($buscarPartes) > 0) {
    $_SESSION['partess']=$buscarPartes;
    echo '<table border="1">';
    echo '<tr><th>Fecha</th><th>Dni Profesor</th><th>Motivo</th><th>Quitar Parte</th></tr>';
    foreach ($buscarPartes as $partes) {
        echo '<tr>';
        echo '<td>' . $partes->time . '</td>';
        echo '<td>' . $partes->dni_p . '</td>';
        echo '<td>' . $partes->motivo . '</td>';
        echo '<td>';
        echo "<form action='' method='POST'>";
       // echo "<input type='hidden' name='ibanId' value='{$cuenta->iban}'>";
        echo "<input type='submit' name='quitarparte' value='Quitar Parte'>";
        echo "</form>";
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "No hay partes para est alumno";
}
?>
