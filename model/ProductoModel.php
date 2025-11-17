<?php
require_once __DIR__ . '/../library/conexion.php';
class ProductoModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    
    public function verProductos()
    {
        $productos = array();
        $consulta = "SELECT * FROM producto ORDER BY id DESC";
        $sql = $this->conexion->query($consulta);
        
        if (!$sql) {
            error_log("Error en consulta: " . $this->conexion->error);
            return [];
        }
        
        while ($producto = $sql->fetch_object()) {
            array_push($productos, $producto);
        }
        
        if (empty($productos)) {
            error_log("No se encontraron productos en la base de datos");
        }
        
        return $productos;
    }
    public function existeCodigo($codigo)
    {
        $codigo = $this->conexion->real_escape_string($codigo);
        $consulta = "SELECT id FROM producto WHERE codigo='$codigo' LIMIT 1";
        $sql = $this->conexion->query($consulta);
        return $sql->num_rows;
    }
    public function existeCategoria($nombre)
    {
        $consulta = "SELECT * FROM producto WHERE nombre='$nombre'";
        $sql = $this->conexion->query($consulta);
        return $sql->num_rows;
    }
    public function registrar($codigo, $nombre, $detalle, $precio, $stock, $id_categoria, $fecha_vencimiento, $imagen, $id_proveedor)
    {
        $codigo            = $this->conexion->real_escape_string($codigo);
        $nombre            = $this->conexion->real_escape_string($nombre);
        $detalle           = $this->conexion->real_escape_string($detalle);
        $precio            = floatval($precio);
        $stock             = intval($stock);
        $id_categoria      = intval($id_categoria);
        $fecha_vencimiento = $this->conexion->real_escape_string($fecha_vencimiento);
        $id_proveedor      = intval($id_proveedor);
        $imagen            = $this->conexion->real_escape_string($imagen);
        $consulta = "INSERT INTO producto (codigo, nombre, detalle, precio, stock, id_categoria, fecha_vencimiento, imagen, id_proveedor) VALUES ('$codigo', '$nombre', '$detalle', $precio, $stock, $id_categoria, '$fecha_vencimiento', '$imagen', '$id_proveedor')";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            return $this->conexion->insert_id;
        }
        return 0;
    }
    public function ver($id)
    {
        $consulta = "SELECT * FROM producto WHERE id='$id'";
        $sql = $this->conexion->query($consulta);
        return $sql->fetch_object();
    }

    public function actualizar($id_cat, $nombre, $detalle) {
        $consulta = "UPDATE producto SET nombre='$nombre', detalle='$detalle' WHERE id='$id_cat'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
     public function eliminar($id){
        $id = intval($id);
        if ($id <= 0) {
            error_log("ProductoModel::eliminar - Invalid id: $id");
            return false;
        }
        $consulta = "DELETE FROM producto WHERE id=$id";
        error_log("ProductoModel::eliminar - Ejecutando: $consulta");
        $sql = $this->conexion->query($consulta);
        if (!$sql) {
            $error = $this->conexion->error;
            error_log("ProductoModel::eliminar - Query error: $error");
            return false;
        }
        $affected = $this->conexion->affected_rows;
        error_log("ProductoModel::eliminar - Affected rows: $affected");
        if ($affected > 0) {
            error_log("ProductoModel::eliminar - Product $id deleted successfully");
            return true;
        } else {
            error_log("ProductoModel::eliminar - No product found with id: $id");
            return false;
        }
    }
    
}
