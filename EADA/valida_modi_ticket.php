<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: inicio.html"); // Redirigir si no está autenticado
    exit();
}

// Verificar si los datos han sido enviados correctamente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_ticket = $_POST['id_ticket'];
    $titulo = $_POST['titulo'];
    $fecha_asignacion = $_POST['fecha_asignacion'];
    $fecha_finalizacion = $_POST['fecha_finalizacion'];
    $descripcion = $_POST['descripcion'];
    $prioridad = $_POST['prioridad'];
    $estado = $_POST['estado'];
    $paleta_colores = $_POST['paleta_colores'];
    $esquema_diseño = $_POST['esquema_diseño'];
    $comentarios_adicionales = $_POST['comentarios_adicionales'];

    include('conexion.php');

    // Actualizar los datos en la base de datos
    $sql = "UPDATE tickets 
            SET titulo = ?, fecha_asignacion = ?, fecha_finalizacion = ?,  descripcion = ?, prioridad = ?,  estado = ?, paleta_colores = ?, esquema_diseño = ?, comentarios_adicionales = ? WHERE id_ticket = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssi", $titulo, $fecha_asignacion, $fecha_finalizacion, $descripcion, $prioridad, $estado, $paleta_colores,  $esquema_diseño, $comentarios_adicionales, $id_ticket);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Datos actualizados correctamente.";
        } else {
            echo "No se realizaron cambios.";
        }
    $stmt->close();
    $conn->close();
    }
?>