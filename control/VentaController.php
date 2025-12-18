<?php
session_start();

require_once("../model/ventaModel.php"); // Corregido: usar el archivo con 'm' minúscula
require_once("../model/ProductoModel.php");

if (!isset($_SESSION['ventas_id'])) {
    echo json_encode(['status' => false, 'msg' => 'Sesión no válida']);
    exit;
}

$id_usuario = $_SESSION['ventas_id'];

$objProducto = new ProductoModel();
$objVenta = new VentaModel();

$tipo = $_GET['tipo'] ?? '';

/* ================= REGISTRAR TEMPORAL ================= */
if ($tipo === "registrarTemporal") {

    $id_producto = intval($_POST['id_producto'] ?? 0);
    $cantidad = intval($_POST['cantidad'] ?? 1);

    if ($id_producto <= 0 || $cantidad <= 0) {
        echo json_encode(['status' => false, 'msg' => 'Datos inválidos']);
        exit;
    }

    $producto = $objProducto->ver($id_producto);
    if (!$producto) {
        echo json_encode(['status' => false, 'msg' => 'Producto no existe']);
        exit;
    }

    $precio = $producto->precio;
    $temporal = $objVenta->buscarTemporal($id_producto, $id_usuario);

    if ($temporal) {
        $objVenta->actualizarCantidadTemporal(
            $id_producto,
            $temporal->cantidad + $cantidad,
            $id_usuario
        );
        echo json_encode(['status' => true, 'msg' => 'Producto actualizado']);
    } else {
        $objVenta->registrar_temporal($id_producto, $precio, $cantidad, $id_usuario);
        echo json_encode(['status' => true, 'msg' => 'Producto agregado']);
    }
    exit;
}

/* ================= LISTAR TEMPORALES ================= */
if ($tipo === "listarTemporales") {

    $data = $objVenta->buscarTemporales($id_usuario);
    if (empty($data)) {
        // Devuelve un array vacío si no hay productos, el frontend lo manejará.
        echo json_encode(['status' => true, 'data' => []]);
        exit;
    }
    
    echo json_encode(['status' => true, 'data' => $data]);
    exit;
}

/* ================= ELIMINAR TEMPORAL ================= */
if ($tipo === "eliminarTemporal") {
    $id = intval($_POST['id'] ?? 0);
    $ok = $objVenta->eliminarTemporal($id);
    echo json_encode(['status' => $ok]);
    exit;
}

/* ================= ACTUALIZAR CANTIDAD ================= */
if ($tipo === "actualizarCantidadTemporalPorId") {
    $id = intval($_POST['id'] ?? 0);
    $cantidad = intval($_POST['cantidad'] ?? 1);
    $ok = $objVenta->actualizarCantidadTemporalPorId($id, $cantidad);
    echo json_encode(['status' => $ok]);
    exit;
}

/* ================= REGISTRAR VENTA ================= */
if ($tipo === "registrarVenta") {

    $id_cliente = intval($_POST['id_cliente'] ?? 0);

    if ($id_cliente <= 0) {
        echo json_encode(['status' => false, 'msg' => 'ID de cliente no válido']);
        exit;
    }

    $temporales = $objVenta->buscarTemporales($id_usuario);

    if (count($temporales) === 0) {
        echo json_encode(['status' => false, 'msg' => 'Carrito vacío']);
        exit;
    }

    $total = 0;
    foreach ($temporales as $t) {
        $total += $t['precio'] * $t['cantidad'];
    }

    $venta_id = $objVenta->registrarVenta($id_usuario, $id_cliente, $total);

    foreach ($temporales as $t) {
        $objVenta->registrarDetalleVenta(
            $venta_id,
            (int)$t['id_producto'],
            (int)$t['cantidad'],
            (float)$t['precio']
        );
        $objProducto->descontarStock((int)$t['id_producto'], (int)$t['cantidad']);
    }

    $objVenta->eliminarTemporales($id_usuario);

    echo json_encode(['status' => true, 'total' => round($total, 2)]);
    exit;
}
