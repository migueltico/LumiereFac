<div class="row">
    <div class="col-lg-10 col-md-8 col-sm-12">
        <div class="card mb-2">
            <div class="card-header">
                <h4>Cajas</h4>
                <a href="#" id="btnNewBox" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cajas_addcaja" data-toggle="tooltip" data-placement="bottom" title="Nueva Caja Diaria">Abrir Nueva Caja</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <?php foreach($cajas as $caja):  ?>
                        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                            <div class="card-header"><h4><?=$caja['nombre'] ?> |  <?=$caja['fecha_init']?></h4></div>
                            <div class="card-body">
                                <h5 class="card-title">Caja Base: <?=$caja['caja_base'] ?></h5>
                            </div>
                        </div>
                        <?php endforeach;  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once(self::modal('modalAddCaja')) ?>