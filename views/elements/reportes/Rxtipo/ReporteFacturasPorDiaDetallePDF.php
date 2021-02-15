<style>
    table tbody tr {
        border-bottom: 1px solid black;
    }

    tr:nth-child(3n) {
        background-color: #f5f5f5 !important;
        color: black;
    }

    td {
        font-size: 0.85rem;
    }

    th {
        font-size: 1rem;
    }
</style>
<table class="table sort" id="sortable" style="width: 100%;margin-top:2rem">
    <thead style="border: 1px solid black;">

        <tr>
            <th data-type="1" data-inner="0" scope="col" style="text-align: center;">#Doc.</th>
            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Doc.</th>
            <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Tipo Trans.</th>
            <!-- <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Tipo Pago <span style="font-size:0.6rem"> (1=Efectivo, 2= Tarjeta, 3= Transferencia)</span></th> -->
            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Efectivo</th>
            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Tarjetas</th>
            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Transf.</th>
            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Total</th>
        </tr>
    </thead>

    <tbody data-sorts="DESC">
        <?php foreach ($data as $rows) : ?>



            <?php
            $total_efectivo = 0;
            $total_tarjeta = 0;
            $total_transferencia = 0;
            $total_diario = 0;
            $total_diarioRow = 0;
            $total = 0;
            $firtCount = false;
            ?>
            <tr class="TrRow"  style="background:#ccc">
                <td scope="row" style="text-align: left;">#CAJA: <?= $rows['rows'][0]["caja"] ?></td>
                <td colspan="1" scope="row" style="text-align: left;"></td>
                <td scope="row" style="text-align: left;">FECHA: <?= $rows['rows'][0]['fecha'] ?></td>
                <td colspan="4" scope="row" style="text-align: left;"></td>
            </tr>
            <?php foreach ($rows['rows'] as $rows) : ?>
                <?php
                $total_efectivo += $rows["efectivo"];
                $total_tarjeta += $rows["tarjeta"];
                $total_transferencia += $rows["transferencia"];
                $total_diario += $total_efectivo + $total_transferencia + $total_transferencia;
                $total =  ($rows["efectivo"] + $rows["tarjeta"] + $rows["transferencia"]);
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
                <?php if ($firtCount) :  ?>
                    <tr class="TrRow">
                        <td scope="row" style="text-align: left;"><?= $rows["caja"] ?></td>
                        <td scope="row" style="text-align: left;">a</td>
                        <td scope="row" style="text-align: left;">b</td>
                        <td scope="row" style="text-align: left;">c</td>
                        <td scope="row" style="text-align: left;">d</td>
                        <td scope="row" style="text-align: left;">e</td>
                        <td scope="row" style="text-align: left;"><?= $rows['fecha'] ?></td>
                    </tr>
                    <?php
                    $firtCount = false;
                    ?>
                <?php endif; ?>
                <tr class="TrRow">

                    <td scope="row" style="text-align: left;"><?= $rows["docNum"] ?></td>
                    <td scope="row" style="text-align: center;text-transform: lowercase;"><?= $rows["doc"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $rows["tipoDoc"] ?></td>
                    <!-- <td scope="row" style="text-align: center;"><?php //$tipoPago == "" ? "Sin abono" : $tipoPago 
                                                                        ?></td> -->
                    <td scope="row" data-value="<?= $rows["efectivo"] ?>" style="text-align: left;"><?= number_format($rows["efectivo"], 2, ".", ",") ?></td>
                    <td scope="row" data-value="<?= $rows["tarjeta"] ?>" style="text-align: left;"><?= number_format($rows["tarjeta"], 2, ".", ",") ?></td>
                    <td scope="row" data-value="<?= $rows["transferencia"] ?>" style="text-align: left;"><?= number_format($rows["transferencia"], 2, ".", ",") ?></td>
                    <td scope="row" data-value="<?= $total ?>" style="text-align: center;"><?= number_format($total, 2, ".", ",") ?></td>

                </tr>
            <?php endforeach; ?>


        <?php endforeach; ?>
    </tbody>
    <tfoot style="border: 1px solid black;">
        <tr class="TrRow btn-success" style="background:#ccc">
            <td scope="row" style="text-align: left;font-weight:600">Totales</td>
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