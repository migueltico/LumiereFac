<div class="hoja">
    <h1 style="text-align: center;">Reporte de facturas por cliente</h1>
    <table width="100%" cellpadding="2px" cellspacing="2px">
        <thead style="border: 2px black;border-style: double;">

            <tr>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Fecha</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Factura</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Nombre</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Telefono</th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: left;">Total</th>
            </tr>
        </thead>

        <tbody data-sorts="DESC">
            <?php
            $cant = 0;
            $total = 0;
            ?>
            <?php foreach ($ventasRows as $rows) : ?>
                <?php
                $cant++;
                $total += $rows["total"];
                ?>
                <tr class="TrRow">
                    <td scope="row" style="text-align: center;"><?= $rows["fecha"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $rows["factura"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $rows["nombre"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $rows["telefono"] ?></td>
                    <td scope="row" data-value="<?= $rows["total"] ?>" style="text-align: left;"><?= number_format($rows["total"], 2, ".", ",") ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="TrRow" style="background:#aaa !important;font-size:1.2rem">
                <td scope="row" colspan="4" style="text-align: center;"></td>
                <td scope="row" style="text-align: left;">Total: <?= number_format($total, 2, ".", ",") ?></td>
            </tr>
        </tfoot>
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