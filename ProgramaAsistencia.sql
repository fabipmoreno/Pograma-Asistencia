create database ProgramaAsistencia;

use ProgramaAsistencia;

CREATE TABLE JefeEstudios (
    JefeEstudiosID INT PRIMARY KEY auto_increment,
    Nombre varchar(50),
    Apellidos varchar(50), 
    Correo varchar(50),
    Contrasenia varchar(50),
    foto varchar(200)
);


CREATE TABLE Alumno (
    AlumnoID INT PRIMARY KEY auto_increment,
    Nombre varchar(50),
    Apellidos varchar(50), 
    Correo varchar(50),
    Contrasenia varchar(255),
    grupo ENUM ("Daw", "Dam", "Asir"),
    foto varchar(200)
);

select * from Alumno; 

CREATE TABLE Profesor (
    ProfesorID INT PRIMARY KEY auto_increment,
    Nombre varchar(50),
    Apellidos varchar(50), 
    Correo varchar(50),
    Contrasenia varchar(50),
    foto varchar(200)
);


CREATE TABLE Asistencia (
    ID INT PRIMARY KEY auto_increment,
    estado ENUM ('presente', 'ausencia', 'retraso', 'convalidado'), 
    AlumnoID INT,
    clase ENUM ('1', '2', '3', '4', '5', '6'),
    fecha DATE, 
    asignatura varchar(100),
    FOREIGN KEY (AlumnoID) REFERENCES Alumno(AlumnoID)
);

select * from Asistencia; 


INSERT INTO Alumno (Nombre, Apellidos, Correo, Contrasenia, grupo, foto) VALUES
('Juan', 'Perez', 'juan.perez@email.com', 'contrasena1', 'Daw', '../Img/ImagenesAlumnos/Alumno1.png'),
('Ana', 'Gonzalez', 'ana.gonzalez@email.com', 'contrasena2', 'Dam', '../Img/ImagenesAlumnos/Alumno2.jpg'),
('Pedro', 'Rodriguez', 'pedro.rodriguez@email.com', 'contrasena3', 'Asir', '../Img/ImagenesAlumnos/Alumno3.jpg'),
('Laura', 'Lopez', 'laura.lopez@email.com', 'contrasena4', 'Daw', '../Img/ImagenesAlumnos/Alumno4.jpg'),
('Carlos', 'Gomez', 'carlos.gomez@email.com', 'contrasena5', 'Dam', '../Img/ImagenesAlumnos/Alumno5.jpg'),
('Maria', 'Fernandez', 'maria.fernandez@email.com', 'contrasena6', 'Asir', '../Img/ImagenesAlumnos/Alumno6.jpg');



INSERT INTO Profesor (Nombre, Apellidos, Correo, Contrasenia, foto) VALUES
('Juan', 'Gomez', 'juan.gomez@email.com', 'pass123', '../Img/ImagenesAlumnos/Profesor1.jpg'),
('Maria', 'Lopez', 'maria.lopez@email.com', 'pass456', '../Img/ImagenesAlumnos/Profesor2.jpg');

select * from Profesor;

INSERT INTO JefeEstudios (Nombre, Apellidos, Correo, Contrasenia, foto) VALUES
('Susana', 'de la Peña', 'susana.jefa@email.com', "pass12", '../Img/ImagenesAlumnos/JefeEstudios.jpg');


select * from JefeEstudios;