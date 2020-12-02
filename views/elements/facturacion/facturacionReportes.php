<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Reportes de factura</h4>
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

        </div>

    </div>
    <div class="card-body loadTable">
    </div>

</div>