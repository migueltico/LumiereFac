$('#bodyContent').on('change', "#reportTypeSelect", function (e) {
    //let show = document.getElementById(this.value)
   // $('.optionselectReports').hide()
   // show.style.display = "block"
   let loadTable = document.getElementById("loadTable")
   loadTable.innerHTML = ""
})
$('#bodyContent').on('click', ".generarReportesFac", function (e) {
    let type = e.target.dataset.type
    let urlReporte = ''
    let reportTypeSelect = document.getElementById('reportTypeSelect').value
    let dateInit = document.getElementById('dateInit').value
    let dateEnd = document.getElementById('dateEnd').value
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
                pdf: `/reportes/rxfacDiaDetallePDF`
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
            break;
    }
    let formData = new FormData()
    let loadTable = document.getElementById("loadTable")
    formData.append('dateInit', dateInit)
    formData.append('dateEnd', dateEnd)
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

        default:
            break;
    }

})