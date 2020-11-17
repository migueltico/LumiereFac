<div class="modal" id="cajas_cerrarCaja">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cierre de Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCerrarCaja">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12" id="montosCajaCerrar">

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Efectivo</span>
                                </div>
                                <input type="text" class="form-control caja_blur" name="efectivo" id="caja_efectivo" placeholder="Monto" value="0.00">
                            </div>
                            <div class=" input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tarjeta</span>
                                </div>
                                <input type="text" class="form-control caja_blur" name="tarjeta" id="caja_tarjeta" placeholder="Monto" value="0.00">
                            </div>
                            <div class=" input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Transferencia</span>
                                </div>
                                <input type="text" name="transferencia" class="form-control caja_blur" id="caja_transferencia" placeholder="Monto" value="0.00">
                            </div>
                            <div class=" alert alert-info d-flex justify-content-between" role="alert">
                                <span><strong>Total:</strong></span><span><strong id="caja_total">0.00</strong></span>
                            </div>
                            <div class=" alert alert-warning d-flex justify-content-between" role="alert" style="font-size: 1.3rem;">
                                <span><strong>Diferencia:</strong></span><span><strong id="caja_diferencia">0.00</strong></span>
                                <input type="hidden" name="diferencia" id="inputDiff">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Comentario</label>
                                <textarea class="form-control" id="caja_comentario" name='comentario' rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btncerrarCajaFinal" data-id="" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>