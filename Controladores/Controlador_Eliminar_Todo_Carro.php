<?php
session_start(); // Inicia la sesión si aún no está iniciada

//Conexión
include "../Config/conexion.php";
// Elimina todos los elementos del carrito de compras
unset($_SESSION["shopping_cart"]);

// Redirige de regreso a la página del carrito
header("Location: Vista_Carro.php");
exit; // Asegura que no haya ninguna salida adicional después de la redirección
?>
