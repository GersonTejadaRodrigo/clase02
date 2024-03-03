<?php
// Este archivo se encarga de procesar la edición de usuarios

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han recibido todos los datos necesarios
    if (isset($_POST['id'], $_POST['usuario'], $_POST['nombre'], $_POST['curso'], $_POST['correo'])) {
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $curso = $_POST['curso'];
        $correo = $_POST['correo'];

        // Actualizar los datos del usuario en la base de datos
        $sql = "UPDATE usuarios SET usuario='$usuario' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $sql = "UPDATE datos SET nombre='$nombre', curso='$curso', correo='$correo' WHERE usuario_id=$id";
            if ($conn->query($sql) === TRUE) {
                // Redirigir a la página de inicio
                header("Location: inicio.php");
                exit();
            } else {
                echo "Error al actualizar los datos del usuario en la tabla 'datos': " . $conn->error;
            }
        } else {
            echo "Error al actualizar el nombre de usuario en la tabla 'usuarios': " . $conn->error;
        }
    } else {
        echo "Por favor, proporcione todos los datos necesarios.";
    }
}
?>
