<div class="container">
    <h4 class="mt-3 mb-3">Lista de Productos</h4>
    <a href="<?= BASE_URL ?>new-product" class="btn btn-primary">Nuevo</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoria</th>
                <th>F.V.</th>
                <th>Codigo de barras</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="content_products">

        </tbody>
    </table>
</div>
<script src="<?= BASE_URL ?>view/function/product.js"></script>
<script src="<?= BASE_URL ?>view/function/JsBarcode.all.min.js"></script>