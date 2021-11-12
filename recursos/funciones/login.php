<?php
session_start();
include('../clases/AccesosCs.php');
//var_dump($_POST);exit;
if (isset($_POST['btn_login'])){
    
    //Asociamos las variable que vienen del arreglo POST 
    $usuario =  $_POST['rut'];
    $password = $_POST['pass'];
    
    //Preparamos el arreglo
    $arregloLogin = array(
        'usuario' => $usuario,
        'pass' => $password
    );

    //Llamamos al METODO LOGIN DE LA CLASE ACCESO Y ENVIAMOS EL ARREGLO
    //Tambien recibiremos un arreglo y lo guardaremos en una variabnloe LOCAL POR EL JSON
    $loginLocal = json_decode($accesos->login($arregloLogin));
    
    //Analisamos lo que encontramos en la bd
    if ($loginLocal->estado == true){

        header('location:../../inicio.php');
    }else{
     header('location:../../index.html');
    }
}
?>