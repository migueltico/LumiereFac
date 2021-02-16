<div class="hoja">

    <h1 style="text-align: center;">Reporte de Ventas Diario</h1>
    <table width="100%" cellpadding="2px" cellspacing="2px">
        <thead style="border: 2px solid black;">
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
                <tr class="">
                    <td scope="row" style="text-align: left;"><?= $rows["fecha"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $rows["cantidad"] ?></td>
                    <td scope="row" style="text-align: left;"><?= number_format($rows["total_efectivo"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: left;"><?= number_format($rows["total_tarjeta"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: left;"><?= number_format($rows["total_transferencia"], 2, ".", ",") ?></td>
                    <td scope="row" style="text-align: left;"><?= number_format($rows["total_diario"], 2, ".", ",") ?></td>

                </tr>
            <?php endforeach; ?>
            <tr class=" btn-success" style="background:#aaa !important;font-size:1.2rem">
                <td scope="row" style="text-align: left;font-weight:600">Totales</td>
                <td scope="row" style="text-align: center;font-weight:600"><?= number_format($cant, 0, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_efectivo, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_tarjeta, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_transferencia, 2, ".", ",") ?></td>
                <td scope="row" style="text-align: left;font-weight:600"><?= number_format($total_diario, 2, ".", ",") ?></td>
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