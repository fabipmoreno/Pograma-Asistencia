<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ProgramaAsistencia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Establecer el juego de caracteres a utf8
$conn->set_charset("utf8");
?>
