<div class="row ml-2" style="max-width: 100%;">
    <form id="permisosForm" class="row">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="col-lg-12 mb-3" style="max-width: 100%;">
            <div class="card" style="max-width: 100%;">
                <div class="card-header"><strong style="font-size:1.2rem">Admin</strong></div>
                <div class="card-body row">
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>General 2</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="general_modulo"><input type="checkbox" class="mr-2" name="general_modulo" id="general_modulo">Ver modulo</label>
                            <label class="text-primary" for="general_guardar"><input type="checkbox" class="mr-2" name="general_guardar" id="general_guardar">Guardar cambios</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Gastos</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="gastos_modulo"><input type="checkbox" class="mr-2" name="gastos_modulo" id="gastos_modulo">Ver modulo</label>
                            <label class="text-primary" for="gastos_guardar"><input type="checkbox" class="mr-2" name="gastos_guardar" id="gastos_guardar">Guardar cambios</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Categorias de precios</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="catpre_modulo"><input type="checkbox" class="mr-2" name="catpre_modulo" id="catpre_modulo">Ver modulo</label>
                            <label class="text-primary" for="catpre_crear"><input type="checkbox" class="mr-2" name="catpre_crear" id="catpre_crear">Crear categoria</label>
                            <label class="text-primary" for="catpre_editar"><input type="checkbox" class="mr-2" name="catpre_editar" id="catpre_editar">Editar categoria</label>
                            <label class="text-primary" for="catpre_eliminar"><input type="checkbox" class="mr-2" name="catpre_eliminar" id="catpre_eliminar">Desactivar categoria</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Categorias y Tallas</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="cattalla_modulo"><input type="checkbox" class="mr-2" name="cattalla_modulo" id="cattalla_modulo">Ver modulo</label>
                            <label class="text-primary" for="cattalla_crear"><input type="checkbox" class="mr-2" name="cattalla_crear" id="cattalla_crear">Crear categoria o talla</label>
                            <label class="text-primary" for="cattalla_editar"><input type="checkbox" class="mr-2" name="cattalla_editar" id="cattalla_editar">Editar categoria o talla</label>
                            <label class="text-primary" for="cattalla_eliminar"><input type="checkbox" class="mr-2" name="cattalla_eliminar" id="cattalla_eliminar">Desactivar categoria o talla</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Descuentos</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="descuento_modulo"><input type="checkbox" class="mr-2" name="descuento_modulo" id="descuento_modulo">Ver modulo</label>
                            <label class="text-success" for="descuento_crear"><input type="checkbox" class="mr-2" name="descuento_crear" id="descuento_crear">Crear Descuento</label>
                            <label class="text-success" for="descuento_editar"><input type="checkbox" class="mr-2" name="descuento_editar" id="descuento_editar">Editar Descuento</label>
                            <label class="text-success" for="descuento_eliminar"><input type="checkbox" class="mr-2" name="descuento_eliminar" id="descuento_eliminar">Desactivar Descuento</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Descuentos por lote</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="descuento_lote_modulo"><input type="checkbox" class="mr-2" name="descuento_lote_modulo" id="descuento_lote_modulo">Ver modulo</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Ofertas</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="ofertas_modulo"><input type="checkbox" class="mr-2" name="ofertas_modulo" id="ofertas_modulo">Ver modulo</label>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mb-3" style="max-width: 100%;">
            <div class="card" style="max-width: 100%;">
                <div class="card-header"><strong style="font-size:1.2rem">Facturacion</strong></div>
                <div class="card-body row">
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Facturar</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="fac_modulo"><input type="checkbox" class="mr-2" name="fac_modulo" id="fac_modulo">Ver modulo</label>
                            <label class="text-primary" for="fac_cliente"><input type="checkbox" class="mr-2" name="fac_cliente" id="fac_cliente">Crear Cliente</label>
                            <label class="text-success" for="fac_descuento"><input type="checkbox" class="mr-2" name="fac_descuento" id="fac_descuento">Descuento</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Cajas</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="caja_modulo"><input type="checkbox" class="mr-2" name="caja_modulo" id="caja_modulo">Ver modulo</label>
                            <label class="text-success" for="caja_crear_caja"><input type="checkbox" class="mr-2" name="caja_crear_caja" id="caja_crear_caja">Crear caja</label>
                            <label class="text-success" for="caja_ver_caja"><input type="checkbox" class="mr-2" name="caja_ver_caja" id="caja_ver_caja">Ver cajas</label>
                            <label class="text-success" for="caja_cerrar_caja"><input type="checkbox" class="mr-2" name="caja_cerrar_caja" id="caja_cerrar_caja">Cerrar cajas( otros usuarios )</label>
                            <label class="text-success" for="caja_ver_total_facturado"><input type="checkbox" class="mr-2" name="caja_ver_total_facturado" id="caja_ver_total_facturado">Ver columna total facturado</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Facturas Pendientes</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="fac_pend_modulo"><input type="checkbox" class="mr-2" name="fac_pend_modulo" id="fac_pend_modulo">Ver modulo</label>
                            <label class="text-primary" for="fac_pend_cancelar"><input type="checkbox" class="mr-2" name="fac_pend_cancelar" id="fac_pend_cancelar">Cancelar factura</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Historial de facturas</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="historial_diario_modulo"><input type="checkbox" class="mr-2" name="historial_diario_modulo" id="historial_diario_modulo">Ver modulo</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Apartados</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="Apartados_modulo"><input type="checkbox" class="mr-2" name="Apartados_modulo" id="Apartados_modulo">Ver modulo</label>
                            <label class="text-primary" for="Apartados_cancelar"><input type="checkbox" class="mr-2" name="Apartados_cancelar" id="Apartados_cancelar">Abonar</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Reimpresion de Facturas</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="reprint_modulo"><input type="checkbox" class="mr-2" name="reprint_modulo" id="reprint_modulo">Ver modulo</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Reportes</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="reportes_modulo"><input type="checkbox" class="mr-2" name="reportes_modulo" id="reportes_modulo">Ver modulo</label>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mb-3" style="max-width: 100%;">
            <div class="card" style="max-width: 100%;">
                <div class="card-header"><strong style="font-size:1.2rem">Inventario</strong></div>
                <div class="card-body row">
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Lista de Productos</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="inv_modulo"><input type="checkbox" class="mr-2" name="inv_modulo" id="inv_modulo">Ver modulo</label>
                            <label class="text-success" for="inv_crear"><input type="checkbox" class="mr-2" name="inv_crear" id="inv_crear">Crear producto</label>
                            <label class="text-success" for="inv_editar"><input type="checkbox" class="mr-2" name="inv_editar" id="inv_editar">Editar producto</label>
                            <label class="text-success" for="inv_eliminar"><input type="checkbox" class="mr-2" name="inv_eliminar" id="inv_eliminar">Desactivar producto</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Stock y Precios</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="stock_modulo"><input type="checkbox" class="mr-2" name="stock_modulo" id="stock_modulo">Ver modulo</label>
                            <label class="text-success" for="stock_ver_precios"><input type="checkbox" class="mr-2" name="stock_ver_precios" id="stock_ver_precios">Ver precio U, precio C, precio S.</label>
                            <label class="text-success" for="stock_cambiar_precios"><input type="checkbox" class="mr-2" name="stock_cambiar_precios" id="stock_cambiar_precios">Mostrar Opciones de cambiar precios</label>
                            <label class="text-success" for="modificar_precio" data-toggle="tooltip" title="Todo usuario con la opcion de 'mostrar opciones de cambiar precio' podra modificar el precio al producto recien creado, para poder modificar el precio a futuro se requiere esta opcion activada">
                                <input type="checkbox" class="mr-2" name="modificar_precio" id="modificar_precio">
                                Permitir cambiar precios siempre
                            </label>
                            <label class="text-success" for="stock_agregar"><input type="checkbox" class="mr-2" name="stock_agregar" id="stock_agregar">Agregar stock y minimo</label>
                        </div>
                    </label>
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Impresion de etiquetas</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="impr_modulo"><input type="checkbox" class="mr-2" name="impr_modulo" id="impr_modulo">Ver modulo</label>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mb-3" style="max-width: 100%;">
            <div class="card" style="max-width: 100%;">
                <div class="card-header"><strong style="font-size:1.2rem">Clientes</strong></div>
                <div class="card-body">
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Lista de Clientes</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="clientes_modulo"><input type="checkbox" class="mr-2" name="clientes_modulo" id="clientes_modulo">Ver modulo</label>
                            <label class="text-primary" for="clientes_crear"><input type="checkbox" class="mr-2" name="clientes_crear" id="clientes_crear">Crear cliente</label>
                            <label class="text-primary" for="clientes_editar"><input type="checkbox" class="mr-2" name="clientes_editar" id="clientes_editar">Editar cliente</label>
                            <label class="text-primary" for="clientes_eliminar"><input type="checkbox" class="mr-2" name="clientes_eliminar" id="clientes_eliminar">Desactivar cliente</label>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mb-3" style="max-width: 100%;">
            <div class="card" style="max-width: 100%;">
                <div class="card-header"><strong style="font-size:1.2rem">Usuarios</strong></div>
                <div class="card-body">
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Lista de Usuarios</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="usuarios_modulo"><input type="checkbox" class="mr-2" name="usuarios_modulo" id="usuarios_modulo">Ver modulo</label>
                            <label class="text-success" for="usuarios_crear"><input type="checkbox" class="mr-2" name="usuarios_crear" id="usuarios_crear">Crear usuario</label>
                            <label class="text-success" for="usuarios_editar"><input type="checkbox" class="mr-2" name="usuarios_editar" id="usuarios_editar">Editar usuario</label>
                            <label class="text-success" for="usuarios_editar_rol"><input type="checkbox" class="mr-2" name="usuarios_editar_rol" id="usuarios_editar_rol">Editar Rol de usuario</label>
                            <label class="text-primary" for="usuarios_eliminar"><input type="checkbox" class="mr-2" name="usuarios_eliminar" id="usuarios_eliminar">Desactivar usuario</label>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mb-3" style="max-width: 100%;">
            <div class="card" style="max-width: 100%;">
                <div class="card-header"><strong style="font-size:1.2rem">Permisos</strong></div>
                <div class="card-body">
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Permisos por rol</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="rol_modulo"><input type="checkbox" class="mr-2" name="rol_modulo" id="rol_modulo">Ver modulo</label>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mb-3" style="max-width: 100%;">
            <div class="card" style="max-width: 100%;">
                <div class="card-header"><strong style="font-size:1.2rem">Historial</strong></div>
                <div class="card-body">
                    <label class="col-lg-3 col-md-6 col-sm-12" for=""><strong>Historial de cambios</strong>
                        <div class="card p-3 textcolorhover">
                            <label class="text-success" for="historial_modulo"><input type="checkbox" class="mr-2" name="historial_modulo" id="historial_modulo">Ver modulo</label>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>