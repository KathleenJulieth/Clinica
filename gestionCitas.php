<?php
include 'conexion.php'; // Archivo de conexión a la base de datos

// Función para crear una nueva cita
function crearCita($fechaCita, $horaCita, $idPaciente, $idDoctor, $estado) {
    global $enlace;
    $query = "INSERT INTO Cita (FechaCita, HoraCita, IDPaciente, IDDoctor, Estado) 
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($enlace, $query);
    mysqli_stmt_bind_param($stmt, "ssiis", $fechaCita, $horaCita, $idPaciente, $idDoctor, $estado);
    
    return mysqli_stmt_execute($stmt);
}

// Función para listar citas
function listarCitas() {
    global $enlace;
    $query = "SELECT c.IDCita, c.FechaCita, c.HoraCita, 
                     p.Nombre AS NombrePaciente, 
                     p.Apellidos AS ApellidosPaciente,
                     d.Nombre AS NombreDoctor, 
                     d.Apellidos AS ApellidosDoctor,
                     c.Estado 
              FROM Cita c
              JOIN Paciente p ON c.IDPaciente = p.IDPaciente
              JOIN Doctor d ON c.IDDoctor = d.IDDoctor
              ORDER BY c.FechaCita, c.HoraCita";
    
    $resultado = mysqli_query($enlace, $query);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

// Función para actualizar cita
function actualizarCita($idCita, $fechaCita, $horaCita, $idPaciente, $idDoctor, $estado) {
    global $enlace;
    $query = "UPDATE Cita 
              SET FechaCita = ?, 
                  HoraCita = ?, 
                  IDPaciente = ?, 
                  IDDoctor = ?, 
                  Estado = ?
              WHERE IDCita = ?";
    
    $stmt = mysqli_prepare($enlace, $query);
    mysqli_stmt_bind_param($stmt, "ssiisi", $fechaCita, $horaCita, $idPaciente, $idDoctor, $estado, $idCita);
    
    return mysqli_stmt_execute($stmt);
}

// Función para eliminar cita
function eliminarCita($idCita) {
    global $enlace;
    $query = "DELETE FROM Cita WHERE IDCita = ?";
    
    $stmt = mysqli_prepare($enlace, $query);
    mysqli_stmt_bind_param($stmt, "i", $idCita);
    
    return mysqli_stmt_execute($stmt);
}


// Manejar solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    switch ($accion) {
        case 'crear':
            $resultado = crearCita(
                $_POST['fechaCita'],
                $_POST['horaCita'],
                $_POST['idPaciente'],
                $_POST['idDoctor'],
                $_POST['estado']
            );
            echo $resultado ? "Cita creada exitosamente" : "Error al crear cita";
            break;
        
        case 'actualizar':
            $resultado = actualizarCita(
                $_POST['idCita'],
                $_POST['fechaCita'],
                $_POST['horaCita'],
                $_POST['idPaciente'],
                $_POST['idDoctor'],
                $_POST['estado']
            );
            echo $resultado ? "Cita actualizada exitosamente" : "Error al actualizar cita";
            break;
        
        case 'eliminar':
            $resultado = eliminarCita($_POST['idCita']);
            echo $resultado ? "Cita eliminada exitosamente" : "Error al eliminar cita";
            break;
    }
    exit();
}
?>