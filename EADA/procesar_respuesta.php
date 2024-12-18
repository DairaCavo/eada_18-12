<?php
session_start();
include 'conexion.php';

// Verificar que el usuario sea programador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 'Programador') {
    die("Acceso no autorizado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ticket = intval($_POST['id_ticket']);
    $respuesta = $conn->real_escape_string(trim($_POST['respuesta']));
    $estado = $conn->real_escape_string(trim($_POST['estado']));
    $id_usuario = $_SESSION['id_usuario'];

    // Actualizar la respuesta en la tabla 'respuesta'
    $query = "
        INSERT INTO respuesta (id_ticket, id_programador, respuesta, estado) 
        VALUES ('$id_ticket', '$id_usuario', '$respuesta', '$estado')
    ";

    if ($conn->query($query)) {
        echo "Respuesta enviada correctamente.";
    } else {
        echo "Error al procesar la respuesta: " . $conn->error;
    }

    $conn->close();
}
?>
