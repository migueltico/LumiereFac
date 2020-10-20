<div class="modal fade" id="SearchClientModal">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="galleryShowTitle" class="modal-title">Buscar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label id="SearchClient_inputBtn" class="btn btn-outline-secondary" type="button">Buscar</label>
                    </div>
                    <input type="text" autocomplete="off" id="SearchClient_input" class="form-control text-left" data-cliente="1" autofocus="on" placeholder="Buscar Cliente">
                </div>
                <div id="contentSearchClient" class="row p-2">

                </div>
                <nav aria-label="Page navigation example">
                    <ul id="paginationModalCliente" data-init="0" class="pagination">

                    </ul>
                </nav>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-info" id="callModalAddClient" data-toggle="modal" data-target="#clientes_editCliente" data-dismiss="modal">Agregar Nuevo Cliente</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>