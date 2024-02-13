//AGREGA UN CLIENTE NUEVO
$("#bodyContent").on("click", "#clientes_add_btnAddCliente", function (e) {
    let formData = new FormData(document.getElementById('clientes_AddClienteForm'))
    let hasError = false
    let msgError = ""
    let clienteName = formData.get("nombre")
    let inputCliente = document.getElementById("fac_cliente_input")
    //validar que los campos no esten vacios en nombre y tel 
    if (formData.get("nombre") === "") {
        msgError += "El campo nombre no puede estar vacío.<br>"
        hasError = true
    }

    if (formData.get("tel") === "") {
        msgError += "El campo teléfono no puede estar vacío.<br>"
        hasError = true
    }
    //validar que el telefono sea numerico
    if (isNaN(formData.get("tel"))) {
        msgError += "El campo teléfono debe ser numérico.<br>"
        hasError = true
    }

    if (hasError) {
        //show swal with html content
        Swal.fire({
            position: 'top',
            title: 'Error',
            html: msgError,
            icon: 'error',
            confirmButtonText: 'OK'
        })
        return
    }
    
    fetch("clientes/addcliente", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            if (resp.error == '00000') {
                refreshClients()
                document.getElementById("clientes_AddClienteForm").reset();
                Swal.fire({
                    position: 'top',
                    title: 'Cliente Agregado',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500
                }, $("#clientes_addCliente").modal("toggle"))
                //agrega el id al #fac_cliente_input en el data-cliente si el input existe
                console.log({
                    inputCliente,
                    resp,
                    clienteName
                })
                if (inputCliente) {
                    inputCliente.value = clienteName
                    inputCliente.dataset.cliente = resp.lastID
                    console.log({
                      clienteName,
                        lastID: resp.lastID  
                    })
                }
            } else if (resp.error === "CLIENTE00002") {
                Swal.fire({
                    position: 'top',
                    title: resp.msg,
                    text: resp.errorMsg,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })

            } else {
                Swal.fire({
                    position: 'top',
                    title: resp.msg,
                    text: resp.errorData.errorMsg[2],
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }

        })
})

//CARGA LOS DATOS AL MODAL DE EDIT DE UN CLIENTE
$("#bodyContent").on("click", ".clientes_EditBtn", function (e) {
    document.getElementById("clientes_EditClienteForm").reset();
    let id = e.target.dataset.id
    let formData = new FormData()
    formData.append("id", id)
    fetch("clientes/getClienteById", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            let cliente = resp.data
            let id = document.getElementById("clientes_edit_id")
            let nombre = document.getElementById("clientes_edit_nombre")
            let cedula = document.getElementById("clientes_edit_cedula")
            let telefono = document.getElementById("clientes_edit_telefono")
            let email = document.getElementById("clientes_edit_email")
            let direccion = document.getElementById("clientes_edit_direccion")
            let direccion2 = document.getElementById("clientes_edit_direccion2")
            id.value = cliente.idcliente
            nombre.value = cliente.nombre
            cedula.value = cliente.cedula
            telefono.value = cliente.telefono
            email.value = cliente.email
            if (cliente.direccion.includes(';')) {

                let strDireccion = cliente.direccion.split(';')
                direccion.value = strDireccion[0]
                direccion2.value = strDireccion[1]
            } else {
                direccion.value = cliente.direccion
            }
            $("#clientes_editCliente").modal("toggle")

        })
})
//ACTUALIZA LOS DATOS DE UN CLIENTE
$("#bodyContent").on("click", "#clientes_edit_btnAddCliente", function (e) {

    let formData = new FormData(document.getElementById('clientes_EditClienteForm'))
    fetch("clientes/updateClienteById", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            if (resp.error == '00000') {
                refreshClients()
                Swal.fire({
                    position: 'top',
                    title: 'Cliente Agregado',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500
                }, $("#clientes_editCliente").modal("toggle"))
            } else {
                Swal.fire({
                    position: 'top',
                    title: resp.msg,
                    text: resp.errorData.errorMsg[2],
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                //console.log(resp);
            }

        })
        .catch(error => console.log(error))
})
$("#bodyContent").on("click", "#clientes_RefreshClientes", refreshClients)

function refreshClients() {
    let img = ` <div class = "loading"><img src ="/public/assets/img/loading.gif" ></div>`;
    $(".loadTable").html('')
    $(".loadTable").append(img)
    fetch("clientes/refreshClients", {
            method: "POST"
        }).then(resp => resp.text())
        .then(resp => {
            $(".loadTable").html(resp)
        })
}