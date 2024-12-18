<?php
session_start();
include 'conexion.php';

// Verificar que el usuario sea cliente
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 'Cliente') {
    die("Acceso no autorizado.");
}

// Verificar si se pasó un ID de ticket
if (!isset($_GET['id_ticket']) || empty($_GET['id_ticket'])) {
    die("No se especificó el ID del ticket.");
}

$id_ticket = intval($_GET['id_ticket']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta Usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h3>Responder al Ticket</h3>
    <form action="validacion_usuario.php" method="POST">
        <input type="hidden" name="id_ticket" value="<?= htmlspecialchars($id_ticket) ?>">

        <label for="respuesta">Respuesta del Usuario:</label>
        <textarea id="respuesta" name="respuesta" rows="4" required></textarea>

        <button type="submit">Enviar Respuesta</button>
    </form>
</body>
</html>
