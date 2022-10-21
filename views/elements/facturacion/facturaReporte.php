<?php
function calcIva(float $precio, int $iva, bool $hasIva, string $defaultReturn = null)
{
    if ($hasIva) {
        $floatIva   = (float)($iva / 100);
        $floatPrice = (float)(1 + $floatIva);
        $priceWithOutIva = (float) $precio * $floatPrice;
        $result = (float)($priceWithOutIva - $precio);
        return $result;
    } else
        return $defaultReturn == null ? 0 : $defaultReturn;
}
function calcIvaFromTotalAmount(float $total, int $iva, bool $hasIva, float $envio = null)
{
    if ($hasIva) {
        if($envio != null){
            $total = $total - $envio;
        }
        $floatIva   = (float)($iva / 100);
        $floatPrice = (float)(1 + $floatIva);
        $priceWithOutIva = (float) $total / $floatPrice;
        $result = (float)($total - $priceWithOutIva);
        return $result;
    } else
        return $envio == null ? 0 : $envio;
}
function calcPrecioSinIva(float $precio, int $iva, bool $hasIva = true, string $defaultReturn = null)
{
    if ($hasIva) {
        $precioSinIva = $precio / (1 + ($iva / 100));
        $precioSinIva = $precioSinIva;
        return $precioSinIva;
    } else
        return $defaultReturn == null ? 0 : $defaultReturn;
}
function aplicarDescuento(float $precio, int $descuento)
{
    $descuentoReal = $descuento !=  0 ? $precio * ($descuento / 100) : 0;
    $precio = $precio - $descuentoReal;
    return $precio;
}
// {
//     if ($hasIva) {
//         $precio = $precio - calcIva($precio, $iva, $hasIva); 37530   33212.38938053097   4317.61061946903   2464.25 + 1853.36 = 4317.61
//     }
//     return $precio;
// }
?>

<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="accordion" id="accordionExample">
        <?php
        $gravado = array("noGravado", "gravado");
        $estado = array("inhabilitado", "habilitado");
        // echo "<pre>";
        // print_r($facturas);
        // echo "</pre>";
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
            $tarjetaData = $factura['tarjeta'];
            $hasTarjetaIva = $tarjetaData == 1 || $tarjetaData == "1"  ? true : false;
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
                                <p><strong>Transferencia:</strong> <?= $transferencia  ?></p>
                            </div>
                            <div class="col-3">
                                <p><strong>Descuento:</strong> <?= number_format($factura['descuento'], 2, '.', ',') ?></p>
                                <!-- <p><strong>Impuesto:</strong> <?= number_format($factura['impuesto'], 2, '.', ',') ?></p> -->
                                <p><strong>Impuesto:</strong> <?= number_format(calcIvaFromTotalAmount($factura['total'], 13, $hasTarjetaIva, $factura['monto_envio']), 2, '.', ',') ?></p>
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
                                        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Desc %</th>
                                        <th data-type="1" data-inner="0" scope="col" style="text-align: left;">Precio Desc.</th>
                                        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Cant.</th>
                                        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Sub.T</th>
                                        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">IVA</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Total</th>

                                    </tr>
                                </thead>
                                <tbody data-sorts="DESC">
                                    <?php
                                    $gravado = array("noGravado", "gravado");
                                    $estado = array("inhabilitado", "habilitado");
                                    $totalProducts = 0;
                                    $totalIva = 0;
                                    $totalPreDesc = 0;
                                    $totalSubTotalPreciosConDesPorCantidad = 0;
                                    ?>
                                    <?php foreach ($factura['details'] as $detail) : ?>
                                        <?php
                                        $precioSinIvaRow = calcPrecioSinIva($detail['precio'], 13, $hasTarjetaIva);
                                        $finalDescuento  = aplicarDescuento($precioSinIvaRow, $detail['descuento']);
                                        $subTotal = calcIva($finalDescuento * (int)$detail["cantidad"], 13, $hasTarjetaIva, 'N/A');
                                        $subTotalAmount = $finalDescuento * (int)$detail["cantidad"];
                                        $iva = calcIva($finalDescuento * (int)$detail["cantidad"], 13, $hasTarjetaIva, 'IVA');
                                        $totalProducts += $detail['total'];
                                        $totalIva += $iva;
                                        $totalPreDesc += $precioSinIvaRow * (int)$detail["cantidad"];
                                        $totalSubTotalPreciosConDesPorCantidad += $subTotalAmount;

                                        // $finalIvaPrecioProducto = aplicarIva($finalDescuento, $detail['iva']);
                                        ?>
                                        <tr class="TrRow">
                                            <td scope="row" style="text-align: left;"><?= $detail["codigo"] ?></td>
                                            <td scope="row" style="text-align: left;max-width:300px"><?= $detail["descripcion"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= $detail["talla"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= $detail["marca"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= $detail["estilo"] ?></td>
                                            <td scope="row" style="text-align: left;"><?= number_format($precioSinIvaRow, 2, '.', ',') ?></td>
                                            <td scope="row" style="text-align: center;"><?= $detail["descuento"] > 1 ? $detail['descuento'] . "%" : 'N/A' ?></td>
                                            <td scope="row" style="text-align: left;"><?= number_format($finalDescuento, 2, '.', ',') ?></td><!-- Descuento Price Amount -->
                                            <td scope="row" style="text-align: center;"><?= $detail["cantidad"] ?></td>
                                            <td scope="row" style="text-align: center;"><?= number_format($finalDescuento * (int)$detail["cantidad"], 2, '.', ',') ?></td><!-- Sub Total -->
                                            <td scope="row" style="text-align: center;"><?= number_format($subTotal, 2, '.', ',') ?></td><!-- Iva Sub Total -->
                                            <!-- <td scope="row" style="text-align: center;"><?= $detail["iva"] > 1 ? $detail['iva'] : 'N/A' ?></td> -->
                                            <td scope="row" style="text-align: left;"><?= number_format($detail['total'], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Tr with sub total and iva Sub total and Total -->
                                    <tr class="TrRow" style="background: #ddd ;">
                                        <td scope="row" style="text-align: left;"></td>
                                        <td scope="row" style="text-align: left;"></td>
                                        <td scope="row" style="text-align: left;"></td>
                                        <td scope="row" style="text-align: left;"></td>
                                        <td scope="row" style="text-align: left;"></td>
                                        <td scope="row" style="text-align: left;"></td>
                                        <td scope="row" style="text-align: center;"></td>
                                        <td scope="row" style="text-align: center;"></td>
                                        <td scope="row" style="text-align: left;"></td>
                                        <td scope="row" style="text-align: center; font-weight:bold;font-size:1.1rem"><?= number_format($totalSubTotalPreciosConDesPorCantidad, 2, '.', ',') ?></td>
                                        <td scope="row" style="text-align: center; font-weight:bold;font-size:1.1rem"><?= number_format($totalIva, 2, '.', ',') ?></td>
                                        <td scope="row" style="text-align: left; font-weight:bold;font-size:1.1rem"><?= number_format($totalProducts, 2, '.', ',') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h2 style="text-align: right;">Total: <?= number_format($factura['total'], 2, '.', ',') ?></h2>
            <?php if ($factura["monto_envio"] > 0) : ?>
                <h6 style="text-align: right;">*incluye precio por envio.</h6>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
</div>