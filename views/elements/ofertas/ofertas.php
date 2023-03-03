        <div class="col-xl-7 col-lg-7 col-md-8 col-sm-12">
            <div class="card mb-5 shadow ">
                <div class="card-header">
                    <h4>Ofertas</h4>
                    <?php
                    $hasPermissionCreate = array_key_exists("ofertas_modulo", $_SESSION['permisos']);
                    ?>
                    <?php if ($hasPermissionCreate) :  ?>
                        <a href="#" id="btnNewoferta" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ofertas_addOfertas" data-toggle="tooltip" data-placement="bottom" title="Nueva oferta"><?= $icons['plus-circle'] ?>Nueva Oferta</a>
                    <?php endif; ?>
                    <!-- <a href="#" id="refrescarDescuentos" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar descuentos">Refrescar</a> -->

                </div>

                <div class="card-body loadTable">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p><strong>Oferta por factura:</strong> Una oferta puede ser valida una sola vez o varias veces segun la cantidad de productos que incluyan la oferta en la misma factura</p>
                        <p><strong>Productos por oferta:</strong> Cada oferta puede aplicar una cantidad de veces por cada producto de la lista de la oferta o una cantidad limitada por oferta</p>
                    </div>
                    <div class="table-responsive">

                        <table class="table sort" id="sortable">
                            <thead>
                                <tr>
                                    <th data-type="0" data-inner="0" scope="col" style="text-align: left;">ID</th>
                                    <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Nombre Oferta</th>
                                    <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Descuento</th>
                                    <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Oferta por factura</th>
                                    <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Productos por oferta</th>
                                    <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Creada el</th>
                                    <th data-type="0" data-inner="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody data-sorts="DESC">
                                <?php
                                $gravado = array("noGravado", "gravado");
                                $estado = array("inhabilitado", "habilitado");
                                ?>
                                <?php foreach ($data as $oferta) : ?>
                                    <tr class="TrRow" id="oferta_<?= $oferta["idOferta"] ?>">
                                        <td scope="row" style="text-align: left;"><?= $oferta["idOferta"] ?></td>
                                        <td scope="row" style="text-align: left;"><?= $oferta["nombreOferta"] ?></td>
                                        <td scope="row" style="text-align: center;"><?= $oferta["descuento"] ?>%</td>
                                        <td scope="row" style="text-align: left;"><?= $oferta["unica"] == 0 ? 'Varias' : 'Una sola' ?></td>
                                        <td scope="row" style="text-align: left;"><?= $oferta["cantidad"] ?> <?= $oferta["productoOrlista"] == 1 ? 'Por cada producto en lista' : 'productos por oferta' ?></td>
                                        <td scope="row" style="text-align: center;"><?= $oferta["createAt"] ?></td>
                                        <td scope="row">
                                            <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                                                <button type="button" class="btn btn-success edit_oferta_btn" data-toggle="modal" data-target="#ofertas_editOfertas" data-id='<?= $oferta["idOferta"] ?>'><?= $icons['edit'] ?></button>
                                                <button type="button" class="btn btn-danger delete_oferta_btn " data-id='<?= $oferta["idOferta"] ?>'><?= $icons['trash'] ?></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <?php include(self::modal('modalAddOferta')) ?>
        <?php include(self::modal('modalAddEditOferta')) ?>