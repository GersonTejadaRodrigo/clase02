--1. Mostrar los usuarios inactivos
SELECT * FROM usuario WHERE user_activo = 0;

--2. Mostrar la cantidad usuarios.
SELECT COUNT(*) AS cantidad_usuarios FROM usuario;

--3. Mostrar todas las columnas de la tabla usuario y la tabla grupo usuario
SELECT us.*, gu.* 
FROM usuario us
INNER JOIN usuario_grupo gu ON us.id_grupo_usu = gu.id;

--4. Mostrar la tabla grupo usuario y otra columna que me diga cantidad de usuario por cada grupo. (Opcional)
SELECT ug.*, 
    (SELECT COUNT(*) FROM usuario WHERE id_grupo_usu = ug.id) AS cantidad_usuarios
FROM usuario_grupo ug;
