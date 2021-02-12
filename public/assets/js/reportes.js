$('#bodyContent').on('change', "#reportTypeSelect", function (e) {
    let show = document.getElementById(this.value)
    $('.optionselectReports').hide()
    show.style.display = "block"
})
$('#bodyContent').on('click', ".generarReportesFac", function (e) {
    let type = e.target.dataset.type
    let urlReporte = ''
    let reportTypeSelect = document.getElementById('reportTypeSelect').value
    let dateInit = document.getElementById('dateInit').value
    let dateEnd = document.getElementById('dateEnd').value
    switch (reportTypeSelect) {
        case 'rxfacDia':
            let urlRxfacDia = {
                html: "/reportes/rxfacDia",
                pdf: `/reportes/rxfacDiaPDF?dateInit=${dateInit}&dateEnd=${dateEnd}`
            }
            urlReporte = urlRxfacDia[type]
            break;

        default:
            break;
    }
    switch (type) {
        case 'html':
            let formData = new FormData()
            formData.append('dateInit', dateInit)
            formData.append('dateEnd', dateEnd)

            fetch(urlReporte, {
                    method: "POST",
                    body: formData
                }).then(resp => resp.text())
                .then(resp => {
                    let loadTable = document.getElementById("loadTable")
                    if (type == 'html') {

                        loadTable.innerHTML = resp
                    }

                })
            break;
        case 'pdf':

            window.open(urlReporte)
            break;

        default:
            break;
    }

})