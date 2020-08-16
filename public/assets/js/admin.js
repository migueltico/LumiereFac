//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
/////////////////////////----GASTOS----///////////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

$('#bodyContent').on("click", "#addNewLineGasto", function (e) {
    e.preventDefault();
    addNewLineGasto(e)
})

$('#bodyContent').on("click", "#btnSaveGastos", function (e) {
    e.preventDefault();
    SaveGastos(e)
})
$('#bodyContent').on("dblclick", ".gastosLabel", function (e) {
    $(this).prop('contenteditable', true)
    $(this).focus()
})

//DETECTA EL DOBLE CLICK EN TOUCH
var touchtime = 0;
$('#bodyContent').on("click", ".gastosLabel", function () {
    if (touchtime == 0) {
        touchtime = new Date().getTime();
    } else {
        if (((new Date().getTime()) - touchtime) < 800) {

            //AQUI SE EJECUTA LA FUNCION SI SE CUMPLE EL DOBLE CLICK
            $(this).prop('contenteditable', true)
            $(this).focus()
            touchtime = 0;
        } else {
            touchtime = 0;
        }
    }
});



$('#bodyContent').on("keypress", ".gastosLabel", function (e) {
    if (e.charCode == 13) {
        $(this).prop('contenteditable', false)
    }
})
$('#bodyContent').on("blur", ".gastosLabel", function (e) {
    $(this).prop('contenteditable', false)

})
$('#bodyContent').on("click", ".RemoveInputGastos", function (e) {
    $(this).parent().remove()
    totalGastosLabel()

})

$('#bodyContent').on("blur", ".inputGastos", function (e) {
    if (this.value == '') this.value = 0.00
    e.preventDefault();
    this.value = parseFloat(this.value.replace(/,/g, ""))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    totalGastosLabel()
    //document.getElementById("display").value = this.value.replace(/,/g, "")
})

function addNewLineGasto(e) {
    let nombre = $("#txtAddNewLineGasto").val()
    console.log(nombre);
    let inputRow = ` <div class="input-group mb-3 col-lg-12 col-md-12 col-sm-12">
                        <div class="input-group-prepend tagNameGastos">
                            <span class="input-group-text gastosLabel" data-toggle="tooltip" data-placement="bottom" title="Doble click para cambiar nombre" id="inputGroup-sizing-default">${nombre}</span>
                            <span class="input-group-text">₡</span>
                        </div>
                        <input type="text" class="form-control inputGastos" data-name="${nombre}" value="0.00">
                        <div class="RemoveInputGastos">x</div>
                    </div>`
    $("#inputGroupGastos").append(inputRow)
}

function SaveGastos() {
    let items = []
    $(".inputGastos").each((i, item) => {
        let name = $(item).parent().children('.tagNameGastos').children('span.gastosLabel').text();
        let value = item.value.trim()
        //name = name.replace(',', '')
        name = name.replace(':', '')
        if (value == 'NaN') value = 0.00
        let data = `${name.trim()}:${value}`
        items.push(data.replace(',', ''))
    })
    // console.log(items);
    let formData = new FormData()
    formData.append("gastos", items)
    fetch("/admin/gastos/saveGastos", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            if (resp.error == '00000') {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Datos Guardados correctamente',
                    showConfirmButton: true,
                    timer: 1500
                })
            } else {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Error al Guardar los datos',
                    text: resp.errorMsg,
                    showConfirmButton: true,
                    timer: 1500
                })
            }
        })
    //console.log(items);
}

function totalGastosLabel() {
    let total = parseFloat(0.00)
    $(".inputGastos").each((i, item) => {
        let valor = $(item).val();
        valor = parseFloat(valor.replace(',', ''))
        // console.log(total, valor);
        total = parseFloat(total + valor)
    })
    total = total
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");


    $("#bodyContent #totalGastosLabel").text('₡ ' + total)
}

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
///////////////////////----END GASTOS----/////////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////----CATEGORIA DE PRECIOS----////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

$('#bodyContent').on("click", "#addNewLineCategoriaPrecio", function (e) {
    e.preventDefault();
    addNewLineCategoriaPrecio(e)
})
$('#bodyContent').on("click", ".EditCategoriaPreciosBtn", function (e) {
    e.preventDefault();
    LoadEditCategoriaPrecio(e)
})
$('#bodyContent').on("click", ".DeleteCategoriaPreciosBtn", function (e) {
    e.preventDefault();
    let id = e.target.dataset.id;
    DeleteCategoriaPrecio(id)
})
$('#bodyContent').on("click", "#editCategoriaPrecio_save", function (e) {
    e.preventDefault();
    SaveEditLineCategoriaPrecio(e)
})

function RefreshCategoriaPrecios() {
    fetch("/admin/categoriaprecios", {
            method: "POST"
        }).then(resp => resp.text())
        .then(resp => {
            $(".bodyContent").html(resp)
        })
}

function addNewLineCategoriaPrecio(e) {
    let descripcion = $("#txtDescripcionCategoriaPrecio").val()
    let factor = $("#txtFactorCategoriaPrecio").val()


    if (factor !== "" && descripcion !== "") {
        let formData = new FormData()
        formData.append("descripcion", descripcion)
        formData.append("factor", factor)
        fetch("/admin/categoriaprecios/add", {
                method: "POST",
                body: formData
            }).then(resp => resp.json())
            .then(resp => {
                if (resp.error == '00000') {
                    RefreshCategoriaPrecios()
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Datos Guardados correctamente',
                        showConfirmButton: true,
                        timer: 1500
                    })

                } else {
                    RefreshCategoriaPrecios()
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Error al Guardar los datos',
                        text: resp.errorMsg,
                        showConfirmButton: true,
                    })
                }

            })
    } else {
        Swal.fire({
            position: 'top',
            icon: 'error',
            title: 'Los campos deben contener informacion',
            showConfirmButton: true,
        })
    }
}

function loadTableCategoriasPrecios(e) {

    fetch("/admin/categoriaprecios/table", {
            method: "POST",
        }).then(resp => resp.text())
        .then(resp => {
            $("#bodyContent .tableJoin").html(resp)
            $(`#editCategoriaPrecios`).modal('toggle')
        })
}

function DeleteCategoriaPrecio(id) {
    let formData = new FormData()
    formData.append("id", id)
    fetch("/admin/categoriaprecios/delete", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {

            if (resp.error == '00000') {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Datos Guardados correctamente',
                    showConfirmButton: true,
                    timer: 1500
                })
            } else if (resp.errorMsg[1] == '1451') {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Error al eliminar la categoria',
                    text: "No se puede eliminar la categoria, por que existen productos dependientes de la misma.",
                    showConfirmButton: true,
                })
            }
        })
}

function LoadEditCategoriaPrecio(e) {
    let descripcionLabel = document.getElementById("editCategoriaPrecio_descripcion_label")
    let descripcion = document.getElementById("editCategoriaPrecio_descripcion")
    let factor = document.getElementById("editCategoriaPrecio_factor")
    let id = document.getElementById("editCategoriaPrecio_id")
    //console.log(descripcion, factor);
    descripcion.value = e.target.dataset.descripcion
    descripcionLabel.innerText = `Editar Categoria de precio #${e.target.dataset.id}`
    factor.value = e.target.dataset.factor
    id.value = e.target.dataset.id
    //console.log(e.target.dataset.descripcion);
    //console.log(e.target.dataset.factor);
}

function SaveEditLineCategoriaPrecio(e) {
    let descripcion = $("#editCategoriaPrecio_descripcion").val()
    let factor = $("#editCategoriaPrecio_factor").val()
    let id = $("#editCategoriaPrecio_id").val()
    let formData = new FormData()
    formData.append("descripcion", descripcion)
    formData.append("factor", factor)
    formData.append("id", id)
    fetch("/admin/categoriaprecios/edit", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {

            if (resp.error == '00000') {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Datos Guardados correctamente',
                    showConfirmButton: true,
                    timer: 1500
                })
                loadTableCategoriasPrecios(e)
            } else {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Error al Guardar los datos',
                    text: resp.errorMsg,
                    showConfirmButton: true,
                    timer: 1500
                })
            }
        })
}