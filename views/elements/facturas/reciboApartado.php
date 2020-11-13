<div class="hoja">
    <?php

    use config\helper as h;

    $info = $data['data'];
    $hoy = date("Y-m-d H:i:s");
    $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
    $HasDescuento = false;
    $HasIva = false;
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
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Tipo Doc: recibo </p>
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Fac:&nbsp; <?= $factura['fac'] ?> &nbsp;&nbsp;&nbsp;&nbsp;<?= $hoy ?></p>
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Recibo:&nbsp; <?= h::maskFormat('#########', $idrecibo) ?></p>
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
                <span class="text-left"><?= strtoupper($desc[0]) ?></span>
            </div>
            <div class="col-2 colFac ">
                <span><?= $item['precio'] ?></span>
            </div>
            <div class="colFac col-2 text-right">
                <span class="text-right"><?= $item['total_iva'] ?></span>
            </div>
            <div class="col-1 colFac">
            </div>
            <?php if ($item['descuento'] !== 0) : ?>
                <div class="colFac col-3">
                    <?php $HasDescuento = true; ?>
                    <span>DESC% <?= strtoupper($item['descuento']) ?></span>
                </div>
            <?php endif; ?>
            <?php if ($item['descuento'] !== 0) : ?>
                <div class="colFac col-4 text-left">
                    <span class="text-right">SUB T.% <?= $item['subtotal'] ?></span>
                </div>
            <?php endif; ?>
            <?php if ($item['iva'] !== 0) : ?>
                <?php $HasIva = true; ?>
                <div class="col-2 colFac">
                    <span>IVA:<?= $item['iva'] ?>%</span>
                </div>
            <?php endif; ?>


        </div>
    <?php endforeach; ?>
    <div class="row col">
        <p class="col-12 text-left colFac" style="font-size: 1rem;">**********************************************************************</p>
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Cant. Art: <?= $cantidadArticulos ?> </p>
    </div>
    <div class="row col">
        <?php if ($HasDescuento) : ?>
            <div class="col-9 text-right" style="font-size: 1.1rem;">DESC%: </div>
            <div class="col-3 text-left " style="font-size: 1.1rem;"><?= $descuento ?> </div>
        <?php endif;  ?>
        <div class="col-9 text-right" style="font-size: 1.1rem;">SUBTOTAL: </div>
        <div class="col-3 text-left " style="font-size: 1.1rem;"><?= $subtotal_descuento ?> </div>
        <?php if ($HasIva) : ?>
            <div class="col-9 text-right" style="font-size: 1.1rem;">I.V.A: </div>
            <div class="col-3 text-left " style="font-size: 1.1rem;"><?= $iva ?> </div>
        <?php endif;  ?>
        <div class="col-9 text-right" style="font-size: 1.1rem;">TOTAL A PAGAR: </div>
        <div class="col-3 text-left " style="font-size: 1.1rem;"><?= $total ?> </div>
        <div class="col-12 text-right" style="font-size: 1.1rem;">---------------------------------------</div>
        <?php
        $montoAbono = 0.00;
        ?>
        <?php foreach ($methodPay as $method) : ?>
            <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= strtoupper($method['methods']['tipo']) . ($method['methods']['tipo'] == "tarjeta" ? "-" . $method['methods']['tarjeta'] : "") ?>:</p>
            <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= $method['methods']['montoWithFormat'] ?></p>
            <?php
            $montoAbono += (float)($method['methods']['monto']);

            ?>
        <?php endforeach; ?>
        <div class="col-12 text-right" style="font-size: 1.1rem;margin-top:5px;">---------------------------------------</div>
        <?php
        $newtotal = str_replace(',', '', $total);
        $newtotal = (float) $newtotal;
        $saldo = ($newtotal - $montoAbono);

        ?>
        <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;">SALDO:</p>
        <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= number_format($saldo, 2, '.', ',') ?></p>
        <br>
        <p class="col-12 text-center" style="font-size: 1.1rem; margin-top:10px; margin-bottom:10px;">**Apartado**</p>

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

<!-- <pre>
    <?php
    //$info = $_SESSION['info'][0];
    // print_r($factura)
    ?>
</pre>  -->
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
    }
</style>