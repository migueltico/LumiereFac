<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">


        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Vendedor</button>
                            </div>
                            <input type="text" disabled class="form-control text-right" data-cliente="1" placeholder="Cliente" value="Julio cesar">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Cliente</button>
                            </div>
                            <input type="text" class="form-control text-right" data-cliente="1" placeholder="Cliente" value="Generico">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="btn btn-outline-secondary" type="button" id="button-addon1">Fecha</label>
                            </div>
                            <input type="text" disabled id="datePickerInput" class="form-control text-right" data-cliente="1" value="<?= date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">

                        <div class="mb-3" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary">Large button</button>
                            <button type="button" class="btn btn-secondary">Large button</button>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button">Tipo</button>
                            </div>
                            <select class="custom-select" id="inputGroupSelect03">
                                <option selected value="1">Efectivo</option>
                                <option value="2">Tarjeta</option>
                                <option value="2">Transferencia</option>
                                <option value="3">Envio</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-lg-6">

                        <div class="totalFactAmount" id="totalFactAmount">0.00</div>

                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="input-group mb-3 col-lg-6 col-md-6 col-sm-10">
                        <div class="input-group-prepend">
                            <label class="btn btn-outline-secondary" type="button">Codigo de Barras</label>
                        </div>
                        <input type="text" autocomplete="on" class="form-control" id="ScanCode" data-cliente="1" autofocus="on" placeholder="Escanea o Digita el codigo" value="">
                        <input type="hidden" name="" id="bodyFactMain" value="1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
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
                            </tr>
                        </thead>
                        <tbody id="appendItemRowProduct">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <h3 id="CantidadFooterFact">Cantidad: 0</h3>
            </div>
        </div>
    </div>
    <?php include(self::modal('modalSearchProductFact')) ?>
</div>