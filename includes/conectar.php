<?php
$server = "localhost";
$user = "root";
$pass = "";
$bd = "plataforma";

// Conexión a la base de dastos
$conn = new mysqli($server, $user, $pass, $bd);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>