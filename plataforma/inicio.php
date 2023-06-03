<?php
include('includes/conectar.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario='" . $_SESSION['user'] . "'");
$a = mysqli_fetch_assoc($user);

if (isset($_REQUEST['cerrar'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="css/disinicio.css">
</head>
<body>
    <img src="archivos/<?php echo $_SESSION['user'].$a['foto']; ?>" width="100" height="100">
    <br>
    <p>Tu nombre es: <?php echo $a['nombre']; ?></p>
    <p>Tipo de usuario: <?php echo $a['tipo']; ?></p>

    <?php
    if ($a['tipo'] == 'profe') {
        echo "<a href='crearclase.php'>Crear Clase</a>";
    }
    if ($a['tipo'] == 'alumno') {
        echo "<a href='unirse.php'>Unirse a Clase</a>";
    }


    ?>
    <br>
    <a href="inicio.php?cerrar=1">Cerrar sesión</a>
    <br>
    <a href="editar.php">Editar Perfil</a>
</body>
</html> 