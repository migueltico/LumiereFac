<div class="modal" id="usuarios_editUsuario">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="usuarios_editUsuariosForm" class="display_flex_row" method="post">
                    <input type="hidden" name="id" id="iduser">
                    <div class="modal-body display_flex_row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="col-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombre y apellidos</span>
                                    </div>
                                    <input type="text" id="usuarios_edit_nombre" name="nombre" class="form-control  p-3">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Correo</span>
                                    </div>
                                    <input type="text" name="correo" class="form-control  p-3" id="usuarios_edit_correo">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
                                    </div>
                                    <input type="text" name="telefono" class="form-control  p-3" id="usuarios_edit_telefono">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Direccion</span>
                                    </div>
                                    <input type="text" name="direccion" class="form-control  p-3" id="usuarios_edit_direccion">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Rol</label>
                                    </div>
                                    <select class="custom-select" name="rol" id="usuarios_edit_rol">
                                        <?php $hasPermission = array_key_exists("usuarios_editar_rol", $_SESSION['permisos']); ?>
                                        <?php if ($hasPermission) :  ?>
                                            <option value="0">Seleccione un Rol</option>
                                        <?php endif; ?>
                                        <?php foreach ($rols as $rol) : ?>
                                            <?php if ($hasPermission) :  ?>
                                                <option value="<?= $rol['idrol'] ?>"><?= $rol['rol'] ?></option>
                                            <?php else : ?>
                                                <option value="0">Sin permisos para modificar el Rol</option>
                                                <?php break;  ?>
                                            <?php endif; ?>
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
                <button type="button" id="usuarios_edit_btneditUsuarios" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>