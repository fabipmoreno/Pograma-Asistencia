<?php

// Inicia la sesión
session_start();

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

// Función para verificar las credenciales de Alumno
function verificarCredencialesAlumno($username, $password) {
    global $conn;

    $query = "SELECT * FROM Alumno WHERE Correo = '$username' AND Contrasenia = '$password'";
    $result = $conn->query($query);

    return ($result->num_rows > 0);
}

// Función para obtener el ID del alumno
function obtenerIDAlumno($username) {
    global $conn;

    $query = "SELECT AlumnoID FROM Alumno WHERE Correo = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['AlumnoID'];
    }

    return null;
}

function obtenerIDProfesor($username) {
    global $conn;

    $query = "SELECT ProfesorID FROM Profesor WHERE Correo = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['ProfesorID'];
    }

    return null;
}

function obtenerIDJefeEstudios($username) {
    global $conn;

    $query = "SELECT JefeEstudiosID FROM JefeEstudios WHERE Correo = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['AlumnoID'];
    }

    return null;
}

// Función para obtener los datos del alumno
function obtenerDatosAlumno($alumnoID) {
    global $conn;

    $query = "SELECT * FROM Alumno WHERE AlumnoID = $alumnoID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    }

    return null;
}

// Función para verificar las credenciales de Profesor
function verificarCredencialesProfesor($username, $password) {
    global $conn;

    $query = "SELECT * FROM Profesor WHERE Correo = '$username' AND Contrasenia = '$password'";
    $result = $conn->query($query);

    return ($result->num_rows > 0);
}

// Función para obtener los datos del profesor
function obtenerDatosProfesor($profesorID) {
    global $conn;

    $query = "SELECT * FROM Profesor WHERE ProfesorID = $profesorID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    }

    return null;
}

// Función para verificar las credenciales de Jefe de Estudios
function verificarCredencialesJefeEstudios($username, $password) {
    global $conn;

    $query = "SELECT * FROM JefeEstudios WHERE Correo = '$username' AND Contrasenia = '$password'";
    $result = $conn->query($query);

    return ($result->num_rows > 0);
}

// Función para obtener los datos del jefe de estudios
function obtenerDatosJefeEstudios($jefeEstudiosID) {
    global $conn;

    $query = "SELECT * FROM JefeEstudios WHERE JefeEstudiosID = $jefeEstudiosID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    }

    return null;
}

// Procesa el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (verificarCredencialesAlumno($username, $password)) {
        // Obtén el ID del usuario basado en el nombre de usuario
        $alumnoID = obtenerIDAlumno($username);

        if ($alumnoID !== null) {
            // Obtén y almacena los datos del alumno
            $datosAlumno = obtenerDatosAlumno($alumnoID);

            // Inicio de sesión exitoso para Alumno
            $_SESSION['usuarioID'] = $alumnoID;
            $_SESSION['usuario'] = 'alumno';
            $_SESSION['datos_usuario'] = $datosAlumno;

            header('Location: Alumnos/Alumnos.php');
            exit;
        } else {
            // Manejar el caso en el que no se encuentra el ID del alumno
            $_SESSION['error'] = "Error: No se pudo encontrar el ID del alumno.";
            header('Location: index.php');
            exit;
        }
    } elseif (verificarCredencialesProfesor($username, $password)) {
        // Obtén el ID del profesor basado en el nombre de usuario
        $profesorID = obtenerIDProfesor($username);

        if ($profesorID !== null) {
            // Obtén y almacena los datos del profesor
            $datosProfesor = obtenerDatosProfesor($profesorID);

            // Inicio de sesión exitoso para Profesor
            $_SESSION['usuarioID'] = $profesorID;
            $_SESSION['usuario'] = 'profesor';
            $_SESSION['datos_usuario'] = $datosProfesor;

            header('Location: Profesores/Profesores.php');
            exit;
        } else {
            // Manejar el caso en el que no se encuentra el ID del profesor
            $_SESSION['error'] = "Error: No se pudo encontrar el ID del profesor.";
            header('Location: index.php');
            exit;
        }
    } elseif (verificarCredencialesJefeEstudios($username, $password)) {
        // Obtén el ID del jefe de estudios basado en el nombre de usuario
        $jefeEstudiosID = obtenerIDJefeEstudios($username);

        if ($jefeEstudiosID !== null) {
            // Obtén y almacena los datos del jefe de estudios
            $datosJefeEstudios = obtenerDatosJefeEstudios($jefeEstudiosID);

            // Inicio de sesión exitoso para Jefe de Estudios
            $_SESSION['usuarioID'] = $jefeEstudiosID;
            $_SESSION['usuario'] = 'jefe_estudios';
            $_SESSION['datos_usuario'] = $datosJefeEstudios;

            header('Location: JefeEstudios/JefeEstudios.php');
            exit;
        } else {
            // Manejar el caso en el que no se encuentra el ID del jefe de estudios
            $_SESSION['error'] = "Error: No se pudo encontrar el ID del jefe de estudios.";
            header('Location: index.php');
            exit;
        }
    } else {
        // Credenciales incorrectas
        $_SESSION['error'] = "Inicio de sesión fallido. Verifica tus credenciales.";
        header('Location: index.php'); // Redirige de nuevo a la página de inicio de sesión
        exit;
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
