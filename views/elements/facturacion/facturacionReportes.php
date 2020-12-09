<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Reportes de factura</h4>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Reportes</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                        <option selected disabled>Seleccione un reporte</option>
                        <option value="1">1-Reporte de Facturas</option>
                        <option value="2">2-Reporte de Facturas por Tipo de venta</option>
                        <option value="3">3-Reporte de Facturas con envios pendientes</option>
                        <option value="4">4-Reporte de Apartados completados</option>
                        <option value="5">5-Reporte de Apartados vencidos</option>
                        <option value="6">6-Reporte de Apartados sin cancelar</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-1 ">
                <div class="selected row p-3">
                    <div class="form-group border border-gray p-2 pr-4 pt-3 mr-3">
                        <div class="custom-control">
                            <input type="radio" id="localradio" name="tipoFac" class="" checked>
                            <label class="" for="localradio">Venta Local</label>
                        </div>
                        <div class="custom-control">
                            <input type="radio" id="envioradio" name="tipoFac" class="">
                            <label class="" for="envioradio">Envios</label>
                        </div>
                        <div class="custom-control">
                            <input type="radio" id="apartadoradio" name="tipoFac" class="">
                            <label class="" for="apartadoradio">Apartados</label>
                        </div>
                    </div>
                    <div class="form-group border border-gray p-2 pr-4 pt-3 mr-3">
                        <div class="custom-control">
                            <input type="radio" id="radioCancelado" name="estadoFac" class="" checked>
                            <label class="" for="radioCancelado">Monto Cancelado</label>
                        </div>
                        <div class="custom-control">
                            <input type="radio" id="radioPendiente" name="estadoFac" class="">
                            <label class="" for="radioPendiente">Pendiente cancelacion</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Fecha Inicio</span>
                    </div>
                    <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Fecha Final</span>
                    </div>
                    <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                <button class="btn btn-primary">Generar</button>
            </div>



        </div>

    </div>
    <div class="card-body loadTable">
    </div>

</div>