<?php

    //conexión
    include "../Config/conexion.php";

    //Declaración de las variables obtenidas por el método POST y FILES del formulario
    $nombreJugador = $_POST["nombre"];
    $imagen = addslashes(file_get_contents($_FILES["imagen"]['tmp_name']));
    $calidad = $_POST["calidad"];
    $valor = $_POST["valor"];
    $equipo = $_POST["equipo"];

    //Preparación de la consulta
    $Sql = "INSERT INTO jugadores ( nombre, imagen, calidad, valor, equipo) VALUES ('$nombreJugador', '$imagen', '$calidad', '$valor', '$equipo')";

    //Realizamos la consulta
    $resultado = $conexion -> query($Sql);

    //Mostramos los resultados

    if ($resultado) {
        header ('Location: ../Vistas/Vista_Gestion.php');
    }else {
        echo "No se registraron los datos";
    }

?>

