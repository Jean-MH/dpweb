<?php
require_once "./config/config.php";
require_once "./control/views_control.php";

$view = new viewsControl();
$mostrar = $view->getViewControl();
// Debug: imprime en comentario cuál es la vista resuelta y si el archivo existe
// Esto ayuda a diagnosticar errores 404.
echo "<!-- mostrar: " . htmlspecialchars($mostrar) . " -->\n";
echo "<!-- existe archivo: " . (is_file($mostrar) ? 'si' : 'no') . " -->\n";

if ($mostrar == "login" || $mostrar == "404") {
    require_once "./view/".$mostrar.".php";
}else {
    include "./view/include/header.php"; // cargamos el header
    include $mostrar;
    include "./view/include/footer.php"; //cargamos el footer
}