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
<header class="bg-secondary">

    <!-- Inicio del menu -->

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- icono-->

            <a class="navbar-brand" href="../index.php">
                <i class="bi bi-suit-spade-fill"></i>
                <span class="text-success">PLAYER PROFIT</span>
            </a>

            <!-- boton del menu -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- elementos del menu colapsable -->

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav mx-auto">

                    <li class="nav-item ">
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

                <hr class="d-md-none text-white-50">

                <!-- enlaces redes sociales PARA UN FUTURO Y SEGUIR ESCALANDO EN EL PROYECTO-->

                <ul class="navbar-nav  flex-row flex-wrap text-light">
                
                    <li class="nav-item dropstart">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo '<div><p> ' . $nombreUsuario . '</p></div>'; ?>
                        </a>
                        <ul class="dropdown-menu transparent-bg">
                            <form method="post">
                                <input type="submit" name="logout" value="CERRAR SESIÓN" class="btn btn-outline-success">
                            </form>
                        </ul>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <a class="nav-link" href="../Vistas/carro.php">
                            <i class="bi bi-person"></i>
                            <small class="d-md-none ms-2">Carro</small>
                        </a>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3 position-relative">
                    <a class="nav-link " href="../Vistas/Vista_carro.php">
                            <i class="bi bi-cart "></i>
                            <small class="d-md-none ms-2"></small>
                        </a>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </li>                   
                </ul>
            </div>
        </div>
    </nav>
</header>

<body>

<div class="container buscador" align="center">
    <h1>Buscar Jugadores</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
        </div>
        <div class="col-md-4">
            <label for="equipo" class="form-label">Equipo</label>
            <input type="text" class="form-control" id="equipo" name="equipo" placeholder="Equipo">
        </div>
        <div class="col-md-2">
            <label for="precio_min" class="form-label">Precio Mínimo</label>
            <input type="number" class="form-control" id="precio_min" name="precio_min" placeholder="Mínimo">
        </div>
        <div class="col-md-2">
            <label for="precio_max" class="form-label">Precio Máximo</label>
            <input type="number" class="form-control" id="precio_max" name="precio_max" placeholder="Máximo">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>
</div>



<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
