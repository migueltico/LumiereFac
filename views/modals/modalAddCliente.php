<div class="modal" id="clientes_addCliente">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="clientes_AddClienteForm" class="display_flex_row" method="post">
                    <div class="modal-body display_flex_row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                            <div class="col-12 position-relative required_field">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombre</span>
                                    </div>
                                    <input type="text" id="clientes_add_nombre" name="nombre" class="form-control  p-3">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Cedula</span>
                                    </div>
                                    <input type="text" name="cedula" class="form-control  p-3" id="clientes_add_cedula">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 position-relative required_field">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
                                    </div>
                                    <input type="text" name="tel" class="form-control  p-3" id="clientes_add_telefono">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Correo</span>
                                    </div>
                                    <input type="text" name="email" class="form-control  p-3" id="clientes_add_email">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Direccion</span>
                                    </div>
                                    <input type="text" name="direccion" class="form-control  p-3" id="clientes_add_direccion">
                                </div>
                                <div class="input-group input-group mb-3">
                                    <input type="text" name="direccion2" class="form-control  p-3" id="clientes_add_direccion2" placeholder="Direccion...">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="clientes_add_btnAddCliente" class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </div>
</div>