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
    $alumnoID = $_SESSION['datos_usuario']['AlumnoID'];

    $hashContrasenia = password_hash($nuevaContrasenia, PASSWORD_DEFAULT);

    $sql = "UPDATE Alumno SET Contrasenia = '$hashContrasenia' WHERE AlumnoID = $alumnoID";

    if ($conn->query($sql) === TRUE) {
        echo "Contraseña actualizada con éxito";
        header('Location: Alumnos.php');
    } else {
        echo "Error al actualizar la contraseña: " . $conn->error;
    }

    $conn->close();
} else {
    header('Location: Alumnos.php');
    exit;
}
?>
