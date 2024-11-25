<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores</title>
    <link rel="stylesheet" href="../Estilos/Profesores.css" class="PasarLista">
    <link rel="stylesheet" href="../Estilos/Header.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a class= "navBarItemLeft" href="../index.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/salida.png"> </a>
            <a class= "navBarItemLeft" href="Profesores.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/lineas-de-calendario.png"> </a>
            <a class= "navBarItemRight" href="NotificacionesProfesor.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/sobre.png"> </a>
            <a class= "navBarItemRight" href="PerfilProfesor.php"> <img class= "fotoIcono" src="../Includes/ImgHeader/circulo-de-usuario.png"> </a>
        </div>
    </header>
    <form action="PasarLista.php" method="post">
    <label class = "TextoSelectClase" >Selecciona la clase:</label>
    <br>
    <div class="divCheckbox">
    <input type="checkbox" name="clase[]" value="Daw" id="daw">
    <label class="TextoClase" for="daw">Daw</label>
    <input type="checkbox" name="clase[]" value="Dam" id="dam">
    <label class="TextoClase" for="dam">Dam</label>
    <input type="checkbox" name="clase[]" value="Asir" id="asir">
    <label class="TextoClase" for="asir">Asir</label>
    </div>
    

    <label for="fecha" class="TextoFecha">Selecciona una fecha:</label>
    <input type="date" id="fecha" name="fecha" class="opcionesForm" required min="2023-01-01">

        <label class = "masTexto" for="hora">Selecciona la hora:</label>
        <select name="hora" id="hora" class="opcionesForm">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>

        <label class = "masTexto" for = "asignatura"> Selecciona la asignatura </label>
        <select name= "asignatura" id= "asignatura" class="opcionesForm">
            <option value="Marcas"> Marcas </option>
            <option value="Marcas"> Redes </option>
            <option value="Marcas"> Android </option>
        </select>

    <button type="submit">Enviar</button>
    </form>


</body>
</html>