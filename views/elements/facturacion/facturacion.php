<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">


        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="fac_vendedor">Vendedor</button>
                            </div>
                            <input type="text" disabled class="form-control text-right" data-vendedor="<?= $_SESSION['id'] ?>" value="<?= $_SESSION['nombre'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#SearchClientModal" type="button" id="fac_cliente">Cliente</button>
                            </div>
                            <input type="text" disabled id="fac_cliente_input" class="form-control text-right" data-cliente="0" placeholder="Cliente" value="Generico">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="btn btn-outline-secondary" type="button" id="fac_fecha">Fecha</label>
                            </div>
                            <input type="text" disabled id="datePickerInput" class="form-control text-right" data-cliente="1" value="<?= date('d-m-Y'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">

                        <div class="mb-3" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary">ENVIO</button>
                        </div>



                    </div>
                    <div class="col-lg-6">

                        <div class="totalFactAmount" id="totalFactAmount">0.00</div>

                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="input-group mb-3 col-lg-6 col-md-6 col-sm-8">
                        <div class="input-group-prepend">
                            <label class="btn btn-outline-secondary" id="btnCodigoBarrasModal" type="button">Buscar</label>
                        </div>
                        <input type="text" autocomplete="on" class="form-control" id="ScanCode" data-cliente="1" autofocus="on" placeholder="Escanea o Digita el codigo" value="094738581">
                        <input type="hidden" name="" id="bodyFactMain" value="1">
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
    <?php include_once(self::modal('modalSearchClient')) ?>
    <?php include_once(self::modal('modalAddCliente')) ?>
    <?php include_once(self::modal('modalFacSend')) ?>
</div>
<div class="" id="printContainer"></div>