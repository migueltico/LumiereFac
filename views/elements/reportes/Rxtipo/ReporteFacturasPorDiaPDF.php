<style>
    table tbody tr {
        border-bottom: 1px solid black;
    }
    tr:nth-child(3n) {
        background-color: #f5f5f5!important;
        color: black;
    }
</style>
<h1 style="text-align: center;">Reporte de Ventas Diario</h1>
<div class="table-responsive">
    <table width="100%" cellpadding="2px" cellspacing="2px">
        <thead style="border: 1px solid black;">
            <tr>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Fecha</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Cantidad</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Total Efectivo</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Total Tarjetas</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Total Transferencias</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Total Diario</th>
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
                <tr class="TrRow" style="border-bottom: 1px dashed black;">
                    <td scope="row" style="text-align: left;"><?= $rows["fecha"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $rows["cantidad"] ?></td>
                    <td scope="row" style="text-align: left;"><?= number_format($rows["total_efectivo"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: left;"><?= number_format($rows["total_tarjeta"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: left;"><?= number_format($rows["total_transferencia"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: left;"><?= number_format($rows["total_diario"], 2, ".", ",") ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot style="border: 1px solid black;">
            <tr class="TrRow btn-success" style="background:#ccc">
                <td scope="row" style="text-align: left;font-weight:600">Totales</td>
                <td scope="row" style="text-align: center;font-weight:600"><?= number_format($cant, 0, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_efectivo, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_tarjeta, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_transferencia, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_diario, 2, ".", ",") ?></td>
            </tr>
        </tfoot>
    </table>
</div>
