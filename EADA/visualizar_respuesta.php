<?php
session_start();
include 'conexion.php';

// Verificar que el usuario sea cliente
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 'Cliente') {
    die("Acceso no autorizado.");
}

// Verificar que se ha pasado un ID de ticket
if (!isset($_GET['id_ticket']) || empty($_GET['id_ticket'])) {
    die("No se especificó el ID del ticket.");
}

$id_ticket = intval($_GET['id_ticket']);

// Consultar la respuesta del ticket
$query = "SELECT * FROM respuesta WHERE id_ticket = '$id_ticket' ORDER BY fecha_asignacion DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "No hay respuesta disponible para este ticket.";
} else {
    $respuesta = mysqli_fetch_assoc($result);
    ?>
    <h3>Respuesta del Programador</h3>
    <p><strong>Estado: </strong><?= htmlspecialchars($respuesta['estado']) ?></p>
    <p><strong>Respuesta: </strong><?= nl2br(htmlspecialchars($respuesta['respuesta'])) ?></p>
    <?php
}

$conn->close();
?>
