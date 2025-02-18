<?php
session_start();
if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: inicio.html"); // Redirigir si no hay sesión
    exit();
}

// Contenido de la página principal
echo "<h1 class='titulo-bienvenida'>Bienvenido/a, " . htmlspecialchars($_SESSION['nombre_usuario']) . "!</h1>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="ticket.css">
</head>
<body class="fondo-pagina">
    <h2 class="subtitulo-accion">¿Qué deseas hacer hoy?</h2>
    <h4 class="texto-secundario">Seleccione la opción que prefieras</h4>
    <form method="post" action="" class="formulario-botones">
        <button class="boton-animado" name="boton1" type="submit" formaction="pendientes.php">Revisar tickets pendientes</button>
        <button class="boton-animado" name="boton2" type="submit" formaction="ticket.html">Crear un nuevo ticket</button>
        <button class="boton-animado" name="boton3" type="submit" formaction="visualizar_respuesta.php">Ver respuestas</button>

    </form>
</body>
</html>
