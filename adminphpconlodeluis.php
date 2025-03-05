<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Acceso denegado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PJM</title>
    <link rel="stylesheet" href="phpconlodeluis.css">
</head>
<body>
    <?php
    if(isset($_POST['nombre']) && isset($_POST['autor']) && isset($_POST['categoria']) && isset($_POST['url']) && isset($_POST['valoracion'])){
        $nombre = $_POST["nombre"];
        $autor = $_POST["autor"];
        $cat = $_POST['categoria'];
        $url = $_POST['url'];
        $valor = $_POST['valoracion'];
        
        $conexion = mysqli_connect("localhost", "root", "", "pjm") or
        die("Problemas con la conexión");
    
        $imagen = file_get_contents($url);
        $nombrefile = str_replace(' ', '', $nombre);
        file_put_contents('imagenes/'.$nombrefile.'.jpg', $imagen);
        $url = 'imagenes/'.$nombrefile.'.jpg';
        
        $sql = "INSERT INTO damelo (nombre, autor, categoria, valoracion, url) VALUES ('$nombre', '$autor', '$cat', $valor, '$url')";
        if (mysqli_query($conexion, $sql)) {
            echo "Añadido correctamente";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    }
    ?>
<form action="adminphpconlodeluis.php" method="post" name="pjm" target="_self">
<table align="center" cellpadding="1" cellspacing="1" style="width:50%;">
    <thead>
        <tr>
            <th colspan="2" scope="col">Formulario</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nombre</td>
            <td><input name="nombre" size="30" type="text"  /></td>
        </tr>
        <tr>
            <td>Autor</td>
            <td><input name="autor" size="30" type="text" /></td>
        </tr>
        <tr>
            <td>Categoría</td>
            <td>
                <select name="categoria" >
                    <option selected value="">Seleccionar</option>
                    <option value="videojuegos">Videojuegos</option>
                    <option value="musica">Música</option>
                    <option value="peliculas">Películas</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Valoración</td>
            <td>
                <select name="valoracion" >
                    <option selected value="">Seleccionar</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Imagen (URL)</td>
            <td><input name="url" size="90" type="text"  /></td>
        </tr>
        <tr>
            <td colspan="2">
                <input name="enviar" type="submit" value="Subir" />
                <input name="borrar" type="reset" value="Limpiar" />
                <button><a href="PJM.php" style="text-decoration: none; color: black;">PRINCIPAL</a></button>
            </td>
        </tr>
    </tbody>
</table>
</form>
</body>
</html>
