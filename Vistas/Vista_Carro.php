<?php 

include '../Layout/header.php'; 

$values["item_quantity"] = 0;

$total = 0; // Inicializar el total fuera del bucle

if (!empty($_SESSION["shopping_cart"])) {
    // Iterar a través de los elementos del carrito y sumar las cantidades
    foreach ($_SESSION["shopping_cart"] as $item) {
        $values["item_quantity"] += $item["item_quantity"];

        // Sumar el subtotal de este elemento al total
        $subtotal = $item["item_quantity"] * $item["valor"];
        $total += $subtotal;
    }
}

if (!empty($_SESSION["shopping_cart"])) {
    // Iterar a través de los elementos del carrito y sumar las cantidades
    foreach ($_SESSION["shopping_cart"] as $item) {
        $values["item_quantity"] += $item["item_quantity"];
    }
}

// Manejar la lógica para agregar elementos al carrito de compras
if(isset($_POST["add_to_cart"])) {
    /*$id = $_GET["id"];*/
    $nombre = $_POST["nombre"];
    $valor = $_POST["valor"];
    $quantity = $_POST["quantity"];

    if(isset($_SESSION["shopping_cart"])) {
        // Verificar si el artículo ya está en el carrito
        $item_in_cart = false;
        foreach($_SESSION["shopping_cart"] as $key => $item) {
            if($item["nombre"] == $nombre) {
                // Si el artículo ya está en el carrito, actualizar la cantidad
                $_SESSION["shopping_cart"][$key]["item_quantity"] += $quantity;
                $item_in_cart = true;
                break;
            }
        }
        // Si el artículo no está en el carrito, agregarlo
        if(!$item_in_cart) {
            $item_array = array(
                /*'id' => $id,*/
                'nombre' => $nombre,
                'valor' => $valor,
                'item_quantity' => $quantity
            );
            $_SESSION["shopping_cart"][] = $item_array;
        }
    } else {
        // Si no hay ningún artículo en el carrito, agregar el primer artículo
        $item_array = array(
            /*'id' => $id,*/
            'nombre' => $nombre,
            'valor' => $valor,
            'item_quantity' => $quantity
        );
        $_SESSION["shopping_cart"][] = $item_array;
    }
}

// Manejar la lógica para eliminar un elemento del carrito
if(isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["index"])) {
    $index = $_GET["index"];
    // Eliminar el elemento del carrito con el índice especificado
    unset($_SESSION["shopping_cart"][$index]);
    // Redirigir de regreso a la página del carrito
    header("Location: Vista_Carro.php");
    exit; // Asegura que no haya ninguna salida adicional después de la redirección
}

// Manejar la lógica para eliminar todos los elementos del carrito
if(isset($_POST["eliminar_todo_carrito"])) {
    // Eliminar todos los elementos del carrito de compras
    unset($_SESSION["shopping_cart"]);
    // Redirigir de regreso a la página del carrito
    header("Location: Vista_Carro.php");
    exit; // Asegura que no haya ninguna salida adicional después de la redirección
}

?>


<!doctype html>
<html lang="es">

<head>
    <title>Proyecto</title>
</head>

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
                        <a class="nav-link" href="../Vistas/Vista_TodosJugadores.php">JUGADORES</a>
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
                        <a class="nav-link active" href="../Vistas/Vista_carro.php">
                            <i class="bi bi-person active" style="font-size: 2rem;"></i> <!-- Ajusta el tamaño del icono aquí -->
                            <small class="d-md-none ms-2"></small>
                        </a>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3 position-relative">
                        <a class="nav-link active" href="../Vistas/Vista_carro.php">
                            <i class="bi bi-cart active" style="font-size: 2rem;"></i> <!-- Ajusta el tamaño del icono aquí -->
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


<?php
    // Incluye el archivo de conexión a la base de datos mediante PDO
    include '../Config/conexionPDO.php';

    // Obtiene el nombre de usuario de la sesión
    $nombre_usuario = $_SESSION['nombre_usuario'];

    // Verifica si existe una lista de jugadores favoritos en la sesión o en una cookie
    if (!empty($_SESSION['favoritos'])) {

        // Si existe en la sesión, asigna los jugadores favoritos a la variable correspondiente
        $jugadores_favoritos = $_SESSION['favoritos'];

    } elseif (isset($_COOKIE['favoritos' . $nombre_usuario])) {

        // Si no existe en la sesión pero sí en una cookie, deserializa y asigna los jugadores favoritos a la variable correspondiente
        $jugadores_favoritos = unserialize($_COOKIE['favoritos' . $nombre_usuario]);
    }



// Verificar si la cookie de favoritos existe
if (isset($_COOKIE['favoritos'])) {
    $favoritos = unserialize($_COOKIE['favoritos']); // Obtener la lista de favoritos desde la cookie

    if (!empty($favoritos)) {
        try {
            $in = str_repeat('?,', count($favoritos) - 1) . '?'; // Crear una cadena de comodines para la consulta SQL
            $sql = "SELECT * FROM jugadores WHERE id IN ($in)"; // Consulta SQL para obtener los jugadores por sus IDs
            $statement = $miPDO->prepare($sql); // Preparar la consulta
            $statement->execute($favoritos); // Ejecutar la consulta con los IDs de los jugadores
            $jugadores_favoritos = $statement->fetchAll(PDO::FETCH_ASSOC); // Obtener los jugadores como un array asociativo

            if ($jugadores_favoritos) {
                echo "<div class='container'>";
                echo "<hr>";
                echo "<div class='text-center'><h4>CARRO DE LA COMPRA</h4></div>";
                echo "<hr>";
                echo "<div class='row justify-content-center'>"; // Añade la clase justify-content-center para centrar los elementos en la fila
                foreach ($jugadores_favoritos as $jugador) {

                    echo "<div class='col-md-3'>"; // Reduce el tamaño de la columna a col-md-3 para hacer la caja más pequeña

                    echo "<div style='border:5px solid #0000; background-color:rgb(226, 255, 192); border-radius:30px; padding:1px; margin-bottom: 10px; margin-top: 10px; text-align:center;'>"; // Ajusta el estilo de la caja y centra el contenido

                    echo "<img src='data:image/jpg;base64," . base64_encode($jugador['imagen']) . "' alt='' width='190' height='260' class='img-responsive' /><br />"; // Reducir el tamaño de la imagen del jugador

                    echo "<h4 class='text-danger'> " . $jugador["nombre"] . "</h4>"; // Reducir el tamaño del nombre del jugador

                    echo "<h4 class='text-success'> " . $jugador['valor'] . '<img src="../IMG/moneda.png" alt="imagen moneda" style="width: 20px;"></h4>'; // Reducir el tamaño del valor del jugador y la imagen de la moneda

                    echo "<form method='post' action=''>";
                    echo "<input type='number' name='quantity' value='1' class='form-control mt-2 mx-auto' style='max-width: 60px;' />"; // Añade la clase mx-auto para centrar horizontalmente el campo de cantidad

                    echo "<input type='hidden' name='nombre' value='" . $jugador["nombre"] . "' />";
                    echo "<input type='hidden' name='valor' value='" . $jugador["valor"] . "' />";
                    echo "<input type='submit' name='add_to_cart' style='margin-top:5px;' class='btn btn-success btn-sm mt-3' value='COMPRAR' />"; // Reducir el tamaño del botón de compra
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>"; // Cierre de la fila
                echo "</div>"; // Cierre del contenedor
            } else {
                echo "No se encontraron jugadores"; // Mensaje si no se encuentran jugadores favoritos
            }
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage(); // Manejar errores de consulta
        }
    } else {
        echo "<div class='text-center'><h6>CESTA VARIA</h6></div>"; // Mensaje si no hay jugadores marcados como favoritos
    }
} else {
    echo "<div class='text-center'><h6>CESTA VACIA</h6></div>"; // Mensaje si la cookie de favoritos no existe
}
?>
    <div style="text-align: center;">
        <form method='post' action='../Controladores/Controlador_EliminarFavoritos.php'>
            <input type='submit' name='eliminar_favoritos' value='ELIMINAR CESTA' class='btn btn-danger'>
            <a href='Vista_TodosJugadores.php' class='btn btn-warning bg-warning'>Volver</a>
        </form>
    </div>

    
    

    <!-- Aquí va el código HTML antes de la tabla de resumen de compra -->


<div class="table-responsive">
    <hr>
    <h4 class="text-center mt-4 mb-4 p-3">RESUMEN DE LA COMPRA</h4>
    <table class="table table-bordered green">
        <hr>
        <tr>
            <th width="40%" style="text-align: center;">JUGADOR</th>
            <th width="10%">CANTIDAD</th>
            <th width="20%" style="text-align: right;">PRECIO</th>
            <th width="15%" style="text-align: right;">TOTAL</th>
            <th width="5%" style="text-align: center;">ELIMINAR</th>
        </tr>

        <?php
        if(!empty($_SESSION["shopping_cart"])) {
            $total = 0;
            foreach($_SESSION["shopping_cart"] as $keys => $values) {
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $values["nombre"]; ?></td>
                    <td style="text-align: center;"><?php echo $values["item_quantity"]; ?></td>
                    <td style="text-align: right;"><?php echo $values["valor"]; ?><img src="../IMG/moneda.png" alt="imagen moneda" style="width: 25px;"> </td>
                    <td style="text-align: right;"><?php echo number_format($values["item_quantity"] * $values["valor"], 0); ?><img src="../IMG/moneda.png" alt="imagen moneda" style="width: 25px;"></td>

                    <td style="text-align: center;">
                        <a href="Vista_Carro.php?action=delete&index=<?php echo $keys; ?>">
                            <span class="btn btn-warning">ELIMINAR</span>
                        </a>
                    </td>

                    
                    
                </tr>
                <?php
                $total = $total + ($values["item_quantity"] * $values["valor"]);
                
            }
            ?>
            <tr>
                <td colspan="3" align="right">TOTAL</td>
                <td align="right"><?php echo number_format($total, 0); ?><img src="../IMG/moneda.png" alt="imagen moneda" style="width: 25px;"> </td>

                <td>
                    <form method="post" action="eliminar_todo.php"> <!-- Cambia 'action' para que apunte al archivo eliminar_todo.php -->
                        <input type="submit" name="eliminar_todo_carrito" value="ELIMINAR TODOS" class="btn btn-danger">
                    </form>
                </td>

                
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="5" align="center">Haz Click en COMPRAR para añadir JUGADORES</td>
            </tr>
            <?php
        }


        ?>

    </table>

    <div style="text-align: center;">
        <form method='post' action='checkout.php'>
            <!-- Otros campos y botones -->
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <input type='submit' name='submit_pay' value='PAGAR' class='btn btn-info'>
            <!-- Otros botones y elementos del formulario -->
        </form>
    </div>


</div>

<!-- Aquí va el código HTML después de la tabla de resumen de compra -->

    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <?php

    include '../Layout/footer.php'; 
    ?>
</body>


</html>
