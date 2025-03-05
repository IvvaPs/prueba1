
<?php
session_start();

// CONEXIÓN A LA BASE DE DATOS
$conexion = mysqli_connect("localhost", "root", "", "pjm") 
    or die("Problemas con la conexión");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // CONSULTAR USUARIO EN LA BD
    $registros = mysqli_query($conexion, 
        "SELECT * FROM usuarios WHERE username = '$username'")
        or die("Problemas en el select: " . mysqli_error($conexion));
    if ($reg = mysqli_fetch_array($registros)) {
        echo $reg['password'];
        if ($password == $reg['password']) {
           
            $_SESSION['username'] = $username;
            // GENERAR UN TOKEN ÚNICO
            $token = bin2hex(random_bytes(32));
            mysqli_query($conexion, 
                "UPDATE usuarios SET token = '$token' WHERE id = " . $reg['id'])
                or die("Problemas en el update: " . mysqli_error($conexion));

            // GUARDAR EL TOKEN EN UNA COOKIE SEGURA (30 días)
            setcookie("user_token", $token, time() + (86400 * 30), "/", "", true, true);

            header("Location: adminphpconlodeluis.php");
            exit();
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    }    
        
   
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="login.php" method="POST">
        <table>
            <tr>
                <td><label for="username">Usuario:</label></td>
                <td><input type="text" id="username" name="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Contraseña:</label></td>
                <td><input type="password" id="password" name="password" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit">Ingresar</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
