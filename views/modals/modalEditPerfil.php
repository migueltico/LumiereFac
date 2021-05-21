<div class="modal" id="perfil_editPerfil">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="perfil_editperfilForm" class="display_flex_row" method="post">
                    <input type="hidden" name="id" id="iduser_perfil" value="<?= $_SESSION["id"] ?>">
                    <div class="modal-body display_flex_row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="col-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombre y apellidos</span>
                                    </div>
                                    <input type="text" id="perfil_edit_nombre" name="nombre" class="form-control  p-3">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Correo</span>
                                    </div>
                                    <input type="text" name="correo" class="form-control  p-3" id="perfil_edit_correo">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
                                    </div>
                                    <input type="text" name="telefono" class="form-control  p-3" id="perfil_edit_telefono">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Direccion</span>
                                    </div>
                                    <input type="text" name="direccion" class="form-control  p-3" id="perfil_edit_direccion">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Usuario</span>
                                    </div>
                                    <input type="text" name="usuario" class="form-control  p-3" id="perfil_edit_usuario" value="<?= $_SESSION["usuario"] ?>">
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="card border-success">
                                    <div class="card-header">
                                        Cambiar Contraseña
                                    </div>
                                    <div class="card-body text-success">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="input-group input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">Contraseña actual</span>
                                                </div>
                                                <input type="password" name="passnow" class="form-control  p-3" id="perfil_edit_pass_now">
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="input-group input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">Nueva Contraseña</span>
                                                </div>
                                                <input type="password"  class="form-control  p-3" id="perfil_edit_new_pass">
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="input-group input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">Confirmar Contraseña</span>
                                                </div>
                                                <input type="password" name="newpass" class="form-control  p-3" id="perfil_edit_confirm_pass">
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="input-group input-group mb-3">
                                                <button type="button" id="perfil_update_pass" class="btn btn-success">Cambiar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="perfil_edit_btneditperfil" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>