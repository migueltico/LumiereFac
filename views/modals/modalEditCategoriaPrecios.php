<div class="modal fade" id="editCategoriaPrecios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoriaPrecio_descripcion_label">Editar Categoria de precio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Descripcion</span>
                    </div>
                    <input type="text" class="form-control" id="editCategoriaPrecio_descripcion">
                    <input type="hidden" class="form-control" id="editCategoriaPrecio_id">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Factor</span>
                    </div>
                    <input type="text" class="form-control" id="editCategoriaPrecio_factor">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"id="editCategoriaPrecio_save" >Guardar cambios</button>
            </div>
        </div>
    </div>
</div>