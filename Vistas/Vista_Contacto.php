

<?php
    include '../Layout/header.php'; 
    
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Buscador</title>
</head>

<header class="bg-secondary">

<!-- Inicio del menu -->

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- icono o nombre -->

        <a class="navbar-brand" href="../index.php">
            <i class="bi bi-suit-spade-fill"></i>
            <span class="text-success">PLAYER PROFIT</span>
        </a>

    </div>
</nav>
</header>

<body>
    <h1 align="center">CONTACTO</h1>

    <!-- La propiedad "readonly" en HTML se utiliza para hacer un campo de entrada de texto no editable,
            lo que significa que el usuario puede ver el contenido, pero no puede modificarlo. -->
    <form action="#" method="GET" name="formulario" readonly id="cajaFormulario" align="center">

        <!-- Utilizamos el método required para que sean obligatorios los campos -->
        <div class="input-group  mb-3">
            <span class="input-group-text">NOMBRE Y APELLIDOS</span>

            <!-- Input para el nombre -->
            <input type="text" aria-label="First name" class="form-control" name="nombre" required pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$">

            <br><!-- Salto de línea -->

            <!-- Input para los apellidos -->
            <input type="text" aria-label="Last name" class="form-control" name="apellidos" required pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$">
            <br>
            
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">TELÉFONO</span>
            <!-- Input para el teléfono -->
            <input type="tel" class="form-control" name="telefono" required pattern="[0-9]+">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">FECHA DE NACIMIENTO</span>
            <!-- Input para la fecha de nacimiento -->
            <input type="date" name="fecha" required class="form-control">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">EMAIL</span>
            <!-- Input para el correo electrónico -->
            <input type="email" class="form-control" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
        </div>

        <div class="input-group">
            <span class="input-group-text">Dirección</span>
            <!-- Textarea para la dirección -->
            <textarea class="form-control" aria-label="With textarea" name="direccion" required></textarea>
        </div>

        <!-- Botón para enviar el formulario -->
        <input id="boton" type="submit" value="ENVIAR" class="btn btn-primary mb-3 col-sm-2 col-form-label">
        <!-- Botón para borrar/resetear el formulario -->
        <input id="boton" type="reset" value="BORRAR" class="btn btn-danger mb-3 col-sm-2 col-form-label">
    </form>
    <?php 
    include '../Layout/footer.php'; 
    ?>
</body>

</html>