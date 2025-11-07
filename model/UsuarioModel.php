<?php
require_once __DIR__ . '/../library/conexion.php';
class UsuarioModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function registrar($nro_identidad, $razon_social, $telefono, $correo, $departamento, $provincia, $distrito, $cod_postal, $direccion, $rol, $password)
    {
        $consulta = "INSERT INTO persona (nro_identidad,razon_social, telefono, correo, departamento, provincia, distrito, cod_postal, direccion, rol, password) VALUES ('$nro_identidad', '$razon_social', '$telefono', '$correo', '$departamento', '$provincia', '$distrito', '$cod_postal', '$direccion', '$rol', '$password')";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    public function existePersona($nro_identidad)
    {
        $consulta = "SELECT * FROM persona WHERE nro_identidad='$nro_identidad'";
        $sql = $this->conexion->query($consulta);
        return $sql->num_rows;
    }
    public function buscarPersonaPorNroIdentidad($nro_identidad)
    {
        $consulta = "SELECT id, razon_social, password FROM persona WHERE nro_identidad = '$nro_identidad' LIMIT 1";
        $sql = $this->conexion->query($consulta);
        return $sql->fetch_object();
    }
    public function verUsuarios()
    {
        $arr_usuarios = array();
        $consulta = "SELECT * FROM persona"; //where rol = "cliente" OR rol = ""
        $sql = $this->conexion->query($consulta);
        while ($objeto = $sql->fetch_object()) {
            array_push($arr_usuarios, $objeto);
        }
        return $arr_usuarios;
    }
    public function ver($id)
    {
        $consulta = "SELECT * FROM persona WHERE id='$id'";
        $sql = $this->conexion->query($consulta);
        return $sql->fetch_object();
    }
    public function actualizar($id_persona, $nro_identidad, $razon_social, $telefono, $correo, $departamento, $provincia, $distrito, $cod_postal, $direccion, $rol) {
        $consulta = "UPDATE persona SET nro_identidad='$nro_identidad', razon_social='$razon_social', telefono='$telefono', correo='$correo', departamento='$departamento', provincia='$provincia', distrito='$distrito', cod_postal='$cod_postal', direccion='$direccion', rol='$rol' WHERE id='$id_persona'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
    public function eliminar($id){
        $consulta = "DELETE FROM persona WHERE id='$id'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }

public function verProveedores(){
    $arr_proveedores = array ();
    // Try to match providers in a case-insensitive, trimmed manner to avoid missing entries
    $arr_proveedores = array();
    $consulta = "SELECT id, razon_social, rol FROM persona WHERE LOWER(TRIM(rol)) LIKE '%proveedor%'";
    $sql = $this->conexion->query($consulta);
    if ($sql) {
        while ($objeto = $sql->fetch_object()) {
            // keep only id and razon_social for response
            $arr_proveedores[] = (object) [ 'id' => $objeto->id, 'razon_social' => $objeto->razon_social ];
        }
    } else {
        error_log("verProveedores SQL error: " . $this->conexion->error);
    }
    return $arr_proveedores;
}

// Dev helper: return last DB error (empty string if none)
public function getLastError()
{
    return $this->conexion->error ?? '';
}
}