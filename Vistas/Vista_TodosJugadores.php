<?php 
    include '../Layout/header.php'; 

    // Incluir el archivo de conexión a la base de datos
    include '../Config/conexionPDO.php';

    // Definir una consulta SQL base para obtener todos los jugadores
    $sql = "SELECT * FROM jugadores";

    // Inicializar el arreglo de parámetros para la consulta preparada
    $params = array();

    // Verificar si se ha enviado un término de búsqueda por nombre
    if(isset($_GET["nombre"]) && !empty($_GET["nombre"])) {
        $sql .= " WHERE nombre LIKE ?";
        $params[] = "%" . $_GET["nombre"] . "%"; // Agregar el término de búsqueda al arreglo de parámetros
    }

    // Verificar si se ha enviado un término de búsqueda por equipo
    if(isset($_GET["equipo"]) && !empty($_GET["equipo"])) {
        if(empty($params)) {
            $sql .= " WHERE";
        } else {
            $sql .= " AND";
        }
        $sql .= " equipo LIKE ?";
        $params[] = "%" . $_GET["equipo"] . "%"; // Agregar el término de búsqueda al arreglo de parámetros
    }

    // Verificar si se ha enviado un término de búsqueda por precio mínimo
    if(isset($_GET["precio_min"]) && !empty($_GET["precio_min"])) {
        $precio_min = intval($_GET["precio_min"]);
        if(empty($params)) {
            $sql .= " WHERE";
        } else {
            $sql .= " AND";
        }
        $sql .= " valor >= ?";
        $params[] = $precio_min; // Agregar el término de búsqueda al arreglo de parámetros
    }

    // Verificar si se ha enviado un término de búsqueda por precio máximo
    if(isset($_GET["precio_max"]) && !empty($_GET["precio_max"])) {
        $precio_max = intval($_GET["precio_max"]);
        if(empty($params)) {
            $sql .= " WHERE";
        } else {
            $sql .= " AND";
        }
        $sql .= " valor <= ?";
        $params[] = $precio_max; // Agregar el término de búsqueda al arreglo de parámetros
    }

    // Preparar la consulta SQL con la concatenación dinámica de condiciones
    $stmt = $miPDO->prepare($sql);

    // Ejecutar la consulta preparada con los parámetros correspondientes
    $stmt->execute($params);

    // Obtener los resultados de la consulta
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="es">

<head>

    <title>Buscar Jugadores</title>

    <!-- CSS personalizado -->
    <style>

        .buscador {
            margin: auto;
        }

        @media (min-width: 1400px) {
            .container {
                max-width: 1020px;
            }
        }

        @media (max-width: 1400px) {
            .container {
                max-width: 800px; /* Cambiar el ancho máximo del contenedor */
            }
        }
    </style>
</head>
<!--Header-->
<!--Header-->
<header class="sticky-top colorfondo" style="background-color: #07031b;">

    <!-- Inicio del menu -->

    <nav class="navbar navbar-expand-md">
        <div class="container-fluid">
            <!-- icono-->

            <a class="navbar-brand greeen" href="../index.php">
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
                        <a class="nav-link  text-decoration-none" aria-current="page" href="../index.php">HOME</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="../Vistas/Vista_TodosJugadores.php">JUGADORES</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../Vistas/Vista_Favoritos.php">FAVORITOS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../Vistas/Vista_Galeria.php">ESPECIALES</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../Vistas/Vista_ObrasMaestras.php">VIDEOS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../Vistas/Vista_Gestion.php">GESTIÓN</a>
                    </li>
                    
                </ul>


                <!-- enlaces redes sociales PARA UN FUTURO Y SEGUIR ESCALANDO EN EL PROYECTO-->

                <ul class="navbar-nav  flex-row flex-wrap">
                
                    <li class="nav-item dropstart">
                        <a class="nav-link dropdown-toggle" style="font-size: 1.2rem;" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo '<div><p> ' . $nombreUsuario . '</p></div>'; ?>
                        </a>
                        <ul class="dropdown-menu transparent-bg">
                            <form method="post">
                                <input type="submit" name="logout" value="CERRAR SESIÓN" class="btn btn-outline-success">
                            </form>
                        </ul>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3 position-relative">
                        <a class="nav-link" href="../Vistas/Vista_carro.php">
                            <i class="bi bi-person" style="font-size: 2rem;"></i> <!-- Ajusta el tamaño del icono aquí -->
                            <small class="d-md-none ms-2"></small>
                        </a>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3 position-relative">
                        <a class="nav-link" href="../Vistas/Vista_carro.php">
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

<div class="container buscador" align="center">
    <hr>
    <h4 align="center">BUSCADOR DE JUGADORES</h4>
    <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="nombre" class="form-label">NOMBRE</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
        </div>
        <div class="col-md-4">
            <label for="equipo" class="form-label">EQUIPO</label>
            <input type="text" class="form-control" id="equipo" name="equipo" placeholder="Equipo">
        </div>
        <div class="col-md-2">
            <label for="precio_min" class="form-label">PRECIO MÍNIMO</label>
            <input type="number" class="form-control" id="precio_min" name="precio_min" placeholder="Mínimo">
        </div>
        <div class="col-md-2">
            <label for="precio_max" class="form-label">PRECIO MÁXIMO</label>
            <input type="number" class="form-control" id="precio_max" name="precio_max" placeholder="Máximo">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">BUSCAR</button>
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="btn btn-secondary">LIMPIAR</a>
        </div>
    </form>
</div>

<div align="center" class="container mt-3">
    <hr>
    <h2 align="center">JUGADORES</h2>
    <hr>
    <div class="row row-cols-2 row-cols-md-4 g-4">
        <?php foreach ($jugadores as $jugador) : ?>
            <div class="col">
                <div class="card h-100" style='border:5px solid #0000; background-color:rgb(226, 255, 192); border-radius:30px; margin-bottom: -30px; margin-top: 10px; text-align:center;'>
                    <img src="data:image/jpg;base64,<?php echo base64_encode($jugador['imagen']); ?>" class="card-img-top" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title text-info"><?php echo $jugador['nombre']; ?></h5>
                        <p class="card-text text-dark"><?php echo $jugador['equipo']; ?></p>
                        <p class="card-text text-success mb-2"><?php echo $jugador['valor']; ?><img src="../IMG/moneda.png" alt="imagen moneda" style="width: 35px;"></p>
                        
                        <!-- Enlace para añadir a favoritos -->
                        <a href="../Controladores/Controlador_Favoritos.php?id=<?php echo $jugador['id']; ?>" class="btn btn-info">Añadir al Carro</a>
                        
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
