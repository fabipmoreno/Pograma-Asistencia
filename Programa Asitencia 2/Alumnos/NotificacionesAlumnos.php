<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../Estilos/Header.css">
    <link rel="stylesheet" href="../Estilos/NotificacionesAlumnos.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a class= "navBarItemLeft" href="../index.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/salida.png"> </a>
            <a class= "navBarItemLeft" href="Alumnos.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/lineas-de-calendario.png"> </a>
            <a class= "navBarItemRight" href="NotificacionesAlumnos.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/sobre.png"> </a>
            <a class= "navBarItemRight" href="PerfilAlumno.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/circulo-de-usuario.png"> </a>
        </div>
    </header>
    
    <div class="contenido">
        <?php
        // Inicia la sesión
        session_start();

        // Verifica si hay una sesión activa y si tiene un usuarioID
        if (isset($_SESSION['usuarioID'])) {
            $usuarioID = $_SESSION['usuarioID'];

            $servername = "localhost";
            $username = "root";
            $password = "3080";
            $dbname = "ProgramaAsistencia";

            // Crear la conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta SQL para obtener datos del alumno, incluida la foto
            $sql = "SELECT a.AlumnoID, a.Nombre, a.Apellidos, a.Correo, a.grupo, a.foto, asis.estado, asis.fecha, asis.asignatura
                    FROM Alumno a
                    INNER JOIN Asistencia asis ON a.AlumnoID = asis.AlumnoID
                    WHERE a.AlumnoID = $usuarioID AND asis.estado IN ('ausencia', 'retraso')";

            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                echo "<h1 class 'titulo'> Notificaciones </h1>";
                while ($row = $result->fetch_assoc()) {
                    $estado = $row["estado"];
                    $fecha = $row["fecha"];
                    $asignatura = $row["asignatura"];
                    $fotoAlumno = $row["foto"];
                    echo "<div class='resultados'>";

                    echo "<img src='{$fotoAlumno}' alt='Foto de {$row['Nombre']}' class='fotoAlumno'>"; 
                    echo "<p class='texto'>Tienes una '$estado' el día: '$fecha' en la asignatura '$asignatura'.</p>";
                }
                echo "</div>";
            } else {
                echo "<p class= 'mensajeNada' >No se encontraron ausencias ni retrasos.</p>";
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            // Si no hay sesión activa, redirige a la página de inicio de sesión
            header("Location: index.php");
        }
        ?>
    </div>
</body>
</html>
