<?php
require_once '../Controlador/ProfesorControlador.php';
require_once '../Controlador/ProfesorCursoControlador.php';
require_once '../Controlador/CursoControlador.php';
require_once '../Controlador/AlumnosControlador.php';

session_start();

if (!isset($_SESSION['datosProfesor'])) {
    header("location:index.php");
    exit;
}


if (isset($_GET['cerrar_sesion'])) {
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}

$cursosId = ProfesorCursoControlador::buscarCursoPorProfesor($_SESSION['datosProfesor']['dni_p']);
?>


<a href="partes.php?cerrar_sesion=true">Cerrar Sesión</a><br>
Profesor: <?php echo $_SESSION['datosProfesor']['nombre'] . " " . $_SESSION['datosProfesor']['apellidos'] ?><br>
<form action="" method="POST">
    Seleccione curso del alumno:
    <select name="cursos">
        <?php
        foreach ($cursosId as $curso) {
            echo "<option value='{$curso['descripcion']}'>{$curso['descripcion']}</option>";
        }
        ?>
    </select><br>
    <input type="submit" name="seleccionar" value="Seleccionar Curso">
</form>

<?php
if (isset($_POST['seleccionar'])) {
    $partes = CursoControlador::contarPartes($_POST['cursos']);

    $_SESSION['descrip'] = $_POST['cursos'];
    ?>
    Este curso tiene <?php echo $partes->totalPartes; ?> partes<br>

    Listado de alumnos:
    <?php
    $alumnos = AlumnosControlador::buscarporIdCurso($partes->id_curso);
    if (is_array($alumnos) && count($alumnos) > 0) {
        echo '<table border="1">';
        echo '<tr><th>Alumnos</th><th>Boton</th><th>Boton</th></tr>';

        foreach ($alumnos as $alumno) {
            echo '<tr>';
            echo '<td>' . $alumno->nombre . " " . $alumno->apellidos;
            '</td>';
            echo '<td>';
            echo "<form action='' method='POST'>";
            echo "<input type='hidden' name='dni' value='{$alumno->dni_a}'>";
            echo "<input type='submit' name='nuevoparte' value='Nuevo Parte'>";
            echo "</form>";
            echo '</td>';
            echo '<td>';
            echo "<form action='' method='POST'>";
            echo "<input type='hidden' name='dni2' value='{$alumno->dni_a}'>";
            echo "<input type='submit' name='historial' value='Historial'>";
            echo "</form>";
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No hay alumnos en este clase";
    }
}

if (isset($_POST['nuevoparte'])) {
    $_SESSION['dni'] = $_POST['dni'];
    header("location:nuevoparte.php");
    exit;
}
if (isset($_POST['historial'])) {
    $_SESSION['dni'] = $_POST['dni2'];
    header("location:historial.php");
    exit;
}

if (isset($_SESSION['parteingresado'])) {
    echo $_SESSION['parteingresado'];
    unset($_SESSION['parteingresado']);
}
?>
