<?php
// Conexión a la base de datos (reemplaza los valores con los de tu configuración)
$servername = "localhost";
$username = "root";
$password = "3080";
$dbname = "ProgramaAsistencia";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recuperar el nombre del alumno enviado desde el formulario
$correo_alumno = $_POST['correoAlumno'];

// Consulta para obtener el registro de asistencia del alumno
$sql = "SELECT * FROM Asistencia WHERE AlumnoID IN (SELECT AlumnoID FROM Alumno WHERE Correo='$correo_alumno')";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo "<link rel='stylesheet' href='../Estilos/VerAsistencia.css'>";

    echo "<header class='headerCambioAsistencia'>";
    echo "<a href='JefeEstudios.php'><img class='ImagenSalir' src='../Includes/ImgHeader/salida.png'></a>"; 
    echo "</header>";

    echo "<h2>Registro de Asistencia para $correo_alumno</h2>";
    echo "<form action='ActualizarAsistencia.php' method='POST' enctype='multipart/form-data'>";
    
    while ($row = $result->fetch_assoc()) {
        $fecha_hora = $row['fecha'];
        $hora = $row['clase'];
        $estado = $row['estado'];

        // Mostrar solo las filas con estado 'ausencia', 'convalidado' y 'retraso'
        if (in_array($estado, ['ausencia', 'convalidado', 'retraso'])) {
            echo "<label>Fecha: $fecha_hora</label>";
            echo "<label>Hora: $hora</label>";
            echo "<input type='hidden' name='asistencia_id[]' value='{$row['ID']}'>";
            echo "<label>Estado:</label>";
            echo "<select name='nuevo_estado[]'>";
            echo "<option value='presente' " . ($estado == 'presente' ? 'selected' : '') . ">Presente</option>";
            echo "<option value='ausencia' " . ($estado == 'ausencia' ? 'selected' : '') . ">Ausencia</option>";
            echo "<option value='retraso' " . ($estado == 'retraso' ? 'selected' : '') . ">Retraso</option>";
            echo "<option value='convalidado' " . ($estado == 'convalidado' ? 'selected' : '') . ">Convalidado</option>";
            echo "</select>";
            echo "<br>";
            echo "<br>";
            echo "<label>Justifcante:</label>";
            echo "<input type='file' class= 'archivo' name='justificante[]'>"; 
        }
    }

    echo "<button type='submit'>Actualizar Asistencia</button>";
    echo "</form>";
} else {
    header("Location: JefeEstudios.php?mensaje=No se han encontrado registros");
}

// Cerrar la conexión
$conn->close();
?>
