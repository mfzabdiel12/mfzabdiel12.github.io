<?php
include('includes/conectar.php');
session_start();

if (isset($_SESSION['user'])) {
    header("Location: inicio.php");
    exit();
}

$message = "";

if (isset($_POST['u']) && isset($_POST['p'])) {
    $u = $_POST['u'];
    $p = $_POST['p'];

    $result = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario='$u' AND password='$p'");
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION['user'] = $u;
        header("Location: inicio.php");
        exit();
    } else {
        $message = "Usuario o contraseña incorrectos";
    }
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $u = $_POST['user'];
    $p = $_POST['pass'];
    $n = $_POST['nombre'];
    $f = $_FILES['foto']['name'];
    $t = $_POST['tipo'];

    $result = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario='$u'");
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $message = "El usuario ya está registrado";
    } else {
        move_uploaded_file($_FILES['foto']['tmp_name'], "archivos/" . $u . $f);
        mysqli_query($conn, "INSERT INTO usuario (usuario, password, nombre, foto, tipo) VALUES ('$u', '$p', '$n', '$f', '$t')");
        $message = "Usuario registrado correctamente";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The New Barber</title>
    <link rel="stylesheet" href="css/diseño.css">
</head>
<body>
    <h1>The New Barber</h1>
    <hr>
    <h1>Iniciar sesión</h1>
    <form action="index.php" method="post">
        Usuario <br>
        <input type="text" name="u" placeholder="Introduce usuario" required><br>
        Contraseña <br>
        <input type="password" name="p" placeholder="Introduce contraseña" required><br>
        <input type="submit" value="Iniciar"><br>
    </form>
    <p><?php echo $message; ?></p>
    <hr>
    <h1>Registro</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        Usuario <br>
        <input type="text" name="user" placeholder="Introduce usuario" required><br>
        Contraseña <br>
        <input type="password" name="pass" placeholder="Introduce contraseña" required><br>
        Nombre <br>
        <input type="text" name="nombre" placeholder="Introduce nombre" required><br>
        Foto <br>
        <input type="file" name="foto" required><br>
        Tipo <br>
        <select name="tipo" id="tipo">
            <option value="profe">Profesor</option>
            <option value="alumno">Alumno</option>
        </select><br><br>
        <input type="submit" value="Registrar"><br>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>