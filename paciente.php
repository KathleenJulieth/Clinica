<?php 
include 'gestionCitas.php';
$citas = listarCitas();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Consultorio</h2>
            <nav>
                <ul>
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#" class="active">Citas Paciente</a></li>
                    <li><a href="#">Perfil</a></li>
                    <li><a href="#">Configuración</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Bienvenido, Usuario</h1>
                <div class="user-profile">
                    <span>Hola, Byron Madariaga</span>
                    <img src="https://via.placeholder.com/40" alt="Profile">
                </div>
            </header>

            <!-- Content -->
            <section class="content">
                <!-- User's Appointments -->
                <div class="appointments">
                    <h2>Mis Citas</h2>
                    <button class="add-btn" onclick="mostrarModalNuevaCita()">+ Agendar Nueva Cita</button>
                    <table>
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Hora</th>
                                <th>Médico</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citas as $cita): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cita['NombrePaciente'] . ' ' . $cita['ApellidosPaciente']); ?></td>
                                <td><?php echo htmlspecialchars($cita['HoraCita']); ?></td>
                                <td><?php echo htmlspecialchars($cita['NombreDoctor'] . ' ' . $cita['ApellidosDoctor']); ?></td>
                                <td>
                                    <span class="status <?php 
                                        echo strtolower($cita['Estado']) === 'completada' ? 'completed' : 
                                             (strtolower($cita['Estado']) === 'cancelada' ? 'canceled' : 'pending'); 
                                    ?>">
                                        <?php echo htmlspecialchars($cita['Estado']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="action-btn" onclick="editarCita(<?php echo $cita['IDCita']; ?>)">Editar</button>
                                    <button class="action-btn danger" onclick="eliminarCita(<?php echo $cita['IDCita']; ?>)">Eliminar</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            
                <!-- Modal para Nueva/Editar Cita -->
                <div id="modalCita" style="display:none;">
                    <form id="formCita">
                        <input type="hidden" name="accion" id="accionCita">
                        <input type="hidden" name="idCita" id="idCita">
                        
                        <label>Fecha:</label>
                        <input type="date" name="fechaCita" required>
                        
                        <label>Hora:</label>
                        <input type="time" name="horaCita" required>
                        
                        <label>Paciente:</label>
                        <select name="idPaciente" required>
                            <?php 
                            $pacientes = "SELECT IDPaciente, Nombre, Apellidos FROM Paciente";
                            $resultado = mysqli_query($enlace, $pacientes);
                            while ($paciente = mysqli_fetch_assoc($resultado)) {
                                echo "<option value='{$paciente['IDPaciente']}'>{$paciente['Nombre']} {$paciente['Apellidos']}</option>";
                            }
                            ?>
                        </select>
                        
                        <label>Médico:</label>
                        <select name="idDoctor" required>
                            <?php 
                            $doctores = "SELECT IDDoctor, Nombre, Apellidos FROM Doctor";
                            $resultado = mysqli_query($enlace, $doctores);
                            while ($doctor = mysqli_fetch_assoc($resultado)) {
                                echo "<option value='{$doctor['IDDoctor']}'>{$doctor['Nombre']} {$doctor['Apellidos']}</option>";
                            }
                            ?>
                        </select>
                        
                        <label>Estado:</label>
                        <select name="estado" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Completada">Completada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                        
                        <button type="submit">Guardar</button>
                        <button type="button" onclick="cerrarModal()">Cancelar</button>
                    </form>
                </div>
            
                <script>
                function mostrarModalNuevaCita() {
                    $('#accionCita').val('crear');
                    $('#modalCita').show();
                }
            
                function editarCita(idCita) {
                    // Aquí deberías cargar los datos de la cita existente
                    $('#accionCita').val('actualizar');
                    $('#idCita').val(idCita);
                    $('#modalCita').show();
                }
            
                function eliminarCita(idCita) {
                    if (confirm('¿Estás seguro de eliminar esta cita?')) {
                        $.ajax({
                            url: 'gestionCitas.php',
                            method: 'POST',
                            data: {
                                accion: 'eliminar',
                                idCita: idCita
                            },
                            success: function(response) {
                                alert(response);
                                location.reload();
                            }
                        });
                    }
                }
            
                $('#formCita').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'gestionCitas.php',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            alert(response);
                            location.reload();
                        }
                    });
                });
            
                function cerrarModal() {
                    $('#modalCita').hide();
                }
                </script>
            </body>

</html>