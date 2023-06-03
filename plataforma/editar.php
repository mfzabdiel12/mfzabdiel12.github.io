<?php
include('includes/conectar.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$message = "";

$user = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario='" . $_SESSION['user'] . "'");
$a = mysqli_fetch_assoc($user);

if (isset($_POST['nombre']) && isset($_FILES['foto'])) {
    $n = $_POST['nombre'];
    $f = $_FILES['foto']['name'];

    move_uploaded_file($_FILES['foto']['tmp_name'], "archivos/" . $_SESSION['user'] . $f);
    mysqli_query($conn, "UPDATE usuario SET nombre='$n', foto='$f' WHERE usuario='" . $_SESSION['user'] . "'");
    $message = "Perfil actualizado correctamente";
}

if (isset($_POST['pass'])) {
    $p = $_POST['pass'];

    mysqli_query($conn, "UPDATE usuario SET password='$p' WHERE usuario='" . $_SESSION['user'] . "'");
    $message = "Contraseña actualizada correctamente";
}

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
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/edidiseño.css">
</head>
<body>
    <h1>Editar Perfil</h1>
    <hr>
    <h2>Datos personales</h2>
    <form action="editar.php" method="post" enctype="multipart/form-data">
        Nombre <br>
        <input type="text" name="nombre" placeholder="Introduce nombre" value="<?php echo $a['nombre']; ?>" required><br>
        Foto <br>
        <input type="file" name="foto"><br>
        <input type="submit" value="Actualizar"><br>
    </form>
    <p><?php echo $message; ?></p>
    <hr>
    <h2>Cambiar contraseña</h2>
    <form action="editar.php" method="post">
        Nueva contraseña <br>
        <input type="password" name="pass" placeholder="Introduce nueva contraseña" required><br>
        <input type="submit" value="Cambiar"><br>
    </form>
    <p><?php echo $message; ?></p>
    <hr>
    <a href="inicio.php">Volver al inicio</a>
    <br>
    <a href="inicio.php?cerrar=1">Cerrar sesión</a>
</body>
</html>