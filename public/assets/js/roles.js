function getRoles() {
    let formData = new FormData()
    let cb = document.getElementById("cbSelectRol")
    let id = cb.options[cb.selectedIndex].value

    formData.append('id', id)
    fetch("/roles/getRoles", {
            method: "POST",
            body: formData
        }).then(resp => resp.text())
        .then(resp => {
            let tablerols = document.getElementById('tablerols')
            tablerols.innerHTML = resp
            setPermisos()

        })
}
$("#bodyContent").on("change", "#cbSelectRol", function () {
    getRoles()
})
$("#bodyContent").on("click", "#btnCrearRol", function () {
    newRol()
})
$("#bodyContent").on("click", "#btnSaveRols", function () {
    saveRoles()
})

function newRol() {
    let form = document.getElementById("rols_form_addrol")
    let formData = new FormData(form)
    fetch("/roles/newRol", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            if (resp.error == "00000") {
                $("#rols_addrol").modal("toggle")
                loadPage(null, "/roles")
                Swal.fire({
                    position: 'top',
                    title: `Rol agregado correctamente`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })


            }
        })
}

function saveRoles() {
    let form = document.getElementById("permisosForm")
    let formData = new FormData(form)
    let cb = document.getElementById("cbSelectRol")
    let rol = cb.options[cb.selectedIndex].textContent
    fetch("/roles/saveRoles", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            if(resp.error =="00000"){
                Swal.fire({
                    position: 'top',
                    title: `Permisos Agregados`,
                    html:`Se agregaron los permisos del Rol: <strong>${rol}</strong>`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
            }
        })
}

function setPermisos() {
    let cb = document.getElementById("cbSelectRol")
    let id = cb.options[cb.selectedIndex].value
    let formData = new FormData()
    formData.append('id', id)
    fetch("/roles/getRolesPermisos", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            if (resp !== "" && resp !== null) {

                Object.keys(resp).map(key => {
                    let elem = document.getElementById(key)
                    elem.checked = true
                })
            }
        })
}