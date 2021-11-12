<?php
session_start();
if (empty($_SESSION)) {
    header('location: index.html');
}

include('recursos/clases/UsuarioCs.php');
include('plantilla/menu.php');
include('plantilla/header.php');

if (isset($_GET['id'])) {
    $params = array(
        'codigo'=>$_GET['id']
    ); 

    $user = json_decode($usuario->cargar($params),true);
    if ($user['estado']==true) {
        $id = $user['id'];
        $nombre = $user['nombre'];
        $apellido = $user['apellido'];
        $perfil = $user['perfil'];
        if ($user['foto']=="") {
            $foto = "perfil.jpg";
        }else{
            $foto = $user['foto'];
        }

    }else{
        $id = "";
        $nombre =  "";
        $apellido =  "";
        $perfil =  "";
        $foto = "perfil.jpg";
    }
}else{
    $id = "";
    $nombre =  "";
    $apellido =  "";
    $perfil =  "";
    $foto = "perfil.jpg";
}


?>
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <form action="recursos/funciones/usuarios_fx.php" method="post" enctype="multipart/form-data">
            <div class="card shadow-lg ">
                <div class="card-header h5">Usuario: <?php echo $nombre." ".$apellido; ?></div>
                <div class="card-body align-self-center">
                    <img class="img-fluid "  src="img/<?php echo $foto; ?>" alt="<?php echo $nombre; ?>">
                    <input type="hidden" name="idH" value="<?php echo $id; ?>">

                </div>
                <div class="card-footer col-8">
                    <div class="custom-file">
                        <input class="custom-file-input"type="file" name="foto" id="foto">
                        <label class="custom-file-label" for="foto">Click para buscar foto</label>
                    </div>
                    <div class="col-4 mt-2">
                        <input class="btn btn-danger " name="btnGuardar_foto" 
                               type="submit" value="Guardar Foto">
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>