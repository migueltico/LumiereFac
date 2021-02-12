<div class="row optionselectReports" id="rxfacDia" style="display: none;">
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
    <div class="row col">
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