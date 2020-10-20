//AGREGA UN CLIENTE NUEVO
$("#bodyContent").on("click", "#usuarios_add_btnAddUsuarios", function (e) {
    let formData = new FormData(document.getElementById('usuarios_AddUsuariosForm'))
    fetch("usuarios/setUser", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            console.log(resp);
            // if (resp.error == '00000') {                
            //     document.getElementById("usuarios_AddUsuariosForm").reset();
            //     Swal.fire({
            //         position: 'top',
            //         title: 'Cliente Agregado',
            //         icon: 'success',
            //         confirmButtonText: 'OK',
            //         timer: 2500
            //     }, $("#clientes_addCliente").modal("toggle"))
            // } else if(resp.error ==="CLIENTE00002") {
            //     Swal.fire({
            //         position: 'top',
            //         title: resp.msg,
            //         text: resp.errorMsg,
            //         icon: 'error',
            //         confirmButtonText: 'OK'
            //     })
            
            // } else {
            //     Swal.fire({
            //         position: 'top',
            //         title: resp.msg,
            //         text: resp.errorData.errorMsg[2],
            //         icon: 'error',
            //         confirmButtonText: 'OK'
            //     })
            // }

        })
})