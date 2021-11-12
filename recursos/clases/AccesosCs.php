<?php
require 'ConexionCs.php';

class  Accesos extends Conexion{

    function __construct(){
        //Se llama al Constructor de Conexion ( con el : llamamos al metodos de la clase padre )
        parent::__construct();
        return $this; 
    }

    public function login (){
        //PREGUNTA SOBRE EL ARREGLO COMO VECTOR DE SUS VARIABLES
        //  IF 1- Criterio (Revisa arregloLogin )  2- El ? revisa si la sentencia es verdadera  
        // 3- El : Sentencia falsa
        $data = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        //Armamos la consulta SQL 
        $sql = "SELECT rut, nombre, apellido, correo, pass, perfil FROM usuario WHERE rut=?";
        //llamamos al metodo de conexion 
        $consulta = $this->prepare($sql);
        //llamamos al metodo blin para enlazar variables '?' y sus tipos 
        $consulta->bind_param('s',$usuario);
        $usuario = $data ['usuario']; 
        $pass = $data ['pass'];
        //Ejecutamos la consulta desde esta Clase
        $this->execute($consulta);
        //Depuramos el objeto smt que estamos usando (DIFERENCIAMOS LA PASS QUE VIENE DE LA BASE DE DATO)
        $consulta->bind_result($rut, $nombre, $apellido, $correo, $pass_bd, $perfil);
        //Leemos el resultado 
        $consulta->fetch();
        //Verificamos la contraseña
        if ($pass==$pass_bd) {
            $info=array(
                'estado' => true,
                'rut' => $rut,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'pass' => $pass,
                'perfil' => $perfil

            );
        }else{
            $info=array(
                'estado'=> false,
                'mensaje'=> '<b>El usuario NO es VALIDO </b>'
            );
        }
        //RETORNAMOS EL ARREGLO
        //var_dump($info);exit;
        return json_encode($info);
    }
 
}

$accesos = new Accesos;

?>