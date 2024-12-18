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
    $id_programador = $_SESSION['id_usuario'];

    $query_respuesta = "
        INSERT INTO respuestas (id_ticket, respuesta, fecha_respuesta) 
        VALUES ('$id_ticket', '$id_programador', NOW())
    ";

    $query_ticket = "
        UPDATE tickets 
        SET estado = '$estado'
        WHERE id_ticket = '$id_ticket'
    ";

    if ($conn->query($query_respuesta) && $conn->query($query_ticket)) {
        echo "Respuesta enviada correctamente.";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
