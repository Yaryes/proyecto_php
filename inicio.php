<?php
session_start();
include('recursos/clases/ConexionCs.php');
include('plantilla/header.php');
include('plantilla/menu.php')
?>

<div class="container mt-5">
    <h3>BIENVENIDO: </h3>
    <h3>PERFIL: </h3>
    <div class="row">
        <div class="col-12">
            <table class="table table-dark table-hocer">
                <thead>
                    <tr>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Apellido </th>
                    <th>Correo</th>
                    <th>Password</th>
                    <th>Perfil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

</div>
<?php
include('plantilla/footer.php');
?>