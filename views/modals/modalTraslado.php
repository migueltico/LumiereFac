<div class="modal" id="traslado_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Traslado de inventario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a style="color: black;" class="nav-link active" id="nav_lista_traslado-tab" data-toggle="tab" href="#nav_lista_traslado" role="tab" aria-controls="nav_lista_traslado" aria-selected="true">Lista de traslados</a>
                        <a style="color: black;" class="nav-link " id="nav_crear_traslados-tab" data-toggle="tab" href="#nav_crear_traslados" role="tab" aria-controls="nav_crear_traslados" aria-selected="false">Crear traslado</a>
                    </div>
                </nav>
                <div class="tab-content p-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav_lista_traslado" role="tabpanel" aria-labelledby="nav_lista_traslado-tab">
                   
                    </div>
                    <div class="tab-pane fade" id="nav_crear_traslados" role="tabpanel" aria-labelledby="nav_crear_traslados-tab">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="col-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Tienda Origen</span>
                                    </div>
                                    <input type="text" id="traslado_origen" class="form-control  p-3" value="<?= $_SESSION['info']['nombre_local']  ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <form id="traslado_form">

                            <div class="col-12">
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="traslado__cbTienda">Tienda traslado</label>
                                        </div>
                                        <select name="tienda_traslado" class="custom-select" id="traslado__cbTienda">
                                            <option selected value="0">Seleccione una tienda...</option>
                                            <?php foreach ($tiendas as $key => $db) : ?>
                                                <option value="<?= $key . ";" . $db ?>"><?= $db ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="col-12">
                                    <div class="input-group input-group">
                                        <label for="traslado_comentario">Comentario:</label>
                                    </div>
                                    <div class="input-group input-group mb-3">
                                        <textarea name="comentario" class="form-control  p-3" id="traslado_comentario" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-12">
                            <div class="col-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text  btn btn-outline-secondary">Escanear Producto</span>
                                    </div>
                                    <input type="text" id="searchProductTrasladoAdd" class="form-control  p-3">
                                    <div class="input-group-prepend">
                                    </div>
                                </div>
                            </div>
                            <div>

                                <table class="table sort" id="sortable">
                                    <thead>
                                        <tr>
                                            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Codigo</th>
                                            <th data-type="0" data-inner="0" scope="col">Descripcion</th>
                                            <th data-type="0" data-inner="0" scope="col">Marca</th>
                                            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Estilo</th>
                                            <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Talla</th>
                                            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Cantidad</th>
                                            <th data-type="0" data-inner="0" scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="trasladoRowsModal" data-sorts="DESC">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnCrearTraslado" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </div>
</div>