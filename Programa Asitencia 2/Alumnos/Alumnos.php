<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "3080";
$dbname = "ProgramaAsistencia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuarioID = $_SESSION['usuarioID'];

function obtenerFechasMes($conn, $mes) {
    $queryFechasMes = "SELECT DISTINCT fecha FROM Asistencia WHERE MONTH(fecha) = $mes";
    $resultFechasMes = $conn->query($queryFechasMes);
    $fechasMesSeleccionado = [];
    while ($fecha = $resultFechasMes->fetch_assoc()) {
        $fechasMesSeleccionado[] = $fecha['fecha'];
    }
    return $fechasMesSeleccionado;
}

function obtenerAsignaturaParaClase($conn, $clase, $mesSeleccionado) {
    $query = "SELECT Asignatura FROM Asistencia WHERE clase = '$clase' AND MONTH(fecha) = $mesSeleccionado LIMIT 1";
    $result = $conn->query($query);

    if ($result === false) {
        die("Error en la consulta de asignatura: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['Asignatura'];
    } else {
        return '-';
    }
}

function obtenerEstadoParaFecha($conn, $alumnoID, $clase, $fecha) {
    $query = "SELECT estado FROM Asistencia WHERE AlumnoID = $alumnoID AND clase = '$clase' AND fecha = '$fecha'";
    $result = $conn->query($query);

    if ($result === false) {
        die("Error en la consulta de estado: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['estado'];
    } else {
        return '-';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asistencia</title>
    <link rel="stylesheet" href="../Estilos/Alumnos.css"/>
    <link rel="stylesheet" href="../Estilos/Header.css"/>
</head>
<body>
<header>
    <div class="navbar">
        <a class="navBarItemLeft" href="../index.php"> <img class="fotoIcono" src="../Includes/ImgHeader/salida.png"> </a>
        <a class="navBarItemLeft" href="Alumnos.php"> <img class="fotoIcono" src="../Includes/ImgHeader/lineas-de-calendario.png"> </a>
        <a class="navBarItemRight" href="NotificacionesAlumnos.php"> <img class="fotoIcono" src="../Includes/ImgHeader/sobre.png"> </a>
        <a class="navBarItemRight" href="PerfilAlumno.php"> <img class="fotoIcono" src="../Includes/ImgHeader/circulo-de-usuario.png"> </a>
    </div>
</header>
<div class="caja">
    <div class="formulario">
        <form method='get' class="formTabla">
            <label for='selectMes' class="seleccionaMes" >Selecciona un mes:</label>
            <select id='selectMes' class="selectMes" name='selectMes'>
                <?php
                $mesesEnEspanol = [
                    1 => 'Enero',
                    2 => 'Febrero',
                    3 => 'Marzo',
                    4 => 'Abril',
                    5 => 'Mayo',
                    6 => 'Junio',
                    7 => 'Julio',
                    8 => 'Agosto',
                    9 => 'Septiembre',
                    10 => 'Octubre',
                    11 => 'Noviembre',
                    12 => 'Diciembre'
                ];
                foreach ($mesesEnEspanol as $numeroMes => $nombreMes) {
                    echo "<option class = 'mesSelect' value='$numeroMes'>$nombreMes</option>";
                }
                ?>
            </select>
            <input type='submit' value='Mostrar Tabla'>
        </form>
    </div>
    <div class="mesLetra">
        <?php
            $mesSeleccionado = isset($_GET['selectMes']) ? $_GET['selectMes'] : null;
            if ($mesSeleccionado) {
                echo "<h2> " . $mesesEnEspanol[$mesSeleccionado] . "</h2>";
            }
            $fechasUnicas = [];
        ?>
    </div>
    <div class="boton">
        <a href="PorcentajePorModulos.php" class="boton">Ver Procentajes</a>
    </div>
</div>
<div class="Tabla">
    <?php
        if ($mesSeleccionado) {
            $queryClases = "SELECT DISTINCT clase FROM Asistencia WHERE AlumnoID = $usuarioID";
            $resultClases = $conn->query($queryClases);

            if ($resultClases === false) {
                die("Error en la consulta de clases: " . $conn->error);
            }

            $fechasMostrar = obtenerFechasMes($conn, $mesSeleccionado);

            echo "<table class='TablaT'>";
            echo "<tr><th>Clase</th><th>Asignatura</th>";

            foreach ($fechasMostrar as $fechaUnica) {
                echo "<th>" . date("d", strtotime($fechaUnica)) . "</th>";
            }

            echo "</tr>";

            $tablasDisponibles = false;
            $ausenciasPorAsignatura = array();

            while ($claseRow = $resultClases->fetch_assoc()) {
                $currentClase = $claseRow['clase'];
                $currentAsignatura = obtenerAsignaturaParaClase($conn, $currentClase, $mesSeleccionado);
                echo "<tr>";
                echo "<td>$currentClase</td>";
                echo "<td>$currentAsignatura</td>";

                $contadorAusencias = 0; // Nuevo contador para ausencias

                // Inicializa el contador de ausencias para cada asignatura
                $ausenciasPorAsignatura[$currentAsignatura] = 0;

                foreach ($fechasMostrar as $fechaUnica) {
                    $estado = obtenerEstadoParaFecha($conn, $usuarioID, $currentClase, $fechaUnica);
                    echo "<td>$estado</td>";

                    if ($estado !== '-') {
                        $tablasDisponibles = true;
                        // Verificar si el estado es "ausencia"
                        if ($estado === 'ausencia') {
                            $contadorAusencias++;
                            // Acumula el contador de ausencias para cada asignatura
                            $ausenciasPorAsignatura[$currentAsignatura]++;
                        }
                    }
                }
            }
                echo "</tr>"; // Cierra el tr después de imprimir las fechas


            echo "</table>"; // Cierra la tabla fuera del bucle
        }
        ?>
</div>

    <?php
        if (isset($ausenciasPorAsignatura) && is_array($ausenciasPorAsignatura)) {
            $ausenciasTotales = 0;

            foreach ($ausenciasPorAsignatura as $asignatura => $totalAusencias) {
                $ausenciasTotales += $totalAusencias;
            }

            $_SESSION['ausenciasPorAsignatura'] = $ausenciasPorAsignatura;
            $_SESSION['ausenciasTotales'] = $ausenciasTotales;
        }

        $conn->close();
    ?>

</body>
</html>