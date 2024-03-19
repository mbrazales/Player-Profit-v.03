<?php 
    include '../Layout/header.php'; 
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
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Proyecto</title>
</head>


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

<nav" class="navbar">
    <div class="container-fluid row justify-content-center">

        <?php

        //conexión a la base de datos
        include "../Config/conexion.php";

        //Obtenemos el valor de id con la solicitud Request, [recoge POST y GET]
        $id = $_REQUEST['id'];

        //Crear una consulta para seleccionar todos los datos de la tabla 'jugadores' donde el ID coincida con el valor recibido.
        $Sql = "SELECT * FROM jugadores WHERE id = $id";

        // Ejecutar la consulta en la base de datos a través de la conexión establecida
        $resultado = $conexion->query($Sql);

        // Obtener la primera fila de resultados como un array asociativo
        $Fila = $resultado->fetch_assoc();


        ?>
        <!--esta etiqueta center es para centrar el desplegable de la calidad de los jugadores , he sido incapaz de hacerlo de otra manera -->
        <center>
            <div class="container">
                <hr> 
                <h1>EDITAR JUGADOR</h1> <!-- Encabezado para editar jugador -->
                <hr> 
                <!-- Formulario que envía los datos a Modelo_Editar_Jugador.php con el ID a editar y permite enviar archivos -->
                <form action="../Modelos/Modelo_Editar_Jugador.php?idEditar=<?php echo $Fila['id'] ?>" method="POST" enctype="multipart/form-data">
                    

                    <div class="mb-3">
                        <label>Nombre</label> <!-- Etiqueta para el nombre -->
                        <input type="text" name="nombre" value="<?php echo $Fila['nombre'] ?>">
                        <!-- Campo de entrada de texto para el nombre, con el valor predefinido obtenido de $Fila['nombre'] -->
                    </div>

                    <select class="form-select mb-3 " name="equipo" style="width: 280px;">
                        <!-- Selección de equipo -->
                        <option selected><?php echo $Fila['equipo'] ?></option>
                        <!-- Opción preseleccionada con la equipo obtenida de $Fila['equipo'] -->
                        <option value="REAL MADRID">REAL MADRID</option>
                        <option value="PSG">PSG</option>
                        <option value="BARCELONA">BARCELONA</option>
                    </select>

                    <div class="mb-3">
                        <label>Imagen</label> <!-- Etiqueta para la imagen -->
                        <input type="file" name="imagen">
                        <!-- Campo para subir una imagen -->
                    </div>

                    <td>
                        <img width="300" height="350" src="data:image/jgp;base64,<?php echo base64_encode($Fila['imagen']) ?>" alt="">
                        <!-- Visualización de la imagen utilizando su representación en base64 -->
                    </td>

                    <select class="form-select mb-3" name="calidad" style="width: 280px;">
                        <!-- Selección de calidad -->
                        <option selected><?php echo $Fila['calidad'] ?></option>
                        <!-- Opción preseleccionada con la calidad obtenida de $Fila['calidad'] -->
                        <option value="ORO UNICO">ORO UNICO</option>
                        <option value="JUGADOR DE LA SEMANA">JUGADOR DE LA SEMANA</option>
                        <option value="ORO NORMAL">ORO NORMAL</option>
                    </select>

                    <div class="mb-3">
                        <label>Valor</label> <!-- Etiqueta para el nombre -->
                        <input type="number" name="valor" value="<?php echo $Fila['valor'] ?>">
                        <!-- Campo de entrada de texto para el valor, con el valor predefinido obtenido de $Fila['valor'] -->
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <!-- Botón para guardar los cambios -->
                    <a href="../index.php" class="btn btn-info">Volver</a>
                    <!-- Enlace para volver a la página principal -->
                </form>
            </div>

        </center>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <?php 
        include '../Layout/footer.php'; 
        ?>
    </body>

</html>