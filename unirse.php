<?php
include('includes/conectar.php');
session_start();
if(!isset($_SESSION['user'])){
	header("Location:index.php");
	exit();
}
if(isset($_REQUEST['clave'])){
	$clave = $_REQUEST['clave'];
	$usuario = $_SESSION['user'];
	$result = mysqli_query($conn, "SELECT * FROM clase WHERE clave='$clave'");
	$n = mysqli_num_rows($result);
	$result2 = mysqli_query($conn, "SELECT * FROM misclases WHERE clave='$clave' AND usuario='$usuario'");
	$n2 = mysqli_num_rows($result2);
	if($n > 0){
		if($n2 == 0){
			mysqli_query($conn, "INSERT INTO misclases VALUES(NULL,'$usuario','$clave')");
		}else{
			echo "<script> alert('Ya estás inscrito en esta clase'); </script>";
		}
	}else{
		echo "<script> alert('La clase no existe'); </script>";
	}
}
if(isset($_REQUEST['e'])){
	mysqli_query($conn, "DELETE FROM misclases WHERE idmiclase=".$_REQUEST['e']);
}
$con=mysqli_query($conn, "SELECT clase.nombre, misclases.idmiclase FROM clase, misclases WHERE clase.clave=misclases.clave AND misclases.usuario='".$_SESSION['user']."'");
$n=mysqli_num_rows($con);
$a=mysqli_fetch_assoc($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Unirse a clase</title>
</head>
<body>
<a href="inicio.php">Inicio</a>
<h1>Unirse a clase</h1><br>
<form action="unirse.php" method="post">
	<input type="text" name="clave" placeholder="CLAVE DE LA CLASE" required><br>
	<input type="submit" value="Unirse a clase">
</form>
<hr>
<h1>Mis clases</h1><hr>
<table>
	<tr>
		<td>Nombre</td>
		<td>Eliminar</td>
	</tr>
	<?php
	if($n>0){
		do{
            echo "<tr><td>".$a['nombre']."</td>";
            echo "<td><a href='unirse.php?e=".$a['idmiclase']."'>Eliminar</a></td></tr>";
		}while ($a=mysqli_fetch_assoc($con)); 
	}else{
		echo "<tr><td>No hay clases</td></tr>";
	}
	?>
</table>

</body>
</html>