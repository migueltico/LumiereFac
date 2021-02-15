<!-- [2021-02-12] => Array
        (
            [rows] => Array
                (
                    [0] => Array
                        (
                            [docNum] => 1000001164
                            [efectivo] => 5865.00
                            [tarjeta] => 0.00
                            [transferencia] => 0.00
                            [total] => 5865.00
                            [tipoDoc] => Compra
                            [doc] => FAC
                            [t_efectivo] => 1
                            [t_tarjeta] => 0
                            [t_transferencia] => 0
                            [caja] => 96
                            [fecha] => 2021-02-12
                        )

                )

            [fecha] => 2021-02-12
            [caja] => 96
        ) -->
<?php foreach ($data as $rows) : ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Fecha: <?= $rows['fecha'] ?></h5>
            <h6 class="card-subtitle mb-2 text-muted">Caja#: <?= $rows['caja'] ?></h6>
            <div class="table-responsive">
                <table class="table sort" id="sortable">
                    <thead>

                        <tr>
                            <th data-type="1" data-inner="0" scope="col" style="text-align: center;"># Doc</th>
                            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Tipo Doc.</th>
                            <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Tipo Transaccion</th>
                            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Tipo Pago.</th>
                            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Efectivo</th>
                            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Tarjetas</th>
                            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Transferencias</th>
                            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Total</th>
                        </tr>
                    </thead>

                    <tbody data-sorts="DESC">
                        <?php
                        $total_efectivo = 0;
                        $total_tarjeta = 0;
                        $total_transferencia = 0;
                        $total_diario = 0;
                        $total = 0;
                        ?>
                        <?php foreach ($rows['rows'] as $rows) : ?>
                            <?php
                            $total_efectivo += $rows["efectivo"];
                            $total_tarjeta += $rows["tarjeta"];
                            $total_transferencia += $rows["transferencia"];
                            $total =  ($rows["efectivo"] + $rows["tarjeta"] + $rows["transferencia"]);
                            $total_diario += $total;
                            $tipoPago = '';
                            $tipoPago .= $rows["t_efectivo"] == '1' ? "Efectivo " : '';
                            $tipoPago .= $rows["t_tarjeta"] == '1' ? "| Tarjeta ;" : '';
                            $tipoPago .= $rows["t_transferencia"] == '1' ? "| Transferencia" : '';
                            $tipoPago = [];
                            if ($rows["t_efectivo"] == '1') {

                                array_push($tipoPago, "Efectivo");
                            }
                            if ($rows["t_tarjeta"] == '1') {

                                array_push($tipoPago, "Tarjeta");
                            }
                            if ($rows["t_transferencia"] == '1') {

                                array_push($tipoPago, "Transferencia");
                            }
                            $tipoPago = implode(",", $tipoPago);
                            ?>
                            <tr class="TrRow">
                                <td scope="row" style="text-align: center;"><?= $rows["docNum"] ?></td>
                                <td scope="row" style="text-align: center;"><?= $rows["doc"] ?></td>
                                <td scope="row" style="text-align: center;"><?= $rows["tipoDoc"] ?></td>
                                <td scope="row" style="text-align: center;"><?= $tipoPago == "" ? "Sin abono" : $tipoPago ?></td>
                                <td scope="row" data-value="<?= $rows["efectivo"] ?>" style="text-align: center;"><?= number_format($rows["efectivo"], 2, ".", ",") ?></td>
                                <td scope="row" data-value="<?= $rows["tarjeta"] ?>" style="text-align: center;"><?= number_format($rows["tarjeta"], 2, ".", ",") ?></td>
                                <td scope="row" data-value="<?= $rows["transferencia"] ?>" style="text-align: center;"><?= number_format($rows["transferencia"], 2, ".", ",") ?></td>
                                <td scope="row" data-value="<?= $total ?>" style="text-align: center;"><?= number_format($total, 2, ".", ",") ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="TrRow bg-primary" style="color: white;">
                            <td scope="row" style="text-align: center;">Totales</td>
                            <td colspan="3" scope="row" style="text-align: center;"></td>
                            <td scope="row" style="text-align: center;"><?= number_format($total_efectivo, 2, ".", ",") ?></td>
                            <td scope="row" style="text-align: center;"><?= number_format($total_tarjeta, 2, ".", ",") ?></td>
                            <td scope="row" style="text-align: center;"><?= number_format($total_transferencia, 2, ".", ",") ?></td>
                            <td scope="row" style="text-align: center;"><?= number_format($total_diario, 2, ".", ",") ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
<?php endforeach; ?>