<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">


        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="fac_vendedor">Cajero</button>
                            </div>
                            <input type="text" id="InputVendedorFact" disabled class="form-control text-right" data-vendedor="<?= $_SESSION['id'] ?>" value="<?= $_SESSION['nombre'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#SearchClientModal" type="button" id="fac_cliente">Cliente</button>
                            </div>
                            <input type="text" disabled id="fac_cliente_input" class="form-control text-right" data-idGenerico="<?= $cliente['idcliente'] ?>" data-cliente="<?= $cliente['idcliente'] ?>" placeholder="Cliente" value="<?= $cliente['nombre'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="btn btn-outline-secondary" type="button" id="fac_fecha">Fecha</label>
                            </div>
                            <input type="text" disabled id="datePickerInput" class="form-control text-right" data-cliente="1" value="<?= date('d-m-Y'); ?>">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <input type="checkbox" id="canDiscountFac"></span>
                            </div>
                            <select class="custom-select" id="descuentosSelect" disabled data-toggle="tooltip" data-placement="top" title="En caso de aplicar descuento seleccione el descuento al tener todos los articulos seleccionados. (Desactive y vuelva a seleccionar para aplicar a nuevos articulos agregados)">
                                <option selected disabled>Seleccione un descuento</option>
                                <?php foreach ($descuentos as $descuento) :  ?>
                                    <option value="<?= $descuento['descuento'] ?>"><?= $descuento['descripcion']  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">

                        <div class="btn-group " role="group" id="group_type_fac">
                            <button type="button" data-tipo="1" id="btnTypeLocal" class="btn active btn-primary">Local</button>
                            <button type="button" data-tipo="2" id="btnTypeEnvio" class="btn btn-info">Envio</button>
                            <button type="button" data-tipo="3" id="btnTypeApartado" class="btn btn-info">Apartado</button>
                            <div class="custom-control custom-switch mt-2 ml-3" style="display: none;" id="ckAbonoSwWrapper">
                                <input type="checkbox" class="custom-control-input" id="ckAbonoSw">
                                <label class="custom-control-label" for="ckAbonoSw">Abono</label>
                            </div>
                            <div class="custom-control custom-switch mt-2 ml-3" id="ckCambiosWrapper">
                                <input type="checkbox" class="custom-control-input" id="ckCambios">
                                <label class="custom-control-label" for="ckCambios">Cambio o devoluciones <button type="text" placeholder="Inhabilitado" disable></button></label>
                            </div>
                        </div>
                        <div class="input-group mb-3 mt-3" id="apartadosWrapper" style="display: none;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" data-factura='0' id="btnMakeAbono" type="button">Apartados <?= $icons['eye'] ?></button>
                            </div>
                            <select class="custom-select" id="apartadosSelect">
                            </select>
                        </div>
                        <div class="input-group mb-3 mt-3" id="precioEnvioWrapper" style="display: none;max-width:300px">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="btn btn-outline-secondary" type="button" id="fac_fecha">Precio Envio</label>
                                </div>
                                <input type="text" class="form-control text-right" id="precioEnvio" value="0.00">
                            </div>
                        </div>
                        <div id="groupCambiosBtn" class="form-group p-2 pr-4 pt-3 mr-3 mt-3" style="display: none;">
                            <div class="input-group mb-3">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend mr-2">
                                        <span class="btn btn-info" id="btnCambios_fac" type="button" class="input-group-text" data-toggle="tooltip" data-placement="top" title="Busqueda de factura y aplicacion de devoluciones">Devoluciones</span>
                                    </div>
                                    <input id="inputSearchFacSaldo" type="text" class="form-control  p-3" placeholder="# factura para cambio o devolucion" data-toggle="tooltip" data-placement="top" title="presione ENTER para consultar la factura con saldo">
                                    <button id="resetSaldostatus" type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Cancelar uso de saldo"><?=$icons['xcircle'] ?></button>
                                </div>
                            </div>
                            <div class="input-group mb-3 hiddenSaldosInput" style="display: none;">
                                <div class="input-group mb-3 col-6">
                                    <div class="input-group-prepend mr-2">
                                        <span class="btn"> <strong>Saldo Actual:</strong> </span>
                                    </div>
                                    <input id="inputFacSaldoNow" style="width:50px !important;" type="text" class="form-control  p-3" placeholder="0.00" data-toggle="tooltip" data-placement="top" title="Saldo" disabled>
                                </div>
                            </div>
                            <div class="input-group mb-3 hiddenSaldosInput" style="display: none;">
                                <div class="input-group mb-3 col-6">
                                    <div class="input-group-prepend mr-2">
                                        <span class="btn"> <strong>Nuevo Saldo:</strong> </span>
                                    </div>
                                    <input id="inputFacNewSaldoNow" style="width:50px !important;" type="text" class="form-control  p-3" placeholder="0.00" data-toggle="tooltip" data-placement="top" title="Nuevo Saldo" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">

                        <div class="totalFactAmount" data-amount="0.00" style="max-height: 150px;" id="totalFactAmount">0.00</div>

                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="input-group mb-3 col-lg-6 col-md-6 col-sm-8">
                        <div class="input-group-prepend">
                            <label class="btn btn-outline-secondary" id="btnCodigoBarrasModal" type="button">Buscar</label>
                        </div>
                        <input type="text" autocomplete="on" class="form-control" id="ScanCode" autofocus="on" placeholder="Escanea o Digita el codigo" value="">
                        <input type="hidden" name="" id="bodyFactMain" data-number="1">
                    </div>

                    <div class="input-group mb-3 col-lg-6 col-md-6 col-sm-4">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#FacSendModal" id="PrintFactBtn">FACTURAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card mb-3 ">
            <div class="card-body responsiveTableHeigth">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col">Codigo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Talla</th>
                                <th scope="col">IVA</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Descuento</th>
                                <th scope="col">SubTotal</th>
                                <th scope="col">Total IVA</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="appendItemRowProduct">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <h3 id="CantidadFooterFact">Cantidad de Lineas: 0</h3>
            </div>
        </div>
    </div>
    <?php include_once(self::modal('modalSearchProductFact')) ?>
    <?php include_once(self::modal('modalSearchFac')) ?>
    <?php include_once(self::modal('modalSearchClient')) ?>
    <?php include_once(self::modal('modalAddCliente')) ?>
    <?php include_once(self::modal('modalFacSend')) ?>
    <?php include_once(self::modal('modalAbonarApartado')) ?>
</div>
<div class="" id="printContainer"></div>