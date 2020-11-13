<div class="modal" id="descuentos_EditDescuento">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Descuento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="descuentos_form_EditDescuento">
                    <input type="hidden" id="descuento_Edit_id" name="id">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="col-12">
                            <div class="input-group input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Descripcion</span>
                                </div>
                                <input type="text" id="descuentos_Edit_descripcion" name="descripcion" class="form-control  p-3">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="col-12">
                            <div class="input-group input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Descuento</span>
                                </div>
                                <input type="number" id="descuentos_Edit_descuento" name="descuento" class="form-control  p-3">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="activo" id="descuentos_Edit_activo">
                            <label class="custom-control-label" for="descuentos_Edit_activo">Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnEditarDescuento" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </div>
</div>