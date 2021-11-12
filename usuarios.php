<?php
session_start();
include('recursos/clases/UsuarioCs.php');
include('plantilla/menu.php');
include('plantilla/header.php');

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = "";
}

if (isset($_GET['id'])) {
    //CARGAR EL FORMULARIO CON LOS REGISTROS DEL ID 
    $codigo = $_GET['id'];
    $params = array(
        'codigo' => $codigo
    );

    $user = json_decode($usuario->cargar($params), true);

    //LLENAR LOS DATOS QUE CARGAN AL INGRESAR
    if ($user['estado'] == true) {
        $_SESSION['user'] = $user;
        $id = $_SESSION['user']['id'];
        $rut =  $_SESSION['user']['rut'];
        $nombre = $_SESSION['user']['nombre'];
        $apellido = $_SESSION['user']['apellido'];
        $correo = $_SESSION['user']['correo'];
        $perfil = $_SESSION['user']['perfil'];
        $foto = $_SESSION['user']['foto'];
    }
} else {
    // CUANDO LLEGUEN VACIOS
    $id = "";
    $rut = "";
    $nombre = "";
    $apellido = "";
    $correo = "";
    $perfil = "";
    $foto = "";
}

if ($foto=="") {
    $foto = "perfil.jpg";
}

if ($perfil != "") {
    $perfilSelected = "<option disabled selected>" . $perfil . "</option>";
} else {
    $perfilSelected = "";
}
echo $msg;
?>

<form action="recursos/funciones/usuarios_fx.php" method="POST">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="alert alert-primary h5">Mantenedor Usuario</div>
            </div>
            <!--DATOS DEL FORMULARIO-->
            <div class="col-10">
                <div class="row mt-3">
                    <div class="b5-form-group col-3">
                        <label for="rut">Rut</label>
                        <input class="form-control" type="text" id="rut" name="rut"
                                value="<?php echo $rut ;?>">
                        <small id="helpRut" class="text-muted">Ingresar rut sin guion</small>
                    </div>
                    <div class="b5-form-group p-4 mt-2">
                        <p>-</p>
                    </div>
                    <div class="b5-form-group col-2 ml-1">
                        <label for="id">Código:</label>
                        <input disabled type="text" name="id" id="id" value="<?php echo $id; ?>" class="form-control" placeholder="codigo" aria-describedby="helpId">
                        <input type="checkbox" name="" id="">
                        <input type="hidden" name="idH" value="<?php echo $id; ?>">
                        <small id="helpId" class="text-muted">Código de usuario</small>
                    </div>
                    <div class="b5-form-group col-2">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" 
                            value="<?php echo $nombre;?>" class="form-control ">
                        <small id="helpNombre" class="text-muted">Ingrese su nombre:</small>
                    </div>
                    <div class="b5-form-group col-3 ml-3">
                        <label for="apellido">Apellido:</label>
                        <input type="text" name="apellido" id="apellido" 
                            value="<?php echo $apellido;?>" class="form-control">
                        <small id="helpApellido" class="text-muted">Ingrese su nombre apellido</small>
                    </div>
                    <div class="b5-form-group col-3">
                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" id="correo" 
                            value="<?php echo $correo;?>" class="form-control">
                        <small id="helpEmail" class="text-muted">Ingrese su correo:</small>
                    </div>
                    <div class="b5-form-group col-2">
                        <label for="pass">Password:</label>
                        <input type="password" name="pass" id="pass" class="form-control " >
                        <small id="helpPass" class="text-muted">Ingrese su contraseña</small>
                    </div>
                    <div class="b5-form-group col-3">
                        <label for="pass2">Repita su Password:</label>
                        <input type="password" name="pass2" id="pass2" class="form-control " >
                        <small id="helpPass2" class="text-muted">Repita su contraseña</small>
                    </div>
                    <div class="b5-form-group col-3">
                        <label for="perfil" class="form-label">Perfil</label>
                        <select class="form-control" name="perfil" id="perfil">
                            <?php echo $perfilSelected;?>
                            <option>Administrador</option>
                            <option>Visita</option>
                            <option>Guia</option>
                        </select>
                        <small id="helpPerfil" class="text-muted">Ingrese su perfil</small>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <!-- IMAGEN DEL MANTENEDOR-->
                <img class="img-fluid" src="img/<?php echo $foto;?>" alt="Imagen del usuario">
                <a  class="btn btn-info btn-block btn-sm"
                    href="fotoUsuario.php?id=<?php echo $id;?>">agregar foto</a>
            </div>
        </div>
        <div class="row mt-3">
            <!-- BOTONES-->
            <div class="col-2">
                <button class="btn btn-success btn-block" name="btnIngresar" id="btnIngresar" type="submit">Ingresar</button>
            </div>
            <div class="col-2">
                <button class="btn btn-info btn-block" name="btnBuscar" id="btnBuscar" type="submit">Buscar</button>
            </div>
            <div class="col-2">
                <button class="btn btn-warning btn-block" name="btnEliminar" id="btnEliminar" type="submit">Eliminar</button>
            </div>
            <div class="col-2">
                <button class="btn btn-danger btn-block" name="btnActualizar" id="btnActualizar" type="submit">Actualizar</button>
            </div>
            <div class="col-2">
                <button class="btn btn-dark btn-block" name="btnLimpiar" id="btnLimpiar" type="reset">Limpiar</button>
            </div>
        </div>
    </div>
</form>
<?php
include('plantilla/footer.php');
?>


