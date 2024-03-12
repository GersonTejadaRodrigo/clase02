<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql_delete_datos = "DELETE FROM datos WHERE usuario_id = $id";
    if ($conn->query($sql_delete_datos) === TRUE) {
        $sql_delete_usuario = "DELETE FROM usuarios WHERE id = $id";
        if ($conn->query($sql_delete_usuario) === TRUE) {
            echo "Usuario eliminado correctamente.";
        } else {
            echo "Error al eliminar usuario: " . $conn->error;
        }
    } else {
        echo "Error al eliminar datos de usuario: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID de usuario no especificado.";
}
?>
