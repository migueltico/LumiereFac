<div class="row">
    <div class="col-12">
        <?php $newDate = date("d-M-y", strtotime($fecha));
        $fecha = explode(' ', $fecha);

        ?>
        <div class="card mb-5">
            <div class="card-header">
                <h4>Gastos</h4>
                <a href="#" id="btnSaveGastos" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Guardar Gastos">Guardar Gastos</a>
                <span><?= $nombre ?></span> |
                <span><?= $newDate ?> | <?= $fecha[1] ?></span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div id="inputGroupGastos">
                            <?php

                            $gastoAll = explode(',', $gastos);
                            $totalGastos = 0;
                            $gastos = trim($gastos);
                            //print_r($gastoAll);
                            ?>
                            <?php if ($gastos !== "") :  ?>
                                <?php foreach ($gastoAll as $value) : ?>
                                    <?php

                                    $gasto = explode(':', $value);

                                    if (is_numeric($gasto[1])) {

                                        $totalGastos +=  $gasto[1];
                                    } else {
                                        $totalGastos += 0;
                                    }
                                    ?>

                                    <div class="input-group mb-3 col-lg-12 col-md-12 col-sm-12">
                                        <div class="input-group-prepend tagNameGastos">
                                            <span class="input-group-text gastosLabel" data-toggle="tooltip" data-placement="bottom" title="Doble click para cambiar nombre" id="inputGroup-sizing-default"><?= $gasto[0] ?></span>
                                            <span class="input-group-text">₡</span>
                                        </div>
                                        <input type="text" class="form-control inputGastos" data-name="<?= $gasto[0] ?>" value="<?= number_format($gasto[1], 2, '.', ',') ?>">
                                        <div class="RemoveInputGastos">x</div>
                                    </div>
                                <?php endforeach; ?>
                                

                            <?php endif;  ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                    <h4 class="card-header">Total Gastos:</h4>
                                    <div class="card-body">
                                        <h2 class="card-title" id="totalGastosLabel">₡ <?= number_format($total, 2, '.', ',') ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                                    <h4 class="card-header">Efectivo: <i><?= $mes ?></i></h4>
                                    <div class="card-body">
                                        <h2 class="card-title" id="totalGastosLabel">₡ <?= number_format($efectivo, 2, '.', ',') ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                                    <h4 class="card-header">Tarjeta: <i><?= $mes ?></i></h4>
                                    <div class="card-body">
                                        <h2 class="card-title" id="totalGastosLabel">₡ <?= number_format($tarjeta, 2, '.', ',') ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                                    <h4 class="card-header">Transferencia: <i><?= $mes ?></i></h4>
                                    <div class="card-body">
                                        <h2 class="card-title" id="totalGastosLabel">₡ <?= number_format($transferencia, 2, '.', ',') ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="separator">
                    <hr>

                    <div class="input-group mt-3 mb-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="input-group-prepend">
                            <button class="btn btn-info" type="button" id="addNewLineGasto">Agregar Linea</button>
                        </div>
                        <input type="text" id="txtAddNewLineGasto" class="form-control" placeholder="Ingrese el nombre del Rubro">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>