<div class="table-responsive">
    <table class="table sort" id="sortable">
        <thead>

            <tr>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Fecha</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Cantidad</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Total Efectivo</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Total Tarjetas</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Total Transferencias</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Total Diario</th>
            </tr>
        </thead>
        
        <tbody data-sorts="DESC">
            <?php
            $cant = 0;
            $total_efectivo = 0;
            $total_tarjeta = 0;
            $total_transferencia = 0;
            $total_diario = 0;
            ?>
            <?php foreach ($rowsDiarios as $rows) : ?>
                <?php
                $cant += $rows["cantidad"];
                $total_efectivo += $rows["total_efectivo"];
                $total_tarjeta += $rows["total_tarjeta"];
                $total_transferencia += $rows["total_transferencia"];
                $total_diario += $rows["total_diario"];
                ?>
                <tr class="TrRow">
                    <td scope="row" style="text-align: center;"><?= $rows["fecha"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $rows["cantidad"] ?></td>
                    <td scope="row" style="text-align: center;"><?= number_format($rows["total_efectivo"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: center;"><?= number_format($rows["total_tarjeta"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: center;"><?= number_format($rows["total_transferencia"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: center;"><?= number_format($rows["total_diario"], 2, ".", ",") ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="TrRow btn-success">
                <td scope="row" style="text-align: center;">Totales</td>
                <td scope="row" style="text-align: center;"><?= number_format($cant, 0, ".", ",") ?></td>
                <td scope="row" style="text-align: center;"><?= number_format($total_efectivo, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: center;"><?= number_format($total_tarjeta, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: center;"><?= number_format($total_transferencia, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: center;"><?= number_format($total_diario, 2, ".", ",") ?></td>
            </tr>
        </tfoot>
    </table>
</div>