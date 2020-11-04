<div class="modal" id="cajas_addcaja">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Abrir Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cajas_form_addcaja">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="col-12">
                            <div class="input-group input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Monto inicial</span>
                                </div>
                                <input type="text" id="cajas_monto" name="monto" class="form-control  p-3">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <select class="custom-select" id="cbSelectuser" name="userId">
                                <option selected disabled>Seleccione un usuario</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= $user['idusuario'] ?>"><?= $user['nombre'] ?> (<?= $user['roles'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnAbrirCaja" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </div>
</div>