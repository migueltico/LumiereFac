<div class="card mb-5 shadow">
    <div class="card-header">
        <h4>Reportes de factura</h4>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Reportes</label>
                    </div>
                    <select class="custom-select" id="reportTypeSelect">
                        <option selected disabled>Seleccione un reporte</option>
                        <option value="rxfacDia">1-Reporte por Facturas Diarias</option>
                        <!-- <option value="2">2-Reporte de Facturas Diario</option> -->
                        <!-- <option value="3">3-Reporte de Facturas con envios pendientes</option> -->
                        <!-- <option value="4">4-Reporte de Apartados completados</option> -->
                        <!-- <option value="5">5-Reporte de Apartados vencidos</option> -->
                        <!-- <option value="6">6-Reporte de Apartados sin cancelar</option> -->
                    </select>
                </div>
            </div>
        </div>
        <?php include(self::block('reportes/ReporteFacturasPorDia')) ?>


    </div>
    <div class="card-body loadTable" id="loadTable">
    </div>

</div>