

<?php 
    include '../Layout/header.php'; 
?>
<!doctype html>
<html lang="es">

<head>
    <title>Buscador</title>
</head>

<body>
    <h1 align="center">LISTADO DE JUGADORES</h1>

    <!-- Formulario de búsqueda -->
    <nav" class="navbar navbar-light bg-light ">
        <div class="container-fluid row justify-content-center">
            <!--La función $_SERVER["PHP_SELF"] devuelve el nombre del archivo del script que está siendo ejecutado. La función "htmlspecialchars()" se utiliza para convertir caracteres especiales en entidades HTML, lo que ayuda a prevenir posibles ataques de inyección de código-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="d-flex col-7 col-md-5">
                <input type="text" id="nombre" name="nombre" placeholder="Buscar Jugador o Equipo ....">
                <button type="submit" class="btn btn-outline-success">Buscar</button>
                <!-- este boton es crucial porque al darlo el usuario resetea la busqueda y se dirige a la página principal mostrando
                    a todos los jugadores, por eso tenemos 2 codigos casi identicos uno para las busquedas y otro para mostrar a todos los jugadores,
                    he de decir que he intentado hacerlo es un solo código pero no he sabido hacerlo, en próximas entregas seguiremos intentandolo-->
                <a href="../index.php" class="btn btn-default">Reset</a>
            </form>
        </div>
    </nav>
    <div class="container-fluid row justify-content-center">
        <!-- Boton para agregar un nuevo jugador -->
        <a href="../Vistas/Vista_NuevoJugador.php" class="btn btn-dark" id="boton-agregar">Nuevo jugador</a>
    </div>
    <hr>
    <hr>

    <div class="container">
        <!--Creación de la tabla de los jugadores, con sus respectivas columnas -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">JUGADOR</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">EQUIPO</th>
                    <th scope="col">CALIDAD</th>
                    <th scope="col">VALOR</th>
                    <th scope="col">ID</th>
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>

            <?php
            //incluimos la conexión esta vez por PDO
            include "../Config/conexionPDO.php";

            // Si se envió un nombre para buscar, realizar la búsqueda
            if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {
                // Almacenamos el nombre buscado
                $nombre_buscado = $_GET['nombre'];

                try {
                    // Preparamos la consulta SQL para buscar jugadores por nombre o equipo
                    $sql = "SELECT * FROM jugadores WHERE nombre LIKE :nombre OR equipo LIKE :nombre";
                    $statement = $miPDO->prepare($sql);

                    // Se usa bindValue para evitar SQL injection
                    $statement->bindValue(':nombre', '%' . $nombre_buscado . '%');

                    // Ejecutamos la consulta
                    $statement->execute();

                    // Obtenemos todos los jugadores que coinciden con la búsqueda
                    $jugadores = $statement->fetchAll(PDO::FETCH_ASSOC);

                    // Si se encontraron jugadores, mostrar información
                    if ($jugadores) {
                        //El bucle foreach se utiliza para recorrer arrays en PHP. La estructura básica es foreach ($array as $valor)
                        foreach ($jugadores as $fila) {
                            // Mostrar los detalles de los jugadores en una tabla 
                            echo "<tr>";
                            // Esto es para cargar la foto.
                            echo "<td><img width='150' height='200' src='data:image/jpg;base64," . base64_encode($fila['imagen']) . "' alt=''></td>";
                            echo "<td>" . $fila['nombre'] . "</td>";
                            echo "<td>" . $fila['equipo'] . "</td>";
                            echo "<td>" . $fila['calidad'] . "</td>";
                            echo "<td>" . $fila['valor'] . "</td>";
                            echo "<td>" . $fila['id'] . "</td>";
                            echo "<td>";
                            // Botones de acción para editar, eliminar y marcar como favorito
                            echo "<a href='../Vistas/Vista_Editar_Jugador.php?id=" . $fila["id"] . "' class='btn btn-warning'>Editar</a>";
                            echo "<a href='../Modelos/Modelo_Eliminar_Jugador.php?id=" . $fila["id"] . "' class='btn btn-danger'>Eliminar</a>";
                            // El boton de favorito agrega los jugadores en una lista de favoritos por medio de una cookie para cada uno de los 
                            // distintos usuarios.
                            echo "<a href='../Vistas/Vista_Favoritos.php?id=" . $fila["id"] . "' class='btn btn-info'>Favorito</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Mostrar un mensaje si no se encontraron jugadores con el nombre buscado
                        echo "<tr><td colspan='5'>No se encontraron jugadores con ese nombre o equipo.</td></tr>";
                    }
                } catch (PDOException $e) {
                    // Capturar y mostrar errores de PDO
                    echo "Error: " . $e->getMessage();
                }
            } else {
                // No se realizó una búsqueda, no mostrar ningún jugador
                echo "<tr><td colspan='7'>No se han cargado jugadores.</td></tr>";
            }
            ?>
        </table>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>  