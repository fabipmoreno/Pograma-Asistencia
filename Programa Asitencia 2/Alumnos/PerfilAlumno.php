<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Alumno</title>
    <link rel="stylesheet" href="../Estilos/PerfilAlumno.css">
    <link rel="stylesheet" href="../Estilos/Header.css">
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

    <div class="containerPerfil">
        <?php
        // Inicia la sesión
        session_start();

        // Verifica si el usuario ha iniciado sesión como alumno
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'alumno' || empty($_SESSION['datos_usuario'])) {
            // Redirige a la página de inicio de sesión si el usuario no ha iniciado sesión como alumno
            header('Location: ../index.php');
            exit;
        }

        // Obtiene los datos del alumno de la sesión
        $datosAlumno = $_SESSION['datos_usuario'];

        // Imprime los datos del alumno
        echo "<div class='containerPerfil datosUsuario'>";
        echo "<img src='{$datosAlumno['foto']}' alt='Foto de {$datosAlumno['Nombre']}' class='fotoProfesor'>";
        echo "<h2 class='titulo'>Perfil del Alumno</h2>";
        echo "<p>Nombre: {$datosAlumno['Nombre']}</p>";
        echo "<p>Apellidos: {$datosAlumno['Apellidos']}</p>";
        echo "<p>Correo: {$datosAlumno['Correo']}</p>";
        echo "</div>";
        ?>

        <!-- Botón para cambiar la contraseña -->
        <button class="BotonContrasenia" onclick="mostrarFormulario()">Cambiar Contraseña</button>

        <!-- Formulario para cambiar la contraseña -->
        <div id="formularioCambioContrasenia" style="display: none;">
            <form action="cambioContrasenia.php" method="post">
                <label for="nuevaContrasenia">Nueva Contraseña:</label>
                <input type="password" name="nuevaContrasenia" required>
                <input type="submit" value="Cambiar Contraseña">
            </form>
        </div>
    </div>

    <script>
        // Función para mostrar el formulario al hacer clic en el botón
        function mostrarFormulario() {
            document.getElementById('formularioCambioContrasenia').style.display = 'block';
        }
    </script>

    <!-- Agrega el resto de tu contenido HTML y cierre del body y html según sea necesario -->
</body>
</html>