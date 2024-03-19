<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #07031b;
        }
        .gracias {
            font-size: 40px;
            color: green;
            text-align: center;
            padding: 50px;
            border: 2px solid green;
            border-radius: 10px;
            background-color: rgb(226, 255, 192);
            width: 30%;
            margin: auto;
            opacity: 0;
            transition: opacity 2s;
        }
        .boton-volver {
            display: block; /* Cambiado a bloque para ocupar toda la línea */
            margin-top: 30px; /* Añadido margen superior para separar del cartel */
            padding: 10px 20px;
            text-decoration: none;
            background-color: green;
            color: white;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

        <div id="cartel" class="gracias">Gracias por tu compra
            <a href="../index.php" class="boton-volver">Volver</a>
            
        </div>



<script>
    window.onload = function() {
        document.getElementById('cartel').style.opacity = "1";
    }
</script>
    
</body>
</html>
