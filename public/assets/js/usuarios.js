//AGREGA UN Usuario NUEVO
$("#bodyContent").on("click", "#usuarios_add_btnAddUsuarios", function (e) {
    let formData = new FormData(document.getElementById('usuarios_AddUsuariosForm'))
    fetch("/usuarios/setUser", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            //console.log(resp);
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
$("#bodyContent").on("click", ".btnEditUserId", function (e) {
    loadDataEditModelUsers(e, '#usuarios_editUsuario')
});
$("#menuContainerId").on("click", "#change_user_pass", function (e) {
    //console.log(e.target)
    loadDataEditModelUsersPerfil(e, '#usuarios_editUsuario')
});
//CARGA DATOS DEL USUARIO A EDITAR
function loadDataEditModelUsers(el, formId) {
    let id = el.target.dataset.id
    document.getElementById("usuarios_editUsuariosForm").reset();
    let formData = new FormData()
    formData.append("id", id)
    fetch("/usuarios/getUserById", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            //console.log(resp);
            if (resp.error == '00000') {

                let iduser = document.getElementById('iduser')
                let usuarios_edit_nombre = document.getElementById('usuarios_edit_nombre')
                let usuarios_edit_correo = document.getElementById('usuarios_edit_correo')
                let usuarios_edit_telefono = document.getElementById('usuarios_edit_telefono')
                let usuarios_edit_direccion = document.getElementById('usuarios_edit_direccion')
                let usuarios_edit_rol = document.getElementById('usuarios_edit_rol')
                let data = resp.data
                iduser.value = data.idusuario
                usuarios_edit_nombre.value = data.nombre
                usuarios_edit_correo.value = data.email
                usuarios_edit_telefono.value = data.telefono
                usuarios_edit_direccion.value = data.direccion
                usuarios_edit_rol.value = data.rol

            } else {
                Swal.fire({
                        position: 'top',
                        title: 'Error al cargar los datos del usuario',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        timer: 2500
                    },
                    $("#usuarios_editUsuario").modal("toggle"))
            }

        })
}
//CARGA DATOS DEL Perfil A EDITAR
function loadDataEditModelUsersPerfil(el, formId) {
    let formData = new FormData()
    let iduser_perfil = document.getElementById('iduser_perfil').value
    formData.append("id", iduser_perfil)
    fetch("/usuarios/getUserById", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            //console.log(resp);
            if (resp.error == '00000') {
                let perfil_edit_nombre = document.getElementById('perfil_edit_nombre')
                let perfil_edit_correo = document.getElementById('perfil_edit_correo')
                let perfil_edit_telefono = document.getElementById('perfil_edit_telefono')
                let perfil_edit_direccion = document.getElementById('perfil_edit_direccion')
                let data = resp.data
                perfil_edit_nombre.value = data.nombre
                perfil_edit_correo.value = data.email
                perfil_edit_telefono.value = data.telefono
                perfil_edit_direccion.value = data.direccion

            } else {
                Swal.fire({
                        position: 'top',
                        title: 'Error al cargar los datos del usuario',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        timer: 3500,
                        timerProgressBar: true
                    },
                    $("#perfil_editperfilForm").modal("toggle"))
            }

        })
}
//Acutaliza el usuario
$("#bodyContent").on("click", "#usuarios_edit_btneditUsuarios", function (e) {
    let formData = new FormData(document.getElementById('usuarios_editUsuariosForm'))
    fetch("/usuarios/editUser", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            //console.log(resp);
            if (resp.error == '00000') {
                document.getElementById("usuarios_editUsuariosForm").reset();
                Swal.fire({
                    position: 'top',
                    title: 'Se actualizo el usuario correctamente',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500
                }, $("#usuarios_editUsuario").modal("toggle"))
            } else {
                Swal.fire({
                    position: 'top',
                    title: resp.msg,
                    text: resp.errorMsg,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })

            }

        })
})
//Acutaliza el perfil
$("#bodyHtml").on("click", "#perfil_edit_btneditperfil", function (e) {
    let formData = new FormData(document.getElementById('perfil_editperfilForm'))
    fetch("/usuarios/editUserPerfil", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            //console.log(resp);
            if (resp.error == '00000') {
                Swal.fire({
                    position: 'top',
                    title: 'Perfil Actualizado',
                    text: `Para ver los cambios, actualize la pagina`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 6000,
                    timerProgressBar: true
                })
            } else {
                Swal.fire({
                    position: 'top',
                    title: resp.msg,
                    text: resp.errorMsg,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })

            }

        })
})
//Acutaliza el pass
$("#bodyHtml").on("click", "#perfil_update_pass", async function (e) {
    let formData = new FormData(document.getElementById('perfil_editperfilForm'))
    let perfil_edit_pass_now = document.getElementById('perfil_edit_pass_now').value
    let perfil_edit_new_pass = document.getElementById('perfil_edit_new_pass').value
    let perfil_edit_confirm_pass = document.getElementById('perfil_edit_confirm_pass').value
    let confirm = await confirmPassNow()
    let samePass = (perfil_edit_new_pass.trim() == perfil_edit_confirm_pass.trim()) && (perfil_edit_new_pass.trim() != '' && perfil_edit_confirm_pass.trim() != '') ? true : false
    if (!samePass) {
        Swal.fire({
            position: 'top',
            title: "Contraseña no coincide",
            text: "Asegurese que los campos de Nueva contraseña y Confirmar contraseña coincidan y que los campos no este vacios",
            icon: 'error',
            confirmButtonText: 'OK'
        })
        return
    }
    console.log(confirm, samePass)
    if (confirm && samePass) {
        fetch("/usuarios/updatePass", {
                method: "POST",
                body: formData
            }).then(resp => resp.json())
            .then(resp => {
                if (resp.error == '00000') {
                    Swal.fire({
                        position: 'top',
                        title: 'Contraseña Actualizada',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 3000,
                        timerProgressBar: true
                    })
                } else {
                    Swal.fire({
                        position: 'top',
                        title: resp.msg,
                        text: resp.errorMsg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })

                }

            })
    }
})

async function confirmPassNow() {
    let formData = new FormData(document.getElementById('perfil_editperfilForm'))
    let resp = await fetch("/usuarios/confirmPassNow", {
        method: "POST",
        body: formData
    })
    let newData = await resp.json()
    if (newData.data.ok == true) {
        return true
    } else {
        Swal.fire({
            position: 'top',
            title: `Contraseña actual incorrecta`,
            icon: 'error',
            confirmButtonText: 'OK'
        })
        return false
    }


}
$("#bodyContent").on("click", ".seeLinkBtnUser", function (e) {
    let formData = new FormData()
    let id = this.dataset.id
    formData.append('id', id)
    fetch("/verIdentificador", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            //console.log(resp);
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
            //console.log(resp);
        })

}