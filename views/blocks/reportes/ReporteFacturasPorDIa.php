<div class="row optionselectReports" id="rxfacDia" style="display: none;">
    <div class="row col">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-wrapping">Fecha Inicio</span>
                </div>
                <input id="dateInit" type="date" class="form-control" value="<?= date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-wrapping">Fecha Final</span>
                </div>
                <input id="dateEnd" type="date" class="form-control" value="<?= date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
            <button data-type="html" class="btn btn-primary generarReportesFac">Generar</button>
            <button data-type="pdf" class="btn btn-info generarReportesFac">PDF</button>
        </div>
    </div>
    
</div>