<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jean</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>view/bootstrap/css/bootstrap.min.css">
    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
    <?php
        if (isset($_GET["views"])) {
            $ruta = explode("/", $_GET["views"]);
            //echo $ruta[1];
        }
        ?>
</head>
<style>
    .table, table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 10px;
        overflow: hidden;
        background: rgba(255,255,255,0.02);
        box-shadow: 0 6px 18px rgba(0,0,0,0.6);
        width: 100%;
    }
    .table thead {
        background: linear-gradient(90deg, #4FB83B 0%, #2FA04A 100%);
        color: #000000ff;
    }
    .table thead th {
        border: 0;
        padding: .75rem 1rem;
        font-weight: 600;
        vertical-align: middle;
    }
    .table tbody td {
        padding: .65rem 1rem;
        color: #111111ff;
        vertical-align: middle;
        border-top: 1px solid rgba(255,255,255,0.03);
    }
    .table tbody tr {
        transition: background .12s ease, transform .08s ease;
    }
    .table tbody tr:hover {
        background: rgba(79,184,59,0.04);
        transform: translateY(-2px);
    }
    .table .actions { white-space: nowrap; }


    .form-table input, .form-table select, .form-table textarea {
        background-color: #0b0b0b;
        color: #000000ff;
        border: 1px solid #2b2b2b;
        padding: .5rem .6rem;
        border-radius: 6px;
    }

    
    .table-responsive {
        border-radius: 10px;
        padding: .6rem;
        background: transparent;
    }

    .btn-sm {
        padding: .25rem .5rem;
        border-radius: 6px;
    }

    @media (max-width: 768px) {
        .table thead { display: none; }
        .table tbody td { display: block; width: 100%; }
        .table tbody tr { margin-bottom: .6rem; display: block; box-shadow: 0 4px 10px rgba(0,0,0,0.6); border-radius: 8px; }
    }
    body {
        background-color: #000000;
    }
    .navbar-expand-lg{
        background-color: #4FB83B;
    }
    h4{
        color : white;
    }
    h2{
        color: white;
    }
    .btn-primary {
        background-color: #4FB83B;
        border-color: #4FB83B;
    }
    .btn-primary:hover {
        background-color: #3fa02f;
        border-color: #3fa02f;
    }
</style>
<body>
    <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= BASE_URL ?>index.php?views=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?views=users">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?views=products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?views=ver-producto">View Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?views=category">Categories</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?views=clientes">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?views=proveedor-lista">Proveedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Shops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sales</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <ul class="navbar-nav px-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="">Perfil</a></li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>login">login</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                        <li>

                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </nav>