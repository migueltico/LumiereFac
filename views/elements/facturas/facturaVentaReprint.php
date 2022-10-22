<div class="hoja">
    <?php
    $info = $Sucursal;
    $hoy = date("Y-m-d H:i:s");
    $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
    $HasDescuento = false;
    $HasIva = false;
    $hasPay = 1;
    $hasSaldo = 0;
    $wasPayTarjeta = true;
    ?>
    <div class="row col">
        <h4 class='col-12 text-center mt-2'><?= $info['nombre_local'] ?></h4>
        <p class="col-12 text-center colFac" style="font-size: 1.1rem;"><?= $info['razon_social'] ?> </p>
        <p class="col-12 text-center colFac" style="font-size: 1.1rem;"><?= $info['direccion'] ?></p>
        <p class="col-12 text-center colFac" style="font-size: 1.1rem;"><?= $info['telefono'] ?></p>
    </div>
    <div class="row col mt-2>
        <p class=" col-12 text-left colFac" style="font-size: 1.1rem;">Cliente: <?= $nameCliente ?> </p>
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Cajero: <?= $nameVendedor ?> </p>
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Tipo Doc: Tiquete </p>
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Fac:&nbsp; <?= $factura['fac'] ?> &nbsp;&nbsp;&nbsp;&nbsp;<?= $fecha ?> </p>
    </div>
    <br>
    <div class="row col">
        <p class="col-12 text-left colFac" style="font-size: 1rem;">**********************************************************************</p>
    </div>
    <br>
    <div class="row col">
        <div class="colFac col-1">
            <span class="text-center">Cant.</span>
        </div>
        <div class="colFac col-7">
            <span class="text-right">&nbsp;&nbsp;Descripcion</span>
        </div>
        <div class="colFac col-2">
            <span class="text-left">P. Unidad</span>
        </div>
        <div class="colFac col-2">
            <span class="text-right">&nbsp;&nbsp;M.Total</span>
        </div>
    </div>
    <br>
    <?php foreach ($items as $key => $item) : ?>
        <div class="row col pb-1">

            <?php $desc = explode(" | ", $item['descripcion']) ?>
            <div class="col-1 colFac center">
                <span class="text-center"><?= $item['cantidad'] ?></span>
            </div>
            <div class="colFac col-7">
                <span class="text-left"><?= strtoupper($desc[0]) ?> (<?= strtoupper($item['talla']) ?>)</span>
            </div>
            <div class="col-2 colFac ">
                <?php if ($wasPayTarjeta && $GLOBALS["DB_NAME"][$_SESSION['db']] != 'maindb') :  ?>
                    <?php
                    //remove ',' from price
                    $newPrice  = str_replace(',', '', $item['precio']);
                    //reduce price by 13%
                    $newPrice  = $newPrice / 1.13;
                    //number format
                    $newPrice  = number_format($newPrice, 2, '.', ',');

                    ?>
                    <span><?= $newPrice ?></span>
                <?php else : ?>
                    <span><?= $item['precio'] ?></span>
                <?php endif; ?>
            </div>
            <div class="colFac col-2 text-right">
                <span class="text-right"><?= number_format($item['total_iva'], '2', '.', ',')   ?></span>
            </div>
            <!-- NEXT ROW -->
            <div class="col-1 colFac">
            </div>
            <?php if ($item['descuento'] != 0) : ?>
                <div class="colFac col-3">
                    <?php $HasDescuento = true; ?>
                    <span>DESC <?= strtoupper($item['descuento']) ?>%</span>
                </div>
            <?php endif; ?>
            <?php if ($item['descuento'] != 0) : ?>
                <?php if ($wasPayTarjeta && $GLOBALS["DB_NAME"][$_SESSION['db']] != 'maindb') :  ?>
                    <?php
                    //remove ',' from price
                    $newPrice  = str_replace(',', '', $item['subtotal']);
                    //reduce price by 13%
                    $newPrice  = $newPrice / 1.13;
                    //number format
                    $newPrice  = number_format($newPrice, 2, '.', ',');

                    ?>
                    <div class="colFac col-4 text-left">
                        <span class="text-right">SUB T. <?= $newPrice ?></span>
                    </div>
                <?php else : ?>
                    <div class="colFac col-4 text-left">
                        <span class="text-right">SUB T. <?= $item['subtotal'] ?></span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($item['iva'] != 0 || ($wasPayTarjeta && $GLOBALS["DB_NAME"][$_SESSION['db']] != 'maindb')) : ?>
                <?php $HasIva = true; ?>
                <div class="col-2 colFac">
                    <?php if ($wasPayTarjeta && $GLOBALS["DB_NAME"][$_SESSION['db']] != 'maindb') :  ?>
                        <span>IVA:13%</span>
                    <?php else : ?>
                        <span>IVA:<?= $item['iva'] ?>%</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="col-1 colFac">
            </div>
            <div class="col-12 colFac">
                <div style="margin-left:8%;font-size: 13px !important; width:100%"><?= $generator->getBarcode($item['cod'], $generator::TYPE_CODE_128, 2, 14); ?></div>
                <div style="margin-left:9%;margin-bottom:3px;font-size: 13px !important; width:100%">**<?= $item['cod'] ?>**</div>
            </div>
            <!-- NEXT ROW -->
        </div>
    <?php endforeach; ?>
    <div class="row col">
        <p class="col-12 text-left colFac" style="font-size: 1rem;">**********************************************************************</p>
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Cant. Art: <?= $cantidadArticulos ?> </p>
    </div>
    <div class="row col">
        <?php if ($HasDescuento) : ?>
            <div class="col-9 text-right" style="font-size: 1.1rem;">DESC: </div>
            <div class="col-3 text-left " style="font-size: 1.1rem;"><?= number_format($descuento, 2, '.', ',') ?> </div>
        <?php endif;  ?>
        <?php if ($wasPayTarjeta && $GLOBALS["DB_NAME"][$_SESSION['db']] != 'maindb') :  ?>
            <?php
            //remove ',' from price
            $newPrice  = str_replace(',', '', $subtotal_descuento);
            //reduce price by 13%
            $newPrice  = $newPrice / 1.13;
            //number format
            $newPrice  = number_format($newPrice, 2, '.', ',');

            ?>
            <div class="col-9 text-right" style="font-size: 1.1rem;">SUBTOTAL: </div>
            <div class="col-3 text-left " style="font-size: 1.1rem;"><?= $newPrice  ?> </div>
        <?php else : ?>
            <div class="col-9 text-right" style="font-size: 1.1rem;">SUBTOTAL: </div>
            <div class="col-3 text-left " style="font-size: 1.1rem;"><?= number_format($subtotal_descuento, 2, '.', ',')   ?> </div>
        <?php endif; ?>
        <?php if ($HasIva) : ?>
            <?php if ($wasPayTarjeta && $GLOBALS["DB_NAME"][$_SESSION['db']] != 'maindb') :  ?>
                <div class="col-9 text-right" style="font-size: 1.1rem;">I.V.A: </div>
                <?php
                //remove ',' from price
                if ($tipoVenta == 2) {
                    $newPrice  = str_replace(',', '', $total);
                    $monto_envio  = str_replace(',', '', $monto_envio);
                    //reduce price by 13%
                    $newPriceWithOutEnvio  = ($newPrice - $monto_envio);
                    $ivaAmount  = $newPriceWithOutEnvio - ($newPriceWithOutEnvio / 1.13);
                    //number format
                    $newPrice  = number_format($ivaAmount, 2, '.', ',');
                } else {
                    $newPrice  = str_replace(',', '', $total);
                    $ivaAmount =  $newPrice - ($newPrice / 1.13);
                    //number format
                    $newPrice  = number_format($ivaAmount, 2, '.', ',');
                }
                ?>
                <div class="col-3 text-left " style="font-size: 1.1rem;"><?= $newPrice  ?> </div>
            <?php else : ?>
                <div class="col-9 text-right" style="font-size: 1.1rem;">I.V.A: </div>
                <div class="col-3 text-left " style="font-size: 1.1rem;"><?= $iva ?> </div>
            <?php endif; ?>
        <?php endif;  ?>
        <?php if ($tipoVenta == 2) : ?>
            <div class="col-9 text-right" style="font-size: 1.1rem;">ENVIO: </div>
            <div class="col-3 text-left " style="font-size: 1.1rem;"><?= number_format($monto_envio, 2, '.', ',') ?> </div>
        <?php endif;  ?>
        <div class="col-9 text-right" style="font-size: 1.1rem;">TOTAL A PAGAR: </div>
        <div class="col-3 text-left " style="font-size: 1.1rem;"><?= number_format($total, 2, '.', ',') ?></div>
        <div class="col-12 text-right" style="font-size: 1.1rem;">-----------------------------------------</div>
        <!-- "0" = no pago | "1" Si pago -->
        <?php if ($hasPay == 1) : ?>
            <?php if ($tipoVenta == 1) : ?>
                <?php foreach ($methodPay as $method) : ?>
                    <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= strtoupper($method['methods']['tipo']) . ($method['methods']['tipo'] == "tarjeta" ? "-" . $method['methods']['tarjeta'] : "") ?>:</p>
                    <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= $method['methods']['montoWithFormat'] ?></p>
                    <?php if ($method['methods']['tipo'] == "tarjeta") : ?>
                        <?php if ($method['methods']['hasMore']) : ?>
                            <?php foreach ($method['methods']['extraCards'] as $card) : ?>
                                <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= strtoupper($card['tipo']) . ($card['tipo'] == "tarjeta" ? "-" . $card['tarjeta'] : "") ?>:</p>
                                <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= $card['montoWithFormat'] ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php elseif ($tipoVenta == 2) : ?>
                <?php foreach ($methodPay as $method) : ?>
                    <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= strtoupper($method['methods']['tipo']) . ($method['methods']['tipo'] == "tarjeta" ? "-" . $method['methods']['tarjeta'] : "") ?>:</p>
                    <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= $method['methods']['montoWithFormat'] ?></p>
                    <?php if ($method['methods']['tipo'] == "tarjeta") : ?>
                        <?php if ($method['methods']['hasMore']) : ?>
                            <?php foreach ($method['methods']['extraCards'] as $card) : ?>
                                <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= strtoupper($card['tipo']) . ($card['tipo'] == "tarjeta" ? "-" . $card['tarjeta'] : "") ?>:</p>
                                <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= $card['montoWithFormat'] ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="row col mt-3">
        <p class="col-12 text-center colFac" style="font-size: 1.3rem;"><?= $info['mensaje_footer_fac'] ?></p>
        <p class="col-12 text-center  mt-2" style="font-size: 0.9rem;"><?= $info['mensaje_restricciones'] ?></p>

    </div>
    <div class="row col mt-4 svg_codeFac" style="display: flex;flex-direction: row; justify-content: center; padding: 0 50px">
        <?php echo $generator->getBarcode($factura['fac'], $generator::TYPE_CODE_128, 2, 30); ?>
        <p><?= $factura['fac'] ?></p>
    </div>
</div>


<style>
    .svg_codeFac svg {
        width: 100%;
    }

    .hoja {
        background-color: green;
        background-color: white;
        padding: 15px;
        width: 440px;
        /* width: 407px; */
        font-size: 12px;
        /* width: 445px; */
        font-family: ticketing_regular, cursive;
        position: relative;
    }

    <?php if ($cantidadArticulos > 2) : ?>.hoja::before {
        bottom: 20%;
        left: 0;
        position: absolute;
        content: 'COPY';
        font-size: 10rem;
        transform: rotate(45deg);
        color: rgba(140, 140, 140, 0.4);
    }

    <?php endif; ?>.hoja::after {
        top: 20%;
        left: 0;
        position: absolute;
        content: 'COPY';
        font-size: 10rem;
        transform: rotate(45deg);
        color: rgba(140, 140, 140, 0.4);
    }
</style>