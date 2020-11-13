<div class="modal" id="apartados_abonar">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facturaTitleAbono">Abonos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-primary" id="abonoSaldoData" role="alert">

                </div>
                <div>
                    <h4>Productos</h4>
                </div>
                <div class="card mb-5" style="width: 100%;">
                    <ul class="list-group list-group-flush" id="productosListAbono">
                    </ul>
                </div>
                <form id="apartados_form_abonar">
                    <input type="hidden" name="idfactura" id="idfactura" value="">
                    <!-- INICIA METODOS DE PAGO -->
                    <div class="card">
                        <div class="cardHeaderAbono selectedMethodPayAbono selectedMethodPayAbono">
                            <h5 class="">Efectivo</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="input-group mb-3 mt-3 col-lg-6 col-md-6 col-sm-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Monto</span>
                                    </div>
                                    <input type="text" class="form-control abonoMontosModal" name="efectivoMontoAbono" id="efectivoMontoAbono" value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="cardHeaderAbono selectedMethodPayAbono">
                            <h5 class="">Tarjeta</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="input-group mb-3 mt-3  col-lg-6 col-md-6 col-sm-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"># Tarjeta</span>
                                    </div>
                                    <input type="text" class="form-control" name="tarjetaAbono" id="tarjetaAbono" maxlength="4" placeholder="Ultimos 4 Digitos">
                                </div>
                                <div class="input-group mb-3 mt-3 col-lg-6 col-md-6 col-sm-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Monto</span>
                                    </div>
                                    <input type="text" class="form-control abonoMontosModal" name="tarjetaMontoAbono" id="tarjetaMontoAbono" value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="cardHeaderAbono selectedMethodPayAbono">
                            <h5 class="">Transferencia</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="input-group mb-3 mt-3 col-lg-3 col-md-6 col-sm-12">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="bancoAbono">Banco</label>
                                    </div>
                                    <select class="custom-select" name="bancoAbono" id="bancoAbono">
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
                                    <input type="text" class="form-control" name="referenciaAbono" id="referenciaAbono" placeholder="">
                                </div>
                                <div class="input-group mb-3 mt-3 col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Monto</span>
                                    </div>
                                    <input type="text" class="form-control abonoMontosModal" name="bancoMontoAbono" id="bancoMontoAbono" value="0.00">
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnAbonarPrint" class="btn btn-primary btn-lg">Abonar</button>
            </div>
        </div>
    </div>
</div>