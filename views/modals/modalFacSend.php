<div class="modal fade" id="FacSendModal">
    <div class="modal-dialog 1modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="galleryShowTitle" class="modal-title">Metodo de Pago</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input" id="MultiTipoPagoFact">
                    <label class="custom-control-label" for="MultiTipoPagoFact">Habilitar diferentes tipos de pago</label>
                </div>
                <div class="card">
                    <div class="cardHeaderSwitch">
                        <h5 class="">Efectivo</h5>
                        <div class="inputGroupFact">
                            <input class="fact_rbRadiosBtns" type="radio" checked name="tipoVenta" id="fact_rbRadioEfectivo">
                            <div class="custom-control custom-switch fact_switchBtns">
                                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2"></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="input-group mb-3 mt-3 col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Monto</span>
                                </div>
                                <input type="text" id="lbMonto" class="form-control" id="lbMonto" value="0.00">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="cardHeaderSwitch">
                        <h5 class="">Tarjeta</h5>
                        <div class="inputGroupFact">
                            <input class="fact_rbRadiosBtns" type="radio" name="tipoVenta" id="fact_rbRadioTarjeta">
                            <div class="custom-control custom-switch fact_switchBtns">
                                <input type="checkbox" class="custom-control-input" id="customSwitch3">
                                <label class="custom-control-label" for="customSwitch3"></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="input-group mb-3 mt-3 col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Tarjeta #</span>
                                </div>
                                <input type="text" class="form-control" maxlength="4" placeholder="Ultimos 4 Digitos">
                            </div>
                            <div class="input-group mb-3 mt-3 col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Monto</span>
                                </div>
                                <input type="text" id="lbMontoCard" class="form-control" value="0.00">
                            </div>
                        </div>
                    </div>
                </div>






            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>