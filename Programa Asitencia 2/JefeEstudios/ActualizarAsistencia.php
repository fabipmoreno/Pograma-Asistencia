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

// Carpeta donde se guardarán los archivos
$carpeta_destino = "../Img/Justificantes"; // Ajusta la ruta según tu estructura de archivos

// Recuperar datos del formulario
$asistencia_ids = $_POST['asistencia_id'];
$nuevos_estados = $_POST['nuevo_estado'];

// Procesar archivos
$justificantes = $_FILES['justificante'];

for ($i = 0; $i < count($asistencia_ids); $i++) {
    $asistencia_id = $asistencia_ids[$i];
    $nuevo_estado = $nuevos_estados[$i];
    
    // Actualizar el estado de asistencia en la base de datos
    $sql = "UPDATE Asistencia SET estado='$nuevo_estado' WHERE ID=$asistencia_id";

    if ($conn->query($sql) !== TRUE) {
        echo "Error al actualizar asistencia: " . $conn->error;
    }

    // Procesar el justificante
    $nombre_archivo = $justificantes['name'][$i];
    $archivo_temporal = $justificantes['tmp_name'][$i];
    $ruta_destino = "$carpeta_destino/$nombre_archivo";

    if (move_uploaded_file($archivo_temporal, $ruta_destino)) {
        echo "Archivo $nombre_archivo movido correctamente.";
    } else {
        echo "Error al mover el archivo $nombre_archivo.";
    }
}

header("Location: JefeEstudios.php?mensaje=Asistencia actualizada correctamente");

// Cerrar la conexión
$conn->close();
?>