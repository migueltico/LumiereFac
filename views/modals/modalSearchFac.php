<div class="modal fade" id="SearchFacModal" style="z-index: 1050;">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="galleryShowTitle" class="modal-title">Buscar Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label id="SearchFac_inputBtn" class="btn btn-outline-secondary" type="button">Buscar</label>
                    </div>
                    <input type="text" autocomplete="off" id="SearchFac_input" class="form-control text-left" data-cliente="1" autofocus="on" placeholder="Buscar Factura" value="1000000256">
                </div>
                <div id="AsignarsaldoGroup" style="display: none;">
                    <div class="form-check">
                        <label class="form-check-label"><input class="form-check-input" type="checkbox" value="" id="ckAsignarSaldoCliente" >Asignar saldo a cliente</label>
                    </div>
                    <div class="input-group mb-3 mt-2" id="selectClienteGroupSaldo" hidden>
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#SearchClientModal">Seleccionar cliente</button>
                        </div>
                        <input type="text" class="form-control" disabled data-cliente="" id="idclienteFacCambio" value="">
                    </div>
                </div>
                <div id="contentSearchFac" class="row p-2">
                    <div class="alert alert-primary" role="alert" id="dataClienteFac" style="display: flex;justify-content:space-between;width:100%;">
                    </div>

                    <table class="table">
                        <thead>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>descuento</th>
                            <th>IVA</th>
                            <th>Total</th>
                            <th>Cant. Cambio</th>
                            <th>Seleccionar</th>

                        </thead>
                        <tbody id="rowsFactDetailsSearch">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-outline-secondary">Facturar Con Saldo</button>
                <button type="button" class="btn btn-primary">Agregar Saldo a cliente</button>
            </div>
        </div>
    </div>
</div>