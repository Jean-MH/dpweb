<?php
require_once "./model/views_model.php";

class viewsControl extends viewModel
{
    public function getPlantillaControl()
    {
        return require_once "./view/plantilla.php";
    }
    public function getViewControl()
    {
        // Permitir ciertas vistas públicas sin iniciar sesión
        $public_views = ["ver-producto", "products", "index", "login"];
        if (isset($_GET["views"])) {
            $ruta = explode("/", $_GET["views"]);
            $viewName = $ruta[0];
            if (in_array($viewName, $public_views)) {
                $response = viewModel::get_view($viewName);
                return $response;
            }
        }

        session_start();
        if (isset($_SESSION['ventas_id'])) {
            if (isset($_GET["views"])) {
                $ruta = explode("/", $_GET["views"]);
                $response = viewModel::get_view($ruta[0]);
            } else {
                $response = "index.php";
            }
        } else {
            $response = "login";
        }
        return $response;
    }
}