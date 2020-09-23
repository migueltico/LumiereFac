<div class="table-responsive">
    <table class="table sort" id="sortable">
        <thead>
            <tr>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: feft;">Nombre</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Cedula</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Telefono</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Email</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Direccion</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: left;">Accion</th>
            </tr>
        </thead>
        <tbody data-sorts="DESC">
            <?php
            $gravado = array("noGravado", "gravado");
            $estado = array("inhabilitado", "habilitado");
            ?>
            <?php foreach ($clientes as $cliente) : ?>
                <tr class="TrRow">
                    <?php
                    $direccion = $cliente["direccion"];
                    if (strpos($direccion, ';')) {
                        $direccion = explode(";", $cliente["direccion"]);
                        $direccion = $direccion[0] . " " . $direccion[1];
                    }

                    ?>
                    <td scope="row" style="text-align: center;"><?= $cliente["idcliente"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $cliente["nombre"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $cliente["cedula"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $cliente["telefono"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $cliente["email"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $direccion ?></td>
                    <td scope="row">
                        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                            <button type="button" class="btn btn-success clientes_EditBtn" data-toggle="modal" data-target="#clientes_EditModal" data-id='<?= $cliente["idcliente"] ?>'><?= $icons['edit'] ?></button>
                            <button type="button" class="btn btn-danger clientes_deleteBtn" data-id='<?= $cliente["idcliente"] ?>'><?= $icons['trash'] ?></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>