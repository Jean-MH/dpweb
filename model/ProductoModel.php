<?php
require_once __DIR__ . '/../library/conexion.php';

class ProductoModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    /* ================= LISTAR ================= */

    public function verProductos()
    {
        $sql = "SELECT * FROM producto ORDER BY id DESC";
        $query = $this->conexion->query($sql);

        $productos = [];
        if ($query) {
            while ($row = $query->fetch_object()) {
                $productos[] = $row;
            }
        }

        return $productos;
    }

    /* ================= VALIDACIONES ================= */

    public function existeCodigo($codigo)
    {
        $sql = "SELECT id FROM producto WHERE codigo = ? LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $codigo);
        $stmt->execute();

        return $stmt->get_result()->num_rows;
    }

    public function existeCategoria($nombre)
    {
        $sql = "SELECT id FROM producto WHERE nombre = ? LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        return $stmt->get_result()->num_rows;
    }

    /* ================= CRUD ================= */

    public function registrar(
        $codigo,
        $nombre,
        $detalle,
        $precio,
        $stock,
        $id_categoria,
        $fecha_vencimiento,
        $imagen,
        $id_proveedor
    ) {
        $sql = "INSERT INTO producto
                (codigo, nombre, detalle, precio, stock, id_categoria, fecha_vencimiento, imagen, id_proveedor)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param(
            "sssdiisss",
            $codigo,
            $nombre,
            $detalle,
            $precio,
            $stock,
            $id_categoria,
            $fecha_vencimiento,
            $imagen,
            $id_proveedor
        );

        if ($stmt->execute()) {
            return $this->conexion->insert_id;
        }

        return 0;
    }

    public function ver($id)
    {
        $sql = "SELECT * FROM producto WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_object();
    }

    public function actualizar($id, $nombre, $detalle)
    {
        $sql = "UPDATE producto SET nombre = ?, detalle = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssi", $nombre, $detalle, $id);

        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM producto WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    /* ================= STOCK ================= */

    public function descontarStock($id_producto, $cantidad)
    {
        $sql = "UPDATE producto
                SET stock = stock - ?
                WHERE id = ? AND stock >= ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iii", $cantidad, $id_producto, $cantidad);

        return $stmt->execute();
    }
}
