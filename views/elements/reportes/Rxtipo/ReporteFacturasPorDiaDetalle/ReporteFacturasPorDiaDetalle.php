<style>
    table tbody tr {
        border-bottom: 1px solid black;
    }

    tr:nth-child(3n) {
        background-color: #f5f5f5;
        color: black;
    }

    div.table-responsive .table tbody tr.onHover:hover {
        background-color: #2780e3 !important;
        color: black;
    }

    table {
        border-collapse: collapse;
    }
</style>
<div class="table-responsive">


    <table class="table" id="sortable" style="width: 100%;margin-top:2rem">
        <thead>

            <tr>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">#Doc.</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Fecha.</th>
                <th data-type="0" data-inner="1" scope="col" style="text-align: left;">Doc.</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Tipo Trans.</th>
                <!-- <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Tipo Pago <span style="font-size:0.6rem"> (1=Efectivo, 2= Tarjeta, 3= Transferencia)</span></th> -->
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Efectivo</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Tarjetas</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Transf.</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Total</th>
            </tr>
        </thead>

        <tbody data-sorts="DESC">
            <?php
            $total_efectivo = 0;
            $total_tarjeta = 0;
            $total_transferencia = 0;
            $total_diario = 0;

            $total = 0;
            $firtCount = false;
            ?>
            <?php foreach ($data as $rows) : ?>




                <tr class="TrRow bg-primary onHover" style="color:white;">
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
                    $total_tarjeta += $rows["tarjeta"];
                    $total_transferencia += $rows["transferencia"];
                    $total_efectivoRow += $rows["efectivo"];
                    $total_tarjetaRow += $rows["tarjeta"];
                    $total_transferenciaRow += $rows["transferencia"];

                    $total_diario += $rows["total"];
                    $total =  ($rows["total"]);
                    $total_diarioRow += $total;
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

                    <tr class="TrRow">

                        <td scope="row" data-value="<?= $rows["docNum"] ?>"  style="text-align: left;"><?= $rows["docNum"] ?></td>
                        <td scope="row" data-value="<?= $rows["fecha"] ?>"  style="text-align: left;"><?= $rows["fecha"] ?></td>
                        <td scope="row" data-value="<?= $rows["doc"] ?>"  style="text-align: left;text-transform:capitalize;"><?= strtolower($rows["doc"]) ?></td>
                        <td scope="row" data-value="<?= $rows["tipoDoc"]  ?>"  style="text-align: left;"><?= $rows["tipoDoc"] ?></td>
                        <td scope="row" data-value="<?= $rows["efectivo"] ?>" style="text-align: left;"><?= number_format($rows["efectivo"], 2, ".", ",") ?></td>
                        <td scope="row" data-value="<?= $rows["tarjeta"] ?>" style="text-align: left;"><?= number_format($rows["tarjeta"], 2, ".", ",") ?></td>
                        <td scope="row" data-value="<?= $rows["transferencia"] ?>" style="text-align: left;"><?= number_format($rows["transferencia"], 2, ".", ",") ?></td>
                        <td scope="row" data-value="<?= $total ?>" style="text-align: left;"><?= number_format($total, 2, ".", ",") ?></td>

                    </tr>
                <?php endforeach; ?>
                <tr class="TrRow" style="background:#ddd !important">
                    <td colspan="4" scope="row" style="text-align: left;font-weight:600">Totales</td>
                    <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_efectivoRow, 2, ".", ",") ?> </td>
                    <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_tarjetaRow, 2, ".", ",") ?> </td>
                    <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_transferenciaRow, 2, ".", ",") ?> </td>
                    <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_diarioRow, 2, ".", ",") ?> </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot style="border: 1px solid black;">
            <tr class="TrRow btn-success" style="background:#aaa">
                <td scope="row" style="text-align: left;font-weight:600">Gran Total</td>
                <td scope="row" style="text-align: left;font-weight:600"></td>
                <td scope="row" style="text-align: left;font-weight:600"></td>
                <td scope="row" style="text-align: left;font-weight:600"></td>
                <!-- <td scope="row" style="text-align: left;font-weight:600"></td> -->
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_efectivo, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_tarjeta, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_transferencia, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_diario, 2, ".", ",") ?></td>
            </tr>
        </tfoot>
    </table>
</div>