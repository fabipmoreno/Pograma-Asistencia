<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "3080";
    $dbname = "ProgramaAsistencia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $nuevaContrasenia = $_POST['nuevaContrasenia'];
    $profesoID = $_SESSION['datos_usuario']['ProfesorID'];

    $hashContrasenia = password_hash($nuevaContrasenia, PASSWORD_DEFAULT);

    $sql = "UPDATE Profesor SET Contrasenia = '$hashContrasenia' WHERE ProfesorID = $profesoID";

    if ($conn->query($sql) === TRUE) {
        echo "Contraseña actualizada con éxito";
        header('Location: Profesores.php');
    } else {
        echo "Error al actualizar la contraseña: " . $conn->error;
    }

    $conn->close();
} else {
    header('Location: Profesores.php');
    exit;
}
?>
