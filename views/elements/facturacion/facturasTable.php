<div class="table-responsive">
    <table class="table sort" id="sortable">
        <thead>
            <tr>
                <th data-type="1" data-inner="0" scope="col" style="text-align: left;"># factura</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Cliente</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Tipo</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Fecha</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Estado</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Total</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: left;">Accion</th>
            </tr>
        </thead>
        <tbody data-sorts="DESC">
            <?php
            $gravado = array("noGravado", "gravado");
            $tipo = array("Local", "Envio", "Apartado");
            $estado = array("inhabilitado", "habilitado");
            ?>
            <?php foreach ($facturas as $factura) : ?>
                <tr class="TrRow">
                    <td scope="row" style="text-align: left;"><?= $factura["consecutivo"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $factura["nombre"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $tipo[($factura["tipo"]-1)] ?></td>
                    <td scope="row" style="text-align: center;"><?= $factura["fecha"] ?></td>
                    <td scope="row" data-value="<?= $factura["fac_estado"] ?>" data-toggle="tooltip" data-placement="top" title="">
                        <div class="<?= $estado[$factura["fac_estado"]] ?>"></div>
                    </td>
                    <td scope="row" style="text-align: center;"><?= $factura["total"] ?></td>
                    <td scope="row">
                        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                            <button type="button" class="btn btn-success facturas_EditBtn" data-toggle="modal" data-target="#facturas_EditModal" data-id='<?= $factura["idfactura"] ?>'><?= $icons['edit'] ?></button>
                            <button type="button" class="btn btn-danger facturas_deleteBtn" data-id='<?= $factura["idfactura"] ?>'><?= $icons['trash'] ?></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>