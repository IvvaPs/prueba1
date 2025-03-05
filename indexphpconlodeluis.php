<!DOCTYPE html>
<html lang="sp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PJM</title>
</head>
<body>
	<?php
	
        //CONEXIÓN
        $conexion = mysqli_connect("localhost", "root", "", "pjm") or
        die("Problemas con la conexión");
		//CONSULTAR
		$registros = mysqli_query($conexion, "SELECT Nombre, Categoria, Valoracion, url FROM pjm;") or
		die("Problemas en el select:" . mysqli_error($conexion));
		while ($reg = mysqli_fetch_array($registros)) {
			echo $reg['Nombre'] . "</br>";
			echo $reg['Categoria'] . "</br>";
			echo $reg['Valoracion'] . "</br>";
			echo "<img src='".$reg['url']."' width='120px'</>";
			echo "</br>";
		}
	?>

</body>
</html>