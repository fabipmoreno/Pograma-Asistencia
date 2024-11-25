<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="Estilos/Login.css" class="css">
</head>

<body>

    <div class="headerLogin">
        <img src="Img/logoNebrija.png" alt="" class="fotoMariposa">
    </div>
    <div class="formulario">
        <form action="login.php" method="post">
            <img src="" alt="" class="logo">
            <label for="username" class="textForm">Correo:</label>
            <br>
            <input type="text" class="usuario" id="username" name="username" required>
            <br>
            <label class="textForm2">Contraseña:</label>
            <br>
            <input type="password" class="contrasenia" id="password" name="password" required>
            <br>
            <?php
            session_start();

            // Muestra el mensaje de error si existe
            if (isset($_SESSION['error'])) {
                echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
                // Limpia el mensaje de error para evitar que se muestre en futuros intentos de inicio de sesión
                unset($_SESSION['error']);
            }
            ?>
            <br>
            <button class="botonLogin" type="submit"> Iniciar sesión </button>
        </form>

        <a href="" class="contraseniaOlvidada"> ¿Contraseña Olvidada? </a>

    </div>

</body>

</html>
