<?php
require 'ConexionCs.php';

class Usuario extends Conexion
{

    function __construct()
    {
        // llamamos al constructor del padre
        parent::__construct();
        return $this;
    }

    //METODO FUERA DEL CRUD PARA CARGAR DATOS 
    public function cargar()
    {
        $data = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        $sqlBuscar = "SELECT id, rut, nombre, apellido, correo, pass, perfil, foto FROM usuario WHERE id=?";
        $consultaBuscar = $this->prepare($sqlBuscar);
        $codigo = $data['codigo'];
        //CON EL METODO BLIND ENLAZAMOS LAS VARIABLES DEL '?' Y DEFINIMOS SU TIPO
        $consultaBuscar->bind_param('i', $codigo); 
        $consultaBuscar->execute();
        $consultaBuscar->bind_result($id, $rut, $nombre, $apellido, $correo, $pass, $perfil, $foto);
        //CON EL METODO FETCH CARGAMOS LAS VARIABLES QUE CREAMOS EN EL BIND_RESULT
        $consultaBuscar->fetch();
        $consultaBuscar->close();

        //ARREGLO DE MANIPULACION DE DATOS 
        if (!empty($codigo)) {
            $info = array(
                'estado' => true,
                'id' => $id,
                'rut' => $rut,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'perfil' => $perfil,
                'foto'=> $foto
            );
        } else {
            $info = array(
                'estado' => false,
                'mensaje' => "<div class='alert alert-danger'>NO SE HAN USUARIOS CON ESE ID </div>"
            );
        }
        return json_encode($info);
    }

    public function mostrarPorrut()
    {
        $data = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        $sqlBuscar = "SELECT id, rut, nombre, apellido, correo, pass, perfil FROM usuario WHERE rut=?";
        $consultaBuscar = $this->prepare($sqlBuscar);
        $run = $data['rut'];
        $consultaBuscar->bind_param('s', $run);
        $consultaBuscar->execute();
        $consultaBuscar->bind_result($id, $rut, $nombre, $apellido, $correo, $pass, $perfil);
        $consultaBuscar->fetch();
        $consultaBuscar->close();
        if (!empty($id)) {
            $info = array(
                'estado' => true,
                'id' => $id,
                'rut' => $rut,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'perfil' => $perfil
            );
        } else {
            $info = array(
                'estado' => false,
                'mensaje' => "<div class='alert alert-dark h5'>NO SE HA REGISTRADO USUARIOS CON ESERUT</div>"
            );
        }
        return json_encode($info);
    }

    public function guardar()
    {
        //CRESCATAMOS LOS PARAMETROS RECIBIDOS IDENTIFICANDO SI LA FILA EXISTE
        $data = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();
        //SENTENCIA SQL PARA VERIFICAR SI EZITE
        $sqlCuantos = "SELECT COUNT(usuario.id) AS 'cuantos' FROM usuario WHERE usuario.correo=?";
        $consultaCuantos = $this->prepare($sqlCuantos);
        $correoUnico = $data['correo'];
        $consultaCuantos->bind_param('s', $correoUnico);
        $consultaCuantos->execute();
        //CON EL METODO BLIND ENLAZAMOS LAS VARIABLES DEL '?' Y DEFINIMOS SU TIPO
        $consultaCuantos->bind_result($cuantosResultado);
        $consultaCuantos->fetch();
        $consultaCuantos->close();
        // INSERTAMOS NUEVO REGISTRO
        if ($cuantosResultado == 0) {

            //INGRESAMOS LAS CONSULTAS PREPARADAS PARA EL INGRESO DE UN NUEVO USUARIO 
            $sqlIngresar = "INSERT INTO usuario(rut, nombre, apellido, correo, pass, Perfil)
                            VALUES (?,?,?,?,?,?);";
            $ingresarUser = $this->prepare($sqlIngresar);
            $rut = utf8_decode($data['rut']);
            $nombre = utf8_decode($data['nombre']);
            $apellido = utf8_decode($data['apellido']);
            $correo = utf8_decode($data['correo']);
            $pass = utf8_decode($data['pass']);
            $perfil = utf8_decode($data['perfil']);
            $ingresarUser->bind_param('ssssss', $rut, $nombre, $apellido, $correo, $pass, $perfil);
            $ingresarUser->execute();
            $ingresarUser->close();

            //RESCATAMOS EL ULTIMO ID INGRESADO PARA REENVIARLO HACIA LA VISTA
            $sqlUltimo = "SELECT MAX(id) AS 'ultimo' FROM usuario;";
            $consultaUltimo = $this->prepare($sqlUltimo);
            $consultaUltimo->execute();
            $consultaUltimo->bind_result($ultimo);
            $consultaUltimo->fetch();
            $ingresarUser->close();

            //CREAMOS EL ARREGLO DEL METODO  
            $info = array(
                'estado' => true,
                'mensaje' => "<div class='alert alert-primary h5'>USUARIO AGREGADO CORRECTAMENTE</div>",
                //SE CREA LA VARIABLE DEL ULTIMO ID INGRESADO 
                'ultimo' => $ultimo
            );
        } else {
            $info = array(
                'estado' => false
            );
        }
        return json_encode($info);
    }

    public function modificar()
    {
        //CRESCATAMOS LOS PARAMETROS RECIBIDOS IDENTIFICANDO SI LA FILA EXISTE
        $data = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();

        //SENTENCIA SQL PARA VERIFICAR SI EZITE
        $sqlCuantos = "SELECT COUNT(usuario.id) AS 'cuantos' FROM usuario WHERE usuario.correo=?";

        $consultaCuantos = $this->prepare($sqlCuantos);
        $correoUnico = $data['correo'];

        $consultaCuantos->bind_param('s', $correoUnico);
        $consultaCuantos->execute();
        //CON EL METODO BLIND ENLAZAMOS LAS VARIABLES DEL '?' Y DEFINIMOS SU TIPO
        $consultaCuantos->bind_result($cuantosResultado);
        $consultaCuantos->fetch();
        $consultaCuantos->close();


        // INSERTAMOS NUEVO REGISTRO
        if ($cuantosResultado != 0) {
            //INGRESAMOS LAS CONSULTAS PREPARADAS PARA EL INGRESO DE UN NUEVO USUARIO 
            $sqlModificar = "UPDATE usuario SET nombre = ?, apellido = ?, pass = ?, perfil = ? WHERE usuario.id = ?;";
            $ModificarUser = $this->prepare($sqlModificar);

            $id = $data['idH'];
            $nombre = utf8_decode($data['nombre']);
            $apellido = utf8_decode($data['apellido']);
            $pass = utf8_decode($data['pass']);
            $perfil = utf8_decode($data['perfil']);

            $ModificarUser->bind_param('ssssi', $nombre, $apellido, $pass, $perfil, $id);
            $ModificarUser->execute();
            $ModificarUser->close();
            //CREAMOS EL ARREGLO DEL METODO  
            $info = array(
                'estado' => true,
                'mensaje' => "<div class='alert alert-primary h5'>USUARIO MODIFICADO CORRECTAMENTE</div>",
                'id' => $id

            );
        } else {
            $info = array(
                'estado' => false,
                'mensaje' => "<div class='alert alert-primary h5'>ERRORV AL MODIFICAR USUARIO</div>"
            );
        }
        return json_encode($info);
    }

    public function buscar()
    {
    }       

    public function eliminar()
    {
    }
}

//CREAMOS NUESTRO NUEVO OBJETO
$usuario = new Usuario;
