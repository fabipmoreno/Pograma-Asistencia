<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../Estilos/NotificacionesJefeEstudios.css" class="PasarLista">
    <link rel="stylesheet" href="../Estilos/Header.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a class= "navBarItemLeft" href="../index.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/salida.png"> </a>
            <a class= "navBarItemLeft" href="JefeEstudios.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/lineas-de-calendario.png"> </a>
            <a class= "navBarItemRight" href="NotificacionesJefeEstudios.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/sobre.png"> </a>
            <a class= "navBarItemRight" href="PerfilJefeEstudios.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/circulo-de-usuario.png"> </a>
        </div>
    </header>

    <?php

    // Establece la conexión a la base de datos (ajusta las credenciales según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "3080";
    $dbname = "ProgramaAsistencia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para obtener la información de todos los alumnos con inasistencias por encima del 15%
    $query = "SELECT Alumno.*, 
                (SELECT COUNT(*) FROM Asistencia WHERE Asistencia.AlumnoID = Alumno.AlumnoID AND Asistencia.estado = 'ausencia') as inasistencias,
                (SELECT COUNT(*) FROM Asistencia WHERE Asistencia.AlumnoID = Alumno.AlumnoID AND Asistencia.estado = 'presente') as asistencias
              FROM Alumno";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Obtén el número de inasistencias y asistencias
            $inasistencias = $row['inasistencias'];
            $asistencias = $row['asistencias'];

            // Calcula el porcentaje de inasistencias
            $porcentajeInasistencias = ($inasistencias / ($inasistencias + $asistencias)) * 100;

            // Limita el número de decimales a 2
            $porcentajeInasistencias = number_format($porcentajeInasistencias, 2);

            // Define el umbral del 15%
            $umbral = 15;

            // Compara el porcentaje con el umbral
            if ($porcentajeInasistencias >= $umbral) {
                // Calcula el porcentaje de asistencias
            $porcentajeAsistencias = 100 - $porcentajeInasistencias;

               // Muestra la información del alumno, incluyendo la foto y el gráfico
               echo "<div class='informacion-alumno'>";
               echo "<img class='fotoAlumno' src='{$row['foto']}' alt='Foto de {$row['Nombre']}'>";
               echo "<h2>{$row['Nombre']} {$row['Apellidos']} ha superado el 15% de inasistencias! </h2>";
               echo "<p class='texto'>Porcentaje de inasistencias: $porcentajeInasistencias%</p>";
               echo "<div class='grafico-container'>";
               echo "<div class='grafico-barra red' style='width: {$porcentajeInasistencias}%;'></div>";
               echo "</div>";
            echo "</div>";
            }
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
    ?>

</body>
</html>
