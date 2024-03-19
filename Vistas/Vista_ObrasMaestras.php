<?php 
    include '../Layout/header.php'; 
?>

<!--*******************************************************************-->

<!doctype html>
<html lang="es">
<!--Head con enlaces a CSS, BOOTSTRAP Y JAVASCRIPT  -->

<head>
    <script src="JS/galeria.js"></script>
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
                        <a class="nav-link active" href="../Vistas/Vista_ObrasMaestras.php">VIDEOS</a>
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
        
        
        <hr>
        <h4 align="center">OBRAS MAESTRAS</h4>
        <hr>
          <div class="card-group <style> background-color : #07031b </style>">
            <div class="card">
              <video id="videoZidane" width="500" height="300" controls poster="../IMG/zidane01.jpg"><source src="../VIDEOS/videoZidane.mp4" type="video/mp4"></video>
              <div class="card-body">
                <h6 class="card-title">LA OCTAVA MARAVILLA</h6>
                <p class="card-text">Cuando le preguntaron a Zidane por este gol con la zurda, el respondió que es diestro.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">Menos mal que la zurda no es su pierna buena.</small>
              </div>
            </div>
            <div class="card">
              <video id="videoRony" width="500" height="300" controls poster="../IMG/rony.jpg"><source src="../VIDEOS/ronaldinho.mp4" type="video/mp4"></video>
              <div class="card-body">
                <h6 class="card-title">EL PRIMER DISPARO DEL GAUCHO</h6>
                <p class="card-text">Es el jugador con más fantasia que han visto mis ojos, este video representa su llegada a la Liga.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">Se te ponen los pelos de punta al rememorarlo.</small>
              </div>
            </div>
            <div class="card">
              <video id="videoFifa" width="500" height="300" controls poster="../IMG/fifa01.jpg"><source src="../VIDEOS/adefifa.mp4" type="video/mp4"></video>
              <div class="card-body">
                <h6 class="card-title">BRAZALES EN FIFA</h6>
                <p class="card-text">Tras 15 años jugando sigo siendo un poco manco, pero me sigue flipando este juego.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">A veces me quito los guantes del horno y hago cositas.</small>
              </div>
            </div>
          
          <script>
              document.addEventListener("DOMContentLoaded", function() {
                var video1 = document.getElementById("videoZidane");
                var video2 = document.getElementById("videoRony");
                
                video1.volume = 0.5; // Establece el volumen del primer video al 50%
                video2.volume = 0.2; // Establece el volumen del segundo video al 50%
              });
            </script>
      



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <?php 
    include '../Layout/footer.php'; 
    ?>
    </body> 
</html>