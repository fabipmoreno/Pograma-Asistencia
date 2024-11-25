<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe De Estudios</title>
    <link rel="stylesheet" href="../Estilos/Header.css" class="css">
    <link rel="stylesheet" href="../Estilos/JefeEstudios.css">
</head>

<?php
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';

if (!empty($mensaje)) {
    echo "<script>alert('$mensaje');</script>";
}
?>

<header>
    <div class="navbar">
        <a class= "navBarItemLeft" href="../index.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/salida.png"> </a>
        <a class= "navBarItemLeft" href="JefeEstudios.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/lineas-de-calendario.png"> </a>
        <a class= "navBarItemRight" href="NotificacionesJefeEstudios.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/sobre.png"> </a>
        <a class= "navBarItemRight" href="PerfilJefeEstudios.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/circulo-de-usuario.png"> </a>
    </div>
</header>

<body>
    <form class= "formCambiarAsistencia" action="VerAsistencia.php" method="POST" >
    <h1 class="titulo" > Justificar Asistencia </h1>
    <label class="Correo" for="correoAlumno">Correo del Alumno:</label>
    <input type="mail" id="correoAlumno" name="correoAlumno" class= "correoAlumno" required>
    <button type="submit" class= "buscarAlumno" >Buscar Asistencia</button>
    </form>
</body>

</html>