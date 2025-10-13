<?php
class viewModel
{
    protected static function get_view($view)
    {
    $white_list = ["home", "products", "users", "new-user","edit-user", "products", "new-product", "edit-product", "category", "new-category", "edit-category", "clientes","new-clients","client-lista","edit-client","proveedor-lista","new-proveedor","edit-proveedor","orders", "order-details", "profile", "settings"];
        if (in_array($view, $white_list)) {
            if (is_file("./view/" . $view . ".php")) {
                $content = "./view/" . $view . ".php";
            } else {
                $content = "404";
            }
        } elseif ($view == "login") {
            $content = "login";
        } else {
            $content = "404";
        }
        return $content;
    }
}