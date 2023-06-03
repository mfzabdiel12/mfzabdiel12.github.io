<?php
include('includes/conectar.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

function generar_clave($longitud) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $clave = '';
    $max = strlen($caracteres) - 1;

    for ($i = 0; $i < $longitud; $i++) {
        $clave .= $caracteres[rand(0, $max)];
    }

    return $clave;
}

$message = "";

if (isset($_POST['clase'])) {
    $nombre = $_POST['clase'];
    $clave = generar_clave(10);
    $usuario = $_SESSION['user'];
    $fecha = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual

    mysqli_query($conn, "INSERT INTO clase (nombre, clave, usuario, fecha) VALUES ('$nombre', '$clave', '$usuario', '$fecha')");
    $message = "Clase creada correctamente";
}

if (isset($_GET['e'])) {
    $claseId = $_GET['e'];
    mysqli_query($conn, "DELETE FROM clase WHERE idclase = '$claseId'");
    $message = "Clase eliminada correctamente";
}

$con = mysqli_query($conn, "SELECT * FROM clase WHERE usuario='" . $_SESSION['user'] . "'");
$n = mysqli_num_rows($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Clase</title>
    <link rel="stylesheet" href="css/creardiseño.css">
</head>
<body>
<a href="inicio.php">Inicio</a>
<h1>Gestión de Clases</h1>
<hr>
<form action="crearclase.php" method="post">
    <input type="text" name="clase" placeholder="NOMBRE CLASE" required><br>
    <input type="submit" value="Crear">
</form>
<hr>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Clave</th>
        <th>Fecha</th>
        <th>Acciones</th>
        <th>Ver Plan</th>
    </tr>
    <?php
    if ($n > 0) {
        while ($a = mysqli_fetch_assoc($con)) {
            echo "<tr>";
            echo "<td>" . $a['nombre'] . "</td>";
            echo "<td>" . $a['clave'] . "</td>";
            echo "<td>" . $a['fecha'] . "</td>";
            echo "<td><a href='crearclase.php?e=" . $a['idclase'] . "'>Eliminar</a></td>";
            echo "<td><a href='plan.php'>Ver Plan</a></td>";
            echo "</tr>";
        }
        echo "<tr><td colspan='5'><b>Total de clases: " . $n . "</b></td></tr>";
    } else {
        echo "<tr><td colspan='5'>No hay clases creadas</td></tr>";
    }
    ?>
</table>
<?php echo $message; ?>
</body>
</html>