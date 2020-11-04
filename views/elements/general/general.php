<div class="row">
    <div class="col-12">
        <div class="card mb-5">
            <div class="card-header">
                <h4>Informacion General</h4>
                <a href="#" id="btnSaveGeneralInfo" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Guardar informacion General">Guardar</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <form id="generalData">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Nombre Sucursal</span>
                                </div>
                                <input type="text" class="form-control" name=":sucursal" value="<?= (!isset($nombre_local) ? "" : $nombre_local) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Razon social</span>
                                </div>
                                <input type="text" class="form-control" name=":razon" value="<?= (!isset($razon_social) ? "" : $razon_social) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Cedula Juridica</span>
                                </div>
                                <input type="text" class="form-control" name=":juridica" value="<?= (!isset($cedula_juridica) ? "" : $cedula_juridica) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Telefono</span>
                                </div>
                                <input type="text" class="form-control" name=":telefono" value="<?= (!isset($telefono) ? "" : $telefono) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Dirección</span>
                                </div>
                                <input type="text" class="form-control" name=":direccion" value="<?= (!isset($direccion) ? "" : $direccion) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Correo informativo</span>
                                </div>
                                <input type="text" class="form-control" name=":mail_info" value="<?= (!isset($correo_info) ? "" : $correo_info) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Correo Ventas</span>
                                </div>
                                <input type="text" class="form-control" name=":mail_ventas" value="<?= (!isset($correo_venta) ? "" : $correo_venta) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Mensaje pie de pagina ( Tickets )</span>
                                </div>
                                <input type="text" class="form-control" name=":msj_footer" value="<?= (!isset($mensaje_footer_fac) ? "" : $mensaje_footer_fac) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Mensaje informativo ( Tickets )</span>
                                </div>
                                <input type="text" class="form-control" name=":msj_info" value="<?= (!isset($mensaje_restricciones) ? "" : $mensaje_restricciones) ?>">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend tagNameGastos">
                                    <span class="input-group-text " id="">Logo</span>
                                </div>
                                <input type="text" class="form-control" name=":logo" placeholder="Url de la imagen" value="<?= (!isset($url_logo) ? "" : $url_logo) ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>