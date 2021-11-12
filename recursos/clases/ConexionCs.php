<?php

class Conexion{

    //1.Atributos
    private $server = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "proyecto_php";
    protected $conexion;
    protected $secured;

    //2.Constructor
    function __construct()
    {
        $this->conexion= new mysqli($this->server,$this->user,$this->pass,$this->db);
        //Encaso de error
        if($this->conexion->connect_errno){
            die("Error al conectar con MySql: (".$this->conexion->connect_errno.") - ".$this->conexion->connect_errno);
        }
    } 

    //3.Metodos
    public function proteger_text($text){
        $this->secured = strip_tags($text);
        $this->secured = htmlspecialchars(trim(strip_tags($text)),ENT_QUOTES,"UTF-8");
        return $this->secured;
    }

    protected function prepare($consulta){
        if(!($consulta = $this->conexion->prepare($consulta))){
            die("Error al preparar la consulta: (".$this->conexion->connect_errno.") - ".$this->conexion->connect_errno);
        }
        return $consulta;
    }

    protected function execute($sentencia){
        if(!$sentencia->execute()){
            die("Fallo la ejecucion de la consulta: (".$this->conexion->connect_errno.") - ".$this->conexion->connect_errno);
        }
        return $sentencia;
    }
}

$conexion = new Conexion;

?>