<?php
session_start();
include('conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    die("No se ha iniciado sesión. Acceso no autorizado.");
}

// Verificar conexión a la base de datos
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Asegurar entrada limpia y evitar inyección SQL
    $titulo = $conn->real_escape_string(trim($_POST['titulo']));
    $fecha_asignacion = $conn->real_escape_string(trim($_POST['fecha_asignacion']));
    $fecha_finalizacion = $conn->real_escape_string(trim($_POST['fecha_finalizacion']));
    $descripcion = $conn->real_escape_string(trim($_POST['descripcion']));
    $paleta_colores = $conn->real_escape_string(trim($_POST['paleta_colores']));
    $esquema_diseño = $conn->real_escape_string(trim($_POST['esquema_diseño']));
    $prioridad = $conn->real_escape_string(trim($_POST['prioridad']));
    $comentarios_adicionales = $conn->real_escape_string(trim($_POST['comentarios_adicionales']));
    $id_usuario = $_SESSION['id_usuario'];

    $sql = "INSERT INTO tickets (titulo, fecha_asignacion, fecha_finalizacion, descripcion,  paleta_colores, esquema_diseño, prioridad, comentarios_adicionales, id_usuario)
            VALUES ('$titulo', '$fecha_asignacion', '$fecha_finalizacion', '$descripcion', '$paleta_colores', '$esquema_diseño', '$prioridad', '$comentarios_adicionales', '$id_usuario')";

    if ($conn->query($sql) === TRUE) {
        $id_ticket = $conn->insert_id;

        $query_programador = "
            SELECT u.id_usuario
            FROM usuarios u
            LEFT JOIN tickets t ON u.id_usuario = t.id_programador
            WHERE u.rol = 'programador'
            GROUP BY u.id_usuario
            ORDER BY COUNT(t.id_ticket) ASC
            LIMIT 1
        ";
        
        $result = $conn->query($query_programador);
        if ($result && $result->num_rows > 0) {
            $programador = $result->fetch_assoc();
            $id_programador = $programador['id_usuario'];

            $sql_asignar = "UPDATE tickets SET id_programador = $id_programador WHERE id_ticket = $id_ticket";
            $conn->query($sql_asignar);
        }

        echo "
        <div style='
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            background-color: #ffe4e1; 
            font-family: Arial, sans-serif;'>
            <h1 style='color: #ff69b4; '>¡Ticket cargado exitosamente!</h1>
            <form action='principal.php' method='get' style='margin-top: 20px;'>
                <button type='submit' style='
                    background-color: #ff69b4; 
                    color: white; 
                    padding: 10px 20px; 
                    border: none; 
                    border-radius: 5px; 
                    font-size: 1rem; 
                    cursor: pointer; 
                    transition: background-color 0.3s;'>
                    Volver
                </button>
            </form>
        </div>
        ";
        exit();
    } else {
        echo "Error al guardar el ticket: " . $conn->error;
    }
}

$conn->close();
