<div class="modal" id="usuarios_addCliente">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="usuarios_AddUsuariosForm" class="display_flex_row" method="post">
                    <div class="modal-body display_flex_row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="col-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombre Completo</span>
                                    </div>
                                    <input type="text" id="usuarios_add_nombre" name="nombre" class="form-control  p-3">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Correo</span>
                                    </div>
                                    <input type="text" name="correo" class="form-control  p-3" id="usuarios_add_correo">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
                                    </div>
                                    <input type="text" name="telefono" class="form-control  p-3" id="usuarios_add_telefono">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Direccion</span>
                                    </div>
                                    <input type="text" name="direccion" class="form-control  p-3" id="usuarios_add_direccion">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Rol</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01">
                                    <option value="0">Seleccione un Rol</option>
                                        <?php foreach($rols as $rol): ?>
                                            <option value="<?= $rol['idrol'] ?>"><?= $rol['rol'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="usuarios_add_btnAddUsuarios" class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </div>
</div>