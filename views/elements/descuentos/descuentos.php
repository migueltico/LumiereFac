<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Descuentos</h4>

        <a href="#" class="btn btn-primary btn-sm" id="newDescuento" data-toggle="tooltip" data-placement="bottom" title="Agregar Nuevo descuento"><?= $icons['plus-circle'] ?>Nuevo</a>
        <a href="#" id="refrescarDescuentos" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar descuentos">Refrescar</a>

    </div>
    <div class="card-body loadTable">
        <div class="table-responsive">
            <table class="table sort" id="sortable">
                <thead>
                    <tr>
                        <th data-type="1" data-inner="0" scope="col" style="text-align: left;">#ID</th>
                        <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Descripcion</th>
                        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">descuento</th>
                        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Ver en Facturacion</th>
                        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Estado</th>
                        <th data-type="1" data-inner="0" scope="col" style="text-align: left;">Accion</th>
                    </tr>
                </thead>
                <tbody data-sorts="DESC">
                    <?php
                    $gravado = array("noGravado", "gravado");
                    $tipo = array("Local", "Envio", "Apartado");
                    $estado = array("inhabilitado", "habilitado");
                    ?>
                    <?php foreach ($data as $desc) : ?>
                        <tr class="TrRow">
                            <td scope="row" style="text-align: left;"><?= $desc["iddescuento"] ?></td>
                            <td scope="row" style="text-align: left;"><?= $desc["descripcion"] ?></td>
                            <td scope="row" style="text-align: center;"><?= $desc["descuento"] ?></td>
                            <td scope="row" data-value="<?= $desc["showFac"] ?>" data-toggle="tooltip" data-placement="top" title="">
                                <div class="<?= $estado[$desc["showFac"] == null ? 0 : $desc["showFac"]] ?>"></div>
                            </td>
                            <td scope="row" data-value="<?= $desc["activo"] ?>" data-toggle="tooltip" data-placement="top" title="">
                                <div class="<?= $estado[$desc["activo"]] ?>"></div>
                            </td>
                            <td scope="row">
                                <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                                    <button type="button" class="btn btn-success EditDescuentoBtn" data-show="<?= $desc["showFac"] ?>" data-id='<?= $desc["iddescuento"] ?>' data-activo="<?= $desc["activo"] ?>" data-descripcion="<?= $desc["descripcion"] ?>" data-descuento="<?= $desc["descuento"] ?>"><?= $icons['edit'] ?></button>
                                    <button type="button" class="btn btn-danger" data-id='<?= $desc["iddescuento"] ?>'><?= $icons['trash'] ?></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php include(self::modal('modalAddDescuento')) ?>
<?php include(self::modal('modalEditDescuento')) ?>