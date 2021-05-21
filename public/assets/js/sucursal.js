    $('#bodyContent').on("click", "#EditSucursalModal #btnAddSucursal", function (e) {
        e.preventDefault();
        AddSucursal()
    })
    $('#bodyContent').on("click", "#EditSucursalModal #btnEditSucursal", function (e) {
        e.preventDefault();
        updateSucursal()
    })
    $('#bodyContent').on("click", ".openEditSucursalBtn", function (e) {
        e.preventDefault();
        document.getElementById("EditSucursalForm").reset();
        let id = $(e.target).data('id')
        loadSucursal(id)
        $("#EditSucursalModal #TitleEditSucursal").text(`Editar Sucursal # ${id}`)
    })
    $('#bodyContent').on("click", ".DeleteSucursalBtn", function (e) {
        e.preventDefault();
        let id = $(e.target).data('id')
        deleteSucursal(id)
        //console.log(id);
    })
    $('#bodyContent').on("click", "#newSucursal", function (e) {
        document.getElementById("AddSucursalForm").reset();
    })
    $('#bodyContent').on("click", "#btnRefrescarSucursal", function (e) {
        e.preventDefault();
        loadTableSucursal(e)
    })

    function AddSucursal() {
        let form = document.getElementById('AddSucursalForm')
        let formData = new FormData(form)
        fetch('/sucursal/addSucursal', {
                method: 'POST',
                body: formData
            }).then(resp => resp.json())
            .then(resp => {
                //console.log(resp);
            })
    }


    function updateSucursal() {
        let form = document.getElementById('EditSucursalForm')
        let formData = new FormData(form)
        fetch('/sucursal/updateSucursal', {
                method: 'POST',
                body: formData
            }).then((result) => result.json())
            .then(resp => {
                //console.log(resp);
                $(`#EditSucursalModal`).modal('toggle')
                loadTableSucursal()
            })
    }

    function loadSucursal(id) {
        let formData = new FormData()
        formData.append('idsucursal', id)

        fetch('/sucursal/getSucursalById', {
                method: 'POST',
                body: formData
            }).then((result) => result.json())
            .then(resp => {
                let data = resp.data
                //console.log(data);
                $("#EditSucursalModal #sucursal").val(data.descripcion)
                $("#EditSucursalModal #idsucursal").val(data.idsucursal)
                $("#EditSucursalModal #ubicacion").val(data.ubicacion)
                $("#EditSucursalModal #tel").val(data.telefono)
            })
    }

    function deleteSucursal(id) {
        let formData = new FormData()
        formData.append('idsucursal', id)

        fetch('/sucursal/deleteSucursal', {
                method: 'POST',
                body: formData
            }).then((result) => result.json())
            .then(resp => {
                if (resp.errorMsg[1] == '1451') {

                    Swal.fire({
                        position: 'top',
                        title: 'Error al eliminar Sucursal',
                        text: resp.errorMsg[2],
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                } else {

                    Swal.fire({
                        position: 'top',
                        title: 'Sucursal Eliminada',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
                    loadTableSucursal()
                }
            })
    }

    function loadTableSucursal(e) {
        let img = '<div class="loading"><img src="/public/assets/img/loading.gif"></div>';
        $(".sucursalTable").html('')
        $(".sucursalTable").append(img)
        fetch('/sucursal/refresh/sucursaltable', {
                method: 'POST'
            })
            .then((result) => result.text())
            .then((html) => {
                $(".sucursalTable").html(html)
            })
            .catch((err) => {
                //console.log('error en FETCH:', err);
            });
    }