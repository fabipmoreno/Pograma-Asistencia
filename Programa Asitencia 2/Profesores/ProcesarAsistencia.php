<?php
$servername = "localhost";
$username = "root";
$password = "3080";
$dbname = "ProgramaAsistencia";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
    $hora = isset($_POST['hora']) ? $_POST['hora'] : '';
    $alumnoIDs = isset($_POST['alumnoID']) ? $_POST['alumnoID'] : '';
    $asistencias = isset($_POST['asistencia']) ? $_POST['asistencia'] : '';
    $asignatura = isset($_POST['asignatura']) ? $_POST['asignatura'] : '';

    // Insertar datos en la tabla Asistencia
    foreach ($alumnoIDs as $key => $alumnoID) {
        $estado = $asistencias[$key];

        // Corrige la columna de clase a asignatura
        $query = "INSERT INTO Asistencia (estado, AlumnoID, clase, fecha, asignatura) VALUES ('$estado', $alumnoID, '$hora', '$fecha', '$asignatura')";

        $result = $conn->query($query);
    }
    echo "<script>alert('Asistencia registrada exitosamente.');</script>";
    echo "<script>window.location.href = 'Profesores.php';</script>";
}
?>