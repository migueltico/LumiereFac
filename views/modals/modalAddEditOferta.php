<div class="modal" id="ofertas_editOfertas">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Oferta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ofertas_EditOfertaForm" class="display_flex_row" method="post">
                    <div class="modal-body display_flex_row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="col-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nombre Oferta</span>
                                    </div>
                                    <input type="text" id="ofertas_edit_nombre" name="nombreOferta" class="form-control  p-3">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Cantidad Productos</span>
                                    </div>
                                    <input type="number" name="cantidad" class="form-control  p-3" min="0" id="ofertas_edit_cantidad" value="1" data-toggle="tooltip" data-placement="bottom" title="0 para permitir cualquier cantidad">
                                    <select name="productoOrlista" class="custom-select" id="ofertas_edit_tipooferta">
                                        <option selected value="1">Por Productos en Lista</option>
                                        <option value="2">Por oferta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descuento %</span>
                                    </div>
                                    <input type="number" name="descuento" min="0" class="form-control  p-3" id="ofertas_edit_descuento">
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="unica" type="checkbox" value="" id="ofertas_edit_unica">
                                        <label class="form-check-label" for="ofertas_edit_unica" data-toggle="tooltip" data-placement="bottom" title="Permite que varios Producto con la misma oferta se aplique">
                                            Unica por factura
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text  btn btn-outline-secondary">Escanear Producto</span>
                                    </div>
                                    <input type="text" id="searchProductOfertaEdit" class="form-control p-3 ">
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
                                            <th data-type="1" data-inner="1" scope="col" style="text-align: center;">Precio</th>
                                            <th data-type="0" data-inner="0" scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ofertaRowsEditModal" data-sorts="DESC">

                                    </tbody>
                                </table>









                            </div>


                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="ofertas_add_btnEditOferta" class="btn btn-primary" data-id="">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>