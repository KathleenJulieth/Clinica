
USE GestionCitasMedicas;

-- Tabla Especialidad
CREATE TABLE Especialidad (
    IDEspecialidad INT PRIMARY KEY,
    NombreEspecialidad VARCHAR(50) NOT NULL
);

-- Tabla Doctor
CREATE TABLE Doctor (
    IDDoctor INT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellidos VARCHAR(100) NOT NULL,
    IDEspecialidad INT,
    Email VARCHAR(50),
    Telefono VARCHAR(10),
    FOREIGN KEY (IDEspecialidad) REFERENCES Especialidad(IDEspecialidad)
);

-- Tabla Paciente
CREATE TABLE Paciente (
    IDPaciente INT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellidos VARCHAR(100) NOT NULL,
    Correo VARCHAR(50),
    Telefono VARCHAR(10)
);

-- Tabla Turno
CREATE TABLE Turno (
    IDTurno INT PRIMARY KEY,
    Jornada VARCHAR(50) NOT NULL,
    HoraInicio TIME NOT NULL,
    HoraFin TIME NOT NULL
);

-- Tabla intermedia Doctor_Horario (Relación entre Doctor y Turno)
CREATE TABLE Horario (
    IDDoctor INT,
    IDTurno INT,
    DiaDeLaSemana VARCHAR(10) NOT NULL, -- Ejemplo: Lunes, Martes, etc.
    PRIMARY KEY (IDDoctor, IDTurno, DiaDeLaSemana), -- Clave primaria compuesta
    FOREIGN KEY (IDDoctor) REFERENCES Doctor(IDDoctor),
    FOREIGN KEY (IDTurno) REFERENCES Turno(IDTurno)
);

-- Tabla Cita
CREATE TABLE Cita (
    IDCita INT PRIMARY KEY,
    FechaCita DATE NOT NULL,
    HoraCita TIME NOT NULL,
    IDPaciente INT,
    IDDoctor INT,
    Estado VARCHAR(50),
    FOREIGN KEY (IDPaciente) REFERENCES Paciente(IDPaciente),
    FOREIGN KEY (IDDoctor) REFERENCES Doctor(IDDoctor)
);
