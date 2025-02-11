<?php
    // 1. Inicia o reanuda una sesión existente
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 2. Obtiene y valida el idioma 
        // seleccionado, estableciendo 'es' por 
        // defecto
        $idioma = 
        in_array(
            $_POST['idioma'], 
            ['es', 'en']
        ) ? $_POST['idioma'] : 'es';

        // 3. Obtiene y valida el estilo seleccionado, 
        // estableciendo 'claro' por defecto
        $estilo = 
        in_array(
            $_POST['estilo'], 
            ['claro', 'oscuro']
        ) ? $_POST['estilo'] : 'claro';

        // 4. Establece una cookie para el idioma con 
        // una duración de 30 días
        setcookie('idioma', $idioma, time() + (86400 * 30));
        // 5. Establece una cookie para el estilo con 
        // una duración de 30 días
        setcookie('estilo', $estilo, time() + (86400 * 30));

        // 6. Redirige al usuario a 'index.php' después 
        // de guardar las preferencias
        header('Location: index.php');
        exit();
    }

    // 7. Obtiene las preferencias actuales de idioma y 
    // estilo desde las cookies o establece valores por 
    // defecto
    $idioma_actual = 
    isset($_COOKIE['idioma']) && in_array(
        $_COOKIE['idioma'], 
        ['es', 'en']
    ) ? $_COOKIE['idioma'] : 'es';

    $estilo_actual = 
    isset($_COOKIE['estilo']) && in_array(
        $_COOKIE['estilo'], 
        ['claro', 'oscuro']
    ) ? $_COOKIE['estilo'] : 'claro';

    // 8. Incluye el archivo de idioma correspondiente
    include("lang/" . $idioma_actual . ".php");

    // 9. No es necesario aplicar estilo aquí, se hace 
    // en el HTML
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($idioma_actual); ?>">
<head>
    <title>
        <?php 
            echo htmlspecialchars(
                $lang['preferencias']
            ); 
        ?>
    </title>
    <link rel="icon" type="image/png" href="img/RFVG.png">
    <link rel="stylesheet" 
    href="css/<?php echo htmlspecialchars($estilo_actual); ?>.css">
    <meta name="viewport" 
    content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>
            <?php 
                echo htmlspecialchars(
                    $lang['preferencias']
                ); 
            ?>
        </h1>
        <form method="post" action="">
            <!-- 10. Selector para el idioma 
             preferido -->
            <label for="idioma">
                <?php 
                    echo htmlspecialchars(
                        $lang['seleccionar_idioma']
                    ); 
                ?>:
            </label>
            <select name="idioma" id="idioma">
                <option value="es" <?php 
                    if ($idioma_actual == 'es') echo 'selected'; 
                ?>>
                    Español
                </option>
                <option value="en" <?php 
                    if ($idioma_actual == 'en') echo 'selected'; 
                ?>>
                    English
                </option>
            </select>
            <br>
            <br>
            <!-- 11. Selector para el estilo 
             preferido -->
            <label for="estilo">
                <?php 
                    echo htmlspecialchars(
                        $lang['seleccionar_estilo']
                    ); 
                ?>:
            </label>
            <select name="estilo" id="estilo">
                <option value="claro" <?php 
                    if ($estilo_actual == 'claro') echo 'selected'; 
                ?>>
                    <?php 
                        echo htmlspecialchars(
                            $lang['estilo_claro']
                        ); 
                    ?>
                </option>
                <option value="oscuro" <?php 
                    if ($estilo_actual == 'oscuro') echo 'selected'; 
                ?>>
                    <?php 
                        echo htmlspecialchars(
                            $lang['estilo_oscuro']
                        ); 
                    ?>
                </option>
            </select>
            <br>
            <br>
            <!-- 12. Botón para guardar las 
             preferencias -->
            <input type="submit" 
            value="<?php 
                echo htmlspecialchars(
                    $lang['guardar_preferencias']
                ); 
            ?>">
        </form>
        <!-- 13. Enlace para volver a la tienda -->
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
