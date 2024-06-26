$('#bodyContent').on('change', "#reportTypeSelect", function (e) {
    //let show = document.getElementById(this.value)
    // $('.optionselectReports').hide()
    // show.style.display = "block"
    let loadTable = document.getElementById("loadTable")
    loadTable.innerHTML = ""
    let reportTypeSelect = document.getElementById('reportTypeSelect').value

    let excelId = document.getElementById('excelIdReporteDiarioDetallado')
    excelId.style.display = "none"

    addComponent(reportTypeSelect)
    console.log(reportTypeSelect)
})
$('#bodyContent').on('click', ".generarReportesFac", function (e) {
    let type = e.target.dataset.type
    let urlReporte = ''
    let reportTypeSelect = document.getElementById('reportTypeSelect').value
    let dateInit = document.getElementById('dateInit').value
    let dateEnd = document.getElementById('dateEnd').value
    let params = {}
    switch (reportTypeSelect) {
        case 'rxCajas':
            let urlRxCajas = {
                html: "/reportes/rxCajas",
                pdf: `/reportes/rxfacDiaPDF`
            }
            urlRxCajas = urlRxfacDia[type]
            break;
        case 'rxfacDia':
            let urlRxfacDia = {
                html: "/reportes/rxfacDia",
                pdf: `/reportes/rxfacDiaPDF`
            }
            urlReporte = urlRxfacDia[type]
            break;
        case 'rxfacDiaDetalle':
            let urlRxfacDiaDetalle = {
                html: "/reportes/rxfacDiaDetalle",
                pdf: `/reportes/rxfacDiaDetallePDF`,
                excel: `/reportes/rxfacDiaDetalleExcel/?dateInit=${dateInit}&dateEnd=${dateEnd}`,
            }
            urlReporte = urlRxfacDiaDetalle[type]
            break;
        case 'rxVentasCliente':
            let rxFacturasXCliente = {
                html: "/reportes/rxFacturasXCliente",
                pdf: `/reportes/rxFacturasXClientePDF`
            }
            urlReporte = rxFacturasXCliente[type]
            break;
        case 'rxfacDiaDetalleMetodoPago':
            let rxFacturasXMetodoPago = {
                html: "/reportes/rxfacDiaDetalleMetodoPago",
                pdf: `/reportes/rxfacDiaDetalleMetodoPagoPDF`
            }
            urlReporte = rxFacturasXMetodoPago[type]
            let selectMetodPagoReport = document.getElementById('selectMetodPagoReport').value
            params = {
                metodo: selectMetodPagoReport
            }
            break;

        default:
            Swal.fire({
                position: 'top',
                title: 'Debes seleccionar un tipo de reporte antes de generar los datos',
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 4500,
                timerProgressBar: true
            })
            return
    }
    let formData = new FormData()
    let loadTable = document.getElementById("loadTable")
    formData.append('dateInit', dateInit)
    formData.append('dateEnd', dateEnd)
    if (Object.keys(params).length > 0) {
        Object.keys(params).map(e => formData.append(e, params[e]))
    }
    switch (type) {
        case 'html':
            loadTable.innerHTML = '<div class = "loading"><img src ="/public/assets/img/loading.gif" ></div>'

            fetch(urlReporte, {
                method: "POST",
                body: formData
            }).then(resp => resp.text())
                .then(resp => {

                    if (type == 'html') {

                        loadTable.innerHTML = resp
                    }

                })
            break;
        case 'pdf':
            fetch(urlReporte, {
                method: "POST",
                body: formData
            }).then(resp => resp.text())
                .then(resp => {

                    if (type == 'pdf') {

                        let h = resp;
                        let d = $("<div>").addClass("printContainer").html(h).appendTo("html");
                        window.print();
                        d.remove();
                    }

                })

            // window.open(urlReporte)
            break;
        case 'excel':
            window.open(urlReporte,'_self' )
            break;

        default:
            break;
    }

})

function addComponent(idSelect) {
    let addnewcomponent = document.getElementById('addnewcomponent')
    addnewcomponent.style.display = 'none'
    switch (idSelect) {
        case 'rxfacDiaDetalleMetodoPago':
            let componente = `
            <div class="col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Metodo</label>
                    </div>
                    <select class="custom-select" id="selectMetodPagoReport">
                        <option value="1" selected disabled>Efectivo</option>
                        <option value="2">Tarjeta</option>
                        <option value="3">Transferencia</option>
                    </select>
                </div>
            </div>
            `

            addnewcomponent.html = ''
            addnewcomponent.style.display = 'block'
            $(addnewcomponent).html(componente)
            break;
        case 'rxfacDiaDetalle':
            let excelId = document.getElementById('excelIdReporteDiarioDetallado')
            excelId.style.display = "inline"
            break
        default:
            return
    }
}