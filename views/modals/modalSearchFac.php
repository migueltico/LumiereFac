<div class="modal fade" id="SearchFacModal" style="z-index: 1050;">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="galleryShowTitle" class="modal-title">Devoluciones/Cambios por factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label id="SearchFac_inputBtn" class="btn btn-outline-secondary" type="button">Buscar</label>
                    </div>
                    <input type="text" autocomplete="off" id="SearchFac_input" class="form-control text-left" data-cliente="1" autofocus="on" placeholder="Buscar Factura" value="">
                </div>
                
                <div class="alert alert-primary  d-flex justify-content-between" role="alert">
                    <div class="col-4"><strong>Fecha Venta:</strong> <span id="fecha_venta_devolucion"></span></div>
                    <div class="col-4"><strong>Saldo:</strong> <span id="saldoActual_devolucion">0.00</span></div>
                    <div class="col-4"><strong>Fecha Max. Devol.:</strong> <strong id="fecha_max_devolucion"></strong></div>
                </div>
                <div id="contentSearchFac" class="row p-2">
                    <input type="hidden" name="idfacDevolucion" id="idfacDevolucion" value="">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>Codigo</th>
                                <th>Descripcion</th>
                                <th>Cant</th>
                                <th>Precio</th>
                                <th>Desc.</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Cant. Cambio</th>
                                <th>Seleccionar</th>
                                <th>Monto</th>

                            </thead>
                            <tbody id="rowsFactDetailsSearch">

                            </tbody>
                        </table>
                    </div>
                    <div>
                        <p><strong>Total Nuevo Saldo: <span id="NewCreditTotal" data-total="0.00" class="text-primary">0.00</span></strong></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnAplicarDevolucion" type="button" class="btn btn-primary">Aplicar</button>
            </div>
        </div>
    </div>
</div>