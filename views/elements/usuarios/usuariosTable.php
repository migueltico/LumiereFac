<div class="table-responsive">

    <table class="table sort" id="sortable">

        <thead>
            <tr>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Nombre</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Usuario</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Correo</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Telefono</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Direccion</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Estado</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Rol</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Accion</th>
            </tr>
        </thead>
        <tbody data-sorts="DESC">
            <?php
            $estado = array("inhabilitado", "habilitado", "nuevoState");
            ?>
            <?php foreach ($users as $user) : ?>
                <tr class="TrRow">
                    <td scope="row" style="text-align: center;"><?= $user["idusuario"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $user["nombre"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $user["usuario"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $user["email"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $user["telefono"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $user["direccion"] ?></td>
                    <td scope="row" data-value="<?= $user["estado"] ?>" data-toggle="tooltip" data-placement="top" title="" style="text-align: left;">
                        <div class="<?= $estado[$user["estado"]] ?>"></div>
                    </td>
                    <td scope="row" style="text-align: center;"><?= $user["roles"] ?></td>
                    <td scope="row">
                        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                            <button type="button" class="btn btn-success " data-id='<?= $user["idusuario"] ?>'><?= $icons['edit'] ?></button>
                            <?php if ($user["identificador"] != null) : ?>
                                <button type="button" class="btn btn-info seeLinkBtnUser" data-id='<?= $user["idusuario"] ?>'><?= $icons['link'] ?></button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-danger " data-id='<?= $user["idusuario"] ?>'><?= $icons['trash'] ?></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>