<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $curso = $_POST['curso'];
    $correo = $_POST['correo'];

    // Insertar datos en la tabla "usuarios"
    $sql_insert_usuario = "INSERT INTO usuarios (usuario, contrasena, cargo) VALUES ('$usuario', '$contrasena', 'comun')";
    if ($conn->query($sql_insert_usuario) === TRUE) {
        $usuario_id = $conn->insert_id; // Obtener el ID del nuevo usuario

        // Insertar datos en la tabla "datos" con el ID del usuario insertado
        $sql_insert_datos = "INSERT INTO datos (usuario_id, nombre, curso, correo) VALUES ('$usuario_id', '$nombre', '$curso', '$correo')";
        if ($conn->query($sql_insert_datos) === TRUE) {
            echo "Nuevo usuario agregado correctamente.";
        } else {
            echo "Error: " . $sql_insert_datos . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_insert_usuario . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
