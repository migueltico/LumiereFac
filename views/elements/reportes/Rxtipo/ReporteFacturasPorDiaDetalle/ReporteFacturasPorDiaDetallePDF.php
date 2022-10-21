<div class="hoja">

    <h1 class="text-center">Reporte de Facturas Diarias - Detalle</h1>
    <table class="">
        <thead style="border: 2px black;border-style: double;">

            <tr>
                <th style="text-align: left;">#Doc.</th>
                <th style="text-align: left;">Fecha.</th>
                <th style="text-align: left;">Doc.</th>
                <th style="text-align: left;">Tipo Trans.</th>
                <!-- <th style="text-align: left;">Tipo Pago <span style="font-size:0.6rem"> (1=Efectivo, 2= Tarjeta, 3= Transferencia)</span></th> -->
                <th style="text-align: left;">Efectivo</th>
                <th style="text-align: left;">Tarjetas</th>
                <th style="text-align: left;">Transf.</th>
                <th style="text-align: left;">Total</th>
            </tr>
        </thead>

        <tbody data-sorts="DESC">
            <?php

            use config\helper as h;

            $total_efectivo = 0;
            $total_tarjeta = 0;
            $total_transferencia = 0;
            $total_diario = 0;

            $total = 0;
            $firtCount = false;
            ?>
            <?php foreach ($data as $rows) : ?>




                <tr class="" style="background:#eee !important;border-bottom:2px solid black">
                    <td scope="row" style="text-align: left;font-weight:600">#Caja: <?= $rows['rows'][0]["caja"] ?></td>
                    <td colspan="1" scope="row" style="text-align: left;"></td>
                    <td colspan="3" scope="row" style="text-align: left;"></td>
                    <td colspan="3" scope="row" style="text-align: left;font-weight:600">Fecha: <?= $rows['rows'][0]['fecha'] ?></td>
                </tr>
                <?php
                $total_diarioRow = 0;
                $total_efectivoRow = 0;
                $total_tarjetaRow = 0;
                $total_transferenciaRow = 0;
                ?>
                <?php foreach ($rows['rows'] as $rows) : ?>
                    <?php
                    $total_efectivo += $rows["efectivo"];
                    $total_tarjeta += (float)$rows["tarjeta"] + (float)$rows["multipago_total"];
                    $total_transferencia += $rows["transferencia"];
                    $total_efectivoRow += $rows["efectivo"];
                    $total_tarjetaRow += $rows["tarjeta"] + $rows["multipago_total"];
                    $total_transferenciaRow += $rows["transferencia"];
                    $total_diario += ((float)$rows["total"] + (float)$rows["multipago_total"]);
                    $total =  ($rows["total"]);
                    $total_diarioRow += $total + (float)$rows["multipago_total"];
                    $tipoPago = [];
                    if ($rows["t_efectivo"] == '1') {

                        array_push($tipoPago, "1");
                    }
                    if ($rows["t_tarjeta"] == '1') {

                        array_push($tipoPago, "2");
                    }
                    if ($rows["t_transferencia"] == '1') {

                        array_push($tipoPago, "3");
                    }
                    $tipoPago = implode(",", $tipoPago);
                    ?>

                    <tr style="border: none;">

                        <td scope="row" style="text-align: left;"><?= h::maskFormat('##########', $rows["docNum"]) ?></td>
                        <td scope="row" style="text-align: left;"><?= $rows["fecha"] ?></td>
                        <td scope="row" style="text-align: left;text-transform:capitalize;"><?= strtolower($rows["doc"]) ?></td>
                        <td scope="row" style="text-align: left;"><?= $rows["tipoDoc"] ?></td>
                        <!-- <td scope="row" style="text-align: center;"><?php //$tipoPago == "" ? "Sin abono" : $tipoPago
                                                                            ?></td> -->
                        <td scope="row" data-value="<?= $rows["efectivo"] ?>" style="text-align: left;">₡<?= number_format($rows["efectivo"], 2, ".", ",") ?></td>
                        <td scope="row" data-value="<?= $rows["tarjeta"] ?>" style="text-align: left;">₡<?= number_format($rows["tarjeta"] + $rows["multipago_total"], 2, ".", ",") ?></td>
                        <td scope="row" data-value="<?= $rows["transferencia"] ?>" style="text-align: left;">₡<?= number_format($rows["transferencia"], 2, ".", ",") ?></td>
                        <td scope="row" data-value="<?= $total + $rows["multipago_total"] ?>" style="text-align: left;">₡<?= number_format($total, 2, ".", ",") ?></td>

                    </tr>
                <?php endforeach; ?>
                <tr class="" style="background:#bbb !important;color:#000;padding:5px">
                    <td colspan="4" scope="row" style="text-align: left;font-weight:600">Totales</td>
                    <td scope="row" style="text-align: left;font-weight:600">₡<?= number_format($total_efectivoRow, 2, ".", ",") ?> </td>
                    <td scope="row" style="text-align: left;font-weight:600">₡<?= number_format($total_tarjetaRow, 2, ".", ",") ?> </td>
                    <td scope="row" style="text-align: left;font-weight:600">₡<?= number_format($total_transferenciaRow, 2, ".", ",") ?> </td>
                    <td scope="row" style="text-align: left;font-weight:600">₡<?= number_format($total_diarioRow, 2, ".", ",") ?> </td>
                </tr>
            <?php endforeach; ?>
            <tr class=" btn-success" style="background:#aaa !important;font-size:1.2rem">
                <td scope="row" style="text-align: left;font-weight:600">Gran Total</td>
                <td scope="row" style="text-align: left;font-weight:600"></td>
                <td scope="row" style="text-align: left;font-weight:600"></td>
                <td scope="row" style="text-align: left;font-weight:600"></td>
                <!-- <td scope="row" style="text-align: left;font-weight:600"></td> -->
                <td scope="row" style="text-align: left;font-weight:600">₡<?= number_format($total_efectivo, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600">₡<?= number_format($total_tarjeta, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600">₡<?= number_format($total_transferencia, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600">₡<?= number_format($total_diario, 2, ".", ",") ?></td>
            </tr>
        </tbody>

    </table>
</div>

<style>
    h1 {
        width: 1100px;
        background: #fff;
        padding: 15px 10px;

    }

    thead tr th {
        padding: 5px 2px;
        font-size: 1.2rem;
    }

    tr {
        background: #fff;
        color: black;
        border: none;
    }

    tr:nth-child(3n) {
        background-color: #f5f5f5 !important;
        color: black;
    }

    td {
        padding: 4px 2px;
        border: none;
    }



    table {
        padding: 15px 10px;
        border-collapse: collapse;
        width: 1100px;
        /* background: #fff !important; */
    }

    .hoja {
        background-color: white;
        width: 1100px;
        min-height: 1589px;
    }
</style>