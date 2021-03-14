<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Nota:</strong> El reporte no incluye ventas por cliente Generico.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="table-responsive">
    <table class="table sort" id="sortable">
        <thead>

            <tr>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Fecha<span class="icon_table"><?=$icons['updown']  ?></span></th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Factura<span class="icon_table"><?=$icons['updown']  ?></span></th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Nombre<span class="icon_table"><?=$icons['updown']  ?></span></th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Telefono<span class="icon_table"><?=$icons['updown']  ?></span></th>
                <th data-type="1" data-inner="1" scope="col" style="text-align: right;">Total<span class="icon_table"><?=$icons['updown']  ?></span></th>
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
                    <td scope="row" data-value="<?= $rows["total"] ?>" style="text-align: right;"><?= number_format($rows["total"], 2, ".", ",") ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="TrRow btn-success">
                <td scope="row" colspan="4" style="text-align: center;"></td>
                <td scope="row" style="text-align: right;">Total: <?= number_format($total, 2, ".", ",") ?></td>
            </tr>
        </tfoot>
    </table>
</div>