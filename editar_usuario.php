<?php
// Este archivo se encarga de procesar la edición de usuarios

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han recibido todos los datos necesarios
    if (isset($_POST['id'], $_POST['usuario'], $_POST['contrasena'], $_POST['nombre'], $_POST['curso'], $_POST['correo'])) {
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        $contrasena = md5($_POST['contrasena']); // Aplicar MD5 a la nueva contraseña
        $nombre = $_POST['nombre'];
        $curso = $_POST['curso'];
        $correo = $_POST['correo'];

        // Actualizar los datos del usuario en la tabla 'usuarios'
        $sql_usuario = "UPDATE usuarios SET usuario='$usuario', contrasena='$contrasena' WHERE id=$id";
        if ($conn->query($sql_usuario) === TRUE) {
            // Actualizar los datos del usuario en la tabla 'datos'
            $sql_datos = "UPDATE datos SET nombre='$nombre', curso='$curso', correo='$correo' WHERE usuario_id=$id";
            if ($conn->query($sql_datos) === TRUE) {
                // Redirigir a la página de inicio
                header("Location: inicio.php");
                exit();
            } else {
                echo "Error al actualizar los datos del usuario en la tabla 'datos': " . $conn->error;
            }
        } else {
            echo "Error al actualizar el usuario en la tabla 'usuarios': " . $conn->error;
        }
    } else {
        echo "Por favor, proporcione todos los datos necesarios.";
    }
}
?>
