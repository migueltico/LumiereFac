<div class="row">
    <div class="col-lg-10 col-md-8 col-sm-12">
        <div class="card mb-2">
            <div class="card-header">
                <h4>Cajas</h4>
                <a href="#" id="btnNewBox" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cajas_addcaja" data-toggle="tooltip" data-placement="bottom" title="Nueva Caja Diaria">Abrir Nueva Caja</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <?php foreach ($cajas as $caja) :  ?>
                        <?php if ($caja['estado'] != 4) :  ?>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="card text-white bg-<?= ($caja['estado'] == 0 ? "danger" : ($caja['estado'] == 1 ? "success" : "warning")) ?> ?> mb-3" style="max-width: 100%;min-height:150px">
                                    <div class="card-header">
                                        <h5>Cajero asignado: <?= $caja['nombre_vendedor'] ?> | <?= $caja['fecha_init'] ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Caja ID: <strong> <?= $caja['idcaja'] ?></strong></h5>
                                        <h5 class="card-title">Caja Base: <strong> ₡<?= $caja['caja_base'] ?></strong></h5>
                                        <h5 class="card-title">Estado: <strong> ₡<?= $caja['estado'] ?></strong></h5>
                                        <?php if ($caja['estado'] == 0 && $caja['idvendedor'] == $_SESSION['id']) :  ?>
                                            <button class="btn btnAbrirCajaEstado" data-caja="<?= $caja['idcaja'] ?>" style="border:1px solid white;color:white;">Abrir Caja</button>
                                        <?php elseif ($caja['estado'] == 1  && $caja['idvendedor'] == $_SESSION['id']) :  ?>
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

</div>

<?php include_once(self::modal('modalAddCaja')) ?>
<?php include_once(self::modal('modalCerrarCaja')) ?>