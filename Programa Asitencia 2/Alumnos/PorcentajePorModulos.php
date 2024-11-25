<?php
session_start();

// Verifica si los datos están disponibles en la sesión
if (isset($_SESSION['ausenciasPorAsignatura']) && isset($_SESSION['ausenciasTotales'])) {
    $ausenciasPorAsignatura = $_SESSION['ausenciasPorAsignatura'];
    $ausenciasTotales = $_SESSION['ausenciasTotales'];
} else {
    // Manejo de caso donde los datos no están disponibles
    echo "No se encontraron datos de ausencias.";
    exit;
}


// Total permitido de asistencias (100%)
$totalAsistenciasPermitidas = 7; // Cambia esto según tus necesidades
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="../Estilos/Alumnos.css"/>
    <link rel="stylesheet" href="../Estilos/Header.css"/>
    <script src="Script/Porcentaje.js"></script>
</head>
<body >
<header>
    <div class="navbar">
        <a class="navBarItemLeft" href="Alumnos.php"> <img class="fotoIcono" src="../Includes/ImgHeader/salida.png"> </a>
        <a class="navBarItemLeft" href="Alumnos.php"> <img class="fotoIcono" src="../Includes/ImgHeader/lineas-de-calendario.png"> </a>
        <a class="navBarItemRight" href="NotificacionesAlumnos.php"> <img class="fotoIcono" src="../Includes/ImgHeader/sobre.png"> </a>
        <a class="navBarItemRight" href="PerfilAlumno.php"> <img class="fotoIcono" src="../Includes/ImgHeader/circulo-de-usuario.png"> </a>
    </div>
</header>

<div class="titulo">
    <h1>Porcentaje de Ausencias por Asignatura</h1>
</div>

<div class="Tabla">
    <table class='TablaT'>
        <tr>
            <th>Asignatura</th>
            <th>Total de Ausencias</th>
            <th>Porcentaje</th> <!-- Nueva columna para el porcentaje -->
        </tr>
        <?php
        foreach ($ausenciasPorAsignatura as $asignatura => $totalAusencias) {
            echo "<tr>";
            echo "<td>$asignatura</td>";
            echo "<td>$totalAusencias</td>";

            // Calcular y mostrar el porcentaje
            $porcentaje = ($totalAusencias / $totalAsistenciasPermitidas) * 100;
            echo "<td class='porcentajeTotal'>" . number_format($porcentaje, 2) . "%</td>";

            echo "</tr>";

        }
        ?>
        <tr>
            <td>Total General</td>
            <td><?php echo $ausenciasTotales; ?></td>
            <?php
            $porcentajeOriginal = ($ausenciasTotales / ($totalAsistenciasPermitidas * count($ausenciasPorAsignatura))) * 100;
            ?>
            <!-- Ahora, calcula el porcentaje total basándote en un máximo de 42 ausencias totales -->
            <?php
            $maxAusenciasTotales = 42;
            $porcentajeTotal = ($ausenciasTotales / $maxAusenciasTotales) * 100;
            ?>

            <!-- Muestra ambos porcentajes -->
            <td>
                <?php echo number_format($porcentajeTotal, 2) . "% "; ?>
            </td>
        </tr>
    </table>
</div>
<script src="Script/Porcentaje.js"></script>
</body>
</html>