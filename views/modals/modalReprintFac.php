<div class="modal fade" id="reimprimirModal" style="z-index: 1050;">
    <div class="modal-dialog modal-dialog-top modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="galleryShowTitle" class="modal-title">Reimpresion de facturas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label id="SearchReprintFac_inputBtn" class="btn btn-outline-secondary" type="button">Buscar</label>
                    </div>
                    <input type="text" autocomplete="off" id="SearchReprintFac_input" class="form-control text-left" data-cliente="1" autofocus="on" placeholder="Buscar por # de Factura" value="">
                </div>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Solo mostraran facturas de venta local y envios relacionadas al usuario actual, recibos de abonos o apartados no estan disponibles
                </div>
                <div id="contentSearchRePrintFac" class="row p-2">

                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>