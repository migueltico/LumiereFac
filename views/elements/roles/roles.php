<div class="row">
    <div class="col-lg-10 col-md-8 col-sm-12">
        <div class="card mb-2">
            <div class="card-header">
                <h4>Permisos de Rol</h4>
                <a href="#" id="btnNewRol" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rols_addrol" data-toggle="tooltip" data-placement="bottom" title="Nuevo rol">Nuevo</a>
                <a href="#" id="btnSaveRols" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Guardar Permisos">Guardar Rols</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="form-group col-lg-6 col-md-8 col-sm-12">
                            <select class="custom-select" id="cbSelectRol">
                                <option selected="" disabled>Seleccione un Rol</option>
                                <?php foreach ($roles as $rol) : ?>
                                    <option value="<?= $rol['idrol'] ?>"><?= $rol['rol'] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-10 col-md-8 col-sm-12">
        <div class="card mb-5">
            <div class="card-body">                
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 " id="tablerols">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once(self::modal('modalAddRol')) ?>