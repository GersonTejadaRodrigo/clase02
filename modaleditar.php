<?php
include 'conexion.php';

// Verificar si se ha proporcionado un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de usuario inválido.";
    exit();
}

$id = $_GET['id'];

// Obtener los datos del usuario a editar
$sql = "SELECT usuarios.id, usuarios.usuario, usuarios.contrasena, datos.nombre, datos.curso, datos.correo FROM usuarios JOIN datos ON usuarios.id = datos.usuario_id WHERE usuarios.id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
?>
    <h2>Editar Usuario</h2>
    <form action="editar_usuario.php" method="post">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo $usuario['usuario']; ?>" required>
        <label for="contrasena">Nueva Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        <label for="curso">Curso:</label>
        <input type="text" id="curso" name="curso" value="<?php echo $usuario['curso']; ?>" required>
        <label for="correo">Correo:</label>
        <input type="text" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required>
        <input type="submit" value="Guardar">
    </form>
<?php
} else {
    echo "Usuario no encontrado.";
}
?>
