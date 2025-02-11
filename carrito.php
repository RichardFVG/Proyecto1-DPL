<?php
// 1. Inicia o reanuda una sesión existente
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// 2. Obtiene las preferencias de idioma y estilo 
// desde las cookies o establece valores por 
// defecto
$idioma = 
isset($_COOKIE['idioma']) && in_array(
    $_COOKIE['idioma'], ['es', 'en']
) ? $_COOKIE['idioma'] : 'es';

$estilo = 
isset($_COOKIE['estilo']) && in_array(
    $_COOKIE['estilo'], ['claro', 'oscuro']
) ? $_COOKIE['estilo'] : 'claro';

// 3. Incluye el archivo de idioma correspondiente
include("lang/" . $idioma . ".php");

// 4. Incluye el archivo que contiene la lista de 
// productos
include('productos.php');
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($idioma); ?>">
<head>
    <meta charset="UTF-8">
    <!-- 5. Establece el título de la página 
     utilizando el archivo de idioma -->
    <title>
        <?php 
            echo htmlspecialchars(
                $lang['carrito_compras']
            ); 
        ?>
    </title>
    <!-- 6. Agrega el favicon -->
    <link rel="icon" type="image/png" href="img/RFVG.png">
    <!-- 7. Enlaza la hoja de estilos según la 
     preferencia del usuario -->
    <link rel="stylesheet" 
    href="css/<?php echo htmlspecialchars($estilo); ?>.css">
    <!-- 8. Hace que el sitio sea responsive -->
    <meta name="viewport" 
    content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>
            <?php 
                echo htmlspecialchars(
                    $lang['carrito_compras']
                ); 
            ?>
        </h1>

        <?php
        // 9. Verifica si existe la cookie del 
        // carrito
        if (isset($_COOKIE['carrito'])) {
            // 10. Deserializa la cookie para 
            // obtener el contenido del carrito
            $carrito = unserialize($_COOKIE['carrito']);

            // 11. Maneja la eliminación de productos 
            // si se ha enviado un formulario POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // 12. Recorre los datos enviados por 
                // POST
                foreach ($_POST as $key => $value) {
                    // 13. Busca claves que comiencen con 
                    // 'eliminar_id_'
                    if (strpos(
                        $key, 
                        'eliminar_id_'
                    ) === 0) {
                        // 14. Extrae el ID del producto de 
                        // la clave
                        $producto_id = 
                        (int) str_replace(
                            'eliminar_id_', 
                            '', 
                            $key
                        );
                        // 15. Obtiene la cantidad a eliminar 
                        // para ese producto
                        $cantidad_a_eliminar = 
                        (int) $_POST[
                            'cantidad_a_eliminar_' . $producto_id
                        ];

                        // 16. Verifica si el producto existe 
                        // en el carrito
                        if (isset($carrito[$producto_id])) {
                            // 17. Resta la cantidad a eliminar 
                            // del total en el carrito
                            $carrito[$producto_id] -= 
                            $cantidad_a_eliminar;

                            // 18. Si la cantidad llega a cero o 
                            // menos, elimina el producto del carrito
                            if ($carrito[$producto_id] <= 0) {
                                unset($carrito[$producto_id]);
                            }

                            // 19. Actualiza la cookie del carrito 
                            // con los nuevos valores
                            setcookie(
                                'carrito', 
                                serialize($carrito), 
                                time() + 3600
                            );
                            // 20. Muestra un mensaje indicando que 
                            // el producto ha sido actualizado
                            echo "<p class='mensaje'>" . 
                            htmlspecialchars(
                                $lang['producto_actualizado']
                            ) . "</p>";
                        }
                    }
                }
            }

            // 21. Verifica si se ha solicitado vaciar el 
            // carrito
            if (isset($_GET['vaciar'])) {
                // 22. Elimina la cookie del carrito y vacía el 
                // array
                setcookie('carrito', '', time() - 3600);
                $carrito = array();
                // 23. Muestra un mensaje indicando que el 
                // carrito ha sido vaciado
                echo "<p class='mensaje'>" . 
                htmlspecialchars(
                    $lang['carrito_vaciado']
                ) . "</p>";
            }

            // 24. Si el carrito no está vacío
            if (!empty($carrito)) {
                // 25. Inicializa variables para el total de 
                // cantidad y precio
                $total_cantidad = 0;
                $total_precio = 0;
                echo "<ul class='cart-list'>";
                // 26. Recorre cada producto en el carrito
                foreach ($carrito as $id => $cantidad) {
                    // 27. Verifica si el producto existe en 
                    // la lista de productos
                    if (isset($productos[$id])) {
                        // 28. Obtiene los detalles del 
                        // producto
                        $nombre = $productos[$id]['nombre'];
                        $precio = $productos[$id]['precio'];
                        $imagen = $productos[$id]['imagen'];

                        // 29. Define el tamaño por defecto de 
                        // las imágenes
                        $ancho = 100;
                        $alto = 100;

                        // 30. Ajusta la altura si el producto 
                        // es agua
                        if ($imagen == 'agua1.png') {
                            $alto = 250;
                        }

                        // 31. Ajusta la altura si el producto es 
                        // chocolate
                        if ($imagen == 'chocolate1.png') {
                            $alto = 160;
                        }

                        // 32. Calcula el subtotal multiplicando 
                        // el precio por la cantidad
                        $subtotal = $precio * $cantidad;
                        // 33. Suma la cantidad al total de 
                        // productos
                        $total_cantidad += $cantidad;
                        // 34. Suma el subtotal al precio total
                        $total_precio += $subtotal;

                        // 35. Muestra el producto en la lista
                        echo "<li class='cart-item'>";
                        echo "<img src='img/" . 
                        htmlspecialchars($imagen) . 
                        "' alt='" . htmlspecialchars($nombre) . 
                        "' width='$ancho' height='$alto'><br>";
                        echo htmlspecialchars($nombre) . 
                        " x $cantidad - " . 
                        number_format($subtotal, 2) . 
                        " €";
                        echo "<br>";

                        // 36. Inicia un formulario para eliminar 
                        // cantidades del producto
                        echo "<form method='post' action='carrito.php'>";
                        echo "<input type='hidden' name='eliminar_id_$id' value='$id'>";
                        echo "<label for='cantidad_$id'>" . 
                        htmlspecialchars($lang['cantidad_a_eliminar']) . 
                        ":</label>";
                        echo "<input type='number' name='cantidad_a_eliminar_$id' id='cantidad_$id' value='1' min='1' max='$cantidad' required>";
                        echo "<input type='submit' value='" . 
                        htmlspecialchars($lang['eliminar_producto']) . 
                        "'>";
                        echo "</form>";

                        echo "</li><br>";
                    }
                }
                echo "</ul>";
                // 37. Muestra el total de productos en el 
                // carrito
                echo "<p>" . 
                htmlspecialchars($lang['total_productos']) . 
                ": $total_cantidad</p>";
                // 38. Muestra el precio total del carrito
                echo "<p>" . 
                htmlspecialchars($lang['precio_total']) . 
                ": " . number_format($total_precio, 2) . 
                " €</p>";
                // 39. Enlace para vaciar el carrito
                echo "<a href='carrito.php?vaciar=1'>" . 
                htmlspecialchars($lang['vaciar_carrito']) . 
                "</a><br>";
            } 
            
            else {
                // 40. Muestra un mensaje si el carrito está 
                // vacío
                echo "<p class='mensaje'>" . 
                htmlspecialchars($lang['carrito_vacio']) . 
                "</p>";
            }
        } 
        
        else {
            // 41. Muestra un mensaje si no existe la cookie 
            // del carrito
            echo "<p class='mensaje'>" . 
            htmlspecialchars($lang['carrito_vacio']) . 
            "</p>";
        }
        ?>

        <!-- 42. Enlace para volver a la tienda -->
        <a href="index.php">
            <?php 
                echo htmlspecialchars(
                    $lang['volver_tienda']
                ); 
            ?>
        </a>
    </div>
</body>
</html>
