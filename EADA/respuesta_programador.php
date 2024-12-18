<?php
session_start();
include 'conexion.php';

// Verificar que el usuario sea programador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 'Programador') {
    die("Acceso no autorizado.");
}

// Verificar que se ha pasado un ID de ticket
if (!isset($_GET['id_ticket']) || empty($_GET['id_ticket'])) {
    die("No se especificó el ID del ticket.");
}

$id_ticket = intval($_GET['id_ticket']);

// Consultar el ticket y la respuesta en la base de datos
$query = "SELECT * FROM respuesta WHERE id_ticket = '$id_ticket' ORDER BY fecha_asignacion DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("No se encontró el ticket con el ID especificado.");
}

$ticket = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder Ticket</title>
    <link rel="stylesheet" href="pen_progra.css">
</head>
<body class="body_formulario">
    <h3 class="titulo_formulario">Responder Ticket</h3>
    <form action="procesar_respuesta.php" method="POST" class="formulario_ticket">
        <input type="hidden" name="id_ticket" value="<?= htmlspecialchars($ticket['id_ticket']) ?>">

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($ticket['titulo']) ?>" disabled>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" disabled><?= htmlspecialchars($ticket['descripcion']) ?></textarea>

        <label for="respuesta">Respuesta del Programador:</label>
        <textarea id="respuesta" name="respuesta" rows="4" required></textarea>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="Pendiente">Pendiente</option>
            <option value="En Progreso">En Progreso</option>
            <option value="Finalizado">Finalizado</option>
        </select>

        <button type="submit" class="boton_responder">Responder</button>
    </form>
</body>
</html>
