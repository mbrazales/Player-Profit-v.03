<?php
// Incluyo funciones creadas para la conexión a la BD y el CRUD
include 'funciones.php';

// Iniciamos la sesión de usuario
session_start();

// Verifica si las variables de las sesiones están establecidas. Si no está definida, se le asigna el valor null para asegurarse de que la variable exista y esté inicializada.
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = null;
}
if (!isset($_SESSION['pass'])) {
    $_SESSION['pass'] = null;
}
if (!isset($_SESSION['nombre_usuario'])) {
    $_SESSION['nombre_usuario'] = null;
}
if (!isset($_SESSION['idPermisos'])) {
    $_SESSION['idPermisos'] = null;
}


// Lógica para iniciar sesión, por ejemplo, después de que el usuario haya ingresado las credenciales correctamente.
$_SESSION['loggedin'] = true;

?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" type="text/css" href="CSS/styles_login.css">
    <title>Player Profit -Login-</title>
</head>


<body>
    <div class="login">
        <form method="post">
            <h2>Hola!<br><span>Inicia sesión</span></h2>
                <div class="inputbox">
                    <input type="text" placeholder="Username" name="nombre_usuario" required pattern="^[a-zA-Z._%+-]+@[a-zA-Z.-]+\.[a-zA-Z]$">
                    <i class="fa-regular fa-user"></i>
                </div>

                <div class="inputbox">
                    <input type="email" placeholder="Email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    <i class="fa-regular fa-envelope"></i>
                </div>

                <div class="inputbox">
                    <input type="password" placeholder="Password" name="pass" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$>">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div class="inputbox">
                    <select name="idPermisos" id="rol" required>
                        <option value="">Selecciona tu rol</option>
                        <option value="1">ADMINISTRADOR</option>
                        <option value="2">USUARIO</option>
                        <!-- Agrega más opciones según sea necesario -->
                    </select>
                </div>

                <div class="inputbox">
                    <input type="submit" name="enviar" value="INICIAR">
                </div>
        </form>
        <h4>O puedes ser auténtico</h4>
        <div class="huella">
            <div class="huellacaja">
                
            </div>
            <p>Iniciar con huella</p>
        </div>
        <div class="huella">
                <p id="registro"><a href="Vistas/Vista_Registro.php" style="text-decoration: none;">No estoy registrado</a></p>
            </div>
        <div class="error">
            <?php
            // Si se han producido errores durante el inicio de sesión, imprime los mensajes de error.
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
                if (!empty($email) && !empty($pass)) {
                    if (!$datos_validos) {
                        echo '<p>¡El usuario o la contraseña no son válidos!</p>';
                    }
                } else {
                    echo '<p>Por favor rellena los campos correctamente</p>';
                }
            }
            ?>
        </div>
    </div>

</body>

</html>

<?php

//establecemos la conexion
$conexion = conexion();

//Si se ha enviado el formulario y he recibido los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Verifica si se ha enviado un formulario mediante el método POST y si existe un campo llamado 'submit'
    if (isset($_POST['enviar'])) {

        //Si se cumple esta condición, el código continúa obteniendo los valores enviados a través del formulario para las variables $email, $pass y $nombre_usuario.
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $nombre_usuario = $_POST['nombre_usuario'];
        $idPermisos = $_POST['idPermisos'];

        //Valido si los campos de email y password están vacíos
        if (!empty($email) && !empty($pass)) {

            //Busco el usuario y el hash asociado a su contraseña
            $hash_BD = buscar_usuario_hash($conexion, $email);

            //Compruebo que la contraseña introducida coincide con el hash asignado
            $datos_validos = coincidenContrasenias($pass, $hash_BD);

            if ($datos_validos) {

                //Si existe, asigno el email y la contraseña como datos de sesión
                //Y la página redirige a la aplicación index.php

                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['idPermisos'] = $idPermisos;

                header('location:index.php');
            } else {
                //De lo contrario, lanzo un mensaje de error

                
            }
        } else if (empty($email) && empty($pass)) {
            
        }
    }
}
//Cierro la conexión a la BD
$conexion = null;
?>
