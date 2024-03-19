<?php 
    include '../Layout/header.php'; 
?>
<!doctype html>
<html lang="es">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
        <title>Proyecto</title>
    </head>

    <header class="bg-secondary">

        <!-- Inicio del menu -->

        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-fluid">
                <!-- icono o nombre -->

                <a class="navbar-brand" href="#">
                    <i class="bi bi-suit-spade-fill"></i>
                    <span class="text-success">PLAYER PROFIT</span>
                </a>

            </div>
        </nav>
    </header>

    <body>
        <!-- Contenedor principal -->
        <div>
            <!-- Título centrado para agregar un nuevo jugador -->
            <h1 align="center" id="nuevoJugador">NUEVO JUGADOR</h1>
        </div>

        <!-- Formulario para agregar un jugador -->

        <form action="../Modelos/Modelo_AgregarJugador.php" method="POST" class="contenedor_incluir_jugador" enctype="multipart/form-data">

            <!-- Campo para ingresar el nombre del jugador -->
            <div class="mb-3">
                <label class="form-label">NOMBRE DEL JUGADOR :</label>
                <input type="text" class="form-control" name="nombre">
            </div>

            <!-- Selección de la calidad del jugador -->
            <select class="form-select mb-3 form-control" name="equipo">
                <option selected disabled>Elige EQUIPO</option>


                
                <?php
                // Incluir el archivo de conexión a la base de datos
                include "../Config/conexion.php";

                // Preparar la consulta para seleccionar todos los datos de la tabla 'jugadores'
                $sql = $conexion->query("SELECT * FROM jugadores");

                // Ejecutar la consulta y mostrar los resultados
                while ($resultado = $sql->fetch_assoc()) {
                            
                    echo "<opcion value='".$resultado['id']."'>".$resultado['equipo']."</option>";
                } 

            ?>
                <option value="REAL MADRID">REAL MADRID</option>
                <option value="PSG">PSG</option>
                <option value="BARCELONA">BARCELONA</option>
            </select>

            <!-- Campo para cargar la foto del jugador -->
            <div class="mb-3">
                <label class="form-label">FOTO : </label>
                <input type="file" class="form-control" name="imagen">
            </div>

                <!-- Campo para ingresar el valor del jugador -->
            <div class="mb-3">
                <label class="form-label">VALOR :</label>
                <input type="number" class="form-control" name="valor">
            </div>

            <!-- Selección de la calidad del jugador -->
            <select class="form-select mb-3 form-control" name="calidad">
                <option selected disabled>Elige Calidad</option>


                
                <?php
                // Incluir el archivo de conexión a la base de datos
                include "../Config/conexion.php";

                // Preparar la consulta para seleccionar todos los datos de la tabla 'jugadores'
                $sql = $conexion->query("SELECT * FROM jugadores");

                // Ejecutar la consulta y mostrar los resultados
                while ($resultado = $sql->fetch_assoc()) {
                            
                    echo "<opcion value='".$resultado['id']."'>".$resultado['calidad']."</option>";
                } 

            ?>
            <option value="ORO UNICO">ORO UNICO</option>
            <option value="JUGADOR DE LA SEMANA">JUGADOR DE LA SEMANA</option>
            <option value="ORO NORMAL">ORO NORMAL</option>
        </select>

            <!-- Botón para guardar el formulario -->
            <button type="submit" class="btn btn-primary">Guardar</button>

            <!-- Enlace para volver a la página principal -->
            <a href="Vista_Gestion.php" class="btn btn-info">Volver</a>

        </form>

        <!-- Scripts necesarios de Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <?php 
        include '../Layout/footer.php'; 
        ?>
    </body>


</html>