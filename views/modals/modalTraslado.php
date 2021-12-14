<div class="modal" id="traslado_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Traslado de inventario | <?= $_SESSION["info"]["nombre_local"]  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a style="color: black;" class="nav-link active" id="nav_lista_traslado-tab" data-toggle="tab" href="#nav_lista_traslado1" role="tab" aria-controls="nav_lista_traslado1" aria-selected="true">Lista de traslados</a>
                        <a style="color: black;" class="nav-link " id="nav_crear_traslados-tab" data-toggle="tab" href="#nav_crear_traslados" role="tab" aria-controls="nav_crear_traslados" aria-selected="false">Crear traslado</a>
                    </div>
                </nav>
                <div class="tab-content p-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav_lista_traslado1" role="tabpanel" aria-labelledby="nav_lista_traslado1-tab">
                        <div class="alert alert-info" role="alert">

                            <li>Los ingresos solo son informativos, estos deben agregarse manualmente al inventario de la tienda a la cual se traslada, el traslado se debe confirmar con el boton verde del check.</li>
                            <li>Los traslados una vez creados modifican el inventario de la tienda de origen.</li>
                            <li>Si un traslado es cancelado en la tienda de Origen el inventario de la tienda se actualizara nuevamente con las unidade, en el caso de cancelacion desde la tienda de traslado, el inventario de la tienda de origen se actualizara una vez confirma la devolucion en la tienda.</li>

                        </div>
                        <div class="table-responsive">
                            <table class="table sort trasladoRowsTable" data-class="trasladoRowsTable" id="sortable">
                                <thead>
                                    <tr>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Id translado</th>
                                        <th data-type="0" data-inner="0" scope="col">Tipo Traslado</th>
                                        <th data-type="0" data-inner="0" scope="col">Tienda origen</th>
                                        <th data-type="0" data-inner="0" scope="col">Tienda a trasladar</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Fecha</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Estado</th>
                                        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="nav_lista_traslado" data-sorts="DESC">
                                </tbody>
                            </table>
                        </div>
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
                                <div class="table-responsive">
                                    <table class="table sort trasladoRowsTableCreate" data-class="trasladoRowsTableCreate" id="sortable">
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
                        <div class="d-flex justify-content-end modal-footer">
                            <button type="button" id="btnCrearTraslado" class="btn btn-primary btn-lg">Crear</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>