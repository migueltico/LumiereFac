
$('document').ready(function () {
    localStorage.setItem('fac_active_btn', 0)

});
$("#bodyContent").on("click", "#rePrintFactBtn", function (e) {
    fetch("/facturacion/getlast/prints", {
        method: "POST"
    }).then(resp => resp.text())
        .then(resp => {
            let content = document.getElementById('contentSearchRePrintFac')
            content.innerHTML = resp
        })
})

$('#bodyContent').on("click", "#btnCambios_fac", function (e) {
    $('#rowsFactDetailsSearch').html('')
    $('#SearchFacModal').modal('toggle')

})
$('#bodyContent').on("click", "#btnAplicarDevolucion", function (e) {
    aplicarDevolucion()
})
$('#bodyContent').on("keypress", "#SearchFac_input", function (e) {
    if (e.keyCode == 13) {
        getFacData(this.value)
    }
})
$('#bodyContent').on("keypress", "#searchProductOfertaEdit", function (e) {
    if (e.charCode == 13) {
        if (e.target.value.length > 0) {
            searchProductToOferta(e, 'searchProductOfertaEdit', 'ofertaRowsEditModal')
        } else {
            Swal.fire({
                position: 'top',
                title: 'Falta codigo',
                text: 'Debes ingresar el codigo de un producto',
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 2500,
                timerProgressBar: true
            })
        }
    }
})
$('#bodyContent').on("keypress", "#searchProductOfertaAdd", function (e) {
    if (e.charCode == 13) {
        if (e.target.value.length > 0) {
            searchProductToOferta(e, 'searchProductOfertaAdd', 'ofertaRowsModal')
        } else {
            Swal.fire({
                position: 'top',
                title: 'Falta codigo',
                text: 'Debes ingresar el codigo de un producto',
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 2500,
                timerProgressBar: true
            })
        }
    }
})
function searchProductToOferta(e, idSearch, idTbody) {
    let element = document.getElementById(idSearch)
    let toSearch = document.getElementById(idSearch).value
    element.focus();
    element.setSelectionRange(0, toSearch.length);
    let resultCompare = existProductRowIntable(toSearch, idTbody)
    if (resultCompare == true) {
        let formData = new FormData()
        formData.append("codigo", toSearch)
        fetch("/admin/ofertas/getproduct", {
            method: "POST",
            body: formData
        }).then(resp => resp.text())
            .then(resp => {
                if (resp != '0' && resp != 'duplicado') {

                    $(`#${idTbody}`).append(resp)
                } else {
                    if (resp == 'duplicado')
                        Swal.fire({
                            position: 'top',
                            title: `Producto`,
                            text: `Este producto ya se encuentra en otra oferta.`,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            timer: 5000,
                            timerProgressBar: true
                        })
                }
            })

    }
}
function existProductRowIntable(toSearch, idTable) {
    let body2 = document.getElementById(idTable)
    for (let item of body2.children) {
        let inner = item.children[0].innerText
        if (toSearch.trim() == inner) {
            Swal.fire({
                position: 'top',
                title: 'El producto ya esta registrado',
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 3500,
                timerProgressBar: true
            })
            return item.children
        }
    }
    return true
}
function getProductsRowsOnTable(idTableBody) {
    let body2 = document.getElementById(idTableBody)
    let ids = ''
    for (let item of body2.children) {
        let inner = item.children[0].innerText
        ids += inner + ','
    }
    let products = ids.slice(0, -1)
    return products
}

$('#bodyContent').on("click", ".delete_row_oferta", function (e) {
    let id = this.dataset.id
    let row = document.getElementById(id)
    row.remove()
})
$('#bodyContent').on("click", ".delete_oferta_btn", function (e) {
    let id = this.dataset.id
    let row = document.getElementById('oferta_' + id)

    let formData = new FormData()
    formData.append("idOferta", id)
    fetch("/admin/ofertas/deleteoferta", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            if (resp.estado && resp.error == '00000') {
                row.remove()
                Swal.fire({
                    position: 'top',
                    title: `Oferta`,
                    text: `Oferta eliminada correctamente.`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 5000,
                    timerProgressBar: true
                })
            } else {
                Swal.fire({
                    position: 'top',
                    title: `Oferta`,
                    text: `Ha ocurrido un problema al tratar de eliminar esta oferta.`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 5000,
                    timerProgressBar: true
                })
            }
        })
})

$('#bodyContent').on("click", "#btnNewoferta", function (e) {
    document.getElementById("ofertas_AddOfertaForm").reset();
    let bodyTable = document.getElementById('ofertaRowsModal')
    bodyTable.innerHTML = ''
})
$('#bodyContent').on("click", ".edit_oferta_btn", function (e) {
    document.getElementById("ofertas_EditOfertaForm").reset();
    let bodyTable = document.getElementById('ofertaRowsEditModal')
    bodyTable.innerHTML = ''
    let idbtnEdit = document.getElementById('ofertas_add_btnEditOferta')
    idbtnEdit.dataset.id = ''
    let id = this.dataset.id
    let formData = new FormData()
    formData.append("idOferta", id)
    fetch("/admin/ofertas/getofertasbyid", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            if (resp.estado && resp.error == '00000') {
                let oferta = resp.data
                let idbtnEdit = document.getElementById('ofertas_add_btnEditOferta')
                let nombre = document.getElementById('ofertas_edit_nombre')
                let cantidad = document.getElementById('ofertas_edit_cantidad')
                let tipoOferta = document.getElementById('ofertas_edit_tipooferta')
                let descuento = document.getElementById('ofertas_edit_descuento')
                let unica = document.getElementById('ofertas_edit_unica')
                let tbody = document.getElementById('ofertaRowsEditModal')
                nombre.value = oferta.nombreOferta
                cantidad.value = oferta.cantidad
                tipoOferta.value = oferta.productoOrlista
                descuento.value = oferta.descuento
                unica.checked = oferta.unica == 0 ? false : true
                tbody.innerHTML = resp.htmlRows
                idbtnEdit.dataset.id = oferta.idOferta
            }
        })
})
$('#bodyContent').on("click", "#ofertas_add_btnAddOferta", function (e) {
    let formData = new FormData(document.getElementById('ofertas_AddOfertaForm'))
    let productos = getProductsRowsOnTable('ofertaRowsModal')
    formData.append("productos", productos)
    fetch("/admin/ofertas/addoferta", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            if (resp.error == '00000') {

                Swal.fire({
                    position: 'top',
                    title: `Oferta`,
                    text: `Oferta Agregada correctamente.`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(`#ofertas_addOfertas`).modal('toggle')
                        loadPage(null, "/admin/ofertas")
                    }
                })

            } else {
                Swal.fire({
                    position: 'top',
                    title: `Error`,
                    text: `${JSON.stringify(resp.errorMsg)}`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
            }
        })

})
$('#bodyContent').on("click", "#ofertas_add_btnEditOferta", function (e) {
    let formData = new FormData(document.getElementById('ofertas_EditOfertaForm'))
    let idbtnEdit = document.getElementById('ofertas_add_btnEditOferta')
    let productos = getProductsRowsOnTable('ofertaRowsEditModal')
    formData.append("productos", productos)
    formData.append("idOferta", idbtnEdit.dataset.id)
    fetch("/admin/ofertas/updateoferta", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {

            if (resp.error == '00000') {

                let nombre = document.getElementById('ofertas_edit_nombre')
                let tipoOferta = document.getElementById('ofertas_edit_tipooferta')
                let descuento = document.getElementById('ofertas_edit_descuento')
                let unica = document.getElementById('ofertas_edit_unica')
                Swal.fire({
                    position: 'top',
                    title: `Oferta`,
                    text: `Oferta actualizada correctamente.`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(`#ofertas_editOfertas`).modal('toggle')
                        loadPage(null, "/admin/ofertas")
                    }
                })


            } else {
                Swal.fire({
                    position: 'top',
                    title: `Error`,
                    text: `${JSON.stringify(resp.errorMsg)}`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
            }
        })

})



$('#bodyContent').on("change", ".inputCantFactRow", function (e) {
    validateInputCantRow(this)
})
$('#bodyContent').on("blur", ".inputCantFactRow", function (e) {
    validateInputCantRow(this)
})
$('#bodyContent').on("change", ".inputSelectRowFact", function (e) {
    calcAmountAllRowDevolution()
})

function aplicarDevolucion() {
    let rows = document.querySelector("#rowsFactDetailsSearch")
    let fac = document.querySelector("#idfacDevolucion").value
    let childs = rows.children
    let selecteds = []
    let total = 0.00
    for (const child of childs) {
        if (child.children[8].children[0].checked) {
            let totalRow = child.children[9].children[0].value
            let rows = {
                idproducto: child.children[0].dataset.id,
                cant: child.children[7].children[0].value,
                total: totalRow
            }
            total += parseFloat(totalRow)
            selecteds.push(rows)
        }
    }
    let fecha_max_devolucion = document.getElementById("fecha_max_devolucion")
    let json = {
        items: selecteds,
        fac: fac,
        fechaMax: fecha_max_devolucion.dataset.fecha,
        total
    }
    //console.log(json)
    if (json.items.length == 0) return
    let headers = {
        "Content-Type": "application/json"
    }
    fetch("/facturacion/agregar/devolucion", {
        method: "POST",
        headers: headers,
        body: JSON.stringify(json)
    }).then(resp => resp.json())
        .then(resp => {
            getFacData(fac)
            Swal.fire({
                position: 'top',
                title: `Devolucion aplicada correctamente`,
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            })
            //console.log(resp)
        })

}

function validateInputCantRow(input) {
    let max = parseInt(input.max)
    let value = parseInt(input.value)
    if (max >= value) {
        calcAmountAllRowDevolution()
    } else {
        Swal.fire({
            position: 'top',
            title: `Cantidad maxima superada`,
            text: `La cantidad de ${input.value} Unidad${input.value > 1 ? "es" : ""} supera la cantidad de ${input.max} Unidad${input.max > 1 ? "es" : ""} facturada${input.max > 1 ? "s" : ""} del producto.`,
            icon: 'error',
            confirmButtonText: 'OK',
            // timer: 8000,
            // timerProgressBar: true
        })
        input.value = input.max
    }
}

function calcAmountAllRowDevolution() {
    let rows = document.querySelector("#rowsFactDetailsSearch")
    let childs = rows.children
    let totalSpan = document.getElementById('NewCreditTotal')
    let saldoActual_devolucion = document.getElementById('saldoActual_devolucion').innerHTML
    let newTotal = 0.00
    for (const child of childs) {
        if (child.children[8].children[0].checked) {
            let amountBack = 0.00
            let totalRow = parseFloat(child.children[6].textContent)
            let cant = parseInt(child.children[2].dataset.realcant)
            let NewCant = parseFloat(child.children[7].children[0].value)
            amountBack = totalRow / cant * NewCant
            // console.table([totalRow, cant, NewCant, amountBack])
            child.children[9].children[0].value = amountBack
            newTotal += parseFloat(amountBack)
        } else {
            child.children[9].children[0].value = "0.00"
        }
    }
    if (newTotal > 0) {
        newTotal += parseFloat(saldoActual_devolucion)
        totalSpan.innerText = ConvertLabelFormat(newTotal)
        totalSpan.dataset.total = newTotal

    } else {
        totalSpan.innerText = "0.00"
        totalSpan.dataset.total = "0.00"
    }
}

function formatDate(dateString, symbol, returnSymbol) {
    let dataArray = dateString.split(symbol)
    let returnDate = ''
    returnDate = dataArray[2] + returnSymbol + dataArray[0] + returnSymbol + dataArray[1]
    return returnDate

}

function getFacData(fac) {
    let regex = '^[+]?([0-9]+(?:[0-9]*)?|[0-9]+)$'
    let resultRegex = fac.match(regex)
    if (resultRegex) {
        let formData = new FormData()
        formData.append('fac', fac)
        fetch('facturacion/consultar/factura', {
            method: 'POST',
            body: formData
        }).then(resp => resp.json())
            .then(resp => {
                if (resp !== null) {
                    let idfacDevolucion = document.getElementById("idfacDevolucion")
                    let fecha_max_devolucion = document.getElementById("fecha_max_devolucion")
                    let fecha_venta_devolucion = document.getElementById("fecha_venta_devolucion")
                    let saldoActual_devolucion = document.getElementById('saldoActual_devolucion')

                    saldoActual_devolucion.innerText = resp.hasDevolution ? resp.devolucion_details.Saldo : '0.00'
                    fecha_venta_devolucion.innerText = resp.fechaFormat
                    fecha_max_devolucion.innerText = resp.fecha_final
                    fecha_max_devolucion.dataset.fecha = resp.fecha_final
                    let d1 = new Date(formatDate(resp.dateNow, '-', '-'))
                    let d2 = new Date(formatDate(resp.fecha_final, '-', '-'))
                    if (d1 > d2) {
                        fecha_max_devolucion.style.color = 'red'
                    } else {
                        fecha_max_devolucion.style.color = 'blue'
                    }
                    let trs = ''
                    idfacDevolucion.value = fac
                    resp.details.forEach((element, index) => {
                        let cantidadModificada = ``
                        if (element.originalCant != undefined && element.originalCant != element.cantidad) {
                            cantidadModificada = `<strong style="color:red;">(${element.cantidad})</strong>`
                        }
                        if (element.originalCant == undefined) {
                            cantidadModificada = ``
                            element.originalCant = element.cantidad
                        }
                        let row = `
                <tr id="ChangesRow_${element.idproducto}">
                    <td data-id="${element.idproducto}">${element.codigo}</td>
                    <td>${element.descripcion_short}</td>
                    <td data-realcant="${element.cantidad}">${element.originalCant} ${cantidadModificada}</td>
                    <td>${element.precio}</td>
                    <td class='text-center'>${element.descuento}%</td>
                    <td class='text-center'>${element.iva}%</td>
                    <td>${element.total}</td>
                    <td><input class="inputCantFactRow" style='text-align:center' ${element.cantidad == 0 ? 'disabled' : ''} type="number" min='${element.cantidad > 0 ? 1 : 0}' max='${element.cantidad}' value='${element.cantidad > 0 ? 1 : 0}'></td>
                    <td class='text-center'><input class="inputSelectRowFact" type='checkbox' ${element.cantidad == 0 ? 'disabled' : ''} data-codigo="${element.idproducto}" data-cantidad="${element.cantidad}" data-precio="${element.precio}" data-descuento="${element.descuento}" data-iva="${element.iva}" data-total="${element.total}" ></td>
                    <td><input style='text-align:center;max-width:80px' type="text" disabled value='0.00'></td>
                </tr>
                `
                        trs += row
                    })
                    $('#rowsFactDetailsSearch').html(trs)
                } else {
                    $('#rowsFactDetailsSearch').html('')
                    Swal.fire({
                        position: 'top',
                        title: `No existe`,
                        text: `La factura #${fac} no se encuentra o no existe en la Base de datos. Por favor verifica e intenta de nuevo.`,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        // timer: 8000,
                        // timerProgressBar: true
                    })
                }

            })
    } else {
        $('#rowsFactDetailsSearch').html('')
        if (fac == '') {
            Swal.fire({
                position: 'top',
                title: `Error`,
                html: `Por favor escriba el numero de la factura a consultar.`,
                icon: 'error',
                confirmButtonText: 'OK',
                // timer: 8000,
                // timerProgressBar: true
            })
        } else {

            Swal.fire({
                position: 'top',
                title: `Error`,
                html: `La factura "<strong>${fac}</strong>" solo debe contener caracteres numericos.`,
                icon: 'error',
                confirmButtonText: 'OK',
                // timer: 8000,
                // timerProgressBar: true
            })
        }
    }
}

$('#bodyContent').on("change", "#ckCambios", function (e) {
    let groupCambiosBtn = document.getElementById('groupCambiosBtn')
    groupCambiosBtn.style.display = this.checked ? 'block' : 'none'
})

//SE EJECUTA AL PRESIONAR ENTER EN EL INPUT DE BUSQUEDA EN INVENTARIO
$('#bodyContent').on("change", ".cantInputFact", function (e) {
    let tr = $(e.target).parent().parent().children()
    RefreshCalcTotalRowPrice(tr, 0)
    getSubTotalAndTotal()
})
$('#bodyContent').on("click", ".btnDeleteRowTarjeta", function (e) {
    let id = this.dataset.id
    let cb = document.getElementById('MultiTipoPagoFact');
    let allMonto = document.getElementsByClassName('tarjertaInputs_monto')[0]
    let rowtarjetas = document.getElementsByClassName('rowtarjetas')
    let totalFactAmount = document.getElementById('totalFactAmount').textContent
    let amountsaldo = document.getElementById('totalFactAmount').dataset.amountsaldo
    let row = document.getElementById(id)
    row.remove()
    if (!cb.checked) {
        if (rowtarjetas.length == 0) {
            allMonto.disabled = true;
            allMonto.value = localStorage.saldo != 'false' && localStorage.saldo != undefined ? amountsaldo : totalFactAmount
        }
    }
})
$('#bodyContent').on("click", "#addNewTarjeta", function (e) {
    let allMonto = document.getElementsByClassName('tarjertaInputs_monto')[0]
    let cb = document.getElementById('MultiTipoPagoFact');
    let d = new Date();
    let n = d.getSeconds();
    let letras = ['a', 'b', 'c', 'd']
    let randID = letras[Math.floor(Math.random() * 4)] + Math.floor(Math.random() * 100) + n;
    let mainRow = document.createElement('div')
    let inputGroup1 = document.createElement('div')
    let inputGroup2 = document.createElement('div')
    let inputGroup3 = document.createElement('div')
    let prepend1 = document.createElement('div')
    let prepend2 = document.createElement('div')
    let input1 = document.createElement('input')
    let input2 = document.createElement('input')
    let span1 = document.createElement('span')
    let span2 = document.createElement('span')
    let button = document.createElement('button')
    let = document.createElement('div')
    mainRow.classList.add('row', 'rowtarjetas')
    mainRow.id = randID

    // *****GROUP 1*****/
    inputGroup1.classList.add('input-group', 'mb-3', 'mt-3', 'col-lg-5', 'col-md-5', 'col-sm-11')
    prepend1.classList.add('input-group-prepend')
    input1.classList.add('form-control', 'tarjertaInputs_tarjeta', 'inputRowsTarjeta')
    input1.type = 'text'
    input1.maxLength = 4
    input1.placeholder = 'Ultimos 4 Digitos'
    input1.dataset.id = randID
    span1.classList.add('input-group-text')


    span1.textContent = '# Tarjeta'
    prepend1.appendChild(span1)
    inputGroup1.appendChild(prepend1)
    inputGroup1.appendChild(input1)
    // *****GROUP 2*****/
    inputGroup2.classList.add('input-group', 'mb-3', 'mt-3', 'col-lg-6', 'col-md-6', 'col-sm-12')
    prepend2.classList.add('input-group-prepend')
    input2.classList.add('form-control', 'tarjertaInputs_monto', 'inputRowsTarjetaMonto', 'lbMontoToPay')
    input2.value = '0.00'
    input2.id = 'tarjetaMonto_' + randID
    input2.type = 'text'
    input2.placeholder = 'Ultimos 4 Digitos'
    span2.classList.add('input-group-text')

    span2.textContent = 'Monto'
    prepend2.appendChild(span2)
    inputGroup2.appendChild(prepend2)
    inputGroup2.appendChild(input2)

    // *****BTN*****/
    inputGroup3.classList.add('input-group', 'mb-3', 'mt-3', 'col-lg-1', 'col-md-1', 'col-sm-1')
    button.textContent = 'X'
    button.dataset.id = randID
    button.classList.add('btn', 'btn-danger', 'btnDeleteRowTarjeta')

    inputGroup3.appendChild(button)
    mainRow.appendChild(inputGroup1)
    mainRow.appendChild(inputGroup2)
    mainRow.appendChild(inputGroup3)
    let addrowtarjeta = document.getElementById('addrowtarjeta')
    let pagoContraEntrega = document.getElementById('pagoContraEntrega')
    if (!pagoContraEntrega.checked) {
        addrowtarjeta.appendChild(mainRow)
        if (!cb.checked) {
            allMonto.disabled = false;
            allMonto.value = '0.00';
        }
    }
})
$('#bodyContent').on("change", "#MultiTipoPagoFact", function (e) {
    multiState(e)
})

function multiState(e) {
    const cb = document.getElementById('MultiTipoPagoFact');
    let rowtarjetas = document.querySelectorAll(".rowtarjetas")
    const InputSwitch = document.getElementsByClassName('fact_switchBtns');
    const InputRadio = document.getElementsByClassName('fact_rbRadiosBtns');
    const removeElements = (elms) => elms.forEach(el => el.remove())
    removeElements(rowtarjetas)
    $(".cardHeaderSwitch").removeClass('selectedMethodPay')
    let pago = document.getElementById("pagoContraEntrega").checked
    if (!pago) {
        if (cb.checked) {
            $('.lbMontoToPay').prop('disabled', false)
            $(".lbMontoToPay").val('0.00')
            for (let i = 0; i < InputSwitch.length; i++) {
                InputSwitch[i].checked = false
                InputSwitch[i].style.display = "block"
                InputRadio[i].style.display = "none"

            }
        } else {
            let amounts = document.getElementById('totalFactAmount')
            //console.log(localStorage.saldo, localStorage.saldo != 'false' && localStorage.saldo != undefined)
            if (localStorage.saldo != 'false' && localStorage.saldo != undefined) {
                $(".lbMontoToPay").val(amounts.dataset.amountsaldo)
            } else {
                $(".lbMontoToPay").val(amounts.dataset.amount)
            }
            $(".cardHeaderSwitch").first().addClass('selectedMethodPay')
            $(".fact_switchBtns input[type='checkbox").prop("checked", false)
            $('.lbMontoToPay').prop('disabled', true)
            InputRadio[0].checked = true
            for (let i = 0; i < InputSwitch.length; i++) {
                InputSwitch[i].checked = false
                InputSwitch[i].style.display = "none"
                InputRadio[i].style.display = "block"
                cb.style.display = "block"
            }
        }
    }
}
$("#bodyContent").on("change", "#pagoContraEntrega", function (e) {
    let tr = document.getElementById("appendItemRowProduct")
    let Multi = document.getElementById("MultiTipoPagoFact").checked
    let rowtarjetas = document.querySelectorAll(".rowtarjetas")
    let count = tr.getElementsByTagName("tr")
    const removeElements = (elms) => elms.forEach(el => el.remove())
    removeElements(rowtarjetas)
    if (Multi && this.checked) {
        $(".lbMontoToPay").prop("disabled", true)
    } else {
        $(".lbMontoToPay").prop("disabled", false)
    }
    if (this.checked && count.length > 0) {
        $("#btnMakeFact").prop("disabled", false)
        $(".lbMontoToPay").prop("disabled", true)
        $(".lbMontoToPay").val("0.00")
    } else if (count.length > 0) {
        $("#btnMakeFact").prop("disabled", false)
        $(".lbMontoToPay").prop("disabled", false)
    } else {
        $("#btnMakeFact").prop("disabled", true)

    }
})
$("#bodyContent").on("click", "#PrintFactBtn", function (e) {
    let tr = document.getElementById("appendItemRowProduct")
    let count = tr.getElementsByTagName("tr")
    let Multi = document.getElementById("MultiTipoPagoFact")
    Multi.checked = false
    multiState(e)
    if (count.length == 0) {
        Swal.fire({
            position: 'top',
            title: '',
            text: "Asegurese de tener algun producto a facturar",
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 2500,
            timerProgressBar: true
        })
        $("#btnMakeFact").prop("disabled", true)
    }
    let btn_Envio = document.getElementById("btnTypeEnvio")
    let btnApartado = document.getElementById("btnTypeApartado")
    let btn_pagoContraEntrega = document.getElementById("pagoContraEntregaContainer")
    let pagoContraEntrega = document.getElementById("pagoContraEntrega")
    pagoContraEntrega.checked = false
    $(".tarjertaInputs_tarjeta").val('')
    $(".transferenciaInputs_referencia").val('')
    $(".transferenciaInputs_banco").val(0)
    if (hasClass(btn_Envio, "active")) {
        btn_pagoContraEntrega.style.display = "block"
    } else {
        btn_pagoContraEntrega.style.display = "none"
    }

    let amount = document.getElementsByClassName("totalFactAmount")[0]
    let btn = document.getElementById('btnMakeFact')
    let amountFloat = parseFloat(amount.dataset.amount.replace(",", ""))
    if (amountFloat > 0.00) {
        $(btn).prop("disabled", false)
    } else {
        $(btn).prop("disabled", true)
    }
    if (hasClass(btnApartado, "active")) {
        $('.lbMontoToPay').prop('disabled', false)
        $('.lbMontoToPay').val('0.00')
    } else {
        $('.lbMontoToPay').prop('disabled', true)
    }
})
$("#bodyContent").on("click", "#group_type_fac .btn", function (e) {
    $("#group_type_fac .btn").removeClass("active")
    $("#group_type_fac .btn").removeClass("btn-primary")
    $("#group_type_fac .btn").addClass("btn-info")
    $(this).removeClass("btn-info")
    $(this).addClass("btn-primary")
    $(this).addClass("active")

    let cliente = document.getElementById("fac_cliente_input")
    let precioEnvioWrapper = document.getElementById("precioEnvioWrapper")
    let precioEnvio = document.getElementById("precioEnvio")
    let btnTypeLocal = document.getElementById('btnTypeLocal');
    let btnTypeEnvio = document.getElementById('btnTypeEnvio');
    let wrapperAbono = document.getElementById('ckAbonoSwWrapper');
    let ckAbonoSw = document.getElementById('ckAbonoSw');
    let apartadosWrapper = document.getElementById('apartadosWrapper');
    let btnTypeApartado = document.getElementById('btnTypeApartado');
    let abono = btnTypeApartado.classList.contains("active");
    let envio = btnTypeEnvio.classList.contains("active");
    precioEnvio.value = '0.00'
    if (envio) {
        precioEnvioWrapper.style.display = "block"
        precioEnvio.value = '0.00'
    } else {
        precioEnvioWrapper.style.display = "none"
        precioEnvio.value = '0.00'
        getSubTotalAndTotal()
    }
    if (abono) {
        let wrapperAbono = document.getElementById('ckAbonoSwWrapper')
        wrapperAbono.style.display = "block"
    } else {
        wrapperAbono.style.display = "none"
        apartadosWrapper.style.display = "none"
        wrapperAbono.checked = false
        ckAbonoSw.checked = false
    }
    if (parseInt(cliente.dataset.idgenerico) == parseInt(cliente.dataset.cliente)) {

        if (abono || envio) {
            btnTypeApartado.classList.remove("active")
            btnTypeApartado.classList.remove("btn-primary")
            btnTypeApartado.classList.add("btn-info")
            btnTypeEnvio.classList.remove("active")
            btnTypeEnvio.classList.remove("btn-primary")
            btnTypeEnvio.classList.add("btn-info")
            btnTypeLocal.classList.add("active")
            btnTypeLocal.classList.add("btn-primary")
            btnTypeLocal.classList.remove("btn-info")
            wrapperAbono.style.display = "none"
            wrapperAbono.checked = false
            precioEnvioWrapper.style.display = "none"
            precioEnvio.value = '0.00'
            getSubTotalAndTotal()
            Swal.fire({
                position: 'top',
                title: 'Tipo de venta requiere Cliente',
                text: "Debes seleccionar un cliente diferente",
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 2500,
                timerProgressBar: true
            })

        }
    }

})

function resetFactScreen() {
    localStorage.removeItem('saldo')
    localStorage.removeItem('ofertas')
    $(`.modal-backdrop`).remove()
    loadPage(null, "facturacion/facturar")

}
$('#bodyContent').on("click", "#btnMakeFact", function (e) {
    //ANCLA
    e.preventDefault();
    $("#btnMakeFact").prop("disabled", true)
    let fac_active_btn = localStorage.getItem('fac_active_btn')
    if (fac_active_btn == 1) {
        alert("Ya se encuentra una factura en proceso, por favor evite el doble click al facturar")
        return
    } else {
        localStorage.setItem('fac_active_btn', 1)
    }
    const cb = document.getElementById('MultiTipoPagoFact');
    let btnTypeApartado = document.getElementById('btnTypeApartado');
    let pagoContraEntrega = document.getElementById('pagoContraEntrega').checked;
    let abono = btnTypeApartado.classList.contains("active");
    pagoContraEntrega = (pagoContraEntrega ? 0 : 1)
    if (cb.checked) {
        let method = PagoMultipleFac(pagoContraEntrega, abono)

        if (method.state) {
            getProductsRowsForFac(method.methodsArray, pagoContraEntrega, abono)
        }
    } else {
        let method = PagoUnicoFac()
        //let isOk = true

        // method.map(e => (e.state == false ? isOk = true : isOk = false))
        if (method[0].state) {
            getProductsRowsForFac(method, pagoContraEntrega, abono)
        } else if (pagoContraEntrega.checked) {

        }


    }
})

function convertToFacNumber() {
    ConvertLabelFormat(111)
}

function getProductsRowsForFac(method, pago, typeAbono) {
    let rows = document.getElementsByClassName('productRowFac')
    let amounts = document.getElementById('totalFactAmount').dataset.amount
    let cliente = document.getElementById('fac_cliente_input')
    let idCliente = cliente.dataset.cliente
    let nameCliente = cliente.value
    let idVendedor = document.getElementById('InputVendedorFact').dataset.vendedor
    let nameVendedor = document.getElementById('InputVendedorFact').value
    let monto_envio = document.getElementById('precioEnvio').value
    let itemsFac = []
    let gran_subtotal = 0.00
    let gran_subtotal_descuento = 0.00
    let methodPay = method
    let cantidadArticulos = 0
    let ivaMonto = 0.00
    for (let row of rows) {
        let id = row.children[0].dataset.id
        let cod = row.children[0].dataset.codigo
        let descripcion = row.children[1].textContent
        let talla = row.children[2].textContent
        let cantidad = parseInt(row.children[4].children[0].value)
        let iva = (row.children[3].textContent > 0 ? row.children[3].textContent : 0)
        let precio = ConvertLabelFormat(parseFloat(row.children[6].textContent))
        let subtotal = ConvertLabelFormat(parseFloat(row.children[8].textContent))
        let total_iva = ConvertLabelFormat(parseFloat(row.children[9].textContent))

        let descuento = (row.children[7].textContent !== "N/A" ? row.children[7].textContent : 0)
        cantidadArticulos += cantidad
        let json = {
            cod,
            id,
            descripcion,
            talla,
            cantidad,
            iva: iva,
            descuento,
            precio,
            subtotal,
            total_iva
        }
        gran_subtotal_descuento += parseFloat(row.children[8].textContent)
        gran_subtotal += parseFloat(row.children[6].textContent) * parseInt(cantidad)
        itemsFac.push(json)

    }
    if (itemsFac.length == 0) {

        itemsFac = 0
    }
    let Okprint = document.getElementById('SendFactBoolean');
    let tipoVenta = parseInt($("#group_type_fac .active").data("tipo"))
    let totalAmountWithOutFormat = parseFloat(amounts.replace(",", ""))
    let iva = (totalAmountWithOutFormat - gran_subtotal_descuento - monto_envio)
    let saldoUsed = parseFloat(localStorage.saldo)
    let inputSearchFacSaldo = document.getElementById('inputSearchFacSaldo').value
    let inputFacNewSaldoNow = document.getElementById('inputFacNewSaldoNow').value
    let finalJson = {
        items: itemsFac,
        total: amounts,
        subtotal_descuento: ConvertLabelFormat(gran_subtotal_descuento),
        descuento: ConvertLabelFormat((gran_subtotal - gran_subtotal_descuento)), // precio sin descuento menos precio con descuento
        iva,
        idCliente: idCliente,
        nameCliente: nameCliente,
        idVendedor,
        nameVendedor,
        methodPay,
        cantidadArticulos,
        tipoVenta,
        monto_envio,
        firstAbono: typeAbono,
        sendFac: (Okprint.checked ? 1 : 0),
        estado: (tipoVenta == 1 ? 1 : 0),
        hasPay: pago,
        hasSaldo: localStorage.saldo != 'false' && localStorage.saldo != undefined ? true : false,
        saldo: localStorage.saldo != 'false' && localStorage.saldo != undefined ? parseFloat(saldoUsed) : false,
        saldo_ref: inputSearchFacSaldo.trim(),
        new_saldo: inputFacNewSaldoNow.trim()

    }
    //console.log("final Json", finalJson);
    setTimeout(() => { //Temporizador para evitar doble factura
        printFact(finalJson)
    }, 700)
}


function PagoUnicoFac() {
    let InputsRadio = document.querySelectorAll(".fact_rbRadiosBtns")
    for (let input of InputsRadio) {
        if (input.checked) {
            let inputClass = input.dataset.inputval
            let result = verificaCamposPago(inputClass, false)
            if (result.state) {
                return [result]
            } else if (!result.campos) {
                Swal.fire({
                    position: 'top',
                    title: 'Campos Incompletos',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
                return [result]
            } else if (result.methods.hasMore && !result.methods.total) {
                Swal.fire({
                    position: 'top',
                    title: 'Monto no coincide con total de factura',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
                return [result]


            }
        }
    }
}

function PagoMultipleFac(pago, abono) {
    let montoToPay = document.getElementsByClassName("lbMontoToPay")
    let amounts = document.getElementById('totalFactAmount').dataset.amount
    let Allswitch = document.getElementsByClassName('switchGroupAmount')
    let finalAmount = 0.00
    let result;
    let methodsArray = []
    for (let switchItem of Allswitch) {
        if (switchItem.checked) {
            let itemId = switchItem.dataset.inputval
            //console.log("CHECK", itemId);
            result = verificaCamposPago(itemId, true)
            if (result.state) {
                let monto = document.getElementsByClassName(`${itemId}_monto`)[0].value

                let valor = monto

                valor = valor.replace(',', "");
                valor = parseFloat(valor)
                if (result.methods.hasMore) {
                    valor += result.methods.totalExtraCards
                }
                //console.log("with Extra mount", valor);
                finalAmount = parseFloat(finalAmount) + parseFloat(valor)
                methodsArray.push(result)
            } else {
                methodsArray.push(result)
                Swal.fire({
                    position: 'top',
                    title: 'Campos Incompletos',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
                return methodsArray
            }
        }
    }
    if (localStorage.saldo !== undefined && localStorage.saldo !== false && localStorage.saldo !== 'false') {
        let newAmount = document.getElementById("amountModalTitle")
        parseInt(newAmount.innerText.replace(",", ""))
        amounts = parseFloat(newAmount.innerHTML.replace(',', ""))
    } else {
        amounts = amounts.replace(',', "")
    }
    if (parseFloat(finalAmount) == parseFloat(amounts) && pago == 1) {
        return {
            state: true,
            methodsArray
        }
    } else if (pago == 0 || abono) {
        methodsArray = {
            state: true,
            methodsArray
        }
    } else {
        methodsArray = {
            state: false,
            methodsArray
        }
        Swal.fire({
            position: 'top',
            title: 'Monto Incorrecto',
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 2500
        })
    }
    return methodsArray
}

function verificaCamposPago(inputClass, multi) {
    switch (inputClass) {
        case 'efectivoInputs':
            let Emonto = document.getElementsByClassName(`${inputClass}_monto`)[0].value

            if (Emonto.length > 0) {
                let methods = {
                    tipo: "efectivo",
                    monto: parseFloat(Emonto.replace(",", "")).toFixed(2),
                    montoWithFormat: Emonto
                }
                return {
                    state: true,
                    methods
                }
            } else {
                return {
                    state: false
                }
            }
            break;
        case 'tarjertaInputs':
            let pagoContraEntrega = document.getElementById('pagoContraEntrega').checked;
            let abono = btnTypeApartado.classList.contains("active");
            let Tmonto = document.getElementsByClassName(`${inputClass}_monto`)[0].value
            let tarjeta = document.getElementsByClassName(`${inputClass}_tarjeta`)[0].value
            let tarjetaIds = document.getElementsByClassName(`inputRowsTarjeta`)
            let rowtarjetas = document.getElementsByClassName('rowtarjetas')
            allLength = true
            for (tarjetId of tarjetaIds) {
                if (tarjetId.value.length == 0) {
                    allLength = false
                }
            }


            // tarjetaMonto_
            let hasMore = rowtarjetas.length !== 0 ? true : false
            let totalGroup = 0.00
            Tmontolength = Tmonto.length > 0 ? true : false
            tarjetalength = tarjeta.length > 0 ? true : false
            if (pagoContraEntrega || abono) {
                Tmontolength = true
                tarjetalength = true
                allLength = true
            }

            if (Tmonto.length > 0 && tarjeta.length > 0 && allLength) {
                let methods = {
                    tipo: "tarjeta",
                    monto: parseFloat(Tmonto.replace(",", "")).toFixed(2),
                    tarjeta,
                    montoWithFormat: Tmonto,
                    hasMore
                }
                if (hasMore) {
                    let extras = []

                    let inputRowsTarjeta = document.getElementsByClassName('inputRowsTarjeta')
                    for (tarjeta of inputRowsTarjeta) {
                        //console.log("Rows value", tarjeta.value);
                        let montoId = `tarjetaMonto_${tarjeta.dataset.id}`
                        let monto = document.getElementById(montoId).value
                        let withOutFormatMonto = parseFloat(monto.replace(",", "")).toFixed(2)
                        totalGroup = (totalGroup + parseFloat(withOutFormatMonto))
                        //console.log(monto);
                        let newTarjeta = {
                            tipo: "tarjeta",
                            tarjeta: tarjeta.value,
                            monto: parseFloat(withOutFormatMonto),
                            montoWithFormat: monto

                        }
                        extras.push(newTarjeta)
                    }
                    methods.extraCards = extras
                    methods.totalExtraCards = totalGroup
                    //console.log("Set News tarjetas", methods);
                }
                if (hasMore) {
                    let btnTypeApartado = document.getElementById('btnTypeApartado');
                    let abono = btnTypeApartado.classList.contains("active");
                    let amounts = document.getElementById('totalFactAmount').dataset.amount
                    let montoTarjetaId = document.getElementById('montoTarjetaId').value
                    amounts = amounts.replace(",", "")
                    amounts = parseFloat(amounts)
                    montoTarjetaId = montoTarjetaId.replace(",", "")
                    montoTarjetaId = parseFloat(montoTarjetaId)
                    totalGroup = (totalGroup + montoTarjetaId)
                    if (amounts !== totalGroup && !multi && !abono && !pagoContraEntrega) {
                        return {
                            state: false,
                            methods,
                            total: false,
                            campos: true
                        }
                    } else {
                        return {
                            state: true,
                            methods,
                            total: true,
                            campos: true
                        }
                    }

                } else {

                    return {
                        state: true,
                        methods,
                        campos: true
                    }
                }
            } else {
                return {
                    state: false,
                    campos: false
                }
            }
            break;
        case 'transferenciaInputs':
            let BnSelected = document.getElementsByClassName(`transferenciaInputs_banco`)[0].selectedIndex
            let banco = document.getElementsByClassName(`transferenciaInputs_banco`)[0].options[BnSelected].text
            let referencia = document.getElementsByClassName(`${inputClass}_referencia`)[0].value
            let Trmonto = document.getElementsByClassName(`${inputClass}_monto`)[0].value
            if (banco.length > 0 && banco !== "Seleccione" && referencia.length > 0 && Trmonto.length > 0) {
                let methods = {
                    tipo: "transferencia",
                    monto: parseFloat(Trmonto.replace(",", "")).toFixed(2),
                    banco,
                    referencia,
                    montoWithFormat: Trmonto
                }
                return {
                    state: true,
                    methods
                }
            } else {
                return {
                    state: false
                }
            }
            break;
    }
}

function printFact(datos) {
    let body = ''
    let headers = {
        "Content-Type": "application/json"
    }
    $("#btnMakeFact").prop("disabled", false)
    localStorage.setItem('fac_active_btn', 0)
    return
    fac_active_btn = false
    let Okprint = document.getElementById('SendFactBoolean');
    // let formData = new FormData()
    // formData.append("datos", JSON.stringify(datos))
    fetch("/facturacion/facturaVenta", {
        method: "POST",
        headers: headers,
        body: JSON.stringify(datos)
    }).then(resp => resp.text())
        .then(resp => {

            if (Okprint.checked) {
                $(`#FacSendModal`).modal('toggle')
                let h = resp;
                let d = $("<div>").addClass("printContainer").html(h).appendTo("html");
                window.print();
                d.remove();
            } else {
                $(`#FacSendModal`).modal('toggle')
                Swal.fire({
                    position: 'top',
                    title: "Factura",
                    text: "Factura generada correctamente",
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
                Okprint.checked = true
            }
            resetFactScreen()
        })

}

function ReprintFact(fac) {
    let formData = new FormData()
    formData.append('fac', fac)
    fetch("/facturacion/reprintFact", {
        method: "POST",
        body: formData
    }).then(resp => resp.text())
        .then(resp => {

            //$(`#reimprimirModal`).modal('toggle')
            let h = resp;
            let d = $("<div>").addClass("printContainer").html(h).appendTo("html");
            window.print();
            d.remove();

            //resetFactScreen()
        })

}
$('#bodyContent').on("click", ".execute_reprint", function (e) {
    let fac = e.target.dataset.fac
    ReprintFact(fac)
})
$('#bodyContent').on("keypress", "#SearchReprintFac_input", function (e) {
    if (e.key == 'Enter') {
        let formData = new FormData()
        let value = e.target.value
        formData.append('fac', value)
        fetch("/facturacion/searchFacByNumber", {
            method: "POST",
            body: formData
        }).then(resp => resp.text())
            .then(resp => {
                let content = document.getElementById('contentSearchRePrintFac')
                content.innerHTML = resp
            })
    }
})
$('#bodyContent').on("change", ".fact_switchBtns input[type='checkbox']", function (e) {
    let check = e.target.checked
    if (check) {

        $(this).parent().parent().parent().addClass('selectedMethodPay')
    } else {
        $(this).parent().parent().parent().removeClass('selectedMethodPay')
    }
})

$('#bodyContent').on("blur", ".lbMontoToPay", function (e) {
    if (this.value == '') this.value = 0.00
    e.preventDefault();
    this.value = parseFloat(this.value.replace(/,/g, ""))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //document.getElementById("display").value = this.value.replace(/,/g, "")
})

/////////Cambia el color del titulo del metodo de pago
$('#bodyContent').on("change", ".fact_rbRadiosBtns", function (e) {
    $(".fact_rbRadiosBtns").removeClass('selectedMethodPay')
    $(this).parent().parent().addClass('selectedMethodPay')

})

$('#bodyContent').on("click", ".cardHeaderSwitch", function (e) {
    const cb = document.getElementById('MultiTipoPagoFact');
    if (!cb.checked) {
        $(".cardHeaderSwitch").removeClass('selectedMethodPay')
        $(this).children().children().prop("checked", true)
        $(this).addClass('selectedMethodPay')
    } else {
        let label = $(this).children('div').find('label');
        if ($(this).hasClass('selectedMethodPay')) {
            $(this).removeClass('selectedMethodPay')
        } else {
            $(this).addClass('selectedMethodPay')
        }
        let check = $(this).find('.fact_switchBtns').find('input')[0];
        check.checked = !check.checked
    }


})

////////////////
$(window).keypress(function (e) {
    let FactMain = document.getElementById("bodyFactMain")
    if (e.charCode == 17 && e.ctrlKey == true && FactMain) {
        $('#paginationModal').html('')
        $('#contentSearchFac').html('')
        $("#SearchProductModal").modal('toggle')

        let element = document.getElementById('SearchProductInputCtrlQ')
        element.focus();
    }
})
$("#bodyContent").on("click", "#btnCodigoBarrasModal", function (e) {
    $('#paginationModal').html('')
    $('#contentSearchFac').html('')
    $("#SearchProductModal").modal('toggle')

    let element = document.getElementById('SearchProductInputCtrlQ')
    element.focus();

})
$("#bodyContent").on("blur", ".cantInputFact", function (e) {
    if (this.value < 1) {
        this.value = 1
        let tr = $(e.target).parent().parent().children()
        RefreshCalcTotalRowPrice(tr, 0)
        getSubTotalAndTotal()
        Swal.fire({
            position: 'top',
            title: "Error en la cantidad",
            text: "La cantidad no puede ser 0 o una cantidad negativa, se cambia cantidad a 1 UND de. " + tr[1].innerText,
            icon: 'error',
            confirmButtonText: 'OK'
        })
    }

})
$("#bodyContent").on("change", ".cantInputFact", function (e) {

    if (this.value < 1) {
        this.value = 1
        let tr = $(e.target).parent().parent().children()
        RefreshCalcTotalRowPrice(tr, 0)
        getSubTotalAndTotal()
        Swal.fire({
            position: 'top',
            title: "Error en la cantidad",
            text: "La cantidad no puede ser 0 o una cantidad negativa, se cambia cantidad a 1 UND. " + tr[1].innerText,
            icon: 'error',
            confirmButtonText: 'OK'
        })
    }

})
$('#bodyContent').on("keypress", "#ScanCode", function (e) {
    if (e.charCode == 13) {
        if (e.target.value.length > 0) {
            getProductFact(e)
        } else {
            Swal.fire({
                position: 'top',
                title: 'Falta codigo',
                text: 'Debes ingresar el codigo de un producto',
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 2500,
                timerProgressBar: true
            })
        }
    }

})
function getRandom(min, max) {
    return Math.floor(Math.random() * (max - min) + min);
}
/**
 * *************************************************************************************
 * *************************************************************************************
 */

async function getProductFact(e) {
    let element = document.getElementById('ScanCode')
    let toSearch = document.getElementById('ScanCode').value
    element.focus();
    element.setSelectionRange(0, toSearch.length);
    let resultCompare = existProductRow(toSearch)
    if (resultCompare == true) {
        let element = document.getElementById('productSearch')
        let formData = new FormData()
        formData.append("toSearch", toSearch)

        let data = await fetch("/facturacion/search/product", {
            method: "POST",
            body: formData
        })
        let resp = await data.json()
        if (resp.data !== false) {
            let data = resp.data
            if (data.stock <= 0) {
                if (data.stock < 0) {
                    Swal.fire({
                        position: 'top',
                        title: "Producto sin stock",
                        text: `Este producto tiene un stock negativo de ${data.stock}`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                    return
                }
                Swal.fire({
                    position: 'top',
                    title: "Producto sin stock",
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                return
            }
            let oferta
            // si oferta id exites
            if (data.idOferta > 0) {
                //Obtengo la info de la oferta
                oferta = await getOferta(data.idOferta)

                //verifico si existe alguna oferta registrada
                let jsonOferta = localStorage.getItem('ofertas')
                //si existe alguna oferta registrada agrego verifico si ya existe y si se puede stackear
                if (jsonOferta) {
                    // se parsea
                    jsonOferta = JSON.parse(jsonOferta)
                    //valido si existe el ID de la oferta en la lista de ofertas registradas en localstorage
                    let resutl = jsonOferta.id.some(e => e == data.idOferta)
                    // valido si es true o false, si existe la oferta
                    if (resutl) {
                        //asignamos el ID de la oferta repetida para verificar los siguientes pasos
                        let id = `oferta_${data.idOferta}`
                        if (jsonOferta[id]['unica'] == 0) {
                            //asigno la cantidad maxima actual a variable
                            let aumentarMaxima = jsonOferta[id]['cantidadMaximaActual']

                            //valido si la cantidad es por cada producto en la lista o solo por la oferta
                            if (jsonOferta[id]['productoOrlista'] == 1) {
                                //consigo la canstidad de productos
                                let totalCodigos = jsonOferta[id]['productosID'].length
                                //agrego a la cantidad maxima la cantidad por oferta X cantidad de productos
                                jsonOferta[id]['cantidadMaximaActual'] = parseInt(aumentarMaxima) + (parseInt(oferta.cantidad) * totalCodigos)
                            } else if (jsonOferta[id]['productoOrlista'] == 2) { // solo por oferta
                                //actualizo la cantidad maxima suamandole el valor de la cantidad de oferta
                                jsonOferta[id]['cantidadMaximaActual'] = parseInt(aumentarMaxima) + parseInt(oferta.cantidad)
                            }


                        }
                        localStorage.setItem('ofertas', JSON.stringify(jsonOferta))
                    } else {
                        //Ya existen ofertas pero la actual hay que agregarla

                        let productosCodigo = oferta.productos.split(',')

                        //se agrega el ID y los nuevos datos de la oferta
                        jsonOferta['id'] = [...jsonOferta.id, oferta.idOferta]
                        jsonOferta[`oferta_${oferta.idOferta}`] = { ...oferta }
                        jsonOferta[`oferta_${oferta.idOferta}`]['productosID'] = productosCodigo
                        jsonOferta[`oferta_${oferta.idOferta}`]['cantidadUsadaActual'] = 0
                        jsonOferta[`oferta_${oferta.idOferta}`]['cantidadMaximaActual'] = oferta.productoOrlista == 1 ? (parseInt(oferta.cantidad) * productosCodigo.length) : oferta.cantidad

                        localStorage.setItem('ofertas', JSON.stringify(jsonOferta))
                    }
                } else {
                    jsonOferta = {
                        id: [oferta.idOferta],
                    }
                    let productosCodigo = oferta.productos.split(',')
                    let totalCodigos = productosCodigo.length
                    jsonOferta[`oferta_${oferta.idOferta}`] = { ...oferta }
                    jsonOferta[`oferta_${oferta.idOferta}`]['productosID'] = productosCodigo
                    jsonOferta[`oferta_${oferta.idOferta}`]['cantidadUsadaActual'] = 0
                    jsonOferta[`oferta_${oferta.idOferta}`]['cantidadMaximaActual'] = oferta.productoOrlista == 1 ? (parseInt(oferta.cantidad) * totalCodigos) : oferta.cantidad

                    localStorage.setItem('ofertas', JSON.stringify(jsonOferta))
                }
            } else {
                oferta = false
            }

            let hasProductoOferta = verificarProductoOferta(data.codigo)
            if (hasProductoOferta != undefined && hasProductoOferta.estado) {
                data.descuento = parseInt(hasProductoOferta.descuento)
                data.descuento_descripcion = 'Oferta id:' + hasProductoOferta.id
            } else {
                hasProductoOferta = {
                    estado: false,
                    descuento: null
                }
            }
            let descuento = (data.descuento == null ? 'N/A' : data.descuento + '%')
            let des_descuento = (data.descuento_descripcion == null ? 'Sin Descuento' : data.descuento_descripcion)
            let precios = calcTotalRowPrice(data.precio_venta, (data.descuento == null ? 0 : data.descuento), (data.activado_iva == 0 ? 0 : data.iva))
            let randnum = getRandom(10, 10000)

            let row = /*html*/ `
                        <tr class="productRowFac ${data.descuento == null ? 'trNotDiscount' : ''}" id="itemRowProduct_${data.idproducto}_${randnum}"  data-hasoferta="${(hasProductoOferta.estado ? 1 : 0)}">
                            <td scope="row" data-oferta="${(hasProductoOferta.estado ? 1 : 0)}" data-codigo="${data.codigo}" data-id="${data.idproducto}" data-toggle="tooltip"data-placement="bottom" title="${data.idproducto}">${data.codigo}</td>
                            <td scope="row">${(hasProductoOferta.estado ? '(- OFERTA -)' : '')} ${data.descripcion_short} | ${data.marca}</td>
                            <td scope="row">${data.talla}</td>
                            <td scope="row">${(data.activado_iva == 0 ? 0 : data.iva)}</td>
                            <td scope="row" data-oferta="${oferta.idOferta}"><input type="number" min="1" ${(hasProductoOferta.estado ? 'max="1" disabled' : '')} class="cantInputFact" id="id_${data.idproducto}" style="width: 43px !important;text-align:center" name="" id="" value="1"  data-oferta="${oferta.idOferta}"></td>
                            <td scope="row">${data.stock}</td>
                            <td scope="row" ${(data.precio_venta < 1 ? 'style="color:red;"' : "")}>${data.precio_venta}</td>
                            <td scope="row" ${data.descuento == null ? 'class="tdNotDiscount"' : ''} data-toggle="tooltip" data-descuento="${(data.descuento == null ? 0 : data.descuento)}" data-placement="bottom" title="${des_descuento}">${descuento}</td>
                            <td scope="row" class="productRowFac_subtotal">${precios[0]}</td>
                            <td scope="row" class="productRowFac_total">${precios[1]}</td>
                            <td scope="row"><button class="btn btn-danger removeItemProductBtn" data-id="${data.idproducto}" data-rand="${randnum}" data-oferta="${oferta.idOferta == undefined && hasProductoOferta.estado ? hasProductoOferta.id : oferta.idOferta}">X</button></td>
                        </tr>
            `
            $('#appendItemRowProduct').append(row)
            getSubTotalAndTotal()

        } else {
            Swal.fire({
                position: 'top',
                title: resp.msg,
                text: resp.errorData.errorMsg[2],
                icon: 'error',
                confirmButtonText: 'OK'
            })
        }

    } else {

        RefreshCalcTotalRowPrice(resultCompare, 1)
        getSubTotalAndTotal()

    }
    getSubTotalAndTotal()
}
function verificarProductoOferta(codigo) {
    let jsonOferta = localStorage.getItem('ofertas')
    jsonOferta = JSON.parse(jsonOferta)

    if (jsonOferta) {
        let result;
        jsonOferta.id.map((e) => {
            let id = `oferta_${e}`
            let idnum = e
            let producto = jsonOferta[id]['productosID']
            producto.map((cod) => {
                if (cod == codigo) {
                    if (jsonOferta[id]['cantidadUsadaActual'] < jsonOferta[id]['cantidadMaximaActual']) {

                        jsonOferta[id]['cantidadUsadaActual'] = parseInt(jsonOferta[id]['cantidadUsadaActual']) + 1
                        localStorage.setItem('ofertas', JSON.stringify(jsonOferta))
                        result = {
                            estado: true,
                            descuento: jsonOferta[id]['descuento'],
                            id: idnum
                        }
                    }
                }
            })
        })
        return result
    } else {
        return { estado: false }
    }
}
function updateOferta(idOferta, deleteOferta, cant, idRowDelete) {
    let check = "check_" + idOferta
    if (check == 'check_undefined' || check == 'check_') {
        return
    }

    if (!deleteOferta) {
        let jsonOferta = localStorage.getItem('ofertas')
        //si existe alguna oferta registrada agrego verifico si ya existe y si se puede stackear  
        // se parsea
        jsonOferta = JSON.parse(jsonOferta)

        //valido si existe el ID de la oferta en la lista de ofertas registradas en localstorage
        let result = jsonOferta.id.some(e => e == idOferta)
        //asigno la cantidad maxima actual a variable
        if (result) {
            let id = `oferta_${idOferta}`
            if (jsonOferta[id]['unica'] == 1) {
                //valido si la cantidad es por cada producto en la lista o solo por la oferta
                if (jsonOferta[id]['productoOrlista'] == 1) {// cantidad por cada producto en la oferta
                    //consigo la canstidad de productos
                    let totalCodigos = jsonOferta[id]['productosID'].length
                    //agrego a la cantidad maxima la cantidad por oferta X cantidad de productos
                    jsonOferta[id]['cantidadMaximaActual'] = (parseInt(jsonOferta[id].cantidad) * totalCodigos)
                } else if (jsonOferta[id]['productoOrlista'] == 2) { // solo por oferta
                    //actualizo la cantidad maxima suamandole el valor de la cantidad de oferta
                    jsonOferta[id]['cantidadMaximaActual'] = parseInt(jsonOferta[id].cantidad)
                }

                localStorage.setItem('ofertas', JSON.stringify(jsonOferta))
            } else {//si pueden repertirse la misma oferta
                //valido si la cantidad es por cada producto en la lista o solo por la oferta
                if (jsonOferta[id]['productoOrlista'] == 1) {
                    //consigo la canstidad de productos
                    let totalCodigos = jsonOferta[id]['productosID'].length
                    //agrego a la cantidad maxima la cantidad por oferta X cantidad de productos
                    jsonOferta[id]['cantidadMaximaActual'] = (parseInt(jsonOferta[id].cantidad) * totalCodigos) * parseInt(cant)
                } else if (jsonOferta[id]['productoOrlista'] == 2) { // solo por oferta
                    //actualizo la cantidad maxima suamandole el valor de la cantidad de oferta
                    jsonOferta[id]['cantidadMaximaActual'] = parseInt(jsonOferta[id].cantidad) * parseInt(cant)
                }

                localStorage.setItem('ofertas', JSON.stringify(jsonOferta))
            }
        }





    } else {
        let row_delete = document.getElementById(idRowDelete)
        let jsonOferta = localStorage.getItem('ofertas')
        // se parsea
        jsonOferta = JSON.parse(jsonOferta)
        let id = `oferta_${idOferta}`
        if ((row_delete.dataset.hasoferta == 1) && (id != "oferta_undefined")) {
            jsonOferta[id]['cantidadUsadaActual'] = parseInt(jsonOferta[id]['cantidadUsadaActual']) - 1
            localStorage.setItem('ofertas', JSON.stringify(jsonOferta))
            return
        }
        if (id != "oferta_undefined") {
            //si existe alguna oferta registrada agrego verifico si ya existe y si se puede stackear  

            jsonOferta.id.map((e, i) => {
                if (e == idOferta) {
                    jsonOferta.id.splice(i, 1);
                }
            })
            delete jsonOferta[id]
            localStorage.setItem('ofertas', JSON.stringify(jsonOferta))
        }
    }
}


async function getOferta(id) {
    try {
        let formData = new FormData()
        formData.append("idOferta", id)
        let data = await fetch("/admin/ofertas/getofertasbyid", {
            method: "POST",
            body: formData
        })
        let oferta = await data.json()
        if (oferta.estado && oferta.error == '00000') {
            return oferta.data
        } else {
            return false
        }

    } catch (error) {
        console.log(error)
        return false
    }
}

function ConvertLabelFormat(amountValue) {
    let valor = amountValue;
    valor = valor
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    return valor
}

function roundHundred(value, rd1, rd2) {
    // return Math.round(value / rd1) * rd2
    return value
}
$("#bodyContent").on("click", ".removeItemProductBtn", function (e) {

    removeItemProduct(e.target.dataset.id, e.target.dataset.oferta, e.target.dataset.rand)
})

function removeItemProduct(id, idOferta, rand) {

    updateOferta(idOferta, true, 0, `itemRowProduct_${id}_${rand}`)
    $(`#itemRowProduct_${id}_${rand}`).remove()
    getSubTotalAndTotal()
}
//total
function getSubTotalAndTotal() {
    let monto_envio = document.getElementById('precioEnvio').value
    let inputFacSaldoNow = document.getElementById('inputFacSaldoNow').value
    let inputFacNewSaldoNow = document.getElementById('inputFacNewSaldoNow')
    let total = parseFloat(monto_envio)
    let cantRow = 0
    $(".productRowFac .productRowFac_total").each((i, element) => {
        let amount = $(element).text()
        total += parseFloat(amount)
        cantRow++
    })
    $("#CantidadFooterFact").text(`Cantidad de Lineas: ${cantRow}`)
    let saldo = parseFloat(inputFacSaldoNow)
    let totalLessSaldo = 0
    let saldoUsed = 0
    if (localStorage.saldo != 'false' && localStorage.saldo != undefined) {
        if (saldo < total) {
            totalLessSaldo = total - saldo
            saldoUsed = saldo
            inputFacNewSaldoNow.value = '0.00'
        } else if (saldo > total) {
            totalLessSaldo = 0
            saldoUsed = parseFloat((saldo - (saldo - total)))
            inputFacNewSaldoNow.value = parseFloat(saldo - total).toFixed(2)
        }
    }
    let numRound = roundHundred(total, 5, 5)
    let newFormat = ConvertLabelFormat(numRound)
    //console.log(newFormat)
    $("#totalFactAmount").text(newFormat)
    $("#totalFactAmount").attr("data-amount", newFormat)

    if (localStorage.saldo != 'false' && localStorage.saldo != undefined) {
        let numRoundSaldo = roundHundred(totalLessSaldo, 5, 5)
        let newFormatSaldo = ConvertLabelFormat(numRoundSaldo)
        let saldoData = localStorage.saldo
        //console.log(saldoData)
        saldoData = saldoUsed
        //console.log(saldoData)
        localStorage.saldo = parseFloat(saldoData).toFixed(2)
        $("#totalFactAmount").attr("data-amountsaldo", newFormatSaldo)
        $(".lbMontoToPay").val(newFormatSaldo)
        $("#amountModalTitle").text(newFormatSaldo)
    } else {

        $(".lbMontoToPay").val(newFormat)
        $("#amountModalTitle").text(newFormat)
    }
}

function calcTotalRowPrice(precio, descuento, iva) {
    let descuentoPorcent = parseFloat(descuento / 100)
    let ivaPorcent = parseFloat(iva / 100)
    let precioVentaSub = parseFloat(precio - parseFloat(precio * descuentoPorcent))
    let TotaliVa = 0
    if (iva == 0) {
        TotaliVa = parseFloat(precioVentaSub)
    } else {

        TotaliVa = parseFloat(precioVentaSub + parseFloat(precioVentaSub * ivaPorcent))
    }

    return [precioVentaSub.toFixed(2), TotaliVa.toFixed(2)]
}

function RefreshCalcTotalRowPrice(tds, sum) {
    let cant = $(tds[4]).children().val()
    let total = parseInt(cant) + parseInt(sum)
    let precio = parseFloat($(tds[6]).text())
    let descuento = tds[7].dataset.descuento
    let descuento_porcentaje = 0
    let monto_reducir = 0
    let totalAll = 0
    if (descuento > 0) {
        descuento_porcentaje = parseFloat(descuento / 100)
    }
    monto_reducir = parseFloat(precio) * parseFloat(descuento_porcentaje)
    precio -= monto_reducir
    totalAll = parseFloat(precio) * parseInt(total)



    $(tds[4]).children('input').val(total)
    $(tds[8]).text(totalAll.toFixed(2))
    let ivaPercent = (parseInt($(tds[3]).text()) == 0 ? 1 : parseInt($(tds[3]).text()))
    if (ivaPercent > 0) {
        let iva = parseInt(ivaPercent) / 100
        let iva_sum = parseFloat(totalAll * iva)
        if (ivaPercent == 1) {
            iva = 1
            iva_sum = 0
        }
        let newTotal = parseFloat(totalAll + iva_sum)
        $(tds[9]).text(newTotal.toFixed(2))
    }
    updateOferta(tds[4].dataset.oferta, false, (parseInt(cant) + parseInt(sum)))
}

function existProductRow(toSearch) {
    let body2 = document.getElementById('appendItemRowProduct')
    let children;
    let stop = false;
    if (body2.children.length > 0) {
        for (let item of body2.children) {
            let inner = item.children[0].innerText

            if (toSearch == inner) {
                if (item.children[0].dataset.oferta == 1) {
                    stop = true
                } else {

                    children = item.children
                    stop = false
                }
            } else {
                stop = true
            }
        }
        return stop ? true : children
    } else {
        return true

    }
}
/**
 * *************************************************************************************
 * *************************************************************************************
 */

$('#bodyContent').on("change", "#descuentosSelect", function (e) {
    let descuento = this.value
    let tds = document.getElementsByClassName('tdNotDiscount')
    let trs = document.getElementsByClassName('trNotDiscount')
    for (td of tds) {
        td.dataset.descuento = descuento
        td.textContent = descuento + '%'
    }
    for (tr of trs) {
        RefreshCalcTotalRowPrice($(tr).children(), 0)
    }
    getSubTotalAndTotal()

})
$('#bodyContent').on("change", "#canDiscountFac", function (e) {
    let descuentos = document.getElementById('descuentosSelect')
    let tds = document.getElementsByClassName('tdNotDiscount')
    let trs = document.getElementsByClassName('trNotDiscount')
    if (this.checked) {
        descuentos.disabled = false
    } else {
        descuentos.disabled = true
        for (td of tds) {
            td.dataset.descuento = 0
            td.textContent = 'N/A'
        }
        descuentos.options[0].selected = true
        for (tr of trs) {
            RefreshCalcTotalRowPrice($(tr).children(), 0)
        }
        getSubTotalAndTotal()
    }

})
$('#bodyContent').on("keypress", "#SearchProductInputCtrlQ", function (e) {
    if (e.charCode == 13) {
        SearchProductModalFact(this.value, 1)

    }

})
$('#bodyContent').on("click", "#SearchProductInputCtrlQBtn", function (e) {
    SearchProductModalFact("", 1)

})
$('#bodyContent').on("click", "#paginationModal .paginationBtn", function (e) {
    let valueInput = document.getElementById('SearchProductInputCtrlQ').value
    SearchProductModalFact(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", "#paginationModalCliente .paginationBtn", function (e) {
    let valueInput = document.getElementById('SearchClient_input').value
    searchClient(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", "#paginationModal .pre_nex", function (e) {
    let valueInput = document.getElementById('SearchProductInputCtrlQ').value

    SearchProductModalFact(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", "#paginationModalCliente .pre_nexCliente", function (e) {
    let valueInput = document.getElementById('SearchClient_input').value

    searchClient(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", ".codeToAddInputSearch", function (e) {
    $("#bodyContent #ScanCode").val("")
    $("#bodyContent #ScanCode").val(this.innerText)
    $("#SearchProductModal").modal('toggle')

    let element = document.getElementById('ScanCode')
    let toSearch = document.getElementById('ScanCode').value
    element.focus();
    element.setSelectionRange(0, toSearch.length);



})
$('#bodyContent').on("click", ".codeToAddInputSearchCard", function (e) {
    let codigo = this.dataset.codebar

    $("#bodyContent #ScanCode").val(codigo)
    $("#SearchProductModal").modal('toggle')
    let element = document.getElementById('ScanCode')
    let toSearch = document.getElementById('ScanCode').value
    element.focus();
    element.setSelectionRange(0, toSearch.length);



})
$('#bodyContent').on("click", ".codeToAddInputSearchClient", function (e) {
    let id = e.target.dataset.id
    let name = e.target.dataset.name
    let inputCliente = document.getElementById("fac_cliente_input")
    let idclienteFacCambio = document.getElementById('idclienteFacCambio')
    inputCliente.value = name
    inputCliente.dataset.cliente = id
    // idclienteFacCambio.dataset.cliente = id
    // idclienteFacCambio.value = name

    $("#SearchClientModal").modal('toggle')



})
$('#bodyContent').on("click", "#fac_cliente", function (e) {
    clearBodySearchClient()
})
$('#bodyContent').on("blur", "#precioEnvio", function (e) {
    getSubTotalAndTotal()
})

$('#bodyContent').on("click", "#resetSaldostatus", function (e) {
    let inputSearchFacSaldo = document.getElementById('inputSearchFacSaldo')
    inputSearchFacSaldo.value = ''
    getSubTotalAndTotal()
    localStorage.removeItem('saldo')
    $(".hiddenSaldosInput").css({
        display: 'none'
    })
})

function clearBodySearchClient() {
    $('#contentSearchClient').html('')
    $('#paginationModalCliente').html('')
}
$('#bodyContent').on("keypress", "#inputSearchFacSaldo", function (e) {
    if (e.key == "Enter") {
        let regex = '^[+]?([0-9]+(?:[0-9]*)?|[0-9]+)$'
        let fac = this.value
        let resultRegex = fac.match(regex)
        if (resultRegex) {
            saldoDevoluciones(this.value);
        } else {
            localStorage.setItem('saldo', 'false')
            $(".hiddenSaldosInput").css({
                display: 'none'
            })
            getSubTotalAndTotal()
            Swal.fire({
                position: 'top',
                title: `Formato de factura incorrecto`,
                text: `Por favor ingresa un formato numérico`,
                icon: 'error',
                confirmButtonText: 'OK'
            })
        }
    }

})
//saldo
function saldoDevoluciones(fac) {
    let formData = new FormData()
    formData.append("fac", fac)
    fetch("/facturacion/consultar/saldo", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            console.table(resp)

            if (resp.error == "00000") {
                // loadPage(null, "/facturacion/cajas")
                if (!resp.data) {
                    $(".hiddenSaldosInput").css({
                        display: 'none'
                    })
                    localStorage.setItem('saldo', 'false')
                    getSubTotalAndTotal()
                    Swal.fire({
                        position: 'top',
                        title: `Sin saldo`,
                        text: `No se encuentra saldo pendiente relacionado a la factura #${fac}`,
                        confirmButtonText: 'OK'
                    })
                } else {
                    $(".hiddenSaldosInput").css({
                        display: 'block'
                    })
                    let inputFacSaldoNow = document.getElementById('inputFacSaldoNow')
                    let inputFacNewSaldoNow = document.getElementById('inputFacNewSaldoNow')
                    inputFacSaldoNow.value = resp.data.Saldo
                    inputFacNewSaldoNow.value = parseFloat(resp.data.Saldo)
                    localStorage.setItem('saldo', resp.data.Saldo)
                    getSubTotalAndTotal()
                    Swal.fire({
                        position: 'top',
                        title: `Saldo ₡${resp.data.Saldo}`,
                        text: `Fecha maxima para usar: ${resp.data.fechaMaxReclamo}`,
                        confirmButtonText: 'OK'
                    })
                }
            }
        })
}

function SearchProductModalFact(toSearch, page) {
    let formData = new FormData()
    let initLimit = page

    formData.append("toSearch", toSearch)
    formData.append("initLimit", initLimit)
    fetch("/facturacion/search/product/ctrlq", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            $('#contentSearchFac').html('')
            let paginacion = resp.paginacion
            let items = `<li class="page-item pre_nex ${resp.previouspage <= 0 ? 'disabled' : ''}" data-minpage="1" data-page="${resp.previouspage <= 0 ? 1 : resp.previouspage}"><p class="page-link">Previous</p></li>`
            for (let index = 0; index < paginacion.paginas; index++) {
                let pageNow = index + 1
                items += `<li class="page-item paginationBtn ${pageNow == page ? 'active' : ''}" data-page="${index + 1}"><a class="page-link" href="#">${index + 1}</a></li>`

            }
            items += `<li class="page-item pre_nex ${resp.nextpage > paginacion.paginas ? 'disabled' : ''}" data-maxpage="${paginacion.paginas}" data-page="${resp.nextpage >= paginacion.paginas ? paginacion.paginas : resp.nextpage}"><p class="page-link">Next</p></li>`

            resp.data.map((el, i) => {
                let url = el.image_url.split(',')
                let producto = `    <div class="col-6 ">
                                        <div class="card mb-3 codeToAddInputSearchCard" style="width: 100%;" data-codebar="${el.codigo}">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 cardImgBody">
                                            <img src="${(url[0] == "" ? "/public/assets/img/not-found.png" : url[0])}" class="card-img" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                            <div class="card-body">
                                                <h6 class="card-title">${el.descripcion}</h6>
                                                <p class="${el.precio_venta < 1 ? "text-danger" : ""}">₡ ${el.precio_venta} |  Stock:${el.stock} </p>
                                                <span class="icon_codeToAddInputSearch"><span class="codeToAddInputSearch">${el.codigo}</span></span>
                                                </br>
                                                <span class=""><small class="text-muted">${(el.iva > 0 ? "<strong>IVA: </strong>" + el.iva + "%" : "")}${(el.descuento > 0 ? " | <strong>Descuento: </strong>" + el.descuento + "%" : "")}</small></span>
                                                </br>
                                                <span class=""><small class="text-muted">Marca: ${el.marca} | Categoria: ${el.categoria} | Talla: ${el.talla}</small></span>
                                                <p class=""><small class="text-muted">Estado: ${(el.estado == 1 ? "Activo" : "Inactivo")}</small></p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>                                
                                    </div>                                
              `

                $('#contentSearchFac').append(producto)
            })
            $('#paginationModal').html('')
            $('#paginationModal').html(items)
        })
}
$('#bodyContent').on("click", "#callModalAddClient", function (e) {
    $('#SearchClientModal').modal('hide')
    $('#clientes_addCliente').modal('toggle')
})
$('#bodyContent').on("keypress", "#SearchClient_input", function (e) {
    if (e.charCode == 13) {
        searchClient(this.value, 1);
    }

})
$('#bodyContent').on("click", "#SearchClient_inputBtn", function (e) {

    searchClient('', 1);

})

function searchClient(toSearch, page) {
    let formData = new FormData()
    let initLimit = page

    formData.append("toSearch", toSearch)
    formData.append("initLimit", initLimit)
    fetch("/clientes/search/searchclient", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            $('#contentSearchClient').html('')
            let paginacion = resp.paginacion
            let items = `<li class="page-item pre_nexCliente ${resp.previouspage <= 0 ? 'disabled' : ''}" data-minpage="1" data-page="${resp.previouspage <= 0 ? 1 : resp.previouspage}"><p class="page-link">Previous</p></li>`
            for (let index = 0; index < paginacion.paginas; index++) {
                let pageNow = index + 1
                items += `<li class="page-item paginationBtn ${pageNow == page ? 'active' : ''}" data-page="${index + 1}"><a class="page-link" href="#">${index + 1}</a></li>`

            }
            items += `<li class="page-item pre_nexCliente ${resp.nextpage > paginacion.paginas ? 'disabled' : ''}" data-maxpage="${paginacion.paginas}" data-page="${resp.nextpage >= paginacion.paginas ? paginacion.paginas : resp.nextpage}"><p class="page-link">Next</p></li>`

            resp.data.map((el, i) => {
                let cliente = `    <div class="col-6">
                                        <div class="card mb-2 codeToAddInputSearchClientCard" style="width: 100%;">
                                        <div class="row no-gutters">                                           
                                            <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <div class="icon_codeToAddInputSearch"><p class="card-text codeToAddInputSearchClient" data-name="${el.nombre}"  data-id="${el.idcliente}">${el.nombre}</p></div>
                                                </h5>
                                                <p class="card-text">${el.email}</p>
                                                <p class="card-text"><strong>Tel: </strong> ${el.telefono}</p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>                                
                                    </div>                                
              `

                $('#contentSearchClient').append(cliente)
            })
            $('#paginationModalCliente').html('')
            $('#paginationModalCliente').html(items)
        })

}

$('#bodyContent').on("click", "#btnAbrirCaja", function (e) {
    abrirCaja();
})

function abrirCaja() {
    let form = document.getElementById("cajas_form_addcaja")
    let formData = new FormData(form)
    let cb = document.getElementById("cbSelectuser")
    let monto = parseInt(document.getElementById("cajas_monto").value)
    let user = parseInt(cb.options[cb.selectedIndex].value)
    if (user !== 0 && !isNaN(monto)) {
        fetch("/facturacion/cajas/abrirCaja", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
            .then(resp => {


                if (resp.error == "00000") {
                    $("#cajas_addcaja").modal("toggle")
                    form.reset()
                    loadPage(null, "/facturacion/cajas")
                    Swal.fire({
                        position: 'top',
                        title: `Se creo caja Correctamente`,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 2500,
                        timerProgressBar: true
                    })


                }
            })
    } else {
        alert('Debe rellenar los campos con la informacion correcta')
    }
}
$('#bodyContent').on("click", ".btnAbrirCajaEstado", function (e) {
    let id = this.dataset.caja
    AbrirCajaEstado(id);
})
$('#bodyContent').on("click", ".btnCerrarCajaEstado", function (e) {
    let id = this.dataset.caja
    let monto = this.dataset.monto
    btnCerrarCajaEstado(id, monto);
})

function AbrirCajaEstado(id) {
    let formData = new FormData()
    formData.append("idcaja", id)
    fetch("/facturacion/cajas/abrirCajaEstado", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {


            if (resp.error == "00000") {
                loadPage(null, "/facturacion/cajas")
                Swal.fire({
                    position: 'top',
                    title: `Caja Abierta`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })


            }
        })
}

function btnCerrarCajaEstado(id, monto) {
    let formData = new FormData()
    formData.append("idcaja", id)
    fetch("/facturacion/cajas/obtenerEstadoCajaEstado", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            //console.log(resp);

            if (resp.error == "00000") {

                let data = resp.data
                let btncerrarCajaFinal = document.getElementById('btncerrarCajaFinal')
                let total = resp.tarjeta + resp.efectivo + resp.transferencia + parseFloat(monto)
                let caja_total_facturado = document.getElementById("caja_total_facturado")
                caja_total_facturado.value = resp.tarjeta + resp.efectivo + resp.transferencia
                let montos = `
                <div class="alert alert-primary d-flex justify-content-between" role="alert">
                <span>Caja Base:</span> <span>${monto}</span>
                </div>
                <div class="alert alert-success d-flex justify-content-between" role="alert">
                <span>Efectivo:</span> <span>${(resp.efectivo.toFixed(2) == null ? '0.00' : resp.efectivo.toFixed(2))}</span>
                </div>
                <div class="alert alert-success d-flex justify-content-between" role="alert">
                <span>Tarjetas:</span> <span>${(resp.tarjeta.toFixed(2) == null ? '0.00' : resp.tarjeta.toFixed(2))}</span>
                </div>
                <div class="alert alert-success d-flex justify-content-between" role="alert">
                <span>Transferencias:</span> <span>${(resp.transferencia.toFixed(2) == null ? '0.00' : resp.transferencia.toFixed(2))}</span>
                </div>
                <div class="alert alert-info d-flex justify-content-between" id="caja_totalsystem" data-total="${total.toFixed(2)}" role="alert">
                <span><strong>Total:</span> <span>${total.toFixed(2)}</strong></span>
                </div>
                
                `
                btncerrarCajaFinal.dataset.id = id
                $("#montosCajaCerrar").html(montos)
            }
        })
}
$('#bodyContent').on("blur", ".caja_blur", function (e) {
    if (this.value == '') {
        this.value = 0
    }
    let efectivo = document.getElementById('caja_efectivo').value
    let tarjeta = document.getElementById('caja_tarjeta').value
    let transferencia = document.getElementById('caja_transferencia').value
    let total = document.getElementById('caja_total')
    let totalsystem = document.getElementById('caja_totalsystem').dataset.total
    let diferencia = document.getElementById('caja_diferencia')
    let inputDiff = document.getElementById('inputDiff')
    let suma = (parseFloat(efectivo) + parseFloat(tarjeta) + parseFloat(transferencia))
    total.innerHTML = suma.toFixed(2)
    diferencia.innerHTML = (suma - totalsystem).toFixed(2)
    inputDiff.value = (suma - totalsystem).toFixed(2)
    //console.log(total);

})
$('#bodyContent').on("blur", ".abonoMontosModal", function (e) {
    if (this.value == '') this.value = 0.00
    e.preventDefault();
    this.value = parseFloat(this.value.replace(/,/g, ""))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //document.getElementById("display").value = this.value.replace(/,/g, "")
})
$('#bodyContent').on("change", "#ckAbonoSw", function (e) {
    if (this.checked) {
        let cliente = document.getElementById("fac_cliente_input")
        getApartadosHasClient(cliente.dataset.cliente)
        apartadosWrapper.style.display = "flex"

    } else {
        apartadosWrapper.style.display = "none"
    }

})
$('#bodyContent').on("click", "#btnMakeAbono", function (e) {
    if (this.dataset.factura !== "0") {
        let abonoSaldoData = document.getElementById("abonoSaldoData")
        let facturaTitleAbono = document.getElementById("facturaTitleAbono")
        let idfactura = document.getElementById("idfactura")
        let fecha_final = this.dataset.fechaFinal
        let fecha_incio = this.dataset.fechaIncio
        facturaTitleAbono.innerText = "Factura#: " + this.dataset.factura
        idfactura.value = parseInt(this.dataset.factura)
        abonoSaldoData.innerHTML = `<strong>Total factura: </strong> ₡${this.dataset.total} | <strong>Total Abonado: </strong> ₡${this.dataset.abono} | <strong>Saldo Pendiente: </strong> ₡${this.dataset.saldo}<br><strong>Fecha Inicio: </strong> ${fecha_incio} | <strong>Fecha Final: </strong> ${fecha_final}`
        $("#apartados_abonar").modal('toggle')
        getProductFacAbono(this.dataset.factura)
    }

})
$('#bodyContent').on("change", "#apartadosSelect", function (e) {
    let apartado = this
    let btnMakeAbono = document.getElementById("btnMakeAbono")

    btnMakeAbono.dataset.factura = apartado.options[apartado.selectedIndex].value
    btnMakeAbono.dataset.abono = apartado.options[apartado.selectedIndex].dataset.abono
    btnMakeAbono.dataset.total = apartado.options[apartado.selectedIndex].dataset.total
    btnMakeAbono.dataset.saldo = apartado.options[apartado.selectedIndex].dataset.saldo
    btnMakeAbono.dataset.fechaFinal = apartado.options[apartado.selectedIndex].dataset.fechaFinal
    btnMakeAbono.dataset.fechaIncio = apartado.options[apartado.selectedIndex].dataset.fechaIncio


})

function formatDate(date) {
    //2020-12-08 16:16:54
    let arrayDate = date.split(' ')[0].split('-')
    let newDate = arrayDate[2] + "-" + arrayDate[1] + "-" + arrayDate[0]
    return newDate
}

function getApartadosHasClient(id) {
    let formData = new FormData()
    formData.append("cliente", id)
    fetch("/facturacion/apartados/getApartadosHasClient", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {

            if (resp.error == "00000") {
                let apartado = resp.data
                let apartadosSelect = document.getElementById('apartadosSelect')
                apartadosSelect.textContent = ''
                if (apartado !== []) {
                    let opt = document.createElement('option');
                    opt.appendChild(document.createTextNode(`Seleccione un apartado`));
                    opt.value = 0;
                    opt.disabled = true
                    opt.selected = true
                    apartadosSelect.appendChild(opt);
                }


                apartado.map(item => {
                    let opt = document.createElement('option');
                    let saldo = parseFloat(item.total) - parseFloat(item.abonado)
                    opt.appendChild(document.createTextNode(`Fac# ${item.consecutivo} (Saldo: ${saldo.toFixed(2)}) (Total:${item.total})`));
                    opt.value = item.consecutivo;
                    opt.dataset.saldo = saldo.toFixed(2);
                    opt.dataset.abono = item.abonado;
                    opt.dataset.total = item.total;
                    opt.dataset.fechaIncio = item.fecha;
                    opt.dataset.fechaFinal = item.fecha_final;
                    apartadosSelect.appendChild(opt);
                })
            }
        })
}

function getProductFacAbono(id) {
    let formData = new FormData()
    formData.append("fac", id)
    $("#productosListAbono").html('')
    fetch("/facturacion/apartados/getProductsFromApartado", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            if (resp.error == "00000") {

                let products = resp.data

                products.map(item => {
                    let iva = parseInt(item.iva)
                    $("#productosListAbono").append(`<li  class="list-group-item">${item.descripcion_short.toUpperCase()} | <strong class="text-primary">Precio:</strong> ${item.precio} ${iva > 0 ? ` | <strong class="text-primary">IVA:</strong> ${item.iva}` : ''} | <strong class="text-primary">Cant:</strong> ${item.cantidad} | <strong class="text-primary">Total:</strong> ${item.total}</li>`)
                })
            }
        })
}
$('#bodyContent').on("click", "#btnAbonarPrint", function (e) {
    setAbono()
})
$('#bodyContent').on("click", ".productosPendienteBtn", function (e) {
    productosPendienteBtn(parseInt(this.dataset.id))
})
$('#bodyContent').on("click", ".facturaChangeState", function (e) {
    facturaChangeState(parseInt(this.dataset.id))
})
$('#bodyContent').on("click", "#btncerrarCajaFinal", function (e) {
    cerrarCajaFinal(parseInt(this.dataset.id))
})
$('#bodyContent').on("click", "#BtncancelPendingFac", function (e) {
    let id = this.dataset.id
    let formData = new FormData()
    formData.append('id', id)
    fetch("/facturacion/pendientes/productos", {
        method: "POST",
        body: formData
    }).then(resp => resp.text())
        .then(resp => {
            //console.log(resp);
            let productos = resp
            let wrapper = document.getElementById('productosPendientesRows')
            wrapper.innerHTML = productos
            $("#productosPendientesModal").modal("toggle")
        })
})

function setAbono() {
    let form = document.getElementById('apartados_form_abonar')
    let InputVendedorFact = document.getElementById('InputVendedorFact').value
    let fac_cliente_input = document.getElementById('fac_cliente_input').value
    let bancoAbono = document.getElementById('bancoAbono')
    let banco = bancoAbono.options[bancoAbono.selectedIndex].textContent
    let formData = new FormData(form)
    banco = banco == 'Seleccione' ? '' : banco
    let extras = []
    let totalGroup = 0
    let inputRowsTarjeta = document.getElementsByClassName('inputRowsTarjeta2')
    let stringCards = ''
    for (tarjeta of inputRowsTarjeta) {
        //console.log("Rows value", tarjeta.value);
        let montoId = `tarjetaMonto_${tarjeta.dataset.id}`
        let monto = document.getElementById(montoId).value
        let withOutFormatMonto = parseFloat(monto.replace(",", "")).toFixed(2)
        totalGroup = (totalGroup + parseFloat(withOutFormatMonto))
        stringCards += tarjeta.value + ',' + parseFloat(withOutFormatMonto) + ",tarjeta;"
    }


    formData.append('vendedor', InputVendedorFact)
    formData.append('cliente', fac_cliente_input)
    formData.append('banco', banco)
    formData.append('cards', stringCards)
    formData.append('totalCards', totalGroup)
    fetch("/facturacion/apartados/setAbono", {
        method: "POST",
        body: formData
    }).then(resp => resp.text())
        .then(resp => {
            let h = resp;
            let d = $("<div>").addClass("printContainer").html(h).appendTo("html");
            window.print();
            d.remove();
            resetFactScreen()

        })
}

function productosPendienteBtn(id) {

    let formData = new FormData()
    formData.append('id', id)
    fetch("/facturacion/pendientes/productos", {
        method: "POST",
        body: formData
    }).then(resp => resp.text())
        .then(resp => {
            let productos = resp
            let wrapper = document.getElementById('productosPendientesRows')
            wrapper.innerHTML = productos
            $("#productosPendientesModal").modal("toggle")
        })

}

function facturaChangeState(id) {

    let formData = new FormData()
    formData.append('id', id)
    fetch("/facturacion/pendientes/changeStateFac", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            if (resp.error == '00000')

                loadPage(null, "/facturacion/pendientes")
            alert("Se acutializo el estado de la factura pendiente #" + id)
        })

}

function cerrarCajaFinal(id) {
    let form = document.getElementById('formCerrarCaja')
    let formData = new FormData(form)
    formData.append('id', id)
    fetch("/facturacion/cajas/cerrarcajafinal", {
        method: "POST",
        body: formData
    }).then(resp => resp.json())
        .then(resp => {
            //console.log(resp);
            if (resp.error == "00000") {
                $("#cajas_cerrarCaja").modal('toggle')
                loadPage(null, '/facturacion/cajas')
                Swal.fire({
                    position: 'top',
                    title: `Caja cerrada`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
            } else {
                Swal.fire({
                    position: 'top',
                    title: `Error`,
                    text: resp.error,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
                //console.log(resp);
            }

        }).catch(error => {
            Swal.fire({
                position: 'top',
                title: `Error`,
                text: error,
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 2500,
                timerProgressBar: true
            })
        })

}

$('#bodyContent').on("click", ".btnDeleteRowTarjeta2", function (e) {
    let id = this.dataset.id
    let row = document.getElementById(id)
    row.remove()
})



$('#bodyContent').on("click", "#addNewTarjeta2", function (e) {
    //console.log('CLICK');
    let allMonto = document.getElementsByClassName('tarjertaInputs_monto2')[0]
    let d = new Date();
    let n = d.getSeconds();
    let letras = ['a', 'b', 'c', 'd']
    let randID = letras[Math.floor(Math.random() * 4)] + Math.floor(Math.random() * 100) + n;
    let mainRow = document.createElement('div')
    let inputGroup1 = document.createElement('div')
    let inputGroup2 = document.createElement('div')
    let inputGroup3 = document.createElement('div')
    let prepend1 = document.createElement('div')
    let prepend2 = document.createElement('div')
    let input1 = document.createElement('input')
    let input2 = document.createElement('input')
    let span1 = document.createElement('span')
    let span2 = document.createElement('span')
    let button = document.createElement('button')
    let = document.createElement('div')
    mainRow.classList.add('row', 'rowtarjetas2')
    mainRow.id = randID

    // *****GROUP 1*****/
    inputGroup1.classList.add('input-group', 'mb-3', 'mt-3', 'col-lg-5', 'col-md-5', 'col-sm-11')
    prepend1.classList.add('input-group-prepend')
    input1.classList.add('form-control', 'tarjertaInputs_tarjeta2', 'inputRowsTarjeta2')
    input1.type = 'text'
    input1.maxLength = 4
    input1.placeholder = 'Ultimos 4 Digitos'
    input1.dataset.id = randID
    span1.classList.add('input-group-text')


    span1.textContent = '# Tarjeta'
    prepend1.appendChild(span1)
    inputGroup1.appendChild(prepend1)
    inputGroup1.appendChild(input1)
    // *****GROUP 2*****/
    inputGroup2.classList.add('input-group', 'mb-3', 'mt-3', 'col-lg-6', 'col-md-6', 'col-sm-12')
    prepend2.classList.add('input-group-prepend')
    input2.classList.add('form-control', 'tarjertaInputs_monto2', 'inputRowsTarjetaMonto2', 'lbMontoToPay')
    input2.value = '0.00'
    input2.id = 'tarjetaMonto_' + randID
    input2.type = 'text'
    input2.placeholder = 'Ultimos 4 Digitos'
    span2.classList.add('input-group-text')

    span2.textContent = 'Monto'
    prepend2.appendChild(span2)
    inputGroup2.appendChild(prepend2)
    inputGroup2.appendChild(input2)

    // *****BTN*****/
    inputGroup3.classList.add('input-group', 'mb-3', 'mt-3', 'col-lg-1', 'col-md-1', 'col-sm-1')
    button.textContent = 'X'
    button.dataset.id = randID
    button.classList.add('btn', 'btn-danger', 'btnDeleteRowTarjeta2')

    inputGroup3.appendChild(button)
    mainRow.appendChild(inputGroup1)
    mainRow.appendChild(inputGroup2)
    mainRow.appendChild(inputGroup3)
    let addrowtarjeta = document.getElementById('addrowtarjeta2')
    addrowtarjeta.appendChild(mainRow)

})



/**
 * *************************************************************************************
 * ***************************REPORTES**********************************************************
 */

$('#bodyContent').on("change", "#reportTypeSelect", function (e) {
    let reportTypeSelect = document.getElementById('reportTypeSelect')
    //console.log(reportTypeSelect.selectedOptions[0].value);
})