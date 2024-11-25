<?php
// Conexión a la base de datos (ajusta las credenciales según tu configuración)
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
    // Obtener los datos del formulario
    $clases = isset($_POST['clase']) ? $_POST['clase'] : [];
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
    $hora = isset($_POST['hora']) ? $_POST['hora'] : '';
    $asignatura = isset($_POST['asignatura']) ? $_POST['asignatura'] : '';

    // Consulta SQL para obtener los alumnos de las clases seleccionadas
    $query = "SELECT * FROM Alumno WHERE grupo IN ('" . implode("','", $clases) . "')";
    $result = $conn->query($query);

    // Mostrar información del grupo
    echo "<header class='headerLista'>";
    echo "<a href='Profesores.php'><img class='ImagenSalir' src='../Includes/ImgHeader/salida.png'></a>"; 
    echo "<p class='TextoGrupos'>Grupos: " . implode(", ", $clases) . "</p>";
    echo "<p class='TextoDia'>Día Seleccionado: $fecha</p>";
    echo "<p class='TextoHora'>Hora Seleccionada: $hora</p>";
    echo "<p class='TextoHora'>Modulo: $asignatura </p>";
    echo "</header>";

    // Mostrar el formulario
    echo "<form class='FormPasarLista' action='ProcesarAsistencia.php' method='post'>";

    echo '<link rel="stylesheet" href="../Estilos/PasarLista.css" class="PasarLista">';


    // Mostrar un formulario para cada alumno
    while ($alumno = $result->fetch_assoc()) {
        echo "<input class='nombreAlumno' type='hidden' name='alumnoID[]' value='" . $alumno['AlumnoID'] . "'>";
        echo "<input class='fecha' type='hidden' name='fecha' value='$fecha'>";
        echo "<input class='hora' type='hidden' name='hora' value='$hora'>";
        echo "<input class='asignatura' type='hidden' name='asignatura' value='$asignatura'>";
        echo "<input class='grupo' type='hidden' name='grupo' value='{$alumno['grupo']}'>";
        echo "<label class='datosAlumno'>";
        echo "<img src='{$alumno['foto']}' alt='Foto de {$alumno['Nombre']}' class='fotoAlumno'>"; 
        echo "{$alumno['Nombre']} {$alumno['Apellidos']} - Grupo: {$alumno['grupo']}</label>";
        echo "<select class='asistencia' name='asistencia[]'>";
        echo "<option value='presente'>Presente</option>";
        echo "<option value='ausencia'>Ausencia</option>";
        echo "<option value='retraso'>Retraso</option>";
        echo "<option value='convalidado'>Convalidado</option>";
        echo "</select>";
    }

    // Mostrar el botón al final
    echo "<button class='pasarAsistencia' type='submit'>Registrar Asistencia</button>";

    echo "</form>";
}
?>
