<div class="modal" id="descuentos_AddDescuento">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Descuento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="descuentos_form_AddDescuento">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="col-12">
                            <div class="input-group input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Descripcion</span>
                                </div>
                                <input type="text" id="descuentos_descripcion" name="descripcion" class="form-control  p-3">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="col-12">
                            <div class="input-group input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Descuento</span>
                                </div>
                                <input type="number" id="descuentos_descuento" name="descuento" class="form-control  p-3">
                            </div>
                        </div>
                    </div>                
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnCrearDescuento" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </div>
</div>