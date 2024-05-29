
<?php

// Session_start() para el inicio de sesión, de lo contrario si no lo hizo se le envia a la página de Vista_Registro.php, aquí nadie se cuela jajajaja.

session_start();

include "Config/conexion.php";

if (!empty($_SESSION['email']) && !empty($_SESSION['pass']) && isset($_SESSION['nombre_usuario']) && isset($_SESSION['idPermisos'])) {
    $nombreUsuario = $_SESSION['nombre_usuario'];
    $email = $_SESSION['email'];
    $idPermisos = $_SESSION['idPermisos']; 
} else {
    // Si no hay sesión activa o falta algún dato necesario en la sesión,
    // muestra un mensaje de error
    echo '<div><p>¡Bienvenido!, pero tenemos un error en algún lado</p></div>';
    // Luego, redirige a la página de inicio de sesión
    header('location: login.php');
    exit(); // Asegura que el script termine después de redirigir
}

// Después de esto, puedes seguir con el resto de tu lógica, como verificar si el usuario ha iniciado sesión
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // El usuario ha iniciado sesión
    //echo 'El usuario ha iniciado sesión.';
} else {
    // El usuario no ha iniciado sesión
    echo 'El usuario no ha iniciado sesión.';
}






//Si se envía el formulario de cerrar sesión de usuario
//Se destruye la sesión y se redirige a la página de login.php

// Cierre de sesión y eliminación de la cookie de favoritos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        // Eliminar la cookie de jugadores favoritos
        setcookie('favoritos', '', time() - 3600, '/'); // Caducar la cookie

        // Mensaje de depuración (Realmente este mensaje nunca lo veo, en un futuro cuando aprenda hacer ventanas emergentes o algo parecido
        // daré más información a los usuarios de mi aplicación.)
        echo "Cookie 'favoritos' eliminada.";

        session_destroy();
        header('location: login.php');
        exit();
    }
}

?>

<!--*******************************************************************-->

<!doctype html>
<html lang="es">
<!--Head con enlaces a CSS, BOOTSTRAP Y JAVASCRIPT  -->

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="CSS/styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
</head>


<!--Header-->
<header class="sticky-top colorfondo" style="background-color: #07031b;">

    <!-- Inicio del menu -->

    <nav class="navbar navbar-expand-md">
        <div class="container-fluid">
            <!-- icono-->

            <a class="navbar-brand greeen" href="index.php">
                <i class="bi bi-suit-spade-fill">PLAYER PROFIT</i>
                
            </a>

            <!-- boton del menu -->

            <button class="navbar-toggler green" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon green"></span>
            </button>

            <!-- elementos del menu colapsable -->

            <div class="collapse navbar-collapse " style="font-size: 1.1rem;" id="menu">
                <ul class="navbar-nav mx-auto">

                    <li class="nav-item">
                        <a class="nav-link  text-decoration-none active" aria-current="page" href="../index.php">HOME</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="Vistas/Vista_TodosJugadores.php">JUGADORES</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="Vistas/Vista_Favoritos.php">CESTA</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="Vistas/Vista_Galeria.php">ESPECIALES</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="Vistas/Vista_ObrasMaestras.php">VIDEOS</a>
                    </li>

                    <?php
                        if ($idPermisos == 1) {
                        // Si $idPermisos es igual a 1, muestra el enlace
                        echo '<li class="nav-item"><a class="nav-link" href="Vistas/Vista_Gestion.php">GESTIÓN</a></li>';
                        }
                    ?>
                    
                </ul>


                <!-- enlaces redes sociales PARA UN FUTURO Y SEGUIR ESCALANDO EN EL PROYECTO-->

                <ul class="navbar-nav  flex-row flex-wrap">
                
                    <li class="nav-item dropstart">
                        <a class="nav-link dropdown-toggle" style="font-size: 1.2rem;" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo '<div><p> ' . $nombreUsuario .'</p></div>'; ?>

                        </a>
                        <ul class="dropdown-menu transparent-bg">
                            <form method="post">
                                <input type="submit" name="logout" value="CERRAR SESIÓN" class="btn btn-outline-success">
                            </form>
                        </ul>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3 position-relative">
                        <a class="nav-link active" href="Vistas/Vista_carro.php">
                            <i class="bi bi-person" style="font-size: 2rem;"></i> <!-- Ajusta el tamaño del icono aquí -->
                            <small class="d-md-none ms-2"></small>
                        </a>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3 position-relative">
                        <a class="nav-link" href="Vistas/Vista_carro.php">
                            <i class="bi bi-cart" style="font-size: 2rem;"></i> <!-- Ajusta el tamaño del icono aquí -->
                            <small class="d-md-none ms-2"></small>
                        </a>
                        <?php
                        // Verificar si el carrito está vacío
                        if (empty($_SESSION["shopping_cart"])) {
                            $cartItemCount = 0;
                        } else {
                            // Calcular la cantidad total de elementos en el carrito
                            $cartItemCount = 0;
                            foreach ($_SESSION["shopping_cart"] as $item) {
                                $cartItemCount += $item["item_quantity"];
                            }
                        }
                        ?>

                        <style>
                            .custom-badge {
                                font-size: 1rem; /* Ajusta el tamaño del número dentro del círculo */
                                top: 22px !important; /* Mueve el círculo hacia abajo */
                                left: 50px !important; /* Mueve el círculo hacia la izquierda */
                            }

                            .custom-badge .badge {
                                width: 1.3rem; /* Ajusta el tamaño del círculo */
                                height: 1.3rem; /* Ajusta el tamaño del círculo */
                                line-height: 2rem; /* Alinea verticalmente el número dentro del círculo */
                                border-radius: 50%; /* Asegura que el círculo tenga bordes redondeados */
                            }
                            /**** index fotos portada****/

.wrapperr {
    width: 100%;
    height: calc(100vh - 20px); /* Ajustado para tener en cuenta el padding */
    display: flex;
    align-items: flex-start; /* Cambiado de center a flex-start */
    justify-content: center;
    padding-top: 100px; /* Añadido para separar desde arriba */
}


.containerr {
    height: 400px;
    display: flex;
    flex-wrap: nowrap;
    justify-content: start;
}

.cardd {
    width: 80px;
    border-radius: .75rem;
    background-size: cover;
    cursor: pointer;
    overflow: hidden;
    border-radius: 2rem;
    margin: 0 10px;
    display: flex;
    align-items: flex-end;
    transition: .6s cubic-bezier(.28,-0.03,0,.99);
    box-shadow: 0px 10px 30px -5px rgba(0,0,0,0.8);
}

.cardd > .row {
    color: white;
    display: flex;
    flex-wrap: nowrap;
}

.cardd > .row > .icon {
    background: #223;
    color: white;
    border-radius: 50%;
    width: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 15px;
}

.cardd > .row > .description {
    display: flex;
    justify-content: center;
    flex-direction: column;
    overflow: hidden;
    height: 80px;
    width: 520px;
    opacity: 0;
    transform: translateY(30px);
    transition-delay: .3s;
    transition: all .3s ease;
}

.descriptionn p {
    color: white;
    padding-top: 5px;
}

.descriptionn h4 {
    text-transform: uppercase;
}

input {
    display: none;
}

input:checked + label {
    width: 600px;
}

input:checked + label .description {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

.cardd[for="c1"] {
    background-image: url('IMG/totys.png');
}
.cardd[for="c2"] {
    background-image: url('IMG/dinero.png');
}
.cardd[for="c3"] {
    background-image: url('IMG/mercador.png');
}
.cardd[for="c4"] {
    background-image: url('IMG/rapidos.png');
}
                        </style>

                        <!-- Código HTML con el círculo rojo y el número -->
                        <?php if ($cartItemCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger custom-badge">
                                <?php echo max(1, $cartItemCount); ?>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        <?php else: ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger custom-badge">
                                0
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        <?php endif; ?>
                    </li>


                </ul>
            </div>
        </div>
    </nav>
</header>

<body>
    
    <div class="wrapperr">
        <div class="containerr">
            <input type="radio" name="slide" id="c1" checked>
            <label for="c1" class="cardd">
                <div class="row">
                    <div class="icon">1</div>
                    <div class="description">
                        <h4>JUGADORES</h4>
                        <p>Tenemos los mejores Jugadores del mercado</p>
                    </div>
                </div>
            </label>
            <input type="radio" name="slide" id="c2" >
            <label for="c2" class="cardd">
                <div class="row">
                    <div class="icon">2</div>
                    <div class="descriptionn">
                        <h4>PRECIOS</h4>
                        <p>Los Precios más competitivos del sector</p>
                    </div>
                </div>
            </label>
            <input type="radio" name="slide" id="c3" >
            <label for="c3" class="cardd">
                <div class="row">
                    <div class="icon">3</div>
                    <div class="descriptionn">
                        <h4>Sin intermediarios</h4>
                        <p>Somos vendedores directos</p>
                    </div>
                </div>
            </label>
            <input type="radio" name="slide" id="c4" >
            <label for="c4" class="cardd">
                <div class="row">
                    <div class="icon">4</div>
                    <div class="descriptionn">
                        <h4>RÁPIDOS Y FIABLES</h4>
                        <p>Operación al instante Y con la máxima transparencia</p>
                    </div>
                </div>
            </label>
        </div>
    </div>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

<footer class="colorfondo style= background-color: #07031b;">
    

        <!-- Inicio del menu -->

        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container-fluid">
                <!-- icono o nombre -->

                <a class="navbar-brand" href="index.php">
                    <i class="bi bi-suit-spade-fill"></i>
                    <span class="">@BRAZALES TEAM</span><i class="bi bi-suit-spade-fill"></i>
                </a>
                <i class="bi bi-suit-spade-fill"></i>
                <a class="navbar-brand" href="index.php">
                    <i class="cookies"></i>
                    <span class="text-success">PLAYER PROFIT</span>
                </a>



                <!-- enlaces redes sociales -->

                <ul class="navbar-nav  flex-row flex-wrap text-light">

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-twitter"></i>
                        <small class="d-md-none ms-2">Twitter</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-github"></i>
                        <small class="d-md-none ms-2">GitHub</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-whatsapp"></i>
                        <small class="d-md-none ms-2">WhatsApp</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-facebook"></i>
                        <small class="d-md-none ms-2">Facebook</small>
                    </li>

                </ul>

                <!--boton Informacion -->

                <form class="d-flex">
                    <a href="Vistas/Vista_Contacto.php">
                        <button type="button" class="btn btn-outline-info">CONTACTO</button>
                    </a>
                </form>


            </div>

            </div>
        </nav>
</footer>
</html>



