<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="accordion" id="accordionExample">
        <?php
        $gravado = array("noGravado", "gravado");
        $estado = array("inhabilitado", "habilitado");
        //var_dump($facturas);
        //var_dump($_SESSION);
        ?>
        <?php foreach ($facturas as $factura) : ?>
            <?php
            $tipoPago = [];
            $extra_tarjetas = "";
            $tipoPago = implode(",", $tipoPago);

            if ($factura["multipago_string"] != "" || $factura["multipago_string"] != null) {
                $tarjetas_varias = explode(";", $factura["multipago_string"]);
                foreach ($tarjetas_varias as $tarjeta) {
                    $tarjeta = explode(",", $tarjeta);
                    $extra_tarjetas .= ", " . $tarjeta[0];
                }
            }
            ?>
            <div class="card  mb-2 border-bottom border-primary">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-<?= ($factura['tipo'] == 3 ? 'warning' : 'default')  ?> btn-block text-left d-flex justify-content-between" type="button">
                            <span><strong>Fac#:</strong> <?= $factura['consecutivo'] ?></span>
                            <span><strong>Total: <?= $factura['monto_envio'] > 0 ? " - (i.e)" : "" ?>: </strong><?= number_format($factura['total'], 2, '.', ',') ?></span>
                            <span><strong>Envio: </strong><?= number_format($factura['monto_envio'], 2, '.', ',') ?></span>
                            <span><strong>Tipo: </strong><?= ($factura['tipo'] == 1 ? 'Local' : ($factura['tipo'] == 2 ? 'Envio' : "Apartado")) ?></span>
                            <span><?= count($factura['details']) ?> Productos</span>
                            <span><strong>Fecha: </strong><?= $factura['fecha'] ?></span>
                        </button>
                    </h2>
                </div>
                <div id="fac<?= $factura['consecutivo'] ?>" class="">
                    <div class="card-body">
                        <?php
                        $tarjetas = "n/a";
                        $transferencia = "n/a";
                        if ($factura['numero_tarjeta'] != "" || $factura['numero_tarjeta'] != null) {
                            $tarjetas = $factura['numero_tarjeta']  . $extra_tarjetas;
                        }
                        if ($factura['banco_transferencia'] != "" || $factura['banco_transferencia'] != null) {
                            $transferencia =  $factura['banco_transferencia']   . " | " .  $factura['referencia_transferencia'];
                        }
                        ?>
                        <div class="row">
                            <div class="col-3">
                                <p><strong>Cliente:</strong> <?= $factura['cliente']  ?></p>
                                <p><strong>Tarjetas:</strong> <?= $tarjetas  ?></p>
                                <p><strong>Transferencia:</strong> <?=$transferencia  ?></p>
                            </div>
                            <div class="col-3">
                                <p><strong>Descuento:</strong> <?= number_format($factura['descuento'], 2, '.', ',') ?></p>
                                <p><strong>Impuesto:</strong> <?= number_format($factura['impuesto'], 2, '.', ',') ?></p>
                                <p><strong>Saldo:</strong> <?= number_format($factura['saldo'], 2, '.', ',') ?> </p>
                            </div>
                        </div>
                        <div class="alert alert-primary  d-flex justify-content-between" role="alert">
                            <span><strong>Monto Efectivo:</strong> <?= number_format($factura['monto_efectivo'], 2, '.', ',') ?></span>
                            <span><strong>Monto Tarjeta:</strong> <?= number_format(($factura['monto_tarjeta'] + $factura['multipago_total']), 2, '.', ',') ?></span>
                            <span><strong>Monto: transferencia:</strong> <?= number_format($factura['monto_transferencia'], 2, '.', ',') ?></span>
                            <?php if ($factura['tipo'] == 3) : ?>
                                <span><strong>Abonado:</strong> <?= number_format($factura['fullAbono'], 2, '.', ',') ?></span>
                                <?php
                                $pendiente =  ((float) $factura['total'] - (float) $factura['fullAbono']);
                                ?>
                                <span><strong>Pendiente:</strong> <?= number_format($pendiente, 2, '.', ',') ?></span>
                            <?php endif;  ?>
                        </div>
                        <?php if ($factura['tipo'] == 3) : ?>
                            <h4>Recibos por Apartado</h4>
                            <div class="table-responsive border border-primary mb-2">
                                <table class="table sort" id="sortable">
                                    <thead>
                                        <tr>
                                            <th data-type="1" data-inner="0" scope="col" style="text-align: left;">#ID recibo</th>
                                            <th data-type="1" data-inner="0" scope="col" style="text-align: left;">#Factura</th>
                                            <th data-type="1" data-inner="0" scope="col" style="text-align: left;">Efectivo</th>
                                            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Tarjeta</th>
                                            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Transferencia</th>
                                            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Fecha</th>
                                            <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Total</th>

                                        </tr>
                                    </thead>
                                    <tbody data-sorts="DESC">
                                        <?php
                                        $gravado = array("noGravado", "gravado");
                                        $estado = array("inhabilitado", "habilitado");
                                        ?>
                                        <?php foreach ($factura['recibos'] as $recibos) : ?>
                                            <?php
                                            $total = $recibos["monto_efectivo"] + $recibos["monto_tarjeta"] + $recibos["monto_transferencia"];
                                            ?>
                                            <tr class="TrRow">
                                                <td scope="row" style="text-align: left;"><?= $recibos["idrecibo"] ?></td>
                                                <td scope="row" style="text-align: left;"><?= $recibos["idfactura"] ?></td>
                                                <td scope="row" style="text-align: left;"><?= number_format($recibos["monto_efectivo"], 2, '.', ',') ?></td>
                                                <td scope="row" style="text-align: left;"><?= number_format(($recibos['monto_tarjeta'] + $recibos['multipago_total']), 2, '.', ',') ?></td>
                                                <td scope="row" style="text-align: left;"><?= number_format($recibos["monto_transferencia"], 2, '.', ',') ?></td>
                                                <td scope="row" style="text-align: left;"><?= $recibos["fechaFormat"]  ?></td>
                                                <td scope="row" style="text-align: left;"><?= number_format($total, 2, '.', ',') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif;  ?>
                        <h4>Productos</h4>
                        <div class="table-responsive border border-warning">
                            <table class="table sort" id="sortable">
                                <thead>
                                    <tr>
                                        <th data-type="1" data-inner="0" scope="col" style="text-align: left;">#Codigo</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Descripcion</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Talla</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Marca</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Estilo</th>
                                        <th data-type="1" data-inner="0" scope="col" style="text-align: left;">Precio</th>
                                        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Cantidad</th>
                                        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Descuento</th>
                                        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">IVA</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Total</th>

                                    </tr>
                                </thead>
                                <tbody data-sorts="DESC">
                                    <?php
                                    $gravado = array("noGravado", "gravado");
                                    $estado = array("inhabilitado", "habilitado");
                                    ?>
                                    <?php foreach ($factura['details'] as $detail) : ?>
                                        <tr class="TrRow">
                                            <td scope="row" style="text-align: left;"><?= $detail["codigo"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= $detail["descripcion"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= $detail["talla"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= $detail["marca"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= $detail["estilo"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= number_format($detail['precio'], 2, '.', ',') ?></td>
                                            <td scope="row" style="text-align: center;"><?= $detail["cantidad"] ?></td>
                                            <td scope="row" style="text-align: center;"><?= $detail["descuento"] > 1 ? $detail['descuento'] : 'N/A' ?></td>
                                            <td scope="row" style="text-align: center;"><?= $detail["iva"] > 1 ? $detail['iva'] : 'N/A' ?></td>
                                            <td scope="row" style="text-align: left;"><?= number_format($detail['total'], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h2 style="text-align: right;">Total: <?= number_format($factura['total'], 2, '.', ',') ?></h2>
        <?php endforeach; ?>
    </div>
</div>