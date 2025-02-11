<?php
// 1. Inicia o reanuda una sesión existente
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// 2. Obtiene las preferencias de idioma y estilo desde las cookies o establece valores por defecto
$idioma = isset($_COOKIE['idioma']) && in_array($_COOKIE['idioma'], ['es', 'en']) ? $_COOKIE['idioma'] : 'es';

$estilo = isset($_COOKIE['estilo']) && in_array($_COOKIE['estilo'], ['claro', 'oscuro']) ? $_COOKIE['estilo'] : 'claro';

// 3. Incluye el archivo de idioma correspondiente
include("lang/" . $idioma . ".php");

// 4. Incluye el archivo que contiene la lista de productos
include('productos.php');
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($idioma); ?>">
<head>
    <meta charset="UTF-8">
    <!-- 5. Establece el título de la página utilizando el archivo de idioma -->
    <title>
        <?php 
            echo htmlspecialchars($lang['titulo_pagina']); 
        ?>
    </title>
    <!-- 6. Agrega el favicon -->
    <link rel="icon" type="image/png" href="img/RFVG.png">
    <!-- 7. Enlaza la hoja de estilos según la preferencia del usuario -->
    <link rel="stylesheet" href="css/<?php echo htmlspecialchars($estilo); ?>.css">
    <!-- 8. Hace que el sitio sea responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <?php
        // 9. Muestra un mensaje de bienvenida personalizado según el tipo de usuario
        if ($_SESSION['usuario'] == 'admin') {
            echo "<h1>" . htmlspecialchars($lang['bienvenida_admin']) . "</h1>";
        } 
        else {
            // 10. Verifica si 'nombre_usuario' está definida y no está vacía
            if (
                isset($_SESSION['nombre_usuario']) && 
                !empty($_SESSION['nombre_usuario'])
            ) {
                $nombre_usuario = htmlspecialchars($_SESSION['nombre_usuario']);
            } 
            else {
                $nombre_usuario = htmlspecialchars($lang['usuario']);
            }
            echo "<h1>" . htmlspecialchars($lang['bienvenida_usuario']) . " <span class='usuario'>$nombre_usuario</span></h1>";
        }

        // 11. Agrega un producto al carrito si se recibe el parámetro 'agregar' en la URL
        if (isset($_GET['agregar'])) {
            $producto_id = (int) $_GET['agregar'];
            // 12. Verifica si el producto existe en la lista de productos
            if (isset($productos[$producto_id])) {
                // 13. Obtiene el carrito actual desde la cookie o crea uno nuevo
                if (isset($_COOKIE['carrito'])) {
                    $carrito = unserialize($_COOKIE['carrito']);
                } 
                else {
                    $carrito = array();
                }
                // 14. Incrementa la cantidad del producto en el carrito
                if (isset($carrito[$producto_id])) {
                    $carrito[$producto_id]++;
                } 
                else {
                    $carrito[$producto_id] = 1;
                }
                // 15. Actualiza la cookie del carrito con los nuevos valores
                setcookie('carrito', serialize($carrito), time() + 3600);
                // 16. Muestra un mensaje indicando que el producto ha sido agregado
                echo "<p class='mensaje'>" . htmlspecialchars($lang['producto_agregado']) . "</p>";
            }
        }
        ?>

        <h2>
            <?php 
                echo htmlspecialchars($lang['lista_productos']); 
            ?>
        </h2>
        <ul class="product-list">
            <?php foreach ($productos as $id => $producto) { ?>
                <li class="product-item">
                    <?php
                        // 17. Define el tamaño por defecto de las imágenes
                        $ancho = 100;
                        $alto = 100;

                        // 18. Ajusta la altura si el producto es agua
                        if ($producto['imagen'] == 'agua1.png') {
                            $alto = 250;
                        }

                        // 19. Ajusta la altura si el producto es chocolate
                        if ($producto['imagen'] == 'chocolate1.png') {
                            $alto = 160;
                        }
                    ?>

                    <!-- 20. Muestra la imagen del producto -->
                    <img src="img/<?php echo htmlspecialchars($producto['imagen']); ?>"
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                         width="<?php echo $ancho; ?>" height="<?php echo $alto; ?>"><br>
                    <!-- 21. Muestra el nombre y el precio del producto -->
                    <?php 
                        echo htmlspecialchars($producto['nombre']); 
                    ?> -
                    <?php 
                        echo number_format($producto['precio'], 2); 
                    ?> €
                    <br>
                    <!-- 22. Enlace para agregar el producto al carrito -->
                    <a href="index.php?agregar=<?php echo $id; ?>">
                        <?php 
                            echo htmlspecialchars($lang['agregar_carrito']); 
                        ?>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <!-- 23. Enlaces de navegación -->
        <a href="carrito.php">
            <?php 
                echo htmlspecialchars($lang['ver_carrito']); 
            ?>
        </a>
        <br>
        <a href="preferencias.php">
            <?php 
                echo htmlspecialchars($lang['cambiar_preferencias']); 
            ?>
        </a>
        <br>
        <a href="logout.php">
            <?php 
                echo htmlspecialchars($lang['cerrar_sesion']); 
            ?>
        </a>
    </div>
</body>
</html>
