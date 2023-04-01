<?php
    function conectar(){
        //Credenciales
        $_SERVER = "localhost";
        $user = "root";
        $pass = "";
        $bd = "db_miagenda";

        $id_conexion = mysqli_connect($_SERVER, $user, $pass, $bd);
        if(!$id_conexion){
            $id_conexion = mysqli_error($id_conexion);
        }
        return $id_conexion;
    }

    function desconectar($id_conexion){
        try {
            mysqli_close($id_conexion);
            $estado = 1;
        } catch (Exception $e) {
            $estado = 0;
        }
        return $estado;
    }

    function agregarContacto($nombre, $telefono)
    {
        # code...
        $id_conexion = conectar();
        $sql = "INSERT INTO tbl_contactos (nombre, telefono) VALUES ('$nombre', '$telefono')";
        if (mysqli_query($id_conexion, $sql)) {
            # code...
            $estado = 1;
        }else{
            $estado = "Error: ". mysqli_error($id_conexion);
        }

        desconectar($id_conexion);
        return $estado;
    }

    function listarcontacto($filtro){
        $id_conexion = conectar();
        $datosFila = array();
        $consulta = "SELECT id_contacto, nombre, telefono FROM tbl_contactos WHERE (nombre LIKE '%$filtro%' OR telefono LIKE '%$filtro%')
        ORDER BY nombre ASC";
        $query = mysqli_query($id_conexion, $consulta);
        $nfilas= mysqli_num_rows($query);
        if ($nfilas != 0) {
            while ($aDatos = mysqli_fetch_array($query)) {
                $jsonFila= array();
                    $id_contacto = $aDatos["id_contacto"];
                    $nombre = $aDatos["nombre"];
                    $telefono = $aDatos["telefono"];
                    $jsonFila["id_contactos"] = $id_contacto;
                    $jsonFila["nombre"] = $nombre;
                    $jsonFila["telefono"] = $telefono;
                    $datosFila[] = $jsonFila;
            }
        }
        desconectar($id_conexion);
        return array_values($datosFila);
    }

    function modificarContacto($id_contacto, $nombre, $telefono)
    {
        # code...
        $id_conexion = conectar();
        $sql = "UPDATE tbl_contactos SET nombre = '$nombre',telefono = '$telefono' WHERE id_contacto = '$id_contacto'";
        if (mysqli_query($id_conexion, $sql)) {
            # code...
            $estado = 1;
        }else{
            $estado = "Error: ". mysqli_error($id_conexion);
        }

        desconectar($id_conexion);
        return $estado;
    }

    function eliminarContacto($id_contacto)
    {
        # code...
        $id_conexion = conectar();
        $sql = "DELETE FROM tbl_contactos WHERE id_contacto = '$id_contacto'";
        if (mysqli_query($id_conexion, $sql)) {
            # code...
            $estado = 1;
        }else{
            $estado = "Error: ". mysqli_error($id_conexion);
        }

        desconectar($id_conexion);
        return $estado;
    }
?>