<div class="table-responsive">
    <table class="table sort" id="sortable">
        <thead>
            <tr>
                <th data-type="1" data-inner="0" scope="col" style="text-align: left;"># factura</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Cliente</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Tipo</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Fecha</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Pago Adelantado</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Total</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Estado</th>
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
                    <td scope="row" style="text-align: center;"><?= $tipo[($factura["tipo"] - 1)] ?></td>
                    <td scope="row" style="text-align: center;"><?= $factura["fecha"] ?></td>
                    <td scope="row" data-value="<?= $factura["cancelado"] ?>" data-toggle="tooltip" data-placement="top" title="Se cancelo el monto antes del envio">
                        <div class="<?= $estado[$factura["cancelado"]] ?>"></div>
                    </td>
                    <td scope="row" style="text-align: center;"><?= $factura["total"] ?></td>
                    <td scope="row" data-value="<?= $factura["fac_estado"] ?>" data-toggle="tooltip" data-placement="top" title="">
                        <div class="<?= $estado[$factura["fac_estado"]] ?>"></div>
                    </td>

                    <td scope="row">
                        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                            <button type="button" class="btn btn-success productosPendienteBtn" data-id='<?= $factura["consecutivo"] ?>'><?= $icons['eye'] ?></button>
                            <?php if ($factura["tipo"] == 2) :  ?>
                                <button type="button" class="btn btn-info facturaChangeState" data-id='<?= $factura["consecutivo"] ?>'><?= $icons['check'] ?></button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>