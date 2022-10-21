<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Reportes de factura</h4>
        <!-- //TODO: actualizar suma de tarjetas en cada reportes, no toma en cuenta tarjetas multiples -->
        <div class="row mb-2">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Reportes</label>
                    </div>
                    <select class="custom-select" id="reportTypeSelect">
                        <option value="0" selected disabled>Seleccione un reporte</option>
                        <option value="rxfacDia">1-Reporte de Facturas Diarias</option>
                        <option value="rxfacDiaDetalle">2-Reporte de Facturas Diarias Detallada</option>
                        <option value="rxfacDiaDetalleMetodoPago">3-Reporte de Facturas Diarias Detallada por Metodo de pago</option>
                        <option value="rxVentasCliente">4-Reporte de Facturas por Cliente</option>
                        <!-- <option value="2">2-Reporte de Facturas Diario</option> -->
                        <!-- <option value="3">3-Reporte de Facturas con envios pendientes</option> -->
                        <!-- <option value="4">4-Reporte de Apartados completados</option> -->
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-3">
            <div class="row col">
                <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-wrapping">Fecha Inicio</span>
                        </div>
                        <input id="dateInit" type="date" class="form-control" value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-wrapping">Fecha Final</span>
                        </div>
                        <input id="dateEnd" type="date" class="form-control" value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
                <div id="addnewcomponent" class="col-lg-2 col-md-6 col-sm-12 mb-1" style="display: none;">
                    
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-1 flex-row">
                    <button data-type="html" class="btn btn-primary generarReportesFac">Generar</button>
                    <button data-type="pdf" class="btn btn-info generarReportesFac">PDF</button>
                    <button data-type="excel" id="excelIdReporteDiarioDetallado" class="btn btn-primary generarReportesFac" style="display: none;">Excel</button>
                </div>
            </div>

        </div>
    </div>
    <div class="card-body loadTable" id="loadTable">
    </div>

</div>