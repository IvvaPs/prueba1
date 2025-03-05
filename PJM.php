<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "pjm") 
    or die("Problemas con la conexión");

// Definimos la categoría seleccionada a través de POST, con un valor predeterminado de 'TODOS'
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : 'TODOS';

// Definimos el criterio de ordenación (valoración por defecto)
$orden = isset($_POST['orden']) ? $_POST['orden'] : 'valoracion';

// Sanitizamos la entrada para prevenir inyecciones SQL
$categoria = mysqli_real_escape_string($conexion, $categoria);
$orden = mysqli_real_escape_string($conexion, $orden);

// Creamos la consulta SQL sin incluir el ID
$query = "SELECT NOMBRE, VALORACION, CATEGORIA, AUTOR, url FROM damelo";

// Si la categoría no es "TODOS", agregamos el filtro por categoría a la consulta SQL
if ($categoria !== "TODOS") {
    $query .= " WHERE CATEGORIA = '$categoria'";
}

// Añadir orden a la consulta SQL
if ($orden == 'valoracion') {
    $query .= " ORDER BY VALORACION DESC";  // Ordenar por valoración de mayor a menor
} elseif ($orden == 'nombre_asc') {
    $query .= " ORDER BY NOMBRE ASC";  // Ordenar por nombre de la A a la Z
} elseif ($orden == 'nombre_desc') {
    $query .= " ORDER BY NOMBRE DESC";  // Ordenar por nombre de la Z a la A
}

// Ejecutamos la consulta SQL
$registros = mysqli_query($conexion, $query) or die("Problemas en el select: " . mysqli_error($conexion));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta PHP</title>
    <link rel="stylesheet" href="principal.css">
</head>
<body>
    
    <form action="" method="post">
        <table border="1" style="width:600px;">
            <tbody>
                <tr>
                    <td><input type="submit" name="categoria" value="TODOS"></td>
                    <td><input type="submit" name="categoria" value="MUSICA"></td>
                    <td><input type="submit" name="categoria" value="PELICULAS"></td>
                    <td><input type="submit" name="categoria" value="VIDEOJUEGOS"></td>
                    <td>
                        <a href="login.php" class="button-link">Inicio de sesión</a>
                        <td>
                        <a href="adminphpconlodeluis.php" class="button-link">Formulario</a>
                    </td>
                    <td>
                        <a href="logout.php" class="button-link">Cerrar sesión</a>
                    </td>
                <tr>
                    <td colspan="7">
                        <label for="orden">Ordenar por:</label>
                        <select name="orden" id="orden">
                            <option value="valoracion" <?= $orden == 'valoracion' ? 'selected' : '' ?>>Valoración</option>
                            <option value="nombre_asc" <?= $orden == 'nombre_asc' ? 'selected' : '' ?>>Nombre A-Z</option>
                            <option value="nombre_desc" <?= $orden == 'nombre_desc' ? 'selected' : '' ?>>Nombre Z-A</option>
                        </select>
                        <input type="submit" value="Ordenar">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <table border="1" cellpadding="5" cellspacing="1" style="width:600px;">
        <thead>
            <tr>
                <th>NOMBRE</th>
                <th>AUTOR</th>
                <th>VALORACIÓN</th>
                <th>CATEGORÍA</th>
                <th>IMAGEN</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar cada registro en una fila de la tabla
            while ($reg = mysqli_fetch_array($registros)) {
                $imagenUrl = htmlspecialchars($reg['url']);
                echo "<tr>";
                echo "<td>" . htmlspecialchars($reg['NOMBRE']) . "</td>";
                echo "<td>" . htmlspecialchars($reg['AUTOR']) . "</td>";
                echo "<td>" . htmlspecialchars($reg['VALORACION']) . "</td>";
                echo "<td>" . htmlspecialchars($reg['CATEGORIA']) . "</td>";
                echo "<td>";
                if (!empty($imagenUrl)) {
                    echo "<img src='$imagenUrl' width='100' height='100'>";
                } else {
                    echo "URL no válida";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    mysqli_close($conexion);
    ?>
</body>
</html>
