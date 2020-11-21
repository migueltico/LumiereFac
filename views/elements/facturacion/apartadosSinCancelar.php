<div class="row">
    <div class="col-12">
        <div class="card col-lg-12 col-md-12 col-sm-12 mb-2">
            <div class="card-body">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3>Apartados</h3>
                    <hr>
                    <div class="accordion" id="accordionExample">
                        <?php
                        $gravado = array("noGravado", "gravado");
                        $estado = array("inhabilitado", "habilitado");
                        ?>
                    
                        <?php foreach ($facturas as $factura) : ?>
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-primary btn-block text-left d-flex justify-content-between" type="button" data-toggle="collapse" data-target="#fac<?= $factura['consecutivo'] ?>" aria-expanded="true" aria-controls="collapseOne">
                                            <span><strong>Factura:</strong> <?= $factura['consecutivo'] ?></span>
                                            <span><strong>Caja ID:</strong> <?= $factura['idcaja'] ?></span>
                                            <span><strong>Total Factura<?= $factura['monto_envio'] > 0 ? " + Envio" : "" ?>: </strong><?= number_format($factura['total'], 2, '.', ',') ?></span>
                                            <span><strong>Tipo de venta: </strong><?= ($factura['tipo'] == 1 ? 'Local' : ($factura['tipo'] == 2 ? 'Envio' : "Apartado")) ?></span>
                                            <span><?= count($factura['details']) ?> Productos</span>
                                            <span><strong>Fecha: </strong><?= $factura['fechaFormat'] ?></span>
                                            <span><strong>Fecha Vencimiento: </strong><?= $factura['fecha_final'] ?></span>
                                        </button>
                                    </h2>
                                </div>

                                <div id="fac<?= $factura['consecutivo'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="alert alert-primary  d-flex justify-content-between" role="alert">
                                            <span><strong>Monto Efectivo:</strong> <?= number_format($factura['monto_efectivo'], 2, '.', ',') ?></span>
                                            <span><strong>Monto Tarjeta:</strong> <?= number_format($factura['monto_tarjeta'], 2, '.', ',') ?></span>
                                            <span><strong>Monto: transferencia:</strong> <?= number_format($factura['monto_transferencia'], 2, '.', ',') ?></span>
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
                                                                <td scope="row" style="text-align: left;"><?= number_format($recibos["monto_tarjeta"], 2, '.', ',') ?></td>
                                                                <td scope="row" style="text-align: left;"><?= number_format($recibos["monto_transferencia"], 2, '.', ',') ?></td>
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
                                                        <th data-type="1" data-inner="0" scope="col" style="text-align: left;">#id</th>
                                                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Descripcion</th>
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
                                                            <td scope="row" style="text-align: left;"><?= $detail["idproducto"] ?></td>
                                                            <td scope="row" style="text-align: left;"><?= $detail["descripcion"] ?></td>
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
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>