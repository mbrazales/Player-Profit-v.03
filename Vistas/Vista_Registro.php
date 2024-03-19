<?php

// Incluyo funciones creadas para la conexión a la BD y el CRUD
include '../funciones.php';

// Iniciamos la sesión de usuario
session_start();

// Establecemos la conexión utilizando la función conexion
$conexion = conexion();

// Verifica si las variables de las sesiones están establecidas. Si no está definida, se le asigna el valor null para asegurarse de que la variable exista y esté inicializada, posiblemente con solo validar una de ellas sería suficiente pero en este caso he puesto las 3.
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = null;
}
if (!isset($_SESSION['pass'])) {
    $_SESSION['pass'] = null;
}
if (!isset($_SESSION['nombre_usuario'])) {
    $_SESSION['nombre_usuario'] = null;
}

// Esto declara una variable llamada $error_pass y le asigna una cadena de texto como valor.
$error_pass = '<div> 
<p>La contraseña debe cumplir con los siguientes criterios:</p>
<p>- Debe contener una combinación de letras y números.</p>
<p>- Debe incluir al menos una letra mayúscula.</p>
<p>- Debe tener entre 4 y 10 caracteres de longitud.</p>
<p>- Debe contener al menos un carácter especial como () o ,. ¡Aporrea ese teclado! XD</p>
</div>';

?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" type="text/css" href="../CSS/styles_login.css">
    <title>Player Profit - Registro -</title>
</head>


<body>

    <div class="login">
        <form method='POST' readonly id="cajaFormulario">
            <h2>Hola!<br><span>REGISTRARTE</span></h2>

            <!-- Utilizamos el método required para que sean obligatorios los campos-->
            <div class="inputbox">
                <input type="text" placeholder="Username" name="nombre_usuario" required pattern="^[a-zA-Z._%+-]+@[a-zA-Z.-]+\.[a-zA-Z]$">
                <i class="fa-regular fa-user"></i>
            </div>

            <div class="inputbox">
                <input type="email"  placeholder="Email" name="email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$>">
                <i class="fa-regular fa-envelope"></i>
            </div>

            <div class="inputbox">
                <input type="password" placeholder="Password" name="pass1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$>">
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="inputbox">
                <input type="password" placeholder="Repeat password" name="pass2"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$>">
                <i class="fa-solid fa-repeat"></i>
            </div>

            <div class="inputbox">
                <input type="submit" name="enviar" value="REGISTRARSE">
            </div>
            <br>
            <div class="huella">
                <p id="registro"><a href="../login.php" style="text-decoration: none;">Ya estoy registrado</a></p>
            </div>

            <!-- Enlace que lleva a la página de login.php para usuarios ya registrados-->
            
        </form>

        <!-- Aquí se muestra el mensaje de error -->
        <div class="error">
            <?php
            // Compruebo si se ha enviado el formulario por POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Verifica si se ha enviado un formulario mediante el método POST y si existe un campo llamado 'enviar'
                if (isset($_POST['enviar'])) {
                    // Si se cumple esta condición, el código continúa obteniendo los valores enviados a través del formulario para las variables $email, $pass1 y $pass2.
                    $email = $_POST['email'];
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];
                    $nombreUsuario = $_POST['nombre_usuario'];
                    
                    // Compruebo en PHP si el email se ha enviado y si es válido
                    if (empty($email)) {
                        echo 'Debes introducir un email.';
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo 'Debes introducir un email correcto';
                    } else {
                        $existe_usuario = buscar_usuario($conexion, $email);
                        if ($existe_usuario) {
                            echo "Ya existe un usuario con el email " . $email;
                        } else {
                            if (!empty($pass1) && !empty($pass2)) {
                                $contrasenia_valida = validar_contrasenia($pass1);
                                $contrasenias_iguales = comparar_contrasenias($pass1, $pass2);
                                if ($contrasenia_valida && $contrasenias_iguales) {
                                    $hash_contrasenia = hashContrasenia($pass1);
                                    crear_usuario($conexion, $email, $hash_contrasenia, $nombreUsuario);
                                    $_SESSION['email'] = $email;
                                    $_SESSION['pass'] = $hash_contrasenia;
                                    $_SESSION['nombre_usuario'] = $nombreUsuario;
                                    header('location:../index.php');
                                } elseif (!$contrasenia_valida) {
                                    echo $error_pass;
                                } elseif (!$contrasenias_iguales) {
                                    echo 'Las contraseñas deben coincidir';
                                }
                            } else {
                                echo "Debes introducir una contraseña";
                            }
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
    
</body>

</html>

<?php
// Cierro la conexión a la BD
$conexion = null;
?>
