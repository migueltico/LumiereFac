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
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Fac:&nbsp; <?= $factura ?> &nbsp;&nbsp;&nbsp;&nbsp;<?= $hoy ?></p>
        <p class="col-12 text-left colFac" style="font-size: 1.1rem;">Recibo:&nbsp; <?= h::maskFormat('#########', $idrecibo) ?></p>
    </div>
    <br>
    <div class="row col">
        <p class="col-12 text-left colFac" style="font-size: 1rem;">**********************************************************************</p>
    </div>
    <br>
    <div class="row col">
        <?php
        $montoAbono = 0.00;
        $newSaldoAnterior = (float) ($total - ($AbonoTotal - $abono));
        $newSaldo = (float)($newSaldoAnterior - $abono);
        ?>
        <div class="col-9 text-right" style="font-size: 1.1rem;">SALDO ANTERIOR: </div>
        <div class="col-3 text-left " style="font-size: 1.1rem;"><?= number_format($newSaldoAnterior, 2, '.', ',') ?> </div>
        <div class="col-12 text-right" style="font-size: 1.1rem;">---------------------------------------</div>

        <?php foreach ($methods as $method) : ?>
            <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= strtoupper($method['tipo']) . ($method['tipo'] == "tarjeta" ? "-" . $method['tarjeta'] : "") ?>:</p>
            <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= number_format($method['monto'], 2, '.', ',') ?></p>
            <?php if (count($cards) > 0) : ?>
                <?php if ($cards[0] != '') : ?>
                    <?php foreach ($cards as $card) : ?>
                        <?php
                        @$card = explode(',', $card);
                        @$card[1] = (float)  $card[1];
                        ?>
                        <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= strtoupper($card[2]) . ($card[2] == "tarjeta" ? "-" . $card[0] : "") ?>:</p>
                        <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= number_format($card[1], 2, '.', ',') ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php
            $montoAbono += (float)($method['monto']);

            ?>
        <?php endforeach; ?>
        <div class="col-12 text-right" style="font-size: 1.1rem;margin-top:5px;">---------------------------------------</div>
        <p class="col-9 text-right" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;">SALDO PENDIENTE:</p>
        <p class="col-3 text-left" style="font-size: 1.1rem; margin-top:0; margin-bottom:0;"><?= number_format($newSaldo, 2, '.', ',') ?></p>
        <br>
        <?php if ($newSaldo == 0) : ?>
            <p class="col-12 text-center" style="font-size: 1.1rem; margin-top:10px; margin-bottom:10px;">**CANCELADO**</p>
        <?php endif; ?>

    </div>
    <div class="row col mt-3">
        <p class="col-12 text-center colFac" style="font-size: 1rem;">****Cancelar antes del <?= $fecha_final ?>****</p>
        <p class="col-12 text-center  mt-2" style="font-size: 0.9rem;"><?= $info['mensaje_restricciones'] ?></p>

    </div>
    <div class="row col mt-4 svg_codeFac" style="display: flex;flex-direction: row; justify-content: center; padding: 0 50px">
        <?php echo $generator->getBarcode($factura, $generator::TYPE_CODE_128, 2, 30); ?>
        <p><?= $factura ?></p>
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