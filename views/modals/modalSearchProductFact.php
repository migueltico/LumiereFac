<div class="modal fade" id="SearchProductModal">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="galleryShowTitle" class="modal-title">Buscar Producto por descripcion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="btn btn-outline-secondary" type="button">Buscar</label>
                    </div>
                    <input type="text" id="SearchProductInputCtrlQ" class="form-control text-left" data-cliente="1" autofocus="on" placeholder="Buscar producto">
                </div>
                <div id="contentSearchFac" class="row p-2">

                </div>
                <nav aria-label="Page navigation example">
                    <ul id="paginationModal" data-init="0" class="pagination">

                    </ul>
                </nav>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>