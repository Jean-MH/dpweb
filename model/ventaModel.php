<?php

declare(strict_types=1);

require_once __DIR__ . "/../library/conexion.php";

class VentaModel
{
    private ?mysqli $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->connect();
    }

    /* ================= TEMPORAL ================= */

    public function registrar_temporal(int $id_producto, float $precio, int $cantidad, int $id_usuario): int|false
    {
        $sql = "INSERT INTO temporal_venta (id_producto, precio, cantidad, id_usuario)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("idii", $id_producto, $precio, $cantidad, $id_usuario);
        if ($stmt->execute()) {
            return $this->conexion->insert_id;
        }
        return false;
    }

    public function actualizarCantidadTemporal(int $id_producto, int $cantidad, int $id_usuario): bool
    {
        $sql = "UPDATE temporal_venta
                SET cantidad = ?
                WHERE id_producto = ? AND id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("iii", $cantidad, $id_producto, $id_usuario);

        return $stmt->execute();
    }

    public function actualizarCantidadTemporalPorId(int $id, int $cantidad): bool
    {
        $sql = "UPDATE temporal_venta SET cantidad = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("ii", $cantidad, $id);

        return $stmt->execute();
    }

    public function buscarTemporales(int $id_usuario): array
    {
        $sql = "SELECT * FROM temporal_venta WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result === false) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarTemporal(int $id_producto, int $id_usuario): ?object
    {
        $sql = "SELECT * FROM temporal_venta
                WHERE id_producto = ? AND id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            return null;
        }
        $stmt->bind_param("ii", $id_producto, $id_usuario);
        $stmt->execute();

        return $stmt->get_result()->fetch_object();
    }

    public function eliminarTemporal(int $id): bool
    {
        $sql = "DELETE FROM temporal_venta WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function eliminarTemporales(int $id_usuario): bool
    {
        $sql = "DELETE FROM temporal_venta WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("i", $id_usuario);

        return $stmt->execute();
    }

    /* ================= VENTA FINAL ================= */

    public function registrarVenta(int $id_usuario, int $id_cliente, float $total): int|false
    {
        $sql = "INSERT INTO venta (id_usuario, id_cliente, total, fecha)
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("iid", $id_usuario, $id_cliente, $total);
        if ($stmt->execute()) {
            return $this->conexion->insert_id;
        }
        return false;
    }

    public function registrarDetalleVenta(int $id_venta, int $id_producto, int $cantidad, float $precio): bool
    {
        $sql = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("iiid", $id_venta, $id_producto, $cantidad, $precio);

        return $stmt->execute();
    }
}
