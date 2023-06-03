<?php
include('includes/conectar.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location:index.php");
    exit();
}

if (isset($_REQUEST['clave'])) {
    $_SESSION['clave'] = $_REQUEST['clave'];
}

if (isset($_REQUEST['fe'])) {
    $u = $_SESSION['user'];
    $c = isset($_SESSION['clave']) ? $_SESSION['clave'] : '';
    $t = $_REQUEST['titulo'];
    $tx = $_REQUEST['texto'];
    $fe = $_REQUEST['fe'];
    echo $fe;
    mysqli_query($conn, "INSERT INTO plan VALUES(NULL, '$u', '$c', '$t', '$tx', NULL, '$fe')");
}

$queryplan = mysqli_query($conn, "SELECT * FROM plan WHERE usuario='".$_SESSION['user']."' AND clave='".(isset($_SESSION['clave']) ? $_SESSION['clave'] : '')."' ORDER BY fecha DESC");
$n = mysqli_num_rows($queryplan);
$aplan = mysqli_fetch_assoc($queryplan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plan de Clase</title>
</head>
<body>
<h1>Agregar Actividades a Plan</h1><br>
<form action="plan.php" method="post">
    <input type="text" name="titulo" placeholder="Titulo" required><br>
    <textarea name="texto" id="" cols="30" rows="10" placeholder="Texto " required></textarea><br>
    <input type="date" name="fe" placeholder="Fecha de Entrega" required><br>
    <input type="submit" name="Agregar">

</form>
<?php
while ($aplan !== null) {
    echo "<br>";
    echo "<h1>".$aplan['titulo']."</h1><br>";
    echo "<p>".$aplan['texto']."</p>";
    echo "fecha: ".$aplan['fecha']."     fecha entrega:".$aplan['fechaentrega']."<br>";
    echo "[<a href='plan.php?ea=".$aplan['idplan']."'> Eliminar Actividad</a>]";
    echo "[<a href='plan.php?ma=".$aplan['idplan']."'> Modificar Actividad</a>]";
    echo "<hr>";

    $aplan = mysqli_fetch_assoc($queryplan);
}
?>

</body>
</html>