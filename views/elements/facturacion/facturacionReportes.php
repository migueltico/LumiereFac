<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Reportes de factura</h4>
        <div class="row mb-2">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Reportes</label>
                    </div>
                    <select class="custom-select" id="reportTypeSelect">
                        <option value="0" selected disabled>Seleccione un reporte</option>
                        <option value="rxfacDia">1-Reporte por Facturas Diarias</option>
                        <option value="rxfacDiaDetalle">2-Reporte por Facturas Diarias Detallada</option>
                        <!-- <option value="2">2-Reporte de Facturas Diario</option> -->
                        <!-- <option value="3">3-Reporte de Facturas con envios pendientes</option> -->
                        <!-- <option value="4">4-Reporte de Apartados completados</option> -->
                    </select>
                </div>
            </div>
        </div>
        <div class="row optionselectReports col mb-2" id="rxfacDia" style="display: none;">
            <h3>Reporte por Facturas Diarias</h3>
        </div>
        <div class="row optionselectReports col mb-2" id="rxfacDiaDetalle" style="display: none;">
            <h3>Reporte por Facturas Diarias Detallada</h3>
        </div>
        <hr>
        <div class="row mt-3">
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
    </div>
    <div class="card-body loadTable" id="loadTable">
    </div>

</div>