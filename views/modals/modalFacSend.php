<div class="modal fade" id="FacSendModal">
    <div class="modal-dialog 1modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="galleryShowTitle" class="modal-title">Metodo de Pago | Monto a pagar: </h5>
                <h5 id="amountModalTitle" style="color:var(--primaryColor);font-weight:bold;margin-left:1rem" class="modal-title">0.00</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row container">
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="MultiTipoPagoFact">
                        <label class="custom-control-label" for="MultiTipoPagoFact">Habilitar Seleccion Multiple</label>
                    </div>
                    <div class="custom-control custom-switch mb-3 ml-2" style="display: none;" id="pagoContraEntregaContainer">
                        <input type="checkbox" class="custom-control-input"  id="pagoContraEntrega">
                        <label class="custom-control-label"  for="pagoContraEntrega">Pago Contra Entrega</label>
                    </div>
                </div>
                <div class="card">
                    <div class="cardHeaderSwitch selectedMethodPay">
                        <h5 class="">Efectivo</h5>
                        <div class="inputGroupFact">
                            <input class="fact_rbRadiosBtns" type="radio" data-inputval="efectivoInputs" checked name="tipoVenta" id="fact_rbRadioEfectivo">
                            <div class="custom-control custom-switch fact_switchBtns">
                                <input type="checkbox" class="custom-control-input switchGroupAmount" data-inputval="efectivoInputs" id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2"></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="input-group mb-3 mt-3 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Monto</span>
                                </div>
                                <input type="text" class="form-control lbMontoToPay efectivoInputs_monto" value="0.00">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="cardHeaderSwitch">
                        <h5 class="">Tarjeta</h5>
                        <div class="inputGroupFact">
                            <input class="fact_rbRadiosBtns" type="radio" name="tipoVenta" data-inputval="tarjertaInputs" id="fact_rbRadioTarjeta">
                            <div class="custom-control custom-switch fact_switchBtns">
                                <input type="checkbox" class="custom-control-input switchGroupAmount" data-inputval="tarjertaInputs" id="customSwitch3">
                                <label class="custom-control-label" for="customSwitch3"></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="input-group mb-3 mt-3  col-lg-6 col-md-6 col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"># Tarjeta</span>
                                </div>
                                <input type="text" class="form-control tarjertaInputs_tarjeta" maxlength="4" placeholder="Ultimos 4 Digitos">
                            </div>
                            <div class="input-group mb-3 mt-3 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Monto</span>
                                </div>
                                <input type="text" class="form-control lbMontoToPay tarjertaInputs_monto" value="0.00">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="cardHeaderSwitch">
                        <h5 class="">Transferencia</h5>
                        <div class="inputGroupFact">
                            <input class="fact_rbRadiosBtns" type="radio" name="tipoVenta" data-inputval="transferenciaInputs" id="fact_rbRadioTarjeta">
                            <div class="custom-control custom-switch fact_switchBtns">
                                <input type="checkbox" class="custom-control-input switchGroupAmount" data-inputval="transferenciaInputs" id="customSwitch4">
                                <label class="custom-control-label" for="customSwitch4"></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="input-group mb-3 mt-3 col-lg-3 col-md-6 col-sm-12">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Banco</label>
                                </div>
                                <select class="custom-select transferenciaInputs_banco" id="inputGroupSelect01">
                                    <option selected value="0">Seleccione</option>
                                    <option value="1">BCR</option>
                                    <option value="2">BNCR</option>
                                    <option value="3">BAC</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 mt-3 col-lg-4 col-md-6 col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"># Referencia</span>
                                </div>
                                <input type="text" class="form-control transferenciaInputs_referencia" placeholder="">
                            </div>
                            <div class="input-group mb-3 mt-3 col-lg-4 col-md-6 col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Monto</span>
                                </div>
                                <input type="text" class="form-control lbMontoToPay transferenciaInputs_monto" value="0.00">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" checked="true" id="SendFactBoolean">
                    <label class="custom-control-label" for="SendFactBoolean">Imprimir</label>
                </div>
                <button type="button" id="btnMakeFact" class="btn btn-lg btn-info">Generar Venta</button>
                <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>