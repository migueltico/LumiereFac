<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card mb-2">
            <div class="card-header">
                <h4>Cajas</h4>
                <?php if (array_key_exists("caja_crear_caja", $_SESSION['permisos'])) :  ?>
                    <a href="#" id="btnNewBox" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cajas_addcaja" data-toggle="tooltip" data-placement="bottom" title="Nueva Caja Diaria">Abrir Nueva Caja</a>
                <?php endif;  ?>
            </div>

            <div class="card-body">
                <div class="row">
                    <?php foreach ($cajas as $caja) :  ?>
                        <?php if ($caja['estado'] != 4) :  ?>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="card text-white bg-<?= ($caja['estado'] == 0 ? "danger" : ($caja['estado'] == 1 ? "success" : "warning")) ?> mb-3 <?= ($caja['idvendedor'] == $_SESSION['id'] ? "shadow  mb-5 bg-body rounded" : '') ?> " style="max-width: 100%;min-height:150px; position:relative;">
                                    <div class="card-header <?= ($caja['idvendedor'] == $_SESSION['id'] && $caja['estado'] != 3 ? "own_caja" : '') ?>">
                                        <h5>Cajero asignado: <?= $caja['nombre_vendedor'] ?> | <?= $caja['fecha_init'] ?></h5>
                                    </div>
                                    <?php
                                    $estado = ['Pendiente', 'Abierta', 'Cerrada']
                                    ?>
                                    <div class="card-body">
                                        <h5 class="card-title">Caja ID: <strong> <?= $caja['idcaja'] ?></strong></h5>
                                        <h5 class="card-title">Caja Base: <strong> ₡<?= $caja['caja_base'] ?></strong></h5>
                                        <h5 class="card-title">Estado: <strong> <?= $estado[$caja['estado']] ?></strong></h5>
                                        <?php if ($caja['estado'] == 0 && $caja['idvendedor'] == $_SESSION['id']) :  ?>
                                            <button class="btn btnAbrirCajaEstado" data-caja="<?= $caja['idcaja'] ?>" style="border:1px solid white;color:white;">Abrir Caja</button>
                                        <?php elseif ($caja['estado'] == 1  && ($caja['idvendedor'] == $_SESSION['id'] || array_key_exists("caja_cerrar_caja", $_SESSION['permisos']))) :  ?>
                                            <button class="btn btnCerrarCajaEstado" data-toggle="modal" data-target="#cajas_cerrarCaja" data-monto="<?= $caja['caja_base'] ?>" data-caja="<?= $caja['idcaja'] ?>" style="border:1px solid white;color:white;">Cerrar Caja</button>
                                        <?php elseif ($caja['estado'] == 2  && $caja['idvendedor'] == $_SESSION['id']) :  ?>
                                            <button class="btn btnVerCajaEstado" data-caja="<?= $caja['idcaja'] ?>" style="border:1px solid white;color:white;">Ver Estado</button>
                                        <?php endif;  ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;  ?>
                    <?php endforeach;  ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card mb-2">
            <div class="card-header">
                <h4>Cajas del ultimo mes</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <table class="table sort" id="sortable">
                        <thead>
                            <tr>
                                <th data-type="1" data-inner="0" scope="col" style="text-align: center;"># Caja </th>
                                <th data-type="0" data-inner="0" scope="col">Usuario</th>
                                <?php if (array_key_exists("caja_ver_total_facturado", $_SESSION['permisos'])) :  ?>
                                    <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Total Facturado</th>
                                <?php endif;  ?>
                                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Monto Base</th>
                                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Efectivo</th>
                                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Tarjetas</th>
                                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Transferencias</th>
                                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Diferencia</th>
                                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Comentario</th>
                                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Fecha</th>

                            </tr>
                        </thead>
                        <tbody data-sorts="DESC">
                            <?php
                            $gravado = array("noGravado", "gravado");
                            $estado = array("inhabilitado", "habilitado");
                            $visible = array_key_exists("stock_ver_precios", $_SESSION['permisos']) ? true : false;
                            ?>
                            <!-- <span class="mr-2"><?php //echo$icons["codebar"] 
                                                    ?></span> -->
                            <?php foreach ($cajaslast as $cajas) : ?>
                                <?php $newDate = date("d-M-y", strtotime($cajas["fecha_init"])); ?>
                                <tr class="TrRow">
                                    <td scope="row" style="text-align: center;"><?= $cajas["idcaja"] ?></td>
                                    <td scope="row"><?= $cajas["nombre"] ?></td>
                                    <?php if (array_key_exists("caja_ver_total_facturado", $_SESSION['permisos'])) :  ?>
                                        <td scope="row" style="text-align: center;"><strong><?= number_format($cajas["total_facturado"], 2, ".", ",") ?: "0.00" ?></strong></td>
                                    <?php endif;  ?>
                                    <td scope="row" class="text-success" style="text-align: center;"><strong><?= number_format($cajas["caja_base"], 2, ".", ",") ?: "0.00" ?></strong></td>
                                    <td scope="row" style="text-align: center;"><strong><?= number_format($cajas["efectivo"], 2, ".", ",") ?: "0.00" ?></strong></td>
                                    <td scope="row" style="text-align: center;"><strong><?= number_format($cajas["tarjetas"], 2, ".", ",") ?: "0.00" ?></strong></td>
                                    <td scope="row" style="text-align: center;"><strong><?= number_format($cajas["transferencias"], 2, ".", ",") ?: "0.00" ?></strong></td>
                                    <td scope="row" style="text-align: center;" class="<?= ($cajas["diferencia"] >= 0 ? "text-success" : "text-danger") ?>"> <?= number_format($cajas["diferencia"], 2, ".", ",") ?: "0.00" ?></td>
                                    <td scope="row" style="text-align: left; max-width: 400px"><?= $cajas["comentario"] == null || $cajas["comentario"] == "" ? "<i style='color:#ddd'>- - Sin comentarios - -</i>" : $cajas["comentario"]  ?></td>
                                    <td scope="row" style="text-align: center;"><?= $newDate ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once(self::modal('modalAddCaja')) ?>
<?php include_once(self::modal('modalCerrarCaja')) ?>