<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica General</title>
    <link rel="icon" type="image/png" href="iconP.png">
    <link rel="stylesheet" href="styles2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Consultorio</h2>
            <nav>
                <ul>
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="paciente.php">Paciente</a></li>
                    <li><a href="secretario.html" class="active">Formulario</a></li>
                    <li><a href="#">Médicos</a></li>
                    <li><a href="#">Configuración</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="titleBar">
                <div class="websiteTitle">
                    <h3>Clinica General - Formulario</h3>
                </div>
            </div>
            <div class="content">
                <div class="content-1">
                    <div class="navbar">
                        <div>
                            <a href="../index.html">Inicio > </a>
                            <a href="page2.html">Formulario</a>
                        </div>
                    </div>
                    <div class="articleWrapper">
                        <div class="articleText">
                            <h1>Formulario - Paciente</h1>
                            <form action="#" name="clinicageneral" method="post">
                                <input type="text" name="Nombre" placeholder="Nombre">
                                <input type="text" name="Apellidos" placeholder="Apellidos">
                                <input type="text" name="Telefono" placeholder="Telefono">
                                <input type="email" name="Correo" placeholder="Correo">
                                <input type="submit" class="btn" name="Enviar" value="Enviar">
                                <input type="reset" class="btn">
                            </form>
                        </div>
                        <div class="articleText">
                            <h1>Formulario - Doctores</h1>
                            <form action="#" name="clinicageneral" method="post">
                                <input type="text" name="NombreD" placeholder="Nombre">
                                <input type="text" name="ApellidosD" placeholder="Apellidos">
                                <input type="text" name="TelefonoD" placeholder="Telefono">
                                <input type="email" name="CorreoD" placeholder="Correo">
                                <input type="text" name="Especialidad" placeholder="Especialidad">
                                <input type="submit" class="btn" name="Enviar2" value="Enviar">
                                <input type="reset" class="btn">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="navButtons">
                </div>
            </div>
        </main>
    </div>

</body>
</html>

<?php
// Incluir conexión
include 'conexion.php';

if (isset($_POST['Enviar2'])) {
    $nombre = $_POST['NombreD'];
    $apellidos = $_POST['ApellidosD'];
    $telefono = $_POST['TelefonoD'];
    $correo = $_POST['CorreoD'];
    $especialidad = $_POST['Especialidad'];

    $insertaDatos = "INSERT INTO doctor (Nombre, Apellidos, IDEspecialidad, Correo, Telefono) 
                     VALUES ('$nombre', '$apellidos', '$especialidad', '$correo', '$telefono')";
    
    if ($enlace && mysqli_query($enlace, $insertaDatos)) {
        echo "<script>alert('Datos del doctor insertados correctamente.');</script>";
    } else {
        echo "<script>alert('Error al insertar datos del doctor: " . mysqli_error($enlace) . "');</script>";
    }
}

if (isset($_POST['Enviar'])) {
    $nombre = $_POST['Nombre'];
    $apellidos = $_POST['Apellidos'];
    $telefono = $_POST['Telefono'];
    $correo = $_POST['Correo'];

    $insertaDatos = "INSERT INTO paciente (Nombre, Apellidos, Telefono, Correo) 
                     VALUES ('$nombre', '$apellidos', '$telefono', '$correo')";
    
    if ($enlace && mysqli_query($enlace, $insertaDatos)) {
        echo "<script>alert('Datos del Paciente insertados correctamente.');</script>";
    } else {
        echo "<script>alert('Error al insertar datos del Paciente: " . mysqli_error($enlace) . "');</script>";
    }
}
?>

