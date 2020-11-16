//AGREGA UN CLIENTE NUEVO
$("#bodyContent").on("click", "#usuarios_add_btnAddUsuarios", function (e) {
    let formData = new FormData(document.getElementById('usuarios_AddUsuariosForm'))
    fetch("/usuarios/setUser", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            console.log(resp);
            if (resp.error == '00000') {
                document.getElementById("usuarios_AddUsuariosForm").reset();
                Swal.fire({
                    position: 'top',
                    title: 'Cliente Agregado',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500
                }, $("#clientes_addCliente").modal("toggle"))
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
//AGREGA UN CLIENTE NUEVO
$("#bodyContent").on("click", ".seeLinkBtnUser", function (e) {
    let formData = new FormData()
    let id = this.dataset.id
    formData.append('id', id)
    fetch("/verIdentificador", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            console.log(resp);
            let info = resp.data
            Swal.fire({
                position: 'top',
                title: 'Link para agregar contraseña',
                html: `<a href="/getPassword/${info.db}/${info.identificador}" target="_blank">${info.server}/getPassword/${info.db}/${info.identificador}</a>`,
                confirmButtonText: 'OK'
            })
        })
})
$("#setPasswordBtn").click(function () {
    let cPass = document.getElementById('cPass').value
    let nPass = document.getElementById('nPass').value
    if (nPass == cPass) {
        SetNewUserPassword()
    } else {
        Swal.fire({
            position: 'top',
            title: `Las contraseñas deben ser iguales.`,
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 2500,
            timerProgressBar: true
        })
    }
})

function SetNewUserPassword() {
    let form = document.getElementById('setPassUser')
    let formData = new FormData(form)

    fetch('/setPassword', {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            if (resp.error = "00000") {
                location.href = "/"
            }
            console.log(resp);
        })

}