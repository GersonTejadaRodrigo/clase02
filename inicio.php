<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

function cerrar_sesion() {
    session_unset(); 
    session_destroy(); 
    header("Location: index.php");  
    exit();
}

if (isset($_POST['cerrar_sesion'])) {
    cerrar_sesion();
}

$sql = "SELECT usuarios.id, usuarios.usuario, datos.nombre, datos.curso, datos.correo FROM usuarios JOIN datos ON usuarios.id = datos.usuario_id";
$result = $conn->query($sql);

$usuarios = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $usuarios[] = array(
            'id' => $row["id"],
            'usuario' => $row["usuario"],
            'nombre' => $row["nombre"],
            'curso' => $row["curso"],
            'correo' => $row["correo"]
        );
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="estilosinicio.css">
    <link rel="stylesheet" href="estilosmodaleditar.css">
</head>
<body>
    <div class="contenedor-botones">
        <!-- Botón para abrir el modal de nuevo usuario -->
        <button class="boton-principal" onclick="document.getElementById('modalUsuario').style.display='block'">Nuevo Usuario</button>
        <button class="boton-principal">Exportar a PDF</button>
        <button class="boton-principal">Exportar a Excel</button>
        <form action="" method="post">
            <button type="submit" name="cerrar_sesion" class="boton-principal">Cerrar Sesión</button>
        </form>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Curso</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['curso']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td class="acciones">
                            <!-- Botón para abrir el modal de edición -->
                            <button class="editar" onclick="editarUsuario(<?php echo $usuario['id']; ?>)">Editar</button>
                            <button onclick="eliminarUsuario(<?php echo $usuario['id']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Modal de nuevo usuario -->
    <div id="modalUsuario" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="document.getElementById('modalUsuario').style.display='none'">&times;</span>
            <h2>Nuevo Usuario</h2>
            <!-- Aquí debes incluir el contenido del formulario para agregar un nuevo usuario -->
            <!-- Puedes crear un archivo modalusuario.php y cargarlo aquí -->
            <?php include 'modalusuario.php'; ?>
        </div>
    </div>

    <!-- Modal de edición de usuario -->
    <div id="modalEditar" class="modal">
        <div class="modal-contenido" id="contenidoEditar">
            <!-- El contenido de este modal será cargado dinámicamente mediante JavaScript -->
        </div>
    </div>

    <script>
        // Función para cargar dinámicamente el contenido del modal de edición
        function editarUsuario(id) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("contenidoEditar").innerHTML = this.responseText;
                    document.getElementById('modalEditar').style.display = 'block';
                }
            };
            xhttp.open("GET", "modaleditar.php?id=" + id, true);
            xhttp.send();
        }

        // Función para eliminar un usuario
        function eliminarUsuario(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Recargar la página después de eliminar el usuario
                        window.location.reload();
                    }
                };
                xhttp.open("POST", "eliminar_usuario.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id=" + id);
            }
        }

        // Cerrar el modal de edición al hacer clic en cualquier lugar fuera del modal
        window.onclick = function(event) {
            var modalUsuario = document.getElementById('modalUsuario');
            var modalEditar = document.getElementById('modalEditar');
            if (event.target == modalUsuario) {
                modalUsuario.style.display = "none";
            }
            if (event.target == modalEditar) {
                modalEditar.style.display = "none";
            }
        }
    </script>
</body>
</html>
