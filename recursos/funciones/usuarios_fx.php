<?php
session_start();
include('../clases/UsuarioCs.php');

if(isset($_POST['btnIngresar']))    {

    //RESCATAMOS LOS PARAMETROS Y LAS ALMACENAMOS EN VARIABLES LOCALES
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $perfil = $_POST['perfil'];
    //EJEMPLO DE DOS VALIDACIONES (SI EL RUT LLEGA O SI LLLEGA VACIO)
    /*
    if (isset($rut) || empty($rut)) {
        $mensaje='<div class="alert alert-dark">EL rut es obligatorio </div>';
        header('location: ../../usuarios.php?msg='.$mensaje);
    }
    */
    //VALIDAR CAMPOS DEL FORMULARIO 
    if (
        empty($rut) || empty($nombre) || empty($apellido) || empty($correo)
        || empty($pass) || empty($pass2) || empty($perfil)) {
        $mensaje = "<div class='alert alert-dark h5'>LOS CAMPOS SON OBLIGATORIOS</div>";
        header('location: ../../usuarios.php?msg='.$mensaje);
    } else {
        //SI LLEGAN LOS CAMPOS DEL FORMULARIO CON DATOS, VERIFICAMOS LAS CONTRASEÑAS IGUALES
        if ($pass == $pass2) {
            //CREAR EL ARREGLO 
            $ArregloFormulario = array(
                'rut' => $rut,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'pass' => $pass,
                'perfil' => $perfil
            );
            //DECODIFICAMOS EL JSON QUE LLEGA DE LA CLASE USUARIO
            $result = json_decode($usuario->guardar($ArregloFormulario));
            //VERIFICAMOS SI EL INGRESO FUE CORRECTO O YA EXISTE 
            if ($result->estado == true) {
                //1.-PRIMERA MANERA DE ENVIAR ALERTA DESDE LA CLASE Y ENVIADA POR GET (GRACIAS AL &) DE MANERA CONCADENADA
                header('location: ../../usuarios.php?id='.$result->ultimo.'&msg='.$result->mensaje);
            } else {
                //2.-SEGUNDA MANERA DE ENVIAR ALERTA DESDE UNA VARIABLE CREADA DE ESTA CLASE Y CONCADENANDOLA POR GET (GRACIAS AL &)
                $mensaje = "<div class='alert alert-dark h5'>EL USUARIO YA EXITE</div>";
                header('location: ../../usuarios.php?msg='.$mensaje);
            }
        } else {
            // RESPUESTA CONTRASEÑA ERRONEA
            $mensaje = "<div class='alert alert-dark h5'>LAS CONTRASEÑAS NO SON IGUALES</div>";
            header('location: ../../usuarios.php?msg='.$mensaje);
        }
    }
}

if(isset($_POST['btnBuscar']))    {
    //RESCATAMOS LOS PARAMETROS Y LAS ALMACENAMOS EN VARIABLES LOCALES
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $perfil = $_POST['perfil'];
    //VALIDAR CAMPOS
    if (empty($rut)) {
        $mensaje = "<div class='alert alert-dark h5'>EL RUT DEBE SER OBLIGATORIO</div>";
        header('location: ../../usuarios.php?msg='.$mensaje);
    } else {
        //PIDE LOS PARAMETROS 
        $ArregloFormulario = array(
            'rut' => $rut,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'correo' => $correo,
            'perfil' => $perfil
        );
        $result = json_decode($usuario->mostrarPorrut($ArregloFormulario));
        //VERIFICAMOS SI EL INGRESO FUE CORRECTO O YA EXISTE 
        if ($result->estado == true) {
            //RESCATAMOS LOS PARAMETROS ENVIADOS POR MOSTRARPORRUT
            $mensaje = "<div class='alert alert-primary h5'>SE ENCONTRO CON EXITO</div>";
            header('location: ../../usuarios.php?id='.$result->id.'&msg='.$mensaje);
        } else {
            $mensaje = "<div class='alert alert-dark h5'>EL USUARIO NO EXITE</div>";
            header('location: ../../usuarios.php?msg='.$mensaje);
        }
    }
}

if(isset($_POST['btnActualizar']))    {

    $idH = $_POST['idH'];
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $perfil = $_POST['perfil'];

    if (empty($nombre) || empty($apellido) || empty($pass) || empty($pass2) || empty($perfil)) {
        $mensaje = "<div class='alert alert-dark h5'>LOS CAMPOS SON OBLIGATORIOS</div>";
        header('location: ../../usuarios.php?msg='.$mensaje);
    }else{
        //ARMAR ARREGLO 
        $params = array(
            'idH' => $idH,
            'rut' => $rut,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'correo' => $correo,
            'pass' => $pass,
            'perfil' => $perfil 
        );
        $result = json_decode($usuario->modificar($params));
        
        //DIRECCIONAMOS LA RESPUESTA
        if ($result->estado == true ) {
            header('location: ../../usuarios.php?id='.$result->id.'&msg=' . $result->mensaje);
        }else{
            header('location: ../../usuarios.php?msg=' . $result->mensaje);
        }
    } 
}

// ENVIO DE FOTO
if(isset($_POST['btnGuardar_foto']))    {

    //var_dump($_POST);
    //var_dump($_FILES);

    //ASOCIAR LA MATRIZ 
    $id = $_POST['idH'];
    //ASOCIAR PARAMETROS DEL ARREGLO 
    $nombreImg =  $_FILES['idH']['name'];
    $tipo =  $_FILES['idH']['type'];
    $size =  $_FILES['idH']['size'];
    $nombreTmnp =  $_FILES['idH']['tmp_name'];

    /*
    //VERIFICAMOS SI LLEGO LA IMAGEN Y SU TAMAÑO
    if (($nombreImg != NULL) && ($size < 3000000)) {
        //VERIFICAMOS SI ES UNA IMAGEN 
        if (($tipo == 'image/png') || ($tipo == 'image/gif') || ($tipo == 'image/jpg') 
            || ($tipo == 'image/jpeg')) {
            $ruta = "../../img/";
            //AHORA MNOVEMOS EL 
            move_uploaded_file()
        }else{
            //MANDAR ERROR DEL TIPO DE IMAGEN
        }
    }else{
        //MENSAJE DE ERROR DEL TAMAÑO
    }

*/
}
?>

